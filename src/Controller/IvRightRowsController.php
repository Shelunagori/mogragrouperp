<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * IvRightRows Controller
 *
 * @property \App\Model\Table\IvRightRowsTable $IvRightRows
 */
class IvRightRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['IvLeftRows', 'Items']
        ];
        $ivRightRows = $this->paginate($this->IvRightRows);

        $this->set(compact('ivRightRows'));
        $this->set('_serialize', ['ivRightRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Iv Right Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ivRightRow = $this->IvRightRows->get($id, [
            'contain' => ['IvLeftRows', 'Items', 'IvRightSerialNumbers']
        ]);

        $this->set('ivRightRow', $ivRightRow);
        $this->set('_serialize', ['ivRightRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ivRightRow = $this->IvRightRows->newEntity();
        if ($this->request->is('post')) {
            $ivRightRow = $this->IvRightRows->patchEntity($ivRightRow, $this->request->data);
            if ($this->IvRightRows->save($ivRightRow)) {
                $this->Flash->success(__('The iv right row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The iv right row could not be saved. Please, try again.'));
            }
        }
        $ivLeftRows = $this->IvRightRows->IvLeftRows->find('list', ['limit' => 200]);
        $items = $this->IvRightRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('ivRightRow', 'ivLeftRows', 'items'));
        $this->set('_serialize', ['ivRightRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Iv Right Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ivRightRow = $this->IvRightRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ivRightRow = $this->IvRightRows->patchEntity($ivRightRow, $this->request->data);
            if ($this->IvRightRows->save($ivRightRow)) {
                $this->Flash->success(__('The iv right row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The iv right row could not be saved. Please, try again.'));
            }
        }
        $ivLeftRows = $this->IvRightRows->IvLeftRows->find('list', ['limit' => 200]);
        $items = $this->IvRightRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('ivRightRow', 'ivLeftRows', 'items'));
        $this->set('_serialize', ['ivRightRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Iv Right Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ivRightRow = $this->IvRightRows->get($id);
        if ($this->IvRightRows->delete($ivRightRow)) {
            $this->Flash->success(__('The iv right row has been deleted.'));
        } else {
            $this->Flash->error(__('The iv right row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
