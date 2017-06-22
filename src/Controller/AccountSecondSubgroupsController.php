<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AccountSecondSubgroups Controller
 *
 * @property \App\Model\Table\AccountSecondSubgroupsTable $AccountSecondSubgroups
 */
class AccountSecondSubgroupsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		$accountSecondSubgroup = $this->AccountSecondSubgroups->newEntity();
        if ($this->request->is('post')) {
            $accountSecondSubgroup = $this->AccountSecondSubgroups->patchEntity($accountSecondSubgroup, $this->request->data);
            if ($this->AccountSecondSubgroups->save($accountSecondSubgroup)) {
                $this->Flash->success(__('The account second subgroup has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account second subgroup could not be saved. Please, try again.'));
            }
        }
        $accountFirstSubgroups = $this->AccountSecondSubgroups->AccountFirstSubgroups->find('list');
        $this->set(compact('accountSecondSubgroup', 'accountFirstSubgroups'));
        $this->set('_serialize', ['accountSecondSubgroup']);
    
       
		
        $accountSecondSubgroups = $this->AccountSecondSubgroups->find()->contain(['AccountFirstSubgroups'=>['AccountGroups'=>['AccountCategories']]]);
		
        $this->set(compact('accountSecondSubgroups'));
        $this->set('_serialize', ['accountSecondSubgroups']);
    }

    /**
     * View method
     *
     * @param string|null $id Account Second Subgroup id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $accountSecondSubgroup = $this->AccountSecondSubgroups->get($id, [
            'contain' => ['AccountFirstSubgroups']
        ]);

        $this->set('accountSecondSubgroup', $accountSecondSubgroup);
        $this->set('_serialize', ['accountSecondSubgroup']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $accountSecondSubgroup = $this->AccountSecondSubgroups->newEntity();
        if ($this->request->is('post')) {
            $accountSecondSubgroup = $this->AccountSecondSubgroups->patchEntity($accountSecondSubgroup, $this->request->data);
            if ($this->AccountSecondSubgroups->save($accountSecondSubgroup)) {
                $this->Flash->success(__('The account second subgroup has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account second subgroup could not be saved. Please, try again.'));
            }
        }
        $accountFirstSubgroups = $this->AccountSecondSubgroups->AccountFirstSubgroups->find('list', ['limit' => 200]);
        $this->set(compact('accountSecondSubgroup', 'accountFirstSubgroups'));
        $this->set('_serialize', ['accountSecondSubgroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Account Second Subgroup id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		
		$this->viewBuilder()->layout('index_layout');
        $accountSecondSubgroup = $this->AccountSecondSubgroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accountSecondSubgroup = $this->AccountSecondSubgroups->patchEntity($accountSecondSubgroup, $this->request->data);
            if ($this->AccountSecondSubgroups->save($accountSecondSubgroup)) {
                $this->Flash->success(__('The account second subgroup has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account second subgroup could not be saved. Please, try again.'));
            }
        }
        $accountFirstSubgroups = $this->AccountSecondSubgroups->AccountFirstSubgroups->find('list', ['limit' => 200]);
        $this->set(compact('accountSecondSubgroup', 'accountFirstSubgroups'));
        $this->set('_serialize', ['accountSecondSubgroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Account Second Subgroup id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$AccountSecondSubgroupsexists = $this->AccountSecondSubgroups->LedgerAccounts->exists(['account_second_subgroup_id' => $id,'company_id'=>$st_company_id]);
		
		if(!$AccountSecondSubgroupsexists){
        $accountSecondSubgroup = $this->AccountSecondSubgroups->get($id);
        if ($this->AccountSecondSubgroups->delete($accountSecondSubgroup)) {
            $this->Flash->success(__('The account first subgroup has been deleted.'));
        } else {
            $this->Flash->error(__('The account first subgroup could not be deleted. Please, try again.'));
        }
		}else{
			$this->Flash->error(__('Once the account second subgroup has generated with Ledger Accounts, the account second group cannot be deleted.'));
		}
		return $this->redirect(['action' => 'index']);
    }
	
	public function AccountSecondSubgroupDropdown($accountFirstSubgroupId = null)
    {
        $this->viewBuilder()->layout('');
		$accountSecondSubgroups = $this->AccountSecondSubgroups->find('list')->where(['account_first_subgroup_id'=>$accountFirstSubgroupId])->order(['AccountSecondSubgroups.name' => 'ASC']);
		$this->set(compact('accountSecondSubgroups'));
    }
}
