<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * IvLeftRows Controller
 *
 * @property \App\Model\Table\IvLeftRowsTable $IvLeftRows
 */
class IvLeftRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Ivs', 'InvoiceRows']
        ];
        $ivLeftRows = $this->paginate($this->IvLeftRows);

        $this->set(compact('ivLeftRows'));
        $this->set('_serialize', ['ivLeftRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Iv Left Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ivLeftRow = $this->IvLeftRows->get($id, [
            'contain' => ['Ivs', 'InvoiceRows', 'IvLeftSerialNumbers', 'IvRightRows']
        ]);

        $this->set('ivLeftRow', $ivLeftRow);
        $this->set('_serialize', ['ivLeftRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ivLeftRow = $this->IvLeftRows->newEntity();
        if ($this->request->is('post')) {
            $ivLeftRow = $this->IvLeftRows->patchEntity($ivLeftRow, $this->request->data);
            if ($this->IvLeftRows->save($ivLeftRow)) {
                $this->Flash->success(__('The iv left row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The iv left row could not be saved. Please, try again.'));
            }
        }
        $ivs = $this->IvLeftRows->Ivs->find('list', ['limit' => 200]);
        $invoiceRows = $this->IvLeftRows->InvoiceRows->find('list', ['limit' => 200]);
        $this->set(compact('ivLeftRow', 'ivs', 'invoiceRows'));
        $this->set('_serialize', ['ivLeftRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Iv Left Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ivLeftRow = $this->IvLeftRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ivLeftRow = $this->IvLeftRows->patchEntity($ivLeftRow, $this->request->data);
            if ($this->IvLeftRows->save($ivLeftRow)) {
                $this->Flash->success(__('The iv left row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The iv left row could not be saved. Please, try again.'));
            }
        }
        $ivs = $this->IvLeftRows->Ivs->find('list', ['limit' => 200]);
        $invoiceRows = $this->IvLeftRows->InvoiceRows->find('list', ['limit' => 200]);
        $this->set(compact('ivLeftRow', 'ivs', 'invoiceRows'));
        $this->set('_serialize', ['ivLeftRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Iv Left Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ivLeftRow = $this->IvLeftRows->get($id);
        if ($this->IvLeftRows->delete($ivLeftRow)) {
            $this->Flash->success(__('The iv left row has been deleted.'));
        } else {
            $this->Flash->error(__('The iv left row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
