<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Challans Controller
 *
 * @property \App\Model\Table\ChallansTable $Challans
 */
class ChallansController extends AppController
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
		$where=[];
		$ch2=$this->request->query('ch2');
		$file=$this->request->query('file');
		$customer=$this->request->query('customer');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		$this->set(compact('ch2','customer','From','To','file'));
        $this->paginate = [
            'contain' => ['Customers', 'Companies', 'Invoices', 'Transporters','Vendors']
        ];
		if(!empty($ch2)){
			$where['ch2 LIKE']='%'.$ch2.'%';
		}
		if(!empty($file)){
			$where['Challans.ch3 LIKE']='%'.$file.'%';
		}
		if(!empty($customer)){
			$where['Customers.customer_name LIKE']='%'.$customer.'%';
		}
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['created_on >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['created_on <=']=$To;
		}
		$challans=$this->paginate($this->Challans->find()->where($where)->where(['challan_type' => 'Returnable','Challans.company_id'=>$st_company_id]));
        
        $this->set(compact('challans'));
        $this->set('_serialize', ['challans']);
    }
	 
	 public function index2()
    {	
		$this->viewBuilder()->layout('index_layout');
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$where=[];
		$ch2=$this->request->query('ch2');
		$file=$this->request->query('file');
		$customer=$this->request->query('customer');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		$this->set(compact('ch2','customer','From','To','file'));
        $this->paginate = [
            'contain' => ['Customers', 'Companies', 'Invoices', 'Transporters','Vendors']
        ];
		if(!empty($ch2)){
			$where['ch2 LIKE']='%'.$ch2.'%';
		}
		if(!empty($file)){
			$where['Challans.ch3 LIKE']='%'.$file.'%';
		}
		if(!empty($customer)){
			$where['Customers.customer_name LIKE']='%'.$customer.'%';
		}
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['created_on >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['created_on <=']=$To;
		}
        $this->paginate = [
            'contain' => ['Customers', 'Companies', 'Invoices', 'Transporters','Vendors']
        ];
		$challans=$this->paginate($this->Challans->find()->where($where)->where(['challan_type' => 'Non Returnable','challans.company_id'=>$st_company_id]));
        
        $this->set(compact('challans'));
        $this->set('_serialize', ['challans']);
    }
    /**
     * View method
     *
     * @param string|null $id Challan id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $challan = $this->Challans->get($id, [
            'contain' => ['Customers', 'Companies', 'Invoices', 'Transporters','Vendors']
        ]);

        $this->set('challan', $challan);
        $this->set('_serialize', ['challan']);
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
		$Company = $this->Challans->Companies->get($st_company_id);
		$challan = $this->Challans->newEntity();
		$st_year_id = $session->read('st_year_id');
		$SessionCheckDate = $this->FinancialYears->get($st_year_id);
		$fromdate1 = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
		$todate1 = date("Y-m-d",strtotime($SessionCheckDate->date_to)); 
		$tody1 = date("Y-m-d");

		$fromdate = strtotime($fromdate1);
		$todate = strtotime($todate1); 
		$tody = strtotime($tody1);

      if($fromdate >= $tody || $todate <= $tody)
       {
       	   $chkdate = 'Not Found';
       }
       else
       {
       	  $chkdate = 'Found';
       }
		if ($this->request->is('post')) {
			
            $challan = $this->Challans->patchEntity($challan, $this->request->data);
			$type=$challan->challan_type;
			
			$last_ch_no_rt=$this->Challans->find()->select(['ch2'])->where(['company_id' => $st_company_id,'challan_type' => $type])->order(['ch2' => 'DESC'])->first();
			
			if($last_ch_no_rt){
				
				$challan->ch2=$last_ch_no_rt->ch2+1;
				
				
			}else{
				$challan->ch2=1;
			}
		
			$challan->created_by=$s_employee_id; 
			$challan->company_id=$st_company_id;
			$challan->created_on=date("Y-m-d",strtotime($challan->created_on));
			$customer_id=$challan->customer_id;
			$vendor_id=$challan->vendor_id;
			
            if ($this->Challans->save($challan)) {
					
					foreach($challan->challan_rows as $challan_row){
					$itemLedger = $this->Challans->ItemLedgers->newEntity();
					$itemLedger->item_id = $challan_row->item_id;	
					$itemLedger->quantity = $challan_row->quantity;
					$itemLedger->source_model = 'Challan';
					$itemLedger->source_id = $challan_row->challan_id;
					$itemLedger->in_out = 'Out';
					$itemLedger->rate = $challan_row->rate;
					$itemLedger->company_id = $st_company_id;
					$itemLedger->processed_on = date("Y-m-d");
					$itemLedger->challan_type = $challan->challan_type;
					//pr($itemLedger); exit;
					$this->Challans->ItemLedgers->save($itemLedger);
					}
                $this->Flash->success(__('The challan has been saved.'));

                  return $this->redirect(['action' => 'confirm/'.$challan->id]);
            } else { 
				
                $this->Flash->error(__('The challan could not be saved. Please, try again.'));
            }
        }
		 $customers = $this->Challans->Customers->find('all')->order(['Customers.customer_name' => 'ASC'])->matching('CustomerCompanies', function ($q) use($st_company_id) {
						return $q->where(['CustomerCompanies.company_id' => $st_company_id]);
					}
				);
		$vendors = $this->Challans->Vendors->find('all')->order(['Vendors.company_name' => 'ASC'])->matching('VendorCompanies', function ($q) use($st_company_id) {
						return $q->where(['VendorCompanies.company_id' => $st_company_id]);
					}
				);
        $companies = $this->Challans->Companies->find('all');
		$items = $this->Challans->Items->find('list')->order(['Items.name' => 'ASC'])->matching(
				'ItemCompanies', function ($q) use($st_company_id) {
					return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
				}
			);

        $invoices = $this->Challans->Invoices->find()->where(['company_id'=>$st_company_id]);
		$invoice_bookings = $this->Challans->InvoiceBookings->find()->where(['company_id'=>$st_company_id]);
        $transporters = $this->Challans->Transporters->find('list');
		$filenames = $this->Challans->Filenames->find('list', ['valueField' => function ($row) {
				return $row['file1'] . '-' . $row['file2'];
			},
			'keyField' => function ($row) {
				return $row['file1'] . '-' . $row['file2'];
			}]);
        $this->set(compact('challan', 'customers', 'Company', 'invoices', 'transporters','items','vendors','filenames','invoice_bookings','chkdate'));
        $this->set('_serialize', ['challan']);
    }
    /**
     * Edit method
     *
     * @param string|null $id Challan id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		
        $challan = $this->Challans->get($id, [
            'contain' => ['Companies','Invoices' => ['InvoiceRows' => ['Items']],'InvoiceBookings' => ['InvoiceBookingRows' => ['Items']],'Transporters','ChallanRows','Creator','Vendors']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challan = $this->Challans->patchEntity($challan, $this->request->data);
			$challan->company_id=$st_company_id;
			$challan->created_by=$s_employee_id; 
			$challan->company_id=$st_company_id;
			$challan->created_on=date("Y-m-d",strtotime($challan->created_on));
			$customer_id=$challan->customer_id;
			$vendor_id=$challan->vendor_id;
			
			if(empty($customer_id))
			{
			$challan->customer_id =0;
			$challan->invoice_id =0;
			$challan->customer_address ='';
			}
			if(empty($vendor_id))
			{
			$challan->vendor_id =0;	
			$challan->invoice_booking_id =0;
			$challan->vendor_address ='';
			}
            if ($this->Challans->save($challan)) {
				
				$this->Challans->ItemLedgers->deleteAll(['source_id' => $id, 'source_model' => 'Challan']);
				foreach($challan->challan_rows as $challan_row){
					$itemLedger = $this->Challans->ItemLedgers->newEntity();
					$itemLedger->item_id = $challan_row->item_id;	
					$itemLedger->quantity = $challan_row->quantity;
					$itemLedger->source_model = 'Challan';
					$itemLedger->source_id = $challan_row->challan_id;
					$itemLedger->in_out = 'Out';
					$itemLedger->rate = $challan_row->rate;
					$itemLedger->company_id = $st_company_id;
					$itemLedger->processed_on = date("Y-m-d");
					$itemLedger->challan_type = $challan->challan_type;
					//pr($itemLedger); exit;
					$this->Challans->ItemLedgers->save($itemLedger);}
				
                $this->Flash->success(__('The challan has been saved.'));
				return $this->redirect(['action' => 'index']);
            } else {
				
                $this->Flash->error(__('The challan could not be saved. Please, try again.'));
            }
        }
		
      
		$customers = $this->Challans->Customers->find('all')->order(['Customers.customer_name' => 'ASC'])->matching('CustomerCompanies', function ($q) use($st_company_id) {
						return $q->where(['CustomerCompanies.company_id' => $st_company_id]);
					}
				);
		$vendors = $this->Challans->Vendors->find('all')->order(['Vendors.company_name' => 'ASC'])->matching('VendorCompanies', function ($q) use($st_company_id) {
						return $q->where(['VendorCompanies.company_id' => $st_company_id]);
					}
				);
        $companies = $this->Challans->Companies->find('all');
		$items = $this->Challans->Items->find('list')->order(['Items.name' => 'ASC'])->matching(
				'ItemCompanies', function ($q) use($st_company_id) {
					return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
				}
			);
		
		$item_ids=[]; 
		if(!empty($challan->invoice_id)){
			foreach($challan->invoice->invoice_rows as $invoice_row){
				$item_ids[]=$invoice_row->item->id;
			}
		}elseif(!empty($challan->invoice_booking_id)){
			foreach($challan->invoice_booking->invoice_booking_rows as $invoice_booking_row){
				$item_ids[]=$invoice_booking_row->item->id;
			}
		}
		

        $invoices = $this->Challans->Invoices->find()->where(['company_id'=>$st_company_id]);
		$invoice_bookings = $this->Challans->InvoiceBookings->find('all');
        $transporters = $this->Challans->Transporters->find('list');
		$filenames = $this->Challans->Filenames->find('list', ['valueField' => function ($row) {
				return $row['file1'] . '-' . $row['file2'];
			},
			'keyField' => function ($row) {
				return $row['file1'] . '-' . $row['file2'];
			}]);
        $this->set(compact('challan', 'customers', 'Company', 'invoices', 'transporters','items','vendors','filenames','invoice_bookings','id'));
	
        $this->set('_serialize', ['challan']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Challan id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challan = $this->Challans->get($id);
        if ($this->Challans->delete($challan)) {
            $this->Flash->success(__('The challan has been deleted.'));
        } else {
            $this->Flash->error(__('The challan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function pdf($id = null)
    {
		$this->viewBuilder()->layout('');
         $challan = $this->Challans->get($id, [
            'contain' => ['Companies','Customers','Invoices','Transporters','ChallanRows','Creator','Vendors','InvoiceBookings']
			]);

        $this->set('challan', $challan);
        $this->set('_serialize', ['challan']);
    }
	
	public function confirm($id = null)
    {
		$this->viewBuilder()->layout('pdf_layout');
		
        $this->set('id', $id);
    }
	public function PendingChallanForCreditNote()
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$challans = $this->paginate($this->Challans->find()->where(['pass_credit_note'=>'Yes','Challans.company_id'=>$st_company_id])->order(['Challans.id' => 'DESC']));
		$this->set('challans', $challans);
	
	}
	
	public function itemsAsInvoice($in_id=null,$source_model=null)
	{
		$this->viewBuilder()->layout('');
		if($source_model=="Invoices"){
			$Invoices=$this->Challans->Invoices->get($in_id, ['contain' => ['InvoiceRows' => ['Items']]]);
		}elseif($source_model=="Invoice_Booking"){
			$Invoices=$this->Challans->InvoiceBookings->get($in_id, ['contain' => ['InvoiceBookingRows' => ['Items']]]);
		}
		$this->set(compact('Invoices', 'source_model'));
		
	}
	public function customerInvoice($in_id=null,$source_model=null)
	{
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$this->viewBuilder()->layout('');
		$Invoices=$this->Challans->Invoices->find()->where(['customer_id'=>$in_id,'company_id'=>$st_company_id]);
	//pr($Invoices->toArray());
		$this->set(compact('Invoices', 'source_model','in_id'));
		
	}	
	public function vendorInvoicebooking($in_id=null,$source_model=null)
	{
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$this->viewBuilder()->layout('');
		$invoice_bookings=$this->Challans->InvoiceBookings->find()->where(['vendor_id'=>$in_id,'company_id'=>$st_company_id]);
		$this->set(compact('invoice_bookings', 'source_model'));
		
	}
	public function vendorInvoicebookingEdit($in_id=null,$source_model=null,$ib_id=null)
	{
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$this->viewBuilder()->layout('');
		$invoice_bookings=$this->Challans->InvoiceBookings->find()->where(['vendor_id'=>$in_id,'company_id'=>$st_company_id]);
		$this->set(compact('invoice_bookings', 'source_model','ib_id'));
		
	}
	
	
}
