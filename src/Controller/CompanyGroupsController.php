<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CompanyGroups Controller
 *
 * @property \App\Model\Table\CompanyGroupsTable $CompanyGroups
 */
class CompanyGroupsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
        $companyGroups = $this->paginate($this->CompanyGroups);

        $this->set(compact('companyGroups'));
        $this->set('_serialize', ['companyGroups']);
    }

    /**
     * View method
     *
     * @param string|null $id Company Group id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $companyGroup = $this->CompanyGroups->get($id, [
            'contain' => ['Customers']
        ]);

        $this->set('companyGroup', $companyGroup);
        $this->set('_serialize', ['companyGroup']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $companyGroup = $this->CompanyGroups->newEntity();
        if ($this->request->is('post')) {
            $companyGroup = $this->CompanyGroups->patchEntity($companyGroup, $this->request->data);
            if ($this->CompanyGroups->save($companyGroup)) {
                $this->Flash->success(__('The company group has been saved.'));

                return $this->redirect('/company-groups');
            } else {
                $this->Flash->error(__('The company group could not be saved. Please, try again.'));
            }
        }
		$companyGroups = $this->paginate($this->CompanyGroups);
        $this->set(compact('companyGroup','companyGroups'));
        $this->set('_serialize', ['companyGroup']);
		 $this->set('_serialize', ['companyGroups']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Company Group id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $companyGroup = $this->CompanyGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $companyGroup = $this->CompanyGroups->patchEntity($companyGroup, $this->request->data);
            if ($this->CompanyGroups->save($companyGroup)) {
                $this->Flash->success(__('The company group has been saved.'));

                return $this->redirect('/company-groups');
            } else {
                $this->Flash->error(__('The company group could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('companyGroup'));
        $this->set('_serialize', ['companyGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Company Group id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$exists = $this->CompanyGroups->Companies->exists(['company_group_id' => $id]);
		if(!$exists){
			$companyGroup = $this->CompanyGroups->get($id);
			if ($this->CompanyGroups->delete($companyGroup)) {
				$this->Flash->success(__('The company group has been deleted.'));
			}else {
				$this->Flash->error(__('The company group could not be deleted. Please, try again.'));
			}
		}else {
            $this->Flash->error(__('Once the company group has registered companies under it, the group cannot be deleted.'));
        }
        
         
		return $this->redirect('/company-groups');
    }
}
