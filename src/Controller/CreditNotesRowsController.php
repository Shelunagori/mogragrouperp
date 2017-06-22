<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CreditNotesRows Controller
 *
 * @property \App\Model\Table\CreditNotesRowsTable $CreditNotesRows
 */
class CreditNotesRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CreditNotes', 'Heads']
        ];
        $creditNotesRows = $this->paginate($this->CreditNotesRows);

        $this->set(compact('creditNotesRows'));
        $this->set('_serialize', ['creditNotesRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Credit Notes Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $creditNotesRow = $this->CreditNotesRows->get($id, [
            'contain' => ['CreditNotes', 'Heads']
        ]);

        $this->set('creditNotesRow', $creditNotesRow);
        $this->set('_serialize', ['creditNotesRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $creditNotesRow = $this->CreditNotesRows->newEntity();
        if ($this->request->is('post')) {
            $creditNotesRow = $this->CreditNotesRows->patchEntity($creditNotesRow, $this->request->data);
            if ($this->CreditNotesRows->save($creditNotesRow)) {
                $this->Flash->success(__('The credit notes row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The credit notes row could not be saved. Please, try again.'));
            }
        }
        $creditNotes = $this->CreditNotesRows->CreditNotes->find('list', ['limit' => 200]);
        $heads = $this->CreditNotesRows->Heads->find('list', ['limit' => 200]);
        $this->set(compact('creditNotesRow', 'creditNotes', 'heads'));
        $this->set('_serialize', ['creditNotesRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Credit Notes Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $creditNotesRow = $this->CreditNotesRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $creditNotesRow = $this->CreditNotesRows->patchEntity($creditNotesRow, $this->request->data);
            if ($this->CreditNotesRows->save($creditNotesRow)) {
                $this->Flash->success(__('The credit notes row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The credit notes row could not be saved. Please, try again.'));
            }
        }
        $creditNotes = $this->CreditNotesRows->CreditNotes->find('list', ['limit' => 200]);
        $heads = $this->CreditNotesRows->Heads->find('list', ['limit' => 200]);
        $this->set(compact('creditNotesRow', 'creditNotes', 'heads'));
        $this->set('_serialize', ['creditNotesRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Credit Notes Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $creditNotesRow = $this->CreditNotesRows->get($id);
        if ($this->CreditNotesRows->delete($creditNotesRow)) {
            $this->Flash->success(__('The credit notes row has been deleted.'));
        } else {
            $this->Flash->error(__('The credit notes row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
