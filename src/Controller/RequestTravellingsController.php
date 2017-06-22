<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RequestTravellings Controller
 *
 * @property \App\Model\Table\RequestTravellingsTable $RequestTravellings
 */
class RequestTravellingsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Employees', 'Companies']
        ];
        $requestTravellings = $this->paginate($this->RequestTravellings);

        $this->set(compact('requestTravellings'));
        $this->set('_serialize', ['requestTravellings']);
    }

    /**
     * View method
     *
     * @param string|null $id Request Travelling id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requestTravelling = $this->RequestTravellings->get($id, [
            'contain' => ['Employees', 'Companies']
        ]);

        $this->set('requestTravelling', $requestTravelling);
        $this->set('_serialize', ['requestTravelling']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$Employee = $this->RequestTravellings->Employees->get($s_employee_id);
        $requestTravelling = $this->RequestTravellings->newEntity();
        if ($this->request->is('post')) {
            $requestTravelling = $this->RequestTravellings->patchEntity($requestTravelling, $this->request->data);
            if ($this->RequestTravellings->save($requestTravelling)) {
                $this->Flash->success(__('The request travelling has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The request travelling could not be saved. Please, try again.'));
            }
        }
        $employees = $this->RequestTravellings->Employees->find('list', ['limit' => 200]);
        $companies = $this->RequestTravellings->Companies->find('list', ['limit' => 200]);
        $this->set(compact('requestTravelling', 'Employee', 'companies'));
        $this->set('_serialize', ['requestTravelling']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Request Travelling id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $requestTravelling = $this->RequestTravellings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestTravelling = $this->RequestTravellings->patchEntity($requestTravelling, $this->request->data);
            if ($this->RequestTravellings->save($requestTravelling)) {
                $this->Flash->success(__('The request travelling has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The request travelling could not be saved. Please, try again.'));
            }
        }
        $employees = $this->RequestTravellings->Employees->find('list', ['limit' => 200]);
        $companies = $this->RequestTravellings->Companies->find('list', ['limit' => 200]);
        $this->set(compact('requestTravelling', 'employees', 'companies'));
        $this->set('_serialize', ['requestTravelling']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Request Travelling id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $requestTravelling = $this->RequestTravellings->get($id);
        if ($this->RequestTravellings->delete($requestTravelling)) {
            $this->Flash->success(__('The request travelling has been deleted.'));
        } else {
            $this->Flash->error(__('The request travelling could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
