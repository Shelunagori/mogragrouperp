<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UserRights Controller
 *
 * @property \App\Model\Table\UserRightsTable $UserRights
 */
class UserRightsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		
        $this->paginate = [
            'contain' => ['Logins', 'Pages']
        ];
        $userRights = $this->paginate($this->UserRights);

        $this->set(compact('userRights'));
        $this->set('_serialize', ['userRights']);
    }

    /**
     * View method
     *
     * @param string|null $id User Right id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userRight = $this->UserRights->get($id, [
            'contain' => ['Logins', 'Pages']
        ]);

        $this->set('userRight', $userRight);
        $this->set('_serialize', ['userRight']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($login_id=null)
    {
		$this->viewBuilder()->layout('index_layout');
		
		$login=$this->UserRights->Logins->find()->select(['employee_id'])->where(['id'=>$login_id])->first();
		$employee=$this->UserRights->Employees->find()->select(['name'])->where(['id'=>$login->employee_id])->first();
		$EmployeeName=$employee->name;
		
		//debug(json_encode($employee, JSON_PRETTY_PRINT));
		
		$userRight = $this->UserRights->newEntity();
        if ($this->request->is('post')) {
			$query = $this->UserRights->query();
			$query->delete()
				->where(['login_id' => $login_id])
				->execute();
	
			$user_rights=$this->request->data["user_rights"];
			foreach($user_rights as	$data){
				if(!empty($data["page_id"])){
					$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => $data["page_id"]
						])
						->execute();
					
				}
			} 
			
			if($user_rights[21]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 25
						])
						->execute();
			}
			if($user_rights[22]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 26
						])
						->execute();
			}
			if($user_rights[23]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 27
						])
						->execute();
			}
			if($user_rights[28]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 29
						])
						->execute();
			}
			if($user_rights[31]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 32
						])
						->execute();
			}
			if($user_rights[68]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 69
						])
						->execute();
			}
			if($user_rights[74]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 75
						])
						->execute();
			}
			if($user_rights[76]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 77
						])
						->execute();
			}
			if($user_rights[78]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 79
						])
						->execute();
			}
			if($user_rights[80]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 81
						])
						->execute();
			}
			if($user_rights[82]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 83
						])
						->execute();
			}
			if($user_rights[84]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 85
						])
						->execute();
			}
			if($user_rights[86]['page_id']>0){
				$query = $this->UserRights->query();
					$query->insert(['login_id', 'page_id'])
						->values([
							'login_id' => $login_id,
							'page_id' => 87
						])
						->execute();
			}
			
			$this->Flash->success(__('User Rights has been Updated.'));
			return $this->redirect(['action' => '/add/'.$login_id]);
        }
		$UserRights=$this->UserRights->find()->where(['login_id'=>$login_id]);
		$page_ids=array();
		foreach($UserRights as $qwe){
			$page_ids[]=$qwe->page_id;
		} 
        $this->set(compact('userRight','page_ids','EmployeeName'));
        $this->set('_serialize', ['userRight']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User Right id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		if(!empty($id)){
			$userRight = $this->UserRights->get($id, [
				'contain' => []
			]);
		}
		
		
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userRight = $this->UserRights->patchEntity($userRight, $this->request->data);
            if ($this->UserRights->save($userRight)) {
                $this->Flash->success(__('The user right has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user right could not be saved. Please, try again.'));
            }
        }
        $logins = $this->UserRights->Logins->find('list', ['limit' => 200]);
        $pages = $this->UserRights->Pages->find('list', ['limit' => 200]);
        $this->set(compact('userRight', 'logins', 'pages','id'));
        $this->set('_serialize', ['userRight']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User Right id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userRight = $this->UserRights->get($id);
        if ($this->UserRights->delete($userRight)) {
            $this->Flash->success(__('The user right has been deleted.'));
        } else {
            $this->Flash->error(__('The user right could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
