<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Receipts Controller
 *
 * @property \App\Model\Table\ReceiptsTable $Receipts
 */
class ReceiptsController extends AppController
{

// Start CSV function 

		public function ReceiptVoucherExport()
		{	
			$session = $this->request->session();
			$st_company_id = $session->read('st_company_id');
			$where = [];
			$receipts = $this->Receipts->find()->where($where)->where(['company_id'=>$st_company_id])->contain(['ReceiptRows'=>function($q){
				$ReceiptRows = $this->Receipts->ReceiptRows->find();
				$totalCrCase = $ReceiptRows->newExpr()
					->addCase(
						$ReceiptRows->newExpr()->add(['cr_dr' => 'Cr']),
						$ReceiptRows->newExpr()->add(['amount']),
						'integer'
					);
				$totalDrCase = $ReceiptRows->newExpr()
					->addCase(
						$ReceiptRows->newExpr()->add(['cr_dr' => 'Dr']),
						$ReceiptRows->newExpr()->add(['amount']),
						'integer'
					);
				return $ReceiptRows->select([
						'total_cr' => $ReceiptRows->func()->sum($totalCrCase),
						'total_dr' => $ReceiptRows->func()->sum($totalDrCase)
					])
					->group('receipt_id')
					->autoFields(true);
				
			}]);

			$i=0; foreach ($receipts as $receipt){ $i++; 

				$data[] = [
					$i,date("d-m-Y",strtotime($receipt->transaction_date)),'#'.str_pad($receipt->voucher_no, 4, '0', STR_PAD_LEFT),$receipt->receipt_rows[0]->total_cr-$receipt->receipt_rows[0]->total_dr
				];			
				
			}
			
			$_serialize = 'data';
			$_header = ['Sr. No.', 'Transaction Date', 'Vocher No', 'Amount'];
			

			$this->response->download('Receipt_Voucher.csv');
			$this->viewBuilder()->className('CsvView.Csv');
			$this->set(compact('data', '_serialize', '_header', '_footer'));
		}	
// End CSV function 	


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
			$where['Receipts.voucher_no LIKE']=$vouch_no;
		}
		
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['Receipts.transaction_date >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['Receipts.transaction_date <=']=$To;
		}
		
		
        $this->paginate = [
            'contain' => []
        ];
        $receipts = $this->paginate($this->Receipts->find()->where($where)->where(['company_id'=>$st_company_id])->contain(['ReceiptRows'=>function($q){
			$ReceiptRows = $this->Receipts->ReceiptRows->find();
			$totalCrCase = $ReceiptRows->newExpr()
				->addCase(
					$ReceiptRows->newExpr()->add(['cr_dr' => 'Cr']),
					$ReceiptRows->newExpr()->add(['amount']),
					'integer'
				);
			$totalDrCase = $ReceiptRows->newExpr()
				->addCase(
					$ReceiptRows->newExpr()->add(['cr_dr' => 'Dr']),
					$ReceiptRows->newExpr()->add(['amount']),
					'integer'
				);
			return $ReceiptRows->select([
					'total_cr' => $ReceiptRows->func()->sum($totalCrCase),
					'total_dr' => $ReceiptRows->func()->sum($totalDrCase)
				])
				->group('receipt_id')
				->autoFields(true);
			
		}])->order(['transaction_date' => 'DESC']));
		
		
        $this->set(compact('receipts'));
        $this->set('_serialize', ['receipts']);
    }

    /**
     * View method
     *
     * @param string|null $id Receipt id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $receipt = $this->Receipts->get($id, [
            'contain' => ['BankCashes', 'Companies', 'ReceiptRows' => ['ReceivedFroms'], 'Creator']
        ]);
		
	
		
		$ref_bal=[];
		foreach($receipt->receipt_rows as $receipt_rows){
			$ReferenceBalancess=$this->Receipts->ReferenceDetails->find()->where(['ledger_account_id'=>$receipt_rows->received_from_id,'receipt_id'=>$receipt->id]);
			$ref_bal[$receipt_rows->received_from_id]=$ReferenceBalancess->toArray();
		}
		
										
		$this->set(compact('ref_bal'));

        $this->set('receipt', $receipt);
        $this->set('_serialize', ['receipt']);
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
		$financial_year = $this->Receipts->FinancialYears->find()->where(['id'=>$st_year_id])->first();

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
		
        $receipt = $this->Receipts->newEntity();
        if ($this->request->is('post')) {
			
            $receipt = $this->Receipts->patchEntity($receipt, $this->request->data);
			$receipt->company_id=$st_company_id;
			//Voucher Number Increment
			$last_voucher_no=$this->Receipts->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_voucher_no){
				$receipt->voucher_no=$last_voucher_no->voucher_no+1;
			}else{
				$receipt->voucher_no=1;
			}
			
			$receipt->created_on=date("Y-m-d");
			$receipt->created_by=$s_employee_id;
			$receipt->transaction_date=date("Y-m-d",strtotime($receipt->transaction_date));
			
			//pr($receipt); exit;
			//Save receipt
            if ($this->Receipts->save($receipt)) {
				$total_cr=0; $total_dr=0;
				foreach($receipt->receipt_rows as $receipt_row){
					
					//Ledger posting for Received From Entity
					$ledger = $this->Receipts->Ledgers->newEntity();
					$ledger->company_id=$st_company_id;
					$ledger->ledger_account_id = $receipt_row->received_from_id;
					if($receipt_row->cr_dr=="Cr"){
						$ledger->credit = $receipt_row->amount;
						$ledger->debit = 0;
						$total_cr=$total_cr+$receipt_row->amount;
					}else{
						$ledger->credit = 0;
						$ledger->debit = $receipt_row->amount;
						$total_dr=$total_dr+$receipt_row->amount;
					}
					
					$ledger->voucher_id = $receipt->id;
					$ledger->voucher_source = 'Receipt Voucher';
					$ledger->transaction_date = $receipt->transaction_date;
					$this->Receipts->Ledgers->save($ledger);
					
					$total_amount=$total_cr-$total_dr;
					
					//Reference Number coding
					if(sizeof(@$receipt->ref_rows[$receipt_row->received_from_id])>0){
						
						foreach($receipt->ref_rows[$receipt_row->received_from_id] as $ref_row){ 
							$ref_row=(object)$ref_row;
							if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
								$query = $this->Receipts->ReferenceBalances->query();
								if($receipt_row->cr_dr=="Cr"){
									$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
									->values([
										'ledger_account_id' => $receipt_row->received_from_id,
										'reference_no' => $ref_row->ref_no,
										'credit' => $ref_row->ref_amount,
										'debit' => 0
									]);
								}else{
									$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
									->values([
										'ledger_account_id' => $receipt_row->received_from_id,
										'reference_no' => $ref_row->ref_no,
										'credit' => 0,
										'debit' => $ref_row->ref_amount
									]);
								}
								$query->execute();
							}else{
								$ReferenceBalance=$this->Receipts->ReferenceBalances->find()->where(['ledger_account_id'=>$receipt_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
								$ReferenceBalance=$this->Receipts->ReferenceBalances->get($ReferenceBalance->id);
								if($receipt_row->cr_dr=="Cr"){
									$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
								}else{
									$ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
								}
								
								$this->Receipts->ReferenceBalances->save($ReferenceBalance);
							}
							
							$query = $this->Receipts->ReferenceDetails->query();
							if($receipt_row->cr_dr=="Cr"){
								$query->insert(['ledger_account_id', 'receipt_id', 'reference_no', 'credit', 'debit', 'reference_type'])
								->values([
									'ledger_account_id' => $receipt_row->received_from_id,
									'receipt_id' => $receipt->id,
									'reference_no' => $ref_row->ref_no,
									'credit' => $ref_row->ref_amount,
									'debit' => 0,
									'reference_type' => $ref_row->ref_type
								]);
							}else{
								$query->insert(['ledger_account_id', 'receipt_id', 'reference_no', 'credit', 'debit', 'reference_type'])
								->values([
									'ledger_account_id' => $receipt_row->received_from_id,
									'receipt_id' => $receipt->id,
									'reference_no' => $ref_row->ref_no,
									'credit' => 0,
									'debit' => $ref_row->ref_amount,
									'reference_type' => $ref_row->ref_type
								]);
							}
							
							$query->execute();
						}
					}
				}
				
				//Ledger posting for bankcash
				$ledger = $this->Receipts->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $receipt->bank_cash_id;
				$ledger->debit = $total_amount;
				$ledger->credit = 0;
				$ledger->voucher_id = $receipt->id;
				$ledger->voucher_source = 'Receipt Voucher';
				$ledger->transaction_date = $receipt->transaction_date;
				$this->Receipts->Ledgers->save($ledger);
				
                $this->Flash->success(__('The receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
            }
        }
		
		$vr=$this->Receipts->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Receipt Voucher','sub_entity'=>'Cash/Bank'])->first();
		$ReceiptVouchersCashBank=$vr->id;
		$vouchersReferences = $this->Receipts->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		$BankCashes_selected='yes';
		if(sizeof($where)>0){
			$bankCashes = $this->Receipts->BankCashes->find('list',
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
			
		
		$vr=$this->Receipts->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Receipt Voucher','sub_entity'=>'Received From'])->first();
		$ReceiptVouchersReceivedFrom=$vr->id;
		$vouchersReferences = $this->Receipts->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		$ReceivedFroms_selected='yes';
		if(sizeof($where)>0){
			$receivedFroms = $this->Receipts->ReceivedFroms->find('list',
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
        $this->set(compact('receipt', 'bankCashes', 'receivedFroms', 'financial_year', 'BankCashes_selected', 'ReceivedFroms_selected','chkdate'));
        $this->set('_serialize', ['receipt']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Receipt id.
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
		$financial_year = $this->Receipts->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		
        $receipt = $this->Receipts->get($id, [
            'contain' => ['ReceiptRows']
        ]);

			   $session = $this->request->session();
			   $st_year_id = $session->read('st_year_id');

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
		

		$old_ref_rows=[];
		$old_received_from_ids=[];
		$old_reference_numbers=[];
		foreach($receipt->receipt_rows as $receipt_row){
			$ReferenceDetails=$this->Receipts->ReferenceDetails->find()->where(['ledger_account_id'=>$receipt_row->received_from_id,'receipt_id'=>$receipt->id]);
			foreach($ReferenceDetails as $ReferenceDetail){
				$old_reference_numbers[$receipt_row->received_from_id][]=$ReferenceDetail->reference_no;
			}
			$old_ref_rows[$receipt_row->received_from_id]=$ReferenceDetails->toArray();
			$old_received_from_ids[]=$receipt_row->received_from_id;
		}
		
        if ($this->request->is(['patch', 'post', 'put'])) {
            $receipt = $this->Receipts->patchEntity($receipt, $this->request->data);
			$receipt->company_id=$st_company_id;
			
			
			$receipt->edited_on=date("Y-m-d");
			$receipt->edited_by=$s_employee_id;
			$receipt->transaction_date=date("Y-m-d",strtotime($receipt->transaction_date));
				
			//Save receipt
			//pr($receipt); exit;
            if ($this->Receipts->save($receipt)) {
				$this->Receipts->Ledgers->deleteAll(['voucher_id' => $receipt->id, 'voucher_source' => 'Receipt Voucher']);
				$total_cr=0; $total_dr=0;
				foreach($receipt->receipt_rows as $receipt_row){
					
					//Ledger posting for Received From Entity
					$ledger = $this->Receipts->Ledgers->newEntity();
					$ledger->company_id=$st_company_id;
					$ledger->ledger_account_id = $receipt_row->received_from_id;
					if($receipt_row->cr_dr=="Cr"){
						$ledger->credit = $receipt_row->amount;
						$ledger->debit = 0;
						$total_cr=$total_cr+$receipt_row->amount;
					}else{
						$ledger->credit = 0;
						$ledger->debit = $receipt_row->amount;
						$total_dr=$total_dr+$receipt_row->amount;
					}
					
					$ledger->voucher_id = $receipt->id;
					$ledger->voucher_source = 'Receipt Voucher';
					$ledger->transaction_date = $receipt->transaction_date;
					$this->Receipts->Ledgers->save($ledger);
					
					$total_amount=$total_cr-$total_dr;
					
					//Reference Number coding
					if(sizeof(@$receipt->ref_rows[$receipt_row->received_from_id])>0){
						
						foreach($receipt->ref_rows[$receipt_row->received_from_id] as $ref_row){
							$ref_row=(object)$ref_row;
							$ReferenceDetail=$this->Receipts->ReferenceDetails->find()->where(['ledger_account_id'=>$receipt_row->received_from_id,'reference_no'=>$ref_row->ref_no,'receipt_id'=>$receipt->id])->first();
							
							if($ReferenceDetail){
								$ReferenceBalance=$this->Receipts->ReferenceBalances->find()->where(['ledger_account_id'=>$receipt_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
								$ReferenceBalance=$this->Receipts->ReferenceBalances->get($ReferenceBalance->id);
								if($receipt_row->cr_dr=="Cr"){
									$ReferenceBalance->credit=$ReferenceBalance->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								}else{
									$ReferenceBalance->debit=$ReferenceBalance->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								}
								
								$this->Receipts->ReferenceBalances->save($ReferenceBalance);
								
								$ReferenceDetail=$this->Receipts->ReferenceDetails->find()->where(['ledger_account_id'=>$receipt_row->received_from_id,'reference_no'=>$ref_row->ref_no,'receipt_id'=>$receipt->id])->first();
								$ReferenceDetail=$this->Receipts->ReferenceDetails->get($ReferenceDetail->id);
								if($receipt_row->cr_dr=="Cr"){
									$ReferenceDetail->credit=$ReferenceDetail->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								}else{
									$ReferenceDetail->debit=$ReferenceDetail->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								}
								$this->Receipts->ReferenceDetails->save($ReferenceDetail);
							}else{
								if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
									$query = $this->Receipts->ReferenceBalances->query();
									if($receipt_row->cr_dr=="Cr"){
										$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
										->values([
											'ledger_account_id' => $receipt_row->received_from_id,
											'reference_no' => $ref_row->ref_no,
											'credit' => $ref_row->ref_amount,
											'debit' => 0
										])
										->execute();
									}else{
										$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
										->values([
											'ledger_account_id' => $receipt_row->received_from_id,
											'reference_no' => $ref_row->ref_no,
											'credit' => 0,
											'debit' => $ref_row->ref_amount
										])
										->execute();
									}
									
								}else{
									$ReferenceBalance=$this->Receipts->ReferenceBalances->find()->where(['ledger_account_id'=>$receipt_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
									$ReferenceBalance=$this->Receipts->ReferenceBalances->get($ReferenceBalance->id);
									if($receipt_row->cr_dr=="Cr"){
										$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
									}else{
										$ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
									}
									$this->Receipts->ReferenceBalances->save($ReferenceBalance);
								}
								
								$query = $this->Receipts->ReferenceDetails->query();
								if($receipt_row->cr_dr=="Cr"){
									$query->insert(['ledger_account_id', 'receipt_id', 'reference_no', 'credit', 'debit', 'reference_type'])
									->values([
										'ledger_account_id' => $receipt_row->received_from_id,
										'receipt_id' => $receipt->id,
										'reference_no' => $ref_row->ref_no,
										'credit' => $ref_row->ref_amount,
										'debit' => 0,
										'reference_type' => $ref_row->ref_type
									])
									->execute();
								}else{
									$query->insert(['ledger_account_id', 'receipt_id', 'reference_no', 'credit', 'debit', 'reference_type'])
									->values([
										'ledger_account_id' => $receipt_row->received_from_id,
										'receipt_id' => $receipt->id,
										'reference_no' => $ref_row->ref_no,
										'credit' => $ref_row->ref_amount,
										'debit' => $ref_row->ref_type,
										'reference_type' => 0
									])
									->execute();
								}
							}
						}
					}
				}
				//Ledger posting for bankcash
				$ledger = $this->Receipts->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $receipt->bank_cash_id;
				$ledger->debit = $total_amount;
				$ledger->credit = 0;
				$ledger->voucher_id = $receipt->id;
				$ledger->voucher_source = 'Receipt Voucher';
				$ledger->transaction_date = $receipt->transaction_date;
				$this->Receipts->Ledgers->save($ledger);
				
                $this->Flash->success(__('The receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
            }
        }
		
		$vr=$this->Receipts->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Receipt Voucher','sub_entity'=>'Cash/Bank'])->first();
		$ReceiptVouchersCashBank=$vr->id;
		$vouchersReferences = $this->Receipts->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		$BankCashes_selected='yes';
		if(sizeof($where)>0){
			$bankCashes = $this->Receipts->BankCashes->find('list',
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
			
		
		$vr=$this->Receipts->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Receipt Voucher','sub_entity'=>'Received From'])->first();
		$ReceiptVouchersReceivedFrom=$vr->id;
		$vouchersReferences = $this->Receipts->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		$ReceivedFroms_selected='yes';
		if(sizeof($where)>0){
			$receivedFroms = $this->Receipts->ReceivedFroms->find('list',
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
		
        $this->set(compact('receipt', 'bankCashes', 'receivedFroms', 'financial_year', 'BankCashes_selected', 'ReceivedFroms_selected', 'old_ref_rows','chkdate'));
        $this->set('_serialize', ['receipt']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Receipt id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $receipt = $this->Receipts->get($id);
        if ($this->Receipts->delete($receipt)) {
            $this->Flash->success(__('The receipt has been deleted.'));
        } else {
            $this->Flash->error(__('The receipt could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function fetchRefNumbers($received_from_id=null,$cr_dr=null){
		$this->viewBuilder()->layout('');
		$ReferenceBalances=$this->Receipts->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
		$this->set(compact('ReferenceBalances','cr_dr'));
	}
	
	public function fetchRefNumbersEdit($received_from_id=null,$reference_no=null,$credit=null,$debit=null,$cr_dr=null){
		$this->viewBuilder()->layout('');
		$ReferenceBalances=$this->Receipts->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
		$this->set(compact('ReferenceBalances', 'reference_no', 'credit', 'debit', 'cr_dr'));
	}
	
	function checkRefNumberUnique($received_from_id,$i){
		$reference_no=$this->request->query['ref_rows'][$received_from_id][$i]['ref_no'];
		$ReferenceBalances=$this->Receipts->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
		if($ReferenceBalances->count()==0){
			echo 'true';
		}else{
			echo 'false';
		}
		exit;
	}
	
	function checkRefNumberUniqueEdit($received_from_id,$i,$is_old){
		$reference_no=$this->request->query['ref_rows'][$received_from_id][$i]['ref_no'];
		$ReferenceBalances=$this->Receipts->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
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
		$ReferenceDetails=$this->Receipts->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'receipt_id'=>$receipt_id]);
		foreach($ReferenceDetails as $ReferenceDetail){
			if($ReferenceDetail->reference_type=="New Reference" || $ReferenceDetail->reference_type=="Advance Reference"){
				$this->Receipts->ReferenceBalances->deleteAll(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no]);
				
				$RDetail=$this->Receipts->ReferenceDetails->get($ReferenceDetail->id);
				$this->Receipts->ReferenceDetails->delete($RDetail);
			}elseif($ReferenceDetail->reference_type=="Against Reference"){
				if(!empty($ReferenceDetail->credit)){
					$ReferenceBalance=$this->Receipts->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
					$ReferenceBalance=$this->Receipts->ReferenceBalances->get($ReferenceBalance->id);
					$ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
					$this->Receipts->ReferenceBalances->save($ReferenceBalance);
				}elseif(!empty($ReferenceDetail->debit)){
					$ReferenceBalance=$this->Receipts->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
					$ReferenceBalance=$this->Receipts->ReferenceBalances->get($ReferenceBalance->id);
					$ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
					$this->Receipts->ReferenceBalances->save($ReferenceBalance);
				}
				$RDetail=$this->Receipts->ReferenceDetails->get($ReferenceDetail->id);
				$this->Receipts->ReferenceDetails->delete($RDetail);
			}
		}		exit;
	}
	
	function deleteOneRefNumbers(){
		$old_received_from_id=$this->request->query['old_received_from_id'];
		$receipt_id=$this->request->query['receipt_id'];
		$old_ref=$this->request->query['old_ref'];
		$old_ref_type=$this->request->query['old_ref_type'];
		
		if($old_ref_type=="New Reference" || $old_ref_type=="Advance Reference"){
			$this->Receipts->ReferenceBalances->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
			$this->Receipts->ReferenceDetails->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
		}elseif($old_ref_type=="Against Reference"){
			$ReferenceDetail=$this->Receipts->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'receipt_id'=>$receipt_id,'reference_no'=>$old_ref])->first();
			if(!empty($ReferenceDetail->credit)){
				$ReferenceBalance=$this->Receipts->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
				$ReferenceBalance=$this->Receipts->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
				$this->Receipts->ReferenceBalances->save($ReferenceBalance);
			}elseif(!empty($ReferenceDetail->debit)){
				$ReferenceBalance=$this->Receipts->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
				$ReferenceBalance=$this->Receipts->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
				$this->Receipts->ReferenceBalances->save($ReferenceBalance);
			}
			$RDetail=$this->Receipts->ReferenceDetails->get($ReferenceDetail->id);
			$this->Receipts->ReferenceDetails->delete($RDetail);
		}
		
		exit;
	}
	

	
	
	
}
