<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RequestLeaves Controller
 *
 * @property \App\Model\Table\RequestLeavesTable $RequestLeaves
 */
class RequestLeavesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    { 
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
      
		$requestLeaves = $this->RequestLeaves->find()->contain(['Employees', 'LeaveTypes'])->where(['employee_id'=>$s_employee_id]);
        //$requestLeaves = $this->RequestLeaves->find();
		//pr($requestLeaves->toArray()); exit;
        $this->set(compact('requestLeaves'));
        $this->set('_serialize', ['requestLeaves']);
    }

    /**
     * View method
     *
     * @param string|null $id Request Leave id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requestLeave = $this->RequestLeaves->get($id, [
            'contain' => ['Employees', 'LeaveTypes', 'Companies']
        ]);

        $this->set('requestLeave', $requestLeave);
        $this->set('_serialize', ['requestLeave']);
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
		$Employee = $this->RequestLeaves->Employees->get($s_employee_id);
		
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->RequestLeaves->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$SessionCheckDate = $this->FinancialYears->get($st_year_id);
		$fromdate1 = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
		$todate1 = date("Y-m-d",strtotime($SessionCheckDate->date_to)); 
		$today = date("Y-m-d");
		
        $requestLeave = $this->RequestLeaves->newEntity();
        if ($this->request->is('post')) {
            $requestLeave = $this->RequestLeaves->patchEntity($requestLeave, $this->request->data);
			if($requestLeave->leave_from == $requestLeave->leave_to){
				$datediff=1;
			}else{
				$datediff = abs($requestLeave->leave_from - $requestLeave->leave_to);
			}
			$requestLeave->leave_from=date("Y-m-d",strtotime($requestLeave->leave_from));
			$requestLeave->leave_to=date("Y-m-d",strtotime($requestLeave->leave_to));
			$requestLeave->request_date=date("Y-m-d");
			$requestLeave->no_of_days=$datediff;
			$requestLeave->leave_status='In-Process';
            if ($this->RequestLeaves->save($requestLeave)) {
                $this->Flash->success(__('The request leave has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else { //pr($requestLeave); exit;
                $this->Flash->error(__('The request leave could not be saved. Please, try again.'));
            }
        }
        $employees = $this->RequestLeaves->Employees->find('list');
        $leaveTypes = $this->RequestLeaves->LeaveTypes->find('list');
        $companies = $this->RequestLeaves->Companies->find('list');
        $this->set(compact('requestLeave', 'employees', 'leaveTypes', 'companies','Employee','today','todate1','financial_year'));
        $this->set('_serialize', ['requestLeave']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Request Leave id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$Employee = $this->RequestLeaves->Employees->get($s_employee_id);
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->RequestLeaves->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$SessionCheckDate = $this->FinancialYears->get($st_year_id);
		$fromdate1 = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
		$todate1 = date("Y-m-d",strtotime($SessionCheckDate->date_to)); 
		$today = date("Y-m-d");
		
        $requestLeave = $this->RequestLeaves->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestLeave = $this->RequestLeaves->patchEntity($requestLeave, $this->request->data);
			if($requestLeave->leave_from == $requestLeave->leave_to){
				$datediff=1;
			}else{
				$datediff = abs($requestLeave->leave_from - $requestLeave->leave_to);
			}
			
			if($datediff==6){
				$datediff=7;
			}elseif($datediff==12){
				$datediff=14;
			}
			
			$requestLeave->leave_from=date("Y-m-d",strtotime($requestLeave->leave_from));
			$requestLeave->leave_to=date("Y-m-d",strtotime($requestLeave->leave_to));
			$requestLeave->request_date=date("Y-m-d");
			$requestLeave->no_of_days=$datediff;
			$requestLeave->leave_status='In-Process';
            if ($this->RequestLeaves->save($requestLeave)) {
                $this->Flash->success(__('The request leave has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The request leave could not be saved. Please, try again.'));
            }
        }
       // $employees = $this->RequestLeaves->Employees->find('list', ['limit' => 200]);
        $leaveTypes = $this->RequestLeaves->LeaveTypes->find('list', ['limit' => 200]);
        $companies = $this->RequestLeaves->Companies->find('list', ['limit' => 200]);
        $this->set(compact('requestLeave', 'Employee', 'leaveTypes', 'companies','today','financial_year'));
        $this->set('_serialize', ['requestLeave']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Request Leave id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $requestLeave = $this->RequestLeaves->get($id);
        if ($this->RequestLeaves->delete($requestLeave)) {
            $this->Flash->success(__('The request leave has been deleted.'));
        } else {
            $this->Flash->error(__('The request leave could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	public function approveLeaves($id=null){
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		//$RequestLeavesData = $this->RequestLeaves->get($id);
		$RequestLeavesData = $this->RequestLeaves->get($id, [
            'contain' => ['Employees', 'LeaveTypes']
        ]);
		
		$employeedata = $this->RequestLeaves->Employees->get($s_employee_id);
		if ($this->request->is(['patch', 'post', 'put'])) {
            $requestLeave = $this->RequestLeaves->patchEntity($RequestLeavesData, $this->request->data);
			//pr($requestLeave->no_of_days); exit;

				
            if ($this->RequestLeaves->save($requestLeave)) {
				
				$ApproveLeaves = $this->RequestLeaves->ApproveLeaves->newEntity();
				$ApproveLeaves->leave_from=date("Y-m-d",strtotime($requestLeave->leave_from));
				$ApproveLeaves->leave_to=date("Y-m-d",strtotime($requestLeave->leave_to));
				$ApproveLeaves->approve_date=date("Y-m-d");
				$ApproveLeaves->no_of_days=$requestLeave->no_of_days;
				$ApproveLeaves->employee_id=$requestLeave->employee_id;
				$ApproveLeaves->leave_type_id=$requestLeave->leave_type_id;
				$this->RequestLeaves->ApproveLeaves->save($ApproveLeaves);
				
				$query_1 = $this->RequestLeaves->query();
				$query_1->update()
						->set(['leave_status' => 'Approve'])
						->where(['id' => $id])
						->execute();
				
				
				
                $this->Flash->success(__('The request leave has been Approved'));

                return $this->redirect(['controller'=>'Logins','action' => 'dashbord']);
            } else { //pr($requestLeave); exit;
                $this->Flash->error(__('The request leave could not be saved. Please, try again.'));
            }
        }
		$this->set(compact('requestLeaves', 'RequestLeavesData','Employee', 'leaveTypes', 'companies','today','financial_year','employeedata'));
        $this->set('_serialize', ['requestLeave']);
		
	}
	public function cancleLeaves($id=null){
		$this->viewBuilder()->layout('');
		$query_1 = $this->RequestLeaves->query();
				$query_1->update()
						->set(['leave_status' => 'Cancle'])
						->where(['id' => $id])
						->execute();
		 return $this->redirect(['controller'=>'Logins','action' => 'dashbord']);
	}
	
	public function showDetails($id=null,$employee_id=null){
		$this->viewBuilder()->layout('ajax_layout');
		//$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->RequestLeaves->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$SessionCheckDate = $this->FinancialYears->get($st_year_id);
		$fromdate1 = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
		$todate1 = date("Y-m-d",strtotime($SessionCheckDate->date_to)); 
		$today = date("Y-m-d");

		$query = $this->RequestLeaves->ApproveLeaves->find();
		$CasualLeave = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['leave_type_id' => 1]),
				$query->newExpr()->add(['no_of_days']),
				'integer'
			);
		$SickLeave = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['leave_type_id' => 2]),
				$query->newExpr()->add(['no_of_days']),
				'integer'
			);

		$query->select([
			'CasualLeave' => $query->func()->sum($CasualLeave),
			'SickLeave' => $query->func()->sum($SickLeave)
		])
		->where(['employee_id'=>$employee_id])
		->where(['leave_from >='=>$financial_year->date_from,'leave_to <='=>$financial_year->date_to])
		->autoFields(true);
        $requestLeaves = $this->paginate($query);
		$this->set(compact('requestLeaves', 'RequestLeavesData','Employee', 'leaveTypes', 'companies','today','financial_year','employeedata'));
        $this->set('_serialize', ['requestLeave']);
		
	}
}
