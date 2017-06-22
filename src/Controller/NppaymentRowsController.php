<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NppaymentRows Controller
 *
 * @property \App\Model\Table\NppaymentRowsTable $NppaymentRows
 */
class NppaymentRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Nppayments', 'ReceivedFroms']
        ];
        $nppaymentRows = $this->paginate($this->NppaymentRows);

        $this->set(compact('nppaymentRows'));
        $this->set('_serialize', ['nppaymentRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Nppayment Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $nppaymentRow = $this->NppaymentRows->get($id, [
            'contain' => ['Nppayments', 'ReceivedFroms']
        ]);

        $this->set('nppaymentRow', $nppaymentRow);
        $this->set('_serialize', ['nppaymentRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $nppaymentRow = $this->NppaymentRows->newEntity();
        if ($this->request->is('post')) {
            $nppaymentRow = $this->NppaymentRows->patchEntity($nppaymentRow, $this->request->data);
            if ($this->NppaymentRows->save($nppaymentRow)) {
                $this->Flash->success(__('The nppayment row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The nppayment row could not be saved. Please, try again.'));
            }
        }
        $nppayments = $this->NppaymentRows->Nppayments->find('list', ['limit' => 200]);
        $receivedFroms = $this->NppaymentRows->ReceivedFroms->find('list', ['limit' => 200]);
        $this->set(compact('nppaymentRow', 'nppayments', 'receivedFroms'));
        $this->set('_serialize', ['nppaymentRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Nppayment Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nppaymentRow = $this->NppaymentRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $nppaymentRow = $this->NppaymentRows->patchEntity($nppaymentRow, $this->request->data);
            if ($this->NppaymentRows->save($nppaymentRow)) {
                $this->Flash->success(__('The nppayment row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The nppayment row could not be saved. Please, try again.'));
            }
        }
        $nppayments = $this->NppaymentRows->Nppayments->find('list', ['limit' => 200]);
        $receivedFroms = $this->NppaymentRows->ReceivedFroms->find('list', ['limit' => 200]);
        $this->set(compact('nppaymentRow', 'nppayments', 'receivedFroms'));
        $this->set('_serialize', ['nppaymentRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Nppayment Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nppaymentRow = $this->NppaymentRows->get($id);
        if ($this->NppaymentRows->delete($nppaymentRow)) {
            $this->Flash->success(__('The nppayment row has been deleted.'));
        } else {
            $this->Flash->error(__('The nppayment row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
