<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ContraVoucherRows Controller
 *
 * @property \App\Model\Table\ContraVoucherRowsTable $ContraVoucherRows
 */
class ContraVoucherRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ContraVouchers', 'ReceivedFroms']
        ];
        $contraVoucherRows = $this->paginate($this->ContraVoucherRows);

        $this->set(compact('contraVoucherRows'));
        $this->set('_serialize', ['contraVoucherRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Contra Voucher Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contraVoucherRow = $this->ContraVoucherRows->get($id, [
            'contain' => ['ContraVouchers', 'ReceivedFroms']
        ]);

        $this->set('contraVoucherRow', $contraVoucherRow);
        $this->set('_serialize', ['contraVoucherRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contraVoucherRow = $this->ContraVoucherRows->newEntity();
        if ($this->request->is('post')) {
            $contraVoucherRow = $this->ContraVoucherRows->patchEntity($contraVoucherRow, $this->request->data);
            if ($this->ContraVoucherRows->save($contraVoucherRow)) {
                $this->Flash->success(__('The contra voucher row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The contra voucher row could not be saved. Please, try again.'));
            }
        }
        $contraVouchers = $this->ContraVoucherRows->ContraVouchers->find('list', ['limit' => 200]);
        $receivedFroms = $this->ContraVoucherRows->ReceivedFroms->find('list', ['limit' => 200]);
        $this->set(compact('contraVoucherRow', 'contraVouchers', 'receivedFroms'));
        $this->set('_serialize', ['contraVoucherRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Contra Voucher Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contraVoucherRow = $this->ContraVoucherRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contraVoucherRow = $this->ContraVoucherRows->patchEntity($contraVoucherRow, $this->request->data);
            if ($this->ContraVoucherRows->save($contraVoucherRow)) {
                $this->Flash->success(__('The contra voucher row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The contra voucher row could not be saved. Please, try again.'));
            }
        }
        $contraVouchers = $this->ContraVoucherRows->ContraVouchers->find('list', ['limit' => 200]);
        $receivedFroms = $this->ContraVoucherRows->ReceivedFroms->find('list', ['limit' => 200]);
        $this->set(compact('contraVoucherRow', 'contraVouchers', 'receivedFroms'));
        $this->set('_serialize', ['contraVoucherRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contra Voucher Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contraVoucherRow = $this->ContraVoucherRows->get($id);
        if ($this->ContraVoucherRows->delete($contraVoucherRow)) {
            $this->Flash->success(__('The contra voucher row has been deleted.'));
        } else {
            $this->Flash->error(__('The contra voucher row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
