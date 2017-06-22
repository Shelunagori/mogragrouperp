<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Transporters Controller
 *
 * @property \App\Model\Table\TransportersTable $Transporters
 */
class TransportersController extends AppController
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
		$transporter = $this->Transporters->newEntity();
		if ($this->request->is('post')) {
            $transporter = $this->Transporters->patchEntity($transporter, $this->request->data);
            if ($this->Transporters->save($transporter)) {
                $this->Flash->success(__('The transporter has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The transporter could not be saved. Please, try again.'));
            }
        }
		$where=[];
		$transporter_alise=$this->request->query('transporter_alise');

		$this->set(compact('transporter_alise'));
		if(!empty($transporter_alise)){
			$where['Transporters.transporter_name LIKE']='%'.$transporter_alise.'%';
		}
		
        $this->set(compact('transporter'));
        $this->set('_serialize', ['transporter']);
		
        $transporters = $this->paginate($this->Transporters->find()->where($where)->order(['Transporters.transporter_name' => 'ASC']));

        $this->set(compact('transporters','status'));
        $this->set('_serialize', ['transporters']);
		$this->set(compact('url'));
    }

    /**
     * View method
     *
     * @param string|null $id Transporter id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transporter = $this->Transporters->get($id, [
            'contain' => []
        ]);

        $this->set('transporter', $transporter);
        $this->set('_serialize', ['transporter']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transporter = $this->Transporters->newEntity();
        if ($this->request->is('post')) {
            $transporter = $this->Transporters->patchEntity($transporter, $this->request->data);
            if ($this->Transporters->save($transporter)) {
                $this->Flash->success(__('The transporter has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The transporter could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('transporter'));
        $this->set('_serialize', ['transporter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Transporter id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $transporter = $this->Transporters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transporter = $this->Transporters->patchEntity($transporter, $this->request->data);
            
			if ($this->Transporters->save($transporter)) {
                $this->Flash->success(__('The transporter has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The transporter could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('transporter'));
        $this->set('_serialize', ['transporter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Transporter id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$SalesOrdersexists = $this->Transporters->SalesOrders->exists(['transporter_id' => $id]);
		$SalesOrdersexists2 = $this->Transporters->SalesOrders->exists(['documents_courier_id' => $id]);
		$Customersexists = $this->Transporters->Customers->exists(['transporter_id' => $id]);
		$CustomerAddressexists = $this->Transporters->CustomerAddress->exists(['transporter_id' => $id]);
		if(!$SalesOrdersexists and !$SalesOrdersexists2 and !$Customersexists and !$CustomerAddressexists){
			$transporter = $this->Transporters->get($id);
			if ($this->Transporters->delete($transporter)) {
				$this->Flash->success(__('The transporter has been deleted.'));
			} else {
				$this->Flash->error(__('The transporter could not be deleted. Please, try again.'));
			}
		}elseif($SalesOrdersexists or $SalesOrdersexists2){
			$this->Flash->error(__('Once the sales order has generated with transporter, the transporter cannot be deleted.'));
		}elseif($Customersexists or $CustomerAddressexists){
			$this->Flash->error(__('Once the customer has registered with transporter, the transporter cannot be deleted.'));
		}
        

        return $this->redirect(['action' => 'index']);
    }
}
