<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ContraVouchers Controller
 *
 * @property \App\Model\Table\ContraVouchersTable $contraVoucher
 */
class ContraVouchersController extends AppController
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
        
        
        $contravouchers = $this->paginate($this->ContraVouchers->find()->where(['company_id'=>$st_company_id])->contain(['ContraVoucherRows'=>function($q){
            $ContraVoucherRows = $this->ContraVouchers->ContraVoucherRows->find();
            $totalCrCase = $ContraVoucherRows->newExpr()
                ->addCase(
                    $ContraVoucherRows->newExpr()->add(['cr_dr' => 'Cr']),
                    $ContraVoucherRows->newExpr()->add(['amount']),
                    'integer'
                );
            $totalDrCase = $ContraVoucherRows->newExpr()
                ->addCase(
                    $ContraVoucherRows->newExpr()->add(['cr_dr' => 'Dr']),
                    $ContraVoucherRows->newExpr()->add(['amount']),
                    'integer'
                );
            return $ContraVoucherRows->select([
                    'total_cr' => $ContraVoucherRows->func()->sum($totalCrCase),
                    'total_dr' => $ContraVoucherRows->func()->sum($totalDrCase)
                ])
                ->group('contra_voucher_id')
                
                ->autoFields(true);
            
        }])->order(['voucher_no'=>'DESC']));
        

        $this->set(compact('contravouchers'));
        $this->set('_serialize', ['contravouchers']);
    }

    /**
     * View method
     *
     * @param string|null $id Contra Voucher id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->layout('index_layout');
        $contravoucher = $this->ContraVouchers->get($id, [
            'contain' => ['BankCashes', 'Companies', 'ContraVoucherRows' => ['ReceivedFroms'], 'Creator']
        ]);
		//pr($contravoucher);exit;
		$ref_bal=[];
		foreach($contravoucher->contra_voucher_rows as $contra_voucher_row){
			$ReferenceBalancess=$this->ContraVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$contra_voucher_row->received_from_id,'contra_voucher_id'=>$contra_voucher_row->id]);
			$ref_bal[$contra_voucher_row->received_from_id]=$ReferenceBalancess->toArray();
		}
		//pr($ref_bal);exit;
										
		$this->set(compact('ref_bal'));
        $this->set('contravoucher', $contravoucher);
        $this->set('_serialize', ['contravoucher']);
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
        $financial_year = $this->ContraVouchers->FinancialYears->find()->where(['id'=>$st_year_id])->first();

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
				 {   $chkdate = 'Found'; }
				 else
				 {   $chkdate = 'Not Found'; }

			   }
			   else
				{
					 $chkdate = 'Not Found';	
				}
       
        $contravoucher = $this->ContraVouchers->newEntity();
        
        if ($this->request->is('post')) {
            $contravoucher = $this->ContraVouchers->patchEntity($contravoucher, $this->request->data);
            

			
			$contravoucher->company_id=$st_company_id;
            //Voucher Number Increment
            $last_voucher_no=$this->ContraVouchers->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
            if($last_voucher_no){
                $contravoucher->voucher_no=$last_voucher_no->voucher_no+1;
            }else{
                $contravoucher->voucher_no=1;
            }
            
            $contravoucher->created_on=date("Y-m-d");
            $contravoucher->created_by=$s_employee_id;
            $contravoucher->transaction_date=date("Y-m-d",strtotime($contravoucher->transaction_date));
            
            if ($this->ContraVouchers->save($contravoucher)) {
                $total_cr=0; $total_dr=0;
               
                foreach($contravoucher->contra_voucher_rows as $contra_voucher_row){
                    
                    //Ledger posting for Received From Entity
                    $ledger = $this->ContraVouchers->Ledgers->newEntity();
                    $ledger->company_id=$st_company_id;
                    $ledger->ledger_account_id = $contra_voucher_row->received_from_id;
                    if($contra_voucher_row->cr_dr=="Dr"){
                        $ledger->debit = $contra_voucher_row->amount;
                        $ledger->credit = 0;
                        $total_dr=$total_dr+$contra_voucher_row->amount;
                    }else{
                        $ledger->debit = 0;
                        $ledger->credit = $contra_voucher_row->amount;
                        $total_cr=$total_cr+$contra_voucher_row->amount;
                    }
                    
                    $ledger->voucher_id = $contravoucher->id;
                    $ledger->voucher_source = 'Contra Voucher';
                    $ledger->transaction_date = $contravoucher->transaction_date;
                    $this->ContraVouchers->Ledgers->save($ledger);
                    
                    $total_amount=$total_dr-$total_cr;
                    
                    //Reference Number coding
                    if(sizeof(@$contravoucher->ref_rows[$contra_voucher_row->received_from_id])>0){
                        
                        foreach($contravoucher->ref_rows[$contra_voucher_row->received_from_id] as $ref_row){ 
                            $ref_row=(object)$ref_row;
                            if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
                                $query = $this->ContraVouchers->ReferenceBalances->query();
                                if($contra_voucher_row->cr_dr=="Dr"){
                                    $query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
                                    ->values([
                                        'ledger_account_id' => $contra_voucher_row->received_from_id,
                                        'reference_no' => $ref_row->ref_no,
                                        'credit' => 0,
                                        'debit' => $ref_row->ref_amount
                                    ])
                                    ->execute();
                                }else{
                                    $query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
                                    ->values([
                                    'ledger_account_id' => $contra_voucher_row->received_from_id,
                                    'reference_no' => $ref_row->ref_no,
                                    'credit' => $ref_row->ref_amount,
                                    'debit' => 0
                                    ])
                                    ->execute();
                                }
                                
                            }else{
                                $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$contra_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
                                $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->get($ReferenceBalance->id);
                                if($contra_voucher_row->cr_dr=="Dr"){
                                    $ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
                                }else{
                                    $ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
                                }
                                
                                $this->ContraVouchers->ReferenceBalances->save($ReferenceBalance);
                            }
                            
                            $query = $this->ContraVouchers->ReferenceDetails->query();
                            if($contra_voucher_row->cr_dr=="Dr"){
                                $query->insert(['ledger_account_id', 'contra_voucher_id', 'reference_no', 'credit', 'debit', 'reference_type'])
                                ->values([
                                    'ledger_account_id' => $contra_voucher_row->received_from_id,
                                    'contra_voucher_id' => $contravoucher->id,
                                    'reference_no' => $ref_row->ref_no,
                                    'credit' => 0,
                                    'debit' => $ref_row->ref_amount,
                                    'reference_type' => $ref_row->ref_type
                                ])
                                ->execute();
                            }else{
                                $query->insert(['ledger_account_id', 'contra_voucher_id', 'reference_no', 'credit', 'debit', 'reference_type'])
                                ->values([
                                    'ledger_account_id' => $contra_voucher_row->received_from_id,
                                    'contra_voucher_id' => $contravoucher->id,
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
                $ledger = $this->ContraVouchers->Ledgers->newEntity();
                $ledger->company_id=$st_company_id;
                $ledger->ledger_account_id = $contravoucher->bank_cash_id;
                $ledger->debit = 0;
                $ledger->credit = $total_amount;
                $ledger->voucher_id = $contravoucher->id;
                $ledger->voucher_source = 'Contra Voucher';
                $ledger->transaction_date = $contravoucher->transaction_date;
                $this->ContraVouchers->Ledgers->save($ledger);
                
                $this->Flash->success(__('The contra voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The contra voucher could not be saved. Please, try again.'));
            }
        }
        $vr=$this->ContraVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Contra Voucher','sub_entity'=>'Cash/Bank'])->first();
        $ReceiptVouchersCashBank=$vr->id;
        $vouchersReferences = $this->ContraVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
        $where=[];
        foreach($vouchersReferences->voucher_ledger_accounts as $data){
            $where[]=$data->ledger_account_id;
        }
        $BankCashes_selected='yes';
        if(sizeof($where)>0){
            $bankCashes = $this->ContraVouchers->BankCashes->find('list',
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
        
        $vr=$this->ContraVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Contra Voucher','sub_entity'=>'Paid To'])->first();
        $ReceiptVouchersReceivedFrom=$vr->id;
        $vouchersReferences = $this->ContraVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
        $where=[];
        foreach($vouchersReferences->voucher_ledger_accounts as $data){
            $where[]=$data->ledger_account_id;
        }
        $ReceivedFroms_selected='yes';
        if(sizeof($where)>0){
            $receivedFroms = $this->ContraVouchers->ReceivedFroms->find('list',
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
        $this->set(compact('contravoucher', 'bankCashes', 'receivedFroms', 'financial_year', 'BankCashes_selected', 'ReceivedFroms_selected','chkdate'));
        $this->set('_serialize', ['contravoucher']);

    }

    /**
     * Edit method
     *
     * @param string|null $id Contra Voucher id.
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
    $financial_year = $this->ContraVouchers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
        
        $contravoucher = $this->ContraVouchers->get($id, [
            'contain' => ['ContraVoucherRows']
        ]);
        $old_ref_rows=[];
        $old_received_from_ids=[];
        $old_reference_numbers=[];

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

        
        foreach($contravoucher->contra_voucher_rows as $contra_voucher_row){
            $ReferenceDetails=$this->ContraVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$contra_voucher_row->received_from_id,'contra_voucher_id'=>$contravoucher->id]);
            foreach($ReferenceDetails as $ReferenceDetail){
                $old_reference_numbers[$contra_voucher_row->received_from_id][]=$ReferenceDetail->reference_no;
            }
            $old_ref_rows[$contra_voucher_row->received_from_id]=$ReferenceDetails->toArray();
            $old_received_from_ids[]=$contra_voucher_row->received_from_id;
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contravoucher = $this->ContraVouchers->patchEntity($contravoucher, $this->request->data);
            $contravoucher->company_id=$st_company_id;
            
            
            $contravoucher->edited_on=date("Y-m-d");
            $contravoucher->edited_by=$s_employee_id;
            $contravoucher->transaction_date=date("Y-m-d",strtotime($contravoucher->transaction_date));
                
            //Save receipt
            //pr($payment); exit;
            if ($this->ContraVouchers->save($contravoucher)) {
                $this->ContraVouchers->Ledgers->deleteAll(['voucher_id' => $contravoucher->id, 'voucher_source' => 'Payment Voucher']);
                $total_cr=0; $total_dr=0;
                foreach($contravoucher->contra_voucher_rows as $contra_voucher_row){
                    
                    //Ledger posting for Received From Entity
                    $ledger = $this->ContraVouchers->Ledgers->newEntity();
                    $ledger->company_id=$st_company_id;
                    $ledger->ledger_account_id = $contra_voucher_row->received_from_id;
                    if($contra_voucher_row->cr_dr=="Dr"){
                        $ledger->debit = $contra_voucher_row->amount;
                        $ledger->credit = 0;
                        $total_dr=$total_dr+$contra_voucher_row->amount;
                    }else{
                        $ledger->debit = 0;
                        $ledger->credit = $contra_voucher_row->amount;
                        $total_cr=$total_cr+$contra_voucher_row->amount;
                    }
                    $ledger->voucher_id = $contravoucher->id;
                    $ledger->voucher_source = 'Contra Voucher';
                    $ledger->transaction_date = $contravoucher->transaction_date;
                    $this->ContraVouchers->Ledgers->save($ledger);
                    
                    $total_amount=$total_dr-$total_cr;
                    
                    //Reference Number coding
                    if(sizeof(@$contravoucher->ref_rows[$contra_voucher_row->received_from_id])>0){
                     foreach($contravoucher->ref_rows[$contra_voucher_row->received_from_id] as $ref_row){
                            $ref_row=(object)$ref_row;
                            $ReferenceDetail=$this->ContraVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$contra_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no,'payment_id'=>$contravoucher->id])->first();
                            
                            if($ReferenceDetail){
                                $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$contra_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
                                $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->get($ReferenceBalance->id);
                                if($contra_voucher_row->cr_dr=="Dr"){
                                    $ReferenceBalance->debit=$ReferenceBalance->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
                                }else{
                                    $ReferenceBalance->credit=$ReferenceBalance->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
                                }
                                
                                $this->ContraVouchers->ReferenceBalances->save($ReferenceBalance);
                                
                                $ReferenceDetail=$this->ContraVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$contra_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no,'contra_voucher_id'=>$contravoucher->id])->first();
                                $ReferenceDetail=$this->ContraVouchers->ReferenceDetails->get($ReferenceDetail->id);
                                if($contra_voucher_row->cr_dr=="Dr"){
                                    $ReferenceDetail->debit=$ReferenceDetail->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
                                }else{
                                    $ReferenceDetail->credit=$ReferenceDetail->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
                                }
                                
                                $this->ContraVouchers->ReferenceDetails->save($ReferenceDetail);
                            }else{
                                if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
                                    $query = $this->ContraVouchers->ReferenceBalances->query();
                                    if($contra_voucher_row->cr_dr=="Dr"){
                                        $query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
                                        ->values([
                                            'ledger_account_id' => $contra_voucher_row->received_from_id,
                                            'reference_no' => $ref_row->ref_no,
                                            'credit' => 0,
                                            'debit' => $ref_row->ref_amount
                                        ])
                                        ->execute();
                                    }else{
                                        $query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
                                        ->values([
                                            'ledger_account_id' => $contra_voucher_row->received_from_id,
                                            'reference_no' => $ref_row->ref_no,
                                            'credit' => $ref_row->ref_amount,
                                            'debit' => 0
                                        ])
                                        ->execute();
                                    }
                                    
                                }else{
                                    $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$contra_voucher_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
                                    $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->get($ReferenceBalance->id);
                                    if($contra_voucher_row->cr_dr=="Dr"){
                                        $ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
                                    }else{
                                        $ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
                                    }
                                    
                                    $this->ContraVouchers->ReferenceBalances->save($ReferenceBalance);
                                }
                                
                                $query = $this->ContraVouchers->ReferenceDetails->query();
                                if($contra_voucher_row->cr_dr=="Dr"){
                                    $query->insert(['ledger_account_id', 'contra_voucher_id', 'reference_no', 'credit', 'debit', 'reference_type'])
                                    ->values([
                                        'ledger_account_id' => $contra_voucher_row->received_from_id,
                                        'contra_voucher_id' => $contravoucher->id,
                                        'reference_no' => $ref_row->ref_no,
                                        'credit' => 0,
                                        'debit' => $ref_row->ref_amount,
                                        'reference_type' => $ref_row->ref_type
                                    ])
                                    ->execute();
                                }else{
                                    $query->insert(['ledger_account_id', 'contra_voucher_id', 'reference_no', 'credit', 'debit', 'reference_type'])
                                    ->values([
                                        'ledger_account_id' => $contra_voucher_row->received_from_id,
                                        'contra_voucher_id' => $contravoucher->id,
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
                $ledger = $this->ContraVouchers->Ledgers->newEntity();
                $ledger->company_id=$st_company_id;
                $ledger->ledger_account_id = $contravoucher->bank_cash_id;
                $ledger->debit = 0;
                $ledger->credit = $total_amount;
                $ledger->voucher_id = $contravoucher->id;
                $ledger->voucher_source = 'Contra Voucher';
                $ledger->transaction_date = $contravoucher->transaction_date;
                $this->ContraVouchers->Ledgers->save($ledger);
                
                $this->Flash->success(__('The receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
            }
        }
        
        $vr=$this->ContraVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Contra Voucher','sub_entity'=>'Cash/Bank'])->first();
        $ReceiptVouchersCashBank=$vr->id;
        $vouchersReferences = $this->ContraVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
        $where=[];
        foreach($vouchersReferences->voucher_ledger_accounts as $data){
            $where[]=$data->ledger_account_id;
        }
        $BankCashes_selected='yes';
        if(sizeof($where)>0){
            $bankCashes = $this->ContraVouchers->BankCashes->find('list',
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
        
        $vr=$this->ContraVouchers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Contra Voucher','sub_entity'=>'Paid To'])->first();
        $ReceiptVouchersReceivedFrom=$vr->id;
        $vouchersReferences = $this->ContraVouchers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
        $where=[];
        foreach($vouchersReferences->voucher_ledger_accounts as $data){
            $where[]=$data->ledger_account_id;
        }
        $ReceivedFroms_selected='yes';
        if(sizeof($where)>0){
            $receivedFroms = $this->ContraVouchers->ReceivedFroms->find('list',
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
        
        $this->set(compact('contravoucher', 'bankCashes', 'receivedFroms', 'financial_year', 'BankCashes_selected', 'ReceivedFroms_selected', 'old_ref_rows','chkdate'));
        $this->set('_serialize', ['contravoucher']);

    }

    /**
     * Delete method
     *
     * @param string|null $id Contra Voucher id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */


    public function fetchRefNumbers($received_from_id=null,$cr_dr=null){
        $this->viewBuilder()->layout('');
        $ReferenceBalances=$this->ContraVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
        $this->set(compact('ReferenceBalances','cr_dr'));
    }
    
    public function fetchRefNumbersEdit($received_from_id=null,$reference_no=null,$debit=null,$credit=null,$cr_dr=null){
        $this->viewBuilder()->layout('');
        $ReferenceBalances=$this->ContraVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
        $this->set(compact('ReferenceBalances', 'reference_no', 'credit', 'debit', 'cr_dr'));
    }
    
    function checkRefNumberUnique($received_from_id,$i){
        $reference_no=$this->request->query['ref_rows'][$received_from_id][$i]['ref_no'];
        $ReferenceBalances=$this->ContraVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
        if($ReferenceBalances->count()==0){
            echo 'true';
        }else{
            echo 'false';
        }
        exit;
    }
    
    function checkRefNumberUniqueEdit($received_from_id,$i,$is_old){
        $reference_no=$this->request->query['ref_rows'][$received_from_id][$i]['ref_no'];
        $ReferenceBalances=$this->ContraVouchers->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
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
        $ReferenceDetails=$this->ContraVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'receipt_id'=>$receipt_id]);
        foreach($ReferenceDetails as $ReferenceDetail){
            if($ReferenceDetail->reference_type=="New Reference" || $ReferenceDetail->reference_type=="Advance Reference"){
                $this->ContraVouchers->ReferenceBalances->deleteAll(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no]);
                
                $RDetail=$this->ContraVouchers->ReferenceDetails->get($ReferenceDetail->id);
                $this->ContraVouchers->ReferenceDetails->delete($RDetail);
            }elseif($ReferenceDetail->reference_type=="Against Reference"){
                if(!empty($ReferenceDetail->credit)){
                    $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
                    $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->get($ReferenceBalance->id);
                    $ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
                    $this->ContraVouchers->ReferenceBalances->save($ReferenceBalance);
                }elseif(!empty($ReferenceDetail->debit)){
                    $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
                    $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->get($ReferenceBalance->id);
                    $ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
                    $this->ContraVouchers->ReferenceBalances->save($ReferenceBalance);
                }
                $RDetail=$this->ContraVouchers->ReferenceDetails->get($ReferenceDetail->id);
                $this->ContraVouchers->ReferenceDetails->delete($RDetail);
            }
        }       exit;
    }
    
    function deleteOneRefNumbers(){
        $old_received_from_id=$this->request->query['old_received_from_id'];
        $payment_id=$this->request->query['payment_id'];
        $old_ref=$this->request->query['old_ref'];
        $old_ref_type=$this->request->query['old_ref_type'];
        
        if($old_ref_type=="New Reference" || $old_ref_type=="Advance Reference"){
            $this->ContraVouchers->ReferenceBalances->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
            $this->ContraVouchers->ReferenceDetails->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
        }elseif($old_ref_type=="Against Reference"){
            $ReferenceDetail=$this->ContraVouchers->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'payment_id'=>$payment_id,'reference_no'=>$old_ref])->first();
            
            if(!empty($ReferenceDetail->credit)){
                $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
                $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->get($ReferenceBalance->id);
                $ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
                $this->ContraVouchers->ReferenceBalances->save($ReferenceBalance);
            }elseif(!empty($ReferenceDetail->debit)){
                $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
                $ReferenceBalance=$this->ContraVouchers->ReferenceBalances->get($ReferenceBalance->id);
                $ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
                $this->ContraVouchers->ReferenceBalances->save($ReferenceBalance);
            }
            $RDetail=$this->ContraVouchers->ReferenceDetails->get($ReferenceDetail->id);
            $this->ContraVouchers->ReferenceDetails->delete($RDetail);
        }
        
        exit;
    }




    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contraVoucher = $this->ContraVouchers->get($id);
        if ($this->ContraVouchers->delete($contraVoucher)) {
            $this->Flash->success(__('The Contra Vouchers has been deleted.'));
        } else {
            $this->Flash->error(__('The Contra Vouchers could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
?>