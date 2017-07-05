<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * JournalVouchers Controller
 *
 * @property \App\Model\Table\JournalVouchersTable $JournalVouchers
 */
class JournalVouchersController extends AppController
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
            'contain' => ['JournalVoucherRows']
        ];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$where = [];
		
		$vouch_no = $this->request->query('vouch_no');
		$From    = $this->request->query('From');
		$To    = $this->request->query('To');
		
		$this->set(compact('vouch_no','From','To'));
		
		if(!empty($vouch_no)){
			$where['JournalVouchers.voucher_no Like']=$vouch_no;
		}
		
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['JournalVouchers.transaction_date >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['JournalVouchers.transaction_date <=']=$To;
		}
		
       $journalVouchers = $this->paginate($this->JournalVouchers->find()->where($where)->where(['company_id'=>$st_company_id])->order(['transaction_date' => 'DESC']));

        $this->set('journalVoucher');
		$this->set(compact('journalVouchers'));
		$this->set('_serialize', ['journalVouchers']);
    }

    /**
     * View method
     *
     * @param string|null $id Journal Voucher id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		
		$this->viewBuilder()->layout('index_layout');
        $journalVoucher = $this->JournalVouchers->get($id, [
            'contain' => ['Companies','JournalVoucherRows'=>['ReceivedFroms'],'Companies','Creator']
        ]);
		//pr($journalVoucher);exit;
		$ref_bal=[];
		foreach($journalVoucher->journal_voucher_rows as $journal_voucher_row){
			$ReferenceBalancess=$this->JournalVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$journal_voucher_row->received_from_id,'journal_voucher_id'=>$journalVoucher->id]);
			$ref_bal[$journal_voucher_row->received_from_id]=$ReferenceBalancess->toArray();
		}
		//pr($ref_bal);exit;
        $this->set('journalVoucher', $journalVoucher);
		$this->set(compact('ref_bal'));
        $this->set('_serialize', ['journalVoucher']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		
		$this->viewBuilder()->layout('index_layout');
        $journalVoucher = $this->JournalVouchers->newEntity();
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $st_year_id = $session->read('st_year_id');
		$financial_year = $this->JournalVouchers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		
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
		
		if ($this->request->is('post')) {
			$last_ref_no=$this->JournalVouchers->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_ref_no){
				$journalVoucher->voucher_no=$last_ref_no->voucher_no+1;
			}else{
				$journalVoucher->voucher_no=1;
			}
            $journalVoucher = $this->JournalVouchers->patchEntity($journalVoucher, $this->request->data);
			
			$journalVoucher->created_by=$s_employee_id;
			$journalVoucher->transaction_date=date("Y-m-d",strtotime($journalVoucher->transaction_date));
			$journalVoucher->created_on=date("Y-m-d");
			$journalVoucher->company_id=$st_company_id;
			//pr($journalVoucher);  exit;
			if ($this->JournalVouchers->save($journalVoucher)) {
				$i=0;
				foreach($journalVoucher->journal_voucher_rows as $journal_voucher_row){
					
					$ledger = $this->JournalVouchers->Ledgers->newEntity();
					$ledger->ledger_account_id = $journal_voucher_row->received_from_id;
					if($journal_voucher_row->cr_dr=='Dr'){
						$ledger->debit = $journal_voucher_row->amount;
						$ledger->credit = 0;
					}
					else {
						$ledger->debit = 0;
						$ledger->credit = $journal_voucher_row->amount;
					}
					$ledger->company_id=$st_company_id;
					$ledger->voucher_id = $journalVoucher->id;
					$ledger->voucher_source = 'Journal Voucher';
					$ledger->transaction_date = date("Y-m-d",strtotime($journalVoucher->transaction_date));
					$ledger->company_id = $st_company_id;
					$this->JournalVouchers->Ledgers->save($ledger);
					
					$query = $this->JournalVouchers->JournalVoucherRows->query();
						$query->update()
							->set(['auto_inc' => $i])
							->where(['id' => $journal_voucher_row->id])
							->execute();
					
					if(sizeof(@$journalVoucher->ref_rows[$i])>0){
						foreach($journalVoucher->ref_rows[$i] as $ref_row){
							$ref_row=(object)$ref_row;
							
							if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
								$query = $this->JournalVouchers->ReferenceBalances->query();
								//pr($journal_voucher_row->received_from_id); exit;
								if($journal_voucher_row->cr_dr=="Dr"){
									$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit','auto_inc'])
									->values([
										'ledger_account_id' => $journal_voucher_row->received_from_id,
										'reference_no' => $ref_row->ref_no,
										'credit' => 0,
										'debit' => $ref_row->ref_amount,
										'auto_inc'=>$i
									])
									->execute();
								}else{
									$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit','auto_inc'])
									->values([
										'ledger_account_id' => $journal_voucher_row->received_from_id,
										'reference_no' => $ref_row->ref_no,
										'credit' => $ref_row->ref_amount,
										'debit' => 0,
										'auto_inc'=>$i
									])
									->execute();
								}
								
							}else{
								$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$journal_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
								$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->get($ReferenceBalance->id);
								if($journal_voucher_row->cr_dr=="Dr"){
									$ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
								}else{
									$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
								}
								$ReferenceBalance->auto_inc=$i;
								$this->JournalVouchers->ReferenceBalances->save($ReferenceBalance);
							}
							$query = $this->JournalVouchers->ReferenceDetails->query();
							if($journal_voucher_row->cr_dr=="Dr"){
								$query->insert(['ledger_account_id', 'journal_voucher_id', 'reference_no', 'credit', 'debit', 'reference_type','auto_inc'])
								->values([
									'ledger_account_id' => $journal_voucher_row->received_from_id,
									'journal_voucher_id' => $journalVoucher->id,
									'reference_no' => $ref_row->ref_no,
									'credit' => 0,
									'debit' => $ref_row->ref_amount,
									'reference_type' => $ref_row->ref_type,
									'auto_inc'=>$i
								])
								->execute();
							}else{
								$query->insert(['ledger_account_id', 'journal_voucher_id', 'reference_no', 'credit', 'debit', 'reference_type','auto_inc'])
								->values([
									'ledger_account_id' => $journal_voucher_row->received_from_id,
									'journal_voucher_id' => $journalVoucher->id,
									'reference_no' => $ref_row->ref_no,
									'credit' => $ref_row->ref_amount,
									'debit' => 0,
									'reference_type' => $ref_row->ref_type,
									'auto_inc'=>$i
								])
								->execute();
							}
							
						}
					}
					$i++;
					}
					$this->Flash->success(__('The Journal-Voucher:'.str_pad($journalVoucher->voucher_no, 4, '0', STR_PAD_LEFT)).' has been genereted.');
					return $this->redirect(['action' => 'view/'.$journalVoucher->id]);
            
				} 
			
           else {
                $this->Flash->error(__('The journal voucher could not be saved. Please, try again.'));
            }
		}
		$vr=$this->JournalVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Journal Voucher','sub_entity'=>'Ledger'])->first();
		$JournalVoucherLedger=$vr->id;
		$vouchersReferences = $this->JournalVouchers->VouchersReferences->get($vr->id, [
          'contain' => ['VoucherLedgerAccounts']
        ]);
		//pr($vouchersReferences); exit;
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		
		$companies = $this->JournalVouchers->Companies->find('all');
		
		$ReceivedFroms_selected='yes';
		if(sizeof($where)>0){
			$receivedFroms = $this->JournalVouchers->ReceivedFroms->find('list',
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
        $this->set(compact('journalVoucher', 'ledgers','companies','Errorledgers','financial_year','JournalVoucherLedger','receivedFroms','ReceivedFroms_selected','chkdate'));
        $this->set('_serialize', ['journalVoucher']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Journal Voucher id.
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
		$financial_year = $this->JournalVouchers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
    
        $journalVoucher = $this->JournalVouchers->get($id, [
            'contain' => ['Companies','JournalVoucherRows'=>['ReceivedFroms'],'Companies','Creator']
        ]);
		
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
		
		foreach($journalVoucher->journal_voucher_rows as $journal_voucher_row){
			$ReferenceDetails=$this->JournalVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$journal_voucher_row->received_from_id,'journal_voucher_id'=>$journalVoucher->id,'auto_inc'=>$journal_voucher_row->auto_inc]);
			
			foreach($ReferenceDetails as $ReferenceDetail){
				$old_reference_numbers[$journal_voucher_row->auto_inc]=$ReferenceDetail->reference_no;
			}
		//pr($journal_voucher_row->id); exit;
			$old_ref_rows[$journal_voucher_row->auto_inc]=$ReferenceDetails->toArray();
			$old_received_from_ids[]=$journal_voucher_row->received_from_id;
			
		} //exit;

	
		
        $Em = new FinancialYearsController;
	    $financial_year_data = $Em->checkFinancialYear($journalVoucher->transaction_date);


        if ($this->request->is(['patch', 'post', 'put'])) {
            $journalVoucher = $this->JournalVouchers->patchEntity($journalVoucher, $this->request->data);
			$journalVoucher->edited_by=$s_employee_id;
			$journalVoucher->transaction_date=date("Y-m-d",strtotime($journalVoucher->transaction_date));
			$journalVoucher->edited_on=date("Y-m-d");
			$journalVoucher->company_id=$st_company_id;
			$journalVoucher->created_by = $journalVoucher -> created_by;
			$journalVoucher->created_on = $journalVoucher -> created_on;
			if ($this->JournalVouchers->save($journalVoucher)) {
				
				$this->JournalVouchers->Ledgers->deleteAll(['voucher_id' => $journalVoucher->id, 'voucher_source' => 'Journal Voucher']);
				$total_cr=0; $total_dr=0;
				$i=0;
				foreach($journalVoucher->journal_voucher_rows as $journal_voucher_row){
					
					$ledger = $this->JournalVouchers->Ledgers->newEntity();
					$ledger->ledger_account_id = $journal_voucher_row->received_from_id;
					if($journal_voucher_row->cr_dr=="Dr"){
						$ledger->debit = $journal_voucher_row->amount;
						$ledger->credit = 0;
						$total_dr=$total_dr+$journal_voucher_row->amount;
					}else{
						$ledger->debit = 0;
						$ledger->credit = $journal_voucher_row->amount;
						$total_cr=$total_cr+$journal_voucher_row->amount;
					}
					$ledger->company_id=$st_company_id;
					$ledger->voucher_id = $journalVoucher->id;
					$ledger->voucher_source = 'Journal Voucher';
					$ledger->transaction_date = date("Y-m-d",strtotime($journalVoucher->transaction_date));
					$ledger->company_id = $st_company_id;
					$this->JournalVouchers->Ledgers->save($ledger);
					$query = $this->JournalVouchers->JournalVoucherRows->query();
					$query->update()
						->set(['auto_inc' => $i])
						->where(['id' => $journal_voucher_row->id])
						->execute();
					
					
					if(sizeof(@$journalVoucher->ref_rows[$i])>0){
						foreach($journalVoucher->ref_rows[$i] as $ref_row){
						$ref_row=(object)$ref_row;
						//pr($ref_row); exit;
						$ReferenceDetail=$this->JournalVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$journal_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no,'journal_voucher_id'=>$journalVoucher->id,'auto_inc'=>$i])->first();
						//pr($ReferenceDetail); exit;
						if($ReferenceDetail){
								$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$journal_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no,'auto_inc'=>$ReferenceDetail->auto_inc])->first();
								$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->get($ReferenceBalance->id);
								if($journal_voucher_row->cr_dr=="Dr"){
									$ReferenceBalance->debit=$ReferenceBalance->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								}else{
									$ReferenceBalance->credit=$ReferenceBalance->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								}
								$this->JournalVouchers->ReferenceBalances->save($ReferenceBalance);
								$ReferenceDetail=$this->JournalVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$journal_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no,'journal_voucher_id'=>$journalVoucher->id,$ReferenceDetail->auto_inc])->first();
								$ReferenceDetail=$this->JournalVouchers->ReferenceDetails->get($ReferenceDetail->id);
								if($journal_voucher_row->cr_dr=="Dr"){
									$ReferenceDetail->debit=$ReferenceDetail->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								}else{
									$ReferenceDetail->credit=$ReferenceDetail->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								}
								
								$this->JournalVouchers->ReferenceDetails->save($ReferenceDetail);
							}else{
								if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
									$query = $this->JournalVouchers->ReferenceBalances->query();
									if($journal_voucher_row->cr_dr=="Dr"){
										$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit','auto_inc'])
										->values([
											'ledger_account_id' => $journal_voucher_row->received_from_id,
											'reference_no' => $ref_row->ref_no,
											'credit' => 0,
											'debit' => $ref_row->ref_amount,
											'auto_inc'=>$i
										])
										->execute();
									}else{
										$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit','auto_inc'])
										->values([
											'ledger_account_id' => $journal_voucher_row->received_from_id,
											'reference_no' => $ref_row->ref_no,
											'credit' => $ref_row->ref_amount,
											'debit' => 0,
											'auto_inc'=>$i
										])
										->execute();
									}
									
								}else{
									$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$journal_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
									$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->get($ReferenceBalance->id);
									if($journal_voucher_row->cr_dr=="Dr"){
										$ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
									}else{
										$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
									}
									
									$this->JournalVouchers->ReferenceBalances->save($ReferenceBalance);
								}
								
								$query = $this->JournalVouchers->ReferenceDetails->query();
								if($journal_voucher_row->cr_dr=="Dr"){
									$query->insert(['ledger_account_id', 'journal_voucher_id', 'reference_no', 'credit', 'debit', 'reference_type','auto_inc'])
									->values([
										'ledger_account_id' => $journal_voucher_row->received_from_id,
										'journal_voucher_id' => $journalVoucher->id,
										'reference_no' => $ref_row->ref_no,
										'credit' => 0,
										'debit' => $ref_row->ref_amount,
										'reference_type' => $ref_row->ref_type,
										'auto_inc'=>$i
									])
									->execute();
								}else{
									$query->insert(['ledger_account_id', 'journal_voucher_id', 'reference_no', 'credit', 'debit', 'reference_type','auto_inc'])
									->values([
										'ledger_account_id' => $journal_voucher_row->received_from_id,
										'journal_voucher_id' => $journalVoucher->id,
										'reference_no' => $ref_row->ref_no,
										'credit' => $ref_row->ref_amount,
										'debit' => 0,
										'reference_type' => $ref_row->ref_type,
										'auto_inc'=>$i
									])
									->execute();
								}
								
							}
						}
					}
					$i++;
					}
					return $this->redirect(['action' => 'view/'.$journalVoucher->id]);
				} else {
                $this->Flash->error(__('The journal voucher could not be saved. Please, try again.'));
            }
        }
		
		$vr=$this->JournalVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Journal Voucher','sub_entity'=>'Ledger'])->first();
		$vouchersReferences = $this->JournalVouchers->VouchersReferences->get($vr->id, [
          'contain' => ['VoucherLedgerAccounts']
        ]);
		//pr($vouchersReferences); exit;
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}

		$ReceivedFroms_selected='yes';
		if(sizeof($where)>0){
			$receivedFroms = $this->JournalVouchers->ReceivedFroms->find('list',
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
				
		
        $companies = $this->JournalVouchers->Companies->find('all');
        $this->set(compact('journalVoucher','receivedFroms','ReceivedFroms_selected', 'companies','ledgers','financial_year','financial_year_data','old_ref_rows','chkdate'));
        $this->set('_serialize', ['journalVoucher']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Journal Voucher id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $journalVoucher = $this->JournalVouchers->get($id);
        if ($this->JournalVouchers->delete($journalVoucher)) {
            $this->Flash->success(__('The journal voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The journal voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function fetchRefNumbers($received_from_id=null,$cr_dr=null){
		$this->viewBuilder()->layout(''); 
		$ReferenceBalances=$this->JournalVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
		$this->set(compact('ReferenceBalances','cr_dr'));
	}
	
	function checkRefNumberUnique($received_from_id,$i){
		$reference_no=$this->request->query['ref_rows'][$received_from_id][$i]['ref_no'];
		$ReferenceBalances=$this->JournalVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
		if($ReferenceBalances->count()==0){
			echo 'true';
		}else{
			echo 'false';
		}
		exit;
	}
	function checkRefNumberUniqueEdit($received_from_id,$i,$is_old,$auto_inc){
		
		$reference_no=$this->request->query['ref_rows'][$auto_inc][$i]['ref_no'];
		$ReferenceBalances=$this->JournalVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no,'auto_inc'=>$auto_inc]);
		//$autow=$ReferenceBalances->count();
		if($ReferenceBalances->count()==1 && $is_old=="yes"){
			echo 'true';
		}elseif($ReferenceBalances->count()==0){
			echo 'true';
		}else{
			echo 'false';
		}
		exit;
	}
	function deleteOneRefNumbers(){
		$old_received_from_id=$this->request->query['old_received_from_id'];
		$journal_voucher_id=$this->request->query['journal_voucher_id'];
		$old_ref=$this->request->query['old_ref'];
		$old_ref_type=$this->request->query['old_ref_type'];
		$auto_inc=$this->request->query['auto_inc'];
		
		if($old_ref_type=="New Reference" || $old_ref_type=="Advance Reference"){
			$this->JournalVouchers->ReferenceBalances->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref,'auto_inc'=>$auto_inc]);
			$this->JournalVouchers->ReferenceDetails->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref,'auto_inc'=>$auto_inc]);
		}elseif($old_ref_type=="Against Reference"){
			$ReferenceDetail=$this->JournalVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'journal_voucher_id'=>$journal_voucher_id,'reference_no'=>$old_ref,'auto_inc'=>$auto_inc])->first();
			if(!empty($ReferenceDetail->credit)){
				$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no,'auto_inc'=>$auto_inc])->first();
				$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
				$this->JournalVouchers->ReferenceBalances->save($ReferenceBalance);
			}elseif(!empty($ReferenceDetail->debit)){
				$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no,'auto_inc'=>$auto_inc])->first();
				$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
				$this->JournalVouchers->ReferenceBalances->save($ReferenceBalance);
			}
			$RDetail=$this->JournalVouchers->ReferenceDetails->get($ReferenceDetail->id);
			$this->JournalVouchers->ReferenceDetails->delete($RDetail);
		}
		
		exit;
	}
	
	function deleteAllRefNumbers($old_received_from_id,$journal_voucher_id,$auto_inc){
		//$auto_inc=$this->request->query['auto_inc'];
		//pr($auto_inc); exit;
		$ReferenceDetails=$this->JournalVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'journal_voucher_id'=>$journal_voucher_id,'auto_inc'=>$auto_inc]);
		foreach($ReferenceDetails as $ReferenceDetail){
			if($ReferenceDetail->reference_type=="New Reference" || $ReferenceDetail->reference_type=="Advance Reference"){
				$this->JournalVouchers->ReferenceBalances->deleteAll(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no,'auto_inc'=>$auto_inc]);
				$RDetail=$this->JournalVouchers->ReferenceDetails->get($ReferenceDetail->id);
				$this->JournalVouchers->ReferenceDetails->delete($RDetail);
			}elseif($ReferenceDetail->reference_type=="Against Reference"){
				if(!empty($ReferenceDetail->credit)){
					$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no,'auto_inc'=>$auto_inc])->first();
					$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->get($ReferenceBalance->id);
					$ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
					$this->JournalVouchers->ReferenceBalances->save($ReferenceBalance);
				}elseif(!empty($ReferenceDetail->debit)){
					$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no,'auto_inc'=>$auto_inc])->first();
					$ReferenceBalance=$this->JournalVouchers->ReferenceBalances->get($ReferenceBalance->id);
					$ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
					$this->JournalVouchers->ReferenceBalances->save($ReferenceBalance);
				}
				$RDetail=$this->JournalVouchers->ReferenceDetails->get($ReferenceDetail->id);
				$this->JournalVouchers->ReferenceDetails->delete($RDetail);
			}
		}		exit;
	}
	
	public function fetchRefNumbersEdit($auto_inc=null,$reference_no=null,$debit=null,$credit=null,$cr_dr=null,$received_from_id=null){
		$this->viewBuilder()->layout('');// pr($reference_no);
		$ReferenceBalances=$this->JournalVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'auto_inc'=>$auto_inc,'reference_no'=>$reference_no]);
		$this->set(compact('ReferenceBalances', 'reference_no', 'debit','credit','cr_dr','received_from_id'));
	}
}
