<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EmployeeHierarchies Controller
 *
 * @property \App\Model\Table\EmployeeHierarchiesTable $EmployeeHierarchies
 */
class EmployeeHierarchiesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Employees']
        ];
        $employeeHierarchies = $this->paginate($this->EmployeeHierarchies);

        $this->set(compact('employeeHierarchies'));
        $this->set('_serialize', ['employeeHierarchies']);
    }

    /**
     * View method
     *
     * @param string|null $id Employee Hierarchy id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employeeHierarchy = $this->EmployeeHierarchies->get($id, [
            'contain' => ['Employees']
        ]);

        $this->set('employeeHierarchy', $employeeHierarchy);
        $this->set('_serialize', ['employeeHierarchy']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employeeHierarchy = $this->EmployeeHierarchies->newEntity();
        if ($this->request->is('post')) {
            $employeeHierarchy = $this->EmployeeHierarchies->patchEntity($employeeHierarchy, $this->request->data);
            if ($this->EmployeeHierarchies->save($employeeHierarchy)) {
                $this->Flash->success(__('The employee hierarchy has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The employee hierarchy could not be saved. Please, try again.'));
            }
        }
        $employees = $this->EmployeeHierarchies->Employees->find('list', ['limit' => 200]);
        $this->set(compact('employeeHierarchy', 'employees'));
        $this->set('_serialize', ['employeeHierarchy']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Hierarchy id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employeeHierarchy = $this->EmployeeHierarchies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeeHierarchy = $this->EmployeeHierarchies->patchEntity($employeeHierarchy, $this->request->data);
            if ($this->EmployeeHierarchies->save($employeeHierarchy)) {
                $this->Flash->success(__('The employee hierarchy has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The employee hierarchy could not be saved. Please, try again.'));
            }
        }
        $employees = $this->EmployeeHierarchies->Employees->find('list', ['limit' => 200]);
        $this->set(compact('employeeHierarchy', 'employees'));
        $this->set('_serialize', ['employeeHierarchy']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee Hierarchy id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeeHierarchy = $this->EmployeeHierarchies->get($id);
        if ($this->EmployeeHierarchies->delete($employeeHierarchy)) {
            $this->Flash->success(__('The employee hierarchy has been deleted.'));
        } else {
            $this->Flash->error(__('The employee hierarchy could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
