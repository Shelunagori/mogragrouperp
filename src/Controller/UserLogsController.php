<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UserLogs Controller
 *
 * @property \App\Model\Table\UserLogsTable $UserLogs
 */
class UserLogsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');

        $this->paginate = [
            'contain' => ['Logins']
        ];
       $userLogs = $this->paginate($this->UserLogs->find()->contain(['Logins'=>['Employees']])->order(['datetime' => 'DESC']));
		//pr($userLogs);exit;
        $this->set(compact('userLogs'));
        $this->set('_serialize', ['userLogs']);
    }

    /**
     * View method
     *
     * @param string|null $id User Log id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userLog = $this->UserLogs->get($id, [
            'contain' => ['Logins']
        ]);

        $this->set('userLog', $userLog);
        $this->set('_serialize', ['userLog']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userLog = $this->UserLogs->newEntity();
        if ($this->request->is('post')) {
            $userLog = $this->UserLogs->patchEntity($userLog, $this->request->data);
            if ($this->UserLogs->save($userLog)) {
                $this->Flash->success(__('The user log has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user log could not be saved. Please, try again.'));
            }
        }
        $logins = $this->UserLogs->Logins->find('list', ['limit' => 200]);
        $this->set(compact('userLog', 'logins'));
        $this->set('_serialize', ['userLog']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User Log id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userLog = $this->UserLogs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userLog = $this->UserLogs->patchEntity($userLog, $this->request->data);
            if ($this->UserLogs->save($userLog)) {
                $this->Flash->success(__('The user log has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user log could not be saved. Please, try again.'));
            }
        }
        $logins = $this->UserLogs->Logins->find('list', ['limit' => 200]);
        $this->set(compact('userLog', 'logins'));
        $this->set('_serialize', ['userLog']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User Log id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userLog = $this->UserLogs->get($id);
        if ($this->UserLogs->delete($userLog)) {
            $this->Flash->success(__('The user log has been deleted.'));
        } else {
            $this->Flash->error(__('The user log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
