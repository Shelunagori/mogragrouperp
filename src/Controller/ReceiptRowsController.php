<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ReceiptRows Controller
 *
 * @property \App\Model\Table\ReceiptRowsTable $ReceiptRows
 */
class ReceiptRowsController extends AppController
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
        $receiptRows = $this->paginate($this->ReceiptRows);

        $this->set(compact('receiptRows'));
        $this->set('_serialize', ['receiptRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Receipt Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $receiptRow = $this->ReceiptRows->get($id, [
            'contain' => ['Receipts', 'ReceivedFroms']
        ]);

        $this->set('receiptRow', $receiptRow);
        $this->set('_serialize', ['receiptRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $receiptRow = $this->ReceiptRows->newEntity();
        if ($this->request->is('post')) {
            $receiptRow = $this->ReceiptRows->patchEntity($receiptRow, $this->request->data);
            if ($this->ReceiptRows->save($receiptRow)) {
                $this->Flash->success(__('The receipt row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The receipt row could not be saved. Please, try again.'));
            }
        }
        $receipts = $this->ReceiptRows->Receipts->find('list', ['limit' => 200]);
        $receivedFroms = $this->ReceiptRows->ReceivedFroms->find('list', ['limit' => 200]);
        $this->set(compact('receiptRow', 'receipts', 'receivedFroms'));
        $this->set('_serialize', ['receiptRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Receipt Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $receiptRow = $this->ReceiptRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $receiptRow = $this->ReceiptRows->patchEntity($receiptRow, $this->request->data);
            if ($this->ReceiptRows->save($receiptRow)) {
                $this->Flash->success(__('The receipt row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The receipt row could not be saved. Please, try again.'));
            }
        }
        $receipts = $this->ReceiptRows->Receipts->find('list', ['limit' => 200]);
        $receivedFroms = $this->ReceiptRows->ReceivedFroms->find('list', ['limit' => 200]);
        $this->set(compact('receiptRow', 'receipts', 'receivedFroms'));
        $this->set('_serialize', ['receiptRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Receipt Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $receiptRow = $this->ReceiptRows->get($id);
        if ($this->ReceiptRows->delete($receiptRow)) {
            $this->Flash->success(__('The receipt row has been deleted.'));
        } else {
            $this->Flash->error(__('The receipt row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
