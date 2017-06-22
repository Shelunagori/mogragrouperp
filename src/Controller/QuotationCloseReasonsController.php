<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * QuotationCloseReasons Controller
 *
 * @property \App\Model\Table\QuotationCloseReasonsTable $QuotationCloseReasons
 */
class QuotationCloseReasonsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		
		$this->viewBuilder()->layout('index_layout');
        $quotationCloseReason = $this->QuotationCloseReasons->newEntity();
        if ($this->request->is('post')) {
            $quotationCloseReason = $this->QuotationCloseReasons->patchEntity($quotationCloseReason, $this->request->data);
            if ($this->QuotationCloseReasons->save($quotationCloseReason)) {
                $this->Flash->success(__('The quotation close reason has been saved.'));
				return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The quotation close reason could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('quotationCloseReason'));
        $this->set('_serialize', ['quotationCloseReason']);
        $quotationCloseReasons = $this->paginate($this->QuotationCloseReasons);

        $this->set(compact('quotationCloseReasons'));
        $this->set('_serialize', ['quotationCloseReasons']);
    }

    /**
     * View method
     *
     * @param string|null $id Quotation Close Reason id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $quotationCloseReason = $this->QuotationCloseReasons->get($id, [
            'contain' => []
        ]);

        $this->set('quotationCloseReason', $quotationCloseReason);
        $this->set('_serialize', ['quotationCloseReason']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $quotationCloseReason = $this->QuotationCloseReasons->newEntity();
        if ($this->request->is('post')) {
            $quotationCloseReason = $this->QuotationCloseReasons->patchEntity($quotationCloseReason, $this->request->data);
            if ($this->QuotationCloseReasons->save($quotationCloseReason)) {
                $this->Flash->success(__('The quotation close reason has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The quotation close reason could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('quotationCloseReason'));
        $this->set('_serialize', ['quotationCloseReason']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Quotation Close Reason id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $quotationCloseReason = $this->QuotationCloseReasons->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $quotationCloseReason = $this->QuotationCloseReasons->patchEntity($quotationCloseReason, $this->request->data);
            if ($this->QuotationCloseReasons->save($quotationCloseReason)) {
                $this->Flash->success(__('The quotation close reason has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The quotation close reason could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('quotationCloseReason'));
        $this->set('_serialize', ['quotationCloseReason']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Quotation Close Reason id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $quotationCloseReason = $this->QuotationCloseReasons->get($id);
        if ($this->QuotationCloseReasons->delete($quotationCloseReason)) {
            $this->Flash->success(__('The quotation close reason has been deleted.'));
        } else {
            $this->Flash->error(__('The quotation close reason could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
