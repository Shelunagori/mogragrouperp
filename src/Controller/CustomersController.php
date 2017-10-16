<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\I18n\Date;


/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 */
class CustomersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
	
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		$where=[];
		$customer=$this->request->query('customer');
		$district=$this->request->query('district');
		$customer_seg=$this->request->query('customer_seg');
		$this->set(compact('customer','district','customer_seg'));
		if(!empty($customer)){
			$where['customer_name LIKE']='%'.$customer.'%';
		}
		if(!empty($district)){
			$where['districts.district LIKE']='%'.$district.'%';
		}
		if(!empty($customer_seg)){
			$where['customerSegs.name LIKE']='%'.$customer_seg.'%';
		}
        $this->paginate = [
            'contain' => ['Districts', 'CustomerSegs']
        ];
        $customers = $this->paginate($this->Customers->find()->where($where)->order(['Customers.customer_name' => 'ASC']));
        $this->set(compact('customers'));
        $this->set('_serialize', ['customers']);
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $customer = $this->Customers->get($id, [
            'contain' => ['Districts', 'CustomerSegs', 'CustomerContacts', 'Quotations','CustomerAddress']
        ]);

        $this->set('customer', $customer);
        $this->set('_serialize', ['customer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $VouchersReferences = $this->Customers->VouchersReferences->find()->toArray();
		
        $customer = $this->Customers->newEntity();
        if ($this->request->is('post')) {
            $customer = $this->Customers->patchEntity($customer, $this->request->data);
			
			$billTobill=$customer->bill_to_bill_account;
			//pr($customer); exit;
            if ($this->Customers->save($customer)) {
				
				foreach($customer->companies as $data)
				{
				$ledgerAccount = $this->Customers->LedgerAccounts->newEntity();
				$ledgerAccount->account_second_subgroup_id = $customer->account_second_subgroup_id;
				$ledgerAccount->name = $customer->customer_name;
				$ledgerAccount->alias = $customer->alias;
				$ledgerAccount->bill_to_bill_account = $billTobill;
				$ledgerAccount->source_model = 'Customers';
				$ledgerAccount->source_id = $customer->id;
				$ledgerAccount->company_id = $data->id;
				$this->Customers->LedgerAccounts->save($ledgerAccount);
				$VouchersReferences = $this->Customers->VouchersReferences->find()->where(['company_id'=>$data->id,'voucher_entity'=>'Receipt Voucher -> Received From'])->first();
				$voucherLedgerAccount = $this->Customers->VoucherLedgerAccounts->newEntity();
				$voucherLedgerAccount->vouchers_reference_id =$VouchersReferences->id;
				$voucherLedgerAccount->ledger_account_id =$ledgerAccount->id;
				$this->Customers->VoucherLedgerAccounts->save($voucherLedgerAccount);
				}
				$this->Flash->success(__('The Customer has been saved.'));
					return $this->redirect(['action' => 'index']);
				
				
            } else { 
                $this->Flash->error(__('The customer could not be saved. Please, try again.'));
            }
			
        }
        $districts = $this->Customers->Districts->find('list')->order(['Districts.District' => 'ASC']);
        $companyGroups = $this->Customers->CompanyGroups->find('list', ['limit' => 200]);
		$CustomerGroups = $this->Customers->CustomerGroups->find('list')->order(['CustomerGroups.name' => 'ASC']);
        $customerSegs = $this->Customers->CustomerSegs->find('list')->order(['CustomerSegs.name' => 'ASC']);
		/* $employees = $this->Customers->Employees->find('list', ['limit' => 200])->where(['dipartment_id' => 1])->order(['Employees.name' => 'ASC']); */
		
		 $employees = $this->Customers->Employees->find('list')->where(['dipartment_id' => 1])->order(['Employees.name' => 'ASC'])->matching(
					'EmployeeCompanies', function ($q) use($st_company_id) {
						return $q->where(['EmployeeCompanies.company_id' => $st_company_id,'EmployeeCompanies.freeze' => 0]);
					}
				); 
		
		
		$transporters = $this->Customers->Transporters->find('list')->order(['Transporters.transporter_name' => 'ASC']);
		$AccountCategories = $this->Customers->AccountCategories->find('list')->order(['AccountCategories.name' => 'ASC']);
		$Companies = $this->Customers->Companies->find('list');
        $this->set(compact('customer', 'districts', 'companyGroups', 'customerSegs','employees','transporters','CustomerGroups','AccountCategories','Companies'));
		$this->set('_serialize', ['customer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $customer = $this->Customers->get($id, [
            'contain' => ['CustomerContacts','CustomerAddress']
        ]);
		
        if ($this->request->is(['patch', 'post', 'put'])) {
			
            $customer = $this->Customers->patchEntity($customer, $this->request->data);
			//pr(); exit;
            if ($this->Customers->save($customer)) {
				
				$query = $this->Customers->LedgerAccounts->query();
					$query->update()
						->set(['bill_to_bill_account' => $customer->bill_to_bill_account])
						->set(['account_second_subgroup_id' => $customer->account_second_subgroup_id])
						->where(['id' => $customer->ledger_account_id])
						->execute();
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The customer could not be saved. Please, try again.'));
            }
        }
        $districts = $this->Customers->Districts->find('list')->order(['Districts.District' => 'ASC']);
        $companyGroups = $this->Customers->CompanyGroups->find('list', ['limit' => 200]);
		$CustomerGroups = $this->Customers->CustomerGroups->find('list')->order(['CustomerGroups.name' => 'ASC']);
        $customerSegs = $this->Customers->CustomerSegs->find('list')->order(['CustomerSegs.name' => 'ASC']);
		$employees = $this->Customers->Employees->find('list')->where(['dipartment_id' => 1])->order(['Employees.name' => 'ASC'])->matching(
					'EmployeeCompanies', function ($q) use($st_company_id) {
						return $q->where(['EmployeeCompanies.company_id' => $st_company_id,'EmployeeCompanies.freeze' => 0]);
					}
				); 
		
		$transporters = $this->Customers->Transporters->find('list')->order(['Transporters.transporter_name' => 'ASC']);
		$AccountCategories = $this->Customers->AccountCategories->find('list');
		$AccountGroups = $this->Customers->AccountGroups->find('list');
		$AccountFirstSubgroups = $this->Customers->AccountFirstSubgroups->find('list');
		$AccountSecondSubgroups = $this->Customers->AccountSecondSubgroups->find('list');
		
        $this->set(compact('customer', 'districts', 'companyGroups', 'customerSegs','employees','transporters','CustomerGroups','AccountCategories','AccountGroups','AccountFirstSubgroups','AccountSecondSubgroups'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$Quotationsexists = $this->Customers->Quotations->exists(['customer_id' => $id]);
		$SalesOrdersexists = $this->Customers->SalesOrders->exists(['customer_id' => $id]);
		$Invoicesexists = $this->Customers->Invoices->exists(['customer_id' => $id]);
		$Filenamesexists = $this->Customers->Filenames->exists(['customer_id' => $id]);
		if(!$Quotationsexists and !$SalesOrdersexists and !$Invoicesexists and !$Filenamesexists){
			$customer = $this->Customers->get($id);
			if ($this->Customers->delete($customer)) {
				$this->Flash->success(__('The customer has been deleted.'));
			} else {
				$this->Flash->error(__('The customer could not be deleted. Please, try again.'));
			}
		}elseif($Quotationsexists){
			$this->Flash->error(__('Once the quotations has generated with customer, the customer cannot be deleted.'));
		}elseif($SalesOrdersexists){
			$this->Flash->error(__('Once the sales-order has generated with customer, the customer cannot be deleted.'));
		}elseif($Invoicesexists){
			$this->Flash->error(__('Once the invoice has generated with customer, the customer cannot be deleted.'));
		}elseif($Filenamesexists){
			$this->Flash->error(__('Once the File has generated with customer, the customer cannot be deleted.'));
		}
		
        return $this->redirect(['action' => 'index']);
    }
	
	
	
	public function addressList($id = null)
    {
		$this->viewBuilder()->layout('ajax_layout');
		
		if(empty($id)){
			echo 'Please Select Customer First.'; exit;
		}
        $customer = $this->Customers->get($id, [
            'contain' => ['CustomerAddress']
        ]);

        $this->set('customer', $customer);
        $this->set('_serialize', ['customer']);
    }
	
	public function defaultAddress($id = null)
    { 
		$this->viewBuilder()->layout('');
		
		if(empty($id)){
			echo ''; exit;
		}
		$defaultAddress = $this->Customers->CustomerAddress->find('all')->where(['customer_id' => $id,'default_address' => 1])->first();
		//pr($defaultAddress); exit;
		echo $defaultAddress->address; 
    }
	public function checkAddress($id = null)
    { 
		$defaultAddress = $this->Customers->find()->contain(['Districts'])->where(['Customers.id' => $id]);
		foreach($defaultAddress as $district)
		{
			if($district->district->state_id=='8')
			{
				echo "Rajasthan";
			}
			else
			{
				echo "other";
			}
		}
      exit;		
    }
	
	public function defaultContact($id = null)
    {
		$this->viewBuilder()->layout('');
		
		if(empty($id)){
			echo ''; exit;
		}
		$defaultContact = $this->Customers->CustomerContacts->find('all')->where(['customer_id' => $id,'default_contact' => 1])->first();
		$result=json_encode(array('contact_person'=>$defaultContact->contact_person,'mobile'=>$defaultContact->mobile));
		die($result);
    }
	
	public function BreakupRangeOverdue(){
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$request=$this->request->query('request');
		
		
		$range_data=[];
		if($request == 'vendor'){
				if ($this->request->is(['post'])) {
			$range_data['range0']=$this->request->data['range_0']; 
			$range_data['range1']=$this->request->data['range_1']; 
			$range_data['range2']=$this->request->data['range_2']; 
			$range_data['range3']=$this->request->data['range_3']; 
			$range_data['range4']=$this->request->data['range_4']; 
			$range_data['range5']=$this->request->data['range_5']; 
			$range_data['range6']=$this->request->data['range_6']; 
			$range_data['range7']=$this->request->data['range_7']; 
			$range_data['tdate']=$this->request->data['to'];
			$to=json_encode($range_data);  
			$this->redirect(['controller'=>'Vendors','action' => 'OverDueReport/'.$to.'']);
			//$this->redirect(['controller'=>'Vendors','action' => 'exportExcel/'.$to.'']);
		 }
		}
		if($request == 'customer'){
			if ($this->request->is(['post'])) {
			$range_data['range0']=$this->request->data['range_0']; 
			$range_data['range1']=$this->request->data['range_1']; 
			$range_data['range2']=$this->request->data['range_2']; 
			$range_data['range3']=$this->request->data['range_3']; 
			$range_data['range4']=$this->request->data['range_4']; 
			$range_data['range5']=$this->request->data['range_5']; 
			$range_data['range6']=$this->request->data['range_6']; 
			$range_data['range7']=$this->request->data['range_7']; 
			$range_data['tdate']=$this->request->data['to'];
			
		$to=json_encode($range_data);  
		$this->redirect(['controller'=>'Customers','action' => 'OverDueReport/'.$to.'']);
		//$this->redirect(['controller'=>'Customers','action' => 'exportExcel/'.$to.'']);
		 }
		}
	}
	
	public function exportExcel($to_send = null){
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$show_data = $this->request->query('total');
		$stock=$this->request->query('total');
		
		$to_range_datas =json_decode($to_send);
		
		$LedgerAccounts =$this->Customers->LedgerAccounts->find()
			->where(['LedgerAccounts.company_id'=>$st_company_id,'source_model'=>'Customers'])
			->order(['LedgerAccounts.name'=>'ASC']);
		$custmer_payment_terms=[];
		foreach($LedgerAccounts as $LedgerAccount){
			$Customer =$this->Customers->get($LedgerAccount->source_id);
			$custmer_payment_terms[$LedgerAccount->id]=$Customer->payment_terms;
		}
		 
		 
		$ReferenceDetails =$this->Customers->ReferenceDetails->find();

		 foreach($ReferenceDetails as $ReferenceDetail){
			 if($ReferenceDetail->invoice_id !=0){ 
				$Receipt =$this->Customers->Invoices->get($ReferenceDetail->invoice_id);
				$Customer =$this->Customers->get($Receipt->customer_id);
				$date = date("Y-m-d", strtotime($Receipt->date_created));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Customers->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
			}else if($ReferenceDetail->receipt_id !=0){ 
				$Receipt =$this->Customers->Receipts->get($ReferenceDetail->receipt_id);
				
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
				$Customer =$this->Customers->get($LedgerAccount->source_id);
				$date = date("Y-m-d", strtotime($Receipt->created_on));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Customers->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
				}
			}else if($ReferenceDetail->payment_id !=0){ 
				$Receipt =$this->Customers->Payments->get($ReferenceDetail->payment_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
				$Customer =$this->Customers->get($LedgerAccount->source_id);
				$date = date("Y-m-d", strtotime($Receipt->created_on));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Customers->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
				}
			}
			else if($ReferenceDetail->journal_voucher_id !=0){ 
				$Receipt =$this->Customers->JournalVouchers->get($ReferenceDetail->journal_voucher_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
			else if($ReferenceDetail->sale_return_id !=0){ 
				$Receipt =$this->Customers->SaleReturns->get($ReferenceDetail->sale_return_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->date_created));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
			else if($ReferenceDetail->petty_cash_voucher_id !=0){ 
				$Receipt =$this->Customers->PettyCashVouchers->get($ReferenceDetail->petty_cash_voucher_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->nppayment_id !=0){ 
				$Receipt =$this->Customers->Nppayments->get($ReferenceDetail->nppayment_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->contra_voucher_id !=0){ 
				$Receipt =$this->Customers->ContraVouchers->get($ReferenceDetail->contra_voucher_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->debit_note_id !=0){ 
				$Receipt =$this->Customers->DebitNotes->get($ReferenceDetail->debit_note_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->credit_note_id !=0){ 
				$Receipt =$this->Customers->CreditNotes->get($ReferenceDetail->credit_note_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->receipt_id ==0 && $ReferenceDetail->payment_id ==0 &&	$ReferenceDetail->invoice_id == 0 && $ReferenceDetail->invoice_booking_id ==0 &&$ReferenceDetail->credit_note_id ==0 && $ReferenceDetail->journal_voucher_id ==0 &&	$ReferenceDetail->sale_return_id ==0 && $ReferenceDetail->purchase_return_id ==0 && $ReferenceDetail->petty_cash_voucher_id ==0 && $ReferenceDetail->nppayment_id ==0 &&$ReferenceDetail->contra_voucher_id ==0){ 
				//$Receipt =$this->Customers->CreditNotes->get($ReferenceDetail->credit_note_id);
				
				@$LedgerAccount =$this->Customers->LedgerAccounts->get(@$ReferenceDetail->ledger_account_id);
				
				if($LedgerAccount->source_model=='Customers' && $LedgerAccount->source_id !=0){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = '2017-04-01';
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
		}
		$ReferenceBalances =$this->Customers->ReferenceBalances->find()->where(['due_date !='=>'0000-00-00']);
		
		$total_debit_1=[];$total_credit_1=[];$due_1=[];
		$total_debit_2=[];$total_credit_2=[];$due_2=[];
		$total_debit_3=[];$total_credit_3=[];$due_3=[];
		$total_debit_4=[];$total_credit_4=[];$due_4=[];	
		$total_debit_5=[];$total_credit_5=[];$due_5=[];	
		$total_debit_6=[];$total_credit_6=[];$due_6=[];	
		$a=0;
		$on_account_dr=[];
		$on_account_cr=[];
		
		foreach($ReferenceBalances as $ReferenceBalance){
				$now=Date::now();
				$now=date("Y-m-d",strtotime($now));
				
				$over_date1=date("Y-m-d",strtotime($to_range_datas->tdate));
				$over_date2=date("Y-m-d",strtotime("-".$to_range_datas->range1."  day", strtotime($over_date1)));
				$over_date3=date("Y-m-d",strtotime("-".$to_range_datas->range2."  day", strtotime($over_date1)));
				$over_date4=date("Y-m-d",strtotime("-".$to_range_datas->range3."  day", strtotime($over_date1)));
				$over_date5=date("Y-m-d",strtotime("-".$to_range_datas->range4."  day", strtotime($over_date1)));
				$over_date6=date("Y-m-d",strtotime("-".$to_range_datas->range5."  day", strtotime($over_date1)));
				$over_date7=date("Y-m-d",strtotime("-".$to_range_datas->range6."  day", strtotime($over_date1)));
				$over_date8=date("Y-m-d",strtotime("-".$to_range_datas->range7."  day", strtotime($over_date1)));
				
				$ReferenceBalance->due_date=date("Y-m-d",strtotime($ReferenceBalance->due_date));
			
				if($ReferenceBalance->due_date <= $over_date1 && $ReferenceBalance->due_date >=  $over_date2){
					
					if($ReferenceBalance->debit != $ReferenceBalance->credit){
							//pr($over_date1);
							//pr($over_date2); exit;
							if($ReferenceBalance->debit > $ReferenceBalance->credit){ 
								@$total_debit_1[$ReferenceBalance->ledger_account_id]+=@$ReferenceBalance->debit-@$ReferenceBalance->credit;
						
							}else{ 
								$total_credit_1[$ReferenceBalance->ledger_account_id]=@$total_credit_1[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->credit-$ReferenceBalance->debit);
							}
					} 
				}
				else if($ReferenceBalance->due_date <= $over_date3 && $ReferenceBalance->due_date >=  $over_date4){
					if($ReferenceBalance->debit != $ReferenceBalance->credit){	
							if($ReferenceBalance->debit > $ReferenceBalance->credit){
								$total_debit_2[$ReferenceBalance->ledger_account_id]=@$total_debit_2[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->debit-$ReferenceBalance->credit);
							}else{
								$total_credit_2[$ReferenceBalance->ledger_account_id]=@$total_credit_2[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->credit-$ReferenceBalance->debit);
							}
						}
						
				}	
				else if($ReferenceBalance->due_date <= $over_date5 && $ReferenceBalance->due_date >=  $over_date6){
					if($ReferenceBalance->debit != $ReferenceBalance->credit){	
							if($ReferenceBalance->debit > $ReferenceBalance->credit){
								$total_debit_3[$ReferenceBalance->ledger_account_id]=@$total_debit_3[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->debit-$ReferenceBalance->credit);
							}else{
								$total_credit_3[$ReferenceBalance->ledger_account_id]=@$total_credit_3[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->credit-$ReferenceBalance->debit);
							}
						}
						
				}
				else if($ReferenceBalance->due_date <= $over_date7 && $ReferenceBalance->due_date >=  $over_date8){ 
					if($ReferenceBalance->debit != $ReferenceBalance->credit){	
							if($ReferenceBalance->debit > $ReferenceBalance->credit){
								$total_debit_4[$ReferenceBalance->ledger_account_id]=@$total_debit_4[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->debit-$ReferenceBalance->credit);
							}else{
								$total_credit_4[$ReferenceBalance->ledger_account_id]=@$total_credit_4[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->credit-$ReferenceBalance->debit);
							}
						}
						
				}else if($ReferenceBalance->due_date <  $over_date8){
					if($ReferenceBalance->debit != $ReferenceBalance->credit && $ReferenceBalance->due_date){	
							if($ReferenceBalance->debit > $ReferenceBalance->credit){
								$total_debit_5[$ReferenceBalance->ledger_account_id]=@$total_debit_5[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->debit-$ReferenceBalance->credit);
							}else{
								$total_credit_5[$ReferenceBalance->ledger_account_id]=@$total_credit_5[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->credit-$ReferenceBalance->debit);
							}
						}
				}else if($ReferenceBalance->due_date > $over_date1){
					if($ReferenceBalance->debit != $ReferenceBalance->credit){	
							if($ReferenceBalance->debit > $ReferenceBalance->credit){
								$total_debit_6[$ReferenceBalance->ledger_account_id]=@$total_debit_6[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->debit-$ReferenceBalance->credit);
							}else{
								$total_credit_6[$ReferenceBalance->ledger_account_id]=@$total_credit_6[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->credit-$ReferenceBalance->debit);
							}
						}
				}
				$ref_amt = $this->Customers->Ledgers->find()->where(['Ledgers.ledger_account_id'=>$ReferenceBalance->ledger_account_id]);
				$ref_amt->select([
					'Debit' => $ref_amt->func()->sum('Debit'),
					'Credit' => $ref_amt->func()->sum('Credit')
				]);
				$ref_amt=@$ref_amt->first(); 
				$ledger_debit[$ReferenceBalance->ledger_account_id]=$ref_amt['Debit'];
				$ledger_credit[$ReferenceBalance->ledger_account_id]=$ref_amt['Credit'];
				
				$ref_amt1 = $this->Customers->ReferenceBalances->find()->where(['ReferenceBalances.ledger_account_id'=>$ReferenceBalance->ledger_account_id]);
				$ref_amt1->select([
					'debit' => $ref_amt1->func()->sum('debit'),
					'credit' => $ref_amt1->func()->sum('credit')
				]);
				$ref_amt1=@$ref_amt1->first(); 
				$ref_bal_debit[$ReferenceBalance->ledger_account_id]=$ref_amt1['debit'];
				$ref_bal_credit[$ReferenceBalance->ledger_account_id]=$ref_amt1['credit'];
				
				/* $ledger=$this->Customers->Ledgers->find()->where(['ledger_account_id'=>$ReferenceBalance->ledger_account_id,'ref_no'=>$ReferenceBalance->reference_no])->first();
				pr(@$ledger->debit);
				pr(@$ledger->ledger_account_id); */
			}
			
        $this->set(compact('LedgerAccounts','Ledgers','over_due_report','custmer_name','custmer_payment','custmer_alise','custmer_payment_ctp','custmer_payment_range_ctp','over_due_report1','total_overdue','to_range_datas','total_debit_1','total_credit_1','total_debit_2','total_credit_2','total_debit_3','total_credit_4','total_debit_4','total_credit_4','total_debit_5','total_credit_5','total_debit_6','total_credit_6','custmer_payment_terms','ledger_debit','ledger_credit','ref_bal_debit','ref_bal_credit','show_data','stock','over_date1','url','to_send'));
        $this->set('_serialize', ['customers']);
	}
	
	
	public function OverDueReport($to_send = null)
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$this->viewBuilder()->layout('report_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$show_data = $this->request->query('total');
		$stock=$this->request->query('total');
		//pr($stock); exit;
		$to_range_datas =json_decode($to_send);
		$LedgerAccounts =$this->Customers->LedgerAccounts->find()
			->where(['LedgerAccounts.company_id'=>$st_company_id,'source_model'=>'Customers'])
			->order(['LedgerAccounts.name'=>'ASC']);
		$custmer_payment_terms=[];
		foreach($LedgerAccounts as $LedgerAccount){
			$Customer =$this->Customers->get($LedgerAccount->source_id);
			$custmer_payment_terms[$LedgerAccount->id]=$Customer->payment_terms;
		}
		 
		 
		$ReferenceDetails =$this->Customers->ReferenceDetails->find();

		 foreach($ReferenceDetails as $ReferenceDetail){
			 if($ReferenceDetail->invoice_id !=0){ 
				$Receipt =$this->Customers->Invoices->get($ReferenceDetail->invoice_id);
				$Customer =$this->Customers->get($Receipt->customer_id);
				$date = date("Y-m-d", strtotime($Receipt->date_created));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Customers->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
			}else if($ReferenceDetail->receipt_id !=0){ 
				$Receipt =$this->Customers->Receipts->get($ReferenceDetail->receipt_id);
				
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
				$Customer =$this->Customers->get($LedgerAccount->source_id);
				$date = date("Y-m-d", strtotime($Receipt->created_on));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Customers->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
				}
			}else if($ReferenceDetail->payment_id !=0){ 
				$Receipt =$this->Customers->Payments->get($ReferenceDetail->payment_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
				$Customer =$this->Customers->get($LedgerAccount->source_id);
				$date = date("Y-m-d", strtotime($Receipt->created_on));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Customers->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
				}
			}
			else if($ReferenceDetail->journal_voucher_id !=0){ 
				$Receipt =$this->Customers->JournalVouchers->get($ReferenceDetail->journal_voucher_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
			else if($ReferenceDetail->sale_return_id !=0){ 
				$Receipt =$this->Customers->SaleReturns->get($ReferenceDetail->sale_return_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->date_created));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
			else if($ReferenceDetail->petty_cash_voucher_id !=0){ 
				$Receipt =$this->Customers->PettyCashVouchers->get($ReferenceDetail->petty_cash_voucher_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->nppayment_id !=0){ 
				$Receipt =$this->Customers->Nppayments->get($ReferenceDetail->nppayment_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->contra_voucher_id !=0){ 
				$Receipt =$this->Customers->ContraVouchers->get($ReferenceDetail->contra_voucher_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->debit_note_id !=0){ 
				$Receipt =$this->Customers->DebitNotes->get($ReferenceDetail->debit_note_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->credit_note_id !=0){ 
				$Receipt =$this->Customers->CreditNotes->get($ReferenceDetail->credit_note_id);
				$LedgerAccount =$this->Customers->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Customers'){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->receipt_id ==0 && $ReferenceDetail->payment_id ==0 &&	$ReferenceDetail->invoice_id == 0 && $ReferenceDetail->invoice_booking_id ==0 &&$ReferenceDetail->credit_note_id ==0 && $ReferenceDetail->journal_voucher_id ==0 &&	$ReferenceDetail->sale_return_id ==0 && $ReferenceDetail->purchase_return_id ==0 && $ReferenceDetail->petty_cash_voucher_id ==0 && $ReferenceDetail->nppayment_id ==0 &&$ReferenceDetail->contra_voucher_id ==0){ 
				//$Receipt =$this->Customers->CreditNotes->get($ReferenceDetail->credit_note_id);
				
				@$LedgerAccount =$this->Customers->LedgerAccounts->get(@$ReferenceDetail->ledger_account_id);
				
				if($LedgerAccount->source_model=='Customers' && $LedgerAccount->source_id !=0){
					$Customer =$this->Customers->get($LedgerAccount->source_id);
					$date = '2017-04-01';
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Customers->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
		}
  
	  
		$ReferenceBalances =$this->Customers->ReferenceBalances->find()->where(['due_date !='=>'0000-00-00']);
		
		$total_debit_1=[];$total_credit_1=[];$due_1=[];
		$total_debit_2=[];$total_credit_2=[];$due_2=[];
		$total_debit_3=[];$total_credit_3=[];$due_3=[];
		$total_debit_4=[];$total_credit_4=[];$due_4=[];	
		$total_debit_5=[];$total_credit_5=[];$due_5=[];	
		$total_debit_6=[];$total_credit_6=[];$due_6=[];	
		$a=0;
		$on_account_dr=[];
		$on_account_cr=[];
		foreach($ReferenceBalances as $ReferenceBalance){
				$now=Date::now();
				$now=date("Y-m-d",strtotime($now));
				$over_date1=date("Y-m-d",strtotime($to_range_datas->tdate));
				$over_date2=date("Y-m-d",strtotime("-".$to_range_datas->range1."  day", strtotime($over_date1)));
				$over_date3=date("Y-m-d",strtotime("-".$to_range_datas->range2."  day", strtotime($over_date1)));
				$over_date4=date("Y-m-d",strtotime("-".$to_range_datas->range3."  day", strtotime($over_date1)));
				$over_date5=date("Y-m-d",strtotime("-".$to_range_datas->range4."  day", strtotime($over_date1)));
				$over_date6=date("Y-m-d",strtotime("-".$to_range_datas->range5."  day", strtotime($over_date1)));
				$over_date7=date("Y-m-d",strtotime("-".$to_range_datas->range6."  day", strtotime($over_date1)));
				$over_date8=date("Y-m-d",strtotime("-".$to_range_datas->range7."  day", strtotime($over_date1)));
				
				$ReferenceBalance->due_date=date("Y-m-d",strtotime($ReferenceBalance->due_date));
			
				if($ReferenceBalance->due_date <= $over_date1 && $ReferenceBalance->due_date >=  $over_date2){
					
					if($ReferenceBalance->debit != $ReferenceBalance->credit){
							//pr($over_date1);
							//pr($over_date2); exit;
							if($ReferenceBalance->debit > $ReferenceBalance->credit){ 
								@$total_debit_1[$ReferenceBalance->ledger_account_id]+=@$ReferenceBalance->debit-@$ReferenceBalance->credit;
						
							}else{ 
								$total_credit_1[$ReferenceBalance->ledger_account_id]=@$total_credit_1[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->credit-$ReferenceBalance->debit);
							}
					} 
				}
				else if($ReferenceBalance->due_date <= $over_date3 && $ReferenceBalance->due_date >=  $over_date4){
					if($ReferenceBalance->debit != $ReferenceBalance->credit){	
							if($ReferenceBalance->debit > $ReferenceBalance->credit){
								$total_debit_2[$ReferenceBalance->ledger_account_id]=@$total_debit_2[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->debit-$ReferenceBalance->credit);
							}else{
								$total_credit_2[$ReferenceBalance->ledger_account_id]=@$total_credit_2[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->credit-$ReferenceBalance->debit);
							}
						}
						
				}	
				else if($ReferenceBalance->due_date <= $over_date5 && $ReferenceBalance->due_date >=  $over_date6){
					if($ReferenceBalance->debit != $ReferenceBalance->credit){	
							if($ReferenceBalance->debit > $ReferenceBalance->credit){
								$total_debit_3[$ReferenceBalance->ledger_account_id]=@$total_debit_3[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->debit-$ReferenceBalance->credit);
							}else{
								$total_credit_3[$ReferenceBalance->ledger_account_id]=@$total_credit_3[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->credit-$ReferenceBalance->debit);
							}
						}
						
				}
				else if($ReferenceBalance->due_date <= $over_date7 && $ReferenceBalance->due_date >=  $over_date8){ 
					if($ReferenceBalance->debit != $ReferenceBalance->credit){	
							if($ReferenceBalance->debit > $ReferenceBalance->credit){
								$total_debit_4[$ReferenceBalance->ledger_account_id]=@$total_debit_4[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->debit-$ReferenceBalance->credit);
							}else{
								$total_credit_4[$ReferenceBalance->ledger_account_id]=@$total_credit_4[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->credit-$ReferenceBalance->debit);
							}
						}
						
				}else if($ReferenceBalance->due_date <  $over_date8){
					if($ReferenceBalance->debit != $ReferenceBalance->credit && $ReferenceBalance->due_date){	
							if($ReferenceBalance->debit > $ReferenceBalance->credit){
								$total_debit_5[$ReferenceBalance->ledger_account_id]=@$total_debit_5[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->debit-$ReferenceBalance->credit);
							}else{
								$total_credit_5[$ReferenceBalance->ledger_account_id]=@$total_credit_5[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->credit-$ReferenceBalance->debit);
							}
						}
				}else if($ReferenceBalance->due_date > $over_date1){
					if($ReferenceBalance->debit != $ReferenceBalance->credit){	
							if($ReferenceBalance->debit > $ReferenceBalance->credit){
								$total_debit_6[$ReferenceBalance->ledger_account_id]=@$total_debit_6[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->debit-$ReferenceBalance->credit);
							}else{
								$total_credit_6[$ReferenceBalance->ledger_account_id]=@$total_credit_6[@$ReferenceBalance->ledger_account_id]+($ReferenceBalance->credit-$ReferenceBalance->debit);
							}
						}
				}
				$ref_amt = $this->Customers->Ledgers->find()->where(['Ledgers.ledger_account_id'=>$ReferenceBalance->ledger_account_id]);
				$ref_amt->select([
					'Debit' => $ref_amt->func()->sum('Debit'),
					'Credit' => $ref_amt->func()->sum('Credit')
				]);
				$ref_amt=@$ref_amt->first(); 
				$ledger_debit[$ReferenceBalance->ledger_account_id]=$ref_amt['Debit'];
				$ledger_credit[$ReferenceBalance->ledger_account_id]=$ref_amt['Credit'];
				
				$ref_amt1 = $this->Customers->ReferenceBalances->find()->where(['ReferenceBalances.ledger_account_id'=>$ReferenceBalance->ledger_account_id]);
				$ref_amt1->select([
					'debit' => $ref_amt1->func()->sum('debit'),
					'credit' => $ref_amt1->func()->sum('credit')
				]);
				$ref_amt1=@$ref_amt1->first(); 
				$ref_bal_debit[$ReferenceBalance->ledger_account_id]=$ref_amt1['debit'];
				$ref_bal_credit[$ReferenceBalance->ledger_account_id]=$ref_amt1['credit'];
				
				/* $ledger=$this->Customers->Ledgers->find()->where(['ledger_account_id'=>$ReferenceBalance->ledger_account_id,'ref_no'=>$ReferenceBalance->reference_no])->first();
				pr(@$ledger->debit);
				pr(@$ledger->ledger_account_id); */
				
			}
			
        $this->set(compact('LedgerAccounts','Ledgers','over_due_report','custmer_name','custmer_payment','custmer_alise','custmer_payment_ctp','custmer_payment_range_ctp','over_due_report1','total_overdue','to_range_datas','total_debit_1','total_credit_1','total_debit_2','total_credit_2','total_debit_3','total_credit_4','total_debit_4','total_credit_4','total_debit_5','total_credit_5','total_debit_6','total_credit_6','custmer_payment_terms','ledger_debit','ledger_credit','ref_bal_debit','ref_bal_credit','show_data','stock','over_date1','url','to_send'));
        $this->set('_serialize', ['customers']);

   
	}
	public function CreditLimit($customer_id = null)
    {
		$this->viewBuilder()->layout('');
		
		$Customer = $this->Customers->get($customer_id);
		echo $Customer->credit_limit;
    }
	
	public function AgstRefForPayment($customer_id=null){
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$Customer=$this->Customers->find()->where(['Customers.id'=>$customer_id])->first();
		//pr($Customer); 
		$ReceiptVoucher=$this->Customers->ReceiptVouchers->find()->where(['received_from_id'=>$Customer->ledger_account_id,'advance_amount > '=>0.00])->toArray();
		//pr($ReceiptVoucher); exit;
		if(!$ReceiptVoucher){ echo 'Select paid to.'; exit; }
		$this->set(compact('Customer','ReceiptVoucher'));
	}

	public function EditCompany($customer_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		$Companies = $this->Customers->Companies->find();
		
		$Company_array=[];
		$Company_array1=[];
		foreach($Companies as $Company){
			$customer_Company_exist= $this->Customers->CustomerCompanies->exists(['customer_id' => $customer_id,'company_id'=>$Company->id]);
			if($customer_Company_exist){
				$Company_array[$Company->id]='Yes';
				$Company_array1[$Company->id]=$Company->name;
			}else{
				$Company_array[$Company->id]='No';
				$Company_array1[$Company->id]=$Company->name;

			}
		}
		$customer_data= $this->Customers->get($customer_id);
		$this->set(compact('Companies','customer_Company','Company_array','customer_id','Company_array1','customer_data'));

	}
	
	public function CheckCompany($company_id=null,$customer_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		 $this->request->allowMethod(['post', 'delete']);
		
		$customer_ledger= $this->Customers->LedgerAccounts->find()->where(['source_model' => 'Customers','source_id'=>$customer_id,'company_id'=>$company_id])->first();
//pr($customer_ledger); exit;
		$ledgerexist = $this->Customers->Ledgers->exists(['ledger_account_id' => $customer_ledger->id]);
				
		if(!$ledgerexist){
			$customer_Company_dlt= $this->Customers->CustomerCompanies->find()->where(['CustomerCompanies.customer_id'=>$customer_id,'company_id'=>$company_id])->first();
			$customer_ledger_dlt= $this->Customers->LedgerAccounts->find()->where(['source_model' => 'Customers','source_id'=>$customer_id,'company_id'=>$company_id])->first();
			
			$VoucherLedgerAccountsexist = $this->Customers->VoucherLedgerAccounts->exists(['ledger_account_id' => $customer_ledger->id]);
			
			/* $Voucherref = $this->Customers->VouchersReferences->find()->contain(['VoucherLedgerAccounts'])->where(['VouchersReferences.company_id'=>$company_id]);
			$size=sizeof($Voucherref);
			pr($size); exit; */
			
			if($VoucherLedgerAccountsexist){
				$Voucherref = $this->Customers->VouchersReferences->find()->contain(['VoucherLedgerAccounts'])->where(['VouchersReferences.company_id'=>$company_id]);
				
				foreach($Voucherref as $Voucherref){
					foreach($Voucherref->voucher_ledger_accounts as $voucher_ledger_account){
							if($voucher_ledger_account->ledger_account_id==$customer_ledger->id){
								$this->Customers->VoucherLedgerAccounts->delete($voucher_ledger_account);
							}
					}
					
				}
				
			}
			$this->Customers->LedgerAccounts->delete($customer_ledger_dlt);
			$this->Customers->CustomerCompanies->delete($customer_Company_dlt);
			return $this->redirect(['action' => 'EditCompany/'.$customer_id]);
				
		}else{
			$this->Flash->error(__('Company Can not Deleted'));
			return $this->redirect(['action' => 'EditCompany/'.$customer_id]);
		}
	}
	
	public function AddCompany($company_id=null,$customer_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		//pr($company_id); 
		//pr($customer_id); exit;
		$CustomerCompany = $this->Customers->CustomerCompanies->newEntity();
		$CustomerCompany->company_id=$company_id;
		$CustomerCompany->customer_id=$customer_id;
		$this->Customers->CustomerCompanies->save($CustomerCompany);
		$customer_details= $this->Customers->get($customer_id);
		$ledgerAccount = $this->Customers->LedgerAccounts->newEntity();
		$ledgerAccount->account_second_subgroup_id = $customer_details->account_second_subgroup_id;
		$ledgerAccount->name = $customer_details->customer_name;
		$ledgerAccount->alias = $customer_details->alias;
		$ledgerAccount->bill_to_bill_account = $customer_details->bill_to_bill_account;
		$ledgerAccount->source_model = 'Customers';
		$ledgerAccount->source_id = $customer_details->id;
		$ledgerAccount->company_id = $company_id;
		$this->Customers->LedgerAccounts->save($ledgerAccount);
		$VouchersReferences = $this->Customers->VouchersReferences->find()->where(['company_id'=>$company_id,'voucher_entity'=>'Receipt Voucher -> Received From'])->first();
				$voucherLedgerAccount = $this->Customers->VoucherLedgerAccounts->newEntity();
				$voucherLedgerAccount->vouchers_reference_id =$VouchersReferences->id;
				$voucherLedgerAccount->ledger_account_id =$ledgerAccount->id;
				$this->Customers->VoucherLedgerAccounts->save($voucherLedgerAccount);
		
		return $this->redirect(['action' => 'EditCompany/'.$customer_id]);
	}
	
}
