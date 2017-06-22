<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CustomerSegs Controller
 *
 * @property \App\Model\Table\CustomerSegsTable $CustomerSegs
 */
class CustomerSegsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
        $customerSegs = $this->paginate($this->CustomerSegs->find()->order(['CustomerSegs.name' => 'ASC']));

        $this->set(compact('customerSegs'));
        $this->set('_serialize', ['customerSegs']);
    }

    /**
     * View method
     *
     * @param string|null $id Customer Seg id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $customerSeg = $this->CustomerSegs->get($id, [
            'contain' => ['Customers']
        ]);

        $this->set('customerSeg', $customerSeg);
        $this->set('_serialize', ['customerSeg']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $customerSeg = $this->CustomerSegs->newEntity();
        if ($this->request->is('post')) {
			$this->request->data["flag"]=0;
            $customerSeg = $this->CustomerSegs->patchEntity($customerSeg, $this->request->data);
            if ($this->CustomerSegs->save($customerSeg)) {
				$name=$customerSeg->name;
                $this->Flash->success(__('The Customer Segment '.$name.' has been saved.'));

               return $this->redirect('/customer-segs');
            } else {
                $this->Flash->error(__('The Customer Segment could not be saved. Please, try again.'));
            }
        }
		
		$where=[];
		$cust_seg=$this->request->query('cust_seg');
		$this->set(compact('cust_seg'));
		if(!empty($cust_seg)){
			$where['name LIKE']='%'.$cust_seg.'%';
		}
		$customerSegs = $this->paginate($this->CustomerSegs->find()->where($where));
        $this->set(compact('customerSeg','customerSegs'));
        $this->set('_serialize', ['customerSeg','customerSegs']);
		
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Seg id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $customerSeg = $this->CustomerSegs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerSeg = $this->CustomerSegs->patchEntity($customerSeg, $this->request->data);
            if ($this->CustomerSegs->save($customerSeg)) {
                $this->Flash->success(__('The Customer Segment has been saved.'));

               return $this->redirect('/customer-segs');
            } else {
                $this->Flash->error(__('The Customer Segment could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('customerSeg'));
        $this->set('_serialize', ['customerSeg']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Seg id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerSeg = $this->CustomerSegs->get($id);
		$Customersexists = $this->CustomerSegs->Customers->exists(['customer_seg_id' => $id]);
		if(!$Customersexists){
			if ($this->CustomerSegs->delete($customerSeg)) {
				$this->Flash->success(__('The customer seg has been deleted.'));
			} else {
				$this->Flash->error(__('The customer seg could not be deleted. Please, try again.'));
			}
		}else{
			$this->Flash->error(__('Once the company segment has registered companies under it, the segment cannot be deleted.'));
		}
		

        return $this->redirect('/customer-segs');
    }
}
