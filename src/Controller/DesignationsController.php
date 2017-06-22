<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Designations Controller
 *
 * @property \App\Model\Table\DesignationsTable $Designations
 */
class DesignationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		
		$designation = $this->Designations->newEntity();
        if ($this->request->is('post')) {
            $designation = $this->Designations->patchEntity($designation, $this->request->data);
            if ($this->Designations->save($designation)) {
                $this->Flash->success(__('The designation has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The designation could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('designation'));
        $this->set('_serialize', ['designation']);
		
        $designations = $this->paginate($this->Designations->find()->order(['Designations.name' => 'ASC']));

        $this->set(compact('designations'));
        $this->set('_serialize', ['designations']);
    }

    /**
     * View method
     *
     * @param string|null $id Designation id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $designation = $this->Designations->get($id, [
            'contain' => []
        ]);

        $this->set('designation', $designation);
        $this->set('_serialize', ['designation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $designation = $this->Designations->newEntity();
        if ($this->request->is('post')) {
            $designation = $this->Designations->patchEntity($designation, $this->request->data);
            if ($this->Designations->save($designation)) {
                $this->Flash->success(__('The designation has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The designation could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('designation'));
        $this->set('_serialize', ['designation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Designation id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $designation = $this->Designations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $designation = $this->Designations->patchEntity($designation, $this->request->data);
            if ($this->Designations->save($designation)) {
                $this->Flash->success(__('The designation has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The designation could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('designation'));
        $this->set('_serialize', ['designation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Designation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$Employeesexists = $this->Designations->Employees->exists(['designation_id' => $id]);
		if(!$Employeesexists){
			$designation = $this->Designations->get($id);
			if ($this->Designations->delete($designation)) {
				$this->Flash->success(__('The designation has been deleted.'));
			} else {
				$this->Flash->error(__('The designation could not be deleted. Please, try again.'));
			}
		}else{
			$this->Flash->error(__('Once the employees has registered with designation, the designations cannot be deleted.'));
		}
        

        return $this->redirect(['action' => 'index']);
    }
}
