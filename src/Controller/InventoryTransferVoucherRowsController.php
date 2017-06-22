<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InventoryTransferVoucherRows Controller
 *
 * @property \App\Model\Table\InventoryTransferVoucherRowsTable $InventoryTransferVoucherRows
 */
class InventoryTransferVoucherRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['InventoryTransferVouchers', 'Items']
        ];
        $inventoryTransferVoucherRows = $this->paginate($this->InventoryTransferVoucherRows);

        $this->set(compact('inventoryTransferVoucherRows'));
        $this->set('_serialize', ['inventoryTransferVoucherRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Inventory Transfer Voucher Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inventoryTransferVoucherRow = $this->InventoryTransferVoucherRows->get($id, [
            'contain' => ['InventoryTransferVouchers', 'Items']
        ]);

        $this->set('inventoryTransferVoucherRow', $inventoryTransferVoucherRow);
        $this->set('_serialize', ['inventoryTransferVoucherRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inventoryTransferVoucherRow = $this->InventoryTransferVoucherRows->newEntity();
        if ($this->request->is('post')) {
            $inventoryTransferVoucherRow = $this->InventoryTransferVoucherRows->patchEntity($inventoryTransferVoucherRow, $this->request->data);
            if ($this->InventoryTransferVoucherRows->save($inventoryTransferVoucherRow)) {
                $this->Flash->success(__('The inventory transfer voucher row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory transfer voucher row could not be saved. Please, try again.'));
            }
        }
        $inventoryTransferVouchers = $this->InventoryTransferVoucherRows->InventoryTransferVouchers->find('list', ['limit' => 200]);
        $items = $this->InventoryTransferVoucherRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('inventoryTransferVoucherRow', 'inventoryTransferVouchers', 'items'));
        $this->set('_serialize', ['inventoryTransferVoucherRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Transfer Voucher Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inventoryTransferVoucherRow = $this->InventoryTransferVoucherRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryTransferVoucherRow = $this->InventoryTransferVoucherRows->patchEntity($inventoryTransferVoucherRow, $this->request->data);
            if ($this->InventoryTransferVoucherRows->save($inventoryTransferVoucherRow)) {
                $this->Flash->success(__('The inventory transfer voucher row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory transfer voucher row could not be saved. Please, try again.'));
            }
        }
        $inventoryTransferVouchers = $this->InventoryTransferVoucherRows->InventoryTransferVouchers->find('list', ['limit' => 200]);
        $items = $this->InventoryTransferVoucherRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('inventoryTransferVoucherRow', 'inventoryTransferVouchers', 'items'));
        $this->set('_serialize', ['inventoryTransferVoucherRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Transfer Voucher Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryTransferVoucherRow = $this->InventoryTransferVoucherRows->get($id);
        if ($this->InventoryTransferVoucherRows->delete($inventoryTransferVoucherRow)) {
            $this->Flash->success(__('The inventory transfer voucher row has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory transfer voucher row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
