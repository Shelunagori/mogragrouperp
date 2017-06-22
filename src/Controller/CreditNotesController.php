<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CreditNotes Controller
 *
 * @property \App\Model\Table\CreditNotesTable $CreditNotes
 */
class CreditNotesController extends AppController
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
        
		$creditNotes = $this->paginate($this->CreditNotes->find()->where(['company_id'=>$st_company_id])->order(['voucher_no'=>'DESC']));
        
		//pr($creditNotes->toArray());exit;
		
		$this->set(compact('creditNotes'));
        $this->set('_serialize', ['creditNotes']);		
    }

    /**
     * View method
     *
     * @param string|null $id Credit Note id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $creditNotes = $this->CreditNotes->get($id, [
            'contain' => ['CustomerSuppilers', 'Companies','Creator','CreditNotesRows'=>['Heads']]
        ]);
		
		//pr($debitNote);exit;
		$ReferenceDetails=$this->CreditNotes->ReferenceDetails->find()->where(['ReferenceDetails.credit_note_id' => $id])->toArray();
		
		$this->set('creditNotes', $creditNotes);
		 $this->set(compact('ReferenceDetails'));
        $this->set('_serialize', ['creditNotes']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $creditNote = $this->CreditNotes->newEntity();
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $st_year_id = $session->read('st_year_id');
		$financial_year = $this->CreditNotes->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		
		if ($this->request->is('post')) {
			$creditNote = $this->CreditNotes->patchEntity($creditNote, $this->request->data);
			$creditNote->created_on=date("Y-m-d");
			$creditNote->transaction_date=date("Y-m-d");
			$creditNote->company_id=$st_company_id;
			$creditNote->created_by=$s_employee_id;
			$last_voucher_no=$this->CreditNotes->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_voucher_no){
				$creditNote->voucher_no=$last_voucher_no->voucher_no+1;
			}else{
				$creditNote->voucher_no=1;
			}
			//pr($creditNote->ref_rows);exit;
           if ($this->CreditNotes->save($creditNote)) {
				$total_cr=0; $total_dr=0;
				foreach($creditNote->credit_notes_rows as $credit_notes_row){

					$ledger = $this->CreditNotes->Ledgers->newEntity();
					$ledger->company_id=$st_company_id;
					$ledger->ledger_account_id = $credit_notes_row->head_id;
					$ledger->credit = 0;
					$ledger->debit = $credit_notes_row->amount;
					$ledger->voucher_id = $creditNote->id;
					$ledger->voucher_source = 'Credit Note';
					$ledger->transaction_date = $creditNote->transaction_date;
					$this->CreditNotes->Ledgers->save($ledger);
					
					$total_dr = $total_dr + $credit_notes_row->amount;
				}
				
				$ledger = $this->CreditNotes->Ledgers->newEntity();
				$ledger->company_id=$st_company_id;
				$ledger->ledger_account_id = $creditNote->customer_suppiler_id;
				$ledger->debit = 0;
				$ledger->credit = $total_dr;
				$ledger->voucher_id = $creditNote->id;
				$ledger->voucher_source = 'Credit Note';
				$ledger->transaction_date = $creditNote->transaction_date;
				$this->CreditNotes->Ledgers->save($ledger);
			}
			
			//pr($creditNote); exit;
		}

		if(sizeof(@$creditNote->ref_rows)>0){
			
			foreach($creditNote->ref_rows as $ref_row){

			
				$ref_row=(object)$ref_row;
				if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
					$query = $this->CreditNotes->ReferenceBalances->query();
					
					$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
					->values([
						'ledger_account_id' => $creditNote->customer_suppiler_id,
						'reference_no' => $ref_row->ref_no,
						'credit' => $ref_row->ref_amount,
						'debit' => 0
					]);
					$query->execute();
				}else{
					$ReferenceBalance=$this->CreditNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$creditNote->customer_suppiler_id,'reference_no'=>$ref_row->ref_no])->first();
					$ReferenceBalance=$this->CreditNotes->ReferenceBalances->get($ReferenceBalance->id);
					$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
					
					$this->CreditNotes->ReferenceBalances->save($ReferenceBalance);
				}
				
				$query = $this->CreditNotes->ReferenceDetails->query();
				$query->insert(['ledger_account_id', 'credit_note_id', 'reference_no', 'credit', 'debit', 'reference_type'])
				->values([
					'ledger_account_id' => $creditNote->customer_suppiler_id,
					'credit_note_id' => $creditNote->id,
					'reference_no' => $ref_row->ref_no,
					'credit' => $ref_row->ref_amount,
					'debit' => 0,
					'reference_type' => $ref_row->ref_type
				]);
			
				$query->execute();
			}
		}
		
		
			$vr=$this->CreditNotes->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Credit Notes','sub_entity'=>'Purchase Account'])->first();
			$CreditNotesSalesAccount=$vr->id;
			$vouchersReferences = $this->CreditNotes->VouchersReferences->get($vr->id, [
				'contain' => ['VoucherLedgerAccounts']
			]);
			
			$where=[];
			foreach($vouchersReferences->voucher_ledger_accounts as $data){
				$where[]=$data->ledger_account_id;
			}
			
			if(sizeof($where)>0){
				$customer_suppiler_id = $this->CreditNotes->CustomerSuppilers->find('list',
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
			
		
		
			$vr=$this->CreditNotes->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Credit Notes','sub_entity'=>'Party'])->first();	
			$CreditNotesParty=$vr->id;
			$vouchersReferences = $this->CreditNotes->VouchersReferences->get($vr->id, [
				'contain' => ['VoucherLedgerAccounts']
			]);
			$where=[];
			foreach($vouchersReferences->voucher_ledger_accounts as $data){
				  $where[]=$data->ledger_account_id;
			
			}
			if(sizeof($where)>0){
				$heads = $this->CreditNotes->Heads->find('list',
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

			$companies = $this->CreditNotes->Companies->find('all');
			$this->set(compact('creditNote', 'customer_suppiler_id', 'heads', 'companies','ErrorsalesAccs','Errorparties','financial_year','CreditNotesParty','CreditNotesSalesAccount'));
			$this->set('_serialize', ['creditNote']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Credit Note id.
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
		$creditNote = $this->CreditNotes->get($id, [
            'contain' => ['CreditNotesRows']
        ]);
		$financial_year = $this->CreditNotes->FinancialYears->find()->where(['id'=>$st_year_id])->first();

	//pr($creditNote->credit_notes_rows); exit;
	
        if ($this->request->is(['patch', 'post', 'put'])) {
					$creditNote = $this->CreditNotes->patchEntity($creditNote, $this->request->data);
					$creditNote->created_on=date("Y-m-d");
					$creditNote->transaction_date=date("Y-m-d");
					$creditNote->company_id=$st_company_id;
					$creditNote->created_by=$s_employee_id;
					$last_voucher_no=$this->CreditNotes->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
					if($last_voucher_no){
						$creditNote->voucher_no=$last_voucher_no->voucher_no+1;
					}else{
						$creditNote->voucher_no=1;
					}
			
           if ($this->CreditNotes->save($creditNote)) {
			   
			   $this->CreditNotes->Ledgers->deleteAll(['voucher_id' => $creditNote->id, 'voucher_source' => 'Credit Note']);
				$total_cr=0; $total_dr=0;
					foreach($creditNote->credit_notes_rows as $credit_notes_row){
						$ledger = $this->CreditNotes->Ledgers->newEntity();
						$ledger->company_id=$st_company_id;
						$ledger->ledger_account_id = $credit_notes_row->head_id;
						$ledger->credit = 0;
						$ledger->debit = $credit_notes_row->amount;
						$ledger->voucher_id = $creditNote->id;
						$ledger->voucher_source = 'Credit Note';
						$ledger->transaction_date = $creditNote->transaction_date;
						$this->CreditNotes->Ledgers->save($ledger);
						$total_dr = $total_dr + $credit_notes_row->amount;
					}
				
					$ledger = $this->CreditNotes->Ledgers->newEntity();
					$ledger->company_id=$st_company_id;
					$ledger->ledger_account_id = $creditNote->customer_suppiler_id;
					$ledger->debit = 0;
					$ledger->credit = $total_dr;
					$ledger->voucher_id = $creditNote->id;
					$ledger->voucher_source = 'Credit Note';
					$ledger->transaction_date = $creditNote->transaction_date;
					$this->CreditNotes->Ledgers->save($ledger);

					if(sizeof(@$creditNote->ref_rows)>0){
						
						
					
					$ref_rows=@$this->request->data['ref_rows'];
					$i=0;
					//pr($ref_rows); exit;
					if(sizeof(@$ref_rows)>0){
						foreach($ref_rows as $ref_row){
							$ref_row=(object)$ref_row;
							$ReferenceDetail=$this->CreditNotes->ReferenceDetails->find()->where(['ledger_account_id'=>$creditNote->customer_suppiler_id,'reference_no'=>$ref_row->ref_no,'credit_note_id'=>$creditNote->id])->first();
							
							if($ReferenceDetail){   
								$ReferenceBalance=$this->CreditNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$creditNote->customer_suppiler_id,'reference_no'=>$ref_row->ref_no])->first();
								
								$ReferenceBalance=$this->CreditNotes->ReferenceBalances->get($ReferenceBalance->id);
								//pr($ref_row->ref_amount); exit;
								$ReferenceBalance->credit=$ReferenceBalance->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								
								$this->CreditNotes->ReferenceBalances->save($ReferenceBalance);
								
								$ReferenceDetail=$this->CreditNotes->ReferenceDetails->find()->where(['ledger_account_id'=>$creditNote->customer_suppiler_id,'reference_no'=>$ref_row->ref_no,'credit_note_id'=>$creditNote->id])->first();
								
								
								$ReferenceDetail=$this->CreditNotes->ReferenceDetails->get($ReferenceDetail->id);
								
								$ReferenceDetail->credit=$ReferenceDetail->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								
								$this->CreditNotes->ReferenceDetails->save($ReferenceDetail);
							}else{  //pr($ref_row); exit;
								if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
									//pr($ref_row); exit;
									$query = $this->CreditNotes->ReferenceBalances->query();
									$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
									->values([
										'ledger_account_id' => $creditNote->customer_suppiler_id,
										'reference_no' => $ref_row->ref_no,
										'credit' =>$ref_row->ref_amount,
										'debit' => 0
									])
									->execute();
									
								}else{ 
									$ReferenceBalance=$this->CreditNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$creditNote->customer_suppiler_id,'reference_no'=>$ref_row->ref_no])->first();
									$ReferenceBalance=$this->CreditNotes->ReferenceBalances->get($ReferenceBalance->id);
									$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
									
									$this->CreditNotes->ReferenceBalances->save($ReferenceBalance);
								}
								
								$query = $this->CreditNotes->ReferenceDetails->query();
								$query->insert(['ledger_account_id', 'credit_note_id', 'reference_no', 'credit', 'debit', 'reference_type'])
								->values([
									'ledger_account_id' => $creditNote->customer_suppiler_id,
									'credit_note_id' => $creditNote->id,
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
			}

			$vr=$this->CreditNotes->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Credit Notes','sub_entity'=>'Purchase Account'])->first();
			
			$CreditNotesSalesAccount=$vr->id;
			$vouchersReferences = $this->CreditNotes->VouchersReferences->get($vr->id, [
				'contain' => ['VoucherLedgerAccounts']
			]);
			//pr($vouchersReferences); exit;
			$where=[];
			foreach($vouchersReferences->voucher_ledger_accounts as $data){
				$where[]=$data->ledger_account_id;
			}
			
			if(sizeof($where)>0){
				$customer_suppiler_id = $this->CreditNotes->CustomerSuppilers->find('list',
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
			
			$vr=$this->CreditNotes->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Credit Notes','sub_entity'=>'Party'])->first();	
			$CreditNotesParty=$vr->id;
			$vouchersReferences = $this->CreditNotes->VouchersReferences->get($vr->id, [
				'contain' => ['VoucherLedgerAccounts']
			]);
			$where=[];
			foreach($vouchersReferences->voucher_ledger_accounts as $data){
				  $where[]=$data->ledger_account_id;
			
			}
			if(sizeof($where)>0){
				$heads = $this->CreditNotes->Heads->find('list',
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

			$ReferenceDetails = $this->CreditNotes->ReferenceDetails->find()->where(['ledger_account_id'=>$creditNote->customer_suppiler_id,'credit_note_id'=>$id]);
	
		if(!empty($ReferenceDetails))
		{
			foreach($ReferenceDetails as $ReferenceDetail)
			{
				$ReferenceBalances[] = $this->CreditNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no]);
			}
		}
		else{
			$ReferenceBalances='';
		}	


        $customerSuppilers = $this->CreditNotes->CustomerSuppilers->find('list', ['limit' => 200]);
        $companies = $this->CreditNotes->Companies->find('list', ['limit' => 200]);
        $this->set(compact('creditNote', 'customerSuppilers', 'companies','heads','customer_suppiler_id','ReferenceDetails','financial_year'));
        $this->set('_serialize', ['creditNote']);			

	}	

	
	public function fetchRefNumbers($ledger_account_id){
		$this->viewBuilder()->layout('');
		$ReferenceBalances=$this->CreditNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$ledger_account_id]);
		$this->set(compact('ReferenceBalances','cr_dr'));
	}		

	function checkRefNumberUnique($received_from_id,$i){
		$reference_no=$this->request->query['ref_rows'][$i]['ref_no'];
		$ReferenceBalances=$this->CreditNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
		if($ReferenceBalances->count()==0){
			echo 'true';
		}else{
			echo 'false';
		}
		exit;
	}		
	
	
    /**
     * Delete method
     *
     * @param string|null $id Credit Note id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

	public function fetchRefNumbersEdit($received_from_id=null,$reference_no=null,$credit=null){
		$this->viewBuilder()->layout('');
		$ReferenceBalances=$this->CreditNotes->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
	    $this->set(compact('ReferenceBalances', 'reference_no', 'credit'));
	}	

	function deleteOneRefNumbers(){
		$old_received_from_id=$this->request->query['old_received_from_id'];
		$creditNote_id=$this->request->query['creditNote_id'];
		$old_ref=$this->request->query['old_ref'];
		$old_ref_type=$this->request->query['old_ref_type'];
		
		if($old_ref_type=="New Reference" || $old_ref_type=="Advance Reference"){
			$this->CreditNotes->ReferenceBalances->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
			$this->CreditNotes->ReferenceDetails->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
		}elseif($old_ref_type=="Against Reference"){
			$ReferenceDetail=$this->CreditNotes->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'credit_note_id'=>$creditNote_id,'reference_no'=>$old_ref])->first();
			if(!empty($ReferenceDetail->credit)){
				$ReferenceBalance=$this->CreditNotes->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
				$ReferenceBalance=$this->CreditNotes->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
				$this->CreditNotes->ReferenceBalances->save($ReferenceBalance);
			}elseif(!empty($ReferenceDetail->debit)){
				$ReferenceBalance=$this->CreditNotes->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
				$ReferenceBalance=$this->CreditNotes->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
				$this->CreditNotes->ReferenceBalances->save($ReferenceBalance);
			}
			$RDetail=$this->CreditNotes->ReferenceDetails->get($ReferenceDetail->id);
			$this->CreditNotes->ReferenceDetails->delete($RDetail);
		}
		
		exit;
	}	


	public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $creditNote = $this->CreditNotes->get($id);
        if ($this->CreditNotes->delete($creditNote)) {
            $this->Flash->success(__('The credit note has been deleted.'));
        } else {
            $this->Flash->error(__('The credit note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
