<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MaterialIndentRows Controller
 *
 * @property \App\Model\Table\MaterialIndentRowsTable $MaterialIndentRows
 */
class MaterialIndentRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['MaterialIndents', 'Items']
        ];
        $materialIndentRows = $this->paginate($this->MaterialIndentRows);

        $this->set(compact('materialIndentRows'));
        $this->set('_serialize', ['materialIndentRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Material Indent Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $materialIndentRow = $this->MaterialIndentRows->get($id, [
            'contain' => ['MaterialIndents', 'Items']
        ]);

        $this->set('materialIndentRow', $materialIndentRow);
        $this->set('_serialize', ['materialIndentRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $materialIndentRow = $this->MaterialIndentRows->newEntity();
        if ($this->request->is('post')) {
            $materialIndentRow = $this->MaterialIndentRows->patchEntity($materialIndentRow, $this->request->data);
            if ($this->MaterialIndentRows->save($materialIndentRow)) {
                $this->Flash->success(__('The material indent row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The material indent row could not be saved. Please, try again.'));
            }
        }
        $materialIndents = $this->MaterialIndentRows->MaterialIndents->find('list', ['limit' => 200]);
        $items = $this->MaterialIndentRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('materialIndentRow', 'materialIndents', 'items'));
        $this->set('_serialize', ['materialIndentRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Material Indent Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $materialIndentRow = $this->MaterialIndentRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $materialIndentRow = $this->MaterialIndentRows->patchEntity($materialIndentRow, $this->request->data);
            if ($this->MaterialIndentRows->save($materialIndentRow)) {
                $this->Flash->success(__('The material indent row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The material indent row could not be saved. Please, try again.'));
            }
        }
        $materialIndents = $this->MaterialIndentRows->MaterialIndents->find('list', ['limit' => 200]);
        $items = $this->MaterialIndentRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('materialIndentRow', 'materialIndents', 'items'));
        $this->set('_serialize', ['materialIndentRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Material Indent Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $materialIndentRow = $this->MaterialIndentRows->get($id);
        if ($this->MaterialIndentRows->delete($materialIndentRow)) {
            $this->Flash->success(__('The material indent row has been deleted.'));
        } else {
            $this->Flash->error(__('The material indent row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
