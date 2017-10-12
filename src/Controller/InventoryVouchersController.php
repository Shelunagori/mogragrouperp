<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InventoryVouchers Controller
 *
 * @property \App\Model\Table\InventoryVouchersTable $InventoryVouchers
 */
class InventoryVouchersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$iv_no=$this->request->query('iv_no');
		$invoice_no=$this->request->query('invoice_no');
		$customer=$this->request->query('customer');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		$this->set(compact('iv_no','customer','invoice_no','From','To'));
		$where=[];
		if(!empty($invoice_no)){
			$where['Invoices.in2 LIKE']=$invoice_no;
		}
		if(!empty($iv_no)){
			$where['InventoryVouchers.iv_number LIKE']=$iv_no;
		}
		if(!empty($customer)){
			$where['Customers.customer_name LIKE']='%'.$customer.'%';
		}
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['InventoryVouchers.transaction_date >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['InventoryVouchers.transaction_date <=']=$To;
		}
        $this->paginate = [
            'contain' => ['Invoices'=>['Customers'],'InventoryVoucherRows']
        ];
		
		$inventoryVouchers = $this->paginate($this->InventoryVouchers->find()->contain(['Invoices'])->where($where)->where(['InventoryVouchers.company_id'=>$st_company_id])->order(['InventoryVouchers.id' => 'DESC']));
		

        $this->set(compact('inventoryVouchers','url'));
        $this->set('_serialize', ['inventoryVouchers']);
    }

	public function excelExport(){
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$iv_no=$this->request->query('iv_no');
		$invoice_no=$this->request->query('invoice_no');
		$customer=$this->request->query('customer');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		$this->set(compact('iv_no','customer','invoice_no','From','To'));
		$where=[];
		if(!empty($invoice_no)){
			$where['Invoices.in2 LIKE']=$invoice_no;
		}
		if(!empty($iv_no)){
			$where['InventoryVouchers.iv_number LIKE']=$iv_no;
		}
		if(!empty($customer)){
			$where['Customers.customer_name LIKE']='%'.$customer.'%';
		}
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['InventoryVouchers.transaction_date >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['InventoryVouchers.transaction_date <=']=$To;
		}
        
		
		$inventoryVouchers = $this->InventoryVouchers->find()->contain(['Invoices'=>['Customers'],'InventoryVoucherRows'])->where($where)->where(['InventoryVouchers.company_id'=>$st_company_id])->order(['InventoryVouchers.id' => 'DESC']);
		

        $this->set(compact('inventoryVouchers','url','From','To'));
	}
	public function indexx()
    {
		$inventerys =$this->InventoryVouchers->find()->where(['transaction_date'=>''])->order(['id'=>'asc'])->toArray();
		//pr($inventerys);exit;
	   foreach($inventerys as $inventery)
		{
			$ledgers =$this->InventoryVouchers->ItemLedgers->find()->where(['ItemLedgers.source_model'=>'Inventory Vouchers','ItemLedgers.source_id'=>$inventery->id,'ItemLedgers.in_out' => 'in']);
			//pr($ledgers->toArray());exit;
			echo $inventery->id;echo "<br>";
			foreach($ledgers as $ledger)
		    {
			    $transaction_date = date("Y-m-d",strtotime($ledger->processed_on));
				                $query = $this->InventoryVouchers->query();
								$query->update()
									->set(['transaction_date' => $transaction_date])
									->where(['id' => $inventery->id])
									->execute(); 
			}
		} 
		exit;
	}
    /**
     * View method
     *
     * @param string|null $id Inventory Voucher id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
	   $inventoryVoucher = $this->InventoryVouchers->get($id, [
            'contain' =>  ['Invoices'=>['InvoiceRows'=>['Items'],'Customers'],'InventoryVoucherRows'=>['Items'=>['ItemSerialNumbers','ItemCompanies' =>function($q) use($st_company_id){
									return $q->where(['company_id'=>$st_company_id]);
								}]],'Creator', 'Companies']
        ]);
		//pr($inventoryVoucher);exit;
		$this->set('inventoryVoucher', $inventoryVoucher);
        $this->set('_serialize', ['inventoryVoucher']);
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
		$invoice_id=@(int)$this->request->query('invoice');
		$item_id=@(int)$this->request->query('item_id');
		
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->InventoryVouchers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		 
		
		$financial_month_first = $this->InventoryVouchers->FinancialMonths->find()->where(['financial_year_id'=>$st_year_id,'status'=>'Open'])->first();
		$financial_month_last = $this->InventoryVouchers->FinancialMonths->find()->where(['financial_year_id'=>$st_year_id,'status'=>'Open'])->last();
		$invoice_data=$this->InventoryVouchers->Invoices->get($invoice_id,[
			'contain'=>['InvoiceRows'=>['Items']]
		]);
		$display_items=[];
		$sales_order_id=$invoice_data->sales_order_id;
		foreach($invoice_data->invoice_rows as $invoice_row){ 
			$SalesOrderRow=$this->InventoryVouchers->SalesOrderRows->find()->where(['sales_order_id'=>$sales_order_id,'item_id'=>$invoice_row->item_id])->first();
			if($invoice_row->item->source=='Purchessed/Manufactured'){ 
				if($SalesOrderRow->source_type=="Manufactured"){
					$display_items[$invoice_row->item->id]=$invoice_row->item->name; 
				}
			}elseif($invoice_row->item->source=='Assembled' or $invoice_row->item->source=='Manufactured'){
				$display_items[$invoice_row->item->id]=$invoice_row->item->name; 
			}
		}
		
		
		foreach($display_items as $item_id=>$item_name){
			$query = $this->InventoryVouchers->InvoiceRows->query();
			$query->update()
				->set(['inventory_voucher_applicable' => 'Yes'])
				->where(['invoice_id' => $invoice_id,'item_id'=>$item_id])
				->execute();
		}
		
						
		if(empty($item_id) && !empty($invoice_id)){
			$row=$this->InventoryVouchers->Invoices->get($invoice_id, [
				'contain' => ['InvoiceRows'=> function ($q) {
				return $q->where(['InvoiceRows.inventory_voucher_status'=>'Pending','InvoiceRows.inventory_voucher_applicable'=>'Yes']);
				}]]);
				
			$invoice_row = $row->invoice_rows[0];
			
			$item_id=$invoice_row->item_id;
			$invoice_row_id=$invoice_row->id;
		}
		$item = $this->InventoryVouchers->Items->get($item_id);
 		$inventoryVouchers = $this->InventoryVouchers->InventoryVoucherRows->find()->where(['invoice_id'=>$invoice_id,'left_item_id'=>$item_id]);
		
		if($inventoryVouchers->count()==0){
			$Invoice = $this->InventoryVouchers->Invoices->get($invoice_id);
			$sales_order_id=$Invoice->sales_order_id;
			$SalesOrderRow=$this->InventoryVouchers->SalesOrderRows->find()->where(['sales_order_id'=>$sales_order_id,'item_id'=>$item_id])->first();
			$SalesOrderRowID=$SalesOrderRow->id;
			
			$JobCardRows=$this->paginate(
			$this->InventoryVouchers->JobCardRows->find()->contain(['Items'=>['ItemSerialNumbers'=>		function ($q) {  return $q
			->where(['ItemSerialNumbers.status' => 'In' ]); }]])
			->where(['sales_order_id'=>$sales_order_id,'sales_order_row_id'=>$SalesOrderRowID])
			);	 
		}else{ 
			$InventoryVoucherRows=$this->InventoryVouchers->InventoryVoucherRows->find()->contain(['Items'=>['ItemSerialNumbers'=>		function ($q) {  return $q
			->where(['ItemSerialNumbers.status' => 'In' ]); }]])
			->where(['invoice_id'=>$invoice_id,'left_item_id'=>$item_id]);
		}
  		$this->set(compact('JobCardRows','InventoryVoucherRows','item','invoice_row','row','display_items','invoice_id'));
		 
		 $Invoicesexists = $this->InventoryVouchers->InventoryVoucherRows->exists(['invoice_id' => $invoice_id]);
		
		if(!$Invoicesexists){ 
			$inventoryVoucher = $this->InventoryVouchers->newEntity();
			if ($this->request->is('post')) {	
				$inventoryVoucher = $this->InventoryVouchers->patchEntity($inventoryVoucher, $this->request->data);
				$inventoryVoucher->iv1=$invoice_data->in1;
 				$inventoryVoucher->iv3=$invoice_data->in3;
				$inventoryVoucher->iv4='16-17';
				$inventoryVoucher->invoice_id=$invoice_id;
				$inventoryVoucher->created_by=$s_employee_id; 
				$inventoryVoucher->company_id=$st_company_id;
				foreach($inventoryVoucher->inventory_voucher_rows as $inventory_voucher_row){
					$inventory_voucher_row->invoice_id=$invoice_id;
					$inventory_voucher_row->left_item_id=$item_id;
				}
				//pr($inventoryVoucher); exit;
				if ($this->InventoryVouchers->save($inventoryVoucher)) { 
				//pr($inventoryVoucher->inventory_voucher_rows); exit;
					foreach($inventoryVoucher->inventory_voucher_rows as $inventory_voucher_row){
						$total_size=sizeof($inventory_voucher_row->item_serial_numbers);
						
						if(!empty($total_size)){
							foreach($inventory_voucher_row->item_serial_numbers as $item_serial_number){
								$query = $this->InventoryVouchers->ItemSerialNumbers->query();
								$query->update()
									->set(['status' => 'Out','inventory_voucher_id' => $inventory_voucher_row->inventory_voucher_id])
									->where(['id' => $item_serial_number])
									->execute();
							}
						}
					}
					
					$query = $this->InventoryVouchers->InvoiceRows->query();
					$query->update()
							->set(['inventory_voucher_status' => 'Done'])
							->where(['id' => $invoice_row_id])
							->execute();
					$row=$this->InventoryVouchers->Invoices->get($invoice_id, [
							'contain' => ['InvoiceRows'=> function ($q) {
								return $q->where(['inventory_voucher_status '=>'Pending']);
								}]]);
								
					$total=sizeof($row->invoice_rows);
							
					if($total>0) {
						$invoice_row = $row->invoice_rows[0];
						$item_id=$invoice_row->item_id;
						return $this->redirect(['action' => 'Add?Invoice='.$invoice_id.'&item_id='.$item_id]);
					}else{
						$this->Flash->success(__('The inventory voucher has been saved.'));
						return $this->redirect(['action' => 'Index']);
					}
				} 
			}	
		}else{ 
			$inventoryVouchersrows = $this->InventoryVouchers->InventoryVoucherRows->find()->where(['invoice_id'=>$invoice_id])->first();
			$inventoryVoucher = $this->InventoryVouchers->get($inventoryVouchersrows->inventory_voucher_id);
			if ($this->request->is(['patch', 'post', 'put'])) { 
            $inventoryVoucher = $this->InventoryVouchers->InventoryVoucherRows->patchEntity($inventoryVoucher, $this->request->data);
				foreach($inventoryVoucher->inventory_voucher_rows as  $key=>$inventory_voucher_row){
					$query = $this->InventoryVouchers->InventoryVoucherRows->query();
					$query->insert(['invoice_id', 'left_item_id', 'item_id', 'quantity', 'inventory_voucher_id'])
						->values([
							'invoice_id' => $invoice_id,
							'left_item_id' => $item_id,
							'item_id' => $inventory_voucher_row['item_id'],
							'quantity' => $inventory_voucher_row['quantity'],
							'inventory_voucher_id' => $inventoryVouchersrows->inventory_voucher_id
							
						])
						->execute();
				} 
				foreach($inventoryVoucher->inventory_voucher_rows as $inventory_voucher_row){
					
					$total_size=sizeof((int)@$inventory_voucher_row['item_serial_numbers']);
						if(!empty($total_size)){
							foreach($inventory_voucher_row['item_serial_numbers'] as $item_serial_number){
								$query = $this->InventoryVouchers->ItemSerialNumbers->query();
								$query->update()
									->set(['status' => 'Out','inventory_voucher_id' => $inventoryVouchersrows->inventory_voucher_id])
									->where(['id' => $item_serial_number])
									->execute();
							}	
						}
				}
				exit;
 				$query = $this->InventoryVouchers->InvoiceRows->query();
				$query->update()
						->set(['inventory_voucher_status' => 'Done'])
						->where(['id' => $invoice_row_id])
						->execute();
						 $row=$this->InventoryVouchers->Invoices->get($invoice_id, [
						'contain' => ['InvoiceRows'=> function ($q) {
							return $q->where(['inventory_voucher_status '=>'Pending']);
							}]]);
							$total=sizeof($row->invoice_rows);
					
				if($total>0) {
						$invoice_row = $row->invoice_rows[0];
						$item_id=$invoice_row->item_id;
						$this->Flash->success(__('The inventory voucher has been saved.'));
						return $this->redirect(['action' => 'Add?Invoice='.$invoice_id.'&item_id='.$item_id]);
				} else {
						$query = $this->InventoryVouchers->Invoices->query();
						$query->update()
						->set(['inventory_voucher_status' => 'Done'])
						->where(['id' => $invoice_id])
						->execute();
						$this->Flash->success(__('The inventory voucher has been saved.'));
						return $this->redirect(['action' => 'view/'.$inventoryVouchersrows->inventory_voucher_id]);
				}
			
			}
		 }

    
		//$items = $this->InventoryVouchers->Items->find('list')->where(['source IN'=>['Purchessed','Purchessed/Manufactured']]);
		$items = $this->InventoryVouchers->Items->find('list')->where(['source IN'=>['Purchessed','Purchessed/Manufactured']])->order(['Items.name' => 'ASC'])->matching(
					'ItemCompanies', function ($q) use($st_company_id) {
						return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
					}
				);
        //$invoiceRows = $this->InventoryVouchers->InvoiceRows->find('list', ['limit' => 200]);
        $this->set(compact('inventoryVoucher', 'Invoice','items','last_iv_no','job_card_data','invoice_data','financial_month_first','financial_month_last'));
        $this->set('_serialize', ['inventoryVoucher']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Voucher id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit() 
    {
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$invoice_id=@(int)$this->request->query('invoice');
		$q_item_id=@(int)$this->request->query('item-id');
		$q_item_qty=@(int)$this->request->query('item-qty');
		
        $s_employee_id=$this->viewVars['s_employee_id'];

			   	$st_year_id = $session->read('st_year_id');
				$financial_year = $this->InventoryVouchers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
				 
				
				$financial_month_first = $this->InventoryVouchers->FinancialMonths->find()->where(['financial_year_id'=>$st_year_id,'status'=>'Open'])->first();
				$financial_month_last = $this->InventoryVouchers->FinancialMonths->find()->where(['financial_year_id'=>$st_year_id,'status'=>'Open'])->last();
				
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


				
		$invoice_data=$this->InventoryVouchers->Invoices->get($invoice_id,[
			'contain'=>['InvoiceRows'=>['Items']]
		]);
		
		$display_items=[];
		$display_quantity=[];
		$sales_order_id=$invoice_data->sales_order_id;
		foreach($invoice_data->invoice_rows as $invoice_row){ 
		
			$SalesOrderRow=$this->InventoryVouchers->SalesOrderRows->find()->where(['sales_order_id'=>$sales_order_id,'item_id'=>$invoice_row->item_id])->first();
			
			if($invoice_row->item->source=='Purchessed/Manufactured'){ 
				if($SalesOrderRow->source_type=="Manufactured" || $SalesOrderRow->source_type=="" ){
					$display_items[$invoice_row->item->id]=$invoice_row->item->name; 
					$display_quantity[$invoice_row->item->id]=$invoice_row->quantity; 
				}
			}elseif($invoice_row->item->source=='Assembled' or $invoice_row->item->source=='Manufactured'){
				$display_items[$invoice_row->item->id]=$invoice_row->item->name; 
				$display_quantity[$invoice_row->item->id]=$invoice_row->quantity; 
			}
		}
		
		//pr($display_items); exit;
		
		foreach($display_items as $item_id=>$item_name){
			$query = $this->InventoryVouchers->InvoiceRows->query();
			$query->update()
				->set(['inventory_voucher_applicable' => 'Yes'])
				->where(['invoice_id' => $invoice_id,'item_id'=>$item_id])
				->execute();
		}
		$Invoice=$this->InventoryVouchers->Invoices->get($invoice_id, [
				'contain' => ['InvoiceRows'=> function ($q) {
				return $q->where(['InvoiceRows.inventory_voucher_applicable'=>'Yes','InvoiceRows.inventory_voucher_status'=>'Pending']);
				}]]);
		
		//$aw=pr(sizeof($Invoice->invoice_rows)); exit;
		
		if(sizeof($Invoice->invoice_rows)==0){
			$query1 = $this->InventoryVouchers->Invoices->query();
			$query1->update()
				->set(['inventory_voucher_status' => 'Completed'])
				->where(['id' => $invoice_id])
				->execute();
			
			$query = $this->InventoryVouchers->query();
			$query->update()
				->set(['status' => 'Completed'])
				->where(['invoice_id' => $invoice_id])
				->execute();
				
		}

		if(empty($q_item_id) && !empty($invoice_id)){
			$Invoice=$this->InventoryVouchers->Invoices->get($invoice_id, [
				'contain' => ['InvoiceRows'=> function ($q) {
				return $q->where(['InvoiceRows.inventory_voucher_applicable'=>'Yes']);
				}]]);
				//pr($Invoice); exit;
			$invoice_row = @$Invoice->invoice_rows[0];
			$item_id=$invoice_row->item_id;
			$invoice_row_id=$invoice_row->id;
			$qty=$invoice_row->quantity;
			return $this->redirect(['action' => 'edit?invoice='.$invoice_id.'&item_id='.$item_id.'&item-qty='.$qty]);
		}
		
	
		
		$InventoryVoucher = $this->InventoryVouchers->newEntity();
		if ($this->request->is(['post','put','patch'])) {
			
			 $q_serial_no=@$this->request->data['serial_numbers'];
			 $narration=@$this->request->data['narration'];
			 $transaction_date=@$this->request->data['transaction_date'];
			 if(!empty($transaction_date))
			 {
				 $transaction_date = date("Y-m-d",strtotime($transaction_date));
			 }
             			 
			
			$InventoryVoucher=$this->InventoryVouchers->find()->where(['invoice_id'=>$invoice_id]);
			if($InventoryVoucher->count()==0){ 
				$last_iv_number=$this->InventoryVouchers->find()->select(['iv_number'])->where(['company_id' => $st_company_id])->order(['iv_number' => 'DESC'])->first();
				if($last_iv_number){
					$iv_number=$last_iv_number->iv_number+1;
				}else{
					$iv_number=1;
				}
				
				$query2 = $this->InventoryVouchers->query();
				$query2->insert(['invoice_id', 'iv_number', 'created_by', 'company_id', 'transaction_date', 'narration'])
				->values([
					'invoice_id' => $invoice_id,
					'iv_number' => $iv_number,
					'created_by' => $s_employee_id,
					'company_id'=>$st_company_id,
					'transaction_date'=>$transaction_date,
					'narration'=>$narration
				])
				->execute();
			}
			else
			{ 
				
				$query2 = $this->InventoryVouchers->query();
				$query2->update()
					->set(['narration' => $narration,'transaction_date' => $transaction_date])
					->where(['company_id' => $st_company_id,'invoice_id'=>$invoice_id])
					->execute();
				
			}
			$InventoryVoucher=$this->InventoryVouchers->find()->where(['invoice_id'=>$invoice_id])->first();
			
			$inventory_voucher_id=$InventoryVoucher->id;
			$query = $this->InventoryVouchers->InventoryVoucherRows->query();
			$query->delete()
				->where(['left_item_id' => $q_item_id,'invoice_id'=>$invoice_id])
				->execute();
			
			$this->InventoryVouchers->ItemSerialNumbers->deleteAll(['item_id' => $q_item_id,'in_inventory_voucher_id' => $inventory_voucher_id]);
			
			
			$query = $this->InventoryVouchers->ItemSerialNumbers->query();
			$query->update()
				->set(['status' => 'In','iv_invoice_id'=>0,'q_item_id'=>0])
				->where(['iv_invoice_id' => $invoice_id,'q_item_id'=>$q_item_id])
				->execute();
			
			$this->InventoryVouchers->ItemLedgers->deleteAll(['left_item_id' => $q_item_id,'source_id' => $inventory_voucher_id,'source_model' => 'Inventory Vouchers','company_id' => $st_company_id]);	

			$inventory_voucher_rows=$this->request->data['inventory_voucher_rows'];
			$total_rate=0;
			foreach($inventory_voucher_rows as $inventory_voucher_row){

				$query3 = $this->InventoryVouchers->InventoryVoucherRows->query();
				$query3->insert(['inventory_voucher_id', 'item_id', 'quantity', 'left_item_id', 'invoice_id'])
				->values([
					'inventory_voucher_id' => $inventory_voucher_id,
					'item_id' => $inventory_voucher_row['item_id'],
					'quantity' => $inventory_voucher_row['quantity'],
					'left_item_id'=>$q_item_id,
					'invoice_id'=>$invoice_id,
				])
				->execute();
			
				if(sizeof(@$inventory_voucher_row['serial_number_data'])>0){
					foreach($inventory_voucher_row['serial_number_data'] as $serial_id){
						$query = $this->InventoryVouchers->ItemSerialNumbers->query();
						$query->update()
							->set(['status' => 'Out','iv_invoice_id'=>$invoice_id,'q_item_id'=>$q_item_id])
							->where(['id' => $serial_id])
							->execute();
					}
				}
				
				$itemLedgers = $this->InventoryVouchers->ItemLedgers->find()->where(['item_id'=>$inventory_voucher_row['item_id'],'in_out'=>'In','company_id' => $st_company_id,'processed_on <=' =>$InventoryVoucher->transaction_date,'rate >'=>0,'quantity >'=>0]);
				
				$rate=0; $count=0;
				foreach($itemLedgers as $itemLedger){
					if($itemLedger->rate > 0 ){  //pr($itemLedgers); 
						$count=$count+$itemLedger->quantity;
						$rate=$rate+($itemLedger->rate*$itemLedger->quantity);
					}
				}
				
				if($count > 0){ 
				$toupdate_rate=$rate/$count;
				}else{
				$toupdate_rate=$rate;	
				}
				//pr($toupdate_rate); exit;
				$out_rate=$toupdate_rate*$inventory_voucher_row['quantity'];
				$total_rate=$total_rate+$out_rate;
				//pr($inventory_voucher_row['quantity']);
				 //exit;
				$query= $this->InventoryVouchers->ItemLedgers->query();
					$query->insert(['item_id', 'quantity', 'source_model', 'source_id','in_out','rate','company_id','left_item_id','processed_on'])
				->values([
					'item_id' => $inventory_voucher_row['item_id'],
					'quantity' => $inventory_voucher_row['quantity'],
					'source_model' => 'Inventory Vouchers',
					'source_id'=>$inventory_voucher_id,
					'in_out'=>'Out',
					'rate'=>$toupdate_rate,
					'company_id'=>$st_company_id,
					'left_item_id'=>$q_item_id,
					'processed_on'=>$transaction_date
				])
				->execute();

			} 
				$this->Flash->success(__('The inventory voucher has been Saved.'));
				
			$total_rate_out=$total_rate/$q_item_qty;
			$query= $this->InventoryVouchers->ItemLedgers->query();
					$query->insert(['item_id', 'quantity', 'source_model', 'source_id','in_out','rate','company_id','left_item_id','processed_on','rate_updated'])
				->values([
					'item_id' => $q_item_id,
					'quantity' => $q_item_qty,
					'source_model' => 'Inventory Vouchers',
					'source_id'=>$inventory_voucher_id,
					'in_out'=>'In',
					'rate'=>$total_rate_out,
					'company_id'=>$st_company_id,
					'left_item_id'=>$q_item_id,
					'processed_on'=>$transaction_date,
					'rate_updated'=>'Yes'
				])
				->execute();
			
			//dynamic cost			
			$results_dynamic_cost=$this->InventoryVouchers->ItemLedgers->find()->where(['ItemLedgers.item_id' => $q_item_id,'ItemLedgers.in_out' => 'In','rate_updated' => 'Yes','company_id' => $st_company_id]); 
				
				$j=0; $qty_total=0; $rate_total=0; $per_unit_cost=0;
				foreach($results_dynamic_cost as $result){
					$qty=$result->quantity;
					$rate=$result->rate;
					@$total_amount=$qty*$rate;
					$rate_total=$rate_total+$total_amount;
					$qty_total=$qty_total+$qty;
				$j++;
				}
				
				$per_unit_cost=$rate_total/$qty_total;
				$query1 = $this->InventoryVouchers->Items->ItemCompanies->query();
				$query1->update()
					->set(['dynamic_cost' => $per_unit_cost])
					->where(['item_id' => $q_item_id,'company_id' => $st_company_id])
					->execute();
			
			$query5 = $this->InventoryVouchers->InvoiceRows->query();
			$query5->update()
				->set(['inventory_voucher_status' => 'Done'])
				->where(['invoice_id'=>$invoice_id,'item_id'=>$q_item_id])
				->execute();  
				
			$InvoiceRowsData = $this->InventoryVouchers->InvoiceRows->find()->where(['InvoiceRows.invoice_id'=>$invoice_id,'InvoiceRows.inventory_voucher_status'=>'Pending']);	
			
			if(sizeof($InvoiceRowsData->toArray())>0){
				return $this->redirect(['action' => 'edit?invoice='.$invoice_id.'&item_id='.$q_item_id.'&item-qty='.$qty]);
			}else{
					return $this->redirect(['action' => 'index']);
			}
				
			if(sizeof($q_serial_no)>0){
				foreach($q_serial_no as $sr){
					$query= $this->InventoryVouchers->ItemSerialNumbers->query();
						$query->insert(['item_id', 'in_inventory_voucher_id', 'status', 'serial_no'])
					->values([
						'item_id' => $q_item_id,
						'in_inventory_voucher_id' => $inventory_voucher_id,
						'status' => 'In',
						'serial_no'=>$sr,
					])
					->execute();
				}
			}
			$Invoices=$this->InventoryVouchers->Invoices->find()
			->contain(['InvoiceRows'])
			->where(['Invoices.sales_order_id'=>$Invoice->sales_order_id])
				->toArray();
			$total=0;
			foreach($Invoices as $Invoice){
				foreach($Invoice->invoice_rows as $invoice_row){
					$total=$total+$invoice_row->quantity;
				}
			}
			$SalesOrders=$this->InventoryVouchers->SalesOrders->find()->contain(['SalesOrderRows' => function($q) use($q_item_id) {
                                    return $q
                                       ->where([
                                            'SalesOrderRows.item_id'=> $q_item_id,
                                        ]);
                                    }
			])->where(['id'=>$Invoices[0]->sales_order_id])->first();
			
			$sales_qty=$SalesOrders->sales_order_rows[0]->quantity;
			if($total==$sales_qty){
				$query = $this->InventoryVouchers->SalesOrders->query();
				$query->update()
				->set(['job_card_status' => 'Converted'])
				->where(['id' => $SalesOrders->id])
				->execute();
			}
			
			
		}
		
		$InventoryVoucherRows=$this->InventoryVouchers->InventoryVoucherRows->find()->where(['invoice_id'=>$invoice_id,'left_item_id'=>$q_item_id])->first();
		
		if(sizeof($InventoryVoucherRows)==0){
			$is_in_made='no';
		}else{
			$is_in_made='yes';
			$q_ItemSerialNumbers=$this->InventoryVouchers->ItemSerialNumbers->find()->where(['in_inventory_voucher_id'=>$InventoryVoucherRows->inventory_voucher_id,'item_id'=>$q_item_id])->toArray();
		
		}
		
		
		
		// For Find Job Card Item//
	//	pr($q_item_id); exit;
			/* $Invoices=$this->InventoryVouchers->Invoices->get($invoice_id);
			if($q_item_id!=0){
			$SalesOrderRow=$this->InventoryVouchers->SalesOrderRows->find()->where(['SalesOrderRows.sales_order_id'=>$Invoices->sales_order_id,'SalesOrderRows.item_id'=>$q_item_id])->first();
			}else{
				$SalesOrderRow=$this->InventoryVouchers->SalesOrderRows->find()->where(['SalesOrderRows.sales_order_id'=>$Invoices->sales_order_id])->first();
			}
			$JobCardRowsData=$this->InventoryVouchers->SalesOrderRows->JobCardRows->find()->contain(['Items'])->where(['sales_order_row_id'=>$SalesOrderRow->id])->toArray(); */
		
	
		//
		
		
				
		
		
		if(!empty($q_item_id) && !empty($invoice_id)){
			
			$InventoryVoucherexist=$this->InventoryVouchers->InventoryVoucherRows->exists(['invoice_id'=>$invoice_id,'left_item_id'=>$q_item_id]);
			//pr($InventoryVoucherexist); exit;
			if($InventoryVoucherexist){
			$InventoryVoucherRows=$this->InventoryVouchers->InventoryVoucherRows->find()->where(['invoice_id'=>$invoice_id,'left_item_id'=>$q_item_id]);
			$Invoice_qty=$this->InventoryVouchers->Invoices->InvoiceRows->find()->where(['InvoiceRows.invoice_id'=>$invoice_id,'InvoiceRows.item_id'=>$q_item_id])->first();
			$q_qty=$Invoice_qty->quantity;
			$q_item_sr=$this->InventoryVouchers->Items->get($q_item_id);
			$q_sno=$q_item_sr->serial_number_enable;
			$Invoices=$this->InventoryVouchers->Invoices->get($invoice_id);	
			$status='Exist';
			//pr($SalesOrderRow); exit;
			}else{
			$Invoices=$this->InventoryVouchers->Invoices->get($invoice_id);
			
			$SalesOrderRow=$this->InventoryVouchers->SalesOrderRows->find()->where(['SalesOrderRows.sales_order_id'=>$Invoices->sales_order_id,'SalesOrderRows.item_id'=>$q_item_id])->first();
			//pr($SalesOrderRow->quantity); exit;
			$InventoryVoucherRows=$this->InventoryVouchers->SalesOrderRows->JobCardRows->find()->contain(['Items'])->where(['sales_order_row_id'=>$SalesOrderRow->id]);
			
			
			if(empty($InventoryVoucherRows)){    //pr($InventoryVoucherRows->toArray()); exit;
			//pr($InventoryVoucherRows->toArray()); exit;
			$sor=$this->InventoryVouchers->SalesOrderRows->JobCardRows->find()->contain(['Items'])->where(['sales_order_row_id'=>$SalesOrderRow->id])->first();
			$sales_order_row=$this->InventoryVouchers->SalesOrderRows->get($sor->sales_order_row_id);
			$job_card_qty=$sales_order_row->quantity;
			
			$status='FisrtTime';
			}  
			$Invoice_qty=$this->InventoryVouchers->Invoices->InvoiceRows->find()->where(['InvoiceRows.invoice_id'=>$invoice_id,'InvoiceRows.item_id'=>$q_item_id])->first();
			$q_qty=$Invoice_qty->quantity;
			//pr($q_qty); exit;
			$q_item_sr=$this->InventoryVouchers->Items->get($q_item_id);
			$q_sno=$q_item_sr->serial_number_enable;
			$job_card_qty=$SalesOrderRow->quantity;
			$status='FisrtTime';
			///$status='FisrtTime';

			
			}
			
		}
	//pr($status); exit;
		$Items = $this->InventoryVouchers->Items->find()->where(['source IN'=>['Purchessed','Purchessed/Manufactured']])->order(['Items.name' => 'ASC'])->matching(
					'ItemCompanies', function ($q) use($st_company_id) {
						return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
					}
				);
				
		//pr($Items->toArray()); exit;	
		//pr($q_qty); exit;	
        $InventoryVoucher_detail=$this->InventoryVouchers->find()->where(['invoice_id'=>$invoice_id])->toArray();	
		$this->set(compact('display_items','invoice_id','q_item_id','InventoryVoucherRows','Items','InventoryVoucher','selected_seials','q_qty','q_sno','is_in_made','q_ItemSerialNumbers','JobCardRowsData','chkdate','job_card_qty','status','InventoryVoucher_detail','display_quantity','financial_month_first','financial_month_last'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Voucher id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryVoucher = $this->InventoryVouchers->get($id);
        if ($this->InventoryVouchers->delete($inventoryVoucher)) {
            $this->Flash->success(__('The inventory voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    } 
	
	public function ItemSerialNumber($select_item_id = null,$invoice_id = null,$q_item_id = null)
    {
		//echo $select_item_id; echo $invoice_id; echo $q_item_id; exit;
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$flag=0;
		//$Item=$this->InventoryVouchers->Items->get($select_item_id);
		$Item = $this->InventoryVouchers->Items->get($select_item_id, [
            'contain' => ['ItemCompanies'=>function($q) use($st_company_id){
				return $q->where(['company_id'=>$st_company_id]);
			}]
        ]);
		if($Item->item_companies[0]->serial_number_enable=="1"){
			$SerialNumbers=$this->InventoryVouchers->ItemSerialNumbers->find()->where(['item_id'=>$select_item_id,'status'=>'In','company_id'=>$st_company_id])->orWhere(['item_id'=>$select_item_id,'iv_invoice_id'=>$invoice_id,'q_item_id'=>$q_item_id,'status'=>'Out','company_id'=>$st_company_id]);
			
			$selectedSerialNumbers=$this->InventoryVouchers->ItemSerialNumbers->find()->where(['item_id'=>$select_item_id,'iv_invoice_id'=>$invoice_id,'q_item_id'=>$q_item_id,'status'=>'Out','company_id'=>$st_company_id]);
			$flag=1;
		}
		$this->set(compact('SerialNumbers','flag','select_item_id','invoice_id','q_item_id','selectedSerialNumbers'));
    }
	
	public function itemLedgerUpdate(){
			$this->viewBuilder()->layout('');
			$session = $this->request->session();
			$st_company_id = $session->read('st_company_id');

			$itemLedgersdata = $this->InventoryVouchers->ItemLedgers->find()->where(['in_out'=>'Out','company_id' => $st_company_id,'source_model'=>'Inventory Vouchers']);
				
			foreach($itemLedgersdata as $itemLedgersdata){
				$itemLedgers = $this->InventoryVouchers->ItemLedgers->find()->where(['item_id'=>$itemLedgersdata['item_id'],'in_out'=>'In','company_id' => $st_company_id,'processed_on <=' =>$itemLedgersdata['processed_on'],'rate >'=>0,'quantity >'=>0]);
				$rate=0; $count=0;
					foreach($itemLedgers as $itemLedger){
						$count=$count+$itemLedger->quantity;
						$rate=$rate+($itemLedger->rate*$itemLedger->quantity);
					} 

					if($count > 0){ 
					$toupdate_rate=$rate/$count;
					}else{
					$toupdate_rate=$rate;	
					}
					
				$query = $this->InventoryVouchers->ItemLedgers->query();
				$query->update()
				->set(['rate' => $toupdate_rate])
				->where(['item_id'=>$itemLedgersdata['item_id'],'in_out'=>'Out','company_id' => $st_company_id,'processed_on' =>$itemLedgersdata['processed_on'],'source_model'=>'Inventory Vouchers'])
				->execute(); 
			}
			
			$itemLedgersIndatas = $this->InventoryVouchers->ItemLedgers->find()->where(['in_out'=>'In','company_id' => $st_company_id,'source_model'=>'Inventory Vouchers']);
			foreach($itemLedgersIndatas as $itemLedgersIndata){
				
				$itemLedgers1 = $this->InventoryVouchers->ItemLedgers->find()->where(['in_out'=>'Out','company_id' => $st_company_id,'rate >'=>0,'quantity >'=>0,'left_item_id'=>$itemLedgersIndata->left_item_id,'source_id'=>$itemLedgersIndata->source_id]);
				
				$rate=0; $count=0;
					foreach($itemLedgers1 as $itemLedgers1){
						$count=$count+$itemLedgers1->quantity;
						$rate=$rate+($itemLedgers1->rate*$itemLedgers1->quantity);
					} 

				$toupdate_rate=$rate/$itemLedgersIndata['quantity'];
				
				$query = $this->InventoryVouchers->ItemLedgers->query();
				$query->update()
				->set(['rate' => $toupdate_rate])
				->where(['item_id'=>$itemLedgersIndata['item_id'],'in_out'=>'In','company_id' => $st_company_id,'processed_on' =>$itemLedgersIndata['processed_on'],'source_model'=>'Inventory Vouchers'])
				->execute(); 
			
		}
		exit;	
	}
	
	public function itemSerialMismatch()
    {
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$InventoryVouchers=$this->InventoryVouchers->find()->contain(['InventoryVoucherRows'=>['Items'=>['ItemSerialNumbers','ItemCompanies'=>function($q) use($st_company_id){
									return $q->where(['ItemCompanies.company_id' => $st_company_id]);
		}]]])->where(['InventoryVouchers.company_id' => $st_company_id]);
		//pr($InventoryVouchers->toArray()); exit;
		$ItemSerials=[];
		foreach($InventoryVouchers as $InventoryVoucher){
			foreach($InventoryVoucher->inventory_voucher_rows as $inventory_voucher_row){
				if(!empty($inventory_voucher_row->item->item_companies[0]['serial_number_enable'])){
					//pr(['invoice_id'=>$invoice->id,'item_id'=>$invoice_row->item_id]);
					$ItemSerialNumbers=$this->InventoryVouchers->Items->ItemSerialNumbers->find()->where(['status' => 'Out','iv_invoice_id'=>$InventoryVoucher->invoice_id,'item_id'=>$inventory_voucher_row->item_id]);
					$ct=$ItemSerialNumbers->count(); //pr($invoice->in2);
					if($ct != $inventory_voucher_row->quantity){ 
					$ItemSerials[$InventoryVoucher->iv_number]=$inventory_voucher_row->item->name;	
					}
				}
			}
		}?>
		<table border="1">
			<tr>
				<th>ID</th>
				<th>InventoryVoucher No</th>
				<th>Item Name</th>
				
			</tr>
			<?php $i=1; foreach($ItemSerials as $key=>$ItemSerial){
				
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $key; ?></td>
				<td><?php echo $ItemSerial; ?></td>
				
				
			</tr>
			<?php $i++; } ?>
		</table>
		
		
		
		<?php exit;
		
	}
	
}
