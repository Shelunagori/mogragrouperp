<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PaymentVouchers Controller
 *
 * @property \App\Model\Table\PaymentVouchersTable $PaymentVouchers
 */
class PaymentVouchersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		
		$this->paginate = [
            'contain' => ['PaidTos','BankCashes']
        ];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $paymentVouchers = $this->paginate($this->PaymentVouchers->find()->where(['PaymentVouchers.company_id'=>$st_company_id])->order(['transaction_date' => 'DESC']));
		$this->set(compact('paymentVouchers'));
        $this->set('_serialize', ['paymentVouchers']);
    }

    /**
     * View method
     *
     * @param string|null $id Payment Voucher id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		
		$this->viewBuilder()->layout('index_layout');
        $paymentVoucher = $this->PaymentVouchers->get($id, [
            'contain' => ['PaidTos','BankCashes','Companies','Creator','PaymentBreakups'=>['InvoiceBookings']]
        ]);
		$ReferenceDetails=$this->PaymentVouchers->ReferenceDetails->find()->where(['ReferenceDetails.payment_voucher_id' => $id])->toArray();
        $this->set('paymentVoucher', $paymentVoucher);
		 $this->set(compact('ReferenceDetails'));
        $this->set('_serialize', ['paymentVoucher']);
    }

	public function fetchReferenceNo($ledger_account_id=null)
    {
		$this->viewBuilder()->layout('ajax_layout');
		$ReferenceBalances=$this->PaymentVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ledger_account_id])->toArray();
		$this->set(compact(['ReferenceBalances']));
	}
	public function deleteReceiptRow($reference_type=null,$old_amount=null,$ledger_account_id=null,$payment_voucher_id=null,$reference_no=null)
    {
		
		$query1 = $this->PaymentVouchers->ReferenceDetails->query();
		$query1->delete()
		->where([
			'ledger_account_id' => $ledger_account_id,
			'payment_voucher_id' => $payment_voucher_id,
			'reference_no' => $reference_no,
			'reference_type' => $reference_type
		])
		->execute();
		
		
		if($reference_type=='Against Reference')
		{
			$res=$this->PaymentVouchers->ReferenceBalances->find()->where(['reference_no' => $reference_no,'ledger_account_id' => $ledger_account_id])->first();
			
			$q=$res->credit-$old_amount;
			
			$query2 = $this->PaymentVouchers->ReferenceBalances->query();
			$query2->update()
				->set(['credit' => $q])
				->where(['reference_no' => $reference_no,'ledger_account_id' => $ledger_account_id])
				->execute();
		}
		else
		{ 
			$query2 = $this->PaymentVouchers->ReferenceBalances->query();
			$query2->delete()
			->where([
				'reference_no' => $reference_no,
				'ledger_account_id' => $ledger_account_id
			])
			->execute();
			
		}
		exit;
	
	}
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $paymentVoucher = $this->PaymentVouchers->newEntity();
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->PaymentVouchers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		
		if ($this->request->is('post')) {
			
			$total_row=sizeof($this->request->data['reference_no']);
			
			$last_ref_no=$this->PaymentVouchers->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_ref_no){
				$paymentVoucher->voucher_no=$last_ref_no->voucher_no+1;
			}else{
				$paymentVoucher->voucher_no=1;
			}
						
			$paymentVoucher = $this->PaymentVouchers->patchEntity($paymentVoucher, $this->request->data);
			
			$paymentVoucher->created_by=$s_employee_id;
			$paymentVoucher->created_on=date("Y-m-d");
			$paymentVoucher->transaction_date=date("Y-m-d",strtotime($paymentVoucher->transaction_date));
			$paymentVoucher->company_id=$st_company_id;
			 if ($this->PaymentVouchers->save($paymentVoucher)) {
				
				//Ledger posting for paidto
				$ledger = $this->PaymentVouchers->Ledgers->newEntity();
			    $ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $paymentVoucher->paid_to_id;
				$ledger->debit = $paymentVoucher->amount;
				$ledger->credit = 0;
				$ledger->voucher_id = $paymentVoucher->id;
				$ledger->voucher_source = 'Payment Voucher';
				$ledger->transaction_date = $paymentVoucher->transaction_date;
				$this->PaymentVouchers->Ledgers->save($ledger);
				
				//Ledger posting for bankcash
				$ledger = $this->PaymentVouchers->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $paymentVoucher->cash_bank_account_id;
				$ledger->debit = 0;
				$ledger->credit = $paymentVoucher->amount;;
				$ledger->voucher_id = $paymentVoucher->id;
				$ledger->transaction_date = $paymentVoucher->transaction_date;
				$ledger->voucher_source = 'Payment Voucher';
				$this->PaymentVouchers->Ledgers->save($ledger); 
				
				for($row=0; $row<$total_row; $row++)
				{
					////////////////  ReferenceDetails ////////////////////////////////
					$query1 = $this->PaymentVouchers->ReferenceDetails->query();
					$query1->insert(['reference_no', 'ledger_account_id', 'payment_voucher_id', 'debit', 'reference_type'])
					->values([
						'ledger_account_id' => $this->request->data['paid_to_id'],
						'payment_voucher_id' => $paymentVoucher->id,
						'reference_no' => $this->request->data['reference_no'][$row],
						'debit' => $this->request->data['credit'][$row],
						'reference_type' => $this->request->data['reference_type'][$row]
					])
					->execute();
					
					////////////////  ReferenceBalances ////////////////////////////////
					if($this->request->data['reference_type'][$row]=='Against Reference')
					{
						$query2 = $this->PaymentVouchers->ReferenceBalances->query();
						$old_data=$this->PaymentVouchers->ReferenceBalances->find()->where(['reference_no' => $this->request->data['reference_no'][$row],'ledger_account_id' => $this->request->data['paid_to_id']])->first();
						$old_amt=$old_data->debit;
						
						$query2->update()
							->set(['debit' => $old_amt+$this->request->data['credit'][$row]])
							->where(['reference_no' => $this->request->data['reference_no'][$row],'ledger_account_id' => $this->request->data['paid_to_id']])
							->execute();
					}
					else
					{
						$query2 = $this->PaymentVouchers->ReferenceBalances->query();
						$query2->insert(['reference_no', 'ledger_account_id', 'debit'])
						->values([
							'reference_no' => $this->request->data['reference_no'][$row],
							'ledger_account_id' => $this->request->data['paid_to_id'],
							'debit' => $this->request->data['credit'][$row],
						])
						->execute();
					}
					
				}
				
				$this->Flash->success(__('The Payment-Voucher:'.str_pad($paymentVoucher->voucher_no, 4, '0', STR_PAD_LEFT)).' has been genereted.');
				return $this->redirect(['action' => 'view/'.$paymentVoucher->id]);
            } else {
				
                $this->Flash->error(__('The payment voucher could not be saved. Please, try again.'));
            }
        }
		$vr=$this->PaymentVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Payment Voucher','sub_entity'=>'Paid To'])->first();
		$paymentVoucherpaidTo=$vr->id;
		$vouchersReferences = $this->PaymentVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
	
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		if(sizeof($where)>0){
			$paidTos = $this->PaymentVouchers->PaidTos->find('list',
				['keyField' => function ($row) {
					return $row['id'];
				},
				'valueField' => function ($row) {
					if(!empty($row['alias'])){
						return  $row['name'] . ' (' . $row['alias'] . ')';
					}else{
						return $row['name'];
					}
					
				}])->where(['PaidTos.id IN' => $where]);
		}
		else{
			$ErrorpaidTos='true';
		}
		$vr=$this->PaymentVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Payment Voucher','sub_entity'=>'Cash/Bank'])->first();
		$paymentVoucherBankCash=$vr->id;
		$vouchersReferences = $this->PaymentVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		//pr($this->PaymentVouchers->BankCashes->find('list')); exit;
		if(sizeof($where)>0){
			$bankCashes = $this->PaymentVouchers->BankCashes->find('list',
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
		}
		else{
			$ErrorbankCashes='true';
		}
		
		
        $companies = $this->PaymentVouchers->Companies->find('all');
		
        $this->set(compact('paymentVoucher', 'paidTos', 'bankCashes','companies','ErrorpaidTos','ErrorbankCashes','financial_year','paymentVoucherpaidTo','paymentVoucherBankCash'));
        $this->set('_serialize', ['paymentVoucher']);
    }

		
    /**
     * Edit method
     *
     * @param string|null $id Payment Voucher id.
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
		$financial_year = $this->PaymentVouchers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
        $paymentVoucher = $this->PaymentVouchers->get($id, [
            'contain' => ['PaidTos','BankCashes','Companies']
		
		  ]);

        $Em = new FinancialYearsController;
	    $financial_year_data = $Em->checkFinancialYear($paymentVoucher->transaction_date);


		$check_date= $paymentVoucher->transaction_date;
		$payment_voucher_id=$id;
		$ReferenceDetails = $this->PaymentVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$paymentVoucher->paid_to_id,'payment_voucher_id'=>$id])->toArray();
		if(!empty($ReferenceDetails))
		{
			foreach($ReferenceDetails as $ReferenceDetail)
			{
				$ReferenceBalances[] = $this->PaymentVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])->toArray();
			}
		}
		else{
			$ReferenceBalances='';
		}
		
		
			if ($this->request->is(['patch', 'post', 'put'])) {
			
            $paymentVoucher = $this->PaymentVouchers->patchEntity($paymentVoucher, $this->request->data);
			$paymentVoucher->company_id=$st_company_id;
			$paymentVoucher->edited_on=date("Y-m-d");
			$paymentVoucher->transaction_date=date("Y-m-d",strtotime($paymentVoucher->transaction_date));
			$paymentVoucher->edited_by=$s_employee_id;
			$total_row=sizeof($this->request->data['reference_no']);
            if ($this->PaymentVouchers->save($paymentVoucher))
			{
				
					$this->PaymentVouchers->Ledgers->deleteAll(['voucher_id' => $paymentVoucher->id, 'voucher_source' => 'Payment Voucher']);
					$ledger = $this->PaymentVouchers->Ledgers->newEntity();
					$ledger->company_id=$st_company_id;
					$ledger->ledger_account_id = $paymentVoucher->paid_to_id;
					$ledger->debit = $paymentVoucher->amount;
					$ledger->credit = 0;
					$ledger->voucher_id = $paymentVoucher->id;
					$ledger->voucher_source = 'Payment Voucher';
					$ledger->transaction_date = $paymentVoucher->transaction_date;
					$this->PaymentVouchers->Ledgers->save($ledger);
					
					//Ledger posting for bankcash
					$ledger = $this->PaymentVouchers->Ledgers->newEntity();
					$ledger->company_id=$st_company_id;
					$ledger->ledger_account_id = $paymentVoucher->cash_bank_account_id;
					$ledger->debit = 0;
					$ledger->credit = $paymentVoucher->amount;;
					$ledger->voucher_id = $paymentVoucher->id;
					$ledger->transaction_date = $paymentVoucher->transaction_date;
					$ledger->voucher_source = 'Payment Voucher';
					$this->PaymentVouchers->Ledgers->save($ledger); 
					
					for($row=0; $row<$total_row; $row++)
					{
						if(!empty($this->request->data['old_amount'][$row]))
						{				////////////////  ReferenceDetails ////////////////////////////////
					
					
							$query1 = $this->PaymentVouchers->ReferenceDetails->query();
							$query1->update()
							->set(['debit' => $this->request->data['credit'][$row]])
							->where([
								'ledger_account_id' => $this->request->data['paid_to_id'],
								'payment_voucher_id' => $paymentVoucher->id,
								'reference_no' => $this->request->data['reference_no'][$row],
								'reference_type' => $this->request->data['reference_type'][$row]
							])
							->execute();
							
							////////////////  ReferenceBalances ////////////////////////////////
							if($this->request->data['reference_type'][$row]=='Against Reference')
							{
								
								$res=$this->PaymentVouchers->ReferenceBalances->find()->where(['reference_no' => $this->request->data['reference_no'][$row],'ledger_account_id' => $this->request->data['paid_to_id']])->first();
								
								 $q=$res->credit-$this->request->data['old_amount'][$row]+ $this->request->data['credit'][$row];
								
								$query2 = $this->PaymentVouchers->ReferenceBalances->query();
								$query2->update()
									->set(['debit' => $q])
									->where(['reference_no' => $this->request->data['reference_no'][$row],'ledger_account_id' => $this->request->data['paid_to_id']])
									->execute();
							}
							else
							{ 
								$query2 = $this->PaymentVouchers->ReferenceBalances->query();
								$query2->update()
								->set(['debit' => $this->request->data['credit'][$row]])
								->where([
									'reference_no' => $this->request->data['reference_no'][$row],
									'ledger_account_id' => $this->request->data['paid_to_id']
								])
								->execute();
								
							}

						}
						else
						{
							////////////////  ReferenceDetails ////////////////////////////////
							$query1 = $this->PaymentVouchers->ReferenceDetails->query();
							$query1->insert(['reference_no', 'ledger_account_id', 'payment_voucher_id', 'debit', 'reference_type'])
							->values([
								'ledger_account_id' => $this->request->data['paid_to_id'],
								'payment_voucher_id' => $paymentVoucher->id,
								'reference_no' => $this->request->data['reference_no'][$row],
								'debit' => $this->request->data['credit'][$row],
								'reference_type' => $this->request->data['reference_type'][$row]
							])
							->execute();
							
							////////////////  ReferenceBalances ////////////////////////////////
							if($this->request->data['reference_type'][$row]=='Against Reference')
							{
								$query2 = $this->PaymentVouchers->ReferenceBalances->query();
								$query2->update()
									->set(['debit' => $this->request->data['credit'][$row]])
									->where(['reference_no' => $this->request->data['reference_no'][$row],'ledger_account_id' => $this->request->data['paid_to_id']])
									->execute();
							}
							else
							{
								$query2 = $this->PaymentVouchers->ReferenceBalances->query();
								$query2->insert(['reference_no', 'ledger_account_id', 'debit'])
								->values([
									'reference_no' => $this->request->data['reference_no'][$row],
									'ledger_account_id' => $this->request->data['paid_to_id'],
									'debit' => $this->request->data['credit'][$row],
								])
								->execute();
							}
						}
						
					}
				
					$this->Flash->success(__('The payment voucher has been saved.'));
					return $this->redirect(['action' => 'view/'.$paymentVoucher->id]);
				} 
			 else {
                $this->Flash->error(__('The payment voucher could not be saved. Please, try again.'));
            }
        }
		$vr=$this->PaymentVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Payment Voucher','sub_entity'=>'Paid To'])->first();
		$vouchersReferences = $this->PaymentVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
	
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		
		$paidTos = $this->PaymentVouchers->PaidTos->find('list',
				['keyField' => function ($row) {
					return $row['id'];
				},
				'valueField' => function ($row) {
					if(!empty($row['alias'])){
						return  $row['name'] . ' (' . $row['alias'] . ')';
					}else{
						return $row['name'];
					}
					
				}])->where(['PaidTos.id IN' => $where]);
				
		$vr=$this->PaymentVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Payment Voucher','sub_entity'=>'Cash/Bank'])->first();
		$vouchersReferences = $this->PaymentVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		$bankCashes = $this->PaymentVouchers->BankCashes->find('list',
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
		
        $companies = $this->PaymentVouchers->Companies->find('all');	
        $this->set(compact('payment_voucher_id','ReferenceDetails','ReferenceBalances','paymentVoucher', 'paidTos', 'bankCashes','companies','financial_year','financial_year_data'));
        $this->set('_serialize', ['paymentVoucher']);
 
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment Voucher id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $paymentVoucher = $this->PaymentVouchers->get($id);
        if ($this->PaymentVouchers->delete($paymentVoucher)) {
            $this->Flash->success(__('The payment voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The payment voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
