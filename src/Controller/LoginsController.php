<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\I18n\Time;
class LoginsController extends AppController
{
	
	public function initialize()
	{
		parent::initialize();
		$this->eventManager()->off($this->Csrf);
	}
	public function index()
    {
       $this->viewBuilder()->layout('login_layout');
	   $number=2;
	   $login = $this->Logins->newEntity();
	   if ($this->request->is('post')) 
		{ 
			$username=$this->request->data["username"];
			$password=$this->request->data["password"];
			$query = $this->Logins->findAllByUsernameAndPassword($username, $password);
			$number = $query->count();
 			
			
			foreach ($query as $row) {
				  $login_id=$row["id"];
				 $employee_id=$row["employee_id"]; 
			}
			
			if($number==1 && !empty($login_id)){ 
			
				$this->request->session()->write('st_login_id',$login_id);
				
				$Employee=$this->Logins->Employees->get($employee_id);
				
				$emp_mobile = $Employee->mobile;

				if($employee_id == 23){
					return $this->redirect(['action' => 'Switch-Company']);
				}
				if(!empty($emp_mobile)){
					return $this->redirect(['controller'=>'Logins', 'action' => 'otpCodeConfirm',$employee_id,$login_id]);
				}else{
					return $this->redirect(['controller'=>'Logins', 'action' => 'errorOtp',$employee_id]);
				}
				
			}
		}
		
		$this->set(compact('login','number'));
		$this->set('_serialize', ['login']);
    }
	
	public function logout()
	{
		$session = $this->request->session();
		$st_login_id = $session->read('st_login_id');
		$login=$this->Logins->get($st_login_id);
		//pr($login->employee_id);exit;
		$query_1 = $this->Logins->Employees->query();
					$query_1->update()
						->set(['status' => 0])
						->where(['id' => $login->employee_id])
						->execute();
		$session = $this->request->session();
		$session->delete('st_login_id');
		return $this->redirect("/login");
	}
	
	public function add()
    {
		$this->viewBuilder()->layout('index_layout');
		$login = $this->Logins->newEntity();
		//pr ($login->employee_id); exit;
		
		
        if ($this->request->is('post')) {
            $login = $this->Logins->patchEntity($login, $this->request->data);
			$emp_id=$login->employee_id;
			$EmployeeIdExist = $this->Logins->exists(['employee_id' => $emp_id]);
		
			if(!$EmployeeIdExist)
				{
					if ($this->Logins->save($login)) {
						$this->Flash->success(__('Login has been saved.'));
					} else {
						$this->Flash->error(__('The Login could not be saved. Please, try again.'));
					}
				}
			else{
				$this->Flash->error(__('This user have already login.'));
				}
        }
		$employees = $this->Logins->Employees->find('list');
		$this->paginate = [
            'contain' => ['Employees']
        ];
		$Logins = $this->paginate($this->Logins);
        $this->set(compact('login','employees','Logins'));
        $this->set('_serialize', ['login']);
    }
	
	function SwitchCompany($company_id=null){
		
		$this->viewBuilder()->layout('login_layout');
		$session = $this->request->session();
		$st_login_id = $session->read('st_login_id');
		
		$login=$this->Logins->get($st_login_id);
		
		if(!empty($company_id)){ 
			$this->request->allowMethod(['post', 'delete']);
			$this->request->session()->write('st_company_id',$company_id);
			
			return $this->redirect(['controller'=>'FinancialYears','action' => 'selectCompanyYear']);
			
		}
		$Employee=$this->Logins->Employees->get($login->employee_id, [
						'contain' => ['Companies']
		]);
		$this->set(compact('st_login_id','Employee'));
	}
	
