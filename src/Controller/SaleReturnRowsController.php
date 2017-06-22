<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SaleReturnRows Controller
 *
 * @property \App\Model\Table\SaleReturnRowsTable $SaleReturnRows
 */
class SaleReturnRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SaleReturns', 'Items']
        ];
        $saleReturnRows = $this->paginate($this->SaleReturnRows);

        $this->set(compact('saleReturnRows'));
        $this->set('_serialize', ['saleReturnRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Sale Return Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $saleReturnRow = $this->SaleReturnRows->get($id, [
            'contain' => ['SaleReturns', 'Items']
        ]);

        $this->set('saleReturnRow', $saleReturnRow);
        $this->set('_serialize', ['saleReturnRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $saleReturnRow = $this->SaleReturnRows->newEntity();
        if ($this->request->is('post')) {
            $saleReturnRow = $this->SaleReturnRows->patchEntity($saleReturnRow, $this->request->data);
            if ($this->SaleReturnRows->save($saleReturnRow)) {
                $this->Flash->success(__('The sale return row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The sale return row could not be saved. Please, try again.'));
            }
        }
        $saleReturns = $this->SaleReturnRows->SaleReturns->find('list', ['limit' => 200]);
        $items = $this->SaleReturnRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('saleReturnRow', 'saleReturns', 'items'));
        $this->set('_serialize', ['saleReturnRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sale Return Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $saleReturnRow = $this->SaleReturnRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $saleReturnRow = $this->SaleReturnRows->patchEntity($saleReturnRow, $this->request->data);
            if ($this->SaleReturnRows->save($saleReturnRow)) {
                $this->Flash->success(__('The sale return row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The sale return row could not be saved. Please, try again.'));
            }
        }
        $saleReturns = $this->SaleReturnRows->SaleReturns->find('list', ['limit' => 200]);
        $items = $this->SaleReturnRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('saleReturnRow', 'saleReturns', 'items'));
        $this->set('_serialize', ['saleReturnRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sale Return Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $saleReturnRow = $this->SaleReturnRows->get($id);
        if ($this->SaleReturnRows->delete($saleReturnRow)) {
            $this->Flash->success(__('The sale return row has been deleted.'));
        } else {
            $this->Flash->error(__('The sale return row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
