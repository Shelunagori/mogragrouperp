<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CustomerGroups Controller
 *
 * @property \App\Model\Table\CustomerGroupsTable $CustomerGroups
 */
class CustomerGroupsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    
    public function index($status=null)
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$this->viewBuilder()->layout('index_layout');
		$customerGroup = $this->CustomerGroups->newEntity();
        if ($this->request->is('post')) {
            $customerGroup = $this->CustomerGroups->patchEntity($customerGroup, $this->request->data);
		
            if ($this->CustomerGroups->save($customerGroup)) {
				$name=$customerGroup->name;
                $this->Flash->success(__('The customer group '.$name.' has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
			else {
                $this->Flash->error(__('The customer group could not be saved. Please, try again.'));
            }
        }
		
		$where=[];
		$customer_group=$this->request->query('customer_group');
		
		$this->set(compact('customer_group'));
		if(!empty($customer_group)){
			$where['CustomerGroups.name LIKE']='%'.$customer_group.'%';
		}
        $this->set(compact('customerGroup'));
        $this->set('_serialize', ['customerGroup']);
		
        $customerGroups = $this->paginate($this->CustomerGroups->find()->where($where)->order(['CustomerGroups.name' => 'ASC']));

        $this->set(compact('customerGroups','status'));
        $this->set('_serialize', ['customerGroups']);
		$this->set(compact('url'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer Group id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerGroup = $this->CustomerGroups->get($id, [
            'contain' => ['Customers']
        ]);

        $this->set('customerGroup', $customerGroup);
        $this->set('_serialize', ['customerGroup']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customerGroup = $this->CustomerGroups->newEntity();
        if ($this->request->is('post')) {
            $customerGroup = $this->CustomerGroups->patchEntity($customerGroup, $this->request->data);
            if ($this->CustomerGroups->save($customerGroup)) {
				
                $this->Flash->success(__('The customer group has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The customer group could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('customerGroup'));
        $this->set('_serialize', ['customerGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Group id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $customerGroup = $this->CustomerGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerGroup = $this->CustomerGroups->patchEntity($customerGroup, $this->request->data);
            if ($this->CustomerGroups->save($customerGroup)) {
                $this->Flash->success(__('The customer group has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The customer group could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('customerGroup'));
        $this->set('_serialize', ['customerGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Group id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$Customersexists = $this->CustomerGroups->Customers->exists(['customer_group_id' => $id]);
		if(!$Customersexists){
			$customerGroup = $this->CustomerGroups->get($id);
			if ($this->CustomerGroups->delete($customerGroup)) {
				$this->Flash->success(__('The customer group has been deleted.'));
			} else {
				$this->Flash->error(__('The customer group could not be deleted. Please, try again.'));
			}
		}else{
			$this->Flash->error(__('Once the customer group has registered customers under it, the group cannot be deleted.'));
		}
        

        return $this->redirect(['action' => 'index']);
    }
}
