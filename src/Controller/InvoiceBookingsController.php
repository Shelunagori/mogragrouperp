<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InvoiceBookings Controller
 *
 * @property \App\Model\Table\InvoiceBookingsTable $InvoiceBookings
 */
class InvoiceBookingsController extends AppController
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
		$purchase_return=$this->request->query('purchase-return');
	    $where = [];
		$book_no = $this->request->query('book_no');
		$grn_no = $this->request->query('grn_no');
		$file = $this->request->query('file');
		$file_grn_no = $this->request->query('file_grn_no');
		$in_no = $this->request->query('in_no');
		$From = $this->request->query('From');
		$To = $this->request->query('To');
		$vendor_name = $this->request->query('vendor_name');
		
		$this->set(compact('book_no','grn_no','From','To','in_no','file_grn_no','file','vendor_name'));
		
		if(!empty($book_no)){
			$where['InvoiceBookings.ib2 LIKE']=$book_no;
		}
		
		if(!empty($file)){
			$where['InvoiceBookings.ib3 LIKE']='%'.$file.'%';
		}
		
		if(!empty($grn_no)){
			$where['Grns.grn2 LIKE']='%'.$grn_no.'%';
		}
		
		if(!empty($file_grn_no)){
			$where['Grns.grn3 LIKE']='%'.$file_grn_no.'%';
		}
		
		if(!empty($in_no)){
			$where['InvoiceBookings.invoice_no LIKE']='%'.$in_no.'%';
		}
		
		if(!empty($vendor_name)){
			$where['Vendors.company_name LIKE']='%'.$vendor_name.'%';
		}
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['InvoiceBookings.created_on >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['InvoiceBookings.created_on <=']=$To;
		}
		
        $this->paginate = [
            'contain' => ['Grns','Vendors']
        ];
		
		if($purchase_return=='true'){
			
			$invoiceBookings = $this->paginate($this->InvoiceBookings->find()->where($where)->where(['InvoiceBookings.company_id'=>$st_company_id])->order(['InvoiceBookings.id' => 'DESC']));
		}else{
			$invoiceBookings = $this->paginate($this->InvoiceBookings->find()->where($where)->where(['InvoiceBookings.company_id'=>$st_company_id])->order(['InvoiceBookings.id' => 'DESC']));
		}
		//pr($invoiceBookings);exit;
        $this->set(compact('invoiceBookings','status','purchase_return'));
        $this->set('_serialize', ['invoiceBookings']);
		$this->set(compact('url'));
    }

	public function PurchaseReturnIndex($status = null){
		$this->viewBuilder()->layout('index_layout');
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$purchase_return=$this->request->query('purchase-return');
		$status=$this->request->query('status');
		@$book_no = $this->request->query('book_no');
		$where=[];
		$status = 0 ;
		if(!empty($book_no)){
			$book_no=$this->request->query('book_no');
			if(!empty($book_no)){
				$where['InvoiceBookings.ib2 LIKE']=$book_no;
			}
			$invoiceBookings =$this->InvoiceBookings->find()->contain(['Grns','Vendors'])->where($where)->where(['InvoiceBookings.company_id'=>$st_company_id])->order(['InvoiceBookings.id' => 'DESC']);
			$status=1;
		}	
		//pr($invoiceBookings->toArray());exit;
		$this->set(compact('invoiceBookings','status','purchase_return','book_no'));
        $this->set('_serialize', ['invoiceBookings']);
		$this->set(compact('url'));
	}
	
    /**
     * View method
     *
     * @param string|null $id Invoice Booking id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$this->viewBuilder()->layout('index_layout');
        $invoiceBooking = $this->InvoiceBookings->get($id, [
            'contain' => ['InvoiceBookingRows'=>['Items'],'Vendors','Creator','Companies']
        ]);
		if($invoiceBooking->ledger_account_for_vat > 0){
			$LedgerAccount=$this->InvoiceBookings->LedgerAccounts->get($invoiceBooking->ledger_account_for_vat);
		}
		
		$purchase_acc='';
		if($st_company_id==25){  
			if($invoiceBooking->purchase_ledger_account==35){
				$purchase_acc="CST Purchase";
			}else{
				$purchase_acc="VAT Purchase";
			}
		}else if($st_company_id==26){
			if($invoiceBooking->purchase_ledger_account==161){
				$purchase_acc="CST Purchase";
			}else{
				$purchase_acc="VAT Purchase";
			}
		}else if($st_company_id==27){
			if($invoiceBooking->purchase_ledger_account==309){
				$purchase_acc="CST Purchase";
			}else{
				$purchase_acc="VAT Purchase";
			}
		}
		
		
		$c_LedgerAccount=$this->InvoiceBookings->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Vendors','source_id'=>$invoiceBooking->vendor_id])->first();
		
		$ReferenceDetails=$this->InvoiceBookings->ReferenceDetails->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'invoice_booking_id'=>$invoiceBooking->id]);
		
		
        $this->set('invoiceBooking', $invoiceBooking);
		$this->set(compact('LedgerAccount', 'ReferenceDetails','purchase_acc'));
        $this->set('_serialize', ['invoiceBooking']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$st_year_id = $session->read('st_year_id');
		

			   $SessionCheckDate = $this->FinancialYears->get($st_year_id);
			   $fromdate1 = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
			   $todate1 = date("Y-m-d",strtotime($SessionCheckDate->date_to)); 
			   $tody1 = date("Y-m-d");
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
			
			
			   
		$grn_id=@(int)$this->request->query('grn');
		$grn=array();
		if(!empty($grn_id)){
			$grn = $this->InvoiceBookings->Grns->get($grn_id, [
				'contain' => ['GrnRows'=>['Items'],'Companies','Vendors','PurchaseOrders'=>['PurchaseOrderRows']]
			]);
			if($grn->purchase_order->discount_type=='%'){
					$discount=($grn->purchase_order->total*$grn->purchase_order->discount)/100;
			}else{
				$discount=$grn->purchase_order->discount;
			}
			$excise_duty=$grn->purchase_order->excise_duty;
			$tot_sale_tax=(($grn->purchase_order->total-$discount)*$grn->purchase_order->sale_tax_per)/100;
			
			$vendor_id=$grn->vendor->id; 
			$v_LedgerAccount=$this->InvoiceBookings->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Vendors','source_id'=>$vendor_id])->first();
			
			$vendor_ledger_acc_id=$v_LedgerAccount->id;
		}
		$last_ib_no=$this->InvoiceBookings->find()->select(['ib2'])->where(['company_id' => $st_company_id])->order(['ib2' => 'DESC'])->first();
		if($last_ib_no){
			@$last_ib_no->ib2=$last_ib_no->ib2+1;
		}else{
			@$last_ib_no->ib2=1;
			}
		$q=0; $item_total_rate=0;
		foreach ($grn->grn_rows as $grn_rows){
			$dis=($discount*$grn->purchase_order->purchase_order_rows[$q]->amount)/$grn->purchase_order->total;
			$item_discount=$dis/$grn->purchase_order->purchase_order_rows[$q]->quantity;
			$item_total_rate+=$grn->purchase_order->purchase_order_rows[$q]->amount-$dis;
			$q++;
		} 
		$this->set(compact('grn','last_ib_no','discount','tot_sale_tax','chkdate','item_total_rate','excise_duty'));
		$invoiceBooking = $this->InvoiceBookings->newEntity();
		if ($this->request->is('post')) { 
		$ref_rows=$this->request->data['ref_rows'];
		
            $invoiceBooking = $this->InvoiceBookings->patchEntity($invoiceBooking, $this->request->data);
			$invoiceBooking->grn_id=$grn_id; 
			$invoiceBooking->created_on=date("Y-m-d");
			$invoiceBooking->company_id=$st_company_id;
			$invoiceBooking->supplier_date=date("Y-m-d",strtotime($invoiceBooking->supplier_date)); 
			$invoiceBooking->created_by=$this->viewVars['s_employee_id'];
			$invoiceBooking->due_payment=$invoiceBooking->total;

			$cst_purchase=0;
			if($st_company_id=='25'){
				$cst_purchase=35;
			}else if($st_company_id=='26'){
				$cst_purchase=161;
			}else if($st_company_id=='27'){
				$cst_purchase=309;
			}
			
			
            if ($this->InvoiceBookings->save($invoiceBooking)) {
				$i=0;
				foreach($invoiceBooking->invoice_booking_rows as $invoice_booking_row)
				{
				$item_id=$invoice_booking_row->item_id;
				$rate=$invoice_booking_row->rate;
				$query = $this->InvoiceBookings->ItemLedgers->query();
				$query->update()
					->set(['rate' => $rate, 'rate_updated' => 'Yes'])
					->where(['item_id' => $item_id, 'source_id' => $grn_id, 'company_id' => $st_company_id, 'source_model'=> 'Grns'])
					->execute();
				
				$results=$this->InvoiceBookings->ItemLedgers->find()->where(['ItemLedgers.item_id' => $item_id,'ItemLedgers.in_out' => 'In','rate_updated' => 'Yes','company_id' => $st_company_id])->toArray(); 
				
				$j=0; $qty_total=0; $rate_total=0; $per_unit_cost=0;
				foreach($results as $result){
					$qty=$result->quantity;
					$rate=$result->rate;
					@$total_amount=$qty*$rate;
					$rate_total=$rate_total+$total_amount;
					$qty_total=$qty_total+$qty;
				$j++;
				}
				
				$per_unit_cost=$rate_total/$qty_total;
				$query1 = $this->InvoiceBookings->Items->ItemCompanies->query();
				$query1->update()
					->set(['dynamic_cost' => $per_unit_cost])
					->where(['company_id' => $st_company_id,'item_id'=>$item_id])
					->execute();
				$i++;
				}
				if(!empty($grn_id)){
					//$grn = $this->InvoiceBookings->Grns->get($grn_id);
					$grn = $this->InvoiceBookings->Grns->get($grn_id, [
								'contain' => ['GrnRows'=>['Items'],'Companies','Vendors','PurchaseOrders'=>['PurchaseOrderRows']]
							]);
					$grn->status='Invoice-Booked';
					$this->InvoiceBookings->Grns->save($grn);
				}
				$accountReferences = $this->InvoiceBookings->AccountReferences->get(2);
				if($invoiceBooking->purchase_ledger_account==$cst_purchase){
					//ledger posting for PURCHASE ACCOUNT
					$ledger = $this->InvoiceBookings->Ledgers->newEntity();
					$ledger->ledger_account_id = $invoiceBooking->purchase_ledger_account;
					$ledger->debit = $invoiceBooking->total;
					$ledger->credit = 0;
					$ledger->voucher_id = $invoiceBooking->id;
					$ledger->company_id = $invoiceBooking->company_id;
					$ledger->voucher_source = 'Invoice Booking';
					$ledger->transaction_date = $invoiceBooking->supplier_date;
					$this->InvoiceBookings->Ledgers->save($ledger);
				}else{
					//ledger posting for PURCHASE ACCOUNT
					$ledger = $this->InvoiceBookings->Ledgers->newEntity();
					$ledger->ledger_account_id = $invoiceBooking->purchase_ledger_account;
					$ledger->debit = $invoiceBooking->total-$invoiceBooking->total_saletax;
					$ledger->credit = 0;
					$ledger->voucher_id = $invoiceBooking->id;
					$ledger->company_id = $invoiceBooking->company_id;
					$ledger->voucher_source = 'Invoice Booking';
					$ledger->transaction_date = $invoiceBooking->supplier_date;
					$this->InvoiceBookings->Ledgers->save($ledger);
					
					//ledger posting for PURCHASE ACCOUNT
					$ledger = $this->InvoiceBookings->Ledgers->newEntity();
					$ledger->ledger_account_id = $invoiceBooking->ledger_account_for_vat;
					$ledger->debit = $invoiceBooking->total_saletax;
					$ledger->credit = 0;
					$ledger->voucher_id = $invoiceBooking->id;
					$ledger->company_id = $invoiceBooking->company_id;
					$ledger->voucher_source = 'Invoice Booking';
					$ledger->transaction_date = $invoiceBooking->supplier_date;
					$this->InvoiceBookings->Ledgers->save($ledger);
				}
				
				
				//Ledger posting for SUPPLIER
				$c_LedgerAccount=$this->InvoiceBookings->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Vendors','source_id'=>$grn->vendor_id])->first();
				$ledger = $this->InvoiceBookings->Ledgers->newEntity();
				$ledger->ledger_account_id = $c_LedgerAccount->id;
				$ledger->debit = 0;
				$ledger->credit =$invoiceBooking->total;
				$ledger->voucher_id = $invoiceBooking->id;
				$ledger->company_id = $invoiceBooking->company_id;
				$ledger->transaction_date = $invoiceBooking->supplier_date;
				$ledger->voucher_source = 'Invoice Booking';
				$this->InvoiceBookings->Ledgers->save($ledger);
				
				//Reference Number coding
					if(sizeof(@$ref_rows)>0){
						
						foreach($ref_rows as $ref_row){ 
							$ref_row=(object)$ref_row;
							if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
								$query = $this->InvoiceBookings->ReferenceBalances->query();
								
								$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
								->values([
									'ledger_account_id' => $v_LedgerAccount->id,
									'reference_no' => $ref_row->ref_no,
									'credit' => $ref_row->ref_amount,
									'debit' => 0
								]);
								$query->execute();
							}else{
								$ReferenceBalance=$this->InvoiceBookings->ReferenceBalances->find()->where(['ledger_account_id'=>$v_LedgerAccount->id,'reference_no'=>$ref_row->ref_no])->first();
								$ReferenceBalance=$this->InvoiceBookings->ReferenceBalances->get($ReferenceBalance->id);
								$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
								
								$this->InvoiceBookings->ReferenceBalances->save($ReferenceBalance);
							}
							
							$query = $this->InvoiceBookings->ReferenceDetails->query();
							$query->insert(['ledger_account_id', 'invoice_booking_id', 'reference_no', 'credit', 'debit', 'reference_type'])
							->values([
								'ledger_account_id' => $v_LedgerAccount->id,
								'invoice_booking_id' => $invoiceBooking->id,
								'reference_no' => $ref_row->ref_no,
								'credit' =>  $ref_row->ref_amount,
								'debit' =>0,
								'reference_type' => $ref_row->ref_type
							]);
						
							$query->execute();
						}
					}

				
				
                $this->Flash->success(__('The invoice booking has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else { pr($invoiceBooking); exit;
                $this->Flash->error(__('The invoice booking could not be saved. Please, try again.'));
            }
        }
		
		
		$AccountReference= $this->InvoiceBookings->AccountReferences->get(2);
		$ledger_account_details = $this->InvoiceBookings->LedgerAccounts->find('list')->contain(['AccountSecondSubgroups'=>['AccountFirstSubgroups' => function($q) use($AccountReference){
			return $q->where(['AccountFirstSubgroups.id'=>$AccountReference->account_first_subgroup_id]);
		}]])->order(['LedgerAccounts.name' => 'ASC'])->where(['LedgerAccounts.company_id'=>$st_company_id]);
		
		$AccountReference= $this->InvoiceBookings->AccountReferences->get(4);
		$ledger_account_vat = $this->InvoiceBookings->LedgerAccounts->find('list'
				,['keyField' => 		function ($row) {
					return $row['id'];
				},
				'valueField' => function ($row) {
					if(!empty($row['alias'])){
						return  $row['name'] . ' (' . $row['alias'] . ')';
					}else{
						return $row['name'];
					}
					
				}])->contain(['AccountSecondSubgroups'=>['AccountFirstSubgroups' => function($q) use($AccountReference){
			return $q->where(['AccountFirstSubgroups.id'=>$AccountReference->account_first_subgroup_id]);
		}]])->order(['LedgerAccounts.name' => 'ASC'])->where(['LedgerAccounts.company_id'=>$st_company_id]);
		
		$cst_purchase=0;
			if($st_company_id=='25'){
				$cst_purchase=35;
			}else if($st_company_id=='26'){
				$cst_purchase=161;
			}else if($st_company_id=='27'){
				$cst_purchase=309;
		
			}	
		$companies = $this->InvoiceBookings->Companies->find('all');
        $grns = $this->InvoiceBookings->Grns->find('list');
        $this->set(compact('invoiceBooking', 'grns','companies','ledger_account_details','v_LedgerAccount', 'ledger_account_vat','fromdate1','tody1'));
        $this->set('_serialize', ['invoiceBooking']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoice Booking id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
	$this->viewBuilder()->layout('index_layout');
	$session = $this->request->session();
	$invoice_booking_id=$id;
	$st_company_id = $session->read('st_company_id');

	$st_year_id = $session->read('st_year_id');

	   $SessionCheckDate = $this->FinancialYears->get($st_year_id);
	   $fromdate1 = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
	   $todate1 = date("Y-m-d",strtotime($SessionCheckDate->date_to)); 
	   $tody1 = date("Y-m-d");

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


		$invoiceBooking = $this->InvoiceBookings->get($id, [
            'contain' => ['InvoiceBookingRows' => ['Items'],'Grns'=>['Companies','Vendors','GrnRows'=>['Items'],'PurchaseOrders'=>['PurchaseOrderRows']]]
        ]);
		
		$vendor_id=$invoiceBooking->grn->vendor->id; 
		$v_LedgerAccount=$this->InvoiceBookings->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Vendors','source_id'=>$vendor_id])->first();
		$vendor_ledger_acc_id=$v_LedgerAccount->id;
		
		$ReferenceDetails = $this->InvoiceBookings->ReferenceDetails->find()->where(['ledger_account_id'=>$vendor_ledger_acc_id,'invoice_booking_id'=>$id])->toArray();
		
		if(!empty($ReferenceDetails))
		{
			foreach($ReferenceDetails as $ReferenceDetail)
			{  //pr($ReferenceDetail->ledger_account_id); exit;
				$ReferenceBalances[] = $this->InvoiceBookings->ReferenceBalances->find()->where(['ledger_account_id'=>$ReferenceDetail->ledger_account_id,'reference_no'=>$ReferenceDetail->reference_no])->toArray();
			}
		}
		else{
			$ReferenceBalances='';
		}
		
		
		$Em = new FinancialYearsController;
	    $financial_year_data = $Em->checkFinancialYear($invoiceBooking->created_on);

		
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoiceBooking = $this->InvoiceBookings->patchEntity($invoiceBooking, $this->request->data);
			$invoiceBooking->supplier_date=date("Y-m-d",strtotime($invoiceBooking->supplier_date)); 
			$cst_purchase=0;
					if($st_company_id=='25'){
						$cst_purchase=35;
					}else if($st_company_id=='26'){
						$cst_purchase=161;
					}else if($st_company_id=='27'){
						$cst_purchase=309;
					}
				
            if ($this->InvoiceBookings->save($invoiceBooking)) { 
				$ref_rows=@$this->request->data['ref_rows'];
				$invoiceBookingId=$invoiceBooking->id;
				$grn_id=$invoiceBooking->grn_id;
				
				if(!empty($grn_id)){
					$grn = $this->InvoiceBookings->Grns->get($grn_id, [
					'contain' => ['GrnRows'=>['Items'],'Companies','Vendors','PurchaseOrders'=>['PurchaseOrderRows']]
					]);
				}
				$this->InvoiceBookings->Ledgers->deleteAll(['voucher_id' =>$invoiceBookingId, 'voucher_source' => 'Invoice Booking']);
				$i=0; 
				
				foreach($invoiceBooking->invoice_booking_rows as $invoice_booking_row)
				{
				$item_id=$invoice_booking_row->item_id;
				$rate=$invoice_booking_row->rate;
				$query = $this->InvoiceBookings->ItemLedgers->query();
				$query->update()
					->set(['rate' => $rate, 'rate_updated' => 'Yes'])
					->where(['item_id' => $item_id, 'source_id' => $grn_id, 'company_id' => $st_company_id, 'source_model'=> 'Grns'])
					->execute();
				$results=$this->InvoiceBookings->ItemLedgers->find()->where(['ItemLedgers.item_id' => $item_id,'ItemLedgers.in_out' => 'In','rate_updated' => 'Yes','company_id' => $st_company_id]); 
				$j=0; $qty_total=0; $rate_total=0; $per_unit_cost=0;
				foreach($results as $result){
					$qty=$result->quantity;
					$rate=$result->rate;
					@$total_amount=$qty*$rate;
					$rate_total=$rate_total+$total_amount;
					$qty_total=$qty_total+$qty;
				$j++;
				}
				
				$per_unit_cost=$rate_total/$qty_total;
				$query1 = $this->InvoiceBookings->Items->ItemCompanies->query();
				$query1->update()
					->set(['dynamic_cost' => $per_unit_cost])
					->where(['item_id' => $item_id,'company_id'=>$st_company_id])
					->execute();
				$i++;
				}
				$accountReferences = $this->InvoiceBookings->AccountReferences->get(2);
				
				if($invoiceBooking->purchase_ledger_account==$cst_purchase){ 
					//ledger posting for PURCHASE ACCOUNT
					$ledger = $this->InvoiceBookings->Ledgers->newEntity();
					$ledger->ledger_account_id = $invoiceBooking->purchase_ledger_account;
					$ledger->debit = $invoiceBooking->total;
					$ledger->credit = 0;
					$ledger->voucher_id = $invoiceBooking->id;
					$ledger->company_id = $invoiceBooking->company_id;
					$ledger->voucher_source = 'Invoice Booking';
					$ledger->transaction_date = $invoiceBooking->supplier_date;
					$this->InvoiceBookings->Ledgers->save($ledger);
					
				}else{
					//ledger posting for PURCHASE ACCOUNT
					$ledger = $this->InvoiceBookings->Ledgers->newEntity();
					$ledger->ledger_account_id = $invoiceBooking->purchase_ledger_account;
					$ledger->debit = $invoiceBooking->total-$invoiceBooking->total_saletax;
					$ledger->credit = 0;
					$ledger->voucher_id = $invoiceBooking->id;
					$ledger->company_id = $invoiceBooking->company_id;
					$ledger->voucher_source = 'Invoice Booking';
					$ledger->transaction_date = $invoiceBooking->supplier_date;
					$this->InvoiceBookings->Ledgers->save($ledger);
					
					
					//ledger posting for PURCHASE ACCOUNT
					$ledger = $this->InvoiceBookings->Ledgers->newEntity();
					$ledger->ledger_account_id = $invoiceBooking->ledger_account_for_vat;
					$ledger->debit = $invoiceBooking->total_saletax;
					$ledger->credit = 0;
					$ledger->voucher_id = $invoiceBooking->id;
					$ledger->company_id = $invoiceBooking->company_id;
					$ledger->voucher_source = 'Invoice Booking';
					$ledger->transaction_date = $invoiceBooking->supplier_date;
					$this->InvoiceBookings->Ledgers->save($ledger);
				}
				
				
				//Ledger posting for SUPPLIER
				$v_LedgerAccount=$this->InvoiceBookings->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Vendors','source_id'=>$vendor_id])->first();
				
				$ledger = $this->InvoiceBookings->Ledgers->newEntity();
				$ledger->ledger_account_id = $v_LedgerAccount->id;
				$ledger->debit = 0;
				$ledger->credit =$invoiceBooking->total;
				$ledger->voucher_id = $invoiceBooking->id;
				$ledger->transaction_date = $invoiceBooking->supplier_date;
				$ledger->company_id = $invoiceBooking->company_id;
				$ledger->voucher_source = 'Invoice Booking';
				$this->InvoiceBookings->Ledgers->save($ledger);
				//pr($invoiceBooking); exit;
				//Reference Number coding 
				if(sizeof(@$ref_rows)>0){
						
						foreach($ref_rows as $ref_row){  
							$ref_row=(object)$ref_row;
							$ReferenceDetail=$this->InvoiceBookings->ReferenceDetails->find()->where(['ledger_account_id'=>$v_LedgerAccount->id,'reference_no'=>$ref_row->ref_no,'invoice_booking_id'=>$invoiceBooking->id])->first();
							
							if($ReferenceDetail){
								$ReferenceBalance=$this->InvoiceBookings->ReferenceBalances->find()->where(['ledger_account_id'=>$v_LedgerAccount->id,'reference_no'=>$ref_row->ref_no])->first();
								$ReferenceBalance=$this->InvoiceBookings->ReferenceBalances->get($ReferenceBalance->id);
								$ReferenceBalance->credit=$ReferenceBalance->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								
								$this->InvoiceBookings->ReferenceBalances->save($ReferenceBalance);
								
								$ReferenceDetail=$this->InvoiceBookings->ReferenceDetails->find()->where(['ledger_account_id'=>$v_LedgerAccount->id,'reference_no'=>$ref_row->ref_no,'invoice_booking_id'=>$invoiceBooking->id])->first();
								$ReferenceDetail=$this->InvoiceBookings->ReferenceDetails->get($ReferenceDetail->id);
								$ReferenceDetail->credit=$ReferenceDetail->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								$this->InvoiceBookings->ReferenceDetails->save($ReferenceDetail);
								
							}else{ 
								if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
									$query = $this->InvoiceBookings->ReferenceBalances->query();
									$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
									->values([
										'ledger_account_id' => $v_LedgerAccount->id,
										'reference_no' => $ref_row->ref_no,
										'credit' => $ref_row->ref_amount,
										'debit' => 0
									])
									->execute();
									
								}else{ 
									$ReferenceBalance=$this->InvoiceBookings->ReferenceBalances->find()->where(['ledger_account_id'=>$v_LedgerAccount->id,'reference_no'=>$ref_row->ref_no])->first();
									$ReferenceBalance=$this->InvoiceBookings->ReferenceBalances->get($ReferenceBalance->id);
									$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
									
									$this->InvoiceBookings->ReferenceBalances->save($ReferenceBalance);
								}
								
								$query = $this->InvoiceBookings->ReferenceDetails->query();
								$query->insert(['ledger_account_id', 'invoice_booking_id', 'reference_no', 'credit', 'debit', 'reference_type'])
								->values([
									'ledger_account_id' => $v_LedgerAccount->id,
									'invoice_booking_id' => $invoiceBooking->id,
									'reference_no' => $ref_row->ref_no,
									'credit' =>$ref_row->ref_amount,
									'debit' => 0, 
									'reference_type' =>$ref_row->ref_type
								])
								->execute();
								
							}
						}
					}

				
                $this->Flash->success(__('The invoice booking has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The invoice booking could not be saved. Please, try again.'));
            }
        }
        $grns = $this->InvoiceBookings->Grns->find('list');
		
		$AccountReference= $this->InvoiceBookings->AccountReferences->get(2);
		$ledger_account_details = $this->InvoiceBookings->LedgerAccounts->find('list')->contain(['AccountSecondSubgroups'=>['AccountFirstSubgroups' => function($q) use($AccountReference){
			return $q->where(['AccountFirstSubgroups.id'=>$AccountReference->account_first_subgroup_id]);
		}]])->order(['LedgerAccounts.name' => 'ASC'])->where(['LedgerAccounts.company_id'=>$st_company_id]);
		
		$AccountReference= $this->InvoiceBookings->AccountReferences->get(4);
		$ledger_account_vat = $this->InvoiceBookings->LedgerAccounts->find('list')->contain(['AccountSecondSubgroups'=>['AccountFirstSubgroups' => function($q) use($AccountReference){
			return $q->where(['AccountFirstSubgroups.id'=>$AccountReference->account_first_subgroup_id]);
		}]])->order(['LedgerAccounts.name' => 'ASC'])->where(['LedgerAccounts.company_id'=>$st_company_id]);
		
        $this->set(compact('invoiceBooking','ReferenceDetails', 'grns','financial_year_data','ReferenceBalances','invoice_booking_id','v_LedgerAccount', 'ledger_account_details', 'ledger_account_vat','chkdate','fromdate1','tody1'));
        $this->set('_serialize', ['invoiceBooking']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoice Booking id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoiceBooking = $this->InvoiceBookings->get($id);
        if ($this->InvoiceBookings->delete($invoiceBooking)) {
            $this->Flash->success(__('The invoice booking has been deleted.'));
        } else {
            $this->Flash->error(__('The invoice booking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	function DueInvoiceBookingsForPayment($paid_to_id=null){
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$Vendor=$this->InvoiceBookings->Vendors->find()->where(['ledger_account_id'=>$paid_to_id])->first();
		if(!$Vendor){ echo 'Select paid to.'; exit; }
		$InvoiceBookings = $this->InvoiceBookings->find()->where(['company_id'=>$st_company_id,'vendor_id'=>$Vendor->id,'due_payment >'=>0]);
		 $this->set(compact('InvoiceBookings','Vendor'));
	}
	
	
	public function fetchRefNumbers($ledger_account_id){
		$this->viewBuilder()->layout('');
		$ReferenceBalances=$this->InvoiceBookings->ReferenceBalances->find()->where(['ledger_account_id'=>$ledger_account_id]);
		$this->set(compact('ReferenceBalances','cr_dr'));
	}
	function checkRefNumberUnique($received_from_id,$i){
		$reference_no=$this->request->query['ref_rows'][$i]['ref_no'];
		$ReferenceBalances=$this->InvoiceBookings->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
		if($ReferenceBalances->count()==0){
			echo 'true'; exit;
		}else{
			echo 'false';
		}
		exit;
	}
	
	public function fetchRefNumbersEdit($received_from_id=null,$reference_no=null,$credit=null){
		$this->viewBuilder()->layout('');
		$ReferenceBalances=$this->InvoiceBookings->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
		$this->set(compact('ReferenceBalances', 'reference_no', 'credit'));
	}
	
	function deleteOneRefNumbers(){
		$old_received_from_id=$this->request->query['old_received_from_id'];
		$invoice_booking_id=$this->request->query['invoice_booking_id'];
		$old_ref=$this->request->query['old_ref'];
		$old_ref_type=$this->request->query['old_ref_type'];
		
		if($old_ref_type=="New Reference" || $old_ref_type=="Advance Reference"){
			$this->InvoiceBookings->ReferenceBalances->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
			$this->InvoiceBookings->ReferenceDetails->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
		}elseif($old_ref_type=="Against Reference"){
			$ReferenceDetail=$this->InvoiceBookings->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'invoice_booking_id'=>$invoice_booking_id,'reference_no'=>$old_ref])->first();
			if(!empty($ReferenceDetail->dedit)){
				$ReferenceBalance=$this->InvoiceBookings->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
				$ReferenceBalance=$this->InvoiceBookings->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->dedit=$ReferenceBalance->dedit-$ReferenceDetail->dedit;
				$this->InvoiceBookings->ReferenceBalances->save($ReferenceBalance);
			}elseif(!empty($ReferenceDetail->credit)){
				$ReferenceBalance=$this->InvoiceBookings->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
				$ReferenceBalance=$this->InvoiceBookings->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
				$this->InvoiceBookings->ReferenceBalances->save($ReferenceBalance);
			}
			$RDetail=$this->InvoiceBookings->ReferenceDetails->get($ReferenceDetail->id);
			$this->InvoiceBookings->ReferenceDetails->delete($RDetail);
		}
		
		exit;
	}
	public function purchaseReport(){
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		$where=[];
		$this->set(compact('From','To'));
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['InvoiceBookings.created_on >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['InvoiceBookings.created_on <=']=$To;
		}
		
		$this->viewBuilder()->layout('index_layout');
		$InvoiceBookings = $this->InvoiceBookings->find()->contain(['InvoiceBookingRows','Vendors'])->where($where)->order(['InvoiceBookings.id' => 'DESC'])->where(['InvoiceBookings.company_id'=>$st_company_id]);
		//pr($InvoiceBookings->toArray()); exit;
		$this->set(compact('InvoiceBookings'));
	}
	
	

}
