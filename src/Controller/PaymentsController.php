<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$where = [];
		$vouch_no = $this->request->query('vouch_no');
		$From = $this->request->query('From');
		$To = $this->request->query('To');
		
		$this->set(compact('vouch_no','From','To'));
		
		if(!empty($vouch_no)){
			$where['Payments.voucher_no LIKE']=$vouch_no;
		}
		
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['Payments.transaction_date >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['Payments.transaction_date <=']=$To;
		}
		
		
		
        $this->paginate = [
            'contain' => []
        ];
		
		
		$payments = $this->paginate($this->Payments->find()->where($where)->where(['company_id'=>$st_company_id])->contain(['PaymentRows'=>function($q){
			$PaymentRows = $this->Payments->PaymentRows->find();
			$totalCrCase = $PaymentRows->newExpr()
				->addCase(
					$PaymentRows->newExpr()->add(['cr_dr' => 'Cr']),
					$PaymentRows->newExpr()->add(['amount']),
					'integer'
				);
			$totalDrCase = $PaymentRows->newExpr()
				->addCase(
					$PaymentRows->newExpr()->add(['cr_dr' => 'Dr']),
					$PaymentRows->newExpr()->add(['amount']),
					'integer'
				);
			return $PaymentRows->select([
					'total_cr' => $PaymentRows->func()->sum($totalCrCase),
					'total_dr' => $PaymentRows->func()->sum($totalDrCase)
				])
				->group('payment_id')
				
				->autoFields(true);
			
		}])->order(['voucher_no'=>'DESC']));
		

        $this->set(compact('payments'));
        $this->set('_serialize', ['payments']);
    }

    /**
     * View method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $payment = $this->Payments->get($id, [
            'contain' => ['BankCashes', 'Companies', 'PaymentRows' => ['ReceivedFroms'], 'Creator']
        ]);
		
		$ref_details=[];
		foreach($payment->payment_rows as $payment_row){
			$ReferenceDetails=$this->Payments->ReferenceDetails->find()->where(['ledger_account_id'=>$payment_row->received_from_id,'payment_id'=>$payment->id]);
			$ref_details[$payment_row->received_from_id]=$ReferenceDetails->toArray();
		}
		
		//pr($ref_details); exit;						
		
		$this->set(compact('ref_details'));
        $this->set('payment', $payment);
        $this->set('_serialize', ['payment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
		
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->Payments->FinancialYears->find()->where(['id'=>$st_year_id])->first();


		   $SessionCheckDate = $this->FinancialYears->get($st_year_id);
		   $fromdate1 = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
		   $todate1 = date("Y-m-d",strtotime($SessionCheckDate->date_to)); 
		   $tody1 = date("Y-m-d");

		   $fromdate = strtotime($fromdate1);
		   $todate = strtotime($todate1); 
	       $tody = strtotime($tody1);

		  if($fromdate < $tody || $todate > $tody)
		   {
			 if($SessionCheckDate['status'] == 'Open')
			 { $chkdate = 'Found'; }
			 else
			 { $chkdate = 'Not Found'; }

		   }
		   else
			{
				$chkdate = 'Not Found';	
			}
	
		
        $payment = $this->Payments->newEntity();
		
        if ($this->request->is('post')) {
            $payment = $this->Payments->patchEntity($payment, $this->request->data);
			$payment->company_id=$st_company_id;
			//Voucher Number Increment
			$last_voucher_no=$this->Payments->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_voucher_no){
				$payment->voucher_no=$last_voucher_no->voucher_no+1;
			}else{
				$payment->voucher_no=1;
			}
			
			$payment->created_on=date("Y-m-d");
			$payment->created_by=$s_employee_id;
			$payment->transaction_date=date("Y-m-d",strtotime($payment->transaction_date));
			//pr($payment); exit;
            if ($this->Payments->save($payment)) {
				$total_cr=0; $total_dr=0;
				foreach($payment->payment_rows as $payment_row){
					
					//Ledger posting for Received From Entity
					$ledger = $this->Payments->Ledgers->newEntity();
					$ledger->company_id=$st_company_id;
					$ledger->ledger_account_id = $payment_row->received_from_id;
					if($payment_row->cr_dr=="Dr"){
						$ledger->debit = $payment_row->amount;
						$ledger->credit = 0;
						$total_dr=$total_dr+$payment_row->amount;
					}else{
						$ledger->debit = 0;
						$ledger->credit = $payment_row->amount;
						$total_cr=$total_cr+$payment_row->amount;
					}
					
					$ledger->voucher_id = $payment->id;
					$ledger->voucher_source = 'Payment Voucher';
					$ledger->transaction_date = $payment->transaction_date;
					$this->Payments->Ledgers->save($ledger);
					
					$total_amount=$total_dr-$total_cr;
					
					//Reference Number coding
					if(sizeof(@$payment->ref_rows[$payment_row->received_from_id])>0){
						
						foreach($payment->ref_rows[$payment_row->received_from_id] as $ref_row){ 
							$ref_row=(object)$ref_row;
							if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
								$query = $this->Payments->ReferenceBalances->query();
								if($payment_row->cr_dr=="Dr"){
									$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
									->values([
										'ledger_account_id' => $payment_row->received_from_id,
										'reference_no' => $ref_row->ref_no,
										'credit' => 0,
										'debit' => $ref_row->ref_amount
									])
									->execute();
								}else{
									$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
									->values([
										'ledger_account_id' => $payment_row->received_from_id,
										'reference_no' => $ref_row->ref_no,
										'credit' => $ref_row->ref_amount,
										'debit' => 0
									])
									->execute();
								}
								
							}else{
								$ReferenceBalance=$this->Payments->ReferenceBalances->find()->where(['ledger_account_id'=>$payment_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
								$ReferenceBalance=$this->Payments->ReferenceBalances->get($ReferenceBalance->id);
								if($payment_row->cr_dr=="Dr"){
									$ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
								}else{
									$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
								}
								
								$this->Payments->ReferenceBalances->save($ReferenceBalance);
							}
							
							$query = $this->Payments->ReferenceDetails->query();
							if($payment_row->cr_dr=="Dr"){
								$query->insert(['ledger_account_id', 'payment_id', 'reference_no', 'credit', 'debit', 'reference_type'])
								->values([
									'ledger_account_id' => $payment_row->received_from_id,
									'payment_id' => $payment->id,
									'reference_no' => $ref_row->ref_no,
									'credit' => 0,
									'debit' => $ref_row->ref_amount,
									'reference_type' => $ref_row->ref_type
								])
								->execute();
							}else{
								$query->insert(['ledger_account_id', 'payment_id', 'reference_no', 'credit', 'debit', 'reference_type'])
								->values([
									'ledger_account_id' => $payment_row->received_from_id,
									'payment_id' => $payment->id,
									'reference_no' => $ref_row->ref_no,
									'credit' => $ref_row->ref_amount,
									'debit' => 0,
									'reference_type' => $ref_row->ref_type
								])
								->execute();
							}
							
						}
					}
				}
				
				//Ledger posting for bankcash
				$ledger = $this->Payments->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $payment->bank_cash_id;
				$ledger->debit = 0;
				$ledger->credit = $total_amount;
				$ledger->voucher_id = $payment->id;
				$ledger->voucher_source = 'Payment Voucher';
				$ledger->transaction_date = $payment->transaction_date;
				$this->Payments->Ledgers->save($ledger);
				
                $this->Flash->success(__('The payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
            }
        }
        $vr=$this->Payments->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Payment Voucher','sub_entity'=>'Cash/Bank'])->first();
		$ReceiptVouchersCashBank=$vr->id;
		$vouchersReferences = $this->Payments->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		$BankCashes_selected='yes';
		if(sizeof($where)>0){
			$bankCashes = $this->Payments->BankCashes->find('list',
				['keyField' => function ($row) {
					return $row['id'];
				},
				'valueField' => function ($row) {
					if(!empty($row['alias'])){
						return  $row['name'] . ' (' . $row['alias'] . ')';
					}else{
						return $row['name'];
					}
					
				}])->where(['BankCashes.id IN' => $where]);
		}else{
			$BankCashes_selected='no';
		}
		//pr($bankCashes->toArray())	; exit;
		
		$vr=$this->Payments->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Payment Voucher','sub_entity'=>'Paid To'])->first();
		$ReceiptVouchersReceivedFrom=$vr->id;
		$vouchersReferences = $this->Payments->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		$ReceivedFroms_selected='yes';
		if(sizeof($where)>0){
			$receivedFroms = $this->Payments->ReceivedFroms->find('list',
				['keyField' => function ($row) {
					return $row['id'];
				},
				'valueField' => function ($row) {
					if(!empty($row['alias'])){
						return  $row['name'] . ' (' . $row['alias'] . ')';
					}else{
						return $row['name'];
					}
					
				}])->where(['ReceivedFroms.id IN' => $where]);
		}else{
			$ReceivedFroms_selected='no';
		}
        $this->set(compact('payment', 'bankCashes', 'receivedFroms', 'financial_year', 'BankCashes_selected', 'ReceivedFroms_selected','chkdate'));
        $this->set('_serialize', ['payment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->Payments->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		   
		   $SessionCheckDate = $this->FinancialYears->get($st_year_id);
		   $fromdate1 = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
		   $todate1 = date("Y-m-d",strtotime($SessionCheckDate->date_to)); 
		   $tody1 = date("Y-m-d");

		   $fromdate = strtotime($fromdate1);
		   $todate = strtotime($todate1); 
		   $tody = strtotime($tody1);

		  if($fromdate < $tody || $todate > $tody)
		   {
			 if($SessionCheckDate['status'] == 'Open')
			 { $chkdate = 'Found'; }
			 else
			 { $chkdate = 'Not Found'; }

		   }
		   else
			{
				$chkdate = 'Not Found';	
			}

		
        $payment = $this->Payments->get($id, [
            'contain' => ['PaymentRows']
        ]);
		$old_ref_rows=[];
		$old_received_from_ids=[];
		$old_reference_numbers=[];
		
		foreach($payment->payment_rows as $payment_row){
			$ReferenceDetails=$this->Payments->ReferenceDetails->find()->where(['ledger_account_id'=>$payment_row->received_from_id,'payment_id'=>$payment->id]);
			foreach($ReferenceDetails as $ReferenceDetail){
				$old_reference_numbers[$payment_row->received_from_id][]=$ReferenceDetail->reference_no;
			}
			$old_ref_rows[$payment_row->received_from_id]=$ReferenceDetails->toArray();
			$old_received_from_ids[]=$payment_row->received_from_id;
		}
		
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payment = $this->Payments->patchEntity($payment, $this->request->data);
			$payment->company_id=$st_company_id;
			
			
			$payment->edited_on=date("Y-m-d");
			$payment->edited_by=$s_employee_id;
			$payment->transaction_date=date("Y-m-d",strtotime($payment->transaction_date));
				
			//Save receipt
			//pr($payment); exit;
            if ($this->Payments->save($payment)) {
				$this->Payments->Ledgers->deleteAll(['voucher_id' => $payment->id, 'voucher_source' => 'Payment Voucher']);
				$total_cr=0; $total_dr=0;
				foreach($payment->payment_rows as $payment_row){
					
					//Ledger posting for Received From Entity
					$ledger = $this->Payments->Ledgers->newEntity();
					$ledger->company_id=$st_company_id;
					$ledger->ledger_account_id = $payment_row->received_from_id;
					if($payment_row->cr_dr=="Dr"){
						$ledger->debit = $payment_row->amount;
						$ledger->credit = 0;
						$total_dr=$total_dr+$payment_row->amount;
					}else{
						$ledger->debit = 0;
						$ledger->credit = $payment_row->amount;
						$total_cr=$total_cr+$payment_row->amount;
					}
					$ledger->voucher_id = $payment->id;
					$ledger->voucher_source = 'Payment Voucher';
					$ledger->transaction_date = $payment->transaction_date;
					$this->Payments->Ledgers->save($ledger);
					
					$total_amount=$total_dr-$total_cr;
					
					//Reference Number coding
					if(sizeof(@$payment->ref_rows[$payment_row->received_from_id])>0){
						
						foreach($payment->ref_rows[$payment_row->received_from_id] as $ref_row){
							$ref_row=(object)$ref_row;
							$ReferenceDetail=$this->Payments->ReferenceDetails->find()->where(['ledger_account_id'=>$payment_row->received_from_id,'reference_no'=>$ref_row->ref_no,'payment_id'=>$payment->id])->first();
							
							if($ReferenceDetail){
								$ReferenceBalance=$this->Payments->ReferenceBalances->find()->where(['ledger_account_id'=>$payment_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
								$ReferenceBalance=$this->Payments->ReferenceBalances->get($ReferenceBalance->id);
								if($payment_row->cr_dr=="Dr"){
									$ReferenceBalance->debit=$ReferenceBalance->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								}else{
									$ReferenceBalance->credit=$ReferenceBalance->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								}
								
								$this->Payments->ReferenceBalances->save($ReferenceBalance);
								
								$ReferenceDetail=$this->Payments->ReferenceDetails->find()->where(['ledger_account_id'=>$payment_row->received_from_id,'reference_no'=>$ref_row->ref_no,'payment_id'=>$payment->id])->first();
								$ReferenceDetail=$this->Payments->ReferenceDetails->get($ReferenceDetail->id);
								if($payment_row->cr_dr=="Dr"){
									$ReferenceDetail->debit=$ReferenceDetail->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								}else{
									$ReferenceDetail->credit=$ReferenceDetail->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								}
								
								$this->Payments->ReferenceDetails->save($ReferenceDetail);
							}else{
								if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
									$query = $this->Payments->ReferenceBalances->query();
									if($payment_row->cr_dr=="Dr"){
										$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
										->values([
											'ledger_account_id' => $payment_row->received_from_id,
											'reference_no' => $ref_row->ref_no,
											'credit' => 0,
											'debit' => $ref_row->ref_amount
										])
										->execute();
									}else{
										$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
										->values([
											'ledger_account_id' => $payment_row->received_from_id,
											'reference_no' => $ref_row->ref_no,
											'credit' => $ref_row->ref_amount,
											'debit' => 0
										])
										->execute();
									}
									
								}else{
									$ReferenceBalance=$this->Payments->ReferenceBalances->find()->where(['ledger_account_id'=>$payment_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
									$ReferenceBalance=$this->Payments->ReferenceBalances->get($ReferenceBalance->id);
									if($payment_row->cr_dr=="Dr"){
										$ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
									}else{
										$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
									}
									
									$this->Payments->ReferenceBalances->save($ReferenceBalance);
								}
								
								$query = $this->Payments->ReferenceDetails->query();
								if($payment_row->cr_dr=="Dr"){
									$query->insert(['ledger_account_id', 'payment_id', 'reference_no', 'credit', 'debit', 'reference_type'])
									->values([
										'ledger_account_id' => $payment_row->received_from_id,
										'payment_id' => $payment->id,
										'reference_no' => $ref_row->ref_no,
										'credit' => 0,
										'debit' => $ref_row->ref_amount,
										'reference_type' => $ref_row->ref_type
									])
									->execute();
								}else{
									$query->insert(['ledger_account_id', 'payment_id', 'reference_no', 'credit', 'debit', 'reference_type'])
									->values([
										'ledger_account_id' => $payment_row->received_from_id,
										'payment_id' => $payment->id,
										'reference_no' => $ref_row->ref_no,
										'credit' => $ref_row->ref_amount,
										'debit' => 0,
										'reference_type' => $ref_row->ref_type
									])
									->execute();
								}
								
							}
						}
					}
				}
				//Ledger posting for bankcash
				$ledger = $this->Payments->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $payment->bank_cash_id;
				$ledger->debit = 0;
				$ledger->credit = $total_amount;
				$ledger->voucher_id = $payment->id;
				$ledger->voucher_source = 'Payment Voucher';
				$ledger->transaction_date = $payment->transaction_date;
				$this->Payments->Ledgers->save($ledger);
				
                $this->Flash->success(__('The receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
            }
        }
		
		$vr=$this->Payments->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Payment Voucher','sub_entity'=>'Cash/Bank'])->first();
		$ReceiptVouchersCashBank=$vr->id;
		$vouchersReferences = $this->Payments->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		$BankCashes_selected='yes';
		if(sizeof($where)>0){
			$bankCashes = $this->Payments->BankCashes->find('list',
				['keyField' => function ($row) {
					return $row['id'];
				},
				'valueField' => function ($row) {
					if(!empty($row['alias'])){
						return  $row['name'] . ' (' . $row['alias'] . ')';
					}else{
						return $row['name'];
					}
					
				}])->where(['BankCashes.id IN' => $where]);
		}else{
			$BankCashes_selected='no';
		}
		
		$vr=$this->Payments->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Payment Voucher','sub_entity'=>'Paid To'])->first();
		$ReceiptVouchersReceivedFrom=$vr->id;
		$vouchersReferences = $this->Payments->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		$ReceivedFroms_selected='yes';
		if(sizeof($where)>0){
			$receivedFroms = $this->Payments->ReceivedFroms->find('list',
				['keyField' => function ($row) {
					return $row['id'];
				},
				'valueField' => function ($row) {
					if(!empty($row['alias'])){
						return  $row['name'] . ' (' . $row['alias'] . ')';
					}else{
						return $row['name'];
					}
					
				}])->where(['ReceivedFroms.id IN' => $where]);
		}else{
			$ReceivedFroms_selected='no';
		}
		
        $this->set(compact('payment', 'bankCashes', 'receivedFroms', 'financial_year', 'BankCashes_selected', 'ReceivedFroms_selected', 'old_ref_rows','chkdate'));
        $this->set('_serialize', ['payment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function fetchRefNumbers($received_from_id=null,$cr_dr=null){
		$this->viewBuilder()->layout('');
		$ReferenceBalances=$this->Payments->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
		$this->set(compact('ReferenceBalances','cr_dr'));
	}
	
	public function fetchRefNumbersEdit($received_from_id=null,$reference_no=null,$debit=null,$credit=null,$cr_dr=null){
		$this->viewBuilder()->layout('');
		$ReferenceBalances=$this->Payments->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
		$this->set(compact('ReferenceBalances', 'reference_no', 'credit', 'debit', 'cr_dr'));
	}
	
	function checkRefNumberUnique($received_from_id,$i){
		$reference_no=$this->request->query['ref_rows'][$received_from_id][$i]['ref_no'];
		$ReferenceBalances=$this->Payments->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
		if($ReferenceBalances->count()==0){
			echo 'true';
		}else{
			echo 'false';
		}
		exit;
	}
	
	function checkRefNumberUniqueEdit($received_from_id,$i,$is_old){
		$reference_no=$this->request->query['ref_rows'][$received_from_id][$i]['ref_no'];
		$ReferenceBalances=$this->Payments->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
		if($ReferenceBalances->count()==1 && $is_old=="yes"){
			echo 'true';
		}elseif($ReferenceBalances->count()==0){
			echo 'true';
		}else{
			echo 'false';
		}
		exit;
	}
	
	function deleteAllRefNumbers($old_received_from_id,$receipt_id){
		$ReferenceDetails=$this->Payments->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'receipt_id'=>$receipt_id]);
		foreach($ReferenceDetails as $ReferenceDetail){
			if($ReferenceDetail->reference_type=="New Reference" || $ReferenceDetail->reference_type=="Advance Reference"){
				$this->Payments->ReferenceBalances->deleteAll(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no]);
				
				$RDetail=$this->Payments->ReferenceDetails->get($ReferenceDetail->id);
				$this->Payments->ReferenceDetails->delete($RDetail);
			}elseif($ReferenceDetail->reference_type=="Against Reference"){
				if(!empty($ReferenceDetail->credit)){
					$ReferenceBalance=$this->Payments->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
					$ReferenceBalance=$this->Payments->ReferenceBalances->get($ReferenceBalance->id);
					$ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
					$this->Payments->ReferenceBalances->save($ReferenceBalance);
				}elseif(!empty($ReferenceDetail->debit)){
					$ReferenceBalance=$this->Payments->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
					$ReferenceBalance=$this->Payments->ReferenceBalances->get($ReferenceBalance->id);
					$ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
					$this->Payments->ReferenceBalances->save($ReferenceBalance);
				}
				$RDetail=$this->Payments->ReferenceDetails->get($ReferenceDetail->id);
				$this->Payments->ReferenceDetails->delete($RDetail);
			}
		}		exit;
	}
	
	function deleteOneRefNumbers(){
		$old_received_from_id=$this->request->query['old_received_from_id'];
		$payment_id=$this->request->query['payment_id'];
		$old_ref=$this->request->query['old_ref'];
		$old_ref_type=$this->request->query['old_ref_type'];
		
		if($old_ref_type=="New Reference" || $old_ref_type=="Advance Reference"){
			$this->Payments->ReferenceBalances->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
			$this->Payments->ReferenceDetails->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
		}elseif($old_ref_type=="Against Reference"){
			$ReferenceDetail=$this->Payments->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'payment_id'=>$payment_id,'reference_no'=>$old_ref])->first();
			
			if(!empty($ReferenceDetail->credit)){
				$ReferenceBalance=$this->Payments->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
				$ReferenceBalance=$this->Payments->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
				$this->Payments->ReferenceBalances->save($ReferenceBalance);
			}elseif(!empty($ReferenceDetail->debit)){
				$ReferenceBalance=$this->Payments->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
				$ReferenceBalance=$this->Payments->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
				$this->Payments->ReferenceBalances->save($ReferenceBalance);
			}
			$RDetail=$this->Payments->ReferenceDetails->get($ReferenceDetail->id);
			$this->Payments->ReferenceDetails->delete($RDetail);
		}
		
		exit;
	}
}
