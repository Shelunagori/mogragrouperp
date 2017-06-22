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
		$Companies = $this->Vendors->Companies->find('list');
        
        $this->set(compact('vendor','ItemGroups','AccountCategories','Companies'));
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
		
        $this->set(compact('vendor','ItemGroups','AccountCategories','AccountGroups','AccountFirstSubgroups','AccountSecondSubgroups'));
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
	
	public function OverDueReport($to_send=null)
    {
		
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$to_range_datas =json_decode($to_send);
		$LedgerAccounts =$this->Vendors->LedgerAccounts->find()
			->where(['LedgerAccounts.company_id'=>$st_company_id,'source_model'=>'Vendors']);
			
		$vendor_payment = [];
		
        
		foreach ($LedgerAccounts as $LedgerAccount){
		$Vendors = $this->Vendors->find()->where(['id'=>$LedgerAccount->source_id])->first();
		$vendor_payment[$LedgerAccount->id] = $Vendors->payment_terms;
		$company_name[$LedgerAccount->id] = $Vendors->company_name;
		$vendor_payment[$LedgerAccount->id] =$to_range_datas;
		$vendor_payment_ctp[$LedgerAccount->id] = $Vendors->payment_terms;
		$vendor_payment_range_ctp =$to_range_datas;
		}
		$over_due_report = [];
		$over_due_report1 = [];
		foreach ($vendor_payment as $key=>$vendor_payment){
			$total_debit=0;$total_credit=0;$due=0;
			$total_debit_1=0;$total_credit_1=0;$due_1=0;
			$total_debit_2=0;$total_credit_2=0;$due_2=0;
			$total_debit_3=0;$total_credit_3=0;$due_3=0;
			$total_debit_4=0;$total_credit_4=0;$due_4=0;
			
			$now=Date::now();
			$over_date=$now->subDays($vendor_payment->range1);
			$now=Date::now();
			$over_date_1=$now->subDays($vendor_payment->range3);
			$now=Date::now();
			$over_date_2=$now->subDays($vendor_payment->range5);//pr($over_date_2);exit;
			$now=Date::now();
			$over_date_3=$now->subDays($vendor_payment->range7);//pr($over_date_3);exit;
			$vendor_ledgers =$this->Vendors->Ledgers->find()->where(['ledger_account_id'=>$key])->toArray();
			 foreach($vendor_ledgers as $vendor_ledger){
				 $now=Date::now();
					if($vendor_ledger->transaction_date >= $over_date && $vendor_ledger->transaction_date <= $now){
						if($vendor_ledger->debit==0){
							$total_credit=$total_credit+$vendor_ledger->credit;
						}else{
							$total_debit=$total_debit+$vendor_ledger->debit;
						}
					}
					elseif($vendor_ledger->transaction_date >= $over_date_1 && $vendor_ledger->transaction_date <= $now){
						if($vendor_ledger->debit==0){
							$total_credit_1=$total_credit_1+$vendor_ledger->credit;
						}else{
							$total_debit_1=$total_debit_1+$vendor_ledger->debit;
						}
					}
					elseif($vendor_ledger->transaction_date >= $over_date_2 && $vendor_ledger->transaction_date <= $now){
						if($vendor_ledger->debit==0){
							$total_credit_2=$total_credit_2+$vendor_ledger->credit;
							
						}else{
							$total_debit_2=$total_debit_2+$vendor_ledger->debit;
						}
					}
					elseif($vendor_ledger->transaction_date >= $over_date_3 && $vendor_ledger->transaction_date <= $now){
						if($vendor_ledger->debit==0){
							$total_credit_3=$total_credit_3+$vendor_ledger->credit;
						}else{
							$total_debit_3=$total_debit_3+$vendor_ledger->debit;
						}
					}	
					else{
						if($vendor_ledger->debit==0){
							$total_credit_4=$total_credit_4+$vendor_ledger->credit;
						}else{
							$total_debit_4=$total_debit_4+$vendor_ledger->debit;
						}
					}
					
				}
				$due=$total_credit-$total_debit; 
				$due_1=$total_credit_1-$total_debit_1; 
				$due_2=$total_credit_2-$total_debit_2; 
				$due_3=$total_credit_3-$total_debit_3;
				$due_4=$total_credit_4-$total_debit_4;
				
				$Company_name =$company_name[$key];
					
				
				$total_overdue[$key] = $due + $due_1 +$due_2 +$due_3 +$due_4;
				
				$over_due_report[$key]=$due;	
				$over_due_report1[$key][1]=$due;	
				$over_due_report[$key]=$due_1;
				$over_due_report1[$key][2]=$due_1;
				$over_due_report[$key]=$due_2;	
				$over_due_report1[$key][3]=$due_2;	
				$over_due_report[$key]=$due_3;	
				$over_due_report1[$key][4]=$due_3;
				$over_due_report[$key]=$due_4;	
				$over_due_report1[$key][5]=$due_4;				
				
			}

        $this->set(compact('LedgerAccounts','Ledgers','over_due_report','company_name','vendor_payment_ctp','total_overdue','over_due_report1','vendor_payment_range_ctp'));
        $this->set('_serialize', ['Vendors']);
    }
}
