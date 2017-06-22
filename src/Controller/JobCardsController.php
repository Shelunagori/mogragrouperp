<?php
namespace App\Controller;

use App\Controller\AppController;


class JobCardsController extends AppController
{
    
    public function index($status=null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		if($status==null or $status=='Pending'){
			$where['status']='Pending';
		}elseif($status=='Closed'){
			$where['status']='Closed';
		}
		$inventory_voucher_status=$this->request->query('inventory_voucher');
		
		$where1=[];
		$jc_no=$this->request->query('jc_no');
		$so_no=$this->request->query('so_no');
		$jc_file_no=$this->request->query('jc_file_no');
		$so_file_no=$this->request->query('so_file_no');
		$Required_From=$this->request->query('Required_From');
		$Required_To=$this->request->query('Required_To');
		$Created_From=$this->request->query('Created_From');
		$Created_To=$this->request->query('Created_To');
		
		$this->set(compact('jc_no','so_no','jc_file_no','so_file_no','Required_From','Required_To','Created_From','Created_To'));
		if(!empty($jc_no)){
			$where1['JobCards.jc2 LIKE']='%'.$jc_no.'%';
		}
		if(!empty($so_no)){
			$where1['SalesOrders.so2 LIKE']='%'.$so_no.'%';
		}
		
		if(!empty($jc_file_no)){
			$where1['JobCards.jc3 LIKE']='%'.$jc_file_no.'%';
		}
		
		if(!empty($so_file_no)){
			$where1['SalesOrders.so3 LIKE']='%'.$so_file_no.'%';
		}
		
		if(!empty($Required_From)){
			$Required_From=date("Y-m-d",strtotime($this->request->query('Required_From')));
			$where1['JobCards.required_date >=']=$Required_From;
		}
		if(!empty($Required_To)){
			$Required_To=date("Y-m-d",strtotime($this->request->query('Required_To')));
			$where1['JobCards.required_date <=']=$Required_To;
		}
		if(!empty($Created_From)){
			$Created_From=date("Y-m-d",strtotime($this->request->query('Created_From')));
			$where1['JobCards.created_on >=']=$Created_From;
		}
		if(!empty($Created_To)){
			$Created_To=date("Y-m-d",strtotime($this->request->query('Created_To')));
			$where1['JobCards.created_on <=']=$Created_To;
		}
		//pr($inventory_voucher_status); exit;
        $this->paginate = [
            'contain' => ['SalesOrders']
        ];
		if($inventory_voucher_status=='true'){
			$jobCards = $this->paginate($this->JobCards->find()->where($where1)->where(['status' => 'Pending','JobCards.company_id'=>$st_company_id]));
		}else{
			$jobCards = $this->paginate($this->JobCards->find()->where($where)->where($where1)->where(['JobCards.company_id'=>$st_company_id])->order(['JobCards.id' => 'DESC']));
		}
        $this->set(compact('jobCards','status'));
        $this->set('_serialize', ['jobCards']);
    }

