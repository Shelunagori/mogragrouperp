<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PaymentRows Controller
 *
 * @property \App\Model\Table\PaymentRowsTable $PaymentRows
 */
class PaymentRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Receipts', 'ReceivedFroms']
        ];
        $paymentRows = $this->paginate($this->PaymentRows);

        $this->set(compact('paymentRows'));
        $this->set('_serialize', ['paymentRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Payment Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $paymentRow = $this->PaymentRows->get($id, [
            'contain' => ['Receipts', 'ReceivedFroms']
        ]);

        $this->set('paymentRow', $paymentRow);
        $this->set('_serialize', ['paymentRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $paymentRow = $this->PaymentRows->newEntity();
        if ($this->request->is('post')) {
            $paymentRow = $this->PaymentRows->patchEntity($paymentRow, $this->request->data);
            if ($this->PaymentRows->save($paymentRow)) {
                $this->Flash->success(__('The payment row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payment row could not be saved. Please, try again.'));
            }
        }
        $receipts = $this->PaymentRows->Receipts->find('list', ['limit' => 200]);
        $receivedFroms = $this->PaymentRows->ReceivedFroms->find('list', ['limit' => 200]);
        $this->set(compact('paymentRow', 'receipts', 'receivedFroms'));
        $this->set('_serialize', ['paymentRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $paymentRow = $this->PaymentRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $paymentRow = $this->PaymentRows->patchEntity($paymentRow, $this->request->data);
            if ($this->PaymentRows->save($paymentRow)) {
                $this->Flash->success(__('The payment row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payment row could not be saved. Please, try again.'));
            }
        }
        $receipts = $this->PaymentRows->Receipts->find('list', ['limit' => 200]);
        $receivedFroms = $this->PaymentRows->ReceivedFroms->find('list', ['limit' => 200]);
        $this->set(compact('paymentRow', 'receipts', 'receivedFroms'));
        $this->set('_serialize', ['paymentRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $paymentRow = $this->PaymentRows->get($id);
        if ($this->PaymentRows->delete($paymentRow)) {
            $this->Flash->success(__('The payment row has been deleted.'));
        } else {
            $this->Flash->error(__('The payment row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
