<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LedgerAccounts Controller
 *
 * @property \App\Model\Table\LedgerAccountsTable $LedgerAccounts
 */
class LedgerAccountsController extends AppController
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
		$ledgerAccount = $this->LedgerAccounts->newEntity();
		$company_data=$this->request->query('company_data');
		//pr($company_data); exit;
        if ($this->request->is('post')) {
            $ledgerAccount = $this->LedgerAccounts->patchEntity($ledgerAccount, $this->request->data);
			$last_ledger_no=$this->LedgerAccounts->find()->select(['auto_inc'])->order(['auto_inc' => 'DESC'])->first();
			$auto_inc=$last_ledger_no->auto_inc+1;
			
			foreach($ledgerAccount->companies['_ids'] as $company_id){
				$query = $this->LedgerAccounts->query();
				$query->insert(['account_second_subgroup_id', 'name', 'alias', 'source_model', 'source_id', 'bill_to_bill_account','auto_inc', 'company_id'])
						->values([
							'account_second_subgroup_id' => $ledgerAccount->account_second_subgroup_id,
							'name' => $ledgerAccount->name,
							'alias' => '',
							'source_model' => 'Ledger Account',
							'source_id' => 0,
							'bill_to_bill_account' => '',
							'auto_inc' => $auto_inc,
							'company_id' => $company_id,
						]);
				$query->execute();
			}
            $this->Flash->success(__('The ledger account has been saved.'));
			return $this->redirect(['action' => 'index']);
		}	
		
        $accountSecondSubgroups = $this->LedgerAccounts->AccountSecondSubgroups->find('list');
        $this->set(compact('ledgerAccount', 'accountSecondSubgroups'));
        $this->set('_serialize', ['ledgerAccount']);
		
		if($company_data=='all'){
			$ledgerAccounts = $this->LedgerAccounts->find()->contain(['Companies','AccountSecondSubgroups'=>['AccountFirstSubgroups'=>['AccountGroups'=>['AccountCategories']]]]);
		}else{
			$ledgerAccounts = $this->LedgerAccounts->find()->contain(['AccountSecondSubgroups'=>['AccountFirstSubgroups'=>['AccountGroups'=>['AccountCategories']]]])->where(['LedgerAccounts.company_id'=>$st_company_id]);
		}
		
		
		$Companies = $this->LedgerAccounts->Companies->find('list');
		$Current_company = $this->LedgerAccounts->Companies->find()->where(['id'=>$st_company_id])->first();
		//pr
		$this->set(compact('ledgerAccounts', 'Companies','Current_company','company_data'));
        $this->set('_serialize', ['ledgerAccounts']);
    }

    /**
     * View method
     *
     * @param string|null $id Ledger Account id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ledgerAccount = $this->LedgerAccounts->get($id, [
            'contain' => ['AccountSecondSubgroups']
        ]);

        $this->set('ledgerAccount', $ledgerAccount);
        $this->set('_serialize', ['ledgerAccount']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $ledgerAccount = $this->LedgerAccounts->newEntity();
        if ($this->request->is('post')) {
            $ledgerAccount = $this->LedgerAccounts->patchEntity($ledgerAccount, $this->request->data);
			$ledgerAccount->source_model='Ledger Account';
			
            if ($this->LedgerAccounts->save($ledgerAccount)) {
                $this->Flash->success(__('The ledger account has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ledger account could not be saved. Please, try again.'));
            }
        }
        $accountSecondSubgroups = $this->LedgerAccounts->AccountSecondSubgroups->find('list', ['limit' => 200]);
        //$sources = $this->LedgerAccounts->Sources->find('list', ['limit' => 200]);
        $this->set(compact('ledgerAccount', 'accountSecondSubgroups'));
        $this->set('_serialize', ['ledgerAccount']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ledger Account id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $ledgerAccount = $this->LedgerAccounts->get($id, [
            'contain' => ['AccountSecondSubgroups']
        ]);
		//pr($ledgerAccount); exit;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ledgerAccount = $this->LedgerAccounts->patchEntity($ledgerAccount, $this->request->data);
			$ledgerAccount->company_id = $st_company_id;
			$ledgerAccount->source_model='Ledger Account';
            if ($this->LedgerAccounts->save($ledgerAccount)) {
                $this->Flash->success(__('The ledger account has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ledger account could not be saved. Please, try again.'));
            }
        }
		
		$AccountSecondSubgroups = $this->LedgerAccounts->AccountSecondSubgroups->find('list');
        
        $this->set(compact('ledgerAccount', 'AccountSecondSubgroups'));
        $this->set('_serialize', ['ledgerAccount']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ledger Account id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ledgerAccount = $this->LedgerAccounts->get($id);
		$ledgers = $this->LedgerAccounts->Ledgers->exists(['Ledgers.ledger_account_id' => $id]);
		//pr($ledgers); exit;

        if ($ledgers==0) {
			$this->LedgerAccounts->delete($ledgerAccount);
            $this->Flash->success(__('The ledger account has been deleted.'));
        } else {
            $this->Flash->error(__('The ledger account could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function LedgerAccountDropdown($accountSecondSubgroupId = null)
    {
		
        $this->viewBuilder()->layout('');
		$ledgerAccount = $this->LedgerAccounts->find('list')->where(['account_second_subgroup_id'=>$accountSecondSubgroupId]);
		//pr(ledgerAccount); exit;
		$this->set(compact('ledgerAccount'));
    }
	
	public function BillToBillAccount($received_from_id=null){
		$this->viewBuilder()->layout('');
		$ledgerAccount = $this->LedgerAccounts->get($received_from_id);
		echo $bill = $ledgerAccount->bill_to_bill_account;
	}
	
	public function BalanceSheet (){
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$date=$this->request->query('date');
		if($date){
			$query=$this->LedgerAccounts->Ledgers->find();
			$Ledgers_Assets=$query->select(['total_debit' => $query->func()->sum('debit'),'total_credit' => $query->func()->sum('credit')])
			->matching('LedgerAccounts.AccountSecondSubgroups.AccountFirstSubgroups.AccountGroups.AccountCategories', function ($q) {
				return $q->where(['AccountCategories.id' => 1]);
			})
			->where(['transaction_date <='=>date('Y-m-d',strtotime($date)),'Ledgers.company_id'=>$st_company_id])
			->contain(['LedgerAccounts'])
			->group(['ledger_account_id'])
			->order(['AccountGroups.sequence'=>'ASC'])
			->autoFields(true);

			$asset_groups=[];
			foreach($Ledgers_Assets as $Ledgers_Asset){
				$asset_groups[$Ledgers_Asset->_matchingData['AccountGroups']->id]['group_id']
					=$Ledgers_Asset->_matchingData['AccountGroups']->id;
				$asset_groups[$Ledgers_Asset->_matchingData['AccountGroups']->id]['debit']
					=@$asset_groups[$Ledgers_Asset->_matchingData['AccountGroups']->id]['debit']+($Ledgers_Asset->total_debit);
				$asset_groups[$Ledgers_Asset->_matchingData['AccountGroups']->id]['credit']
					=@$asset_groups[$Ledgers_Asset->_matchingData['AccountGroups']->id]['credit']+($Ledgers_Asset->total_credit);
				$asset_groups[$Ledgers_Asset->_matchingData['AccountGroups']->id]['name']
					=$Ledgers_Asset->_matchingData['AccountGroups']->name;
				$asset_groups[$Ledgers_Asset->_matchingData['AccountGroups']->id]['sequence']
					=$Ledgers_Asset->_matchingData['AccountGroups']->sequence;
			}
			
			$query2=$this->LedgerAccounts->Ledgers->find();
			$Ledgers_Liablities=$query2->select(['total_debit' => $query2->func()->sum('debit'),'total_credit' => $query2->func()->sum('credit')])
			->matching('LedgerAccounts.AccountSecondSubgroups.AccountFirstSubgroups.AccountGroups.AccountCategories', function ($q) {
				return $q->where(['AccountCategories.id' => 2]);
			})
			->where(['transaction_date <='=>date('Y-m-d',strtotime($date)),'Ledgers.company_id'=>$st_company_id])
			->contain(['LedgerAccounts'])
			->group(['ledger_account_id'])
			->autoFields(true)->toArray();
			
			$liablitie_groups=[];
			foreach($Ledgers_Liablities as $Ledgers_Liablitie){ //pr($Ledgers_Liablitie->total_credit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountGroups']->id]['group_id']
					=$Ledgers_Liablitie->_matchingData['AccountGroups']->id;
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountGroups']->id]['debit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountGroups']->id]['debit']+($Ledgers_Liablitie->total_debit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountGroups']->id]['credit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountGroups']->id]['credit']+($Ledgers_Liablitie->total_credit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountGroups']->id]['name']
					=$Ledgers_Liablitie->_matchingData['AccountGroups']->name;
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountGroups']->id]['sequence']
					=$Ledgers_Liablitie->_matchingData['AccountGroups']->sequence;
			} 
			
			$this->set(compact('Ledgers_Assets','Ledgers_Liablities', 'asset_groups', 'liablitie_groups'));
		}
		$this->set(compact('date'));
	}
 

	public function firstSubGroups($group_id,$date)
	{
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$query2=$this->LedgerAccounts->Ledgers->find();
			$Ledgers_Liablities=$query2->select(['total_debit' => $query2->func()->sum('debit'),'total_credit' => $query2->func()->sum('credit')])
			->matching('LedgerAccounts.AccountSecondSubgroups.AccountFirstSubgroups.AccountGroups', function ($q) use($group_id) {
				return $q->where(['AccountGroups.id' => $group_id]);
			})
			->where(['transaction_date <='=>date('Y-m-d',strtotime($date)),'Ledgers.company_id'=>$st_company_id])
			->contain(['LedgerAccounts'])
			->group(['ledger_account_id'])
			->autoFields(true)->toArray();
			$liablitie_groups=[];
			foreach($Ledgers_Liablities as $Ledgers_Liablitie){
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id]['group_id']
					=$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id;
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id]['debit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id]['debit']+($Ledgers_Liablitie->total_debit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id]['credit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id]['credit']+($Ledgers_Liablitie->total_credit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id]['name']
					=$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->name;
			}

			$this->set(compact('liablitie_groups'));
		
	}
	
	public function secondSubGroups($group_id,$date)
	{
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$query2=$this->LedgerAccounts->Ledgers->find();
			$Ledgers_Liablities=$query2->select(['total_debit' => $query2->func()->sum('debit'),'total_credit' => $query2->func()->sum('credit')])
			->matching('LedgerAccounts.AccountSecondSubgroups.AccountFirstSubgroups', function ($q) use($group_id) {
				return $q->where(['AccountFirstSubgroups.id' => $group_id]);
			})
			->where(['transaction_date <='=>date('Y-m-d',strtotime($date)),'Ledgers.company_id'=>$st_company_id])
			->contain(['LedgerAccounts'])
			->group(['ledger_account_id'])
			->autoFields(true)->toArray();
			$liablitie_groups=[];
			foreach($Ledgers_Liablities as $Ledgers_Liablitie){
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id]['group_id']
					=$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id;
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id]['debit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id]['debit']+($Ledgers_Liablitie->total_debit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id]['credit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id]['credit']+($Ledgers_Liablitie->total_credit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id]['name']
					=$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->name;
			}

			$this->set(compact('liablitie_groups'));
		
	}
	
	public function ledgerAccountData($group_id,$date)
	{
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$query2=$this->LedgerAccounts->Ledgers->find();
			$Ledgers_Liablities=$query2->select(['total_debit' => $query2->func()->sum('debit'),'total_credit' => $query2->func()->sum('credit')])
			->matching('LedgerAccounts.AccountSecondSubgroups', function ($q) use($group_id) {
				return $q->where(['AccountSecondSubgroups.id' => $group_id]);
			})
			->where(['transaction_date <='=>date('Y-m-d',strtotime($date)),'Ledgers.company_id'=>$st_company_id])
			->contain(['LedgerAccounts'])
			->group(['ledger_account_id'])
			->autoFields(true)->toArray();
			$liablitie_groups=[];
			foreach($Ledgers_Liablities as $Ledgers_Liablitie){
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id]['group_id']
					=$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id;
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id]['debit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id]['debit']+($Ledgers_Liablitie->total_debit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id]['credit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id]['credit']+($Ledgers_Liablitie->total_credit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id]['name']
					=$Ledgers_Liablitie->_matchingData['LedgerAccounts']->name;
			}

			$this->set(compact('liablitie_groups'));
		
	}


	
public function ProfitLossStatement (){
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$date=$this->request->query('date');
		$to_date=$this->request->query('to_date');
	
	if($date){
			$query=$this->LedgerAccounts->Ledgers->find();
			$Ledgers_Expense=$query->select(['total_debit' => $query->func()->sum('debit'),'total_credit' => $query->func()->sum('credit')])
			->matching('LedgerAccounts.AccountSecondSubgroups.AccountFirstSubgroups.AccountGroups.AccountCategories', function ($q) {
				return $q->where(['AccountCategories.id' => 4]);
			})
			->where(['transaction_date >='=>date('Y-m-d',strtotime($date)),'transaction_date <='=>date('Y-m-d',strtotime($to_date)),
			
			'Ledgers.company_id'=>$st_company_id])
			->contain(['LedgerAccounts'])
			->group(['ledger_account_id'])
			->autoFields(true);
			
			$Expense_groups=[];
			foreach($Ledgers_Expense as $Ledgers_Expense){
				$Expense_groups[$Ledgers_Expense->_matchingData['AccountGroups']->id]['group_id']
					=$Ledgers_Expense->_matchingData['AccountGroups']->id;
				$Expense_groups[$Ledgers_Expense->_matchingData['AccountGroups']->id]['debit']
					=@$Expense_groups[$Ledgers_Expense->_matchingData['AccountGroups']->id]['debit']+($Ledgers_Expense->total_debit);
				$Expense_groups[$Ledgers_Expense->_matchingData['AccountGroups']->id]['credit']
					=@$Expense_groups[$Ledgers_Expense->_matchingData['AccountGroups']->id]['credit']+($Ledgers_Expense->total_credit);
				$Expense_groups[$Ledgers_Expense->_matchingData['AccountGroups']->id]['name']
					=$Ledgers_Expense->_matchingData['AccountGroups']->name;
				$Expense_groups[$Ledgers_Expense->_matchingData['AccountGroups']->id]['sequence']
					=$Ledgers_Expense->_matchingData['AccountGroups']->sequence;
			}
			//pr($Expense_groups); exit;
			$query2=$this->LedgerAccounts->Ledgers->find();
			$Ledgers_Income=$query2->select(['total_debit' => $query2->func()->sum('debit'),'total_credit' => $query2->func()->sum('credit')])
			->matching('LedgerAccounts.AccountSecondSubgroups.AccountFirstSubgroups.AccountGroups.AccountCategories', function ($q) {
				return $q->where(['AccountCategories.id' => 3]);
			})
			->where(['transaction_date >='=>date('Y-m-d',strtotime($date)),
			'transaction_date <='=>date('Y-m-d',strtotime($to_date)),'Ledgers.company_id'=>$st_company_id])
			->contain(['LedgerAccounts'])
			->group(['ledger_account_id'])
			->autoFields(true)->toArray();
			
			$Income_groups=[];
			foreach($Ledgers_Income as $Ledgers_Income){ //pr($Ledgers_Liablitie->total_credit);
				$Income_groups[$Ledgers_Income->_matchingData['AccountGroups']->id]['group_id']
					=$Ledgers_Income->_matchingData['AccountGroups']->id;
				$Income_groups[$Ledgers_Income->_matchingData['AccountGroups']->id]['debit']
					=@$Income_groups[$Ledgers_Income->_matchingData['AccountGroups']->id]['debit']+($Ledgers_Income->total_debit);
				$Income_groups[$Ledgers_Income->_matchingData['AccountGroups']->id]['credit']
					=@$Income_groups[$Ledgers_Income->_matchingData['AccountGroups']->id]['credit']+($Ledgers_Income->total_credit);
				$Income_groups[$Ledgers_Income->_matchingData['AccountGroups']->id]['name']
					=$Ledgers_Income->_matchingData['AccountGroups']->name;
				$Income_groups[$Ledgers_Income->_matchingData['AccountGroups']->id]['sequence']
					=$Ledgers_Income->_matchingData['AccountGroups']->sequence;
			}
			
			
			
			$this->set(compact('Expense_groups','Income_groups'));
		}
		$this->set(compact('date','to_date'));
	}
	
public function firstSubGroupsPnl($group_id,$from_date,$to_date)
	{
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$query2=$this->LedgerAccounts->Ledgers->find();
			$Ledgers_Liablities=$query2->select(['total_debit' => $query2->func()->sum('debit'),'total_credit' => $query2->func()->sum('credit')])
			->matching('LedgerAccounts.AccountSecondSubgroups.AccountFirstSubgroups.AccountGroups', function ($q) use($group_id) {
				return $q->where(['AccountGroups.id' => $group_id]);
			})
			->where(['transaction_date >='=>date('Y-m-d',strtotime($from_date)),
			'transaction_date <='=>date('Y-m-d',strtotime($to_date)),'Ledgers.company_id'=>$st_company_id])
			->contain(['LedgerAccounts'])
			->group(['ledger_account_id'])
			->autoFields(true)->toArray();
			$liablitie_groups=[];
			foreach($Ledgers_Liablities as $Ledgers_Liablitie){
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id]['group_id']
					=$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id;
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id]['debit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id]['debit']+($Ledgers_Liablitie->total_debit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id]['credit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id]['credit']+($Ledgers_Liablitie->total_credit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->id]['name']
					=$Ledgers_Liablitie->_matchingData['AccountFirstSubgroups']->name;
			}

			$this->set(compact('liablitie_groups'));
		
	}
	
		public function secondSubGroupsPnl($group_id,$from_date,$to_date)
	{
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$query2=$this->LedgerAccounts->Ledgers->find();
			$Ledgers_Liablities=$query2->select(['total_debit' => $query2->func()->sum('debit'),'total_credit' => $query2->func()->sum('credit')])
			->matching('LedgerAccounts.AccountSecondSubgroups.AccountFirstSubgroups', function ($q) use($group_id) {
				return $q->where(['AccountFirstSubgroups.id' => $group_id]);
			})
			->where(['transaction_date >='=>date('Y-m-d',strtotime($from_date)),
			'transaction_date <='=>date('Y-m-d',strtotime($to_date)),'Ledgers.company_id'=>$st_company_id])
			->contain(['LedgerAccounts'])
			->group(['ledger_account_id'])
			->autoFields(true)->toArray();
			$liablitie_groups=[];
			foreach($Ledgers_Liablities as $Ledgers_Liablitie){
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id]['group_id']
					=$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id;
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id]['debit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id]['debit']+($Ledgers_Liablitie->total_debit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id]['credit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id]['credit']+($Ledgers_Liablitie->total_credit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->id]['name']
					=$Ledgers_Liablitie->_matchingData['AccountSecondSubgroups']->name;
			}

			$this->set(compact('liablitie_groups'));
		
	}
	
	public function ledgerAccountDataPnl($group_id,$from_date,$to_date)
	{
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$query2=$this->LedgerAccounts->Ledgers->find();
			$Ledgers_Liablities=$query2->select(['total_debit' => $query2->func()->sum('debit'),'total_credit' => $query2->func()->sum('credit')])
			->matching('LedgerAccounts.AccountSecondSubgroups', function ($q) use($group_id) {
				return $q->where(['AccountSecondSubgroups.id' => $group_id]);
			})
			->where(['transaction_date >='=>date('Y-m-d',strtotime($from_date)),
			'transaction_date <='=>date('Y-m-d',strtotime($to_date)),'Ledgers.company_id'=>$st_company_id])
			->contain(['LedgerAccounts'])
			->group(['ledger_account_id'])
			->autoFields(true)->toArray();
			$liablitie_groups=[];
			foreach($Ledgers_Liablities as $Ledgers_Liablitie){
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id]['group_id']
					=$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id;
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id]['debit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id]['debit']+($Ledgers_Liablitie->total_debit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id]['credit']
					=@$liablitie_groups[$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id]['credit']+($Ledgers_Liablitie->total_credit);
				$liablitie_groups[$Ledgers_Liablitie->_matchingData['LedgerAccounts']->id]['name']
					=$Ledgers_Liablitie->_matchingData['LedgerAccounts']->name;
			}

			$this->set(compact('liablitie_groups'));
		
	}
	
	function checkBillToBillAccountingStatus($received_from_id){
		$Ledger=$this->LedgerAccounts->get($received_from_id);
		echo $Ledger->bill_to_bill_account;
		exit;
	}
	public function EditCompany($ledgerAccount_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		$Companies = $this->LedgerAccounts->Companies->find();
		$LedgerAccount_data= $this->LedgerAccounts->get($ledgerAccount_id);
//pr($LedgerAccount_data->name); exit;
		$Company_array=[];
		$Company_array1=[];
		$Company_array2=[];
		foreach($Companies as $Company){
			$Company_exist= $this->LedgerAccounts->exists(['name' => $LedgerAccount_data->name,'company_id'=>$Company->id]);
			if($Company_exist){
				$LedgerAccount= $this->LedgerAccounts->find()->where(['name' => $LedgerAccount_data->name,'company_id'=>$Company->id])->first();

				$Company_array[$Company->id]='Yes';
				$Company_array1[$Company->id]=$Company->name;
				$Company_array2[$Company->id]=$LedgerAccount->id;
				
			}else{
				$Company_array[$Company->id]='No';
				$Company_array1[$Company->id]=$Company->name;
				$Company_array2[$Company->id]='';
			}

		}
		
		$this->set(compact('saletax_data','Companies','customer_Company','Company_array','ledgerAccount_id','Company_array1','Company_array2','LedgerAccount_data'));

	}
	
public function AddCompany($ledgerAccount_id=null,$key=null)
    { 
		$this->viewBuilder()->layout('index_layout');	
		$Ledger_details= $this->LedgerAccounts->get($ledgerAccount_id);
		$ledgerAccount = $this->LedgerAccounts->newEntity();
		$ledgerAccount->account_second_subgroup_id = $Ledger_details->account_second_subgroup_id;
		$ledgerAccount->name = $Ledger_details->name;
		$ledgerAccount->source_model = 'Ledger Account';
		$ledgerAccount->source_id = 0;
		$ledgerAccount->company_id = $key;
		$ledgerAccount->auto_inc=$Ledger_details->auto_inc;
		$this->LedgerAccounts->save($ledgerAccount);

		return $this->redirect(['action' => 'EditCompany/'.$ledgerAccount_id]);
	}
public function CheckCompany($ledger_id=null,$company_id=null)
    { //pr($key);exit;
		$this->viewBuilder()->layout('index_layout');	
		 $this->request->allowMethod(['post', 'delete']);
		//pr($employees_ledger->auto_inc); exit;
		$ledgerexist = $this->LedgerAccounts->Ledgers->exists(['ledger_account_id' => $ledger_id]);
		
		if(!$ledgerexist){
			$ledger_dlt= $this->LedgerAccounts->find()->where(['company_id'=>$company_id,'id'=>$ledger_id])->first();
			//pr($ledger_dlt);exit;
			$auto_inc=$ledger_dlt->auto_inc; 
			$this->LedgerAccounts->delete($ledger_dlt);
			$auto_inc_exist= $this->LedgerAccounts->exists(['auto_inc' => $auto_inc]);
			
			if(!$auto_inc_exist){
				$this->Flash->success(__('The ledger account has been deleted.'));
				return $this->redirect(['action' => 'index']);}
			else{
				$page_redirect= $this->LedgerAccounts->find()->where(['auto_inc'=>$auto_inc])->first();
				$this->Flash->success(__('The ledger account has been deleted.'));
				return $this->redirect(['action' => 'EditCompany/'.$page_redirect->id]);
			}
				
		}else{
			$this->Flash->error(__('Company Can not Deleted'));
			return $this->redirect(['action' => 'EditCompany/'.$ledger_id]);
		}
	}
	
	public function updateSequence()
    {
		$AccountGroup=$this->request->query('AccountGroup');
		$AccountGroup_js=json_decode($AccountGroup);
        foreach($AccountGroup_js as  $info)
		{  
          foreach($info as $key => $info1)
		  {
            if($info1)
			{
				    $this->request->allowMethod(['get', 'update']);
					$AccountGroup = $this->LedgerAccounts->AccountGroups->get($key);
					$AccountGroup->sequence=$info1;
					$this->LedgerAccounts->AccountGroups->save($AccountGroup);
			}
          }
		}
		exit;
    }
	
}