	function otpCodeConfirm($employee_id=null,$login_id=null)
	{
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$Employee=$this->Logins->Employees->get($employee_id);
		$status = $Employee->status;
		$Emp_name = $Employee->name;		
		$mobile_no = $Employee->mobile;	
		$randomString = rand(1000, 9999);
		if($status == '0'){
				
			$query = $this->Logins->Employees->query();
					$query->update()
						->set(['otp_no' => $randomString])
						->where(['id' => $employee_id])
						->execute();
						
		
		 $sms=str_replace(' ', '+', 'Dear '.$Emp_name.', Your one time password is '.$randomString.'.');
          $working_key='A7a76ea72525fc05bbe9963267b48dd96';
        $sms_sender='MOGRAG';
        $ch = curl_init('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile_no.'&message='.$sms.'');
		  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response2=curl_exec($ch);
		//$response2=1;
		
		if(!empty($response2)){
		
		}else if(empty($response2)){
			return $this->redirect(['controller'=>'Logins', 'action' => 'errorOtp',$employee_id]);
		}
		curl_close($ch);
		$query_1 = $this->Logins->Employees->query();
					$query_1->update()
						->set(['status' => 1])
						->where(['id' => $employee_id])
						->execute();
		}
		return $this->redirect(['controller'=>'Logins', 'action' => 'generateOtp',$employee_id,$login_id]);

	}
	
	
	function generateOtp($employee_id=null,$login_id=null){ 
	
		$this->viewBuilder()->layout('login_layout');
		$Employee=$this->Logins->Employees->get($employee_id, [
					'contain' => ['Companies']
				]);
						
			if ($this->request->is('put')) 
			{ 
				$otp_no=$this->request->data["otp_no"];
			
				
				if($Employee['otp_no'] == $otp_no){
					$time = Time::now();
					$user_logs = $this->Logins->UserLogs->newEntity();
					$user_logs->login_id = $login_id;
					$user_logs->datetime = $time;
					$this->Logins->UserLogs->save($user_logs);
					$count=0;
						
					foreach($Employee->companies as $company){
						$count++;
					}
					if($count==1){
					foreach($Employee->companies as $company){
						$this->request->session()->write('st_company_id',$company->id);
						break;
					}
					return $this->redirect(['controller'=>'Financial-Years','action' => 'selectCompanyYear']);
				}
				else
				{
					return $this->redirect(['action' => 'Switch-Company']);
				}
					
				}else{
					
					$this->Flash->error(__('Please Enter Correct OTP Code'));
				
				}
			}
		
			
		$this->set(compact('st_login_id','Employee'));
		$this->set('_serialize', ['Employee']);

	}
	
	function resendOtp($employee_id=null){
		$Employee=$this->Logins->Employees->get($employee_id);
		//$this->viewBuilder()->layout('login_layout');
		
		$Emp_name = $Employee->name;		
		$mobile_no = $Employee->mobile;	
		$randomString = rand(1000, 9999);
				$query = $this->Logins->Employees->query();
					$query->update()
						->set(['otp_no' => $randomString])
						->where(['id' => $employee_id])
						->execute();
						
		
		 $sms=str_replace(' ', '+', 'Dear '.$Emp_name.', Your one time password is '.$randomString.'.');
          $working_key='A7a76ea72525fc05bbe9963267b48dd96';
        $sms_sender='MOGRAG';
        $ch = curl_init('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile_no.'&message='.$sms.'');
		  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response2=curl_exec($ch);
		if(!empty($response2)){
		
		}else if(empty($response2)){
			return $this->redirect(['controller'=>'Logins', 'action' => 'errorOtp',$employee_id]);
		}
		curl_close($ch);
		$this->set(compact('st_login_id','Employee'));
		$this->set('_serialize', ['Employee']);
	}
	
	function errorOtp($employee_id=null){
		$this->viewBuilder()->layout('login_layout');
		
		$session = $this->request->session();
		$st_login_id = $session->read('st_login_id');
		$Employee=$this->Logins->Employees->get($employee_id);
		
		$this->set(compact('st_login_id','Employee'));
	}

	public function delete($id=null){
			$this->request->allowMethod(['post', 'delete']);
		$this->Logins->UserRights->deleteAll(['login_id' => $id]);
		$login = $this->Logins->get($id);
			if ($this->Logins->delete($login)) {
				$this->Flash->success(__('The User Login  has been deleted.'));
			} else {
				$this->Flash->error(__('The User Login could not be deleted. Please, try again.'));
			}
			return $this->redirect(['controller'=>'Logins','action' => 'Add']);
	}
	public function dashbord()
    {
       $this->viewBuilder()->layout('index_layout');
	   $leaves = $this->Logins->RequestLeaves->find()->contain(['Employees', 'LeaveTypes'])->where(['leave_status'=>'In-Process']);
	   //pr($Leaves->toArray()); exit;
	   $this->set(compact('leaves'));
		
    }
}

