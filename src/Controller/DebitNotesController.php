<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DebitNotes Controller
 *
 * @property \App\Model\Table\DebitNotesTable $DebitNotes
 */
class DebitNotesController extends AppController
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
        $this->paginate = [
            'contain' => []
        ];
        
		$debitNotes = $this->paginate($this->DebitNotes->find()->where(['company_id'=>$st_company_id])->order(['voucher_no'=>'DESC']));
        
		//pr($debitNotes->toArray());exit;
		
		$this->set(compact('debitNotes'));
        $this->set('_serialize', ['debitNotes']);

	}

    /**
     * View method
     *
     * @param string|null $id Debit Note id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $debitNote = $this->DebitNotes->get($id, [
            'contain' => ['CustomerSuppilers', 'Companies','Creator','DebitNotesRows'=>['Heads']]
        ]);
		
		//pr($debitNote);exit;
		$ReferenceDetails=$this->DebitNotes->ReferenceDetails->find()->where(['ReferenceDetails.debit_note_id' => $id])->toArray();
		
		$this->set('debitNote', $debitNote);
		 $this->set(compact('ReferenceDetails'));
        $this->set('_serialize', ['debitNote']);
	}

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $debitNote = $this->DebitNotes->newEntity();
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $st_year_id = $session->read('st_year_id');
		$financial_year = $this->DebitNotes->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		
		if ($this->request->is('post')) {
			$debitNote = $this->DebitNotes->patchEntity($debitNote, $this->request->data);
			$debitNote->created_on=date("Y-m-d");
			$debitNote->transaction_date=date("Y-m-d");
			$debitNote->company_id=$st_company_id;
			$debitNote->created_by=$s_employee_id;
			$last_voucher_no=$this->DebitNotes->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_voucher_no){
				$debitNote->voucher_no=$last_voucher_no->voucher_no+1;
			}else{
				$debitNote->voucher_no=1;
			}
			//pr($debitNote->ref_rows);exit;
           if ($this->DebitNotes->save($debitNote)) {
				$total_cr=0; $total_dr=0;
				foreach($debitNote->debit_notes_rows as $debit_notes_row){

					$ledger = $this->DebitNotes->Ledgers->newEntity();
					$ledger->company_id=$st_company_id;
					$ledger->ledger_account_id = $debit_notes_row->head_id;
					$ledger->credit = $debit_notes_row->amount;
					$ledger->debit = 0;
					$ledger->voucher_id = $debitNote->id;
					$ledger->voucher_source = 'Debit Note';
					$ledger->transaction_date = $debitNote->transaction_date;
					$this->DebitNotes->Ledgers->save($ledger);
					
					$total_dr = $total_dr + $debit_notes_row->amount;
				}
				
				$ledger = $this->DebitNotes->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $debitNote->customer_suppiler_id;
				$ledger->debit = $total_dr;
				$ledger->credit = 0;
				$ledger->voucher_id = $debitNote->id;
				$ledger->voucher_source = 'Debit Note';
				$ledger->transaction_date = $debitNote->transaction_date;
				$this->DebitNotes->Ledgers->save($ledger);
			}
			
			//pr($debitNote); exit;
		}

		if(sizeof(@$debitNote->ref_rows)>0){
			
			foreach($debitNote->ref_rows as $ref_row){

			//pr($ref_row); exit;
			
				$ref_row=(object)$ref_row;
				if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
					$query = $this->DebitNotes->ReferenceBalances->query();
					
					$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
					->values([
						'ledger_account_id' => $debitNote->customer_suppiler_id,
						'reference_no' => $ref_row->ref_no,
						'credit' => 0,
						'debit' => $ref_row->ref_amount
					]);
					$query->execute();
				}else{
					$ReferenceBalance=$this->DebitNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$debitNote->customer_suppiler_id,'reference_no'=>$ref_row->ref_no])->first();
					$ReferenceBalance=$this->DebitNotes->ReferenceBalances->get($ReferenceBalance->id);
					$ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
					
					$this->DebitNotes->ReferenceBalances->save($ReferenceBalance);
				}
				
				$query = $this->DebitNotes->ReferenceDetails->query();
				$query->insert(['ledger_account_id', 'debit_note_id', 'reference_no', 'credit', 'debit', 'reference_type'])
				->values([
					'ledger_account_id' => $debitNote->customer_suppiler_id,
					'debit_note_id' => $debitNote->id,
					'reference_no' => $ref_row->ref_no,
					'credit' => 0,
					'debit' => $ref_row->ref_amount,
					'reference_type' => $ref_row->ref_type
				]);
			
				$query->execute();
			}
		}
		
		
			$vr=$this->DebitNotes->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Debit Notes','sub_entity'=>'Customer-Suppiler'])->first();
			$DebitNotesSalesAccount=$vr->id;
			$vouchersReferences = $this->DebitNotes->VouchersReferences->get($vr->id, [
				'contain' => ['VoucherLedgerAccounts']
			]);
			
			$where=[];
			foreach($vouchersReferences->voucher_ledger_accounts as $data){
				$where[]=$data->ledger_account_id;
			}
			
			if(sizeof($where)>0){
				$customer_suppiler_id = $this->DebitNotes->CustomerSuppilers->find('list',
					['keyField' => function ($row) {
						return $row['id'];
					},
					'valueField' => function ($row) {
						if(!empty($row['alias'])){
							return  $row['name'] . ' (' . $row['alias'] . ')';
						}else{
							return $row['name'];
						}
						
					}])->where(['CustomerSuppilers.id IN' => $where]);
			}
			else{
				$ErrorsalesAccs='true';
			}
			
		
		
			$vr=$this->DebitNotes->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Debit Notes','sub_entity'=>'Heads'])->first();	
			$DebitNotesParty=$vr->id;
			$vouchersReferences = $this->DebitNotes->VouchersReferences->get($vr->id, [
				'contain' => ['VoucherLedgerAccounts']
			]);
			$where=[];
			foreach($vouchersReferences->voucher_ledger_accounts as $data){
				  $where[]=$data->ledger_account_id;
			
			}
			if(sizeof($where)>0){
				$heads = $this->DebitNotes->Heads->find('list',
					['keyField' => function ($row) {
						return $row['id'];
					},
					'valueField' => function ($row) {
						if(!empty($row['alias'])){
							return  $row['name'] . ' (' . $row['alias'] . ')';
						}else{
							return $row['name'];
						}
						
					}])->where(['Heads.id IN' => $where]);
			
			}
			else{
				$Errorparties='true';
			}

			$companies = $this->DebitNotes->Companies->find('all');
			$this->set(compact('debitNote', 'customer_suppiler_id', 'heads', 'companies','ErrorsalesAccs','Errorparties','financial_year','DebitNotesParty','DebitNotesSalesAccount'));
			$this->set('_serialize', ['debitNote']);
    }

	public function fetchRefNumbers($ledger_account_id){
		$this->viewBuilder()->layout('');
		$ReferenceBalances=$this->DebitNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$ledger_account_id]);
		$this->set(compact('ReferenceBalances','cr_dr'));
	}		

	function checkRefNumberUnique($received_from_id,$i){
		$reference_no=$this->request->query['ref_rows'][$i]['ref_no'];
		$ReferenceBalances=$this->DebitNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
		if($ReferenceBalances->count()==0){
			echo 'true';
		}else{
			echo 'false';
		}
		exit;
	}	

    /**
     * Edit method
     *
     * @param string|null $id Debit Note id.
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
		$financial_year = $this->DebitNotes->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$debitNote = $this->DebitNotes->get($id, [
            'contain' => ['DebitNotesRows']
        ]);

	
	
        if ($this->request->is(['patch', 'post', 'put'])) {
            $debitNote = $this->DebitNotes->patchEntity($debitNote, $this->request->data);
			$debitNote->created_on=date("Y-m-d");
			$debitNote->transaction_date=date("Y-m-d");
			$debitNote->company_id=$st_company_id;
			$debitNote->created_by=$s_employee_id;
			$last_voucher_no=$this->DebitNotes->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_voucher_no){
				$debitNote->voucher_no=$last_voucher_no->voucher_no+1;
			}else{
				$debitNote->voucher_no=1;
			}
			
           if ($this->DebitNotes->save($debitNote)) {
				$total_cr=0; $total_dr=0;
				foreach($debitNote->debit_notes_rows as $debit_notes_row){

					$ledger = $this->DebitNotes->Ledgers->newEntity();
					$ledger->company_id=$st_company_id;
					$ledger->ledger_account_id = $debit_notes_row->head_id;
					$ledger->credit = $debit_notes_row->amount;
					$ledger->debit = 0;
					$ledger->voucher_id = $debitNote->id;
					$ledger->voucher_source = 'Debit Note';
					$ledger->transaction_date = $debitNote->transaction_date;
					$this->DebitNotes->Ledgers->save($ledger);
					
					$total_dr = $total_dr + $debit_notes_row->amount;
				}
				
				$ledger = $this->DebitNotes->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $debitNote->customer_suppiler_id;
				$ledger->debit = $total_dr;
				$ledger->credit = 0;
				$ledger->voucher_id = $debitNote->id;
				$ledger->voucher_source = 'Debit Note';
				$ledger->transaction_date = $debitNote->transaction_date;
				$this->DebitNotes->Ledgers->save($ledger);

					if(sizeof(@$debitNote->ref_rows)>0){
						
						$this->DebitNotes->Ledgers->deleteAll(['voucher_id' => $debitNote->id, 'voucher_source' => 'Debit Note']);
					
					$ref_rows=@$this->request->data['ref_rows'];
					//pr($ref_rows); exit;
					if(sizeof(@$ref_rows)>0){
						foreach($ref_rows as $ref_row){
							$ref_row=(object)$ref_row;
							$ReferenceDetail=$this->DebitNotes->ReferenceDetails->find()->where(['ledger_account_id'=>$debitNote->customer_suppiler_id,'reference_no'=>$ref_row->ref_no,'debit_note_id'=>$debitNote->id])->first();
							
							if($ReferenceDetail){
								$ReferenceBalance=$this->DebitNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$debitNote->customer_suppiler_id,'reference_no'=>$ref_row->ref_no])->first();
								$ReferenceBalance=$this->DebitNotes->ReferenceBalances->get($ReferenceBalance->id);
								$ReferenceBalance->debit=$ReferenceBalance->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								
								$this->DebitNotes->ReferenceBalances->save($ReferenceBalance);
								
								$ReferenceDetail=$this->DebitNotes->ReferenceDetails->find()->where(['ledger_account_id'=>$debitNote->customer_suppiler_id,'reference_no'=>$ref_row->ref_no,'debit_note_id'=>$debitNote->id])->first();
								$ReferenceDetail=$this->DebitNotes->ReferenceDetails->get($ReferenceDetail->id);
								$ReferenceDetail->debit=$ReferenceDetail->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								$this->DebitNotes->ReferenceDetails->save($ReferenceDetail);
							}else{
								if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
									$query = $this->DebitNotes->ReferenceBalances->query();
									$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
									->values([
										'ledger_account_id' => $debitNote->customer_suppiler_id,
										'reference_no' => $ref_row->ref_no,
										'credit' => 0,
										'debit' => $ref_row->ref_amount
									])
									->execute();
									
								}else{
									$ReferenceBalance=$this->DebitNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$debitNote->customer_suppiler_id,'reference_no'=>$ref_row->ref_no])->first();
									$ReferenceBalance=$this->DebitNotes->ReferenceBalances->get($ReferenceBalance->id);
									$ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
									
									$this->DebitNotes->ReferenceBalances->save($ReferenceBalance);
								}
								
								$query = $this->DebitNotes->ReferenceDetails->query();
								$query->insert(['ledger_account_id', 'debit_note_id', 'reference_no', 'credit', 'debit', 'reference_type'])
								->values([
									'ledger_account_id' => $debitNote->customer_suppiler_id,
									'debit_note_id' => $debitNote->id,
									'reference_no' => $ref_row->ref_no,
									'credit' => 0,
									'debit' => $ref_row->ref_amount,
									'reference_type' => $ref_row->ref_type
								])
								->execute();
								
							}
						}
					}
						
					}				
				
			}
        }

			$vr=$this->DebitNotes->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Debit Notes','sub_entity'=>'Customer-Suppiler'])->first();
			$DebitNotesSalesAccount=$vr->id;
			$vouchersReferences = $this->DebitNotes->VouchersReferences->get($vr->id, [
				'contain' => ['VoucherLedgerAccounts']
			]);
			
			$where=[];
			foreach($vouchersReferences->voucher_ledger_accounts as $data){
				$where[]=$data->ledger_account_id;
			}
			
			if(sizeof($where)>0){
				$customer_suppiler_id = $this->DebitNotes->CustomerSuppilers->find('list',
					['keyField' => function ($row) {
						return $row['id'];
					},
					'valueField' => function ($row) {
						if(!empty($row['alias'])){
							return  $row['name'] . ' (' . $row['alias'] . ')';
						}else{
							return $row['name'];
						}
						
					}])->where(['CustomerSuppilers.id IN' => $where]);
			}
			else{
				$ErrorsalesAccs='true';
			}

			$vr=$this->DebitNotes->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Debit Notes','sub_entity'=>'Heads'])->first();	
			$DebitNotesParty=$vr->id;
			$vouchersReferences = $this->DebitNotes->VouchersReferences->get($vr->id, [
				'contain' => ['VoucherLedgerAccounts']
			]);
			$where=[];
			foreach($vouchersReferences->voucher_ledger_accounts as $data){
				  $where[]=$data->ledger_account_id;
			
			}
			if(sizeof($where)>0){
				$heads = $this->DebitNotes->Heads->find('list',
					['keyField' => function ($row) {
						return $row['id'];
					},
					'valueField' => function ($row) {
						if(!empty($row['alias'])){
							return  $row['name'] . ' (' . $row['alias'] . ')';
						}else{
							return $row['name'];
						}
						
					}])->where(['Heads.id IN' => $where]);
			
			}
			else{
				$Errorparties='true';
			}

			$ReferenceDetails = $this->DebitNotes->ReferenceDetails->find()->where(['ledger_account_id'=>$debitNote->customer_suppiler_id,'debit_note_id'=>$id]);
		
			
		
		
		if(!empty($ReferenceDetails))
		{
			foreach($ReferenceDetails as $ReferenceDetail)
			{
				$ReferenceBalances[] = $this->DebitNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no]);
			}
		}
		else{
			$ReferenceBalances='';
		}	


        $customerSuppilers = $this->DebitNotes->CustomerSuppilers->find('list', ['limit' => 200]);
        $companies = $this->DebitNotes->Companies->find('list', ['limit' => 200]);
        $this->set(compact('debitNote', 'customerSuppilers', 'companies','heads','customer_suppiler_id','ReferenceDetails','financial_year'));
        $this->set('_serialize', ['debitNote']);
    }

	public function fetchRefNumbersEdit($received_from_id=null,$reference_no=null,$debit=null){
		$this->viewBuilder()->layout('');
		$ReferenceBalances=$this->DebitNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
	    $this->set(compact('ReferenceBalances', 'reference_no', 'debit'));
	}	

	function deleteOneRefNumbers(){
		$old_received_from_id=$this->request->query['old_received_from_id'];
		$debitNote_id=$this->request->query['debitNote_id'];
		$old_ref=$this->request->query['old_ref'];
		$old_ref_type=$this->request->query['old_ref_type'];
		
		if($old_ref_type=="New Reference" || $old_ref_type=="Advance Reference"){
			$this->DebitNotes->ReferenceBalances->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
			$this->DebitNotes->ReferenceDetails->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
		}elseif($old_ref_type=="Against Reference"){
			$ReferenceDetail=$this->DebitNotes->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'debit_note_id'=>$debitNote_id,'reference_no'=>$old_ref])->first();
			if(!empty($ReferenceDetail->credit)){
				$ReferenceBalance=$this->DebitNotes->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
				$ReferenceBalance=$this->DebitNotes->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
				$this->DebitNotes->ReferenceBalances->save($ReferenceBalance);
			}elseif(!empty($ReferenceDetail->debit)){
				$ReferenceBalance=$this->DebitNotes->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
				$ReferenceBalance=$this->DebitNotes->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
				$this->DebitNotes->ReferenceBalances->save($ReferenceBalance);
			}
			$RDetail=$this->DebitNotes->ReferenceDetails->get($ReferenceDetail->id);
			$this->DebitNotes->ReferenceDetails->delete($RDetail);
		}
		
		exit;
	}	
	
	
    /**
     * Delete method
     *
     * @param string|null $id Debit Note id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $debitNote = $this->DebitNotes->get($id);
        if ($this->DebitNotes->delete($debitNote)) {
            $this->Flash->success(__('The debit note has been deleted.'));
        } else {
            $this->Flash->error(__('The debit note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
