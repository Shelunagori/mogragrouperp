<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ReceiptVouchers Controller
 *
 * @property \App\Model\Table\ReceiptVouchersTable $ReceiptVouchers
 */
class ReceiptVouchersController extends AppController
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
            'contain' => ['ReceivedFroms', 'BankCashes']
        ];
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $receiptVouchers = $this->paginate($this->ReceiptVouchers->find()->where(['ReceiptVouchers.company_id'=>$st_company_id])->order(['transaction_date' => 'DESC']));

        $this->set(compact('receiptVouchers'));
        $this->set('_serialize', ['receiptVouchers']);
    }

    /**
     * View method
     *
     * @param string|null $id Receipt Voucher id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $receiptVoucher = $this->ReceiptVouchers->get($id, [
            'contain' => ['ReceivedFroms', 'BankCashes','Companies','Creator','ReceiptBreakups'=>['Invoices']]
        ]);
		$ReferenceDetails=$this->ReceiptVouchers->ReferenceDetails->find()->where(['ReferenceDetails.receipt_voucher_id' => $id])->toArray();
		//pr($ReferenceDetails); exit;
        $this->set('receiptVoucher', $receiptVoucher);
		 $this->set(compact('ReferenceDetails'));
        $this->set('_serialize', ['receiptVoucher']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
	 
	public function fetchReferenceNo($ledger_account_id=null)
    {
		$this->viewBuilder()->layout('ajax_layout');
	
		$ReferenceDetails=$this->ReceiptVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ledger_account_id])->toArray();
		//pr($ReferenceDetail); exit;
		$this->set(compact(['ReferenceDetails']));
	}
	public function deleteReceiptRow($reference_type=null,$old_amount=null,$ledger_account_id=null,$receipt_voucher_id=null,$reference_no=null)
    {
		$query1 = $this->ReceiptVouchers->ReferenceDetails->query();
		$query1->delete()
		->where([
			'ledger_account_id' => $ledger_account_id,
			'receipt_voucher_id' => $receipt_voucher_id,
			'reference_no' => $reference_no,
			'reference_type' => $reference_type
		])
		->execute();
		
		if($reference_type=='Against Reference')
		{
			$res=$this->ReceiptVouchers->ReferenceBalances->find()->where(['reference_no' => $reference_no,'ledger_account_id' => $ledger_account_id])->first();
			
			$q=$res->debit-$old_amount;
			
			$query2 = $this->ReceiptVouchers->ReferenceBalances->query();
			$query2->update()
				->set(['debit' => $q])
				->where(['reference_no' => $reference_no,'ledger_account_id' => $ledger_account_id])
				->execute();
		}
		else
		{ 
			$query2 = $this->ReceiptVouchers->ReferenceBalances->query();
			$query2->delete()
			->where([
				'reference_no' => $reference_no,
				'ledger_account_id' => $ledger_account_id
			])
			->execute();
			
		}
		exit;
	
	}
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $receiptVoucher = $this->ReceiptVouchers->newEntity();
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->ReceiptVouchers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
        
        if ($this->request->is('post')) {
			
			$total_row=sizeof($this->request->data['reference_no']);
			$last_ref_no=$this->ReceiptVouchers->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_ref_no){
				$receiptVoucher->voucher_no=$last_ref_no->voucher_no+1;
			}else{
				$receiptVoucher->voucher_no=1;
			}
			$receiptVoucher = $this->ReceiptVouchers->patchEntity($receiptVoucher, $this->request->data);
			$receiptVoucher->created_by=$s_employee_id;
			$receiptVoucher->transaction_date=date("Y-m-d",strtotime($receiptVoucher->transaction_date));
			$receiptVoucher->created_on=date("Y-m-d");
			$receiptVoucher->company_id=$st_company_id;
			
			
			
            if ($this->ReceiptVouchers->save($receiptVoucher)) {
				//Ledger posting for bankcash
				$ledger = $this->ReceiptVouchers->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $receiptVoucher->bank_cash_id;
				$ledger->debit = $receiptVoucher->amount;
				$ledger->credit = 0;
				$ledger->voucher_id = $receiptVoucher->id;
				$ledger->voucher_source = 'Receipt Voucher';
				$ledger->transaction_date = $receiptVoucher->transaction_date;
				$this->ReceiptVouchers->Ledgers->save($ledger);
				
				//Ledger posting for Received From Entity
				$ledger = $this->ReceiptVouchers->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $receiptVoucher->received_from_id;
				$ledger->debit = 0;
				$ledger->credit = $receiptVoucher->amount;
				$ledger->voucher_id = $receiptVoucher->id;
				$ledger->voucher_source = 'Receipt Voucher';
				$ledger->transaction_date = $receiptVoucher->transaction_date;
				$this->ReceiptVouchers->Ledgers->save($ledger); 
				
				for($row=0; $row<$total_row; $row++)
				{
					////////////////  ReferenceDetails ////////////////////////////////
					$query1 = $this->ReceiptVouchers->ReferenceDetails->query();
					$query1->insert(['reference_no', 'ledger_account_id', 'receipt_voucher_id', 'credit', 'reference_type'])
					->values([
						'ledger_account_id' => $this->request->data['received_from_id'],
						'receipt_voucher_id' => $receiptVoucher->id,
						'reference_no' => $this->request->data['reference_no'][$row],
						'credit' => $this->request->data['debit'][$row],
						'reference_type' => $this->request->data['reference_type'][$row]
					])
					->execute();
					
					////////////////  ReferenceBalances ////////////////////////////////
					if($this->request->data['reference_type'][$row]=='Against Reference')
					{
						$query2 = $this->ReceiptVouchers->ReferenceBalances->query();
						$query2->update()
							->set(['credit' => $this->request->data['debit'][$row]])
							->where(['reference_no' => $this->request->data['reference_no'][$row],'ledger_account_id' => $this->request->data['received_from_id']])
							->execute();
					}
					else
					{
						$query2 = $this->ReceiptVouchers->ReferenceBalances->query();
						$query2->insert(['reference_no', 'ledger_account_id', 'debit'])
						->values([
							'reference_no' => $this->request->data['reference_no'][$row],
							'ledger_account_id' => $this->request->data['received_from_id'],
							'credit' => $this->request->data['debit'][$row],
						])
						->execute();
					}
					
				}
				$this->Flash->success(__('The Receipt-Voucher:'.str_pad($receiptVoucher->id, 4, '0', STR_PAD_LEFT)).' has been genereted.');
				return $this->redirect(['action' => 'view/'.$receiptVoucher->id]);
           
			} else {
                $this->Flash->error(__('The receipt voucher could not be saved. Please, try again.'));
            }
			
        }
		
		$vr=$this->ReceiptVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Receipt Voucher','sub_entity'=>'Received From'])->first();
		$ReceiptVouchersReceivedFrom=$vr->id;
		$vouchersReferences = $this->ReceiptVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		if(sizeof($where)>0){
			$receivedFroms = $this->ReceiptVouchers->ReceivedFroms->find('list',
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
			$ErrorreceivedFroms='true';
		}
		
		$vr=$this->ReceiptVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Receipt Voucher','sub_entity'=>'Cash/Bank'])->first();
		$ReceiptVouchersCashBank=$vr->id;
		$vouchersReferences = $this->ReceiptVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		if(sizeof($where)>0){
			$bankCashes = $this->ReceiptVouchers->BankCashes->find('list',
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
			$ErrorbankCashes='true';
		}
		
		
        $companies = $this->ReceiptVouchers->Companies->find('all');
		
		$Invoices = $this->ReceiptVouchers->Invoices->find()->where(['company_id'=>$st_company_id,'due_payment >'=>0]);		
        $this->set(compact('receiptVoucher', 'receivedFroms', 'bankCashes','companies','ErrorreceivedFroms','ErrorbankCashes','customers','financial_year','ReceiptVouchersCashBank','ReceiptVouchersReceivedFrom'));
        $this->set('_serialize', ['receiptVoucher']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Receipt Voucher id.
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
		$receipt_voucher_id=$id;
		$financial_year = $this->ReceiptVouchers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
        $receiptVoucher = $this->ReceiptVouchers->get($id);

        if ($this->request->is('post')) {
			
			$total_row=sizeof($this->request->data['reference_no']);
			$last_ref_no=$this->ReceiptVouchers->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_ref_no){
				$receiptVoucher->voucher_no=$last_ref_no->voucher_no+1;
			}else{
				$receiptVoucher->voucher_no=1;
			}
			$receiptVoucher = $this->ReceiptVouchers->patchEntity($receiptVoucher, $this->request->data);
			$receiptVoucher->created_by=$s_employee_id;
			$receiptVoucher->transaction_date=date("Y-m-d",strtotime($receiptVoucher->transaction_date));
			$receiptVoucher->created_on=date("Y-m-d");
			$receiptVoucher->company_id=$st_company_id;
			
			
			
            if ($this->ReceiptVouchers->save($receiptVoucher)) {
				//Ledger posting for bankcash
				$ledger = $this->ReceiptVouchers->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $receiptVoucher->bank_cash_id;
				$ledger->debit = $receiptVoucher->amount;
				$ledger->credit = 0;
				$ledger->voucher_id = $receiptVoucher->id;
				$ledger->voucher_source = 'Receipt Voucher';
				$ledger->transaction_date = $receiptVoucher->transaction_date;
				$this->ReceiptVouchers->Ledgers->save($ledger);
				
				//Ledger posting for Received From Entity
				$ledger = $this->ReceiptVouchers->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $receiptVoucher->received_from_id;
				$ledger->debit = 0;
				$ledger->credit = $receiptVoucher->amount;
				$ledger->voucher_id = $receiptVoucher->id;
				$ledger->voucher_source = 'Receipt Voucher';
				$ledger->transaction_date = $receiptVoucher->transaction_date;
				$this->ReceiptVouchers->Ledgers->save($ledger); 
				
				for($row=0; $row<$total_row; $row++)
				{
					////////////////  ReferenceDetails ////////////////////////////////
					$query1 = $this->ReceiptVouchers->ReferenceDetails->query();
					$query1->insert(['reference_no', 'ledger_account_id', 'receipt_voucher_id', 'credit', 'reference_type'])
					->values([
						'ledger_account_id' => $this->request->data['received_from_id'],
						'receipt_voucher_id' => $receiptVoucher->id,
						'reference_no' => $this->request->data['reference_no'][$row],
						'credit' => $this->request->data['debit'][$row],
						'reference_type' => $this->request->data['reference_type'][$row]
					])
					->execute();
					
					////////////////  ReferenceBalances ////////////////////////////////
					if($this->request->data['reference_type'][$row]=='Against Reference')
					{
						$query2 = $this->ReceiptVouchers->ReferenceBalances->query();
						$query2->update()
							->set(['credit' => $this->request->data['debit'][$row]])
							->where(['reference_no' => $this->request->data['reference_no'][$row],'ledger_account_id' => $this->request->data['received_from_id']])
							->execute();
					}
					else
					{
						$query2 = $this->ReceiptVouchers->ReferenceBalances->query();
						$query2->insert(['reference_no', 'ledger_account_id', 'debit'])
						->values([
							'reference_no' => $this->request->data['reference_no'][$row],
							'ledger_account_id' => $this->request->data['received_from_id'],
							'credit' => $this->request->data['debit'][$row],
						])
						->execute();
					}
					
				}
				$this->Flash->success(__('The Receipt-Voucher:'.str_pad($receiptVoucher->id, 4, '0', STR_PAD_LEFT)).' has been genereted.');
				return $this->redirect(['action' => 'view/'.$receiptVoucher->id]);
           
			} else {
                $this->Flash->error(__('The receipt voucher could not be saved. Please, try again.'));
            }
			
        }		
		
		$ReferenceDetails = $this->ReceiptVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$receiptVoucher->received_from_id,'receipt_voucher_id'=>$id])->toArray();
		if(!empty($ReferenceDetails))
		{
			foreach($ReferenceDetails as $ReferenceDetail)
			{
				$ReferenceBalances[] = $this->ReceiptVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])->toArray();
			}
		}
		else{
			$ReferenceBalances='';
		}
		

        $Em = new FinancialYearsController;
	    $financial_year_data = $Em->checkFinancialYear($receiptVoucher->transaction_date);
       


        if ($this->request->is(['patch', 'post', 'put'])) {
			$total_row=sizeof($this->request->data['reference_no']);
			
            $receiptVoucher = $this->ReceiptVouchers->patchEntity($receiptVoucher, $this->request->data);
			$receiptVoucher->edited_by=$s_employee_id;
				$receiptVoucher->transaction_date=date("Y-m-d",strtotime($receiptVoucher->transaction_date));
				$receiptVoucher->edited_on=date("Y-m-d");
				$receiptVoucher->company_id=$st_company_id;
			
            if ($this->ReceiptVouchers->save($receiptVoucher)) {
				
				//delete old data
				$this->ReceiptVouchers->Ledgers->deleteAll(['voucher_id' => $receiptVoucher->id, 'voucher_source' => 'Receipt Voucher']);
				
				//Ledger posting for bankcash
				$ledger = $this->ReceiptVouchers->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $receiptVoucher->bank_cash_id;
				$ledger->debit =$receiptVoucher->amount;
				$ledger->credit =0;
				$ledger->voucher_id = $receiptVoucher->id;
				$ledger->voucher_source = 'Receipt Voucher';
				$ledger->transaction_date = $receiptVoucher->transaction_date;
				$this->ReceiptVouchers->Ledgers->save($ledger);
				
				//Ledger posting for Received From Entity
				$ledger = $this->ReceiptVouchers->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $receiptVoucher->received_from_id;
				$ledger->debit = 0;
				$ledger->credit = $receiptVoucher->amount;
				$ledger->voucher_id = $receiptVoucher->id;
				$ledger->voucher_source = 'Receipt Voucher';
				$ledger->transaction_date = $receiptVoucher->transaction_date;
				$this->ReceiptVouchers->Ledgers->save($ledger);
				
				for($row=0; $row<$total_row; $row++)
				{
					if(!empty($this->request->data['old_amount'][$row]))
					{				////////////////  ReferenceDetails ////////////////////////////////
				
				
						$query1 = $this->ReceiptVouchers->ReferenceDetails->query();
						$query1->update()
						->set(['credit' => $this->request->data['debit'][$row]])
						->where([
							'ledger_account_id' => $this->request->data['received_from_id'],
							'receipt_voucher_id' => $receiptVoucher->id,
							'reference_no' => $this->request->data['reference_no'][$row],
							'reference_type' => $this->request->data['reference_type'][$row]
						])
						->execute();
						
						////////////////  ReferenceBalances ////////////////////////////////
						if($this->request->data['reference_type'][$row]=='Against Reference')
						{
							
							$res=$this->ReceiptVouchers->ReferenceBalances->find()->where(['reference_no' => $this->request->data['reference_no'][$row],'ledger_account_id' => $this->request->data['received_from_id']])->first();
							
							 $q=$res->debit-$this->request->data['old_amount'][$row]+ $this->request->data['debit'][$row];
							
							$query2 = $this->ReceiptVouchers->ReferenceBalances->query();
							$query2->update()
								->set(['debit' => $q])
								->where(['reference_no' => $this->request->data['reference_no'][$row],'ledger_account_id' => $this->request->data['received_from_id']])
								->execute();
						}
						else
						{ 
							$query2 = $this->ReceiptVouchers->ReferenceBalances->query();
							$query2->update()
							->set(['credit' => $this->request->data['debit'][$row]])
							->where([
								'reference_no' => $this->request->data['reference_no'][$row],
								'ledger_account_id' => $this->request->data['received_from_id']
							])
							->execute();
							
						}

					}
					else
					{
						////////////////  ReferenceDetails ////////////////////////////////
						$query1 = $this->ReceiptVouchers->ReferenceDetails->query();
						$query1->insert(['reference_no', 'ledger_account_id', 'receipt_voucher_id', 'credit', 'reference_type'])
						->values([
							'ledger_account_id' => $this->request->data['received_from_id'],
							'receipt_voucher_id' => $receiptVoucher->id,
							'reference_no' => $this->request->data['reference_no'][$row],
							'credit' => $this->request->data['debit'][$row],
							'reference_type' => $this->request->data['reference_type'][$row]
						])
						->execute();
						
						////////////////  ReferenceBalances ////////////////////////////////
						if($this->request->data['reference_type'][$row]=='Against Reference')
						{
							$query2 = $this->ReceiptVouchers->ReferenceBalances->query();
							$query2->update()
								->set(['credit' => $this->request->data['debit'][$row]])
								->where(['reference_no' => $this->request->data['reference_no'][$row],'ledger_account_id' => $this->request->data['received_from_id']])
								->execute();
						}
						else
						{
							$query2 = $this->ReceiptVouchers->ReferenceBalances->query();
							$query2->insert(['reference_no', 'ledger_account_id', 'credit'])
							->values([
								'reference_no' => $this->request->data['reference_no'][$row],
								'ledger_account_id' => $this->request->data['received_from_id'],
								'credit' => $this->request->data['debit'][$row],
							])
							->execute();
						}
					}
					
				}
				
                $this->Flash->success(__('The receipt voucher has been saved.'));
				return $this->redirect(['action' => 'view/'.$receiptVoucher->id]);
            } else {
                $this->Flash->error(__('The receipt voucher could not be saved. Please, try again.'));
            }
        }
		
		$vr=$this->ReceiptVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Receipt Voucher','sub_entity'=>'Received From'])->first();
		$vouchersReferences = $this->ReceiptVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		$receivedFroms = $this->ReceiptVouchers->ReceivedFroms->find('list',
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
			
		$vr=$this->ReceiptVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Receipt Voucher','sub_entity'=>'Cash/Bank'])->first();
		$vouchersReferences = $this->ReceiptVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		//pr(['BankCashes.id IN' => $where]);
		$bankCashes = $this->ReceiptVouchers->BankCashes->find('list',
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
		
        $companies = $this->ReceiptVouchers->Companies->find('all');		
        $this->set(compact('ReferenceDetails','ReferenceBalances','receiptVoucher', 'receivedFroms', 'bankCashes','companies','financial_year','financial_year_data','receipt_voucher_id'));
        $this->set('_serialize', ['receiptVoucher']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Receipt Voucher id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $receiptVoucher = $this->ReceiptVouchers->get($id);
        if ($this->ReceiptVouchers->delete($receiptVoucher)) {
            $this->Flash->success(__('The receipt voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The receipt voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
