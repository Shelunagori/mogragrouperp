<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Nppayments Controller
 *
 * @property \App\Model\Table\NppaymentsTable $Nppayments
 */
class NppaymentsController extends AppController
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
            $where['Nppayments.voucher_no LIKE']=$vouch_no;
        }
        
        if(!empty($From)){
            $From=date("Y-m-d",strtotime($this->request->query('From')));
            $where['Nppayments.transaction_date >=']=$From;
        }
        if(!empty($To)){
            $To=date("Y-m-d",strtotime($this->request->query('To')));
            $where['Nppayments.transaction_date <=']=$To;
        }
        
        $this->paginate = [
            'contain' => []
        ];
        
        
        $nppayments = $this->paginate($this->Nppayments->find()->where($where)->where(['company_id'=>$st_company_id])->contain(['NppaymentRows'=>function($q){
            $NppaymentRows = $this->Nppayments->NppaymentRows->find();
            $totalCrCase = $NppaymentRows->newExpr()
                ->addCase(
                    $NppaymentRows->newExpr()->add(['cr_dr' => 'Cr']),
                    $NppaymentRows->newExpr()->add(['amount']),
                    'integer'
                );
            $totalDrCase = $NppaymentRows->newExpr()
                ->addCase(
                    $NppaymentRows->newExpr()->add(['cr_dr' => 'Dr']),
                    $NppaymentRows->newExpr()->add(['amount']),
                    'integer'
                );
            return $NppaymentRows->select([
                    'total_cr' => $NppaymentRows->func()->sum($totalCrCase),
                    'total_dr' => $NppaymentRows->func()->sum($totalDrCase)
                ])
                ->group('nppayment_id')
                
                ->autoFields(true);
            
        }])->order(['voucher_no'=>'DESC']));
        

        $this->set(compact('nppayments'));
        $this->set('_serialize', ['nppayments']);
    }

    /**
     * View method
     *
     * @param string|null $id Nppayment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->layout('index_layout');
        $nppayment = $this->Nppayments->get($id, [
            'contain' => ['BankCashes', 'Companies', 'NppaymentRows' => ['ReceivedFroms'], 'Creator']
        ]);

        $this->set('nppayment', $nppayment);
        $this->set('_serialize', ['nppayment']);
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
        $financial_year = $this->Nppayments->FinancialYears->find()->where(['id'=>$st_year_id])->first();
        
        $nppayment = $this->Nppayments->newEntity();

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
            $nppayment = $this->Nppayments->patchEntity($nppayment, $this->request->data);
            $nppayment->company_id=$st_company_id;
            //Voucher Number Increment
            $last_voucher_no=$this->Nppayments->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
            if($last_voucher_no){
                $nppayment->voucher_no=$last_voucher_no->voucher_no+1;
            }else{
                $nppayment->voucher_no=1;
            }
            
            $nppayment->created_on=date("Y-m-d");
            $nppayment->created_by=$s_employee_id;
            $nppayment->transaction_date=date("Y-m-d",strtotime($nppayment->transaction_date));
            //pr($nppayment); exit;
            if ($this->Nppayments->save($nppayment)) {
                $total_cr=0; $total_dr=0;
                foreach($nppayment->nppayment_rows as $nppayment_row){
                    
                    //Ledger posting for Received From Entity
                    $ledger = $this->Nppayments->Ledgers->newEntity();
                    $ledger->company_id=$st_company_id;
                    $ledger->ledger_account_id = $nppayment_row->received_from_id;
                    if($nppayment_row->cr_dr=="Dr"){
                        $ledger->debit = $nppayment_row->amount;
                        $ledger->credit = 0;
                        $total_dr=$total_dr+$nppayment_row->amount;
                    }else{
                        $ledger->debit = 0;
                        $ledger->credit = $nppayment_row->amount;
                        $total_cr=$total_cr+$nppayment_row->amount;
                    }
                    
                    $ledger->voucher_id = $nppayment->id;
                    $ledger->voucher_source = 'Non Print Payment Voucher';
                    $ledger->transaction_date = $nppayment->transaction_date;
                    $this->Nppayments->Ledgers->save($ledger);
                    
                    $total_amount=$total_dr-$total_cr;
                    
                    //Reference Number coding
                    if(sizeof(@$nppayment->ref_rows[$nppayment_row->received_from_id])>0){
                        
                        foreach($nppayment->ref_rows[$nppayment_row->received_from_id] as $ref_row){ 
                            $ref_row=(object)$ref_row;
                            if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
                                $query = $this->Nppayments->ReferenceBalances->query();
                                if($nppayment_row->cr_dr=="Dr"){
                                    $query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
                                    ->values([
                                        'ledger_account_id' => $nppayment_row->received_from_id,
                                        'reference_no' => $ref_row->ref_no,
                                        'credit' => 0,
                                        'debit' => $ref_row->ref_amount
                                    ])
                                    ->execute();
                                }else{
                                    $query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
                                    ->values([
                                        'ledger_account_id' => $nppayment_row->received_from_id,
                                        'reference_no' => $ref_row->ref_no,
                                        'credit' => $ref_row->ref_amount,
                                        'debit' => 0
                                    ])
                                    ->execute();
                                }
                                
                            }else{
                                $ReferenceBalance=$this->Nppayments->ReferenceBalances->find()->where(['ledger_account_id'=>$nppayment_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
                                $ReferenceBalance=$this->Nppayments->ReferenceBalances->get($ReferenceBalance->id);
                                if($nppayment_row->cr_dr=="Dr"){
                                    $ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
                                }else{
                                    $ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
                                }
                                
                                $this->Nppayments->ReferenceBalances->save($ReferenceBalance);
                            }
                            
                            $query = $this->Nppayments->ReferenceDetails->query();
                            if($nppayment_row->cr_dr=="Dr"){
                                $query->insert(['ledger_account_id', 'nppayment_id', 'reference_no', 'credit', 'debit', 'reference_type'])
                                ->values([
                                    'ledger_account_id' => $nppayment_row->received_from_id,
                                    'nppayment_id' => $nppayment->id,
                                    'reference_no' => $ref_row->ref_no,
                                    'credit' => 0,
                                    'debit' => $ref_row->ref_amount,
                                    'reference_type' => $ref_row->ref_type
                                ])
                                ->execute();
                            }else{
                                $query->insert(['ledger_account_id', 'nppayment_id', 'reference_no', 'credit', 'debit', 'reference_type'])
                                ->values([
                                    'ledger_account_id' => $nppayment_row->received_from_id,
                                    'nppayment_id' => $nppayment->id,
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
                $ledger = $this->Nppayments->Ledgers->newEntity();
                $ledger->company_id=$st_company_id;
                $ledger->ledger_account_id = $nppayment->bank_cash_id;
                $ledger->debit = 0;
                $ledger->credit = $total_amount;
                $ledger->voucher_id = $nppayment->id;
                $ledger->voucher_source = 'Non Print Payment Voucher';
                $ledger->transaction_date = $nppayment->transaction_date;
                $this->Nppayments->Ledgers->save($ledger);
                
                $this->Flash->success(__('The non print payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {

                $this->Flash->error(__('The non print payment could not be saved. Please, try again.'));
            }
        }
        $vr=$this->Nppayments->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Non Print Payment Voucher','sub_entity'=>'Cash/Bank'])->first();
        $ReceiptVouchersCashBank=$vr->id;
        $vouchersReferences = $this->Nppayments->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
        $where=[];
        foreach($vouchersReferences->voucher_ledger_accounts as $data){
            $where[]=$data->ledger_account_id;
        }
        $BankCashes_selected='yes';
        if(sizeof($where)>0){
            $bankCashes = $this->Nppayments->BankCashes->find('list',
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
        
        $vr=$this->Nppayments->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Non Print Payment Voucher','sub_entity'=>'Paid To'])->first();
        $ReceiptVouchersReceivedFrom=$vr->id;
        $vouchersReferences = $this->Nppayments->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
        $where=[];
        foreach($vouchersReferences->voucher_ledger_accounts as $data){
            $where[]=$data->ledger_account_id;
        }
        $ReceivedFroms_selected='yes';
        if(sizeof($where)>0){
            $receivedFroms = $this->Nppayments->ReceivedFroms->find('list',
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
        $this->set(compact('nppayment', 'bankCashes', 'receivedFroms', 'financial_year', 'BankCashes_selected', 'ReceivedFroms_selected','chkdate'));
        $this->set('_serialize', ['nppayment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Nppayment id.
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
        $financial_year = $this->Nppayments->FinancialYears->find()->where(['id'=>$st_year_id])->first();

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

        
        $nppayment = $this->Nppayments->get($id, [
            'contain' => ['NppaymentRows']
        ]);
        $old_ref_rows=[];
        $old_received_from_ids=[];
        $old_reference_numbers=[];
        
        foreach($nppayment->nppayment_rows as $nppayment_row){
            $ReferenceDetails=$this->Nppayments->ReferenceDetails->find()->where(['ledger_account_id'=>$nppayment_row->received_from_id,'nppayment_id'=>$nppayment->id]);
            foreach($ReferenceDetails as $ReferenceDetail){
                $old_reference_numbers[$nppayment_row->received_from_id][]=$ReferenceDetail->reference_no;
            }
            $old_ref_rows[$nppayment_row->received_from_id]=$ReferenceDetails->toArray();
            $old_received_from_ids[]=$nppayment_row->received_from_id;
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $nppayment = $this->Nppayments->patchEntity($nppayment, $this->request->data);
            $nppayment->company_id=$st_company_id;
            
            $nppayment->edited_on=date("Y-m-d");
            $nppayment->edited_by=$s_employee_id;
            $nppayment->transaction_date=date("Y-m-d",strtotime($nppayment->transaction_date));
                
            //Save receipt
            //pr($payment); exit;
            if ($this->Nppayments->save($nppayment)) {
                $this->Nppayments->Ledgers->deleteAll(['voucher_id' => $nppayment->id, 'voucher_source' => 'Non Print Payment Voucher']);
                $total_cr=0; $total_dr=0;
                foreach($nppayment->nppayment_rows as $nppayment_row){
                    
                    //Ledger posting for Received From Entity
                    $ledger = $this->Nppayments->Ledgers->newEntity();
                    $ledger->company_id=$st_company_id;
                    $ledger->ledger_account_id = $nppayment_row->received_from_id;
                    if($nppayment_row->cr_dr=="Dr"){
                        $ledger->debit = $nppayment_row->amount;
                        $ledger->credit = 0;
                        $total_dr=$total_dr+$nppayment_row->amount;
                    }else{
                        $ledger->debit = 0;
                        $ledger->credit = $nppayment_row->amount;
                        $total_cr=$total_cr+$nppayment_row->amount;
                    }
                    $ledger->voucher_id = $nppayment->id;
                    $ledger->voucher_source = 'Non Print Payment Voucher';
                    $ledger->transaction_date = $nppayment->transaction_date;
                    $this->Nppayments->Ledgers->save($ledger);
                    
                    $total_amount=$total_dr-$total_cr;
                    
                    //Reference Number coding
                    if(sizeof(@$nppayment->ref_rows[$nppayment_row->received_from_id])>0){
                        
                        foreach($nppayment->ref_rows[$nppayment_row->received_from_id] as $ref_row){
                            $ref_row=(object)$ref_row;
                            $ReferenceDetail=$this->Nppayments->ReferenceDetails->find()->where(['ledger_account_id'=>$nppayment_row->received_from_id,'reference_no'=>$ref_row->ref_no,'payment_id'=>$nppayment->id])->first();
                            
                            if($ReferenceDetail){
                                $ReferenceBalance=$this->Nppayments->ReferenceBalances->find()->where(['ledger_account_id'=>$nppayment_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
                                $ReferenceBalance=$this->Nppayments->ReferenceBalances->get($ReferenceBalance->id);
                                if($nppayment_row->cr_dr=="Dr"){
                                    $ReferenceBalance->debit=$ReferenceBalance->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
                                }else{
                                    $ReferenceBalance->credit=$ReferenceBalance->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
                                }
                                
                                $this->Nppayments->ReferenceBalances->save($ReferenceBalance);
                                
                                $ReferenceDetail=$this->Nppayments->ReferenceDetails->find()->where(['ledger_account_id'=>$nppayment_row->received_from_id,'reference_no'=>$ref_row->ref_no,'nppayment_id'=>$nppayment->id])->first();
                                $ReferenceDetail=$this->Nppayments->ReferenceDetails->get($ReferenceDetail->id);
                                if($nppayment_row->cr_dr=="Dr"){
                                    $ReferenceDetail->debit=$ReferenceDetail->debit-$ref_row->ref_old_amount+$ref_row->ref_amount;
                                }else{
                                    $ReferenceDetail->credit=$ReferenceDetail->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
                                }
                                
                                $this->Nppayments->ReferenceDetails->save($ReferenceDetail);
                            }else{
                                if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
                                    $query = $this->Nppayments->ReferenceBalances->query();
                                    if($nppayment_row->cr_dr=="Dr"){
                                        $query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
                                        ->values([
                                            'ledger_account_id' => $nppayment_row->received_from_id,
                                            'reference_no' => $ref_row->ref_no,
                                            'credit' => 0,
                                            'debit' => $ref_row->ref_amount
                                        ])
                                        ->execute();
                                    }else{
                                        $query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
                                        ->values([
                                            'ledger_account_id' => $nppayment_row->received_from_id,
                                            'reference_no' => $ref_row->ref_no,
                                            'credit' => $ref_row->ref_amount,
                                            'debit' => 0
                                        ])
                                        ->execute();
                                    }
                                    
                                }else{
                                    $ReferenceBalance=$this->Nppayments->ReferenceBalances->find()->where(['ledger_account_id'=>$nppayment_row->received_from_id,'reference_no'=>$ref_row->ref_no])->first();
                                    $ReferenceBalance=$this->Nppayments->ReferenceBalances->get($ReferenceBalance->id);
                                    if($nppayment_row->cr_dr=="Dr"){
                                        $ReferenceBalance->debit=$ReferenceBalance->debit+$ref_row->ref_amount;
                                    }else{
                                        $ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
                                    }
                                    
                                    $this->Nppayments->ReferenceBalances->save($ReferenceBalance);
                                }
                                
                                $query = $this->Nppayments->ReferenceDetails->query();
                                if($nppayment_row->cr_dr=="Dr"){
                                    $query->insert(['ledger_account_id', 'nppayment_id', 'reference_no', 'credit', 'debit', 'reference_type'])
                                    ->values([
                                        'ledger_account_id' => $nppayment_row->received_from_id,
                                        'nppayment_id' => $nppayment->id,
                                        'reference_no' => $ref_row->ref_no,
                                        'credit' => 0,
                                        'debit' => $ref_row->ref_amount,
                                        'reference_type' => $ref_row->ref_type
                                    ])
                                    ->execute();
                                }else{
                                    $query->insert(['ledger_account_id', 'nppayment_id', 'reference_no', 'credit', 'debit', 'reference_type'])
                                    ->values([
                                        'ledger_account_id' => $nppayment_row->received_from_id,
                                        'nppayment_id' => $nppayment->id,
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
                $ledger = $this->Nppayments->Ledgers->newEntity();
                $ledger->company_id=$st_company_id;
                $ledger->ledger_account_id = $nppayment->bank_cash_id;
                $ledger->debit = 0;
                $ledger->credit = $total_amount;
                $ledger->voucher_id = $nppayment->id;
                $ledger->voucher_source = 'Non Print Payment Voucher';
                $ledger->transaction_date = $nppayment->transaction_date;
                $this->Nppayments->Ledgers->save($ledger);
                
                $this->Flash->success(__('The receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
            }
        }
        
        $vr=$this->Nppayments->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Non Print Payment Voucher','sub_entity'=>'Cash/Bank'])->first();
        $ReceiptVouchersCashBank=$vr->id;
        $vouchersReferences = $this->Nppayments->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
        $where=[];
        foreach($vouchersReferences->voucher_ledger_accounts as $data){
            $where[]=$data->ledger_account_id;
        }
        $BankCashes_selected='yes';
        if(sizeof($where)>0){
            $bankCashes = $this->Nppayments->BankCashes->find('list',
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
        
        $vr=$this->Nppayments->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Non Print Payment Voucher','sub_entity'=>'Paid To'])->first();
        $ReceiptVouchersReceivedFrom=$vr->id;
        $vouchersReferences = $this->Nppayments->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
        $where=[];
        foreach($vouchersReferences->voucher_ledger_accounts as $data){
            $where[]=$data->ledger_account_id;
        }
        $ReceivedFroms_selected='yes';
        if(sizeof($where)>0){
            $receivedFroms = $this->Nppayments->ReceivedFroms->find('list',
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
        
        $this->set(compact('nppayment', 'bankCashes', 'receivedFroms', 'financial_year', 'BankCashes_selected', 'ReceivedFroms_selected', 'old_ref_rows','chkdate'));
        $this->set('_serialize', ['nppayment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Nppayment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nppayment = $this->Nppayments->get($id);
        if ($this->Nppayments->delete($nppayment)) {
            $this->Flash->success(__('The non print payment has been deleted.'));
        } else {
            $this->Flash->error(__('The non print payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function fetchRefNumbers($received_from_id=null,$cr_dr=null){
        $this->viewBuilder()->layout('');
        $ReferenceBalances=$this->Nppayments->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
        $this->set(compact('ReferenceBalances','cr_dr'));
    }
    
    public function fetchRefNumbersEdit($received_from_id=null,$reference_no=null,$debit=null,$credit=null,$cr_dr=null){
        $this->viewBuilder()->layout('');
        $ReferenceBalances=$this->Nppayments->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
        $this->set(compact('ReferenceBalances', 'reference_no', 'credit', 'debit', 'cr_dr'));
    }
    
    function checkRefNumberUnique($received_from_id,$i){
        $reference_no=$this->request->query['ref_rows'][$received_from_id][$i]['ref_no'];
        $ReferenceBalances=$this->Nppayments->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
        if($ReferenceBalances->count()==0){
            echo 'true';
        }else{
            echo 'false';
        }
        exit;
    }
    
    function checkRefNumberUniqueEdit($received_from_id,$i,$is_old){
        $reference_no=$this->request->query['ref_rows'][$received_from_id][$i]['ref_no'];
        $ReferenceBalances=$this->Nppayments->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
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
        $ReferenceDetails=$this->Nppayments->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'receipt_id'=>$receipt_id]);
        foreach($ReferenceDetails as $ReferenceDetail){
            if($ReferenceDetail->reference_type=="New Reference" || $ReferenceDetail->reference_type=="Advance Reference"){
                $this->Payments->ReferenceBalances->deleteAll(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no]);
                
                $RDetail=$this->Nppayments->ReferenceDetails->get($ReferenceDetail->id);
                $this->Nppayments->ReferenceDetails->delete($RDetail);
            }elseif($ReferenceDetail->reference_type=="Against Reference"){
                if(!empty($ReferenceDetail->credit)){
                    $ReferenceBalance=$this->Nppayments->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
                    $ReferenceBalance=$this->Nppayments->ReferenceBalances->get($ReferenceBalance->id);
                    $ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
                    $this->Payments->ReferenceBalances->save($ReferenceBalance);
                }elseif(!empty($ReferenceDetail->debit)){
                    $ReferenceBalance=$this->Nppayments->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
                    $ReferenceBalance=$this->Nppayments->ReferenceBalances->get($ReferenceBalance->id);
                    $ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
                    $this->Nppayments->ReferenceBalances->save($ReferenceBalance);
                }
                $RDetail=$this->Nppayments->ReferenceDetails->get($ReferenceDetail->id);
                $this->Nppayments->ReferenceDetails->delete($RDetail);
            }
        }       exit;
    }
    
    function deleteOneRefNumbers(){
        $old_received_from_id=$this->request->query['old_received_from_id'];
        $nppayment_id=$this->request->query['nppayment_id'];
        $old_ref=$this->request->query['old_ref'];
        $old_ref_type=$this->request->query['old_ref_type'];
        
        if($old_ref_type=="New Reference" || $old_ref_type=="Advance Reference"){
            $this->Nppayments->ReferenceBalances->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
            $this->Nppayments->ReferenceDetails->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
        }elseif($old_ref_type=="Against Reference"){
            $ReferenceDetail=$this->Nppayments->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'nppayment_id'=>$nppayment_id,'reference_no'=>$old_ref])->first();
            
            if(!empty($ReferenceDetail->credit)){
                $ReferenceBalance=$this->Nppayments->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
                $ReferenceBalance=$this->Nppayments->ReferenceBalances->get($ReferenceBalance->id);
                $ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
                $this->Nppayments->ReferenceBalances->save($ReferenceBalance);
            }elseif(!empty($ReferenceDetail->debit)){
                $ReferenceBalance=$this->Nppayments->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
                $ReferenceBalance=$this->Nppayments->ReferenceBalances->get($ReferenceBalance->id);
                $ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
                $this->Nppayments->ReferenceBalances->save($ReferenceBalance);
            }
            $RDetail=$this->Nppayments->ReferenceDetails->get($ReferenceDetail->id);
            $this->Nppayments->ReferenceDetails->delete($RDetail);
        }
        
        exit;
    }
}
