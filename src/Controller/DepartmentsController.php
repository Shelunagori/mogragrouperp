<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Departments Controller
 *
 * @property \App\Model\Table\DipartmentsTable $Departments
 */
class DepartmentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		
		 $department = $this->Departments->newEntity();
        if ($this->request->is('post')) {
            $department = $this->Departments->patchEntity($department, $this->request->data);
            if ($this->Departments->save($department)) {
                $this->Flash->success(__('The dipartment has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The dipartment could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('department'));
        $this->set('_serialize', ['department']);
		
        $departments = $this->paginate($this->Departments->find()->order(['Departments.name' => 'ASC']));

        $this->set(compact('departments'));
        $this->set('_serialize', ['departments']);
    }

    /**
     * View method
     *
     * @param string|null $id Dipartment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dipartment = $this->Departments->get($id, [
            'contain' => ['Employees']
        ]);

        $this->set('dipartment', $dipartment);
        $this->set('_serialize', ['dipartment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dipartment = $this->Departments->newEntity();
        if ($this->request->is('post')) {
            $dipartment = $this->Departments->patchEntity($dipartment, $this->request->data);
            if ($this->Departments->save($dipartment)) {
                $this->Flash->success(__('The dipartment has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The dipartment could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('dipartment'));
        $this->set('_serialize', ['dipartment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Dipartment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $dipartment = $this->Departments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dipartment = $this->Departments->patchEntity($dipartment, $this->request->data);
            if ($this->Departments->save($dipartment)) {
                $this->Flash->success(__('The dipartment has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The dipartment could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('dipartment'));
        $this->set('_serialize', ['dipartment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Dipartment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$Employeesexists = $this->Departments->Employees->exists(['dipartment_id' => $id]);
		if(!$Employeesexists){
			$dipartment = $this->Departments->get($id);
			if ($this->Departments->delete($dipartment)) {
				$this->Flash->success(__('The dipartment has been deleted.'));
			} else {
				$this->Flash->error(__('The dipartment could not be deleted. Please, try again.'));
			}
		}else{
			$this->Flash->error(__('Once the employees has registered with department, the department cannot be deleted.'));
		}
        

        return $this->redirect(['action' => 'index']);
    }
}
