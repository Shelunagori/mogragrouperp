<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\I18n\Date;

/**
 * Vendors Controller
 *
 * @property \App\Model\Table\VendorsTable $Vendors
 */
class VendorsController extends AppController
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
		
        
		$where =[];
		$supp_name = $this->request->query('supp_name');
		
		$this->set(compact('supp_name'));
		
		if(!empty($supp_name)){
			$where['Vendors.company_name LIKE']= '%'.$supp_name.'%';
		}
	

		$vendors = $this->paginate($this->Vendors->find()->where($where)->order(['Vendors.company_name' => 'ASC']));
		
        $this->set(compact('vendors'));
        $this->set('_serialize', ['vendors']);
    }

    /**
     * View method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vendor = $this->Vendors->get($id, [
            'contain' => []
        ]);

        $this->set('vendor', $vendor);
        $this->set('_serialize', ['vendor']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $vendor = $this->Vendors->newEntity();
        if ($this->request->is('post')) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->data);
			//pr($vendor); exit;	
			
            if ($this->Vendors->save($vendor))
			{
				
				foreach($vendor->companies as $data)
				{
					$ledgerAccount = $this->Vendors->LedgerAccounts->newEntity();
					$ledgerAccount->account_second_subgroup_id = $vendor->account_second_subgroup_id;
					$ledgerAccount->name = $vendor->company_name;
					$ledgerAccount->source_model = 'Vendors';
					$ledgerAccount->source_id = $vendor->id;
					$ledgerAccount->company_id = $data->id;
					$this->Vendors->LedgerAccounts->save($ledgerAccount);
					$VouchersReferences = $this->Vendors->VouchersReferences->find()->where(['company_id'=>$data->id,'voucher_entity'=>'PaymentVoucher -> Paid To'])->first();
					$voucherLedgerAccount = $this->Vendors->VoucherLedgerAccounts->newEntity();
					$voucherLedgerAccount->vouchers_reference_id =$VouchersReferences->id;
					$voucherLedgerAccount->ledger_account_id =$ledgerAccount->id;
					$this->Vendors->VoucherLedgerAccounts->save($voucherLedgerAccount);
				} 
				$this->Flash->success(__('The Vendor has been saved.'));
					return $this->redirect(['action' => 'index']);
				
				
            } else 
				{
					$this->Flash->error(__('The vendor could not be saved. Please, try again.'));
				}
        }
		$ItemGroups = $this->Vendors->ItemGroups->find('list');
		$AccountCategories = $this->Vendors->AccountCategories->find('list');
		$Districts = $this->Vendors->Districts->find('list');
		$Companies = $this->Vendors->Companies->find('list');
        
        $this->set(compact('vendor','ItemGroups','AccountCategories','Companies','Districts'));
        $this->set('_serialize', ['vendor']);
    }

	
	
    /**
     * Edit method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $vendor = $this->Vendors->get($id, [
            'contain' => ['VendorContactPersons']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->data);
			//pr($vendor); exit;	
            if ($this->Vendors->save($vendor)) {
				$query = $this->Vendors->LedgerAccounts->query();
					$query->update()
						->set(['account_second_subgroup_id' => $vendor->account_second_subgroup_id])
						->where(['id' => $vendor->ledger_account_id])
						->execute();
                $this->Flash->success(__('The vendor has been saved.'));
				return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
            }
        }
		$ItemGroups = $this->Vendors->ItemGroups->find('list');
		$AccountCategories = $this->Vendors->AccountCategories->find('list');
		$AccountGroups = $this->Vendors->AccountGroups->find('list');
		$AccountFirstSubgroups = $this->Vendors->AccountFirstSubgroups->find('list');
		$AccountSecondSubgroups = $this->Vendors->AccountSecondSubgroups->find('list');
		$Districts = $this->Vendors->Districts->find('list');
        $this->set(compact('vendor','ItemGroups','AccountCategories','AccountGroups','AccountFirstSubgroups','AccountSecondSubgroups','Districts'));
        $this->set('_serialize', ['vendor']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vendor = $this->Vendors->get($id);
        if ($this->Vendors->delete($vendor)) {
            $this->Flash->success(__('The vendor has been deleted.'));
        } else {
            $this->Flash->error(__('The vendor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function EditCompany($vendor_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		$Companies = $this->Vendors->Companies->find();
		$Company_array=[];
		$Company_array1=[];
		$Company_array2=[];
		foreach($Companies as $Company){
			$employee_Company_exist= $this->Vendors->VendorCompanies->exists(['vendor_id' => $vendor_id,'company_id'=>$Company->id]);
			if($employee_Company_exist){
				$bill_to_bill_account= $this->Vendors->LedgerAccounts->find()->where(['source_model'=>'Vendors','source_id' => $vendor_id,'company_id'=>$Company->id])->first();
				$Company_array[$Company->id]='Yes';
				$Company_array1[$Company->id]=$Company->name;
				$Company_array2[$Company->id]=$bill_to_bill_account->bill_to_bill_account;
				
			}else{
				$Company_array[$Company->id]='No';
				$Company_array1[$Company->id]=$Company->name;
				$Company_array2[$Company->id]='No';
			}
		}

		$vendor_data= $this->Vendors->get($vendor_id);
		$this->set(compact('vendor_data','Companies','customer_Company','Company_array','vendor_id','Company_array1','Company_array2'));

	}
	
	public function AddCompany($company_id=null,$vendor_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		//pr($company_id); 
		
		$EmployeeCompany = $this->Vendors->VendorCompanies->newEntity();
		$EmployeeCompany->company_id=$company_id;
		$EmployeeCompany->vendor_id=$vendor_id;
		
		$this->Vendors->VendorCompanies->save($EmployeeCompany);

		$vendor_details= $this->Vendors->get($vendor_id);
		//pr($vendor_details); exit;
		$ledgerAccount = $this->Vendors->LedgerAccounts->newEntity();
		$ledgerAccount->account_second_subgroup_id = $vendor_details->account_second_subgroup_id;
		$ledgerAccount->name = $vendor_details->company_name;
		//$ledgerAccount->alias = $employee_details->alias;
		$ledgerAccount->bill_to_bill_account = 'Yes';
		$ledgerAccount->source_model = 'Vendors';
		$ledgerAccount->source_id = $vendor_details->id;
		$ledgerAccount->company_id = $company_id;
		//pr($ledgerAccount); exit;
		$this->Vendors->LedgerAccounts->save($ledgerAccount);
		$VouchersReferences = $this->Vendors->VouchersReferences->find()->where(['company_id'=>$company_id,'voucher_entity'=>'PaymentVoucher -> Paid To'])->first();
					$voucherLedgerAccount = $this->Vendors->VoucherLedgerAccounts->newEntity();
					$voucherLedgerAccount->vouchers_reference_id =$VouchersReferences->id;
					$voucherLedgerAccount->ledger_account_id =$ledgerAccount->id;
					$this->Vendors->VoucherLedgerAccounts->save($voucherLedgerAccount);
		
		return $this->redirect(['action' => 'EditCompany/'.$vendor_id]);
	}
	
	public function CheckCompany($company_id=null,$vendor_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		 $this->request->allowMethod(['post', 'delete']);
		$employees_ledger= $this->Vendors->LedgerAccounts->find()->where(['source_model' => 'Vendors','source_id'=>$vendor_id,'company_id'=>$company_id])->first();

		$ledgerexist = $this->Vendors->Ledgers->exists(['ledger_account_id' => $employees_ledger->id]);

		if(!$ledgerexist){
			$customer_Company_dlt= $this->Vendors->VendorCompanies->find()->where(['VendorCompanies.vendor_id'=>$vendor_id,'company_id'=>$company_id])->first();
			$customer_ledger_dlt= $this->Vendors->LedgerAccounts->find()->where(['source_model' => 'Vendors','source_id'=>$vendor_id,'company_id'=>$company_id])->first();
			$VoucherLedgerAccountsexist = $this->Vendors->VoucherLedgerAccounts->exists(['ledger_account_id' => $employees_ledger->id]);
			if($VoucherLedgerAccountsexist){
				$Voucherref = $this->Vendors->VouchersReferences->find()->contain(['VoucherLedgerAccounts'])->where(['VouchersReferences.company_id'=>$company_id]);
				foreach($Voucherref as $Voucherref){
					foreach($Voucherref->voucher_ledger_accounts as $voucher_ledger_account){
							if($voucher_ledger_account->ledger_account_id==$employees_ledger->id){
								$this->Vendors->VoucherLedgerAccounts->delete($voucher_ledger_account);
							}
					}
					
				}
				
			}

			$this->Vendors->VendorCompanies->delete($customer_Company_dlt);
			$this->Vendors->LedgerAccounts->delete($customer_ledger_dlt);
			return $this->redirect(['action' => 'EditCompany/'.$vendor_id]);
				
		}else{
			$this->Flash->error(__('Company Can not Deleted'));
			return $this->redirect(['action' => 'EditCompany/'.$vendor_id]);
		}
	}
	public function BillToBill($company_id=null,$vendor_id=null,$bill_to_bill_account=null)
	{

	
		$query2 = $this->Vendors->LedgerAccounts->query();
		
		$query2->update()
			->set(['bill_to_bill_account' => $bill_to_bill_account])
			->where(['source_model' => 'Vendors','source_id'=>$vendor_id,'company_id'=>$company_id])
			->execute();
			
		return $this->redirect(['action' => 'EditCompany/'.$vendor_id]);
	}
	
	public function exportExcel($to_send = null){
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$stock=$this->request->query('total');
		$to_range_datas =json_decode($to_send);
		$LedgerAccounts =$this->Vendors->LedgerAccounts->find()
			->where(['LedgerAccounts.company_id'=>$st_company_id,'source_model'=>'Vendors'])
			->order(['LedgerAccounts.name'=>'ASC']);
		
		$custmer_payment_terms=[];
		foreach($LedgerAccounts as $LedgerAccount){
			$Customer =$this->Vendors->get($LedgerAccount->source_id);
			$custmer_payment_terms[$LedgerAccount->id]=$Customer->payment_terms;
		}
		$ReferenceDetails =$this->Vendors->ReferenceDetails->find();
		
/* 		$LedgerAccount_details =$this->Vendors->LedgerAccounts->find();
		$ReferenceDetails =$this->Vendors->ReferenceDetails->find();
		$data=[];
		foreach($ReferenceDetails as $ReferenceDetail){
			$AccountSecondSubgroupsexists = $this->Vendors->LedgerAccounts->exists(['id' => $ReferenceDetail->ledger_account_id]);
			if(empty($AccountSecondSubgroupsexists)){
				$data=$ReferenceDetail->ledger_account_id;
			}
		}
		pr($data); exit; */
		
		 foreach($ReferenceDetails as $ReferenceDetail){
			if($ReferenceDetail->receipt_id !=0){ 
				$Receipt =$this->Vendors->Receipts->get($ReferenceDetail->receipt_id);
				
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
				$Customer =$this->Vendors->get($LedgerAccount->source_id);
				$date = date("Y-m-d", strtotime($Receipt->created_on));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Vendors->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
				}
			}else if($ReferenceDetail->payment_id !=0){ 
				$Receipt =$this->Vendors->Payments->get($ReferenceDetail->payment_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
				$Customer =$this->Vendors->get($LedgerAccount->source_id);
				$date = date("Y-m-d", strtotime($Receipt->created_on));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Vendors->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
				}
			}
			else if($ReferenceDetail->journal_voucher_id !=0){ 
				$Receipt =$this->Vendors->JournalVouchers->get($ReferenceDetail->journal_voucher_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
			else if($ReferenceDetail->sale_return_id !=0){ 
				$Receipt =$this->Vendors->SaleReturns->get($ReferenceDetail->sale_return_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->date_created));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->purchase_return_id !=0){ 
				$Receipt =$this->Vendors->PurchaseReturns->get($ReferenceDetail->purchase_return_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->transaction_date));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
			else if($ReferenceDetail->petty_cash_voucher_id !=0){ 
				$Receipt =$this->Vendors->PettyCashVouchers->get($ReferenceDetail->petty_cash_voucher_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->nppayment_id !=0){ 
				$Receipt =$this->Vendors->Nppayments->get($ReferenceDetail->nppayment_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->contra_voucher_id !=0){ 
				$Receipt =$this->Vendors->ContraVouchers->get($ReferenceDetail->contra_voucher_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->debit_note_id !=0){ 
				$Receipt =$this->Vendors->DebitNotes->get($ReferenceDetail->debit_note_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->credit_note_id !=0){ 
				$Receipt =$this->Vendors->CreditNotes->get($ReferenceDetail->credit_note_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->invoice_booking_id !=0){ 
				$Receipt =$this->Vendors->InvoiceBookings->get($ReferenceDetail->invoice_booking_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->receipt_id ==0 && $ReferenceDetail->payment_id ==0 &&	$ReferenceDetail->invoice_id == 0 && $ReferenceDetail->invoice_booking_id ==0 &&$ReferenceDetail->credit_note_id ==0 && $ReferenceDetail->journal_voucher_id ==0 &&	$ReferenceDetail->sale_return_id ==0 && $ReferenceDetail->purchase_return_id ==0 && $ReferenceDetail->petty_cash_voucher_id ==0 && $ReferenceDetail->nppayment_id ==0 &&$ReferenceDetail->contra_voucher_id ==0){ 
				@$LedgerAccount =$this->Vendors->LedgerAccounts->get(@$ReferenceDetail->ledger_account_id);
			
				if($LedgerAccount->source_model=='Vendors' && $LedgerAccount->source_id !=0){
					//pr($LedgerAccount->source_id);
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = '2017-04-01';
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
		}   
		 
		$ReferenceBalances =$this->Vendors->ReferenceBalances->find()->where(['due_date !='=>'0000-00-00']);
		
		$total_debit_1=[];$total_credit_1=[];$due_1=[];
		$total_debit_2=[];$total_credit_2=[];$due_2=[];
		$total_debit_3=[];$total_credit_3=[];$due_3=[];
		$total_debit_4=[];$total_credit_4=[];$due_4=[];	
		$total_debit_5=[];$total_credit_5=[];$due_5=[];	
		$total_debit_6=[];$total_credit_6=[];$due_6=[];	

		$a=0;
			foreach($ReferenceBalances as $ReferenceBalance){
				$now=Date::now();
				$now=date("Y-m-d",strtotime($now));
				
				//pr($now); 
				$over_date1=date("Y-m-d",strtotime($to_range_datas->tdate));
				$over_date2=date("Y-m-d",strtotime("-".$to_range_datas->range1."  day", strtotime($over_date1)));
				
				
				$over_date3=date("Y-m-d",strtotime("-".$to_range_datas->range2."  day", strtotime($over_date1)));
				$over_date4=date("Y-m-d",strtotime("-".$to_range_datas->range3."  day", strtotime($over_date1)));
				
				$over_date5=date("Y-m-d",strtotime("-".$to_range_datas->range4."  day", strtotime($over_date1)));
				$over_date6=date("Y-m-d",strtotime("-".$to_range_datas->range5."  day", strtotime($over_date1)));
				
				$over_date7=date("Y-m-d",strtotime("-".$to_range_datas->range6."  day", strtotime($over_date1)));
				$over_date8=date("Y-m-d",strtotime("-".$to_range_datas->range7."  day", strtotime($over_date1)));
				//pr($over_date8); exit;
				
				$ReferenceBalance->due_date=date("Y-m-d",strtotime($ReferenceBalance->due_date));
			
				if($ReferenceBalance->due_date <= $over_date1 && $ReferenceBalance->due_date >=  $over_date2){
					
					
					if($ReferenceBalance->debit != $ReferenceBalance->credit){
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
						
				}else if($ReferenceBalance->due_date <  $over_date8 && $ReferenceBalance->due_date < $over_date1){
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
				

				$ref_amt = $this->Vendors->Ledgers->find()->where(['Ledgers.ledger_account_id'=>$ReferenceBalance->ledger_account_id]);
				$ref_amt->select([
					'Debit' => $ref_amt->func()->sum('Debit'),
					'Credit' => $ref_amt->func()->sum('Credit')
				]);
				$ref_amt=@$ref_amt->first(); 
				$ledger_debit[$ReferenceBalance->ledger_account_id]=$ref_amt['Debit'];
				$ledger_credit[$ReferenceBalance->ledger_account_id]=$ref_amt['Credit'];
				
				$ref_amt1 = $this->Vendors->ReferenceBalances->find()->where(['ReferenceBalances.ledger_account_id'=>$ReferenceBalance->ledger_account_id]);
				$ref_amt1->select([
					'debit' => $ref_amt1->func()->sum('debit'),
					'credit' => $ref_amt1->func()->sum('credit')
				]);
				$ref_amt1=@$ref_amt1->first(); 
				$ref_bal_debit[$ReferenceBalance->ledger_account_id]=$ref_amt1['debit'];
				$ref_bal_credit[$ReferenceBalance->ledger_account_id]=$ref_amt1['credit'];
			
					
			} 
			//pr($total_debit_3[477]);
			//pr($total_credit_3[477]);
			//exit;
		
        $this->set(compact('LedgerAccounts','Ledgers','over_due_report','custmer_name','custmer_payment','custmer_alise','custmer_payment_ctp','custmer_payment_range_ctp','over_due_report1','total_overdue','to_range_datas','total_debit_1','total_credit_1','total_debit_2','total_credit_2','total_debit_3','total_credit_3','total_credit_4','total_debit_4','total_debit_5','total_credit_5','custmer_payment_terms','ledger_debit','ledger_credit','ref_bal_debit','ref_bal_credit','stock','total_debit_6','total_credit_6'));
        $this->set('_serialize', ['Vendors']);
		
	}
	
	public function OverDueReport($to_send=null)
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$this->viewBuilder()->layout('report_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$stock=$this->request->query('total');
		$to_range_datas =json_decode($to_send);
		$LedgerAccounts =$this->Vendors->LedgerAccounts->find()
			->where(['LedgerAccounts.company_id'=>$st_company_id,'source_model'=>'Vendors'])
			->order(['LedgerAccounts.name'=>'ASC']);
		
		$custmer_payment_terms=[];
		foreach($LedgerAccounts as $LedgerAccount){
			$Customer =$this->Vendors->get($LedgerAccount->source_id);
			$custmer_payment_terms[$LedgerAccount->id]=$Customer->payment_terms;
		}
		$ReferenceDetails =$this->Vendors->ReferenceDetails->find();
		
/* 		$LedgerAccount_details =$this->Vendors->LedgerAccounts->find();
		$ReferenceDetails =$this->Vendors->ReferenceDetails->find();
		$data=[];
		foreach($ReferenceDetails as $ReferenceDetail){
			$AccountSecondSubgroupsexists = $this->Vendors->LedgerAccounts->exists(['id' => $ReferenceDetail->ledger_account_id]);
			if(empty($AccountSecondSubgroupsexists)){
				$data=$ReferenceDetail->ledger_account_id;
			}
		}
		pr($data); exit; */
		
		 foreach($ReferenceDetails as $ReferenceDetail){
			if($ReferenceDetail->receipt_id !=0){ 
				$Receipt =$this->Vendors->Receipts->get($ReferenceDetail->receipt_id);
				
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
				$Customer =$this->Vendors->get($LedgerAccount->source_id);
				$date = date("Y-m-d", strtotime($Receipt->created_on));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Vendors->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
				}
			}else if($ReferenceDetail->payment_id !=0){ 
				$Receipt =$this->Vendors->Payments->get($ReferenceDetail->payment_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
				$Customer =$this->Vendors->get($LedgerAccount->source_id);
				$date = date("Y-m-d", strtotime($Receipt->created_on));
				$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
				$query = $this->Vendors->ReferenceBalances->query();
				$query->update()
						->set(['transaction_date' =>$date,'due_date'=>$due_date])
						->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
						->execute();
				}
			}
			else if($ReferenceDetail->journal_voucher_id !=0){ 
				$Receipt =$this->Vendors->JournalVouchers->get($ReferenceDetail->journal_voucher_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
			else if($ReferenceDetail->sale_return_id !=0){ 
				$Receipt =$this->Vendors->SaleReturns->get($ReferenceDetail->sale_return_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->date_created));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->purchase_return_id !=0){ 
				$Receipt =$this->Vendors->PurchaseReturns->get($ReferenceDetail->purchase_return_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->transaction_date));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
			else if($ReferenceDetail->petty_cash_voucher_id !=0){ 
				$Receipt =$this->Vendors->PettyCashVouchers->get($ReferenceDetail->petty_cash_voucher_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->nppayment_id !=0){ 
				$Receipt =$this->Vendors->Nppayments->get($ReferenceDetail->nppayment_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->contra_voucher_id !=0){ 
				$Receipt =$this->Vendors->ContraVouchers->get($ReferenceDetail->contra_voucher_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->debit_note_id !=0){ 
				$Receipt =$this->Vendors->DebitNotes->get($ReferenceDetail->debit_note_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->credit_note_id !=0){ 
				$Receipt =$this->Vendors->CreditNotes->get($ReferenceDetail->credit_note_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->invoice_booking_id !=0){ 
				$Receipt =$this->Vendors->InvoiceBookings->get($ReferenceDetail->invoice_booking_id);
				$LedgerAccount =$this->Vendors->LedgerAccounts->get($ReferenceDetail->ledger_account_id);
				if($LedgerAccount->source_model=='Vendors'){
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = date("Y-m-d", strtotime($Receipt->created_on));
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}else if($ReferenceDetail->receipt_id ==0 && $ReferenceDetail->payment_id ==0 &&	$ReferenceDetail->invoice_id == 0 && $ReferenceDetail->invoice_booking_id ==0 &&$ReferenceDetail->credit_note_id ==0 && $ReferenceDetail->journal_voucher_id ==0 &&	$ReferenceDetail->sale_return_id ==0 && $ReferenceDetail->purchase_return_id ==0 && $ReferenceDetail->petty_cash_voucher_id ==0 && $ReferenceDetail->nppayment_id ==0 &&$ReferenceDetail->contra_voucher_id ==0){ 
				@$LedgerAccount =$this->Vendors->LedgerAccounts->get(@$ReferenceDetail->ledger_account_id);
			
				if($LedgerAccount->source_model=='Vendors' && $LedgerAccount->source_id !=0){
					//pr($LedgerAccount->source_id);
					$Customer =$this->Vendors->get($LedgerAccount->source_id);
					$date = '2017-04-01';
					$due_date= date("Y-m-d",strtotime("+".$Customer->payment_terms."  day", strtotime($date)));
					$query = $this->Vendors->ReferenceBalances->query();
					$query->update()
							->set(['transaction_date' =>$date,'due_date'=>$due_date])
							->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])
							->execute();
				}
			}
		}   
		 
		$ReferenceBalances =$this->Vendors->ReferenceBalances->find()->where(['due_date !='=>'0000-00-00']);
		
		$total_debit_1=[];$total_credit_1=[];$due_1=[];
		$total_debit_2=[];$total_credit_2=[];$due_2=[];
		$total_debit_3=[];$total_credit_3=[];$due_3=[];
		$total_debit_4=[];$total_credit_4=[];$due_4=[];	
		$total_debit_5=[];$total_credit_5=[];$due_5=[];	
		$total_debit_6=[];$total_credit_6=[];$due_6=[];	

		$a=0;
			foreach($ReferenceBalances as $ReferenceBalance){
				$now=Date::now();
				$now=date("Y-m-d",strtotime($now));
				
				//pr($now); 
				$over_date1=date("Y-m-d",strtotime($to_range_datas->tdate));
				$over_date2=date("Y-m-d",strtotime("-".$to_range_datas->range1."  day", strtotime($over_date1)));
				
				
				$over_date3=date("Y-m-d",strtotime("-".$to_range_datas->range2."  day", strtotime($over_date1)));
				$over_date4=date("Y-m-d",strtotime("-".$to_range_datas->range3."  day", strtotime($over_date1)));
				
				$over_date5=date("Y-m-d",strtotime("-".$to_range_datas->range4."  day", strtotime($over_date1)));
				$over_date6=date("Y-m-d",strtotime("-".$to_range_datas->range5."  day", strtotime($over_date1)));
				
				$over_date7=date("Y-m-d",strtotime("-".$to_range_datas->range6."  day", strtotime($over_date1)));
				$over_date8=date("Y-m-d",strtotime("-".$to_range_datas->range7."  day", strtotime($over_date1)));
				//pr($over_date8); exit;
				
				$ReferenceBalance->due_date=date("Y-m-d",strtotime($ReferenceBalance->due_date));
			
				if($ReferenceBalance->due_date <= $over_date1 && $ReferenceBalance->due_date >=  $over_date2){
					
					
					if($ReferenceBalance->debit != $ReferenceBalance->credit){
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
						
				}else if($ReferenceBalance->due_date <  $over_date8 && $ReferenceBalance->due_date < $over_date1){
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
				

				$ref_amt = $this->Vendors->Ledgers->find()->where(['Ledgers.ledger_account_id'=>$ReferenceBalance->ledger_account_id]);
				$ref_amt->select([
					'Debit' => $ref_amt->func()->sum('Debit'),
					'Credit' => $ref_amt->func()->sum('Credit')
				]);
				$ref_amt=@$ref_amt->first(); 
				$ledger_debit[$ReferenceBalance->ledger_account_id]=$ref_amt['Debit'];
				$ledger_credit[$ReferenceBalance->ledger_account_id]=$ref_amt['Credit'];
				
				$ref_amt1 = $this->Vendors->ReferenceBalances->find()->where(['ReferenceBalances.ledger_account_id'=>$ReferenceBalance->ledger_account_id]);
				$ref_amt1->select([
					'debit' => $ref_amt1->func()->sum('debit'),
					'credit' => $ref_amt1->func()->sum('credit')
				]);
				$ref_amt1=@$ref_amt1->first(); 
				$ref_bal_debit[$ReferenceBalance->ledger_account_id]=$ref_amt1['debit'];
				$ref_bal_credit[$ReferenceBalance->ledger_account_id]=$ref_amt1['credit'];
			
					
			} 
			//pr($total_debit_3[477]);
			//pr($total_credit_3[477]);
			//exit;
		
        $this->set(compact('LedgerAccounts','Ledgers','over_due_report','custmer_name','custmer_payment','custmer_alise','custmer_payment_ctp','custmer_payment_range_ctp','over_due_report1','total_overdue','to_range_datas','total_debit_1','total_credit_1','total_debit_2','total_credit_2','total_debit_3','total_credit_3','total_credit_4','total_debit_4','total_debit_5','total_credit_5','custmer_payment_terms','ledger_debit','ledger_credit','ref_bal_debit','ref_bal_credit','stock','total_debit_6','total_credit_6','to_send','url'));
        $this->set('_serialize', ['Vendors']);
    }
}
