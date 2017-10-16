<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SaleReturns Controller
 *
 * @property \App\Model\Table\SaleReturnsTable $SaleReturns
 */
class SaleReturnsController extends AppController
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
		
		$where = [];
		
		$vouch_no = $this->request->query('vouch_no');
		$in_no    = $this->request->query('in_no');
		$From    = $this->request->query('From');
		$To    = $this->request->query('To');
		$total    = $this->request->query('total');
       
		$this->set(compact('vouch_no','in_no','salesman','From','To','total'));
		
		if(!empty($vouch_no)){
			$where['SaleReturns.sr2 Like']=$vouch_no;
		}
		
		if(!empty($in_no)){
			$where['SaleReturns.sr3 Like']='%'.$in_no.'%';
		}
		
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['SaleReturns.date_created >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['SaleReturns.date_created <=']=$To;
		}
		
		if(!empty($total)){
			$where['SaleReturns.total_after_pnf']=$total;
		}
		$saleReturns = $this->paginate($this->SaleReturns->find()->where($where)->where(['SaleReturns.company_id'=>$st_company_id])->contain(['Invoices'])->order(['SaleReturns.id' => 'DESC']));
		//pr($saleReturns); exit;

        $this->set(compact('saleReturns','url'));
        $this->set('_serialize', ['saleReturns']);
    }

	public function exportExcel(){
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$where = [];
		
		$vouch_no = $this->request->query('vouch_no');
		$in_no    = $this->request->query('in_no');
		$From    = $this->request->query('From');
		$To    = $this->request->query('To');
		$total    = $this->request->query('total');
       
		$this->set(compact('vouch_no','in_no','salesman','From','To','total'));
		
		if(!empty($vouch_no)){
			$where['SaleReturns.sr2 Like']=$vouch_no;
		}
		
		if(!empty($in_no)){
			$where['SaleReturns.sr3 Like']='%'.$in_no.'%';
		}
		
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['SaleReturns.date_created >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['SaleReturns.date_created <=']=$To;
		}
		
		if(!empty($total)){
			$where['SaleReturns.total_after_pnf']=$total;
		}
		$saleReturns = $this->SaleReturns->find()->where($where)->where(['SaleReturns.company_id'=>$st_company_id])->contain(['Invoices'])->order(['SaleReturns.id' => 'DESC']);
		//pr($saleReturns); exit;

        $this->set(compact('saleReturns','url'));
        $this->set('_serialize', ['saleReturns']);
	}
    /**
     * View method
     *
     * @param string|null $id Sale Return id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $saleReturn = $this->SaleReturns->get($id, [
            'contain' => ['SaleReturnRows']
        ]);

        $this->set('saleReturn', $saleReturn);
        $this->set('_serialize', ['saleReturn']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$this->viewBuilder()->layout('index_layout');
        $saleReturn = $this->SaleReturns->newEntity();
		$invoice_id=@(int)$this->request->query('invoice');
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->SaleReturns->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		 
		
		$financial_month_first = $this->SaleReturns->FinancialMonths->find()->where(['financial_year_id'=>$st_year_id,'status'=>'Open'])->first();
		$financial_month_last = $this->SaleReturns->FinancialMonths->find()->where(['financial_year_id'=>$st_year_id,'status'=>'Open'])->last();
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

/* 
		$invoice = $this->SaleReturns->Invoices->get($invoice_id, [
            'contain' => ['InvoiceRows' => ['Items'=>['ItemSerialNumbers'=>function($q) use($invoice_id){
							return $q->where(['ItemSerialNumbers.Status' => 'Out','ItemSerialNumbers.invoice_id'=>$invoice_id]);
							},'ItemCompanies'=>function($q) use($st_company_id){
							return $q->where(['ItemCompanies.company_id' => $st_company_id]);
							}]],'SaleTaxes','Companies','Customers'=>['CustomerAddress'=> function ($q) {
						return $q
						->where(['CustomerAddress.default_address' => 1]);}],'Employees','SaleTaxes']
        ]); */
		
		$invoice = $this->SaleReturns->Invoices->get($invoice_id, [
				'contain' => ['InvoiceRows' => ['Items'=>['ItemSerialNumbers'=>function($q) use($invoice_id){
							return $q->where(['ItemSerialNumbers.Status' => 'Out','ItemSerialNumbers.invoice_id'=>$invoice_id]);
							},'ItemCompanies'=>function($q) use($st_company_id){
							return $q->where(['ItemCompanies.company_id' => $st_company_id]);
							}]],'SaleTaxes','Companies','Customers'=>['CustomerAddress'=> function ($q) {
						return $q
						->where(['CustomerAddress.default_address' => 1]);}],'Employees','SaleTaxes'
					]
			]);

		
		$c_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Customers','source_id'=>$invoice->customer->id])->first();

		
		$ReferenceDetails=$this->SaleReturns->ReferenceDetails->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'invoice_id'=>$invoice->id]);
		
        if ($this->request->is('post')) {
			$ref_rows=@$this->request->data['ref_rows'];
            $saleReturn = $this->SaleReturns->patchEntity($saleReturn, $this->request->data);
			foreach($saleReturn->sale_return_rows as $sale_return_row){ 
			//pr($sale_return_row); exit;
				if($sale_return_row->item_serial_numbers){ 
					$item_serial_no=implode(",",$sale_return_row->item_serial_numbers );
					$sale_return_row->item_serial_number=$item_serial_no;
				}
					
			}
			
			$saleReturn->company_id=$invoice->company_id;
			$saleReturn->invoice_id=$invoice->id;
			$saleReturn->sale_tax_id=$invoice->sale_tax_id;
			$saleReturn->date_created=date("Y-m-d");
			$saleReturn->sr1=$invoice->in1;
			$last_sr_no=$this->SaleReturns->find()->select(['sr2'])->where(['company_id' => $st_company_id])->order(['sr2' => 'DESC'])->first();
			if($last_sr_no){
				$saleReturn->sr2=$last_sr_no->sr2+1;
			}else{
				$saleReturn->sr2=1;
			}
			$saleReturn->sr3=$invoice->in3;
			$saleReturn->sr4=$invoice->in4;
			$saleReturn->sales_ledger_account = $invoice->sales_ledger_account;;
			$saleReturn->fright_ledger_account = $invoice->fright_ledger_account;;
			$saleReturn->transporter_id = $invoice->transporter_id;;
			$saleReturn->employee_id = $s_employee_id;
			$saleReturn->st_ledger_account_id = $invoice->st_ledger_account_id;
			
			$saleReturn->transaction_date = date("Y-m-d",strtotime($saleReturn->transaction_date)); 
			//pr($saleReturn->transaction_date); exit;
			//pr($invoice->st_ledger_account_id); exit;
			//exit;
			 if ($this->SaleReturns->save($saleReturn)) {
				
				//GET CUSTOMER LEDGER-ACCOUNT-ID
				$c_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Customers','source_id'=>$invoice->customer->id])->first();
				$ledger_grand=$saleReturn->grand_total;
				$ledger = $this->SaleReturns->Ledgers->newEntity();
				$ledger->ledger_account_id = $c_LedgerAccount->id;
				$ledger->debit = 0;
				$ledger->credit =$saleReturn->grand_total;
				$ledger->voucher_id = $saleReturn->id;
				$ledger->voucher_source = 'Sale Return';
				$ledger->company_id = $invoice->company_id;
				$ledger->transaction_date = $saleReturn->transaction_date;
				if($ledger_grand>0)
				{
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				
				//Ledger posting for Account Reference
				$ledger_pnf=$saleReturn->total_after_pnf;
				$ledger = $this->SaleReturns->Ledgers->newEntity();
				$ledger->ledger_account_id = $invoice->sales_ledger_account;
				$ledger->debit = $saleReturn->total_after_pnf;
				$ledger->credit = 0;
				$ledger->voucher_id = $saleReturn->id;
				$ledger->company_id = $invoice->company_id;
				$ledger->transaction_date = $saleReturn->transaction_date;
				$ledger->voucher_source = 'Sale Return';
				if($ledger_pnf>0)
				{
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				
				//Ledger posting for Sale Tax
				$ledger_saletax=$invoice->sale_tax_amount;
				$ledger = $this->SaleReturns->Ledgers->newEntity();
				$ledger->ledger_account_id = $invoice->st_ledger_account_id;

				$ledger->debit = $saleReturn->sale_tax_amount;

				$ledger->credit = 0;
				$ledger->voucher_id = $saleReturn->id;
				$ledger->company_id = $invoice->company_id;
				$ledger->transaction_date = $saleReturn->transaction_date;
				$ledger->voucher_source = 'Sale Return';
				if($ledger_saletax>0)
				{
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				//Ledger posting for Fright Amount
				$ledger_fright= $saleReturn->fright_amount;
				$ledger = $this->SaleReturns->Ledgers->newEntity();
				$ledger->ledger_account_id = $invoice->fright_ledger_account;
				$ledger->debit = $saleReturn->fright_amount;
				$ledger->credit =0; 
				$ledger->voucher_id = $saleReturn->id;
				$ledger->company_id = $invoice->company_id;
				$ledger->transaction_date = $saleReturn->transaction_date;
				$ledger->voucher_source = 'Sale Return';
				if($ledger_fright>0)
				{
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				$discount=$invoice->discount;
				$pf=$invoice->pnf;
				$exciseDuty=$invoice->exceise_duty;
				$sale_tax=$invoice->sale_tax_amount;
				$fright=$invoice->fright_amount;
				$total_amt=0;
				
				foreach($saleReturn->sale_return_rows as $sale_return_row){
					$item_serial_no=$sale_return_row->item_serial_number;
					if($item_serial_no){
					$serial_no=explode(",",$item_serial_no);
					foreach($serial_no as $serial){
						
						$query = $this->SaleReturns->SaleReturnRows->ItemSerialNumbers->query();
						$query->update()
							->set(['sale_return_id'=>$saleReturn->id])
							->where(['id' => $serial])
							->execute();
						
					$ItemSerialNumber_data=$this->SaleReturns->SaleReturnRows->ItemSerialNumbers->get($serial);
					$ItemSerialNumbers = $this->SaleReturns->SaleReturnRows->ItemSerialNumbers->newEntity();
					$ItemSerialNumbers->status='In';
					$ItemSerialNumbers->sale_return_id=$saleReturn->id;
					$ItemSerialNumbers->serial_no=$ItemSerialNumber_data->serial_no;
					$ItemSerialNumbers->item_id=$ItemSerialNumber_data->item_id;
					$ItemSerialNumbers->company_id=$st_company_id;
					$this->SaleReturns->SaleReturnRows->ItemSerialNumbers->save($ItemSerialNumbers);
					}
					}
				}
				//$saleReturn->data=array_filter($saleReturn->check);
				//pr($saleReturn); exit;
				foreach($saleReturn->sale_return_rows as $sale_return_row){ //pr($saleReturn->invoice_id); exit;
					$InvoiceRow = $this->SaleReturns->Invoices->InvoiceRows->find()->where(['InvoiceRows.item_id'=>$sale_return_row->item_id,'invoice_id'=>$saleReturn->invoice_id])->first();
					//pr($InvoiceRow->sale_return_quantity); exit;
					$query = $this->SaleReturns->Invoices->InvoiceRows->query();
						$query->update()
							->set(['sale_return_quantity'=>$sale_return_row->quantity+$InvoiceRow->sale_return_quantity])
							->where(['invoice_id' => $invoice->id, 'item_id'=>$sale_return_row->item_id])
							->execute();
					}
				 $saleReturn->check=array_filter($saleReturn->check);
					$i=0; 
					foreach($saleReturn->check as $sale_return_row){
						$item_id=$sale_return_row;
						$item_details=$this->SaleReturns->ItemLedgers->find()->where(['item_id'=>$item_id,'in_out'=>'In','processed_on <='=>$saleReturn->transaction_date,'rate >'=>0,'quantity >'=>0]);
						//pr($item_details->toArray()); exit;
						$ledger_data=$item_details->count();
						$Itemledger_qty=0;
						$Itemledger_rate=0;
						if($ledger_data>0){ 
							$j=0; $qty_total=0; $total_amount=0;
							foreach($item_details as $item_detail){
								$Itemledger_qty = $Itemledger_qty+$item_detail->quantity;
								$Itemledger_rate = $Itemledger_rate+($item_detail->quantity*$item_detail->rate);
								$j++;
							}
						}else{ 
							$Itemledger_qty=1;
							$Itemledger_rate=0;
						}
						$per_unit_cost=$Itemledger_rate/$Itemledger_qty;
						$query= $this->SaleReturns->ItemLedgers->query();
						$query->insert(['item_id','quantity' ,'rate', 'in_out','source_model','processed_on','company_id','source_id'])
							  ->values([
											'item_id' => $item_id,
											'quantity' => $saleReturn->sale_return_rows[$i]['quantity'],
											'rate' => $per_unit_cost,
											'source_model' => 'Sale Return',
											'processed_on' => date("Y-m-d",strtotime($saleReturn->transaction_date)),
											'in_out'=>'In',
											'company_id'=>$st_company_id,
											'source_id'=>$saleReturn->id
										])
					    ->execute();
						$i++;
					}
					
					$query = $this->SaleReturns->Invoices->query();
						$query->update()
							->set(['sale_return_status' => 'Yes','sale_return_id'=>$saleReturn->id])
							->where(['id' => $invoice->id])
							->execute();
					
								//Reference Number coding
					if(sizeof(@$ref_rows)>0){
						foreach($ref_rows as $ref_row){ 
							$ref_row=(object)$ref_row;
							
							if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
								$query = $this->SaleReturns->ReferenceBalances->query();
								$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
								->values([
									'ledger_account_id' => $c_LedgerAccount->id,
									'reference_no' => $ref_row->ref_no,
									'credit' => $ref_row->ref_amount,
									'debit' => 0
								]);
								$query->execute();
							}else{ 
								$ReferenceBalance=$this->SaleReturns->ReferenceBalances->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'reference_no'=>$ref_row->ref_no])->first();
								
								$ReferenceBalance=$this->SaleReturns->ReferenceBalances->get($ReferenceBalance->id);
								
								$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
								//pr($ReferenceBalance); exit;
								$this->SaleReturns->ReferenceBalances->save($ReferenceBalance);
							}
							$query = $this->SaleReturns->ReferenceDetails->query();
							$query->insert(['ledger_account_id', 'sale_return_id', 'reference_no', 'credit', 'debit', 'reference_type'])
							->values([
								'ledger_account_id' => $c_LedgerAccount->id,
								'sale_return_id' => $saleReturn->id,
								'reference_no' => $ref_row->ref_no,
								'credit' => $ref_row->ref_amount,
								'debit' => 0,
								'reference_type' => $ref_row->ref_type
							]);
						
							$query->execute();
						}
					}
				
				
				
				/* $flag=0;
				$data=[];
				foreach($saleReturn->sale_return_rows as $sale_return_row){
					$invoice_data=$this->SaleReturns->Invoices->InvoiceRows->find()->where(['invoice_id'=>$saleReturn->invoice_id,
					'item_id'=>$sale_return_row->item_id,
					'inventory_voucher_applicable' => 'Yes'])->first();
					if($invoice_data){
						$flag=1;
						$data[$sale_return_row->item_id]=$sale_return_row->quantity;
					}
				}
				if($flag >0){
						$data=json_encode($data);
						//pr($data); exit;
						$query = $this->SaleReturns->query();
						$query->update()
							->set(['inventory_return_voucher_status'=>'Incomplete'])
							->where(['id' => $saleReturn->id])
							->execute();
						$this->redirect(['controller'=>'Rivs','action' => 'Add/'.$saleReturn->id,$data]);
				}
				else{ */
						$this->Flash->success(__('The sale return has been saved.'));
						return $this->redirect(['action' => 'index']);
				//}
			
               
            } else { //pr($saleReturn); exit;
                $this->Flash->error(__('The sale return could not be saved. Please, try again.'));
            }
        }
		$ledger_account_details = $this->SaleReturns->LedgerAccounts->get($invoice->sales_ledger_account);
		$ledger_account_details_for_fright = $this->SaleReturns->LedgerAccounts->get($invoice->fright_ledger_account);
		$Transporter = $this->SaleReturns->Transporters->get($invoice->transporter_id);
		$Em = new FinancialYearsController;
		$financial_year_data = $Em->checkFinancialYear($invoice->date_created);
		//pr($invoice); exit;
        $customers = $this->SaleReturns->Customers->find('list', ['limit' => 200]);
        $saleTaxes = $this->SaleReturns->SaleTaxes->find('list', ['limit' => 200]);
        $companies = $this->SaleReturns->Companies->find('list', ['limit' => 200]);
        $salesOrders = $this->SaleReturns->SalesOrders->find('list', ['limit' => 200]);
        $employees = $this->SaleReturns->Employees->find('list', ['limit' => 200]);
        $transporters = $this->SaleReturns->Transporters->find('list', ['limit' => 200]);
        $this->set(compact('saleReturn', 'customers', 'saleTaxes', 'companies', 'salesOrders', 'employees', 'transporters','invoice','Transporter','financial_year_data','ledger_account_details','ledger_account_details_for_fright','c_LedgerAccount','chkdate','financial_month_first','financial_month_last'));
        $this->set('_serialize', ['saleReturn']);
    }

	public function inventoryReturn($id = null,$data=null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$sale_return_data=$this->SaleReturns->get($id,[
			'contain'=>['SaleReturnRows'=>['Items']]
		]);
		
		
		$data1=json_decode($data);
		$InventoryVoucherRows=[];
		$inventory_return=[];
		$Item_serial_no=[];
		foreach($data1 as $item_id=>$qty){
				$Item=$this->SaleReturns->Items->get($item_id);
				$inventory_return[$item_id]=['qty'=>$qty,'item_name'=>$Item->name];
				$InventoryVoucherRows[$item_id]=$this->SaleReturns->InventoryVouchers->InventoryVoucherRows->find()->contain(['Items'=>['ItemCompanies'=>function ($q) use($st_company_id) {  return $q
				->where(['ItemCompanies.company_id' => $st_company_id ]); },'ItemSerialNumbers'=>function ($q) use($sale_return_data) {  return $q
				->where(['ItemSerialNumbers.iv_invoice_id' => $sale_return_data->invoice_id ]); }
				
				]])->where(['invoice_id'=>$sale_return_data->invoice_id,'left_item_id'=>$item_id]);
				$Invoice_qty[$item_id]=$this->SaleReturns->InventoryVouchers->InvoiceRows->find()->where(['invoice_id'=>$sale_return_data->invoice_id,'item_id'=>$item_id])->first();
			
			}
			//pr($this->request); exit;
		if ($this->request->is(['patch', 'post', 'put'])) {
			$sale_return_data1 = $this->SaleReturns->patchEntity($sale_return_data, $this->request->data);
			//pr($sale_return_data1->item_ledgers); exit;
			foreach($sale_return_data1->sale_return_rows as $sale_return_row){
			$itemLedger = $this->SaleReturns->ItemLedgers->newEntity();
					$itemLedger->item_id = $sale_return_row->item_id;
					$itemLedger->quantity = $sale_return_row->quantity;
					$itemLedger->source_model = 'Sale Return';
					$itemLedger->source_id = $id;
					$itemLedger->in_out = 'Out';
					$itemLedger->rate = 0;
					$itemLedger->company_id = $st_company_id;
					$itemLedger->processed_on = date("Y-m-d");
					//$this->SaleReturns->ItemLedgers->save($itemLedger);
			}
			
			foreach($sale_return_data1->item_ledgers as $item_ledger){
				$itemLedger = $this->SaleReturns->ItemLedgers->newEntity();
					$itemLedger->item_id = $item_ledger['item_id'];
					$itemLedger->quantity = $item_ledger['quantity'];
					$itemLedger->source_model = 'Sale Return';
					$itemLedger->source_id = $id;
					$itemLedger->in_out = 'In';
					$itemLedger->rate = 0;
					$itemLedger->company_id = $st_company_id;
					$itemLedger->processed_on = date("Y-m-d");
					//$this->SaleReturns->ItemLedgers->save($itemLedger);
			} 
			
			if(!empty($sale_return_data1->item_serial_numbers)){
			$sale_return_data1->item_serial_numbers=array_filter($sale_return_data1->item_serial_numbers);
				foreach($sale_return_data1->item_serial_numbers as $item_serial_number1){
					foreach($item_serial_number1 as $item_serial_number){
					$item_serial_number_data=$this->SaleReturns->SaleReturnRows->ItemSerialNumbers->get($item_serial_number);
					$ItemSerialNumbers = $this->SaleReturns->SaleReturnRows->ItemSerialNumbers->newEntity();
						$ItemSerialNumbers->status='In';
						$ItemSerialNumbers->sale_return_id=$id;
						$ItemSerialNumbers->serial_no=$item_serial_number_data->serial_no;
						$ItemSerialNumbers->item_id=$item_serial_number_data->item_id;
						$ItemSerialNumbers->company_id=$st_company_id;
						$this->SaleReturns->SaleReturnRows->ItemSerialNumbers->save($ItemSerialNumbers);
					} 
				}
			}
			
			$this->Flash->success(__('The Inventory return has been saved.'));
			return $this->redirect(['action' => 'index']);
		 }	
			
		//pr($InventoryVoucherRows); exit;
		$this->set(compact('Invoice_qty','sale_return_data','InventoryVoucherRows','inventory_return','Item_serial_no'));
	}
	
    /**
     * Edit method
     *
     * @param string|null $id Sale Return id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$this->viewBuilder()->layout('index_layout');
        //$saleReturn = $this->SaleReturns->newEntity();
		$invoice_id=@(int)$this->request->query('invoice');
		
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->SaleReturns->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		 
		
		$financial_month_first = $this->SaleReturns->FinancialMonths->find()->where(['financial_year_id'=>$st_year_id,'status'=>'Open'])->first();
		$financial_month_last = $this->SaleReturns->FinancialMonths->find()->where(['financial_year_id'=>$st_year_id,'status'=>'Open'])->last();
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

		 $saleReturn = $this->SaleReturns->get($id);
		 $invoice_id=$saleReturn->invoice_id;
		$invoice= $this->SaleReturns->Invoices->get($invoice_id, [
				'contain' => ['InvoiceRows' => ['Items'=>['ItemSerialNumbers'=>function($q) use($invoice_id){
							return $q->where(['ItemSerialNumbers.Status' => 'Out','ItemSerialNumbers.invoice_id'=>$invoice_id]);
							},'ItemCompanies'=>function($q) use($st_company_id){
							return $q->where(['ItemCompanies.company_id' => $st_company_id]);
							}]],'SaleTaxes','Companies','Customers'=>['CustomerAddress'=> function ($q) {
						return $q
						->where(['CustomerAddress.default_address' => 1]);}],'Employees','SaleTaxes'
					]
			]); 
		
		//pr($invoice->toArray()); exit;
		$transaction_date=$invoice->transaction_date;
		$date_created=$invoice->date_created;
		$c_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Customers','source_id'=>$invoice->customer->id])->first();
		//pr($c_LedgerAccount); exit;
		$ReferenceDetails=$this->SaleReturns->ReferenceDetails->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'sale_return_id'=>$saleReturn->id]);
		 
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $saleReturn = $this->SaleReturns->patchEntity($saleReturn, $this->request->data);
			$ref_rows=@$this->request->data['ref_rows'];
            $saleReturn = $this->SaleReturns->patchEntity($saleReturn, $this->request->data);
			foreach($saleReturn->sale_return_rows as $sale_return_row){  
		
				if($sale_return_row->itm_serial_number){
					$item_serial_no=implode(",",$sale_return_row->itm_serial_number );
					$sale_return_row->itm_serial_number=$item_serial_no;
				}
					
			}
			//pr($sale_return_row->itm_serial_number); exit;
			$saleReturn->date_created=$date_created;
			$saleReturn->invoice_id=$invoice_id;
			$saleReturn->sale_tax_id=$saleReturn->sale_tax_id;
			$saleReturn->edited_on = date("Y-m-d"); 
			$saleReturn->edited_by=$this->viewVars['s_employee_id'];
			$saleReturn->transaction_date=date("Y-m-d",strtotime($saleReturn->transaction_date));   
			//pr($saleReturn); exit;
        if ($this->SaleReturns->save($saleReturn)) {
				$this->SaleReturns->Ledgers->deleteAll(['voucher_id' => $saleReturn->id, 'voucher_source' => 'Sale Return','company_id'=>$st_company_id]);
				$this->SaleReturns->ItemSerialNumbers->deleteAll(['ItemSerialNumbers.sale_return_id' => $saleReturn->id,'ItemSerialNumbers.company_id'=>$st_company_id,'ItemSerialNumbers.invoice_id'=> 0]);
				$this->SaleReturns->ItemLedgers->deleteAll(['source_id' => $saleReturn->id, 'source_model' => 'Sale Return','company_id'=>$st_company_id]);
				
				$query = $this->SaleReturns->Invoices->InvoiceRows->query();
						$query->update()
							->set(['sale_return_quantity'=>0])
							->where(['invoice_id' => $invoice_id])
							->execute();
				$query1 = $this->SaleReturns->ItemSerialNumbers->query();
						$query1->update()
							->set(['sale_return_id'=>0])
							->where(['invoice_id' => $invoice_id])
							->execute();
				
				$c_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Customers','source_id'=>$invoice->customer->id])->first();
				$ledger_grand=$saleReturn->grand_total;
				$ledger = $this->SaleReturns->Ledgers->newEntity();
				$ledger->ledger_account_id = $c_LedgerAccount->id;
				$ledger->debit = 0;
				$ledger->credit =$saleReturn->grand_total;
				$ledger->voucher_id = $saleReturn->id;
				$ledger->voucher_source = 'Sale Return';
				$ledger->company_id = $saleReturn->company_id;
				$ledger->transaction_date = $saleReturn->transaction_date;
				if($ledger_grand>0)
				{
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				
				//Ledger posting for Account Reference
				$ledger_pnf=$saleReturn->total_after_pnf;
				$ledger = $this->SaleReturns->Ledgers->newEntity();
				$ledger->ledger_account_id = $saleReturn->sales_ledger_account;
				$ledger->debit = $saleReturn->total_after_pnf;
				$ledger->credit = 0;
				$ledger->voucher_id = $saleReturn->id;
				$ledger->company_id = $saleReturn->company_id;
				$ledger->transaction_date = $saleReturn->transaction_date;
				$ledger->voucher_source = 'Sale Return';
				if($ledger_pnf>0)
				{
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				
				//Ledger posting for Sale Tax
				
				$ledger_saletax=$saleReturn->sale_tax_amount;
				//pr($saleReturn->st_ledger_account_id); exit;
				$ledger1 = $this->SaleReturns->Ledgers->newEntity();
				$ledger1->ledger_account_id = $saleReturn->st_ledger_account_id;
				$ledger1->debit = $saleReturn->sale_tax_amount;
				$ledger1->credit = 0;
				$ledger1->voucher_id = $saleReturn->id;
				$ledger1->company_id = $saleReturn->company_id;
				$ledger1->transaction_date = $saleReturn->transaction_date;
				$ledger1->voucher_source = 'Sale Return';
				
				if($ledger_saletax > 0)
				{  
					$this->SaleReturns->Ledgers->save($ledger1); 
				}
				//pr($saleReturn->st_ledger_account_id); exit;
				//Ledger posting for Fright Amount
				$ledger_fright= $saleReturn->fright_amount;
				$ledger = $this->SaleReturns->Ledgers->newEntity();
				$ledger->ledger_account_id = $saleReturn->fright_ledger_account;
				$ledger->debit = $saleReturn->fright_amount;
				$ledger->credit =0; 
				$ledger->voucher_id = $saleReturn->id;
				$ledger->company_id = $saleReturn->company_id;
				$ledger->transaction_date = $saleReturn->transaction_date;
				$ledger->voucher_source = 'Sale Return';
				if($ledger_fright >0)
				{
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				
				$discount=$saleReturn->discount;
				$pf=$saleReturn->pnf;
				$exciseDuty=$saleReturn->exceise_duty;
				$sale_tax=$saleReturn->sale_tax_amount;
				$fright=$saleReturn->fright_amount;
				$total_amt=0;
				
				
				/* foreach($saleReturn->sale_return_rows as $sale_return_row){
					$ItemSerialNumbers=$this->SaleReturns->ItemSerialNumbers->find()->where(['sale_return_id'=>$saleReturn->id]);
					foreach($ItemSerialNumbers as $ItemSerialNumber){   
						$query = $this->SaleReturns->SaleReturnRows->ItemSerialNumbers->query();
								$query->update()
									->set(['status' => 'Out','sale_return_id'=>0])
									->where(['id' => $ItemSerialNumber->id,'invoice_id' => $invoice->id])
									->execute();
					
					}
				} */
				foreach($saleReturn->sale_return_rows as $sale_return_row){ 
				//pr(sizeof($sale_return_row->itm_serial_number)); exit; 
					if(sizeof($sale_return_row->itm_serial_number) > 0){ 
						$item_serial_no=$sale_return_row->itm_serial_number;
						if($item_serial_no){
						$serial_no=explode(",",$item_serial_no);
						//pr($serial_no); exit;
						foreach($serial_no as $item_serial_number){
						//pr($saleReturn->id);	exit;
							$query = $this->SaleReturns->SaleReturnRows->ItemSerialNumbers->query();
							$query->update()
							->set(['sale_return_id'=>$saleReturn->id])
							->where(['id' => $item_serial_number])
							->execute();
							
						$item_serial_number_data=$this->SaleReturns->SaleReturnRows->ItemSerialNumbers->get($item_serial_number);
						$ItemSerialNumbers = $this->SaleReturns->SaleReturnRows->ItemSerialNumbers->newEntity();
							$ItemSerialNumbers->status='In';
							$ItemSerialNumbers->sale_return_id=$id;
							$ItemSerialNumbers->serial_no=$item_serial_number_data->serial_no;
							$ItemSerialNumbers->item_id=$item_serial_number_data->item_id;
							$ItemSerialNumbers->company_id=$st_company_id;
							$this->SaleReturns->SaleReturnRows->ItemSerialNumbers->save($ItemSerialNumbers);
						}
					}
					}
				}
				
				//exit;
			
				foreach($saleReturn->sale_return_rows as $sale_return_row){ 
					$query = $this->SaleReturns->Invoices->InvoiceRows->query();
						$query->update()
							->set(['sale_return_quantity'=>$sale_return_row->quantity])
							->where(['invoice_id' => $saleReturn->invoice_id,'item_id'=>$sale_return_row->item_id])
							->execute();
					}
				
					$i=0; 
					$processed_on = date("Y-m-d",strtotime($invoice->date_created));
					foreach($saleReturn->sale_return_rows as $sale_return_row){
						$item_details=$this->SaleReturns->ItemLedgers->find()->where(['item_id'=>$sale_return_row->item_id,'in_out'=>'In','processed_on <='=>$processed_on,'rate >'=>0,'quantity >'=>0]);
						
						//pr($processed_on); exit;
						//pr($item_details->toArray()); exit;
						$ledger_data=$item_details->count();
						$Itemledger_qty=0;
						$Itemledger_rate=0;
						if($ledger_data>0){ 
							$j=0; $qty_total=0; $total_amount=0;
							foreach($item_details as $item_detail){
								$Itemledger_qty = $Itemledger_qty+$item_detail->quantity;
								$Itemledger_rate = $Itemledger_rate+($item_detail->quantity*$item_detail->rate);
								$j++;
						}
						}else{ 
							$Itemledger_qty=1;
							$Itemledger_rate=0;
						}
						
						$per_unit_cost=$Itemledger_rate/$Itemledger_qty;
						
						$query= $this->SaleReturns->ItemLedgers->query();
						$query->insert(['item_id','quantity' ,'rate', 'in_out','source_model','processed_on','company_id','source_id'])
							  ->values([
											'item_id' => $sale_return_row->item_id,
											'quantity' => $sale_return_row->quantity,
											'rate' => $per_unit_cost,
											'source_model' => 'Sale Return',
											'processed_on' => date("Y-m-d",strtotime($saleReturn->transaction_date)),
											'in_out'=>'In',
											'company_id'=>$st_company_id,
											'source_id'=>$saleReturn->id
										])
					    ->execute();
						$i++;
						/* 
						
						
						//$item_id=$sale_return_row;
						$item_detail=$this->SaleReturns->ItemLedgers->find()->where(['item_id'=>$sale_return_row->item_id,'source_model != '=>'Invoices'])->first();
						//pr($item_detail); exit;
						$itemLedger = $this->SaleReturns->ItemLedgers->newEntity();
						$itemLedger->item_id = $sale_return_row->item_id;
						$itemLedger->quantity = $sale_return_row->quantity;
						$itemLedger->source_model = 'Sale Return';
						$itemLedger->source_id = $saleReturn->id;
						$itemLedger->in_out = 'In';if(!$item_detail){
							$itemLedger->rate = 0;
						}else{
							$itemLedger->rate = $item_detail->rate;
						}
						$itemLedger->company_id = $saleReturn->company_id;
						$itemLedger->processed_on = $saleReturn->transaction_date;
						$this->SaleReturns->ItemLedgers->save($itemLedger);
						$i++; */
					}
					
					$query = $this->SaleReturns->Invoices->query();
						$query->update()
							->set(['sale_return_status' => 'Yes','sale_return_id'=>$saleReturn->id])
							->where(['id' => $saleReturn->invoice_id])
							->execute();
					
					if(sizeof(@$ref_rows)>0){
						foreach($ref_rows as $ref_row){
							$ref_row=(object)$ref_row;
							$ReferenceDetail=$this->SaleReturns->ReferenceDetails->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'reference_no'=>$ref_row->ref_no,'sale_return_id'=>$saleReturn->id])->first();
							
							if($ReferenceDetail){ //pr($ref_row->ref_old_amount); exit;
								$ReferenceBalance=$this->SaleReturns->ReferenceBalances->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'reference_no'=>$ref_row->ref_no])->first();
								$ReferenceBalance=$this->SaleReturns->ReferenceBalances->get($ReferenceBalance->id);
								$ReferenceBalance->credit=$ReferenceBalance->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								$this->SaleReturns->ReferenceBalances->save($ReferenceBalance);
								
								$ReferenceDetail=$this->SaleReturns->ReferenceDetails->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'reference_no'=>$ref_row->ref_no,'sale_return_id'=>$saleReturn->id])->first();
								
								$ReferenceDetail=$this->SaleReturns->ReferenceDetails->get($ReferenceDetail->id);
								$ReferenceDetail->credit=$ReferenceDetail->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								$this->SaleReturns->ReferenceDetails->save($ReferenceDetail);
							}else{
								if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
									$query = $this->SaleReturns->ReferenceBalances->query();
									$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
									->values([
										'ledger_account_id' => $c_LedgerAccount->id,
										'reference_no' => $ref_row->ref_no,
										'credit' => $ref_row->ref_amount,
										'debit' => 0
									])
									->execute();
									
								}else{
									$ReferenceBalance=$this->SaleReturns->ReferenceBalances->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'reference_no'=>$ref_row->ref_no])->first();
									$ReferenceBalance=$this->SaleReturns->ReferenceBalances->get($ReferenceBalance->id);
									$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
									
									$this->SaleReturns->ReferenceBalances->save($ReferenceBalance);
								}
								

								$query = $this->SaleReturns->ReferenceDetails->query();
								$query->insert(['ledger_account_id', 'sale_return_id', 'reference_no', 'credit', 'debit', 'reference_type'])
								->values([
									'ledger_account_id' => $c_LedgerAccount->id,
									'sale_return_id' => $saleReturn->id,
									'reference_no' => $ref_row->ref_no,
									'credit' => $ref_row->ref_amount,
									'debit' => 0,
									'reference_type' => $ref_row->ref_type
								])
								->execute();
								
							}
						}
					}
					
				
                $this->Flash->success(__('The sale return has been saved.'));

                return $this->redirect(['action' => 'index']);

            } else { 
                $this->Flash->error(__('The sale return could not be saved. Please, try again.'));
            }
        }
		//pr($invoice->id); exit;
		/* foreach($invoice->sale_return->sale_return_rows as $sale_return_row){
			if($sale_return_row->item_serial_number){
			@$ItemSerialNumber_In[$sale_return_row->item_id]= explode(",",$sale_return_row->item_serial_number);
			$ItemSerialNumber[$sale_return_row->item_id]=$this->SaleReturns->SaleReturnRows->ItemSerialNumbers->find()->where(['item_id'=>$sale_return_row->item_id,'status'=>'In','company_id'=>$st_company_id,'ItemSerialNumbers.invoice_id'=>$invoice->id])->orWhere(['ItemSerialNumbers.invoice_id'=>$invoice->id,'item_id'=>$sale_return_row->item_id,'status'=>'Out','company_id'=>$st_company_id])->toArray();
			}
				
		} */
		//pr($ItemSerialNumber); exit;
		
		$ledger_account_details = $this->SaleReturns->LedgerAccounts->get($saleReturn->sales_ledger_account);
		$ledger_account_details_for_fright = $this->SaleReturns->LedgerAccounts->get($saleReturn->fright_ledger_account);
		//$Transporter = $this->SaleReturns->Transporters->get($saleReturn->transporter_id);
		$Em = new FinancialYearsController;
		$financial_year_data = $Em->checkFinancialYear($saleReturn->date_created);
        $customers = $this->SaleReturns->Customers->find('list', ['limit' => 200]);
        $saleTaxes = $this->SaleReturns->SaleTaxes->find('list', ['limit' => 200]);
        $companies = $this->SaleReturns->Companies->find('list', ['limit' => 200]);
        $salesOrders = $this->SaleReturns->SalesOrders->find('list', ['limit' => 200]);
        $employees = $this->SaleReturns->Employees->find('list', ['limit' => 200]);
        $transporters = $this->SaleReturns->Transporters->find('list', ['limit' => 200]);
        //$stLedgerAccounts = $this->SaleReturns->StLedgerAccounts->find('list', ['limit' => 200]);
        $this->set(compact('saleReturn','ledger_account_details','ledger_account_details_for_fright','Transporter', 'financial_year_data','customers', 'saleTaxes', 'companies', 'salesOrders', 'employees', 'transporters', 'stLedgerAccounts','invoice','ItemSerialNumber','ReferenceDetails','c_LedgerAccount','chkdate','financial_month_first','financial_month_last'));
        $this->set('_serialize', ['saleReturn']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sale Return id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $saleReturn = $this->SaleReturns->get($id);
        if ($this->SaleReturns->delete($saleReturn)) {
            $this->Flash->success(__('The sale return has been deleted.'));
        } else {
            $this->Flash->error(__('The sale return could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	function checkRefNumberUnique($received_from_id,$i){
		$reference_no=$this->request->query['ref_rows'][$i]['ref_no'];
		$ReferenceBalances=$this->SaleReturns->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
		if($ReferenceBalances->count()==0){
			echo 'true';
		}else{
			echo 'false';
		}
		exit;
	}
	function checkRefNumberUniqueEdit($received_from_id,$i,$is_old){ 
	
		$reference_no=$this->request->query['ref_rows'][$i]['ref_no'];
		//pr($reference_no);exit;
		$ReferenceBalances=$this->SaleReturns->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id,'reference_no'=>$reference_no]);
		
		if($ReferenceBalances->count()==1 && $is_old=="yes"){
			echo 'true';
		}elseif($ReferenceBalances->count()==0){
			echo 'true';
		}else{
			echo 'false';
		}
		exit;
	}
	public function fetchRefNumbers($ledger_account_id){
		$this->viewBuilder()->layout('');
		$ReferenceBalances=$this->SaleReturns->ReferenceBalances->find()->where(['ledger_account_id'=>$ledger_account_id]);
		$this->set(compact('ReferenceBalances','cr_dr'));
	}
	public function fetchRefNumbersEdit($received_from_id=null,$reference_no=null,$credit=null){
		$this->viewBuilder()->layout('');
		$ReferenceBalances=$this->SaleReturns->ReferenceBalances->find()->where(['ledger_account_id'=>$received_from_id]);
		$this->set(compact('ReferenceBalances', 'reference_no', 'credit'));
	}
	function deleteOneRefNumbers(){
		$old_received_from_id=$this->request->query['old_received_from_id'];
		$sale_return_id=$this->request->query['sale_return_id'];
		$old_ref=$this->request->query['old_ref'];
		$old_ref_type=$this->request->query['old_ref_type'];
		//pr($old_ref_type); exit;
		if($old_ref_type=="New Reference" || $old_ref_type=="Advance Reference"){
			$this->SaleReturns->ReferenceBalances->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
			$this->SaleReturns->ReferenceDetails->deleteAll(['ledger_account_id'=>$old_received_from_id,'reference_no'=>$old_ref]);
		}elseif($old_ref_type=="Against Reference"){
			$ReferenceDetail=$this->SaleReturns->ReferenceDetails->find()->where(['ledger_account_id'=>$old_received_from_id,'sale_return_id'=>$sale_return_id,'reference_no'=>$old_ref])->first();
			if(!empty($ReferenceDetail->credit)){
				$ReferenceBalance=$this->SaleReturns->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
				$ReferenceBalance=$this->SaleReturns->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->credit=$ReferenceBalance->credit-$ReferenceDetail->credit;
				$this->SaleReturns->ReferenceBalances->save($ReferenceBalance);
			}elseif(!empty($ReferenceDetail->debit)){
				$ReferenceBalance=$this->SaleReturns->ReferenceBalances->find()->where(['ledger_account_id' => $ReferenceDetail->ledger_account_id, 'reference_no' => $ReferenceDetail->reference_no])->first();
				$ReferenceBalance=$this->SaleReturns->ReferenceBalances->get($ReferenceBalance->id);
				$ReferenceBalance->debit=$ReferenceBalance->debit-$ReferenceDetail->debit;
				$this->SaleReturns->ReferenceBalances->save($ReferenceBalance);
			}
			$RDetail=$this->SaleReturns->ReferenceDetails->get($ReferenceDetail->id);
			$this->SaleReturns->ReferenceDetails->delete($RDetail);
		}
		
		exit;
	}
	
	public function exportSaleExcel(){
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		$this->set(compact('From','To'));
		$where=[];
		$where=[];
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['SaleReturns.date_created >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['SaleReturns.date_created <=']=$To;
		}
		$this->viewBuilder()->layout('');
		$SaleReturns = $this->SaleReturns->find()->where($where)->contain(['SaleReturnRows','Customers'])->order(['SaleReturns.id' => 'DESC'])->where(['SaleReturns.company_id'=>$st_company_id,'sale_return_type'=>'Non-GST']);
		//pr($invoices->toArray()); exit;
		$this->set(compact('SaleReturns','From','To'));
	}
	
	public function salesReturnReport(){
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		$this->set(compact('From','To'));
		$where=[];
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['SaleReturns.date_created >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['SaleReturns.date_created <=']=$To;
		}
		$SaleReturns = $this->SaleReturns->find()->where($where)->contain(['SaleReturnRows','Customers'])->order(['SaleReturns.id' => 'DESC'])->where(['SaleReturns.company_id'=>$st_company_id,'sale_return_type'=>'Non-GST']);
		//pr($invoices->toArray()); exit;
		$this->set(compact('SaleReturns','url'));
	}
	public function GstSalesAdd(){
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$invoice_id=@(int)$this->request->query('invoice');
		
		if(!empty($invoice_id)){
			$invoice = $this->SaleReturns->Invoices->get($invoice_id, [
				'contain' => ['InvoiceRows.Items' => function ($q) use($invoice_id,$st_company_id) {
						   return $q
								->where(['InvoiceRows.quantity > InvoiceRows.sale_return_quantity'])
								->contain(['ItemSerialNumbers'=>function($q) use($invoice_id,$st_company_id){
									return $q->where(['ItemSerialNumbers.status' => 'Out','ItemSerialNumbers.company_id' => $st_company_id,'ItemSerialNumbers.invoice_id'=>$invoice_id]); 
								},
								'ItemCompanies'=>function($q) use($st_company_id){
									return $q->where(['ItemCompanies.company_id' => $st_company_id]);
								}]);
						},'Companies','Customers'=>['Districts'],'Employees'
					]
			]);
			$c_LedgerAccount=$this->SaleReturns->Invoices->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Customers','source_id'=>$invoice->customer->id])->first();
		}
			$st_year_id = $session->read('st_year_id');
			   $SessionCheckDate = $this->SaleReturns->FinancialYears->get($st_year_id);
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
			
			$saleReturn = $this->SaleReturns->newEntity();
		  if ($this->request->is('post')) {
			 $data=$this->request->data; 
			$saleReturn = $this->SaleReturns->patchEntity($saleReturn, $this->request->data);
			
			$itm_serial_number_data=[];
			foreach($data['sale_return_rows'] as $sale_return_row){
				if(sizeof(@$sale_return_row['itm_serial_number']) > 0){
					$item_serial_no=implode(",",$sale_return_row['itm_serial_number'] );
					$itm_serial_number_data[$sale_return_row['item_id']]=$item_serial_no;
				}
			} 
			
			//pr($itm_serial_number_data); exit;
			$last_in_no=$this->SaleReturns->find()->select(['sr2'])->where(['company_id' => $invoice->company_id])->order(['sr2' => 'DESC'])->first();
			if($last_in_no){
				$saleReturn->sr2=$last_in_no->sr2+1;
			}else{
				$saleReturn->sr2=1;
			}
			
			$saleReturn->sr1=$invoice->in1;
			$saleReturn->sr3=$invoice->in3;
			$saleReturn->sr4=$invoice->in4;
			$saleReturn->created_by=$s_employee_id;
			$saleReturn->company_id=$invoice->company_id;
			$saleReturn->invoice_id=$invoice->id;
			$saleReturn->employee_id=$s_employee_id;
			$saleReturn->customer_id=$invoice->customer_id;
			$saleReturn->customer_po_no=$invoice->customer_po_no;
			$saleReturn->po_date=date("Y-m-d",strtotime($invoice->po_date)); 
			$saleReturn->date_created=date("Y-m-d");
			$saleReturn->invoice_type='GST';
			$saleReturn->total_after_pnf=$saleReturn->total_taxable_value;
			$saleReturn->sales_ledger_account=$saleReturn->sales_ledger_account;
			$saleReturn->sale_return_type="GST";
			$saleReturn->sale_return_status="Yes";
			$saleReturn->transaction_date=date("Y-m-d",strtotime($saleReturn->transaction_date)); 
			
		

			$ref_rows=@$saleReturn->ref_rows;
			if ($this->SaleReturns->save($saleReturn)) {
				
				//GET CUSTOMER LEDGER-ACCOUNT-ID
				$c_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Customers','source_id'=>$invoice->customer->id])->first();
				
				$ledger_grand=$saleReturn->grand_total;
				$ledger = $this->SaleReturns->Ledgers->newEntity();
				$ledger->ledger_account_id = $c_LedgerAccount->id;
				$ledger->credit = $saleReturn->grand_total;
				$ledger->debit = 0;
				$ledger->voucher_id = $saleReturn->id;
				$ledger->voucher_source = 'Sale Return';
				$ledger->company_id = $saleReturn->company_id;
				$ledger->transaction_date = $saleReturn->transaction_date;
				$this->SaleReturns->Ledgers->save($ledger); 
				
			foreach($saleReturn->sale_return_rows as $sale_return_row){
				if($sale_return_row->cgst_amount > 0){
					$cg_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'SaleTaxes','source_id'=>$sale_return_row->cgst_percentage])->first();
					$ledger = $this->SaleReturns->Ledgers->newEntity();
					$ledger->ledger_account_id = $cg_LedgerAccount->id;
					$ledger->credit = 0;
					$ledger->debit = $sale_return_row->cgst_amount;
					$ledger->voucher_id = $saleReturn->id;
					$ledger->voucher_source = 'Sale Return';
					$ledger->company_id = $invoice->company_id;
					$ledger->transaction_date = $saleReturn->transaction_date;
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				if($sale_return_row->sgst_amount > 0){
					$s_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'SaleTaxes','source_id'=>$sale_return_row->sgst_percentage])->first();
					$ledger = $this->SaleReturns->Ledgers->newEntity();
					$ledger->ledger_account_id = $s_LedgerAccount->id;
					$ledger->credit = 0;
					$ledger->debit = $sale_return_row->sgst_amount;
					$ledger->voucher_id = $saleReturn->id;
					$ledger->voucher_source = 'Sale Return';
					$ledger->company_id = $invoice->company_id;
					$ledger->transaction_date = $saleReturn->transaction_date;
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				if($sale_return_row->igst_amount > 0){
					$i_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'SaleTaxes','source_id'=>$sale_return_row->igst_percentage])->first();
					$ledger = $this->SaleReturns->Ledgers->newEntity();
					$ledger->ledger_account_id = $i_LedgerAccount->id;
					$ledger->credit = 0;
					$ledger->debit = $sale_return_row->igst_amount;
					$ledger->voucher_id = $saleReturn->id;
					$ledger->voucher_source = 'Sale Return';
					$ledger->company_id = $invoice->company_id;
					$ledger->transaction_date = $saleReturn->transaction_date;
					$this->SaleReturns->Ledgers->save($ledger); 
				}
			}
				
				//Ledger posting for Account Reference
				//$ledger_pnf=$invoice->total_after_pnf;
				//$accountReferences=$this->Invoices->AccountReferences->get(1);
				$ledger_fright=@(int)$saleReturn->fright_amount;
				//pr($ledger_fright); exit;
				$ledger = $this->SaleReturns->Ledgers->newEntity();
				$ledger->ledger_account_id = $saleReturn->sales_ledger_account;
				$ledger->debit = $saleReturn->total+$ledger_fright;
				$ledger->credit = 0;
				$ledger->voucher_id = $saleReturn->id;
				$ledger->company_id = $saleReturn->company_id;
				$ledger->transaction_date = $saleReturn->transaction_date;
				$ledger->voucher_source = 'Sale Return';
				$this->SaleReturns->Ledgers->save($ledger); 
				
				if(sizeof($itm_serial_number_data) > 0){
				foreach($saleReturn->sale_return_rows as $sale_return_row){
					if($itm_serial_number_data[$sale_return_row->item_id] > 0){
						$query = $this->SaleReturns->SaleReturnRows->query();
						$query->update()
							->set(['itm_serial_number'=>$itm_serial_number_data[$sale_return_row->item_id]])
							->where(['sale_return_id' => $saleReturn->id,'item_id'=>$sale_return_row->item_id])
							->execute();
						
					$serial_no=explode(",",$itm_serial_number_data[$sale_return_row->item_id]);
					foreach($serial_no as $serial){
						
						$query = $this->SaleReturns->SaleReturnRows->ItemSerialNumbers->query();
						$query->update()
							->set(['sale_return_id'=>$saleReturn->id])
							->where(['id' => $serial])
							->execute();
						
						$ItemSerialNumber_data = $this->SaleReturns->SaleReturnRows->ItemSerialNumbers->get($serial);
						$ItemSerialNumber = $this->SaleReturns->SaleReturnRows->ItemSerialNumbers->newEntity();
						$ItemSerialNumber->sale_return_id=$saleReturn->id;
						$ItemSerialNumber->status='In';
						$ItemSerialNumber->item_id=$ItemSerialNumber_data->item_id;
						$ItemSerialNumber->company_id=$ItemSerialNumber_data->company_id;
						$ItemSerialNumber->serial_no=$ItemSerialNumber_data->serial_no;
						$this->SaleReturns->SaleReturnRows->ItemSerialNumbers->save($ItemSerialNumber); 
						
					}
				}
			}
			}
			$Invoice_data = $this->SaleReturns->Invoices->get($invoice->id);
			$Invoice_data->sale_return_id=$saleReturn->id;
			$this->SaleReturns->Invoices->save($Invoice_data);
				
			foreach($saleReturn->sale_return_rows as $sale_return_row){
				$saleReturn->check=array_filter($saleReturn->check);
					foreach($saleReturn->check as $invoice_row_id){
						//pr($invoice_row_id); 
						$item_id=$sale_return_row['item_id'];
						$qty=$sale_return_row['quantity'];
						$rate=$sale_return_row['rate'];
						$amount=$sale_return_row['amount'];
						$itemLedgers = $this->SaleReturns->ItemLedgers->find()->where(['item_id'=>$item_id,'in_out'=>'In','company_id' => $st_company_id,'processed_on <=' =>$saleReturn->transaction_date,'rate > '=>0,'quantity > '=>0]);
				
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
										
						$InvoiceRows = $this->SaleReturns->Invoices->InvoiceRows->get($invoice_row_id);
						$InvoiceRows->sale_return_quantity=$InvoiceRows->sale_return_quantity+$qty;
						$this->SaleReturns->Invoices->InvoiceRows->save($InvoiceRows);

						//Insert in Item Ledger//
						$itemLedger = $this->SaleReturns->ItemLedgers->newEntity();
						$itemLedger->item_id = $item_id;
						$itemLedger->quantity = $qty;
						$itemLedger->source_model = 'Sale Return';
						$itemLedger->source_id = $saleReturn->id;
						$itemLedger->in_out = 'In';
						$itemLedger->rate = $toupdate_rate;
						$itemLedger->company_id = $invoice->company_id;
						$itemLedger->processed_on =$saleReturn->transaction_date;   
						$this->SaleReturns->ItemLedgers->save($itemLedger);
					}
				}
				
				if($saleReturn->fright_cgst_amount > 0){
					$cg_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'SaleTaxes','source_id'=>$saleReturn->fright_cgst_percent])->first();
					$ledger = $this->SaleReturns->Ledgers->newEntity();
					$ledger->ledger_account_id = $cg_LedgerAccount->id;
					$ledger->credit = 0;
					$ledger->debit = $saleReturn->fright_cgst_amount;
					$ledger->voucher_id = $saleReturn->id;
					$ledger->voucher_source = 'Sale Return';
					$ledger->company_id = $saleReturn->company_id;
					$ledger->transaction_date = $saleReturn->transaction_date;
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				if($saleReturn->fright_sgst_amount > 0){
					$s_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'SaleTaxes','source_id'=>$saleReturn->fright_sgst_percent])->first();
					$ledger = $this->SaleReturns->Ledgers->newEntity();
					$ledger->ledger_account_id = $s_LedgerAccount->id;
					$ledger->credit = 0;
					$ledger->debit =$saleReturn->fright_sgst_amount;
					$ledger->voucher_id = $saleReturn->id;
					$ledger->voucher_source = 'Sale Return';
					$ledger->company_id = $saleReturn->company_id;
					$ledger->transaction_date = $saleReturn->transaction_date;
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				if($saleReturn->fright_igst_amount > 0){
					$i_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'SaleTaxes','source_id'=>$saleReturn->fright_igst_percent])->first();
					$ledger = $this->SaleReturns->Ledgers->newEntity();
					$ledger->ledger_account_id = $i_LedgerAccount->id;
					$ledger->credit = 0;
					$ledger->debit = $saleReturn->fright_igst_amount;
					$ledger->voucher_id = $saleReturn->id;
					$ledger->voucher_source = 'Sale Return';
					$ledger->company_id = $saleReturn->company_id;
					$ledger->transaction_date = $saleReturn->transaction_date;
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				//Reference Number coding
				
				/* 	if(sizeof(@$ref_rows)== 0){
						//$ref_row->ref_no='i'.$invoice->in2;
						$query = $this->Invoices->ReferenceBalances->query();
								$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
								->values([
									'ledger_account_id' => $c_LedgerAccount->id,
									'reference_no' => 'i'.$invoice->in2,
									'credit' => 0,
									'debit' => $invoice->grand_total
								]);
								$query->execute();
								
						$query = $this->Invoices->ReferenceDetails->query();
							$query->insert(['ledger_account_id', 'invoice_id', 'reference_no', 'credit', 'debit', 'reference_type'])
							->values([
								'ledger_account_id' => $c_LedgerAccount->id,
								'invoice_id' => $invoice->id,
								'reference_no' => 'i'.$invoice->in2,
								'credit' => 0,
								'debit' => $invoice->grand_total,
								'reference_type' => 'New Reference'
							]);
							
								$query->execute();
						
					}else  */
						
					if(sizeof(@$ref_rows)>0){ 
			
						foreach($ref_rows as $ref_row){  	
							$ref_row=(object)$ref_row; 
							
							if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
								$query = $this->SaleReturns->ReferenceBalances->query();
								$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
								->values([
									'ledger_account_id' => $c_LedgerAccount->id,
									'reference_no' => $ref_row->ref_no,
									'credit' => $ref_row->ref_amount,
									'debit' => 0
								]);
								$query->execute();
								
							}else{
								$ReferenceBalance=$this->SaleReturns->ReferenceBalances->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'reference_no'=>$ref_row->ref_no])->first();
								$ReferenceBalance=$this->SaleReturns->ReferenceBalances->get($ReferenceBalance->id);
								$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
								$this->SaleReturns->ReferenceBalances->save($ReferenceBalance);
							}
							
							$query = $this->SaleReturns->ReferenceDetails->query(); 
							$query->insert(['ledger_account_id', 'sale_return_id', 'reference_no', 'credit', 'debit', 'reference_type'])
							->values([
								'ledger_account_id' => $c_LedgerAccount->id,
								'sale_return_id' => $saleReturn->id,
								'reference_no' => $ref_row->ref_no,
								'credit' => $ref_row->ref_amount,
								'debit' => 0,
								'reference_type' => $ref_row->ref_type
							]);
							
								$query->execute();
						} 
					}
			
                $this->Flash->success(__('The invoice has been saved.'));

                return $this->redirect(['action' => 'Index']);
            } else { 
                $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
            }
        }
				
		
		
		//pr($invoice->toArray()); exit;
		$GstTaxes = $this->SaleReturns->Invoices->SaleTaxes->find()->where(['SaleTaxes.account_second_subgroup_id'=>5])->matching(
					'SaleTaxCompanies', function ($q) use($st_company_id) {
						return $q->where(['SaleTaxCompanies.company_id' => $st_company_id]);
					} 
				);
		
		$AccountReference_for_sale= $this->SaleReturns->Invoices->AccountReferences->get(1);
		$account_first_subgroup_id=$AccountReference_for_sale->account_first_subgroup_id;
		$ledger_account_details = $this->SaleReturns->Invoices->LedgerAccounts->find('list')->contain(['AccountSecondSubgroups'=>['AccountFirstSubgroups' => function($q) use($account_first_subgroup_id){
			return $q->where(['AccountFirstSubgroups.id'=>$account_first_subgroup_id]);
		}]])->order(['LedgerAccounts.name' => 'ASC'])->where(['LedgerAccounts.company_id'=>$st_company_id]);
		
		$AccountReference_for_fright= $this->SaleReturns->Invoices->AccountReferences->get(3);
		$account_first_subgroup_id_for_fright=$AccountReference_for_fright->account_first_subgroup_id;
		$ledger_account_details_for_fright = $this->SaleReturns->Invoices->LedgerAccounts->find('list')->contain(['AccountSecondSubgroups'=>['AccountFirstSubgroups' => function($q) use($account_first_subgroup_id_for_fright){
			return $q->where(['AccountFirstSubgroups.id'=>$account_first_subgroup_id_for_fright]);
		}]])->order(['LedgerAccounts.name' => 'ASC'])->where(['LedgerAccounts.company_id'=>$st_company_id]);
		
		
		$transporters = $this->SaleReturns->Invoices->Transporters->find('list');
		
		 $this->set(compact('invoice','ledger_account_details','transporters','GstTaxes','ledger_account_details_for_fright','c_LedgerAccount','chkdate','saleReturn'));
	}
	public function gstSalesEdit($id=null)
	{
		
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$saleReturn = $this->SaleReturns->get($id, [
				'contain' => ['Customers']]);
				
		$invoice = $this->SaleReturns->Invoices->get($saleReturn->invoice_id, [
				'contain' => ['InvoiceRows.Items' => function ($q) use($st_company_id,$saleReturn) {
						   return $q
								->contain(['ItemSerialNumbers'=>function($q) use($st_company_id,$saleReturn){
									return $q->where(['ItemSerialNumbers.status' => 'Out','ItemSerialNumbers.company_id' => $st_company_id,'ItemSerialNumbers.invoice_id'=>$saleReturn->invoice_id]); 
								},
								'ItemCompanies'=>function($q) use($st_company_id){
									return $q->where(['ItemCompanies.company_id' => $st_company_id]);
								}]);
						},'Companies','Customers'=>['Districts'],'Employees'
					]
			]);
	
		$c_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Customers','source_id'=>$saleReturn->customer->id])->first();
		
		$ReferenceDetails=$this->SaleReturns->ReferenceDetails->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'sale_return_id'=>$id]);
			
		$st_year_id = $session->read('st_year_id');
			   $SessionCheckDate = $this->SaleReturns->FinancialYears->get($st_year_id);
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
		//pr($Invoice); exit;
		 if ($this->request->is('put')) { 
			$data=$this->request->data();
			$saleReturn = @$this->SaleReturns->patchEntity($saleReturn, $this->request->data);
			//pr($data); exit;
			$itm_serial_number_data=[];
			foreach($data['sale_return_rows'] as $sale_return_row){
				if(sizeof(@$sale_return_row['itm_serial_number']) > 0){
					$item_serial_no=implode(",",$sale_return_row['itm_serial_number'] );
					$itm_serial_number_data[$sale_return_row['item_id']]=$item_serial_no;
				}
			} 		
			
			//pr($itm_serial_number_data); exit;
			$saleReturn->sr1=$saleReturn->sr1;
			$saleReturn->sr2=$saleReturn->sr2;
			$saleReturn->sr3=$saleReturn->sr3;
			$saleReturn->sr4=$saleReturn->sr4;
			$saleReturn->created_by=$s_employee_id;
			$saleReturn->company_id=$invoice->company_id;
			$saleReturn->invoice_id=$invoice->id;
			$saleReturn->employee_id=$s_employee_id;
			$saleReturn->customer_id=$invoice->customer_id;
			$saleReturn->customer_po_no=$invoice->customer_po_no;
			$saleReturn->po_date=date("Y-m-d",strtotime($invoice->po_date)); 
			$saleReturn->date_created=date("Y-m-d");
			$saleReturn->invoice_type='GST';
			$saleReturn->total_after_pnf=$saleReturn->total_taxable_value;
			$saleReturn->sales_ledger_account=$saleReturn->sales_ledger_account;
			$saleReturn->sale_return_type="GST";
			$saleReturn->sale_return_status="Yes";
			$saleReturn->transaction_date=date("Y-m-d",strtotime($saleReturn->transaction_date)); 
			
		//pr($saleReturn); exit;

			$ref_rows=@$saleReturn->ref_rows;
			if ($this->SaleReturns->save($saleReturn)) {
				
				$this->SaleReturns->Ledgers->deleteAll(['voucher_id' => $saleReturn->id, 'voucher_source' => 'Sale Return','company_id'=>$st_company_id]);
				$this->SaleReturns->ItemSerialNumbers->deleteAll(['ItemSerialNumbers.sale_return_id' => $saleReturn->id,'ItemSerialNumbers.company_id'=>$st_company_id,'ItemSerialNumbers.invoice_id'=>0]);
				$this->SaleReturns->ItemLedgers->deleteAll(['source_id' => $saleReturn->id, 'source_model' => 'Sale Return','company_id'=>$st_company_id]);
				
				$query = $this->SaleReturns->Invoices->InvoiceRows->query();
						$query->update()
							->set(['sale_return_quantity'=>0])
							->where(['invoice_id' => $invoice->id])
							->execute();
				$query1 = $this->SaleReturns->ItemSerialNumbers->query();
						$query1->update()
							->set(['sale_return_id'=>0])
							->where(['invoice_id' => $invoice->id])
							->execute();
				//exit;
				//GET CUSTOMER LEDGER-ACCOUNT-ID
				$c_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'Customers','source_id'=>$invoice->customer->id])->first();
				
				$ledger_grand=$saleReturn->grand_total;
				$ledger = $this->SaleReturns->Ledgers->newEntity();
				$ledger->ledger_account_id = $c_LedgerAccount->id;
				$ledger->credit = $saleReturn->grand_total;
				$ledger->debit = 0;
				$ledger->voucher_id = $saleReturn->id;
				$ledger->voucher_source = 'Sale Return';
				$ledger->company_id = $saleReturn->company_id;
				$ledger->transaction_date = $saleReturn->transaction_date;
				$this->SaleReturns->Ledgers->save($ledger); 
				
			foreach($saleReturn->sale_return_rows as $sale_return_row){
				if($sale_return_row->cgst_amount > 0){
					$cg_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'SaleTaxes','source_id'=>$sale_return_row->cgst_percentage])->first();
					$ledger = $this->SaleReturns->Ledgers->newEntity();
					$ledger->ledger_account_id = $cg_LedgerAccount->id;
					$ledger->credit = 0;
					$ledger->debit = $sale_return_row->cgst_amount;
					$ledger->voucher_id = $saleReturn->id;
					$ledger->voucher_source = 'Sale Return';
					$ledger->company_id = $invoice->company_id;
					$ledger->transaction_date = $saleReturn->transaction_date;
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				if($sale_return_row->sgst_amount > 0){
					$s_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'SaleTaxes','source_id'=>$sale_return_row->sgst_percentage])->first();
					$ledger = $this->SaleReturns->Ledgers->newEntity();
					$ledger->ledger_account_id = $s_LedgerAccount->id;
					$ledger->credit = 0;
					$ledger->debit = $sale_return_row->sgst_amount;
					$ledger->voucher_id = $saleReturn->id;
					$ledger->voucher_source = 'Sale Return';
					$ledger->company_id = $invoice->company_id;
					$ledger->transaction_date = $saleReturn->transaction_date;
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				if($sale_return_row->igst_amount > 0){
					$i_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'SaleTaxes','source_id'=>$sale_return_row->igst_percentage])->first();
					$ledger = $this->SaleReturns->Ledgers->newEntity();
					$ledger->ledger_account_id = $i_LedgerAccount->id;
					$ledger->credit = 0;
					$ledger->debit = $sale_return_row->igst_amount;
					$ledger->voucher_id = $saleReturn->id;
					$ledger->voucher_source = 'Sale Return';
					$ledger->company_id = $invoice->company_id;
					$ledger->transaction_date = $saleReturn->transaction_date;
					$this->SaleReturns->Ledgers->save($ledger); 
				}
			}
				
				$ledger_fright=@(int)$saleReturn->fright_amount;
				$ledger = $this->SaleReturns->Ledgers->newEntity();
				$ledger->ledger_account_id = $saleReturn->sales_ledger_account;
				$ledger->debit = $saleReturn->total+$ledger_fright;
				$ledger->credit = 0;
				$ledger->voucher_id = $saleReturn->id;
				$ledger->company_id = $saleReturn->company_id;
				$ledger->transaction_date = $saleReturn->transaction_date;
				$ledger->voucher_source = 'Sale Return';
				$this->SaleReturns->Ledgers->save($ledger); 
				
				if(sizeof($itm_serial_number_data) > 0){
				foreach($saleReturn->sale_return_rows as $sale_return_row){
					if($itm_serial_number_data[$sale_return_row->item_id] > 0){
						$query = $this->SaleReturns->SaleReturnRows->query();
						$query->update()
							->set(['itm_serial_number'=>$itm_serial_number_data[$sale_return_row->item_id]])
							->where(['sale_return_id' => $saleReturn->id,'item_id'=>$sale_return_row->item_id])
							->execute();
						
					$serial_no=explode(",",$itm_serial_number_data[$sale_return_row->item_id]);
					foreach($serial_no as $serial){
						
						$query = $this->SaleReturns->SaleReturnRows->ItemSerialNumbers->query();
						$query->update()
							->set(['sale_return_id'=>$saleReturn->id])
							->where(['id' => $serial])
							->execute();
						
						$ItemSerialNumber_data = $this->SaleReturns->SaleReturnRows->ItemSerialNumbers->get($serial);
						$ItemSerialNumber = $this->SaleReturns->SaleReturnRows->ItemSerialNumbers->newEntity();
						$ItemSerialNumber->sale_return_id=$saleReturn->id;
						$ItemSerialNumber->status='In';
						$ItemSerialNumber->item_id=$ItemSerialNumber_data->item_id;
						$ItemSerialNumber->company_id=$ItemSerialNumber_data->company_id;
						$ItemSerialNumber->serial_no=$ItemSerialNumber_data->serial_no;
						$this->SaleReturns->SaleReturnRows->ItemSerialNumbers->save($ItemSerialNumber); 
					}
					}
				}
				}
			$Invoice_data = $this->SaleReturns->Invoices->get($invoice->id);
			$Invoice_data->sale_return_id=$saleReturn->id;
			$this->SaleReturns->Invoices->save($Invoice_data);
				
				
				$check_row=[]; $i=0;
				$saleReturn->check=array_filter($saleReturn->check);
				foreach($saleReturn->check as $invoice_row_id){
					$check_row[$i]=$invoice_row_id;
					$i++;
				}
				//pr($saleReturn); exit;
				$i=0;
			foreach($saleReturn->sale_return_rows as $sale_return_row){
						$item_id=$sale_return_row['item_id'];
						$qty=$sale_return_row['quantity'];
						//pr($qty); 
						$rate=$sale_return_row['rate'];
						$amount=$sale_return_row['amount'];
						
						$itemLedgers = $this->SaleReturns->ItemLedgers->find()->where(['item_id'=>$item_id,'in_out'=>'In','company_id' => $st_company_id,'processed_on <=' =>$saleReturn->transaction_date,'rate > '=>0,'quantity > '=>0]);
				
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
						
										
						$InvoiceRows = $this->SaleReturns->Invoices->InvoiceRows->get($check_row[$i]);
						$InvoiceRows->sale_return_quantity=$qty;
						$this->SaleReturns->Invoices->InvoiceRows->save($InvoiceRows);

						//Insert in Item Ledger//
						$itemLedger = $this->SaleReturns->ItemLedgers->newEntity();
						$itemLedger->item_id = $item_id;
						$itemLedger->quantity = $qty;
						$itemLedger->source_model = 'Sale Return';
						$itemLedger->source_id = $saleReturn->id;
						$itemLedger->in_out = 'In';
						$itemLedger->rate = $toupdate_rate;
						$itemLedger->company_id = $invoice->company_id;
						$itemLedger->processed_on =$saleReturn->transaction_date;   
						$this->SaleReturns->ItemLedgers->save($itemLedger);
						
						$i++;
				}
				
				if($saleReturn->fright_cgst_amount > 0){
					$cg_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'SaleTaxes','source_id'=>$saleReturn->fright_cgst_percent])->first();
					$ledger = $this->SaleReturns->Ledgers->newEntity();
					$ledger->ledger_account_id = $cg_LedgerAccount->id;
					$ledger->credit = 0;
					$ledger->debit = $saleReturn->fright_cgst_amount;
					$ledger->voucher_id = $saleReturn->id;
					$ledger->voucher_source = 'Sale Return';
					$ledger->company_id = $saleReturn->company_id;
					$ledger->transaction_date = $saleReturn->transaction_date;
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				if($saleReturn->fright_sgst_amount > 0){
					$s_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'SaleTaxes','source_id'=>$saleReturn->fright_sgst_percent])->first();
					$ledger = $this->SaleReturns->Ledgers->newEntity();
					$ledger->ledger_account_id = $s_LedgerAccount->id;
					$ledger->credit = 0;
					$ledger->debit =$saleReturn->fright_sgst_amount;
					$ledger->voucher_id = $saleReturn->id;
					$ledger->voucher_source = 'Sale Return';
					$ledger->company_id = $saleReturn->company_id;
					$ledger->transaction_date = $saleReturn->transaction_date;
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				if($saleReturn->fright_igst_amount > 0){
					$i_LedgerAccount=$this->SaleReturns->LedgerAccounts->find()->where(['company_id'=>$st_company_id,'source_model'=>'SaleTaxes','source_id'=>$saleReturn->fright_igst_percent])->first();
					$ledger = $this->SaleReturns->Ledgers->newEntity();
					$ledger->ledger_account_id = $i_LedgerAccount->id;
					$ledger->credit = 0;
					$ledger->debit = $saleReturn->fright_igst_amount;
					$ledger->voucher_id = $saleReturn->id;
					$ledger->voucher_source = 'Sale Return';
					$ledger->company_id = $saleReturn->company_id;
					$ledger->transaction_date = $saleReturn->transaction_date;
					$this->SaleReturns->Ledgers->save($ledger); 
				}
				//Reference Number coding
			
						
					if(sizeof(@$ref_rows)>0){
						foreach($ref_rows as $ref_row){
							$ref_row=(object)$ref_row;

							$ReferenceDetail=$this->SaleReturns->ReferenceDetails->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'reference_no'=>$ref_row->ref_no,'sale_return_id'=>$saleReturn->id])->first();
							
							if($ReferenceDetail){ //pr($ref_row->ref_old_amount); exit;
								$ReferenceBalance=$this->SaleReturns->ReferenceBalances->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'reference_no'=>$ref_row->ref_no])->first();
								$ReferenceBalance=$this->SaleReturns->ReferenceBalances->get($ReferenceBalance->id);
								$ReferenceBalance->credit=$ReferenceBalance->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								$this->SaleReturns->ReferenceBalances->save($ReferenceBalance);
								
								$ReferenceDetail=$this->SaleReturns->ReferenceDetails->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'reference_no'=>$ref_row->ref_no,'sale_return_id'=>$saleReturn->id])->first();
								
								$ReferenceDetail=$this->SaleReturns->ReferenceDetails->get($ReferenceDetail->id);
								$ReferenceDetail->credit=$ReferenceDetail->credit-$ref_row->ref_old_amount+$ref_row->ref_amount;
								$this->SaleReturns->ReferenceDetails->save($ReferenceDetail);
							}else{
								if($ref_row->ref_type=='New Reference' or $ref_row->ref_type=='Advance Reference'){
									$query = $this->SaleReturns->ReferenceBalances->query();
									$query->insert(['ledger_account_id', 'reference_no', 'credit', 'debit'])
									->values([
										'ledger_account_id' => $c_LedgerAccount->id,
										'reference_no' => $ref_row->ref_no,
										'credit' => $ref_row->ref_amount,
										'debit' => 0
									])
									->execute();
									
								}else{
									$ReferenceBalance=$this->SaleReturns->ReferenceBalances->find()->where(['ledger_account_id'=>$c_LedgerAccount->id,'reference_no'=>$ref_row->ref_no])->first();
									$ReferenceBalance=$this->SaleReturns->ReferenceBalances->get($ReferenceBalance->id);
									$ReferenceBalance->credit=$ReferenceBalance->credit+$ref_row->ref_amount;
									
									$this->SaleReturns->ReferenceBalances->save($ReferenceBalance);
								}
								

								$query = $this->SaleReturns->ReferenceDetails->query();
								$query->insert(['ledger_account_id', 'sale_return_id', 'reference_no', 'credit', 'debit', 'reference_type'])
								->values([
									'ledger_account_id' => $c_LedgerAccount->id,
									'sale_return_id' => $saleReturn->id,
									'reference_no' => $ref_row->ref_no,
									'credit' => $ref_row->ref_amount,
									'debit' => 0,
									'reference_type' => $ref_row->ref_type
								])
								->execute();
								
							}
						}
					}
			
                $this->Flash->success(__('The invoice has been saved.'));

                return $this->redirect(['action' => 'Index']);
            } else { 
                $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
            }
        }
		
		
		
		
		
		
		$GstTaxes = $this->SaleReturns->Invoices->SaleTaxes->find()->where(['SaleTaxes.account_second_subgroup_id'=>5])->matching(
					'SaleTaxCompanies', function ($q) use($st_company_id) {
						return $q->where(['SaleTaxCompanies.company_id' => $st_company_id]);
					} 
				);
		
		$AccountReference_for_sale= $this->SaleReturns->Invoices->AccountReferences->get(1);
		$account_first_subgroup_id=$AccountReference_for_sale->account_first_subgroup_id;
		$ledger_account_details = $this->SaleReturns->Invoices->LedgerAccounts->find('list')->contain(['AccountSecondSubgroups'=>['AccountFirstSubgroups' => function($q) use($account_first_subgroup_id){
			return $q->where(['AccountFirstSubgroups.id'=>$account_first_subgroup_id]);
		}]])->order(['LedgerAccounts.name' => 'ASC'])->where(['LedgerAccounts.company_id'=>$st_company_id]);
		
		$AccountReference_for_fright= $this->SaleReturns->Invoices->AccountReferences->get(3);
		$account_first_subgroup_id_for_fright=$AccountReference_for_fright->account_first_subgroup_id;
		$ledger_account_details_for_fright = $this->SaleReturns->Invoices->LedgerAccounts->find('list')->contain(['AccountSecondSubgroups'=>['AccountFirstSubgroups' => function($q) use($account_first_subgroup_id_for_fright){
			return $q->where(['AccountFirstSubgroups.id'=>$account_first_subgroup_id_for_fright]);
		}]])->order(['LedgerAccounts.name' => 'ASC'])->where(['LedgerAccounts.company_id'=>$st_company_id]);
		
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->SaleReturns->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$financial_month_first = $this->SaleReturns->FinancialMonths->find()->where(['financial_year_id'=>$st_year_id,'status'=>'Open'])->first();
		$financial_month_last = $this->SaleReturns->FinancialMonths->find()->where(['financial_year_id'=>$st_year_id,'status'=>'Open'])->last();
		
		
		$transporters = $this->SaleReturns->Invoices->Transporters->find('list');
		
		 $this->set(compact('invoice','ledger_account_details','transporters','GstTaxes','ledger_account_details_for_fright','c_LedgerAccount','chkdate','saleReturn','ReferenceDetails','financial_month_first','financial_month_last'));	
		
		
	}
	
	
}
