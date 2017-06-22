<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PettyCashVoucherRows Controller
 *
 * @property \App\Model\Table\PettyCashVoucherRowsTable $PettyCashVoucherRows
 */
class PettyCashVoucherRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['PettyCashVouchers', 'ReceivedFroms']
        ];
        $pettyCashVoucherRows = $this->paginate($this->PettyCashVoucherRows);

        $this->set(compact('pettyCashVoucherRows'));
        $this->set('_serialize', ['pettyCashVoucherRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Petty Cash Voucher Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pettyCashVoucherRow = $this->PettyCashVoucherRows->get($id, [
            'contain' => ['PettyCashVouchers', 'ReceivedFroms']
        ]);

        $this->set('pettyCashVoucherRow', $pettyCashVoucherRow);
        $this->set('_serialize', ['pettyCashVoucherRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pettyCashVoucherRow = $this->PettyCashVoucherRows->newEntity();
        if ($this->request->is('post')) {
            $pettyCashVoucherRow = $this->PettyCashVoucherRows->patchEntity($pettyCashVoucherRow, $this->request->data);
            if ($this->PettyCashVoucherRows->save($pettyCashVoucherRow)) {
                $this->Flash->success(__('The petty cash voucher row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The petty cash voucher row could not be saved. Please, try again.'));
            }
        }
        $pettyCashVouchers = $this->PettyCashVoucherRows->PettyCashVouchers->find('list', ['limit' => 200]);
        $receivedFroms = $this->PettyCashVoucherRows->ReceivedFroms->find('list', ['limit' => 200]);
        $this->set(compact('pettyCashVoucherRow', 'pettyCashVouchers', 'receivedFroms'));
        $this->set('_serialize', ['pettyCashVoucherRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Petty Cash Voucher Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pettyCashVoucherRow = $this->PettyCashVoucherRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pettyCashVoucherRow = $this->PettyCashVoucherRows->patchEntity($pettyCashVoucherRow, $this->request->data);
            if ($this->PettyCashVoucherRows->save($pettyCashVoucherRow)) {
                $this->Flash->success(__('The petty cash voucher row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The petty cash voucher row could not be saved. Please, try again.'));
            }
        }
        $pettyCashVouchers = $this->PettyCashVoucherRows->PettyCashVouchers->find('list', ['limit' => 200]);
        $receivedFroms = $this->PettyCashVoucherRows->ReceivedFroms->find('list', ['limit' => 200]);
        $this->set(compact('pettyCashVoucherRow', 'pettyCashVouchers', 'receivedFroms'));
        $this->set('_serialize', ['pettyCashVoucherRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Petty Cash Voucher Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pettyCashVoucherRow = $this->PettyCashVoucherRows->get($id);
        if ($this->PettyCashVoucherRows->delete($pettyCashVoucherRow)) {
            $this->Flash->success(__('The petty cash voucher row has been deleted.'));
        } else {
            $this->Flash->error(__('The petty cash voucher row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
