<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SaleTaxes Controller
 *
 * @property \App\Model\Table\SaleTaxesTable $SaleTaxes
 */
class SaleTaxesController extends AppController
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

		
		$saleTax = $this->SaleTaxes->newEntity();
        if ($this->request->is('post')) {
            $saleTax = $this->SaleTaxes->patchEntity($saleTax, $this->request->data);
			
            if ($this->SaleTaxes->save($saleTax)) { 
					foreach($saleTax->companies as $company){
					$LedgerAccount = $this->SaleTaxes->LedgerAccounts->newEntity();
					$LedgerAccount->account_second_subgroup_id=$saleTax->account_second_subgroup_id;
					$LedgerAccount->name=$saleTax->tax_figure;
					$LedgerAccount->alias=$saleTax->invoice_description;
					$LedgerAccount->source_model='SaleTaxes';
					$LedgerAccount->source_id=$saleTax->id;
					$LedgerAccount->bill_to_bill_account='';
					$LedgerAccount->company_id=$company->id;
					$this->SaleTaxes->LedgerAccounts->save($LedgerAccount);
				}
				$this->Flash->success(__('The sale tax has been saved.'));
				return $this->redirect(['action' => 'index']);
			}else {
                $this->Flash->error(__('The sale tax could not be saved. Please, try again.'));
            }
        }
		$AccountCategories = $this->SaleTaxes->AccountCategories->find('list');
		$Companies = $this->SaleTaxes->Companies->find('list');
        $this->set(compact('saleTax','AccountCategories'));
        $this->set('_serialize', ['saleTax']);
		
        $saleTaxes = $this->paginate($this->SaleTaxes);
		$st_LedgerAccounts=$this->SaleTaxes->LedgerAccounts->find()->where(['source_model'=>'SaleTaxes','company_id'=>$st_company_id]);	
		$sale_tax_ledger_accounts=[];
		$sale_tax_ledger_accounts1=[];
			foreach($st_LedgerAccounts as $st_LedgerAccount){
				$SaleTaxes = $this->SaleTaxes->find()->where(['id'=>$st_LedgerAccount->source_id])->first();
				$sale_tax_ledger_accounts[$st_LedgerAccount->source_id]=$SaleTaxes->invoice_description;
				$sale_tax_ledger_accounts1[$st_LedgerAccount->source_id]=$SaleTaxes->freeze;
				
			}

        $this->set(compact('saleTaxes','Companies','sale_tax_ledger_accounts','sale_tax_ledger_accounts1'));
        $this->set('_serialize', ['saleTaxes']);
    }

    /**
     * View method
     *
     * @param string|null $id Sale Tax id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $saleTax = $this->SaleTaxes->get($id, [
            'contain' => []
        ]);

        $this->set('saleTax', $saleTax);
        $this->set('_serialize', ['saleTax']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $saleTax = $this->SaleTaxes->newEntity();
        if ($this->request->is('post')) {
            $saleTax = $this->SaleTaxes->patchEntity($saleTax, $this->request->data);
            
			if ($this->SaleTaxes->save($saleTax)) 
			{
				
				$ledgerAccount = $this->SaleTaxes->LedgerAccounts->newEntity();
				$ledgerAccount->account_second_subgroup_id = $saleTax->account_second_subgroup_id;
				$ledgerAccount->name = 'SaleTax->'.$saleTax->tax_figure;
				$ledgerAccount->source_model = 'SaleTax';
				$ledgerAccount->source_id = $saleTax->id;
				if ($this->SaleTaxes->LedgerAccounts->save($ledgerAccount)) 
				{
					$this->Flash->success(__('The sale tax has been saved.'));
					return $this->redirect(['action' => 'index']);
				} 
			}else 
				{
					$this->Flash->error(__('The sale tax could not be saved. Please, try again.'));
				}
        }
		
		$AccountCategories = $this->SaleTaxes->AccountCategories->find('list');
        $this->set(compact('saleTax','AccountCategories'));
        $this->set('_serialize', ['saleTax']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sale Tax id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		
        $saleTax = $this->SaleTaxes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $saleTax = $this->SaleTaxes->patchEntity($saleTax, $this->request->data);
			
            if ($this->SaleTaxes->save($saleTax)) {
					$query = $this->SaleTaxes->LedgerAccounts->query();
					$query->update()
						->set(['account_second_subgroup_id' => $saleTax->account_second_subgroup_id,'name'=>$saleTax->tax_figure,'alias'=>$saleTax->invoice_description])
						->where(['source_id' => $saleTax->id,'source_model'=>'SaleTaxes'])
						->execute();
                $this->Flash->success(__('The sale tax has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The sale tax could not be saved. Please, try again.'));
            }
        }
		
		
		$AccountCategories = $this->SaleTaxes->AccountCategories->find('list');
		$AccountGroups = $this->SaleTaxes->AccountGroups->find('list');
		$AccountFirstSubgroups = $this->SaleTaxes->AccountFirstSubgroups->find('list');
		$AccountSecondSubgroups = $this->SaleTaxes->AccountSecondSubgroups->find('list');
		
		
		
        $this->set(compact('saleTax','AccountCategories','AccountGroups','AccountFirstSubgroups','AccountSecondSubgroups','Companies'));
        $this->set('_serialize', ['saleTax']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sale Tax id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->request->allowMethod(['post', 'delete']);
		$SaleTaxquoteexists = $this->SaleTaxes->SalesOrderRows->exists(['sale_tax_id' => $id]);
		$SaleTaxinvExists =  $this->SaleTaxes->Invoices->exists(['sale_tax_id' => $id]);
		if((!$SaleTaxquoteexists) AND (!$SaleTaxinvExists)){
			$saleTax = $this->SaleTaxes->get($id);
			if ($this->SaleTaxes->delete($saleTax)) {
            $this->Flash->success(__('The sale tax has been deleted.'));
			} else {
            $this->Flash->error(__('The sale tax could not be deleted. Please, try again.'));
			}
		} else{
			$this->Flash->error(__('Once the sales order or invoice has generated with sale tax, the Sale tax cannot be deleted.'));
		}
         return $this->redirect(['action' => 'index']);
    }

	public function EditCompany($saletax_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		$Companies = $this->SaleTaxes->Companies->find();
		$Company_array=[];
		$Company_array1=[];
		$Company_array2=[];
		foreach($Companies as $Company){
			$Company_exist= $this->SaleTaxes->SaleTaxCompanies->exists(['sale_tax_id' => $saletax_id,'company_id'=>$Company->id]);

			if($Company_exist){
				$saletax_data= $this->SaleTaxes->SaleTaxCompanies->find()->where(['sale_tax_id' => $saletax_id,'company_id'=>$Company->id])->first();
//pr($saletax_data);
				$Company_array[$Company->id]='Yes';
				$Company_array1[$Company->id]=$Company->name;
				$Company_array2[$Company->id]=$saletax_data->freeze;
				
			}else{
				$Company_array[$Company->id]='No';
				$Company_array1[$Company->id]=$Company->name;
				$Company_array2[$Company->id]='1';
			}

		} //exit;
		$saletax_data= $this->SaleTaxes->get($saletax_id);
		$this->set(compact('saletax_data','Companies','customer_Company','Company_array','saletax_id','Company_array1','Company_array2'));

	}

	public function SaleTaxFreeze($company_id=null,$saletax_id=null,$freeze=null)
	{
		$query2 = $this->SaleTaxes->SaleTaxCompanies->query();
		$query2->update()
			->set(['freeze' => $freeze])
			->where(['sale_tax_id' => $saletax_id,'company_id'=>$company_id])
			->execute();

		return $this->redirect(['action' => 'EditCompany/'.$saletax_id]);
	}

	public function CheckCompany($company_id=null,$saletax_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		 $this->request->allowMethod(['post', 'delete']);
		$employees_ledger= $this->SaleTaxes->LedgerAccounts->find()->where(['source_model' => 'SaleTaxes','source_id'=>$saletax_id,'company_id'=>$company_id])->first();
		$ledgerexist = $this->SaleTaxes->Ledgers->exists(['ledger_account_id' => $employees_ledger->id]);
		
		if(!$ledgerexist){
			$customer_Company_dlt= $this->SaleTaxes->SaleTaxCompanies->find()->where(['SaleTaxCompanies.sale_tax_id'=>$saletax_id,'company_id'=>$company_id])->first();

			$customer_ledger_dlt= $this->SaleTaxes->LedgerAccounts->find()->where(['source_model' => 'SaleTaxes','source_id'=>$saletax_id,'company_id'=>$company_id])->first();

			$VoucherLedgerAccountsexist = $this->SaleTaxes->VoucherLedgerAccounts->exists(['ledger_account_id' => $employees_ledger->id]);

			if($VoucherLedgerAccountsexist){
				$Voucherref = $this->SaleTaxes->VouchersReferences->find()->contain(['VoucherLedgerAccounts'])->where(['VouchersReferences.company_id'=>$company_id]);
				foreach($Voucherref as $Voucherref){
					foreach($Voucherref->voucher_ledger_accounts as $voucher_ledger_account){
							if($voucher_ledger_account->ledger_account_id==$employees_ledger->id){
								$this->SaleTaxes->VoucherLedgerAccounts->delete($voucher_ledger_account);
							}
					}
					
				}
				
			}

			$this->SaleTaxes->SaleTaxCompanies->delete($customer_Company_dlt);
			$this->SaleTaxes->LedgerAccounts->delete($customer_ledger_dlt);
			return $this->redirect(['action' => 'EditCompany/'.$saletax_id]);
				
		}else{
			$this->Flash->error(__('Company Can not Deleted'));
			return $this->redirect(['action' => 'EditCompany/'.$saletax_id]);
		}
	}

	public function AddCompany($company_id=null,$saletax_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		$sale_tax_details= $this->SaleTaxes->get($saletax_id);
		$ledgerAccount = $this->SaleTaxes->LedgerAccounts->newEntity();
		$ledgerAccount->account_second_subgroup_id = $sale_tax_details->account_second_subgroup_id;
		$ledgerAccount->name = $sale_tax_details->tax_figure;
		$ledgerAccount->source_model = 'SaleTaxes';
		$ledgerAccount->source_id = $sale_tax_details->id;
		$ledgerAccount->company_id = $company_id;
		$this->SaleTaxes->LedgerAccounts->save($ledgerAccount);

		$SaleTaxCompany = $this->SaleTaxes->SaleTaxCompanies->newEntity();
		$SaleTaxCompany->company_id=$company_id;
		$SaleTaxCompany->sale_tax_id=$saletax_id;
		$SaleTaxCompany->sale_tax_id=$saletax_id;
		//pr($SaleTaxCompany); exit;
		$this->SaleTaxes->SaleTaxCompanies->save($SaleTaxCompany);
		
		return $this->redirect(['action' => 'EditCompany/'.$saletax_id]);
	}
}