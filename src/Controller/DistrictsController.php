<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Districts Controller
 *
 * @property \App\Model\Table\DistrictsTable $Districts
 */
class DistrictsController extends AppController
{

	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Csrf');
	}

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
        $districts = $this->paginate($this->Districts);

        $this->set(compact('districts'));
        $this->set('_serialize', ['districts']);
    }

    /**
     * View method
     *
     * @param string|null $id District id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $district = $this->Districts->get($id, [
            'contain' => []
        ]);

        $this->set('district', $district);
        $this->set('_serialize', ['district']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
		
        $district = $this->Districts->newEntity();
        if ($this->request->is('post')) {
            $district = $this->Districts->patchEntity($district, $this->request->data);
            if ($this->Districts->save($district)) {
                $this->Flash->success(__('The district has been saved.'));

				 return $this->redirect('/Districts');
            } else {
                $this->Flash->error(__('The district could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('district'));
        $this->set('_serialize', ['district']);
		
		$where=[];
		$customer_state=$this->request->query('customer_state');
		$customer_district=$this->request->query('customer_district');
		$this->set(compact('customer_state','customer_district'));
		if(!empty($customer_state)){
			$where['state LIKE']='%'.$customer_state.'%';
		}
		if(!empty($customer_district)){
			$where['district LIKE']='%'.$customer_district.'%';
		}
		 //$alldistricts = $this->paginate($this->Districts);
		 //$search=$this->request->query('search');
			//if($search){
				//$alldistricts = $this->paginate($this->Districts->find()
				//->where([
					//'state LIKE' => '%'.$search.'%'
				//]));
     //  }
	   
	    $listdistricts = $this->paginate($this->Districts->find()->where($where)->order(['Districts.state' => 'ASC']));
		
        $this->set(compact('alldistricts','listdistricts'));
        $this->set('_serialize', ['alldistricts']);
		$this->set('_serialize', ['listdistricts']);
		
		
    }

    /**
     * Edit method
     *
     * @param string|null $id District id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $district = $this->Districts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $district = $this->Districts->patchEntity($district, $this->request->data);
            if ($this->Districts->save($district)) {
                $this->Flash->success(__('The district has been saved.'));

                return $this->redirect('/Districts');
            } else {
                $this->Flash->error(__('The district could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('district'));
        $this->set('_serialize', ['district']);
    }

    /**
     * Delete method
     *
     * @param string|null $id District id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$Customersexists = $this->Districts->Customers->exists(['district_id' => $id]);
		if(!$Customersexists){
			$district = $this->Districts->get($id);
			if ($this->Districts->delete($district)) {
				$this->Flash->success(__('The district has been deleted.'));
			} else {
				$this->Flash->error(__('The district could not be deleted. Please, try again.'));
			}
		}else{
			$this->Flash->error(__('Once the customers has generated with district, the district cannot be deleted.'));
		}
        

         return $this->redirect('/Districts');
    }
}
