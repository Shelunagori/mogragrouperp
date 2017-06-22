<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * JobCardRows Controller
 *
 * @property \App\Model\Table\JobCardRowsTable $JobCardRows
 */
class JobCardRowsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['JobCards', 'SalesOrderRows', 'Items']
        ];
        $jobCardRows = $this->paginate($this->JobCardRows);

        $this->set(compact('jobCardRows'));
        $this->set('_serialize', ['jobCardRows']);
    }

    /**
     * View method
     *
     * @param string|null $id Job Card Row id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $jobCardRow = $this->JobCardRows->get($id, [
            'contain' => ['JobCards', 'SalesOrderRows', 'Items']
        ]);

        $this->set('jobCardRow', $jobCardRow);
        $this->set('_serialize', ['jobCardRow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $jobCardRow = $this->JobCardRows->newEntity();
        if ($this->request->is('post')) {
            $jobCardRow = $this->JobCardRows->patchEntity($jobCardRow, $this->request->data);
            if ($this->JobCardRows->save($jobCardRow)) {
                $this->Flash->success(__('The job card row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The job card row could not be saved. Please, try again.'));
            }
        }
        $jobCards = $this->JobCardRows->JobCards->find('list', ['limit' => 200]);
        $salesOrderRows = $this->JobCardRows->SalesOrderRows->find('list', ['limit' => 200]);
        $items = $this->JobCardRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('jobCardRow', 'jobCards', 'salesOrderRows', 'items'));
        $this->set('_serialize', ['jobCardRow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Job Card Row id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $jobCardRow = $this->JobCardRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $jobCardRow = $this->JobCardRows->patchEntity($jobCardRow, $this->request->data);
            if ($this->JobCardRows->save($jobCardRow)) {
                $this->Flash->success(__('The job card row has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The job card row could not be saved. Please, try again.'));
            }
        }
        $jobCards = $this->JobCardRows->JobCards->find('list', ['limit' => 200]);
        $salesOrderRows = $this->JobCardRows->SalesOrderRows->find('list', ['limit' => 200]);
        $items = $this->JobCardRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('jobCardRow', 'jobCards', 'salesOrderRows', 'items'));
        $this->set('_serialize', ['jobCardRow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Job Card Row id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jobCardRow = $this->JobCardRows->get($id);
        if ($this->JobCardRows->delete($jobCardRow)) {
            $this->Flash->success(__('The job card row has been deleted.'));
        } else {
            $this->Flash->error(__('The job card row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
