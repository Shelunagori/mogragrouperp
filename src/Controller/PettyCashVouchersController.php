<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PettyCashVouchers Controller
 *
 * @property \App\Model\Table\PettyCashVouchersTable $PettyCashVouchers
 */
class PettyCashVouchersController extends AppController
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
        $pettycashvouchers = $this->paginate($this->PettyCashVouchers->find()->where(['company_id'=>$st_company_id])->contain(['PettyCashVoucherRows'])->order(['voucher_no'=>'DESC']));
        $this->set(compact('pettycashvouchers'));
        $this->set('_serialize', ['pettycashvouchers']);
    }

    /**
     * View method
     *
     * @param string|null $id Petty Cash Voucher id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->layout('index_layout');
        $pettycashvoucher = $this->PettyCashVouchers->get($id, [
            'contain' => ['BankCashes', 'Companies', 'PettyCashVoucherRows' => ['ReceivedFroms'], 'Creator']
        ]);
		//pr($pettycashvoucher);exit;
		$ref_bal=[];
		foreach($pettycashvoucher->petty_cash_voucher_rows as $petty_cash_voucher_row){
			$ReferenceBalancess=$this->PettyCashVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$petty_cash_voucher_row->received_from_id,'petty_cash_voucher_id'=>$pettycashvoucher->id]);
			$ref_bal[$petty_cash_voucher_row->received_from_id]=$ReferenceBalancess->toArray();
		}
		//pr($ref_bal);exit;
										
		$this->set(compact('ref_bal'));

        $this->set('pettycashvoucher', $pettycashvoucher);
        $this->set('_serialize', ['pettycashvoucher']);
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
        $financial_year = $this->PettyCashVouchers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
        
        $pettycashvoucher = $this->PettyCashVouchers->newEntity();

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
            $pettycashvoucher = $this->PettyCashVouchers->patchEntity($pettycashvoucher, $this->request->data);
            $pettycashvoucher->company_id=$st_company_id;
            //Voucher Number Increment
            $last_voucher_no=$this->PettyCashVouchers->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
            if($last_voucher_no){
                $pettycashvoucher->voucher_no=$last_voucher_no->voucher_no+1;
            }else{
                $pettycashvoucher->voucher_no=1;
            }
            
            $pettycashvoucher->created_on=date("Y-m-d");
            $pettycashvoucher->created_by=$s_employee_id;
            $pettycashvoucher->transaction_date=date("Y-m-d",strtotime($pettycashvoucher->transaction_date));
            //pr($pettycashvoucher); exit;
            if ($this->PettyCashVouchers->save($pettycashvoucher)) {
               $total_cr=0; $total_dr=0; $total_dr=0; $i=0;
                foreach($pettycashvoucher->petty_cash_voucher_rows as $petty_cash_voucher_row){

                    //Ledger posting for Received From Entity
                    $ledger = $this->PettyCashVouchers->Ledgers->newEntity();
                    $ledger->company_id=$st_company_id;
                    $ledger->ledger_account_id = $petty_cash_voucher_row->received_from_id;
                    if($petty_cash_voucher_row->cr_dr=="Dr"){
                        $ledger->debit = $petty_cash_voucher_row->amount;
                        $ledger->credit = 0;
                        $total_dr=$total_dr+$petty_cash_voucher_row->amount;
                    }else{
                        $ledger->debit = 0;
                        $ledger->credit = $petty_cash_voucher_row->amount;
                        $total_cr=$total_cr+$petty_cash_voucher_row->amount;
                    }
                    
                    $ledger->voucher_id = $pettycashvoucher->id;
                    $ledger->voucher_source = 'Petty Cash Payment Voucher';
                    $ledger->transaction_date = $pettycashvoucher->transaction_date;
                    $this->PettyCashVouchers->Ledgers->save($ledger);
					
					
					$query = $this->PettyCashVouchers->PettyCashVoucherRows->query();
						$query->update()
							->set(['auto_inc' => $i])
							->where(['id' => $petty_cash_voucher_row->id])
							->execute();
                    
                    $total_amount=$total_dr-$total_cr;
                    
                    //Reference Number coding
                    if(sizeof(@$pettycashvoucher->ref_rows[$i])>0){
                        
                        foreach($pettycashvoucher->ref_rows[$i] as $ref_row){

                            $ref_row=(object)$ref_row;
                            if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
                                $query = $this->PettyCashVouchers->ReferenceBalances->query();
                                if($petty_cash_voucher_row->cr_dr=="Dr"){
                                    $query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit','auto_inc'])
                                    ->values([
                                        'ledger_account_id' => $petty_cash_voucher_row->received_from_id,
                                        'reference_no' => $ref_row->ref_no,
                                        'credit' => 0,
                                        'debit' => $ref_row->ref_amount,
										'auto_inc'=>$i
                                    ])
                                    ->execute();
                                }else{
                                    $query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit','auto_inc'])
                                    ->values([
                                        'ledger_account_id' => $petty_cash_voucher_row->received_from_id,
                                        'reference_no' => $ref_row->ref_no,
                                        'credit' => $ref_row->ref_amount,
                                        'debit' => 0,
										'auto_inc'=>$i
                                    ])
                                    ->execute();
                                }
                                
                            }else{
                                $ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$petty_cash_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
                                $ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->get($ReferenceBalance->id);
                                if($petty_cash_voucher_row->cr_dr=="Dr"){
                                    $ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
                                }else{
                                    $ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
                                }
								$ReferenceBalance->auto_inc=$i;
                                $this->PettyCashVouchers->ReferenceBalances->save($ReferenceBalance);
                            }
                            
                            $query = $this->PettyCashVouchers->ReferenceDetails->query();
                            if($petty_cash_voucher_row->cr_dr=="Dr"){
                                $query->insert(['ledger_account_id', 'petty_cash_voucher_id', 'reference_no', 'credit', 'debit', 'reference_type','auto_inc'])
                                ->values([
                                    'ledger_account_id' => $petty_cash_voucher_row->received_from_id,
                                    'petty_cash_voucher_id' => $pettycashvoucher->id,
                                    'reference_no' => $ref_row->ref_no,
                                    'credit' => 0,
                                    'debit' => $ref_row->ref_amount,
                                    'reference_type' => $ref_row->ref_type,
									'auto_inc'=>$i
                                ])
                                ->execute();
                            }else{
                                $query->insert(['ledger_account_id', 'petty_cash_voucher_id', 'reference_no', 'credit', 'debit', 'reference_type','auto_inc'])
                                ->values([
                                    'ledger_account_id' => $petty_cash_voucher_row->received_from_id,
                                    'petty_cash_voucher_id' => $pettycashvoucher->id,
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
				$total_cr1=0; $total_dr1=0;
                foreach($pettycashvoucher->petty_cash_voucher_rows as $petty_cash_voucher_row){
                    if($petty_cash_voucher_row->cr_dr=="Dr"){
                        $total_dr1=$total_dr1+$petty_cash_voucher_row->amount;
                    }else{
                        $total_cr1=$total_cr1+$petty_cash_voucher_row->amount;
                    }
				}
               
                //Ledger posting for bankcash
                $ledger = $this->PettyCashVouchers->Ledgers->newEntity();
                $ledger->company_id=$st_company_id;
                $ledger->ledger_account_id = $pettycashvoucher->bank_cash_id;
                 if($total_dr1 > $total_cr1){
				 $ledger->credit = $total_dr1-$total_cr1;
				 $ledger->debit = 0;
				}else{
				 $ledger->debit = $total_cr1-$total_dr1;
				 $ledger->credit = 0;
				}
                $ledger->voucher_id = $pettycashvoucher->id;
                $ledger->voucher_source = 'Petty Cash Payment Voucher';
                $ledger->transaction_date = $pettycashvoucher->transaction_date;
                $this->PettyCashVouchers->Ledgers->save($ledger);
                
                $this->Flash->success(__('The petty cash has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The petty cash could not be saved. Please, try again.'));
            }
        }
        $vr=$this->PettyCashVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Petty Cash Payment','sub_entity'=>'Cash/Bank'])->first();
        $ReceiptVouchersCashBank=$vr->id;
        $vouchersReferences = $this->PettyCashVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
        $where=[];
        foreach($vouchersReferences->voucher_ledger_accounts as $data){
            $where[]=$data->ledger_account_id;
        }
        $BankCashes_selected='yes';
        if(sizeof($where)>0){
            $bankCashes = $this->PettyCashVouchers->BankCashes->find('list',
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
        //pr($bankCashes->toArray())    ; exit;
        
        $vr=$this->PettyCashVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Petty Cash Payment','sub_entity'=>'Paid To'])->first();
        $ReceiptVouchersReceivedFrom=$vr->id;
        $vouchersReferences = $this->PettyCashVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
        $where=[];
        foreach($vouchersReferences->voucher_ledger_accounts as $data){
            $where[]=$data->ledger_account_id;
        }
        $ReceivedFroms_selected='yes';
        if(sizeof($where)>0){
            $receivedFroms = $this->PettyCashVouchers->ReceivedFroms->find('list',
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
        $this->set(compact('pettycashvoucher', 'bankCashes', 'receivedFroms', 'financial_year', 'BankCashes_selected', 'ReceivedFroms_selected','chkdate'));
        $this->set('_serialize', ['pettycashvoucher']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Petty Cash Voucher id.
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
        $financial_year = $this->PettyCashVouchers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
        
        $pettycashvoucher = $this->PettyCashVouchers->get($id, [
            'contain' => ['PettyCashVoucherRows']
        ]);

        $old_ref_rows=[];
        $old_received_from_ids=[];
        $old_reference_numbers=[];

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

        
        foreach($pettycashvoucher->petty_cash_voucher_rows as $petty_cash_voucher_row){
            $ReferenceDetails=$this->PettyCashVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$petty_cash_voucher_row->received_from_id,'petty_cash_voucher_id'=>$pettycashvoucher->id,'auto_inc'=>$petty_cash_voucher_row->auto_inc]);
          

            foreach($ReferenceDetails as $ReferenceDetail){
            $old_reference_numbers[$petty_cash_voucher_row->auto_inc]=$ReferenceDetail->reference_no;
            }
            $old_ref_rows[$petty_cash_voucher_row->auto_inc]=$ReferenceDetails->toArray();
            $old_received_from_ids[]=$petty_cash_voucher_row->received_from_id;
        }
		//pr( $old_ref_rows); exit;
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pettycashvoucher = $this->PettyCashVouchers->patchEntity($pettycashvoucher, $this->request->data);
            $pettycashvoucher->company_id=$st_company_id;
            
            
            $pettycashvoucher->edited_on=date("Y-m-d");
            $pettycashvoucher->edited_by=$s_employee_id;
            $pettycashvoucher->transaction_date=date("Y-m-d",strtotime($pettycashvoucher->transaction_date));
                
            //Save receipt
            //pr($payment); exit;
            if ($this->PettyCashVouchers->save($pettycashvoucher)) {
                $this->PettyCashVouchers->Ledgers->deleteAll(['voucher_id' => $pettycashvoucher->id, 'voucher_source' => 'Petty Cash Payment Voucher']);
                $total_cr=0; $total_dr=0; $i=0;
                foreach($pettycashvoucher->petty_cash_voucher_rows as $petty_cash_voucher_row){
                    //Ledger posting for Received From Entity
                    $ledger = $this->PettyCashVouchers->Ledgers->newEntity();
                    $ledger->company_id=$st_company_id;
                    $ledger->ledger_account_id = $petty_cash_voucher_row->received_from_id;
                    if($petty_cash_voucher_row->cr_dr=="Dr"){
                        $ledger->debit = $petty_cash_voucher_row->amount;
                        $ledger->credit = 0;
                        $total_dr=$total_dr+$petty_cash_voucher_row->amount;
                    }else{
                        $ledger->debit = 0;
                        $ledger->credit = $petty_cash_voucher_row->amount;
                        $total_cr=$total_cr+$petty_cash_voucher_row->amount;
                    }
                    $ledger->voucher_id = $pettycashvoucher->id;
                    $ledger->voucher_source = 'Petty Cash Payment Voucher';
                    $ledger->transaction_date = $pettycashvoucher->transaction_date;
                    $this->PettyCashVouchers->Ledgers->save($ledger);
                    
					$query = $this->PettyCashVouchers->PettyCashVoucherRows->query();
						$query->update()
							->set(['auto_inc' => $i])
							->where(['id' => $petty_cash_voucher_row->id])
							->execute();
                    $total_amount=$total_dr-$total_cr;
                    
                    //Reference Number coding
                   if(sizeof(@$pettycashvoucher->ref_rows[$i])>0){
                        
                        foreach($pettycashvoucher->ref_rows[$i] as $ref_row){
                            $ref_row=(object)$ref_row;
                            $ReferenceDetail=$this->PettyCashVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$petty_cash_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no,'petty_cash_voucher_id'=>$pettycashvoucher->id,'auto_inc'=>$i])->first();
                            
                            if($ReferenceDetail){
                                $ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$petty_cash_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no,'auto_inc'=>$ReferenceDetail->auto_inc])->first();
                                $ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->get($ReferenceBalance->id);
                                if($petty_cash_voucher_row->cr_dr=="Dr"){
                                    $ReferenceBalance->debit=$ReferenceBalance->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
                                }else{
                                    $ReferenceBalance->credit=$ReferenceBalance->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
                                }
                                
                                $this->PettyCashVouchers->ReferenceBalances->save($ReferenceBalance);
                                
                                $ReferenceDetail=$this->PettyCashVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$petty_cash_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no,'petty_cash_voucher_id'=>$pettycashvoucher->id,'auto_inc'=>$ReferenceDetail->auto_inc])->first();
                                $ReferenceDetail=$this->PettyCashVouchers->ReferenceDetails->get($ReferenceDetail->id);
                                if($petty_cash_voucher_row->cr_dr=="Dr"){
                                    $ReferenceDetail->debit=$ReferenceDetail->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
                                }else{
                                    $ReferenceDetail->credit=$ReferenceDetail->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
                                }
                                
                                $this->PettyCashVouchers->ReferenceDetails->save($ReferenceDetail);
                            }else{
                                if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
                                    $query = $this->PettyCashVouchers->ReferenceBalances->query();
                                    if($petty_cash_voucher_row->cr_dr=="Dr"){
                                        $query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit','auto_inc'])
                                        ->values([
                                            'ledger_account_id' => $petty_cash_voucher_row->received_from_id,
                                            'reference_no' => $ref_row->ref_no,
                                            'credit' => 0,
                                            'debit' => $ref_row->ref_amount,
											'auto_inc'=>$i
                                        ])
                                        ->execute();
                                    }else{
                                        $query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit','auto_inc'])
                                        ->values([
                                            'ledger_account_id' => $petty_cash_voucher_row->received_from_id,
                                            'reference_no' => $ref_row->ref_no,
                                            'credit' => $ref_row->ref_amount,
                                            'debit' => 0,
											'auto_inc'=>$i
                                        ])
                                        ->execute();
                                    }
                                    
                                }else{
									//pr(['ledger_account_id'=>$petty_cash_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no,'auto_inc'=>$i]); exit;
                                    $ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$petty_cash_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
                                    $ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->get($ReferenceBalance->id);
                                    if($petty_cash_voucher_row->cr_dr=="Dr"){
                                        $ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
                                    }else{
                                        $ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
                                    }
                                    
                                    $this->PettyCashVouchers->ReferenceBalances->save($ReferenceBalance);
                                }
                                
                                $query = $this->PettyCashVouchers->ReferenceDetails->query();
                                if($petty_cash_voucher_row->cr_dr=="Dr"){
                                    $query->insert(['ledger_account_id', 'petty_cash_voucher_id', 'reference_no', 'credit', 'debit', 'reference_type','auto_inc'])
                                    ->values([
                                        'ledger_account_id' => $petty_cash_voucher_row->received_from_id,
                                        'petty_cash_voucher_id' => $pettycashvoucher->id,
                                        'reference_no' => $ref_row->ref_no,
                                        'credit' => 0,
                                        'debit' => $ref_row->ref_amount,
                                        'reference_type' => $ref_row->ref_type,
										'auto_inc'=>$i
                                    ])
                                    ->execute();
                                }else{
                                    $query->insert(['ledger_account_id', 'petty_cash_voucher_id', 'reference_no', 'credit', 'debit', 'reference_type','auto_inc'])
                                    ->values([
                                        'ledger_account_id' => $petty_cash_voucher_row->received_from_id,
                                        'petty_cash_voucher_id' => $pettycashvoucher->id,
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
                //Ledger posting for bankcash
                $total_cr1=0; $total_dr1=0;
                foreach($pettycashvoucher->petty_cash_voucher_rows as $petty_cash_voucher_row){
                    if($petty_cash_voucher_row->cr_dr=="Dr"){
                        $total_dr1=$total_dr1+$petty_cash_voucher_row->amount;
                    }else{
                        $total_cr1=$total_cr1+$petty_cash_voucher_row->amount;
                    }
				}
                $ledger = $this->PettyCashVouchers->Ledgers->newEntity();
                $ledger->company_id=$st_company_id;
                $ledger->ledger_account_id = $pettycashvoucher->bank_cash_id;
                 if($total_dr1 > $total_cr1){
				 $ledger->credit = $total_dr1-$total_cr1;
				 $ledger->debit = 0;
				}else{
				 $ledger->debit = $total_cr1-$total_dr1;
				 $ledger->credit = 0;
				}
                $ledger->voucher_id = $pettycashvoucher->id;
                $ledger->voucher_source = 'Petty Cash Payment Voucher';
                $ledger->transaction_date = $pettycashvoucher->transaction_date;
                $this->PettyCashVouchers->Ledgers->save($ledger);
                
                $this->Flash->success(__('The receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
            }
        }
       
        $vr=$this->PettyCashVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Petty Cash Payment','sub_entity'=>'Cash/Bank'])->first();
        $ReceiptVouchersCashBank=$vr->id;
        $vouchersReferences = $this->PettyCashVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
        $where=[];
        foreach($vouchersReferences->voucher_ledger_accounts as $data){
            $where[]=$data->ledger_account_id;
        }
        $BankCashes_selected='yes';
        if(sizeof($where)>0){
            $bankCashes = $this->PettyCashVouchers->BankCashes->find('list',
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
        
        $vr=$this->PettyCashVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Petty Cash Payment','sub_entity'=>'Paid To'])->first();
        $ReceiptVouchersReceivedFrom=$vr->id;
        $vouchersReferences = $this->PettyCashVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
        $where=[];
        foreach($vouchersReferences->voucher_ledger_accounts as $data){
            $where[]=$data->ledger_account_id;
        }

        $ReceivedFroms_selected='yes';
        if(sizeof($where)>0){
            $receivedFroms = $this->PettyCashVouchers->ReceivedFroms->find('list',
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
         //pr($pettycashvoucher); exit;
        $this->set(compact('pettycashvoucher', 'bankCashes', 'receivedFroms', 'financial_year', 'BankCashes_selected', 'ReceivedFroms_selected', 'old_ref_rows','chkdate'));
        $this->set('_serialize', ['pettycashvoucher']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Petty Cash Voucher id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pettycashvoucher = $this->PettyCashVouchers->get($id);
        if ($this->PettyCashVouchers->delete($pettycashvoucher)) {
            $this->Flash->success(__('The petty cash voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The petty cash voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function fetchRefNumbers($received_from_id=null,$cr_dr=null){
        $this->viewBuilder()->layout('');
        $ReferenceBalances=$this->PettyCashVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
        $this->set(compact('ReferenceBalances','cr_dr'));
    }
    
  public function fetchRefNumbersEdit($auto_inc=null,$reference_no=null,$debit=null,$credit=null,$cr_dr=null,$received_from_id=null){
		$this->viewBuilder()->layout('');// pr($reference_no);
		$ReferenceBalances=$this->PettyCashVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'auto_inc'=>$auto_inc,'reference_no'=>$reference_no]);
		$this->set(compact('ReferenceBalances', 'reference_no', 'debit','credit','cr_dr','received_from_id'));
	}
    
   	function checkRefNumberUnique($received_from_id,$i,$is_old,$auto_inc){
		$reference_no=$this->request->query['ref_rows'][$auto_inc][$i]['ref_no'];
		$ReferenceBalances=$this->PettyCashVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
		if($ReferenceBalances->count()==0){
			echo 'true';
		}else{
			echo 'false';
		}
		exit;
	}
	
    
    function checkRefNumberUniqueEdit($received_from_id,$i,$is_old,$auto_inc){
        $reference_no=$this->request->query['ref_rows'][$auto_inc][$i]['ref_no'];
        $ReferenceBalances=$this->PettyCashVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
        if($ReferenceBalances->count()==1 && $is_old=="yes"){
            echo 'true';
        }elseif($ReferenceBalances->count()==0){
            echo 'true';
        }else{
            echo 'false';
        }
        exit;
    }
    
	function deleteAllRefNumbers($old_received_from_id,$petty_cash_voucher_id,$auto_inc){
		//$auto_inc=$this->request->query['auto_inc'];
		//pr($auto_inc); exit;
		$ReferenceDetails=$this->PettyCashVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'petty_cash_voucher_id'=>$petty_cash_voucher_id,'auto_inc'=>$auto_inc]);
		foreach($ReferenceDetails as $ReferenceDetail){
			if($ReferenceDetail->reference_type=="New Reference" || $ReferenceDetail->reference_type=="Advance Reference"){
				$this->PettyCashVouchers->ReferenceBalances->deleteAll(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no,'auto_inc'=>$auto_inc]);
				$RDetail=$this->PettyCashVouchers->ReferenceDetails->get($ReferenceDetail->id);
				$this->PettyCashVouchers->ReferenceDetails->delete($RDetail);
			}elseif($ReferenceDetail->reference_type=="Against Reference"){
				if(!empty($ReferenceDetail->credit)){
					$ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no,'auto_inc'=>$auto_inc])->first();
					$ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->get($ReferenceBalance->id);
					$ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
					$this->PettyCashVouchers->ReferenceBalances->save($ReferenceBalance);
				}elseif(!empty($ReferenceDetail->debit)){
					$ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no,'auto_inc'=>$auto_inc])->first();
					$ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->get($ReferenceBalance->id);
					$ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
					$this->PettyCashVouchers->ReferenceBalances->save($ReferenceBalance);
				}
				$RDetail=$this->PettyCashVouchers->ReferenceDetails->get($ReferenceDetail->id);
				$this->PettyCashVouchers->ReferenceDetails->delete($RDetail);
			}
		}		exit;
	}
    

	function deleteOneRefNumbers(){
		$old_received_from_id=$this->request->query['old_received_from_id'];
		$petty_cash_voucher_id=$this->request->query['petty_cash_voucher_id'];
		$old_ref=$this->request->query['old_ref'];
		$old_ref_type=$this->request->query['old_ref_type'];
		$auto_inc=$this->request->query['auto_inc'];
		
		if($old_ref_type=="New Reference" || $old_ref_type=="Advance Reference"){
			$this->PettyCashVouchers->ReferenceBalances->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref,'auto_inc'=>$auto_inc]);
			$this->PettyCashVouchers->ReferenceDetails->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref,'auto_inc'=>$auto_inc]);
		}elseif($old_ref_type=="Against Reference"){
			$ReferenceDetail=$this->PettyCashVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'petty_cash_voucher_id'=>$petty_cash_voucher_id,'reference_no'=>$old_ref,'auto_inc'=>$auto_inc])->first();
			if(!empty($ReferenceDetail->credit)){
				$ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no,'auto_inc'=>$auto_inc])->first();
				$ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
				$this->PettyCashVouchers->ReferenceBalances->save($ReferenceBalance);
			}elseif(!empty($ReferenceDetail->debit)){
				$ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no,'auto_inc'=>$auto_inc])->first();
				$ReferenceBalance=$this->PettyCashVouchers->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
				$this->PettyCashVouchers->ReferenceBalances->save($ReferenceBalance);
			}
			$RDetail=$this->PettyCashVouchers->ReferenceDetails->get($ReferenceDetail->id);
			$this->PettyCashVouchers->ReferenceDetails->delete($RDetail);
		}
		
		exit;
	}


}
