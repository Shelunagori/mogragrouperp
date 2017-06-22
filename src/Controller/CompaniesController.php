<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Companies Controller
 *
 * @property \App\Model\Table\CompaniesTable $Companies
 */
class CompaniesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		
		$company = $this->Companies->newEntity();
        if ($this->request->is('post')) {
            $company = $this->Companies->patchEntity($company, $this->request->data);
            if ($this->Companies->save($company)) {
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The company could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('company'));
        $this->set('_serialize', ['company']);
		
		$this->paginate = [
            'contain' => ['CompanyGroups']
        ];
		
	    $companies = $this->paginate($this->Companies->find()->order(['Companies.name' => 'ASC']));


        $this->set(compact('companies'));
        $this->set('_serialize', ['companies']);
    }

    /**
     * View method
     *
     * @param string|null $id Company id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {   
	    $this->viewBuilder()->layout('index_layout');
        $company = $this->Companies->get($id, [
            'contain' => ['CompanyGroups','CompanyBanks']
        ]);

        $this->set('company', $company);
        $this->set('_serialize', ['company']);
    }
	
  /**
      $employee = $this->Employees->get($id, [
            'contain' => ['Departments','Designations','EmployeeContactPersons']
        ]);
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $company = $this->Companies->newEntity();
        if ($this->request->is('post')) {
            $company = $this->Companies->patchEntity($company, $this->request->data);
			
			$file = $this->request->data['logo'];
			$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
			$arr_ext = array('png'); //set allowed extensions
			$setNewFileName = uniqid();
			
			$company->logo=$setNewFileName. '.' . $ext;
			if (in_array($ext, $arr_ext)) {
				move_uploaded_file($file['tmp_name'], WWW_ROOT . '/logos/' . $setNewFileName . '.' . $ext);
			}
				
            if ($this->Companies->save($company)) {
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The company could not be saved. Please, try again.'));
            }
        }
		
		$companyGroups = $this->Companies->CompanyGroups->find('list');
		
        $this->set(compact('company','companyGroups'));
        $this->set('_serialize', ['company']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Company id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		
        $company = $this->Companies->get($id, [
            'contain' => ['CompanyBanks']
        ]);
		
        if ($this->request->is(['patch', 'post', 'put'])) {
            $company = $this->Companies->patchEntity($company, $this->request->data,['validate' => 'Custom']);
			
			$file = $this->request->data['logo'];
			if(!empty($file['name'])){
				$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
				$arr_ext = array('png'); //set allowed extensions
				$setNewFileName = uniqid();
				
				$company->logo=$setNewFileName. '.' . $ext;
				@unlink(WWW_ROOT . '/logos/' . $company->getOriginal('logo'));
				if (in_array($ext, $arr_ext)) {
					move_uploaded_file($file['tmp_name'], WWW_ROOT . '/logos/' . $setNewFileName . '.' . $ext);
				}
			}else{
				$company->logo=$company->getOriginal('logo');
			}
			
			if ($this->Companies->save($company)) {
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The company could not be saved. Please, try again.'));
            }
        }
		$companyGroups = $this->Companies->CompanyGroups->find('list');
        $this->set(compact('company','companyGroups'));
        $this->set('_serialize', ['company']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Company id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$Quotationsexists = $this->Companies->Quotations->exists(['company_id' => $id]);
		$SalesOrdersexists = $this->Companies->SalesOrders->exists(['company_id' => $id]);
		$Invoicesexists = $this->Companies->Invoices->exists(['company_id' => $id]);
		if(!$Quotationsexists and !$SalesOrdersexists and !$Invoicesexists){
			$company = $this->Companies->get($id);
			if ($this->Companies->delete($company)) {
				$this->Flash->success(__('The company has been deleted.'));
			} else {
				$this->Flash->error(__('The company could not be deleted. Please, try again.'));
			}
		}elseif($Quotationsexists){
			$this->Flash->error(__('Once the company has generated quotations, the company cannot be deleted.'));
		}elseif($SalesOrdersexists){
			$this->Flash->error(__('Once the company has generated sales-order, the company cannot be deleted.'));
		}elseif($Invoicesexists){
			$this->Flash->error(__('Once the company has generated invoice, the company cannot be deleted.'));
		}
        

        return $this->redirect(['action' => 'index']);
    }
}
