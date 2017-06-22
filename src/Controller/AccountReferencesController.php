<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AccountReferences Controller
 *
 * @property \App\Model\Table\AccountReferencesTable $AccountReferences
 */
class AccountReferencesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
        
        $accountReferences = $this->paginate($this->AccountReferences);
        $accountReferences = $this->AccountReferences->find('all')->toArray();
		//pr($accountReferences); exit;
        $this->set(compact('accountReferences'));
        $this->set('_serialize', ['accountReferences']);
    }

    /**
     * View method
     *
     * @param string|null $id Account Reference id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $accountReference = $this->AccountReferences->get($id, [
            'contain' => ['LedgerAccounts']
        ]);

        $this->set('accountReference', $accountReference);
        $this->set('_serialize', ['accountReference']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

		$this->viewBuilder()->layout('index_layout');
        $accountReference = $this->AccountReferences->newEntity();
        if ($this->request->is('post')) {
            $accountReference = $this->AccountReferences->patchEntity($accountReference, $this->request->data);
            if ($this->AccountReferences->save($accountReference)) {
                $this->Flash->success(__('The account reference has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account reference could not be saved. Please, try again.'));
            }
        }
        //$ledgerAccounts = $this->AccountReferences->LedgerAccounts->find('list', ['limit' => 200]);
		$AccountCategories = $this->AccountReferences->AccountCategories->find('list');
        $this->set(compact('accountReference', 'ledgerAccounts','AccountCategories'));
        $this->set('_serialize', ['accountReference']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Account Reference id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $accountReference = $this->AccountReferences->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accountReference = $this->AccountReferences->patchEntity($accountReference, $this->request->data);
			
			$accountReference->account_first_subgroup_id=$accountReference->account_first_subgroup_id;
            if ($this->AccountReferences->save($accountReference)) {
                $this->Flash->success(__('The account reference has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account reference could not be saved. Please, try again.'));
            }
        }
		$AccountCategories = $this->Employees->AccountCategories->find('list');
		$AccountGroups = $this->Employees->AccountGroups->find('list');
		$AccountFirstSubgroups = $this->Employees->AccountFirstSubgroups->find('list');
		$AccountSecondSubgroups = $this->Employees->AccountSecondSubgroups->find('list');
        $ledgerAccounts = $this->AccountReferences->LedgerAccounts->find('list');
        $this->set(compact('accountReference', 'ledgerAccounts','AccountGroups','AccountCategories','AccountFirstSubgroups','AccountSecondSubgroups'));
        $this->set('_serialize', ['accountReference']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Account Reference id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accountReference = $this->AccountReferences->get($id);
        if ($this->AccountReferences->delete($accountReference)) {
            $this->Flash->success(__('The account reference has been deleted.'));
        } else {
            $this->Flash->error(__('The account reference could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
