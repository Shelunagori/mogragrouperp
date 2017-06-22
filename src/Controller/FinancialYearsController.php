<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FinancialYears Controller
 *
 * @property \App\Model\Table\FinancialYearsTable $FinancialYears
 */
class FinancialYearsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
			$session = $this->request->session();
			$st_company_id = $session->read('st_company_id');
			$st_year_id = $session->read('st_year_id');
			$financialYear = $this->FinancialYears->newEntity();
			if ($this->request->is('post')) {
			//pr($this->request->data);
			//exit;
			$financialYear = $this->FinancialYears->patchEntity($financialYear, $this->request->data);
			$financialYear->company_id=$st_company_id;
			$financialYear->date_from=date("Y-m-d",strtotime($financialYear->date_from)); 
			$financialYear->date_to=date("Y-m-d",strtotime($financialYear->date_to));
			
			if ($this->FinancialYears->save($financialYear)) {
				$date1  = $financialYear->date_from;
				$date2  = $financialYear->date_to;
				$output = [];
				$time   = strtotime($date1);
				$last   = date('m-Y', strtotime($date2));

				do {
					$month = date('m-Y', $time);
					$total = date('t', $time);

					$output[] =  $month;

					$time = strtotime('+1 month', $time);
				} while ($month != $last);
			
				foreach ($output as $dt) {
				
				$financial_month = $this->FinancialYears->FinancialMonths->newEntity();
				$financial_month->financial_year_id=$financialYear->id;
				$financial_month->month=$dt;
				$financial_month->status='Open';
				$this->FinancialYears->FinancialMonths->save($financial_month);
				}
				$this->Flash->success(__('The financial year has been saved.'));
				return $this->redirect(['action' => 'index']);
            } else {
				$this->Flash->error(__('The financial year could not be saved. Please, try again.'));
            }
		}
			$this->set(compact('financialYear'));
			$this->set('_serialize', ['financialYear']);
			
			$financial_year = $this->FinancialYears->find()->where(['id'=>$st_year_id])->first();
			$start_date = $financial_year->date_from;
			$lastyear = strtotime("-1 year", strtotime($start_date));
			$firstDate = date("Y-m-d", $lastyear);
			
			$last_financial_year = $this->FinancialYears->find()->where(['date_from >=' => $firstDate,'date_to <' => $start_date,'company_id' => $st_company_id])->first();
			if($last_financial_year){
				$l_year_status=$last_financial_year->status;
			}
			else{
				$l_year_status=' ';
			}
			$this->paginate = [
				'contain' => ['Companies']
			];
			$financialYears = $this->paginate($this->FinancialYears->find()->where(['company_id'=>$st_company_id]));
			
			$this->set(compact('financialYears','l_year_status'));
			$this->set('_serialize', ['financialYears']);
    }

    /**
     * View method
     *
     * @param string|null $id Financial Year id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		 
			$financialYear = $this->FinancialYears->get($id, [
            'contain' => ['Companies']
			]);

        $this->set('financialYear', $financialYear);
        $this->set('_serialize', ['financialYear']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $financialYear = $this->FinancialYears->newEntity();
			$session = $this->request->session();
			$st_company_id = $session->read('st_company_id');
		
        if ($this->request->is('post')) {
		
			$financialYear = $this->FinancialYears->patchEntity($financialYear, $this->request->data);
			$financialYear->company_id=$st_company_id;
			
            if ($this->FinancialYears->save($financialYear)) {
                $this->Flash->success(__('The financial year has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The financial year could not be saved. Please, try again.'));
            }
        }
        $companies = $this->FinancialYears->Companies->find('list', ['limit' => 200]);
        $this->set(compact('financialYear', 'companies'));
        $this->set('_serialize', ['financialYear']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Financial Year id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $financialYear = $this->FinancialYears->get($id, [
            'contain' => []
        ]);
		$session = $this->request->session();
			$st_company_id = $session->read('st_company_id');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $financialYear = $this->FinancialYears->patchEntity($financialYear, $this->request->data);
			$financialYear->company_id=$st_company_id;
			$financialYear->date_from=date("Y-m-d",strtotime($financialYear->date_from)); 
			$financialYear->date_to=date("Y-m-d",strtotime($financialYear->date_to));
            if ($this->FinancialYears->save($financialYear)) {
                $this->Flash->success(__('The financial year has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The financial year could not be saved. Please, try again.'));
            }
        }
        $companies = $this->FinancialYears->Companies->find('list', ['limit' => 200]);
        $this->set(compact('financialYear', 'companies'));
        $this->set('_serialize', ['financialYear']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Financial Year id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $financialYear = $this->FinancialYears->get($id);
        if ($this->FinancialYears->delete($financialYear)) {
            $this->Flash->success(__('The financial year has been deleted.'));
        } else {
            $this->Flash->error(__('The financial year could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function selectCompanyYear($financialYear_id=null)
    {
			$this->viewBuilder()->layout('login_layout');
			$session = $this->request->session();
			$st_company_id = $session->read('st_company_id');
		
			if(!empty($financialYear_id)){ 
			$this->request->allowMethod(['post', 'delete']);
			$this->request->session()->write('st_year_id',$financialYear_id);
			return $this->redirect("/Dashboard");
			}
			$financialYears = $this->paginate($this->FinancialYears->find()->where(['company_id'=>$st_company_id,'status' =>'Open']));
			
			$count=0;
			foreach($financialYears as $data){
					$count++;
			}
				if($count==1){
					foreach($financialYears as $financialYear){
						$this->request->session()->write('st_year_id',$financialYear->id);
						break;
					}
					return $this->redirect('/Dashboard');
				}
			
			$this->set(compact('financialYears'));
			$this->set('_serialize', ['financialYears']);
    }
	
	public function closed($id = null)
    {
        $financialYear = $this->FinancialYears->get($id);
		$financialYear->status='Closed';
		 if ($this->FinancialYears->save($financialYear)) {
            $this->Flash->success(__('The Financial Year has been Closed.'));
        } else {
            $this->Flash->error(__('The Financial Year could not be Closed. Please, try again.'));
        }
		return $this->redirect(['action' => 'index']);
    }
	
	public function open($id = null)
    {
        $financialYear = $this->FinancialYears->get($id);
		$financialYear->status='Open';
		if ($this->FinancialYears->save($financialYear)) {
             $this->Flash->success(__('The Financial Year has been Closed.'));
        } else {
            $this->Flash->error(__('The Financial Year could not be Closed. Please, try again.'));
        }
		return $this->redirect(['action' => 'index']);
    }


    public function checkFinancialYear($financial_date)
    {
    	 $financial_date = date("Y-m-d",strtotime($financial_date));
    
    	 $FinancialYears = $this->FinancialYears->find()->toArray();
        foreach ($FinancialYears as $FinancialYear) {
 			$date_from = date("d-m-Y",strtotime($FinancialYear->date_from));
 			$date_to = date("d-m-Y",strtotime($FinancialYear->date_to));
 		    while (strtotime($date_from) <= strtotime($date_to)) {
              $date_from = date ("Y-m-d", strtotime("+1 day", strtotime($date_from)));
              if($date_from == $financial_date)
                 {  
                 	if($FinancialYear->status == "Open") 
                 	{
                 		$financialYear_id = $FinancialYear->id;
        				$FinancialYear_month = $this->FinancialYears->FinancialMonths->find()->where(['FinancialMonths.financial_year_id'=>$financialYear_id]);
        				foreach ($FinancialYear_month as $FinancialYear_months) {
        					$finl_date = date("m-Y",strtotime($financial_date));
        					
        					if($finl_date == $FinancialYear_months->month)
        					{
        						if($FinancialYear_months->status == "Open")
        						{
        							return ['Response'=> 'Open'];
        						}
        						else
        						{
        							return ['Response'=> 'Close'];
        						}
        					}
        					 
        				}

                 	}
                 	else
                 	{
                 		return ['Response'=> 'Close'];
                 	}	
                 }	
			}
		}
    }
	

}
