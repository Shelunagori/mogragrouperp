<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemLedgers Controller
 *
 * @property \App\Model\Table\ItemLedgersTable $ItemLedgers
 */
class ItemLedgersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($item_id=null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
        $st_company_id = $session->read('st_company_id');
		
		
        $this->paginate = [
            'contain' => ['Items']
        ];
        $itemLedgers2 = $this->paginate($this->ItemLedgers->find()->where(['ItemLedgers.item_id'=>$item_id,'ItemLedgers.company_id'=>$st_company_id])->order(['processed_on'=>'DESC']));
		$itemLedgers=[];
		foreach($itemLedgers2 as $itemLedger){
			if($itemLedger->source_model =='Items'){
				$itemLedger->voucher_info='-';
				$itemLedger->party_type='Item';
				$itemLedger->party_info='-'; 
			}else{
				$result=$this->GetVoucherParty($itemLedger->source_model,$itemLedger->source_id); 
				$itemLedger->voucher_info=$result['voucher_info'];
				$itemLedger->party_type=$result['party_type'];
				$itemLedger->party_info=$result['party_info']; 	
			}
			$itemLedgers[]=$itemLedger;
		}
        $this->set(compact('itemLedgers'));
        $this->set('_serialize', ['itemLedgers']);
    }
	
	public function GetVoucherParty($source_model=null,$source_id=null)
    {
		
		//return $source_model.$source_id;
		if($source_model=="Grns"){
			$Grn=$this->ItemLedgers->InvoiceBookings->find()->where(['grn_id'=>$source_id])->first();
			//pr($Grn); exit;
			$Vendor=$this->ItemLedgers->Vendors->get($Grn->vendor_id);
			return ['voucher_info'=>$Grn,'party_type'=>'Supplier','party_info'=>$Vendor];
		}
		
		if($source_model=="Inventory Vouchers"){ //echo "IV"; exit;
			$InventoryVoucher=$this->ItemLedgers->InventoryVouchers->get($source_id);
			//pr($InventoryVoucher); exit;
			return ['voucher_info'=>$InventoryVoucher,'party_type'=>'-','party_info'=>''];
		}
		if($source_model=="Invoices"){
			$Invoice=$this->ItemLedgers->Invoices->get($source_id);
			$Customer=$this->ItemLedgers->Customers->get($Invoice->customer_id);
			return ['voucher_info'=>$Invoice,'party_type'=>'Customer','party_info'=>$Customer];
		}
		if($source_model=="Challan"){
			$Challan=$this->ItemLedgers->Challans->get($source_id);
			
			if($Challan->challan_for=='Customer'){
			$Party=$this->ItemLedgers->Customers->get($Challan->customer_id);
			}else{
			$Party=$this->ItemLedgers->Vendors->get($Challan->vendor_id);
			}
			return ['voucher_info'=>$Challan,'party_type'=>$Challan->challan_for,'party_info'=>$Party];
		}
		if($source_model=="Purchase Return"){
			$PurchaseReturn=$this->ItemLedgers->PurchaseReturns->get($source_id);
			$Vendor=$this->ItemLedgers->Vendors->get($PurchaseReturn->vendor_id);
			return ['voucher_info'=>$PurchaseReturn,'party_type'=>'Purchase','party_info'=>$Vendor];
		}
		if($source_model=="Sale Return"){ 
			$SaleReturn=$this->ItemLedgers->SaleReturns->get($source_id);
			//pr($SaleReturn); exit;
			$Customer=$this->ItemLedgers->Customers->get($SaleReturn->customer_id);
			return ['voucher_info'=>$SaleReturn,'party_type'=>'Sale','party_info'=>$Customer];
		}
		 if($source_model=="Inventory Transfer Voucher"){ 
			$InventoryTransferVouchers=$this->ItemLedgers->InventoryTransferVouchers->get($source_id);//pr($source_id);exit;
			//$Item=$this->ItemLedgers->Items->get($source_id);
			return ['voucher_info'=>$InventoryTransferVouchers,'party_type'=>'-','party_info'=>'-'];
		} 
       return $source_model.$source_id;
    }

    /**
     * View method
     *
     * @param string|null $id Item Ledger id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemLedger = $this->ItemLedgers->get($id, [
            'contain' => ['Items', 'Sources', 'Companies']
        ]);

        $this->set('itemLedger', $itemLedger);
        $this->set('_serialize', ['itemLedger']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemLedger = $this->ItemLedgers->newEntity();
        if ($this->request->is('post')) {
            $itemLedger = $this->ItemLedgers->patchEntity($itemLedger, $this->request->data);
            if ($this->ItemLedgers->save($itemLedger)) {
                $this->Flash->success(__('The item ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item ledger could not be saved. Please, try again.'));
            }
        }
        $items = $this->ItemLedgers->Items->find('list', ['limit' => 200]);
        $sources = $this->ItemLedgers->Sources->find('list', ['limit' => 200]);
        $companies = $this->ItemLedgers->Companies->find('list', ['limit' => 200]);
        $this->set(compact('itemLedger', 'items', 'sources', 'companies'));
        $this->set('_serialize', ['itemLedger']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Ledger id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemLedger = $this->ItemLedgers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemLedger = $this->ItemLedgers->patchEntity($itemLedger, $this->request->data);
            if ($this->ItemLedgers->save($itemLedger)) {
                $this->Flash->success(__('The item ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item ledger could not be saved. Please, try again.'));
            }
        }
        $items = $this->ItemLedgers->Items->find('list', ['limit' => 200]);
        $sources = $this->ItemLedgers->Sources->find('list', ['limit' => 200]);
        $companies = $this->ItemLedgers->Companies->find('list', ['limit' => 200]);
        $this->set(compact('itemLedger', 'items', 'sources', 'companies'));
        $this->set('_serialize', ['itemLedger']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Ledger id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemLedger = $this->ItemLedgers->get($id);
        if ($this->ItemLedgers->delete($itemLedger)) {
            $this->Flash->success(__('The item ledger has been deleted.'));
        } else {
            $this->Flash->error(__('The item ledger could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function stockReport(){
		$this->viewBuilder()->layout('index_layout');
        $session = $this->request->session();
        $st_company_id = $session->read('st_company_id');
		$item_name=$this->request->query('item_name');
		$item_stocks =[];$items_names =[];
		$query = $this->ItemLedgers->find();
		$totalInCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['in_out' => 'In']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['in_out' => 'Out']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);

		$query->select([
			'total_in' => $query->func()->sum($totalInCase),
			'total_out' => $query->func()->sum($totalOutCase),'id','item_id'
		])
		->where(['company_id'=>$st_company_id])
		->group('item_id')
		->autoFields(true)
		->order(['name'=>'ASC'])
		->contain(['Items'=>function($q) use($item_name){
			return $q->where(['name LIKE'=>'%'.$item_name.'%']);
		}]);
		$results =$query->toArray();
		//pr($results);exit;
		foreach($results as $result){
			if($result->total_in - $result->total_out != 0){
				$item_stocks[$result->item_id] = $result->total_in - $result->total_out;
				$items_names[$result->item_id] = $result->item->name;
			}
		}
		$itemLedgers = $this->paginate($query);
        $this->set(compact('itemLedgers', 'item_name','item_stocks','items_names'));
		$this->set('_serialize', ['itemLedgers']);
    }
	
	 public function materialindentreport(){
		$this->viewBuilder()->layout('index_layout'); 
		$session = $this->request->session();
        $st_company_id = $session->read('st_company_id');
		//$Items = $this->ItemLedgers->Items->find()->where(['source'=>'Purchessed/Manufactured'])->orWhere(['source'=>'Purchessed']); 
		/* $material_items_for_purchase=[];
		$material_items_for_purchase[]=array('item_name'=>'Kgn212','item_id'=>'144','quantity'=>'25','company_id'=>'25','employee_name'=>'Gopal','company_name'=>'STL','material_indent_id'=>'2');
		
		$to=json_encode($material_items_for_purchase);
		//pr($to); exit;
		$this->redirect(['controller'=>'PurchaseOrders','action' => 'add/'.$to.'']); */
		$mit=$this->ItemLedgers->newEntity();
		
		if ($this->request->is(['post'])) {
			$check=$this->request->data['check']; 
			$suggestindent=$this->request->data['suggestindent']; 
			$to_send=[];
			foreach($check as $item_id){
				$to_send[$item_id]=$suggestindent[$item_id];
			}

			$to=json_encode($to_send); 
			//rwjihf dfgdf?3qrrg
			//$this->redirect(['controller'=>'PurchaseOrders','action' => 'add/'.$to.'']);
			$this->redirect(['controller'=>'MaterialIndents','action' => 'add/'.$to.'']);
		}
		
		$salesOrders=$this->ItemLedgers->SalesOrders->find()
			->select(['total_rows'=>$this->ItemLedgers->SalesOrders->find()->func()->count('SalesOrderRows.id')])
			->leftJoinWith('SalesOrderRows', function ($q) {
				return $q->where(['SalesOrderRows.processed_quantity < SalesOrderRows.quantity']);
			})
			->where(['company_id'=>$st_company_id])
			->group(['SalesOrders.id'])
			->autoFields(true)
			->having(['total_rows >' => 0])
			->contain(['SalesOrderRows'])
			->toArray();
			//pr($salesOrders); exit; 
			
			$sales=[];
			foreach($salesOrders as $data){
				foreach($data->sales_order_rows as $row){ 
				//pr($row->quantity);
				$item_id=$row->item_id;
				$quantity=$row->quantity;
				$processed_quantity=$row->processed_quantity;
				$Sales_Order_stock=$quantity-$processed_quantity;
				$sales[$row->item_id]=@$sales[$row->item_id]+$Sales_Order_stock;
				}
				//$sales[$item_id]=@$sales[$item_id]+$Sales_Order_stock;
			}
			//pr($sales);exit;
		$JobCards=$this->ItemLedgers->JobCards->find()->where(['status'=>'Pending','company_id'=>$st_company_id])->contain(['JobCardRows']);
		
		$job_card_items=[];
		foreach($JobCards as $JobCard){
			foreach($JobCard->job_card_rows as $job_card_row){
				$job_card_items[$job_card_row->item_id]=@$job_card_items[$job_card_row->item_id]+$job_card_row->quantity;
			}
		}		
		//pr($job_card_items); exit;
		
		$ItemLedgers = $this->ItemLedgers->find();
				$totalInCase = $ItemLedgers->newExpr()
					->addCase(
						$ItemLedgers->newExpr()->add(['in_out' => 'In']),
						$ItemLedgers->newExpr()->add(['quantity']),
						'integer'
					);
				$totalOutCase = $ItemLedgers->newExpr()
					->addCase(
						$ItemLedgers->newExpr()->add(['in_out' => 'Out']),
						$ItemLedgers->newExpr()->add(['quantity']),
						'integer'
					);

				$ItemLedgers->select([
					'total_in' => $ItemLedgers->func()->sum($totalInCase),
					'total_out' => $ItemLedgers->func()->sum($totalOutCase),'id','item_id'
				])
				->group('item_id')
				->autoFields(true)
				->contain(['Items' => function($q) use($st_company_id){
					return $q->where(['Items.source'=>'Purchessed/Manufactured'])->orWhere(['Items.source'=>'Purchessed'])->contain(['ItemCompanies'=>function($p) use($st_company_id){
						return $p->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
					}]);
				}]);
				//pr($ItemLedgers->toArray()); exit;
		foreach ($ItemLedgers as $itemLedger){
			if($itemLedger->company_id==$st_company_id){
			$item_name=$itemLedger->item->name;
			$item_id=$itemLedger->item->id;
			$Current_Stock=$itemLedger->total_in-$itemLedger->total_out;
			
			
			$material_report[]=array('item_name'=>$item_name,'item_id'=>$item_id,'Current_Stock'=>$Current_Stock,'sales_order'=>@$sales[$item_id],'job_card_qty'=>@$job_card_items[$item_id]);
			}
		} 
			
		$this->set(compact('material_report','mit'));
			
	 }
	
	
}
