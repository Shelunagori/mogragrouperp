<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ledgers Controller
 *
 * @property \App\Model\Table\LedgersTable $Ledgers
 */
class LedgersController extends AppController
{
	public $helpers = [
         'Paginator' => ['templates' => 'paginator-templates']
         ];

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($status=null)
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$this->viewBuilder()->layout('index_layout');
		$where=[];
		$ledger=$this->request->query('ledger');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$this->set(compact('ledger','From','To'));
		if(!empty($ledger)){
			$where['ledger_account_id']=$ledger;
		}
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['transaction_date >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['transaction_date <=']=$To;
		}
		$where['Ledgers.company_id']=$st_company_id;
        $this->paginate = [
            'contain' => ['LedgerAccounts']
        ];
        $ledgers = $this->paginate($this->Ledgers->find()->where($where)->order(['Ledgers.transaction_date' => 'DESC','Ledgers.voucher_id'=>'DESC','Ledgers.voucher_source'=>'DESC']));
		
					$url_link=[];
			foreach($ledgers as $ledger){
				if($ledger->voucher_source=="Journal Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->JournalVouchers->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Payment Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->Payments->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Petty Cash Payment Voucher"){
					$url_link[$ledger->id]="/petty-cash-vouchers/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Contra Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->ContraVouchers->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Receipt Voucher"){
				$url_link[$ledger->id]=$this->Ledgers->Receipts->get($ledger->voucher_id); 
				}else if($ledger->voucher_source=="Invoice"){
					$url_link[$ledger->id]=$this->Ledgers->Invoices->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Invoice Booking"){
					$url_link[$ledger->id]=$this->Ledgers->InvoiceBookings->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Non Print Payment Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->Nppayments->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Debit Note"){
					$url_link[$ledger->id]=$this->Ledgers->DebitNotes->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Credit Note"){
					$url_link[$ledger->id]=$this->Ledgers->CreditNotes->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Purchase Return"){
					$url_link[$ledger->id]=$this->Ledgers->PurchaseReturns->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Sale Return"){
					$url_link[$ledger->id]=$this->Ledgers->SaleReturns->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Inventory Return"){
					$url_link[$ledger->id]=$this->Ledgers->Rivs->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Inventory Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->InventoryVouchers->get($ledger->voucher_id);
				}
			}
		
		
        $ledgerAccounts = $this->Ledgers->LedgerAccounts->find('list');
		//pr($ledgers);exit;
        $this->set(compact('ledgers','ledgerAccounts','url_link'));
        $this->set('_serialize', ['ledgers']);
		$this->set(compact('url'));
    }

    /**
     * View method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
	 
	 public function exportOb()
    {
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $st_year_id = $session->read('st_year_id');
		$ledger_account_id=$this->request->query('ledger_account_id');
		$financial_year = $this->Ledgers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$SessionCheckDate = $this->FinancialYears->get($st_year_id);
		$from = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
		$To = date("Y-m-d"); 
		
		$this->set(compact('ledger','From','To'));
		if(!empty($ledger)){
			$where['ledger_account_id']=$ledger;
		}
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['transaction_date >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['transaction_date <=']=$To;
		}
		
		if($ledger_account_id)
		{
			$Ledger_Account_data = $this->Ledgers->LedgerAccounts->get($ledger_account_id, [
            'contain' => ['AccountSecondSubgroups'=>['AccountFirstSubgroups'=>['AccountGroups'=>['AccountCategories']]]]
        ]);
			$from = $this->request->query['From'];
			$To = $this->request->query['To'];
			$transaction_from_date= date('Y-m-d', strtotime($from));
			$transaction_to_date= date('Y-m-d', strtotime($To));
			$this->set(compact('from','To','transaction_from_date','transaction_to_date'));
		
			if($from == '01-04-2017'){
				$OB = $this->Ledgers->find()->where(['ledger_account_id'=>$ledger_account_id,'transaction_date  '=>$transaction_from_date]);
				$opening_balance_ar=[];
			foreach($OB as $Ledger)
				{
					if($Ledger->voucher_source== "Opening Balance"){
						@$opening_balance_ar['debit']+=$Ledger->debit;
						@$opening_balance_ar['credit']+=$Ledger->credit;
					}
				}	
			}else{
				$OB = $this->Ledgers->find()->where(['ledger_account_id'=>$ledger_account_id,'transaction_date  <'=>$transaction_from_date]);
				$opening_balance_ar=[];
				foreach($OB as $Ledger)
					{
						
							@$opening_balance_ar['debit']+=$Ledger->debit;
							@$opening_balance_ar['credit']+=$Ledger->credit;
					}	
			}
				//pr($opening_balance_ar); exit;
		$where['Ledgers.company_id']=$st_company_id;
       
		$Ledgers = $this->Ledgers->find()
				->where(['ledger_account_id'=>$ledger_account_id,'company_id'=>$st_company_id])
				->where(function($exp) use($transaction_from_date,$transaction_to_date){
					return $exp->between('transaction_date', $transaction_from_date, $transaction_to_date, 'date');
				})->order(['transaction_date' => 'DESC']);
				
		//$ledgers = $this->Ledgers->find()->contain(['LedgerAccounts'])->where($where)->where(['voucher_source != '=>'Opening Balance'])->order(['transaction_date'=>'DESC']);
		
		$url_link=[];
			foreach($Ledgers as $ledger){
				if($ledger->voucher_source=="Journal Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->JournalVouchers->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Payment Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->Payments->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Petty Cash Payment Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->PettyCashVouchers->get($ledger->voucher_id);
					//pr($url_link[$ledger->id]); exit;
				}else if($ledger->voucher_source=="Contra Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->ContraVouchers->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Receipt Voucher"){
				$url_link[$ledger->id]=$this->Ledgers->Receipts->get($ledger->voucher_id); 
				}else if($ledger->voucher_source=="Invoice"){ 
					$inq=$this->Ledgers->Invoices->get($ledger->voucher_id);
					if($inq->sale_tax_id==0){
						$url_link[$ledger->id]=$this->Ledgers->Invoices->get($ledger->voucher_id, [
							'contain' => ['Customers']
						]);
					}else{
						$url_link[$ledger->id]=$this->Ledgers->Invoices->get($ledger->voucher_id, [
							'contain' => ['Customers','SaleTaxes']
						]);
					}
					
					
				}else if($ledger->voucher_source=="Invoice Booking"){
					$ib=$this->Ledgers->InvoiceBookings->get($ledger->voucher_id);
					if($ib->cst_vat=='vat'){
						$url_link[$ledger->id]=$this->Ledgers->InvoiceBookings->get($ledger->voucher_id, [
							'contain' => ['Vendors','InvoiceBookingRows']
						]);
					}else{
						$url_link[$ledger->id]=$this->Ledgers->InvoiceBookings->get($ledger->voucher_id, [
							'contain' => ['Vendors','InvoiceBookingRows']
						]);
					}
				}else if($ledger->voucher_source=="Non Print Payment Voucher"){ 
						
					$url_link[$ledger->id]=$this->Ledgers->Nppayments->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Debit Note"){
					$url_link[$ledger->id]=$this->Ledgers->DebitNotes->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Credit Note"){
					$url_link[$ledger->id]=$this->Ledgers->CreditNotes->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Purchase Return"){
					$url_link[$ledger->id]=$this->Ledgers->PurchaseReturns->get($ledger->voucher_id);
				}
			}
		}			
		//pr($url_link); exit;
		//$ledger_acc = $this->Ledgers->find()->contain(['LedgerAccounts'])->where($where)->where(['voucher_source != '=>'Opening Balance'])->first();
		
		$ledger=$this->Ledgers->LedgerAccounts->find('list',
				['keyField' => function ($row) {
					return $row['id'];
				},
				'valueField' => function ($row) {
					if(!empty($row['alias'])){
						return  $row['name'] . ' (' . $row['alias'] . ')';
					}else{
						return $row['name'];
					}
					
				}])->where(['company_id'=>$st_company_id]);
		
		//$ledger_acc_name=$ledger_acc->ledger_account->name;
		//$ledger_acc_alias=$ledger_acc->ledger_account->alias;
		
        //$ledgerAccounts = $this->Ledgers->LedgerAccounts->find('list');
        $this->set(compact('Ledgers','ledger','ledger_account_id','Ledger_Account_data','url_link','transaction_from_date','transaction_to_date','financial_year','from','To','opening_balance_ar'));
        $this->set('_serialize', ['Ledgers']);
    }
	 public function exportExcel()
    {
		$this->viewBuilder()->layout('');
		$where=[];
		$ledger=$this->request->query('ledger');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$this->set(compact('ledger','From','To'));
		if(!empty($ledger)){
			$where['ledger_account_id']=$ledger;
		}
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['transaction_date >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['transaction_date <=']=$To;
		}
		
		$where['Ledgers.company_id']=$st_company_id;
       
		 $this->paginate = [
            'contain' => ['LedgerAccounts']
        ];
		
		$ledgers = $this->Ledgers->find()->contain(['LedgerAccounts'])->where($where)->order(['transaction_date'=>'DESC']);
		
		
		
		//pr($ledgers->toArray());exit;
			$url_link=[];
			foreach($ledgers as $ledger){
				if($ledger->voucher_source=="Journal Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->JournalVouchers->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Payment Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->Payments->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Petty Cash Payment Voucher"){
					$url_link[$ledger->id]="/petty-cash-vouchers/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Contra Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->ContraVouchers->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Receipt Voucher"){
				$url_link[$ledger->id]=$this->Ledgers->Receipts->get($ledger->voucher_id); 
				}else if($ledger->voucher_source=="Invoice"){
					$url_link[$ledger->id]=$this->Ledgers->Invoices->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Invoice Booking"){
					$url_link[$ledger->id]=$this->Ledgers->InvoiceBookings->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Non Print Payment Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->Nppayments->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Debit Note"){
					$url_link[$ledger->id]=$this->Ledgers->DebitNotes->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Credit Note"){
					$url_link[$ledger->id]=$this->Ledgers->CreditNotes->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Purchase Return"){
					$url_link[$ledger->id]=$this->Ledgers->PurchaseReturns->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Sale Return"){
					$url_link[$ledger->id]=$this->Ledgers->SaleReturns->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Inventory Return"){
					$url_link[$ledger->id]=$this->Ledgers->Rivs->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Inventory Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->InventoryVouchers->get($ledger->voucher_id);
				}
			}
		
		
        $ledgerAccounts = $this->Ledgers->LedgerAccounts->find('list');
                 $this->set(compact('ledgers','ledgerAccounts','url_link','From','To'));

        $this->set('_serialize', ['ledgers']);
    }
	
	 
	 
    public function view($id = null)
    {
        $ledger = $this->Ledgers->get($id, [
            'contain' => ['LedgerAccounts']
        ]);

        $this->set('ledger', $ledger);
        $this->set('_serialize', ['ledger']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		
        $ledger = $this->Ledgers->newEntity();
        if ($this->request->is('post')) {
            $ledger = $this->Ledgers->patchEntity($ledger, $this->request->data);
			
            if ($this->Ledgers->save($ledger)) {
                $this->Flash->success(__('The ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ledger could not be saved. Please, try again.'));
            }
        }
        $ledgerAccounts = $this->Ledgers->LedgerAccounts->find('list', ['limit' => 200]);
        $this->set(compact('ledger', 'ledgerAccounts'));
        $this->set('_serialize', ['ledger']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $ledger = $this->Ledgers->newEntity();
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $ledger = $this->Ledgers->get($id, [
            'contain' => ['LedgerAccounts']
        ]);
		$ledger_details= $this->Ledgers->find()->where(['ledger_account_id'=>$ledger->ledger_account_id,'voucher_source'=>'Opening Balance']);
		//pr($ledger_details->toArray()); exit;

		
	if ($this->request->is(['patch', 'post', 'put'])) {
		$ledger = $this->Ledgers->patchEntity($ledger, $this->request->data);
		//$total_row=sizeof($this->request->data['reference_no']);
		//pr($ledger->ledger_rows); exit;
		foreach($ledger->ledger_rows as $ledger_row){
			//pr($ledger_row); exit;
			if($ledger_row['ledger_id'] > 0){ 
			$ledger_data = $this->Ledgers->get($ledger_row['ledger_id']);
				if(@$ledger_row['debit']>0){ 
				$Reference_detail_datas = $this->Ledgers->ReferenceDetails->find()->where(['reference_no'=>$ledger_data->ref_no,'reference_type'=>'Against Reference','ledger_account_id'=>$ledger_data->ledger_account_id]);
				$flag=$Reference_detail_datas->count();
				$total_amt=$ledger_row['debit']; 
				$delete_status='no';
					foreach($Reference_detail_datas as $Reference_detail_data){
						$R=$total_amt-$Reference_detail_data->credit;
						
						if($R>0 && $delete_status=='no'){
							$total_amt=$R;
							$flag--;
						}
						else if($R<=0 && $delete_status=='no'){  
							$delete_status='Deleted';
							$query = $this->Ledgers->ReferenceDetails->query();
							$query->update()
							->set(['credit' => abs($total_amt)])
							->where(['id' => $Reference_detail_data->id])
							->execute();
							
							$new_Reference_detail = $this->Ledgers->ReferenceDetails->find()->where(['reference_no'=>$ledger_data->ref_no,'reference_type'=>'New Reference','ledger_account_id'=>$ledger_data->ledger_account_id])->first();
								$query = $this->Ledgers->ReferenceDetails->query();
								$query->update()
								->set(['debit' => $ledger_row['debit']])
								->where(['id' => $new_Reference_detail->id])
								->execute();
							//pr($flag); exit;
							$total_amt=0;
							$flag=0;
						}else if($R<0 && $delete_status='Deleted'){ 
							$this->Ledgers->ReferenceDetails->delete($Reference_detail_data);
						}
						  
					}
					$new_Reference_detail = $this->Ledgers->ReferenceDetails->find()->where(['reference_no'=>$ledger_data->ref_no,'reference_type'=>'New Reference','ledger_account_id'=>$ledger_data->ledger_account_id])->first();
								$query = $this->Ledgers->ReferenceDetails->query();
								$query->update()
								->set(['debit' => $ledger_row['debit']])
								->where(['id' => $new_Reference_detail->id])
								->execute();
					
					$query = $this->Ledgers->query();
								$query->update()
								->set(['debit' => $ledger_row['debit'],'credit' => 0])
								->where(['id' => $ledger_row['ledger_id']])
								->execute();
					$new_Reference_Balance = $this->Ledgers->ReferenceBalances->find()->where(['reference_no'=>$ledger_data->ref_no,'ledger_account_id'=>$ledger_data->ledger_account_id])->first();
					if($ledger_row['debit'] >= $new_Reference_Balance->debit){ 
										$query = $this->Ledgers->ReferenceBalances->query();
										$query->update()
										->set(['debit' => $ledger_row['debit']])
										->where(['id' => $new_Reference_Balance->id])
										->execute();
					}
					else if($ledger_row['debit'] < $new_Reference_Balance->debit && $ledger_row['debit'] > $new_Reference_Balance->credit){ 
										$query = $this->Ledgers->ReferenceBalances->query();
										$query->update()
										->set(['debit' => $ledger_row['debit']])
										->where(['id' => $new_Reference_Balance->id])
										->execute();
					}
					else if($ledger_row['debit'] < $new_Reference_Balance->debit && $ledger_row['debit'] <= $new_Reference_Balance->credit){
										$query = $this->Ledgers->ReferenceBalances->query();
										$query->update()
										->set(['debit' => $ledger_row['debit'],'credit' => $ledger_row['debit']])
										->where(['id' => $new_Reference_Balance->id])
										->execute();
					}
					}else{
						$Reference_detail_datas = $this->Ledgers->ReferenceDetails->find()->where(['reference_no'=>$ledger_data->ref_no,'reference_type'=>'Against Reference','ledger_account_id'=>$ledger_data->ledger_account_id]);
						$flag=$Reference_detail_datas->count();
						$total_amt=$ledger_row['credit']; 
						$delete_status='no';
						foreach($Reference_detail_datas as $Reference_detail_data){
						
						$R=$total_amt-$Reference_detail_data->debit;
						//pr($R); exit;
						if($R>=0 && $delete_status=='no'){
							$total_amt=$R;
							$flag--;
						}
						else if($R<0 && $delete_status=='no'){ 
							$query = $this->Ledgers->ReferenceDetails->query();
							$query->update()
							->set(['debit' => abs($total_amt)])
							->where(['id' => $Reference_detail_data->id])
							->execute();
							
							$new_Reference_detail = $this->Ledgers->ReferenceDetails->find()->where(['reference_no'=>$ledger_data->ref_no,'reference_type'=>'New Reference','ledger_account_id'=>$ledger_data->ledger_account_id])->first();
								$query = $this->Ledgers->ReferenceDetails->query();
								$query->update()
								->set(['credit' => $ledger_row['credit']])
								->where(['id' => $new_Reference_detail->id])
								->execute();
							$delete_status='Deleted';
							$total_amt=0;
						}else if($R<0 && $delete_status=='Deleted'){ 
							$this->Ledgers->ReferenceDetails->delete($Reference_detail_data);
						}
						  
					}
					$new_Reference_detail = $this->Ledgers->ReferenceDetails->find()->where(['reference_no'=>$ledger_data->ref_no,'reference_type'=>'New Reference','ledger_account_id'=>$ledger_data->ledger_account_id])->first();
								$query = $this->Ledgers->ReferenceDetails->query();
								$query->update()
								->set(['credit' => $ledger_row['credit']])
								->where(['id' => $new_Reference_detail->id])
								->execute();
					
					$query = $this->Ledgers->query();
								$query->update()
								->set(['credit' => $ledger_row['credit'],'debit' => 0])
								->where(['id' => $ledger_row['ledger_id']])
								->execute();
					$new_Reference_Balance = $this->Ledgers->ReferenceBalances->find()->where(['reference_no'=>$ledger_data->ref_no,'ledger_account_id'=>$ledger_data->ledger_account_id])->first();
					if($ledger_row['credit'] >= $new_Reference_Balance->credit){ 
										$query = $this->Ledgers->ReferenceBalances->query();
										$query->update()
										->set(['credit' => $ledger_row['credit']])
										->where(['id' => $new_Reference_Balance->id])
										->execute();
					}
					else if($ledger_row['credit'] < $new_Reference_Balance->credit && $ledger_row['credit'] > $new_Reference_Balance->debit){ 
										$query = $this->Ledgers->ReferenceBalances->query();
										$query->update()
										->set(['credit' => $ledger_row['credit']])
										->where(['id' => $new_Reference_Balance->id])
										->execute();
					}
					else if($ledger_row['credit'] < $new_Reference_Balance->credit && $ledger_row['credit'] <= $new_Reference_Balance->debit){
										$query = $this->Ledgers->ReferenceBalances->query();
										$query->update()
										->set(['credit' => $ledger_row['credit'],'debit' => $ledger_row['credit']])
										->where(['id' => $new_Reference_Balance->id])
										->execute();
					}
					}
				}
				else{ 
					
					//Posting in Ledger
					$Ledger_data = $this->Ledgers->newEntity();
					$Ledger_data->ledger_account_id=$ledger->ledger_account_id;
					if($ledger_row['credit']==0){  
						$Ledger_data->debit = $ledger_row['debit'];
						$Ledger_data->credit = 0;
					}
					else { 
						$Ledger_data->debit = 0;
						$Ledger_data->credit = $ledger_row['credit'];
					}
					$Ledger_data->voucher_source = 'Opening Balance';
					$Ledger_data->ref_no = $ledger_row['ref_no'];
					$Ledger_data->transaction_date = date("Y-m-d",strtotime($ledger->transaction_date));
					$Ledger_data->company_id = $st_company_id;
					$this->Ledgers->save($Ledger_data);
					
					//Posting in ReferenceDetails
					$ReferenceDetail = $this->Ledgers->ReferenceDetails->newEntity();
					$ReferenceDetail->ledger_account_id=$ledger->ledger_account_id;
					if($ledger_row['credit']==0){
						$ReferenceDetail->debit = $ledger_row['debit'];
						$ReferenceDetail->credit = 0;
					}
					else {
						$ReferenceDetail->debit = 0;
						$ReferenceDetail->credit = $ledger_row['credit'];
					}
					$ReferenceDetail->reference_type = 'New Reference';
					$ReferenceDetail->reference_no = $ledger_row['ref_no'];
					$this->Ledgers->ReferenceDetails->save($ReferenceDetail);
					
					//Posting in ReferenceBalances
					$ReferenceBalance = $this->Ledgers->ReferenceBalances->newEntity();
					$ReferenceBalance->ledger_account_id=$ledger->ledger_account_id;
					if($ledger_row['credit']==0){
						$ReferenceBalance->debit = $ledger_row['debit'];
						$ReferenceBalance->credit = 0;
					}
					else {
						$ReferenceBalance->debit = 0;
						$ReferenceBalance->credit = $ledger_row['credit'];
					}
					$ReferenceBalance->reference_type = 'New Reference';
					$ReferenceBalance->reference_no = $ledger_row['ref_no'];
					$this->Ledgers->ReferenceBalances->save($ReferenceBalance);
				}  
			}
		}
		//pr($ledger); exit;
        $ledgerAccounts = $this->Ledgers->LedgerAccounts->find('list', ['limit' => 200]);
        $this->set(compact('ledger', 'ledgerAccounts','allow','ledger_details'));
        $this->set('_serialize', ['ledger']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ledger id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ledger = $this->Ledgers->get($id);
        if ($this->Ledgers->delete($ledger)) {
            $this->Flash->success(__('The ledger has been deleted.'));
        } else {
            $this->Flash->error(__('The ledger could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function openingBalance()
    {
		$this->viewBuilder()->layout('index_layout');
        $ledger = $this->Ledgers->newEntity();
		
		$session = $this->request->session();
		$company_id = $session->read('st_company_id');
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->Ledgers->FinancialYears->find()->where(['id'=>$st_year_id])->first();	
				
		if ($this->request->is('post')) {
			
			$total_row=sizeof($this->request->data['reference_no']);
			$Ledgersexists = $this->Ledgers->exists(['ledger_account_id' => $this->request->data['ledger_account_id'],'company_id'=>$company_id,'voucher_source'=>'Opening Balance']);
			if($Ledgersexists){
				$this->Flash->error(__('Opening Balance already exists'));
				return $this->redirect(['action' => 'openingBalance']);
			}

			
		    for($row=0; $row<$total_row; $row++)
		    {
			 ////////////////  Ledger ////////////////////////////////
			 //pr($total_row); exit;
			if($total_row==1){
					if($this->request->data['credit'][$row]==0 && $this->request->data['debit'][$row]==0){
					$this->Flash->error(__('Please can not enter Zero value , try again.'));
					return $this->redirect(['action' => 'Opening_balance']);
				}
			}
				 
			 if($this->request->data['credit'][$row]==0 && $this->request->data['debit'][$row]==0){
				 
			 }else{
				$query = $this->Ledgers->query();
				$query->insert(['transaction_date', 'ledger_account_id', 'voucher_source', 'credit', 'debit','company_id','ref_no'])
				->values([
					'transaction_date' => date('Y-m-d', strtotime($this->request->data['transaction_date'])),
					'ledger_account_id' => $this->request->data['ledger_account_id'],
					'voucher_source' => $this->request->data['voucher_source'],
					'credit' => $this->request->data['credit'][$row],
					'debit' => $this->request->data['debit'][$row],
					'company_id' => $company_id,
					'ref_no' => $this->request->data['reference_no'][$row]
				])
				->execute();
			 
			
				////////////////  ReferenceDetails ////////////////////////////////
				$query1 = $this->Ledgers->ReferenceDetails->query();
				$query1->insert(['reference_no', 'ledger_account_id', 'credit', 'debit', 'reference_type'])
				->values([
					'ledger_account_id' => $this->request->data['ledger_account_id'],
					'reference_no' => $this->request->data['reference_no'][$row],
					'credit' => $this->request->data['credit'][$row],
					'debit' => $this->request->data['debit'][$row],
					'reference_type' => 'New Reference'
				])
				->execute();
				
				////////////////  ReferenceBalances ////////////////////////////////
				$query2 = $this->Ledgers->ReferenceBalances->query();
				$query2->insert(['reference_no', 'ledger_account_id', 'credit', 'debit'])
				->values([
					'reference_no' => $this->request->data['reference_no'][$row],
					'ledger_account_id' => $this->request->data['ledger_account_id'],
					'credit' => $this->request->data['credit'][$row],
					'debit' => $this->request->data['debit'][$row]
				])
				->execute();
		   }//exit;
		   return $this->redirect(['action' => 'Opening_balance']);
			}
        }
		
		
        $ledgerAccounts = $this->Ledgers->LedgerAccounts->find('list',
			['keyField' => function ($row) {
				return $row['id'];
			},
			'valueField' => function ($row) {
				if(!empty($row['alias'])){
					return  $row['name'] . ' (' . $row['alias'] . ')';
				}else{
					return $row['name'];
				}
				
			}])->where(['company_id'=>$company_id])->contain(['AccountSecondSubgroups'=>['AccountFirstSubgroups'=>['AccountGroups'=>['AccountCategories'=>function($q){
				return $q->where(['AccountCategories.id IN'=>[1,2]]);
			}]]]]);
        $this->set(compact('ledger', 'ledgerAccounts','financial_year'));
        $this->set('_serialize', ['ledger']);
    }
	
	
	
	public function checkReferenceNo()
    {
		$reference_no=$this->request->query['reference_no'][0];
		$ledger_account_id=$this->request->query['ledger_account_id'];
		
		$ReferenceDetails=$this->Ledgers->ReferenceBalances->find()
		->where(['reference_no' => $reference_no,'ledger_account_id' => $ledger_account_id])
		->count();
		
		if(empty($ReferenceDetails))
		{
			$output="true";
		}
		else
		{
			$output="false";
		}
		
		$this->response->body($output);
		return $this->response;
	}
	public function AccountStatementRefrence (){
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$status=$this->request->query('status');
		$ledger_account_id=$this->request->query('ledgerid');
		
		if($ledger_account_id > 0 && $status=='Pending'){  
		$this->redirect(['controller'=>'Ledgers','action' => 'findDate/'.$ledger_account_id]);
		}else{ 
		$this->viewBuilder()->layout('index_layout');
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $st_year_id = $session->read('st_year_id');
		$ledger_account_id=$this->request->query('ledgerid');
		$financial_year = $this->Ledgers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$SessionCheckDate = $this->FinancialYears->get($st_year_id);
		$from = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
		$To = date("Y-m-d"); 
		$this->set(compact('ledger_account_id'));
		$status=$this->request->query('status');
		//pr($ledger_account_id); exit;
		
		
		//exit;
		$ReferenceBalance_transaction_date=[];
		$ReferenceBalance_due_date=[];
		if($ledger_account_id)
		{
		$Ledger_Account_data = $this->Ledgers->LedgerAccounts->get($ledger_account_id, [
        'contain' => ['AccountSecondSubgroups'=>['AccountFirstSubgroups'=>['AccountGroups'=>['AccountCategories']]]] ]);
		
		if($Ledger_Account_data->source_model=='Customers'){
			$customer_data = $this->Ledgers->LedgerAccounts->Customers->get($Ledger_Account_data->source_id);
			$customer_ledger_data = $this->Ledgers->find()->where(['Ledgers.ledger_account_id'=>$ledger_account_id]);
			//pr($customer_ledger_data->toArray()); exit;
		}
		
		$Ledgers = $this->Ledgers->find()->where(['Ledgers.ledger_account_id'=>$ledger_account_id]);
		
		$ledger_amt = $this->Ledgers->find()->where(['Ledgers.ledger_account_id'=>$ledger_account_id]);
		$ledger_amt->select([
			'Debit' => $ledger_amt->func()->sum('Debit'),
			'Credit' => $ledger_amt->func()->sum('Credit')
		]);
		
		$ledger_amt=@$ledger_amt->first();
		//$ledger_amt=@$ledger_amt->first();
		
		
		$ReferenceBalances = $this->Ledgers->ReferenceBalances->find()->where(['ReferenceBalances.ledger_account_id'=>$ledger_account_id]);
		//pr($ReferenceBalances->toArray()); exit;
		
		$ref_amt = $this->Ledgers->ReferenceDetails->find()->where(['ReferenceDetails.ledger_account_id'=>$ledger_account_id]);
		$ref_amt->select([
			'debit' => $ref_amt->func()->sum('debit'),
			'credit' => $ref_amt->func()->sum('credit')
		]);
		
		$ref_amt=$ref_amt->first(); 
		
		}
		
		$ledger=$this->Ledgers->LedgerAccounts->find('list',
			['keyField' => function ($row) {
				return $row['id'];
			},
			'valueField' => function ($row) {
				if(!empty($row['alias'])){
					return  $row['name'] . ' (' . $row['alias'] . ')';
				}else{
					return $row['name'];
				}
				
			}])->where(['company_id'=>$st_company_id]);
			
			$this->set(compact('Ledgers','ledger','financial_year','ReferenceBalances','Ledger_Account_data','ref_amt','ledger_amt','url'));
		}
	}
	
	public function excelExportAccountRef(){
		$status=$this->request->query('status');
		$ledger_account_id=$this->request->query('ledgerid');
		
		if($ledger_account_id > 0 && $status=='Pending'){  
		$this->redirect(['controller'=>'Ledgers','action' => 'findDate/'.$ledger_account_id]);
		}else{ 
		$this->viewBuilder()->layout('');
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $st_year_id = $session->read('st_year_id');
		$ledger_account_id=$this->request->query('ledgerid');
		$financial_year = $this->Ledgers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$SessionCheckDate = $this->FinancialYears->get($st_year_id);
		$from = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
		$To = date("Y-m-d"); 
		$this->set(compact('ledger_account_id'));
		$status=$this->request->query('status');
		//pr($ledger_account_id); exit;
		
		
		//exit;
		$ReferenceBalance_transaction_date=[];
		$ReferenceBalance_due_date=[];
		if($ledger_account_id)
		{
		$Ledger_Account_data = $this->Ledgers->LedgerAccounts->get($ledger_account_id, [
        'contain' => ['AccountSecondSubgroups'=>['AccountFirstSubgroups'=>['AccountGroups'=>['AccountCategories']]]] ]);
		
		if($Ledger_Account_data->source_model=='Customers'){
			$customer_data = $this->Ledgers->LedgerAccounts->Customers->get($Ledger_Account_data->source_id);
			$customer_ledger_data = $this->Ledgers->find()->where(['Ledgers.ledger_account_id'=>$ledger_account_id]);
			//pr($customer_ledger_data->toArray()); exit;
		}
		
		$Ledgers = $this->Ledgers->find()->where(['Ledgers.ledger_account_id'=>$ledger_account_id]);
		
		$ledger_amt = $this->Ledgers->find()->where(['Ledgers.ledger_account_id'=>$ledger_account_id]);
		$ledger_amt->select([
			'Debit' => $ledger_amt->func()->sum('Debit'),
			'Credit' => $ledger_amt->func()->sum('Credit')
		]);
		
		$ledger_amt=@$ledger_amt->first();
		//$ledger_amt=@$ledger_amt->first();
		
		
		$ReferenceBalances = $this->Ledgers->ReferenceBalances->find()->where(['ReferenceBalances.ledger_account_id'=>$ledger_account_id]);
		//pr($ReferenceBalances->toArray()); exit;
		
		$ref_amt = $this->Ledgers->ReferenceDetails->find()->where(['ReferenceDetails.ledger_account_id'=>$ledger_account_id]);
		$ref_amt->select([
			'debit' => $ref_amt->func()->sum('debit'),
			'credit' => $ref_amt->func()->sum('credit')
		]);
		
		$ref_amt=$ref_amt->first(); 
		
		}
		
		$ledger=$this->Ledgers->LedgerAccounts->find('list',
			['keyField' => function ($row) {
				return $row['id'];
			},
			'valueField' => function ($row) {
				if(!empty($row['alias'])){
					return  $row['name'] . ' (' . $row['alias'] . ')';
				}else{
					return $row['name'];
				}
				
			}])->where(['company_id'=>$st_company_id]);
			
			$this->set(compact('Ledgers','ledger','financial_year','ReferenceBalances','Ledger_Account_data','ref_amt','ledger_amt'));
		}
	}
	public function AccountStatement (){
		$this->viewBuilder()->layout('index_layout');
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $st_year_id = $session->read('st_year_id');
		$ledger_account_id=$this->request->query('ledger_account_id');
		$financial_year = $this->Ledgers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$SessionCheckDate = $this->FinancialYears->get($st_year_id);
		$from = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
		$To = date("Y-m-d"); 
		if($ledger_account_id)
		{
			$Ledger_Account_data = $this->Ledgers->LedgerAccounts->get($ledger_account_id, [
            'contain' => ['AccountSecondSubgroups'=>['AccountFirstSubgroups'=>['AccountGroups'=>['AccountCategories']]]]
        ]);
			
			$from = $this->request->query['From'];
			$To = $this->request->query['To'];
			$transaction_from_date= date('Y-m-d', strtotime($from));
			$transaction_to_date= date('Y-m-d', strtotime($To));
			$this->set(compact('from','To','transaction_from_date','transaction_to_date'));
			//pr($from); exit;
			if($from == '01-04-2017'){
				$OB = $this->Ledgers->find()->where(['ledger_account_id'=>$ledger_account_id,'transaction_date  '=>$transaction_from_date]);
				$opening_balance_ar=[];
			foreach($OB as $Ledger)
				{
					if($Ledger->voucher_source== "Opening Balance"){
						@$opening_balance_ar['debit']+=$Ledger->debit;
						@$opening_balance_ar['credit']+=$Ledger->credit;
					}
				}	
			}else{
				$OB = $this->Ledgers->find()->where(['ledger_account_id'=>$ledger_account_id,'transaction_date  <'=>$transaction_from_date]);
		
				$opening_balance_ar=[];
				foreach($OB as $Ledger)
					{
						
							@$opening_balance_ar['debit']+=$Ledger->debit;
							@$opening_balance_ar['credit']+=$Ledger->credit;
					}	
			}
			
			$Ledgers = $this->Ledgers->find()
				->where(['ledger_account_id'=>$ledger_account_id,'company_id'=>$st_company_id])
				->where(function($exp) use($transaction_from_date,$transaction_to_date){
					return $exp->between('transaction_date', $transaction_from_date, $transaction_to_date, 'date');
				})->order(['transaction_date' => 'DESC']);
				//pr($Ledgers->toArray()); exit;
		
			$url_link=[];
			foreach($Ledgers as $ledger){
				if($ledger->voucher_source=="Journal Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->JournalVouchers->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Payment Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->Payments->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Petty Cash Payment Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->PettyCashVouchers->get($ledger->voucher_id);
					//pr($url_link[$ledger->id]); exit;
				}else if($ledger->voucher_source=="Contra Voucher"){
					$url_link[$ledger->id]=$this->Ledgers->ContraVouchers->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Receipt Voucher"){
				$url_link[$ledger->id]=$this->Ledgers->Receipts->get($ledger->voucher_id); 
				}else if($ledger->voucher_source=="Invoice"){ 
					$inq=$this->Ledgers->Invoices->get($ledger->voucher_id);
					if($inq->sale_tax_id==0){
						$url_link[$ledger->id]=$this->Ledgers->Invoices->get($ledger->voucher_id, [
							'contain' => ['Customers']
						]);
					}else{
						$url_link[$ledger->id]=$this->Ledgers->Invoices->get($ledger->voucher_id, [
							'contain' => ['Customers','SaleTaxes']
						]);
					}
					
					
				}else if($ledger->voucher_source=="Invoice Booking"){
					$ib=$this->Ledgers->InvoiceBookings->get($ledger->voucher_id);
					if($ib->cst_vat=='vat'){
						$url_link[$ledger->id]=$this->Ledgers->InvoiceBookings->get($ledger->voucher_id, [
							'contain' => ['Vendors','InvoiceBookingRows']
						]);
					}else{
						$url_link[$ledger->id]=$this->Ledgers->InvoiceBookings->get($ledger->voucher_id, [
							'contain' => ['Vendors','InvoiceBookingRows']
						]);
					}
				}else if($ledger->voucher_source=="Non Print Payment Voucher"){ 
						
					$url_link[$ledger->id]=$this->Ledgers->Nppayments->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Debit Note"){
					$url_link[$ledger->id]=$this->Ledgers->DebitNotes->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Credit Note"){
					$url_link[$ledger->id]=$this->Ledgers->CreditNotes->get($ledger->voucher_id);
				}else if($ledger->voucher_source=="Purchase Return"){
					$url_link[$ledger->id]=$this->Ledgers->PurchaseReturns->get($ledger->voucher_id);
				}
			}
		}			
			//pr($url_link); exit;
			$ledger=$this->Ledgers->LedgerAccounts->find('list',
				['keyField' => function ($row) {
					return $row['id'];
				},
				'valueField' => function ($row) {
					if(!empty($row['alias'])){
						return  $row['name'] . ' (' . $row['alias'] . ')';
					}else{
						return $row['name'];
					}
					
				}])->where(['company_id'=>$st_company_id]);
		//pr($opening_balance_ar); exit;
			$this->set(compact('Ledgers','ledger','ledger_account_id','Ledger_Account_data','url_link','transaction_from_date','transaction_to_date','financial_year','from','To','opening_balance_ar'));	
			$this->set(compact('url'));			
		
	}
	

	
	public function openingBalanceView (){
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$ledger_name=$this->request->query('ledger_name');
		
		$OpeningBalanceViews = $this->paginate($this->Ledgers->find()
		->contain(['LedgerAccounts'=>function($q) use($ledger_name){
			return $q->where(['LedgerAccounts.name LIKE'=>'%'.$ledger_name.'%']);
		}])
		->where(['Ledgers.company_id'=>$st_company_id,'Ledgers.voucher_source'=>'Opening Balance']));
		//pr($OpeningBalanceViews->toArray()); exit;
		$this->set(compact('OpeningBalanceViews', 'ledger_name'));
	}
	
	public function bankReconciliationAdd () {
		
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $st_year_id = $session->read('st_year_id');
		$ledger_account_id=$this->request->query('ledger_account_id');
		$financial_year = $this->Ledgers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$SessionCheckDate = $this->FinancialYears->get($st_year_id);
		$from=$this->request->query['From'];
		$To=$this->request->query['To'];
		$bankReconciliationAdd = $this->Ledgers->newEntity();
		if(@$ledger_account_id)
		{
			$transaction_from_date= date('Y-m-d', strtotime($this->request->query['From']));
			$transaction_to_date= date('Y-m-d', strtotime($this->request->query['To']));
			$Bank_Ledgers = $this->Ledgers->find()
				->where(['ledger_account_id'=>$ledger_account_id,'company_id'=>$st_company_id,'voucher_source NOT IN'=>'Opening Balance'
				])
				->where(function($exp) use($transaction_from_date,$transaction_to_date){
					$between = clone $exp;
					return $exp->between('transaction_date', $transaction_from_date, $transaction_to_date, 'date')
					->not($between->between('reconciliation_date', $transaction_from_date, $transaction_to_date, 'date'));
				})->order('transaction_date','ASC');
		}
		
		
		if($ledger_account_id)
		{
			$Ledger_Account_data = $this->Ledgers->LedgerAccounts->get($ledger_account_id, [
            'contain' => ['AccountSecondSubgroups'=>['AccountFirstSubgroups'=>['AccountGroups'=>['AccountCategories']]]]
        ]);
			
			$from = $this->request->query['From'];
			
			$To = $this->request->query['To'];
			
			$transaction_from_date= date('Y-m-d', strtotime($this->request->query['From']));
			$transaction_to_date= date('Y-m-d', strtotime($this->request->query['To']));
			
			$this->set(compact('from','To','transaction_from_date','transaction_to_date'));
			
			
			$OB = $this->Ledgers->find()->where(['ledger_account_id'=>$ledger_account_id,'transaction_date  <='=>$transaction_to_date]);
					
				$opening_balance_ar=[];
			foreach($OB as $Ledger)
				{
					
						@$opening_balance_ar['debit']+=$Ledger->debit;
						@$opening_balance_ar['credit']+=$Ledger->credit;
					
				}	
				//pr($opening_balance_ar);exit;
				//pr($opening_balance_ar);exit;
			//pr($from); exit;
			/* if($from == '01-04-2017'){
				$OB = $this->Ledgers->find()->where(['ledger_account_id'=>$ledger_account_id,'transaction_date  '=>$transaction_from_date]);
				$opening_balance_ar=[];
			foreach($OB as $Ledger)
				{
					if($Ledger->voucher_source== "Opening Balance"){
						@$opening_balance_ar['debit']+=$Ledger->debit;
						@$opening_balance_ar['credit']+=$Ledger->credit;
					}
				}	
			}else{
				$OB = $this->Ledgers->find()->where(['ledger_account_id'=>$ledger_account_id,'transaction_date  <'=>$transaction_from_date]);
		
				$opening_balance_ar=[];
				foreach($OB as $Ledger)
					{
						
							@$opening_balance_ar['debit']+=$Ledger->debit;
							@$opening_balance_ar['credit']+=$Ledger->credit;
					}	
			} */
			
			$Ledgers = $this->Ledgers->find()
				->where(['ledger_account_id'=>$ledger_account_id,'company_id'=>$st_company_id])
				->where(function($exp) use($transaction_from_date,$transaction_to_date){
					$between = clone $exp;
					return $exp->between('transaction_date', $transaction_from_date, $transaction_to_date, 'date')
					->not($between->between('reconciliation_date', $transaction_from_date, $transaction_to_date, 'date'));
				})->order('transaction_date','ASC');
				//pr($Ledgers->toArray()); exit;
		
			
		}	
		
		
		$vr=$this->Ledgers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Bank Reconciliation Add','sub_entity'=>'Bank'])->first();
		$bankReconciliation=$vr->id;
		$vouchersReferences = $this->Ledgers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		$BankCashes_selected='yes';
		//pr(sizeof($where)); exit;
		if(sizeof($where)>0){
			$banks = $this->Ledgers->LedgerAccounts->find('list',
				['keyField' => function ($row) {
					return $row['id'];
				},
				'valueField' => function ($row) {
					if(!empty($row['alias'])){
						return  $row['name'] . ' (' . $row['alias'] . ')';
					}else{
						return $row['name'];
					}
					
				}])->where(['LedgerAccounts.id IN' => $where]);
		}else{
			$BankCashes_selected='no';
		}
		if(@$ledger_account_id)
		{
		$bank_ledger_data=$this->Ledgers->LedgerAccounts->get($ledger_account_id);
		}
		$this->set(compact('bankReconciliationAdd','banks','Bank_Ledgers','ledger_account_id','bank_ledger_data','Ledgers','ledger','ledger_account_id','Ledger_Account_data','url_link','transaction_from_date','transaction_to_date','financial_year','from','To','opening_balance_ar'));
	}
	public function dateUpdate($ledger_id=null,$reconciliation_date=null){
		$this->viewBuilder()->layout('');
		//$ledger = $this->Ledgers->get($id);
		if($reconciliation_date=="yes"){
		$reconciliation_date="0000-00-00";
		}else{
		$reconciliation_date=date("Y-m-d",strtotime($reconciliation_date));
		}
	//	pr($reconciliation_date)
		$query = $this->Ledgers->query();
		$query->update()
		->set(['reconciliation_date' => $reconciliation_date])
		->where(['id' => $ledger_id])
		->execute();
		$this->set(compact('reconciliation_date','ledger_id','reconciliation_date'));
	}
	
	public function bankReconciliationView () {
		
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $st_year_id = $session->read('st_year_id');
		$ledger_account_id=$this->request->query('ledger_account_id');
		$financial_year = $this->Ledgers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		
		$from =$this->request->query['From'];
		$To =$this->request->query['To'];
		$bankReconciliationAdd = $this->Ledgers->newEntity();
		if($ledger_account_id)
		{
			$transaction_from_date= date('Y-m-d', strtotime($this->request->query['From']));
			$transaction_to_date= date('Y-m-d', strtotime($this->request->query['To']));

			$Bank_Ledgers = $this->Ledgers->find()
				->where(['ledger_account_id'=>$ledger_account_id,'company_id'=>$st_company_id,'reconciliation_date >'=>'0000-00-00','voucher_source NOT IN'=>'Opening Balance'])
				->where(function($exp) use($transaction_from_date,$transaction_to_date){
					return $exp->between('transaction_date', $transaction_from_date, $transaction_to_date, 'date');
				})->order('transaction_date','ASC');
				//pr($Bank_Ledgers->toArray()); exit;
		}

		$vr=$this->Ledgers->VouchersReferences->find()->where(['company_id'=>$st_company_id,'module'=>'Bank Reconciliation Add','sub_entity'=>'Bank'])->first();
		$bankReconciliation=$vr->id;
		$vouchersReferences = $this->Ledgers->VouchersReferences->get($vr->id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		
		$where=[];
		foreach($vouchersReferences->voucher_ledger_accounts as $data){
			$where[]=$data->ledger_account_id;
		}
		$BankCashes_selected='yes';
		
		if(sizeof($where)>0){
			$banks = $this->Ledgers->LedgerAccounts->find('list',
				['keyField' => function ($row) {
					return $row['id'];
				},
				'valueField' => function ($row) {
					if(!empty($row['alias'])){
						return  $row['name'] . ' (' . $row['alias'] . ')';
					}else{
						return $row['name'];
					}
					
				}])->where(['LedgerAccounts.id IN' => $where]);
		}else{
			$BankCashes_selected='no';
		}
		if(@$ledger_account_id)
		{
		$bank_ledger_data=$this->Ledgers->LedgerAccounts->get($ledger_account_id);
		}
		$this->set(compact('bankReconciliationAdd','banks','Bank_Ledgers','ledger_account_id','bank_ledger_data','To','financial_year'));
	}
	public function findDate($ledger_account_id=null){ 
	
		$ReferenceDetails =$this->Ledgers->ReferenceDetails->find()->where(['ledger_account_id'=>$ledger_account_id]);
		//pr($ReferenceDetails->toArray()); exit;
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->Ledgers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		foreach($ReferenceDetails as $ReferenceDetail){
			 if($ReferenceDetail->invoice_id !=0){  
				$Receipt =$this->Ledgers->Invoices->get($ReferenceDetail->invoice_id);
				$Customer =$this->Ledgers->Customers->get($Receipt->customer_id);
				$date = date("Y-m-d", strtotime($Receipt->date_created));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Ledgers->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
			}else if($ReferenceDetail->receipt_id !=0){ 
				$Receipt =$this->Ledgers->Receipts->get($ReferenceDetail->receipt_id);
				
				$LedgerAccount =$this->Ledgers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
				$Customer =$this->Ledgers->Customers->get($LedgerAccount->source_id);
				$date = date("Y-m-d", strtotime($Receipt->created_on));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Ledgers->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
				}
			}else if($ReferenceDetail->payment_id !=0){ 
				$Receipt =$this->Ledgers->Payments->get($ReferenceDetail->payment_id);
				$LedgerAccount =$this->Ledgers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
				$Customer =$this->Ledgers->Customers->get($LedgerAccount->source_id);
				$date = date("Y-m-d", strtotime($Receipt->created_on));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Ledgers->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
				}
			}
			else if($ReferenceDetail->journal_voucher_id !=0){ 
				$Receipt =$this->Ledgers->JournalVouchers->get($ReferenceDetail->journal_voucher_id);
				$LedgerAccount =$this->Ledgers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Ledgers->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Ledgers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
			else if($ReferenceDetail->sale_return_id !=0){ 
				$Receipt =$this->Ledgers->SaleReturns->get($ReferenceDetail->sale_return_id);
				$LedgerAccount =$this->Ledgers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Ledgers->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->date_created));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Ledgers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
			else if($ReferenceDetail->petty_cash_voucher_id !=0){ 
				$Receipt =$this->Ledgers->PettyCashVouchers->get($ReferenceDetail->petty_cash_voucher_id);
				$LedgerAccount =$this->Ledgers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Ledgers->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Ledgers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->nppayment_id !=0){ 
				$Receipt =$this->Ledgers->Nppayments->get($ReferenceDetail->nppayment_id);
				$LedgerAccount =$this->Ledgers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Ledgers->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Ledgers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->contra_voucher_id !=0){ 
				$Receipt =$this->Ledgers->ContraVouchers->get($ReferenceDetail->contra_voucher_id);
				$LedgerAccount =$this->Ledgers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Ledgers->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Ledgers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->debit_note_id !=0){ 
				$Receipt =$this->Ledgers->DebitNotes->get($ReferenceDetail->debit_note_id);
				$LedgerAccount =$this->Ledgers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Ledgers->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Ledgers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->credit_note_id !=0){ 
				$Receipt =$this->Ledgers->CreditNotes->get($ReferenceDetail->credit_note_id);
				$LedgerAccount =$this->Ledgers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Ledgers->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Ledgers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->invoice_booking_id !=0){ 
				$Receipt =$this->Ledgers->InvoiceBookings->get($ReferenceDetail->invoice_booking_id);
				$LedgerAccount =$this->Ledgers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Ledgers->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Ledgers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else {  
				@$LedgerAccount =$this->Ledgers->LedgerAccounts->get(@$ReferenceDetail->ledger_account_id); 
				if($LedgerAccount->source_model=='Customers' && $LedgerAccount->source_id !=0){
					$Customer =$this->Ledgers->Customers->get(@$LedgerAccount->source_id);
					$date = $financial_year->date_from;
					$due_date= $financial_year->date_from;
					//pr($due_date); exit;
					$query = $this->Ledgers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
		}
		$status="Completed";
		$this->redirect(['controller'=>'Ledgers','action' => 'AccountStatementRefrence?status='.$status.'&ledgerid='.$ledger_account_id]);
		
   }
	
	public function getAllLedgers(){
		$Ledgers25 = $this->Ledgers->find()->where(['Ledgers.company_id'=>'25','voucher_source'=>'Opening Balance'])->contain(['LedgerAccounts']);
		$Ledgers26 = $this->Ledgers->find()->where(['Ledgers.company_id'=>'26','voucher_source'=>'Opening Balance'])->contain(['LedgerAccounts']);
		$Ledgers27 = $this->Ledgers->find()->where(['Ledgers.company_id'=>'27','voucher_source'=>'Opening Balance'])->contain(['LedgerAccounts']);
		$this->set(compact('Ledgers25','Ledgers26','Ledgers27'));
	}
}
