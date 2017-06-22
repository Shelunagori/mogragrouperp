<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SalesOrders Controller
 *
 * @property \App\Model\Table\SalesOrdersTable $SalesOrders
 */
class SalesOrdersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($status=null)
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$this->viewBuilder()->layout('index_layout');
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$copy_request=$this->request->query('copy-request');
		$job_card=$this->request->query('job-card');
		
		$where=[];
		//$company_alise=$this->request->query('company_alise');
		$sales_order_no=$this->request->query('sales_order_no');
		$file=$this->request->query('file');
		$customer=$this->request->query('customer');
		$po_no=$this->request->query('po_no');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		$items=$this->request->query('items');
		$pull_request=$this->request->query('pull-request');
		$this->set(compact('sales_order_no','customer','po_no','product','From','To','file','pull_request','items'));
		/* if(!empty($company_alise)){
			$where['SalesOrders.so1 LIKE']='%'.$company_alise.'%';
		} */
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
			$where['SalesOrders.customer_po_no LIKE']='%'.$po_no.'%';
		}
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['SalesOrders.created_on >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['SalesOrders.created_on <=']=$To;
		}
        $this->paginate = [
            'contain' => ['Customers','Employees','Categories', 'Companies']
        ];
		
        $this->paginate = [
            'contain' => ['Customers']
        ];
		
		
		
		if($status==null or $status=='Pending'){
			$having=['total_rows >' => 0];
		}elseif($status=='Converted Into Invoice'){
			$having=['total_rows =' => 0];
		}
		
		
		if(!empty($items)){
			
			$salesOrders=$this->paginate($this->SalesOrders->find()
			->contain(['Quotations','SalesOrderRows'=>['Items']])
			->matching(
					'SalesOrderRows.Items', function ($q) use($items) {
						return $q->where(['Items.name LIKE' =>'%'.$items.'%']);
					}
				)
				);
		}else{
		$salesOrders=$this->paginate(
			$this->SalesOrders->find()->contain(['Quotations','SalesOrderRows'=>['Items']])->select(['total_rows' => 
				$this->SalesOrders->find()->func()->count('SalesOrderRows.id')])
					->leftJoinWith('SalesOrderRows', function ($q) {
						return $q->where(['SalesOrderRows.processed_quantity < SalesOrderRows.quantity']);
					})
					->group(['SalesOrders.id'])
					->autoFields(true)
					->having($having)
					->where($where)
					->where(['SalesOrders.company_id'=>$st_company_id])
					->order(['SalesOrders.so2' => 'DESC'])
			);
			
		}//pr($salesOrders);exit;	
		if(!empty($job_card)){
			$salesOrders=$this->paginate(
				$this->SalesOrders->find()->contain(['SalesOrderRows'])
				->where(['job_card'=>'Pending'])->order(['SalesOrders.id' => 'DESC'])
			);
		}
		$SalesOrderRows = $this->SalesOrders->SalesOrderRows->find()->toArray();
        $this->set(compact('salesOrders','status','copy_request','job_card','SalesOrderRows'));
        $this->set('_serialize', ['salesOrders']);
		$this->set(compact('url'));
    }
	
	
	 public function exportExcel($status=null)
    {
		$this->viewBuilder()->layout('');
		$where=[];
		$company_alise=$this->request->query('company_alise');
		$sales_order_no=$this->request->query('sales_order_no');
		$file=$this->request->query('file');
		$customer=$this->request->query('customer');
		$po_no=$this->request->query('po_no');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		$pull_request=$this->request->query('pull-request');
		$this->set(compact('sales_order_no','customer','po_no','product','From','To','company_alise','file','pull_request'));
		if(!empty($company_alise)){
			$where['SalesOrders.so1 LIKE']='%'.$company_alise.'%';
		}
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
			$where['customer_po_no LIKE']='%'.$po_no.'%';
		}
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['date >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['date <=']=$To;
		}
        $this->paginate = [
            'contain' => ['Customers','Employees','Categories', 'Companies']
        ];
		
        $this->paginate = [
            'contain' => ['Customers']
        ];
		
		if($status==null or $status=='Pending'){
			$having=['total_rows >' => 0];
		}elseif($status=='Converted Into Invoice'){
			$having=['total_rows =' => 0];
		}
		$salesOrders=$this->paginate(
			$this->SalesOrders->find()->select(['total_rows' => 
				$this->SalesOrders->find()->func()->count('SalesOrderRows.id')])
				->leftJoinWith('SalesOrderRows', function ($q) {
					return $q->where();
				})
				->group(['SalesOrders.id'])
				->autoFields(true)
				->having($having)
				->where($where)
				->order(['SalesOrders.id' => 'DESC'])
			);
		
        $this->set(compact('salesOrders','status'));
        $this->set('_serialize', ['salesOrders']);
    }
	
	
	

    /**
     * View method
     *
     * @param string|null $id Sales Order id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $salesOrder = $this->SalesOrders->get($id, [
            'contain' => ['Customers', 'Companies','Carrier','Courier','SalesOrderRows' => ['Items']]
        ]);
        $this->set('salesOrder', $salesOrder);
        $this->set('_serialize', ['salesOrder']);
    }
	
	public function pdf($id = null)
    {
		$this->viewBuilder()->layout('');
        $salesOrder = $this->SalesOrders->get($id, [
            'contain' => ['Customers', 'Companies','Carrier','Creator','Editor','Courier','Employees','SalesOrderRows' => function($q){
				return $q->order(['SalesOrderRows.id' => 'ASC'])->contain(['SaleTaxes','Items'=>['Units']]);
			}]
        ]);

        $this->set('salesOrder', $salesOrder);
        $this->set('_serialize', ['salesOrder']);
    }
	
	public function confirm($id = null)
    {
		$this->viewBuilder()->layout('pdf_layout');
		$salesorder = $this->SalesOrders->get($id, [
            'contain' => ['SalesOrderRows']
			]);
		if ($this->request->is(['patch', 'post', 'put'])) {
            foreach($this->request->data['sales_order_rows'] as $sales_order_row_id=>$value){
				$salesOrderRow=$this->SalesOrders->SalesOrderRows->get($sales_order_row_id);
				$salesOrderRow->height=$value["height"];
				$this->SalesOrders->SalesOrderRows->save($salesOrderRow);
			}
			return $this->redirect(['action' => 'confirm/'.$id]);
        }
		
		$this->set(compact('salesorder','id'));
    }
	
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		
		$s_employee_id=$this->viewVars['s_employee_id'];
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$Company = $this->SalesOrders->Companies->get($st_company_id);
		
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->SalesOrders->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		
		
			   $SessionCheckDate = $this->FinancialYears->get($st_year_id);
			   $fromdate1 = DATE("Y-m-d",strtotime($SessionCheckDate->date_from));   
			   $todate1 = DATE("Y-m-d",strtotime($SessionCheckDate->date_to)); 
			   $tody1 = DATE("Y-m-d");

			   $fromdate = strtotime($fromdate1);
			   $todate = strtotime($todate1); 
			   $tody = strtotime($tody1);

			  if($fromdate < $tody || $todate > $tody)
			   {
				 if($SessionCheckDate['status'] == 'Open')
				 { $chkdate = 'Found'; }
				 else
				 { $chkdate = 'Not Found'; }

			   }
			   else
				{
					$chkdate = 'Not Found';	
				}

			
				

		$quotation_id=@(int)$this->request->query('quotation');
		$quotation=array(); 
		$process_status='New';
		if(!empty($quotation_id)){
			$quotation = $this->SalesOrders->Quotations->get($quotation_id, [
				'contain' => ['QuotationRows.Items' => function ($q) use($st_company_id) {
						   return $q
								->where(['QuotationRows.quantity > QuotationRows.proceed_qty']);
								
						}
					],'Customers'=>['CustomerAddress' => function($q){
					return $q->where(['default_address'=>1]);
				}]
			]);
			$process_status='Pulled From Quotation';
		}
		
		$this->set(compact('quotation','process_status'));
		
		$sales_id=$this->request->query('copy');
		$job_id=$this->request->query('job');
		//pr($process_status); exit;
		
		if(!empty($sales_id)){ 
			
			$salesOrder_data = $this->SalesOrders->newEntity();
			
			$salesOrder = $this->SalesOrders->get($sales_id, [
				'contain' => ['Customers'=>['CustomerContacts'=>function($q){
				return $q
			->where(['CustomerContacts.default_contact'=>1]);
			}],'Employees','SalesOrderRows'=>['Items']]
			]);
			$process_status='Copy';
			
		}
		elseif(!empty($job_id)){
			$salesOrder = $this->SalesOrders->get($job_id, [
				'contain' => ['SalesOrderRows']
			]);
		}
		else{
			  $salesOrder_data = $this->SalesOrders->newEntity();
			}
		
      
        if ($this->request->is(['patch', 'post', 'put'])) {
			
			//$salesOrder = $this->SalesOrders->newEntity();
			
            $salesOrder = $this->SalesOrders->patchEntity($salesOrder_data, $this->request->data);
			$last_so_no=$this->SalesOrders->find()->select(['so2'])->where(['company_id' => $st_company_id])->order(['so2' => 'DESC'])->first();
			$salesOrder->expected_delivery_date=date("Y-m-d",strtotime($salesOrder->expected_delivery_date)); 
			$salesOrder->po_date=date("Y-m-d",strtotime($salesOrder->po_date)); 
			$salesOrder->created_by=$s_employee_id; 
			if($last_so_no){
				$salesOrder->so2=$last_so_no->so2+1;
			}else{
				$salesOrder->so2=1;
			}
			
			
			$salesOrder->created_on=date("Y-m-d",strtotime($salesOrder->created_on));
			$salesOrder->edited_on=date("Y-m-d",strtotime($salesOrder->edited_on));
			$salesOrder->quotation_id=$quotation_id;
			$salesOrder->created_on_time= date("Y-m-d h:i:sA");
			$salesOrder->company_id=$st_company_id;
			
			
			//pr($salesOrder); exit;
			
			if ($this->SalesOrders->save($salesOrder)) {
				$status_close=$this->request->query('status');
				
			foreach($salesOrder->sales_order_rows as $sales_order_row){
				
					$quotation_rows = $this->SalesOrders->Quotations->QuotationRows->find()->where(['QuotationRows.item_id'=>$sales_order_row->item_id,'quotation_id'=>$salesOrder->quotation_id])->first();
					
						if($quotation_rows){
							//pr($quotation_rows); exit;
							$query1 = $this->SalesOrders->Quotations->QuotationRows->query();
							$query1->update()
							->set(['proceed_qty' =>$quotation_rows->proceed_qty+$sales_order_row->quantity])
							->where(['id' => $quotation_rows->id])
							->execute();
						}
						
				}  	
				
			
				if(!empty($status_close)){
				$query = $this->SalesOrders->Quotations->query();
					$query->update()
						->set(['status' => 'Closed'])
						->where(['id' => $quotation_id])
						->execute();
				} else{
						$falg=0;
					if($salesOrder->quotation_id > 0){ 
					$quotation_rows_datas = $this->SalesOrders->Quotations->QuotationRows->find()->where(['quotation_id'=>$salesOrder->quotation_id])->toArray();
						foreach($quotation_rows_datas as $quotation_rows_data){
							if($quotation_rows_data->quantity != $quotation_rows_data->proceed_qty){ 
							$falg=1;	
							}
						} 
					} 
					if($falg==1){
						$query_pending = $this->SalesOrders->Quotations->query();
						$query_pending->update()
						->set(['Quotations.status' => 'Pending'])
						->where(['id' => $salesOrder->quotation_id])
						->execute();
					}
				}
				
				$this->Flash->success(__('The sales order has been saved.'));
				return $this->redirect(['action' => 'confirm/'.$salesOrder->id]);

            } else {
                $this->Flash->error(__('The sales order could not be saved. Please, try again.'));
            }
        }
        $customers = $this->SalesOrders->Customers->find('all')->order(['Customers.customer_name' => 'ASC'])->contain(['CustomerAddress'=>function($q){
			return $q
			->where(['CustomerAddress.default_address'=>1]);
		}])->matching(
					'CustomerCompanies', function ($q) use($st_company_id) {
						return $q->where(['CustomerCompanies.company_id' => $st_company_id]);
					}
				);
		$copy=$this->request->query('copy');
		//pr ($copy); exit;
		if(!empty($copy)){
			$process_status='Copy';
		}
		//pr ($process_status); exit;
		if($quotation_id){
			$Filenames = $this->SalesOrders->Filenames->find()->where(['customer_id' => $quotation->customer_id]);
		}elseif($id){
			$Filenames = $this->SalesOrders->Filenames->find()->where(['customer_id' => $salesOrder->customer_id]);
		}else{
			$Filenames = $this->SalesOrders->Filenames->find();
		}
		
        $companies = $this->SalesOrders->Companies->find('all');
		$quotationlists = $this->SalesOrders->Quotations->find()->where(['status'=>'Pending'])->order(['Quotations.id' => 'DESC']);
		$items = $this->SalesOrders->Items->find('list')->matching(
					'ItemCompanies', function ($q) use($st_company_id) {
						return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
					} 
				)->order(['Items.name' => 'ASC']);
		$transporters = $this->SalesOrders->Carrier->find('list')->order(['Carrier.transporter_name' => 'ASC']);
		//$employees = $this->SalesOrders->Employees->find('list')->where(['dipartment_id' => 1])->order(['Employees.name' => 'ASC']);
		$employees = $this->SalesOrders->Employees->find('list')->where(['dipartment_id' => 1])->order(['Employees.name' => 'ASC'])->matching(
					'EmployeeCompanies', function ($q) use($st_company_id) {
						return $q->where(['EmployeeCompanies.company_id' => $st_company_id]);
					}
				);
		$termsConditions = $this->SalesOrders->TermsConditions->find('all');
		$SaleTaxes = $this->SalesOrders->SaleTaxes->find('all')->where(['SaleTaxes.freeze'=>0])->matching(
					'SaleTaxCompanies', function ($q) use($st_company_id) {
						return $q->where(['SaleTaxCompanies.company_id' => $st_company_id]);
					} 
				);
		
		//pr($salesOrder); exit; 
        $this->set(compact('salesOrder', 'customers', 'companies','quotationlists','items','transporters','Filenames','termsConditions','serviceTaxs','exciseDuty','employees','SaleTaxes','copy','process_status','Company','chkdate','financial_year','sales_id','salesOrder_copy','job_id','salesOrder_data'));
        $this->set('_serialize', ['salesOrder']);
    }
	
	public function pullFromQuotation(){
		if ($this->request->is('post')) {
			$quotation_id=$this->request->data["quotation_id"];
            return $this->redirect(['action' => 'add?quotation='.$quotation_id]);
        }
	}

    /**
     * Edit method
     *
     * @param string|null $id Sales Order id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $salesOrder = $this->SalesOrders->get($id, [
            'contain' => ['Quotations'=>['QuotationRows'],'SalesOrderRows' => ['Items','JobCardRows'],'Invoices' => ['InvoiceRows']]
        ]);
		//pr($salesOrder->quotation->quotation_rows);
		$qt_data=[];
		$qt_data1=[];
		
		if($salesOrder->quotation_id>0){
		$session = $this->request->session();
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->SalesOrders->FinancialYears->find()->where(['id'=>$st_year_id])->first();
			foreach($salesOrder->quotation->quotation_rows as $quotation_row){
				$qt_data[$quotation_row->item_id]=$quotation_row->quantity;
				$qt_data1[$quotation_row->item_id]=$quotation_row->proceed_qty;
			}
		}
		$closed_month=$this->viewVars['closed_month'];
		
		if(!in_array(date("m-Y",strtotime($salesOrder->created_on)),$closed_month))
		{

			$Em = new FinancialYearsController;
			$financial_year_data = $Em->checkFinancialYear($salesOrder->created_on);
			

			$s_employee_id=$this->viewVars['s_employee_id'];
			
			$session = $this->request->session();
			$st_company_id = $session->read('st_company_id');
			$st_year_id = $session->read('st_year_id');
			
			   $SessionCheckDate = $this->FinancialYears->get($st_year_id);
			   $fromdate1 = DATE("Y-m-d",strtotime($SessionCheckDate->date_from));   
			   $todate1 = DATE("Y-m-d",strtotime($SessionCheckDate->date_to)); 
			   $tody1 = DATE("Y-m-d");

			   $fromdate = strtotime($fromdate1);
			   $todate = strtotime($todate1); 
			   $tody = strtotime($tody1);

			  if($fromdate < $tody || $todate > $tody)
			   {
				 if($SessionCheckDate['status'] == 'Open')
				 { $chkdate = 'Found'; }
				 else
				 { $chkdate = 'Not Found'; }

			   }
			   else
				{
					$chkdate = 'Not Found';	
				}


			
			if ($this->request->is(['patch', 'post', 'put'])) {
				$salesOrder = $this->SalesOrders->patchEntity($salesOrder, $this->request->data);
				
				$salesOrder->expected_delivery_date=date("Y-m-d",strtotime($salesOrder->expected_delivery_date));
				$salesOrder->po_date=date("Y-m-d",strtotime($salesOrder->po_date)); 
				$salesOrder->date=date("Y-m-d",strtotime($salesOrder->date));
				$salesOrder->edited_by=$s_employee_id;
				$salesOrder->edited_on=date("Y-m-d");
				$salesOrder->edited_on_time= date("Y-m-d h:i:sA");
				
				//pr($salesOrder); exit;


				if ($this->SalesOrders->save($salesOrder)) {
					
					foreach($salesOrder->sales_order_rows as $sales_order_row){
						$job_card_row_ids=explode(',',$sales_order_row->job_card_row_ids);
						foreach($job_card_row_ids as $job_card_row_id){
							//pr($job_card_row_id); exit;
							$query = $this->SalesOrders->SalesOrderRows->JobCardRows->query();
							$query->update()
							->set(['sales_order_row_id' => $sales_order_row->id])
							->where(['id' => $job_card_row_id])
							->execute();
						}
					}
					foreach($salesOrder->sales_order_rows as $sales_order_row){
					$quotation_rows = $this->SalesOrders->Quotations->QuotationRows->find()->where(['QuotationRows.item_id'=>$sales_order_row->item_id,'quotation_id'=>$salesOrder->quotation_id])->first();
				
						if($quotation_rows){ 
							$query1 = $this->SalesOrders->Quotations->QuotationRows->query();
							$query1->update()
							->set(['proceed_qty' =>$quotation_rows->proceed_qty-$sales_order_row->old_quantity+$sales_order_row->quantity])
							->where(['id' => $quotation_rows->id])
							->execute();
						}
					}
						
					$falg=0;
					if($salesOrder->quotation_id > 0){
					$quotation_rows_datas = $this->SalesOrders->Quotations->QuotationRows->find()->where(['quotation_id'=>$salesOrder->quotation_id])->toArray();
						foreach($quotation_rows_datas as $quotation_rows_data){
							if($quotation_rows_data->quantity != $quotation_rows_data->proceed_qty){ 
							$falg=1;	
							}
						} 
					} 
					
					
					if($falg==1){
						$query_pending = $this->SalesOrders->Quotations->query();
						$query_pending->update()
						->set(['Quotations.status' => 'Pending'])
						->where(['id' => $salesOrder->quotation_id])
						->execute();
					}
					
					$salesOrder->job_card_status='Pending';
					$query2 = $this->SalesOrders->query();
					$query2->update()
						->set(['job_card_status' => 'Pending'])
						->where(['id' => $id])
						->execute();
					
					$this->Flash->success(__('The sales order has been saved.'));
					return $this->redirect(['action' => 'confirm/'.$salesOrder->id]);
				} else { 
					$this->Flash->error(__('The sales order could not be saved. Please, try again.'));
				}
			}
			$customers = $this->SalesOrders->Customers->find('all')->order(['Customers.customer_name' => 'ASC'])->contain(['CustomerAddress'=>function($q){
				return $q
				->where(['CustomerAddress.default_address'=>1]);
			}])->matching(
						'CustomerCompanies', function ($q) use($st_company_id) {
							return $q->where(['CustomerCompanies.company_id' => $st_company_id]);
						}
					);
			$companies = $this->SalesOrders->Companies->find('all', ['limit' => 200]);
			$quotationlists = $this->SalesOrders->Quotations->find()->where(['status'=>'Pending'])->order(['Quotations.id' => 'DESC']);
			$items = $this->SalesOrders->Items->find('list')->matching(
						'ItemCompanies', function ($q) use($st_company_id) {
							return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
						}
					)->order(['Items.name' => 'ASC']);
			$transporters = $this->SalesOrders->Carrier->find('list', ['limit' => 200])->order(['Carrier.transporter_name' => 'ASC']);
			$employees = $this->SalesOrders->Employees->find('list')->where(['dipartment_id' => 1])->order(['Employees.name' => 'ASC'])->matching(
						'EmployeeCompanies', function ($q) use($st_company_id) {
							return $q->where(['EmployeeCompanies.company_id' => $st_company_id]);
						}
					);
			$termsConditions = $this->SalesOrders->TermsConditions->find('all',['limit' => 200]);
			//$SaleTaxes = $this->SalesOrders->SaleTaxes->find('all')->where(['SaleTaxes.freeze'=>0]);
			$Filenames = $this->SalesOrders->Filenames->find()->where(['customer_id' => $salesOrder->customer_id]);
			$SaleTaxes = $this->SalesOrders->SaleTaxes->find('all')->where(['SaleTaxes.freeze'=>0])->matching(
						'SaleTaxCompanies', function ($q) use($st_company_id) {
							return $q->where(['SaleTaxCompanies.company_id' => $st_company_id]);
						} 
					);
			$this->set(compact('salesOrder', 'customers', 'companies','quotationlists','items','transporters','termsConditions','serviceTaxs','exciseDuty','employees','SaleTaxes','Filenames','financial_year_data','chkdate','qt_data','qt_data1','financial_year'));
			$this->set('_serialize', ['salesOrder']);
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
     * @param string|null $id Sales Order id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $salesOrder = $this->SalesOrders->get($id);
        if ($this->SalesOrders->delete($salesOrder)) {
            $this->Flash->success(__('The sales order has been deleted.'));
        } else {
            $this->Flash->error(__('The sales order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
