<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
		$this->loadComponent('Csrf');
		
		date_default_timezone_set('Asia/Kolkata');
		
		$session = $this->request->session();
		/*$db = @$session->read('db');
		$db='default';
		$conn = ConnectionManager::get($db);
		$conn->begin();*/
		$closed_month=[];
		
		$controller = $this->request->params['controller'];
		$action = $this->request->params['action']; 
		if (in_array($controller, ['Logins']) and in_array($action, ['index','generateOtp'])) {
		}else{
			$st_login_id = $session->read('st_login_id');
			$st_company_id = $session->read('st_company_id');
			$st_year_id =  $session->read('st_year_id');
			//$st_opt_confirm =  $session->read('st_opt_confirm');
			
			//pr($st_opt_confirm);exit;
			
			if(empty($st_login_id)){
				return $this->redirect('/logins'); exit;
				//return $this->redirect(['controller'=>'Homes','action'>'logins']); 
			}else{
				$this->loadModel('Logins');
				$login=$this->Logins->get($st_login_id);
				$this->set('s_employee_id',$login->employee_id);
				
				
				$this->loadModel('Employees');
				$sessionEmployee=$this->Employees->get($login->employee_id);
				
				if($st_company_id){
					$this->loadModel('Companies');
					$sessionCompany=$this->Companies->get($st_company_id);
					$this->set('s_company_name',$sessionCompany->name);
				}
				if($st_year_id){
					$this->loadModel('FinancialYears');
					$sessionYears=$this->FinancialYears->get($st_year_id);
					$this->set('s_year_from',date("Y",strtotime($sessionYears->date_from)));
					$this->set('s_year_to',date("Y",strtotime($sessionYears->date_to)));
				}
				
				
				$this->set('s_employee_name',$sessionEmployee->name);
				
				
			}
			////// Financial Year Or Month Closed /////////////
			$this->loadModel('FinancialYears');
			$this->loadModel('FinancialMonths');
			$FinancialClose = $this->FinancialYears->find()->where(['company_id'=>$st_company_id])->contain(['FinancialMonths' => function($q){
				return $q->where(['status' => 'Closed']);
			}
			])->toArray();
			foreach($FinancialClose as $financial_closes)
			{
				foreach($financial_closes->financial_months as $financial_months)
				{
					$closed_month[]=$financial_months->month;
				}
			}
			$this->set(compact('closed_month'));
			
			////////////////////////////////////////////
		}
		if(!empty($st_login_id)){
			$this->loadModel('UserRights');
			$UserRights=$this->UserRights->find()->where(['login_id'=>$st_login_id]);
			$allowed_pages=array();
			foreach($UserRights as $qwe){
				$allowed_pages[]=$qwe->page_id;
			}
			$this->set(compact('allowed_pages'));
		}

		$this->loadModel('Pages');
		$pages=$this->Pages->find()->where(['master'=>1]);
		$this->set(compact('pages'));

		$page=$this->Pages->find()->where(['controller'=>$controller,'action'=>$action])->first();

		if(!empty($page->id) and !in_array($page->id,$allowed_pages)){
			$pages=[];
			$this->set(compact('pages'));
			$this->viewBuilder()->layout('index_layout');
			$this -> render('/Error/not_allow'); 
		}
		
		


		
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
	   
}
