<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AccountGroups Controller
 *
 * @property \App\Model\Table\AccountGroupsTable $AccountGroups
 */
class AccountGroupsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		$accountGroup = $this->AccountGroups->newEntity();
		
		
        if ($this->request->is('post')) {
            $accountGroup = $this->AccountGroups->patchEntity($accountGroup, $this->request->data);
			$name=$accountGroup->name;
			//pr($name); exit;
			$AccountGroupsNameexists = $this->AccountGroups->exists(['name' => $name]);
						
			
					if ($this->AccountGroups->save($accountGroup)) {
					$this->Flash->success(__('The account group has been saved.'));

					return $this->redirect(['action' => 'index']);
					} else {
					$this->Flash->error(__('The account group could not be saved. Please, try again.'));
					}
			
					
		}
        $accountCategories = $this->AccountGroups->AccountCategories->find('list');
        $this->set(compact('accountGroup', 'accountCategories'));
        $this->set('_serialize', ['accountGroup']);
    
        $this->paginate = [
            'contain' => ['AccountCategories']
        ];
		
		$accountGroups = $this->AccountGroups->find()->contain(['AccountCategories']);
		
        //$accountGroups = $this->paginate($this->AccountGroups->find()->where($where));

        $this->set(compact('accountGroups'));
        $this->set('_serialize', ['accountGroups']);
    }

    /**
     * View method
     *
     * @param string|null $id Account Group id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $accountGroup = $this->AccountGroups->get($id, [
            'contain' => ['AccountCategories', 'AccountFirstSubgroups']
        ]);

        $this->set('accountGroup', $accountGroup);
        $this->set('_serialize', ['accountGroup']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
		
        $accountGroup = $this->AccountGroups->newEntity();

        if ($this->request->is('post')) {
            $accountGroup = $this->AccountGroups->patchEntity($accountGroup, $this->request->data);
            if ($this->AccountGroups->save($accountGroup)) {
                $this->Flash->success(__('The account group has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account group could not be saved. Please, try again.'));
            }
        }
        $accountCategories = $this->AccountGroups->AccountCategories->find('list', ['limit' => 200]);
        $this->set(compact('accountGroup', 'accountCategories'));
        $this->set('_serialize', ['accountGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Account Group id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		
		$this->viewBuilder()->layout('index_layout');
        $accountGroup = $this->AccountGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accountGroup = $this->AccountGroups->patchEntity($accountGroup, $this->request->data);
            if ($this->AccountGroups->save($accountGroup)) {
                $this->Flash->success(__('The account group has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account group could not be saved. Please, try again.'));
            }
        }
        $accountCategories = $this->AccountGroups->AccountCategories->find('list', ['limit' => 200]);
        $this->set(compact('accountGroup', 'accountCategories'));
        $this->set('_serialize', ['accountGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Account Group id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$AccountFirstSubgroupsexists = $this->AccountGroups->AccountFirstSubgroups->exists(['account_group_id' => $id]);
		
		if(!$AccountFirstSubgroupsexists){
        $accountGroup = $this->AccountGroups->get($id);
        if ($this->AccountGroups->delete($accountGroup)) {
            $this->Flash->success(__('The account group has been deleted.'));
        } else {
            $this->Flash->error(__('The account group could not be deleted. Please, try again.'));
        }
		}else{
			$this->Flash->error(__('Once the account group has generated with Account categories, the account group cannot be deleted.'));
		}

        return $this->redirect(['action' => 'index']);
    }
	
	public function AccountGroupDropdown($accountCategoryId = null)
    {
        $this->viewBuilder()->layout('');
		$accountGroups = $this->AccountGroups->find('list')->where(['account_category_id'=>$accountCategoryId])->order(['AccountGroups.name' => 'ASC']);
		$this->set(compact('accountGroups'));
    }
}
