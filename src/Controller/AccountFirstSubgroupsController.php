<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AccountFirstSubgroups Controller
 *
 * @property \App\Model\Table\AccountFirstSubgroupsTable $AccountFirstSubgroups
 */
class AccountFirstSubgroupsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		$accountFirstSubgroup = $this->AccountFirstSubgroups->newEntity();
		if ($this->request->is('post')) {
            $accountFirstSubgroup = $this->AccountFirstSubgroups->patchEntity($accountFirstSubgroup, $this->request->data);
            if ($this->AccountFirstSubgroups->save($accountFirstSubgroup)) {
                $this->Flash->success(__('The account first subgroup has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account first subgroup could not be saved. Please, try again.'));
            }
        }
        $accountGroups = $this->AccountFirstSubgroups->AccountGroups->find('list');
        $this->set(compact('accountFirstSubgroup', 'accountGroups'));
        $this->set('_serialize', ['accountFirstSubgroup']);

        $this->paginate = [
            'contain' => ['AccountGroups'=>['AccountCategories']]
        ];
		
		$accountFirstSubgroups = $this->AccountFirstSubgroups->find()->contain(['AccountGroups'=>['AccountCategories']]);
		
        //$accountFirstSubgroups = $this->paginate($this->AccountFirstSubgroups->find()->where($where));

        $this->set(compact('accountFirstSubgroups'));
        $this->set('_serialize', ['accountFirstSubgroups']);
    }

    /**
     * View method
     *
     * @param string|null $id Account First Subgroup id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $accountFirstSubgroup = $this->AccountFirstSubgroups->get($id, [
            'contain' => ['AccountGroups']
        ]);

        $this->set('accountFirstSubgroup', $accountFirstSubgroup);
        $this->set('_serialize', ['accountFirstSubgroup']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $accountFirstSubgroup = $this->AccountFirstSubgroups->newEntity();
        if ($this->request->is('post')) {
            $accountFirstSubgroup = $this->AccountFirstSubgroups->patchEntity($accountFirstSubgroup, $this->request->data);
            if ($this->AccountFirstSubgroups->save($accountFirstSubgroup)) {
                $this->Flash->success(__('The account first subgroup has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account first subgroup could not be saved. Please, try again.'));
            }
        }
        $accountGroups = $this->AccountFirstSubgroups->AccountGroups->find('list', ['limit' => 200]);
        $this->set(compact('accountFirstSubgroup', 'accountGroups'));
        $this->set('_serialize', ['accountFirstSubgroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Account First Subgroup id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		
		$this->viewBuilder()->layout('index_layout');
        $accountFirstSubgroup = $this->AccountFirstSubgroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accountFirstSubgroup = $this->AccountFirstSubgroups->patchEntity($accountFirstSubgroup, $this->request->data);
            if ($this->AccountFirstSubgroups->save($accountFirstSubgroup)) {
                $this->Flash->success(__('The account first subgroup has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account first subgroup could not be saved. Please, try again.'));
            }
        }
        $accountGroups = $this->AccountFirstSubgroups->AccountGroups->find('list', ['limit' => 200]);
        $this->set(compact('accountFirstSubgroup', 'accountGroups'));
        $this->set('_serialize', ['accountFirstSubgroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Account First Subgroup id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$AccountSecondSubgroupsexists = $this->AccountFirstSubgroups->AccountSecondSubgroups->exists(['account_first_subgroup_id' => $id]);
		
		if(!$AccountSecondSubgroupsexists){
        $accountFirstSubgroup = $this->AccountFirstSubgroups->get($id);
        if ($this->AccountFirstSubgroups->delete($accountFirstSubgroup)) {
            $this->Flash->success(__('The account first subgroup has been deleted.'));
        } else {
            $this->Flash->error(__('The account first subgroup could not be deleted. Please, try again.'));
        }
		}else{
			$this->Flash->error(__('Once the account first subgroup has generated with Account Second subgroup, the account first group cannot be deleted.'));
		}

        return $this->redirect(['action' => 'index']);
    }
	
	public function AccountFirstSubgroupDropdown($accountGroupId = null)
    {
        $this->viewBuilder()->layout('');
		$accountFirstSubgroups = $this->AccountFirstSubgroups->find('list')->where(['account_group_id'=>$accountGroupId])->order(['AccountFirstSubgroups.name' => 'ASC']);
		$this->set(compact('accountFirstSubgroups'));
    }
}