    /**
     *   method
     *
     * @param string|null $id Job Card id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $jobCard = $this->JobCards->get($id, [
            'contain' => ['SalesOrders'=>['SalesOrderRows'=>['Items'=>function ($q){
					return $q->where(['SalesOrderRows.source_type != ' => 'Purchessed','Items.source !='=>'Purchessed']);
				},'JobCardRows'=>['Items']]],'Creator', 'Companies','Customers']
        ]);
        $this->set('jobCard', $jobCard);
        $this->set('_serialize', ['jobCard']);
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
		$sales_order_id=@(int)$this->request->query('sales-order');
		if(!empty($sales_order_id)){
			$salesOrder = $this->JobCards->SalesOrders->get($sales_order_id, [
				'contain' => ['Customers','SalesOrderRows'=>['Items'=>function ($q){
					return $q->where(['SalesOrderRows.source_type != ' => 'Purchessed','Items.source !='=>'Purchessed']);
				}]]
			]);
		}
		
		$last_jc_no=$this->JobCards->find()->select(['jc2'])->where(['company_id' => $st_company_id])->order(['jc2' => 'DESC'])->first();
			if($last_jc_no){
				@$last_jc_no->jc2=$last_jc_no->jc2+1;
			}else{
				@$last_jc_no->jc2=1;
			}
		$jobCard = $this->JobCards->newEntity();
        if ($this->request->is('post')) {
			$jobCard = $this->JobCards->patchEntity($jobCard, $this->request->data);
			
			$jobCard->required_date=date("Y-m-d",strtotime($jobCard->required_date)); 
			//pr($jobCard->required_date); exit;
			$jobCard->created_by=$s_employee_id; 
			$jobCard->sales_order_id=$sales_order_id;
			$jobCard->company_id=$st_company_id;
			$jobCard->customer_po_no=$jobCard->customer_po_no;
			$jobCard->created_on=date("Y-m-d");
			$jobCard->status='Pending';
			foreach($jobCard->job_card_rows as $job_card_row){
					$job_card_row->sales_order_id=$sales_order_id;
				}
			if ($this->JobCards->save($jobCard)) {
					$query = $this->JobCards->SalesOrders->query();
					$query->update()
						->set(['job_card_status' => 'Converted'])
						->where(['id' => $jobCard->sales_order_id])
						->execute();
                $this->Flash->success(__('The job card has been saved.'));

				return $this->redirect(['action' => 'view/'.$jobCard->id]);
            } else { 
                $this->Flash->error(__('The job card could not be saved. Please, try again.'));
            }
        }
		$items = $this->JobCards->Items->find('list')->where(['source IN'=>['Purchessed','Purchessed/Manufactured']])->order(['Items.name' => 'ASC'])->matching(
					'ItemCompanies', function ($q) use($st_company_id) {
						return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
					}
				);
        $companies = $this->JobCards->Companies->find('list', ['limit' => 200]);
        $this->set(compact('jobCard', 'salesOrder', 'companies','items','customers','last_jc_no'));
        $this->set('_serialize', ['jobCard']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Job Card id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$jobCard = $this->JobCards->get($id, [
            'contain' => ['SalesOrders'=>['SalesOrderRows'=>['Items'=>function ($q){
					return $q->where(['SalesOrderRows.source_type != ' => 'Purchessed','Items.source !='=>'Purchessed']);
				},'JobCardRows'=>['Items']]],'Creator', 'Companies','Customers']
        ]);
		$closed_month=$this->viewVars['closed_month'];
		
		if(!in_array(date("m-Y",strtotime($jobCard->created_on)),$closed_month))
		{
	
			$Em = new FinancialYearsController;
			$financial_year_data = $Em->checkFinancialYear($jobCard->created_on);
					
			if ($this->request->is(['patch', 'post', 'put'])) {
				$jobCard = $this->JobCards->patchEntity($jobCard, $this->request->data);
				$jobCard->required_date=date("Y-m-d",strtotime($jobCard->required_date)); 
				$jobCard->created_by=$s_employee_id; 
				$jobCard->company_id=$st_company_id;
				$jobCard->customer_po_no=$jobCard->customer_po_no;
				
				$jobCard->created_on=date("Y-m-d");
				$jobCard->sales_order_id=$jobCard->sales_order->id;
				foreach($jobCard->job_card_rows as $job_card_row){
						$job_card_row->sales_order_id=$jobCard->sales_order_id;
					}
				
				if ($this->JobCards->save($jobCard)) {
					$query = $this->JobCards->SalesOrders->query();
						$query->update()
							->set(['job_card_status' => 'Converted'])
							->where(['id' => $jobCard->sales_order_id])
							->execute();
					$this->Flash->success(__('The job card has been saved.'));
					return $this->redirect(['action' => 'view/'.$jobCard->id]);
				} else { 
					$this->Flash->error(__('The job card could not be saved. Please, try again.'));
				}
			}
			
			$items = $this->JobCards->Items->find('list')->where(['source IN'=>['Purchessed','Purchessed/Manufactured']])->order(['Items.name' => 'ASC'])->matching(
						'ItemCompanies', function ($q) use($st_company_id) {
							return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
						}
					);
			$this->set(compact('jobCard', 'salesOrders', 'companies','items','financial_year_data'));
			$this->set('_serialize', ['jobCard']);
		}
		else
		{
			$this->Flash->error(__('This month is locked.'));
			return $this->redirect(['action' => 'index']);
		}
    }

    /**
     * Delete method
     *
     * @param string|null $id Job Card id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jobCard = $this->JobCards->get($id);
        if ($this->JobCards->delete($jobCard)) {
            $this->Flash->success(__('The job card has been deleted.'));
        } else {
            $this->Flash->error(__('The job card could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
	
	public function PendingSalesorderForJobcard()
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$where=[];
		$sales_order_no=$this->request->query('sales_order_no');
		$file=$this->request->query('file');
		$customer=$this->request->query('customer');
		$po_no=$this->request->query('po_no');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		
		$this->set(compact('sales_order_no','customer','po_no','From','To','file'));
		
		if(!empty($sales_order_no)){
			$where['SalesOrders.so2 LIKE']=$sales_order_no;
		}
		if(!empty($file)){
			$where['SalesOrders.so3 LIKE']='%'.$file.'%';
		}
		if(!empty($customer)){
			$where['Customers.customer_name LIKE']='%'.$customer.'%';
		}
		if(!empty($po_no)){
			$where['JobCards.customer_po_no LIKE']='%'.$po_no.'%';
		}
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['JobCards.created_on >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['JobCards.created_on <=']=$To;
		}
		
		$this->paginate = [
            'contain' => ['Customers','JobCards','SalesOrderRows'=>['Items'=>function ($q){
				return $q->where(['Items.source'=>'Purchessed/Manufactured']);
			}]]
        ];
		
		$SalesOrders=$this->paginate(
			$this->JobCards->SalesOrders->find()->where($where)->select(['total_rows' => 
				$this->JobCards->SalesOrders->find()->func()->count('SalesOrderRows.id')])
					->matching(
						'SalesOrderRows.Items', function ($q) {
							return $q->where(['Items.source !='=>'Purchessed']);
						}
					)
					->group(['SalesOrders.id'])
					->autoFields(true)
					->having(['total_rows >' => 0])
					->where(['job_card_status'=>'Pending'])
					->where(['SalesOrders.company_id'=>$st_company_id])
					->order(['SalesOrders.id' => 'DESC'])
			);
			
		
	
		$this->set(compact('SalesOrders'));
        $this->set('_serialize', ['jobCard']);
    }
	public function PreAdd()
    {
		$this->viewBuilder()->layout('index_layout');
		$sales_order_id=$this->request->query('sales-order');
		$sales_order_id=$this->request->query('sales-order');
		$count_sales_item = 0;   
		$jobCard = $this->JobCards->SalesOrders->get($sales_order_id, [
            'contain' => ['Customers','SalesOrderRows'=>['Items'=>function ($q){
					return $q->where(['Items.source' => 'Purchessed/Manufactured']);
				}]]
        ]);
		
		if ($this->request->is(['patch', 'post', 'put'])) {
            $jobCard = $this->JobCards->patchEntity($jobCard, $this->request->data);
            if ($this->JobCards->save($jobCard)) {
				
				$query = $this->JobCards->SalesOrders->SalesOrderRows->find()->where(['sales_order_id'=>$sales_order_id]);
				$count_sales_item = $query->count();

				foreach($jobCard->sales_order_rows as $sales_order_row ){

						if($sales_order_row['source_type'] =='Purchessed')
						{
							$count_sales_item = $count_sales_item - 1; 
							$query = $this->JobCards->SalesOrders->SalesOrderRows->query();
								$query->update()
								->set(['source_type' =>$sales_order_row['source_type']])
								->where(['id' => $sales_order_row['id']])
								->execute();	

						}
						else
						{
							$query = $this->JobCards->SalesOrders->SalesOrderRows->query();
								$query->update()
								->set(['source_type' =>$sales_order_row['source_type']])
								->where(['id' => $sales_order_row['id']])
								->execute();	
						}

					
					}

					if($count_sales_item == 0)
					{
						$this->Flash->success(__('All items are purchessed job card  not created.'));
						$this->redirect(['controller' =>'JobCards','action' => 'index']);
					}
					else
					{
						$this->Flash->success(__('The job card has been saved.'));
						$this->redirect(['controller' =>'JobCards','action' => 'Add?Sales-Order='.$sales_order_id]);
					}
					
                
            } else { 
                $this->Flash->error(__('The job card could not be saved. Please, try again.'));
            }
        }
        
        $this->set(compact('jobCard'));
        $this->set('_serialize', ['jobCards']);
	
	}
	public function PreEdit()
    {
		$this->viewBuilder()->layout('index_layout');
		$sales_order_id=$this->request->query('sales-order');
		$id=$this->request->query('job-card');
		
		$jobCard = $this->JobCards->SalesOrders->get($sales_order_id, [
            'contain' => ['Customers','SalesOrderRows'=>['Items'=>function ($q){
					return $q->where(['Items.source'=>'Purchessed/Manufactured']);
				}]]
        ]);
		
		
		if ($this->request->is(['patch', 'post', 'put'])) {
            $jobCard = $this->JobCards->patchEntity($jobCard, $this->request->data);
            if ($this->JobCards->save($jobCard)) {
				
					foreach($jobCard->sales_order_rows as $sales_order_row ){
						if($sales_order_row['source_type']=="Purchessed"){
							$this->JobCards->JobCardRows->deleteAll(['sales_order_row_id' => $sales_order_row['id']]);
						}
						$query = $this->JobCards->SalesOrders->SalesOrderRows->query();
							$query->update()
							->set(['source_type' =>$sales_order_row['source_type']])
							->where(['id' => $sales_order_row['id']])
							->execute();
					} 
		
                $this->Flash->success(__('The job card has been saved.'));
                $this->redirect(['controller' =>'JobCards','action' => 'Edit/'.$id]);
            } else { 
                $this->Flash->error(__('The job card could not be saved. Please, try again.'));
            }
        }
        
        $this->set(compact('jobCard'));
        $this->set('_serialize', ['jobCards']);
	
	}
	
	public function close($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$JobCard = $this->JobCards->get($id);
		$JobCard->status="Closed";
		if ($this->JobCards->save($JobCard)) {
			$this->Flash->success(__('The job card has closed.'));
		} else {
			$this->Flash->error(__('The job card could not be closed. Please, try again.'));
		}
		
        
        return $this->redirect(['action' => 'index']);
    }
}
