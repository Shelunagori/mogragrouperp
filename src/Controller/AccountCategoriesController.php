<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AccountCategories Controller
 *
 * @property \App\Model\Table\AccountCategoriesTable $AccountCategories
 */
class AccountCategoriesController extends AppController
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
		$name=$this->request->query('name');
		$this->set(compact('name'));
		
		if(!empty($name)){
			$where['name LIKE']='%'.$name.'%';
		}
		
		
	    $accountCategories = $this->paginate($this->AccountCategories->find()->where($where));

        $this->set(compact('accountCategories'));
        $this->set('_serialize', ['accountCategories']);
    }

    /**
     * View method
     *
     * @param string|null $id Account Category id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $accountCategory = $this->AccountCategories->get($id, [
            'contain' => ['AccountGroups']
        ]);

        $this->set('accountCategory', $accountCategory);
        $this->set('_serialize', ['accountCategory']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
		
        $accountCategory = $this->AccountCategories->newEntity();
        if ($this->request->is('post')) {
            $accountCategory = $this->AccountCategories->patchEntity($accountCategory, $this->request->data);
            if ($this->AccountCategories->save($accountCategory)) {
                $this->Flash->success(__('The account category has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account category could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('accountCategory'));
        $this->set('_serialize', ['accountCategory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Account Category id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $accountCategory = $this->AccountCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accountCategory = $this->AccountCategories->patchEntity($accountCategory, $this->request->data);
            if ($this->AccountCategories->save($accountCategory)) {
                $this->Flash->success(__('The account category has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The account category could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('accountCategory'));
        $this->set('_serialize', ['accountCategory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Account Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$AccountGroupsexists = $this->AccountCategories->AccountGroups->exists(['account_category_id' => $id]);
		
		if(!$AccountGroupsexists){
        $accountCategory = $this->AccountCategories->get($id);
        if ($this->AccountCategories->delete($accountCategory)) {
            $this->Flash->success(__('The account category has been deleted.'));
        } else {
            $this->Flash->error(__('The account category could not be deleted. Please, try again.'));
        }
		}else{
			$this->Flash->error(__('Once the item groups has generated with item categories, the item categories cannot be deleted.'));
		}
        

        return $this->redirect(['action' => 'index']);
    }
}
