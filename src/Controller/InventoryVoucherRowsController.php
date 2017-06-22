<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InventoryVoucherRows Controller
 *
 * @property \App\Model\Table\InventoryVoucherRowsTable $InventoryVoucherRows
 */
class InventoryVoucherRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['InventoryVouchers', 'Items']
        ];
        $inventoryVoucherRows = $this->paginate($this->InventoryVoucherRows);

        $this->set(compact('inventoryVoucherRows'));
        $this->set('_serialize', ['inventoryVoucherRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Inventory Voucher Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inventoryVoucherRow = $this->InventoryVoucherRows->get($id, [
            'contain' => ['InventoryVouchers', 'Items']
        ]);

        $this->set('inventoryVoucherRow', $inventoryVoucherRow);
        $this->set('_serialize', ['inventoryVoucherRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inventoryVoucherRow = $this->InventoryVoucherRows->newEntity();
        if ($this->request->is('post')) {
            $inventoryVoucherRow = $this->InventoryVoucherRows->patchEntity($inventoryVoucherRow, $this->request->data);
            if ($this->InventoryVoucherRows->save($inventoryVoucherRow)) {
                $this->Flash->success(__('The inventory voucher row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory voucher row could not be saved. Please, try again.'));
            }
        }
        $inventoryVouchers = $this->InventoryVoucherRows->InventoryVouchers->find('list', ['limit' => 200]);
        $items = $this->InventoryVoucherRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('inventoryVoucherRow', 'inventoryVouchers', 'items'));
        $this->set('_serialize', ['inventoryVoucherRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Voucher Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inventoryVoucherRow = $this->InventoryVoucherRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryVoucherRow = $this->InventoryVoucherRows->patchEntity($inventoryVoucherRow, $this->request->data);
            if ($this->InventoryVoucherRows->save($inventoryVoucherRow)) {
                $this->Flash->success(__('The inventory voucher row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory voucher row could not be saved. Please, try again.'));
            }
        }
        $inventoryVouchers = $this->InventoryVoucherRows->InventoryVouchers->find('list', ['limit' => 200]);
        $items = $this->InventoryVoucherRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('inventoryVoucherRow', 'inventoryVouchers', 'items'));
        $this->set('_serialize', ['inventoryVoucherRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Voucher Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryVoucherRow = $this->InventoryVoucherRows->get($id);
        if ($this->InventoryVoucherRows->delete($inventoryVoucherRow)) {
            $this->Flash->success(__('The inventory voucher row has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory voucher row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
