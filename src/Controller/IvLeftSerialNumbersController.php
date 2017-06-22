<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * IvLeftSerialNumbers Controller
 *
 * @property \App\Model\Table\IvLeftSerialNumbersTable $IvLeftSerialNumbers
 */
class IvLeftSerialNumbersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['IvLeftRows']
        ];
        $ivLeftSerialNumbers = $this->paginate($this->IvLeftSerialNumbers);

        $this->set(compact('ivLeftSerialNumbers'));
        $this->set('_serialize', ['ivLeftSerialNumbers']);
    }

    /**
     * View method
     *
     * @param string|null $id Iv Left Serial Number id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ivLeftSerialNumber = $this->IvLeftSerialNumbers->get($id, [
            'contain' => ['IvLeftRows']
        ]);

        $this->set('ivLeftSerialNumber', $ivLeftSerialNumber);
        $this->set('_serialize', ['ivLeftSerialNumber']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ivLeftSerialNumber = $this->IvLeftSerialNumbers->newEntity();
        if ($this->request->is('post')) {
            $ivLeftSerialNumber = $this->IvLeftSerialNumbers->patchEntity($ivLeftSerialNumber, $this->request->data);
            if ($this->IvLeftSerialNumbers->save($ivLeftSerialNumber)) {
                $this->Flash->success(__('The iv left serial number has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The iv left serial number could not be saved. Please, try again.'));
            }
        }
        $ivLeftRows = $this->IvLeftSerialNumbers->IvLeftRows->find('list', ['limit' => 200]);
        $this->set(compact('ivLeftSerialNumber', 'ivLeftRows'));
        $this->set('_serialize', ['ivLeftSerialNumber']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Iv Left Serial Number id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ivLeftSerialNumber = $this->IvLeftSerialNumbers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ivLeftSerialNumber = $this->IvLeftSerialNumbers->patchEntity($ivLeftSerialNumber, $this->request->data);
            if ($this->IvLeftSerialNumbers->save($ivLeftSerialNumber)) {
                $this->Flash->success(__('The iv left serial number has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The iv left serial number could not be saved. Please, try again.'));
            }
        }
        $ivLeftRows = $this->IvLeftSerialNumbers->IvLeftRows->find('list', ['limit' => 200]);
        $this->set(compact('ivLeftSerialNumber', 'ivLeftRows'));
        $this->set('_serialize', ['ivLeftSerialNumber']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Iv Left Serial Number id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ivLeftSerialNumber = $this->IvLeftSerialNumbers->get($id);
        if ($this->IvLeftSerialNumbers->delete($ivLeftSerialNumber)) {
            $this->Flash->success(__('The iv left serial number has been deleted.'));
        } else {
            $this->Flash->error(__('The iv left serial number could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
