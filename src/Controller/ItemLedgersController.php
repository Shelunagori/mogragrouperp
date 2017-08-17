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
			$Grn=$this->ItemLedgers->Grns->get($source_id);
			//pr($Grn); 
			$Vendor=$this->ItemLedgers->Vendors->get($Grn->vendor_id);
			return ['voucher_info'=>$Grn,'party_type'=>'-','party_info'=>$Vendor];
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
			$Customer=$this->ItemLedgers->Customers->get($SaleReturn->customer_id);
			return ['voucher_info'=>$SaleReturn,'party_type'=>'Sale','party_info'=>$Customer];
		}
		 if($source_model=="Inventory Transfer Voucher"){ 
			$InventoryTransferVouchers=$this->ItemLedgers->InventoryTransferVouchers->get($source_id);//pr($source_id);exit;
			//$Item=$this->ItemLedgers->Items->get($source_id);
			return ['voucher_info'=>$InventoryTransferVouchers,'party_type'=>'-','party_info'=>'-'];
		} 
		if($source_model=="Inventory Return"){ 
			$Inventoryreturn=$this->ItemLedgers->Rivs->get($source_id);
			//pr($source_id);exit;
			//pr($Inventoryreturn);exit;
			return ['voucher_info'=>$Inventoryreturn,'party_type'=>'-','party_info'=>'-'];
		} 
       return $source_model.$source_id;
    }
	
	public function stockLedger(){
		
	$this->viewBuilder()->layout('index_layout');
        $session = $this->request->session();
        $items=$this->request->query('items');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		
		$this->set(compact('From','To'));
		$where=[];
		if(!empty($items)){  
			$where['id']=$items;
			
		}
				
		$Items = $this->ItemLedgers->Items->find('list')->where($where)->order(['Items.name' => 'ASC']);
		$Items_list = $this->ItemLedgers->Items->find('list')->order(['Items.name' => 'ASC']);
		$this->set(compact('Items', 'items','From','To','Items_list'));
		$this->set('_serialize', ['itemLedgers']); 
    }
	
	public function GetItemVouchers($source_model_id=null,$source_id1=null)
    {
		if($source_model_id=="Invoices"){
			$Invoice=$this->ItemLedgers->Invoices->get($source_id1);
			return ['voucher_info'=>$Invoice];
		}
		
		if($source_model_id=="Grns"){ 
			$Grns=$this->ItemLedgers->Grns->get($source_id1);
			return ['voucher_info'=>$Grns];
		}
		
		if($source_model_id=="Inventory Vouchers"){ 
			$InventoryVoucher=$this->ItemLedgers->InventoryVouchers->get($source_id1);
			return ['voucher_info'=>$InventoryVoucher];
		}
		
		if($source_model_id=="Challan"){ 
			$Challan=$this->ItemLedgers->Challans->get($source_id1);
			
			return ['voucher_info'=>$Challan];
		}
		if($source_model_id=="Purchase Return"){
			$PurchaseReturn=$this->ItemLedgers->PurchaseReturns->get($source_id1);
			
			return ['voucher_info'=>$PurchaseReturn];
		}
		if($source_model_id=="Sale Return"){
			$SaleReturn=$this->ItemLedgers->SaleReturns->get($source_id1);
			return ['voucher_info'=>$SaleReturn];
		}
		 if($source_model_id=="Inventory Transfer Voucher"){ 
			$InventoryTransferVouchers=$this->ItemLedgers->InventoryTransferVouchers->get($source_id1);
			
			return ['voucher_info'=>$InventoryTransferVouchers];
		} 
		if($source_model_id=="Inventory Return"){ 
			$Inventoryreturn=$this->ItemLedgers->Rivs->get($source_id1);
			return ['voucher_info'=>$Inventoryreturn];
		} 
		return $source_model_id.$source_id1;
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
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$this->viewBuilder()->layout('index_layout');
        $session = $this->request->session();
        $st_company_id = $session->read('st_company_id');
		$item_name=$this->request->query('item_name');
		$item_category=$this->request->query('item_category');
		$item_group=$this->request->query('item_group_id');
		$from_date=$this->request->query('from_date');
		$to_date=$this->request->query('to_date');
		$stock=$this->request->query('stock');
		$status=$this->request->query('status');
		$item_sub_group=$this->request->query('item_sub_group_id');
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->ItemLedgers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$date = $financial_year->date_from;
		$due_date= $financial_year->date_from;
		if(empty($from_date)){
			$from_date=$date;
			$to_date=date('Y-m-d');
		};
		

		
		$where=[];
		$where1=[];
		$this->set(compact('item_category','item_group','item_sub_group','stock','item_name'));
		if(!empty($item_name)){ 
			$where['Item_id']=$item_name;
			
		}
		if(!empty($item_category)){
			$where['Items.item_category_id']=$item_category;
		}
		if(!empty($item_group)){
			$where['Items.item_group_id ']=$item_group;
		}
		if(!empty($item_sub_group)){
			$where['Items.item_sub_group_id ']=$item_sub_group;
		}
		if(!empty($search_date)){
			$search_date=date("Y-m-d",strtotime($search_date));
            $where1['processed_on <=']=$search_date;
		}
			//pr($where);exit;
		$item_stocks =[];$items_names =[];
		$query = $this->ItemLedgers->find()->where(['ItemLedgers.processed_on >='=> date("Y-m-d",strtotime($from_date)), 'ItemLedgers.processed_on <=' =>date("Y-m-d",strtotime($to_date))]);
				//pr($query->toArray()); exit;
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
		->contain(['Items'=>function ($q) use($where) { 
				return $q->where($where)->contain(['Units']);
				}])
		->where(['company_id'=>$st_company_id])
		->group('item_id')
		->autoFields(true)
		->where($where)
		
		->order(['Items.name'=>'ASC']);
		$results =$query->toArray();
		
		
		if($stock == "Negative"){
			foreach($results as $result){
				if($result->total_in - $result->total_out < 0){
					$item_stocks[$result->item_id] = $result->total_in - $result->total_out;
					$items_names[$result->item_id] = $result->item->name;
					$items_unit_names[$result->item_id] = $result->item->unit->name;
				}
			}
		}elseif($stock == "Zero"){
			foreach($results as $result){
				if($result->total_in - $result->total_out == 0){
					$item_stocks[$result->item_id] = $result->total_in - $result->total_out;
					$items_names[$result->item_id] = $result->item->name;
					$items_unit_names[$result->item_id] = $result->item->unit->name;
				}
			}
		}elseif($stock == "Positive"){
			foreach($results as $result){
				if($result->total_in - $result->total_out > 0){
					$item_stocks[$result->item_id] = $result->total_in - $result->total_out;
					$items_names[$result->item_id] = $result->item->name;
					$items_unit_names[$result->item_id] = $result->item->unit->name;
					//pr($item_stocks);
				}
			}
		}else{
			foreach($results as $result){
				
					$item_stocks[$result->item_id] = $result->total_in - $result->total_out;
					$items_names[$result->item_id] = $result->item->name;
					$items_unit_names[$result->item_id] = $result->item->unit->name;
				
				}
			}
		$ItemLedgers = $this->ItemLedgers->find()->contain(['Items'=>function ($q) use($where){
			return $q->where($where);
		}])->where(['ItemLedgers.company_id'=>$st_company_id,'ItemLedgers.rate >'=>0]);
		//pr(sizeof($item_stocks)); exit;
		$item_rate=[];
		$in_qty=[];
		foreach($ItemLedgers as $ItemLedger){
				if($ItemLedger->in_out == 'In'){
					@$item_rate[$ItemLedger->item_id] += ($ItemLedger->quantity*$ItemLedger->rate);
					@$in_qty[$ItemLedger->item_id] += $ItemLedger->quantity;
				}
		}
		
		
		$where=[];
		if(!empty($item_name)){ 
			$where['Items.id']=$item_name;
			
		}
		if(!empty($item_category)){
			$where['Items.item_category_id']=$item_category;
		}
		if(!empty($item_group)){
			$where['Items.item_group_id ']=$item_group;
		}
		if(!empty($item_sub_group)){
			$where['Items.item_sub_group_id ']=$item_sub_group;
		}
		if(!empty($search_date)){
			$search_date=date("Y-m-d",strtotime($search_date));
            $where1['processed_on <=']=$search_date;
		}
		 $ItemDatas=[];
		 $ItemUnits=[];
		if(!$stock){
		$Items =$this->ItemLedgers->Items->find()->contain(['Units','ItemCompanies'=>function($p) use($st_company_id){
						return $p->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
		}])->where($where);
		
		
		foreach($Items as $Item){ 
			$ItemLedgersexists = $this->ItemLedgers->exists(['item_id' => $Item->id,'company_id'=>$st_company_id]);
			if(empty($ItemLedgersexists)){
				$ItemDatas[$Item->id]=$Item->name;
				$ItemUnits[$Item->id]=$Item->unit->name;
			}
		}
	}		
		$ItemCategories = $this->ItemLedgers->Items->ItemCategories->find('list')->order(['ItemCategories.name' => 'ASC']);
		$ItemGroups = $this->ItemLedgers->Items->ItemGroups->find('list')->order(['ItemGroups.name' => 'ASC']);
		$ItemSubGroups = $this->ItemLedgers->Items->ItemSubGroups->find('list')->order(['ItemSubGroups.name' => 'ASC']);
		$Items = $this->ItemLedgers->Items->find('list')->order(['Items.name' => 'ASC']);
        $this->set(compact('itemLedgers', 'item_name','item_stocks','items_names','ItemCategories','ItemGroups','ItemSubGroups','item_rate','in_qty','Items','from_date','to_date','ItemDatas','items_unit_names','ItemUnits','url'));
		$this->set('_serialize', ['itemLedgers']); 
    }
	
	public function excelStock(){
		$this->viewBuilder()->layout('');
        $session = $this->request->session();
        $st_company_id = $session->read('st_company_id');
		$item_name=$this->request->query('item_name');
		$item_category=$this->request->query('item_category');
		$item_group=$this->request->query('item_group_id');
		$from_date=$this->request->query('from_date');
		$to_date=$this->request->query('to_date');
		$stock=$this->request->query('stock');
		$status=$this->request->query('status');
		$item_sub_group=$this->request->query('item_sub_group_id');
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->ItemLedgers->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$date = $financial_year->date_from;
		$due_date= $financial_year->date_from;
		if(empty($from_date)){
			$from_date=$date;
			$to_date=date('Y-m-d');
		};
		

		
		$where=[];
		$where1=[];
		$this->set(compact('item_category','item_group','item_sub_group','stock','item_name'));
		if(!empty($item_name)){ 
			$where['Item_id']=$item_name;
			
		}
		if(!empty($item_category)){
			$where['Items.item_category_id']=$item_category;
		}
		if(!empty($item_group)){
			$where['Items.item_group_id ']=$item_group;
		}
		if(!empty($item_sub_group)){
			$where['Items.item_sub_group_id ']=$item_sub_group;
		}
		if(!empty($search_date)){
			$search_date=date("Y-m-d",strtotime($search_date));
            $where1['processed_on <=']=$search_date;
		}
			//pr($where);exit;
		$item_stocks =[];$items_names =[];
		$query = $this->ItemLedgers->find()->where(['ItemLedgers.processed_on >='=> date("Y-m-d",strtotime($from_date)), 'ItemLedgers.processed_on <=' =>date("Y-m-d",strtotime($to_date))]);
				//pr($query->toArray()); exit;
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
		->contain(['Items'=>function ($q) use($where) { 
				return $q->where($where)->contain(['Units']);
				}])
		->where(['company_id'=>$st_company_id])
		->group('item_id')
		->autoFields(true)
		->where($where)
		
		->order(['Items.name'=>'ASC']);
		$results =$query->toArray();
		
		
		if($stock == "Negative"){
			foreach($results as $result){
				if($result->total_in - $result->total_out < 0){
					$item_stocks[$result->item_id] = $result->total_in - $result->total_out;
					$items_names[$result->item_id] = $result->item->name;
					$items_unit_names[$result->item_id] = $result->item->unit->name;
				}
			}
		}elseif($stock == "Zero"){
			foreach($results as $result){
				if($result->total_in - $result->total_out == 0){
					$item_stocks[$result->item_id] = $result->total_in - $result->total_out;
					$items_names[$result->item_id] = $result->item->name;
					$items_unit_names[$result->item_id] = $result->item->unit->name;
				}
			}
		}elseif($stock == "Positive"){
			foreach($results as $result){
				if($result->total_in - $result->total_out > 0){
					$item_stocks[$result->item_id] = $result->total_in - $result->total_out;
					$items_names[$result->item_id] = $result->item->name;
					$items_unit_names[$result->item_id] = $result->item->unit->name;
					//pr($item_stocks);
				}
			}
		}else{
			foreach($results as $result){
				
					$item_stocks[$result->item_id] = $result->total_in - $result->total_out;
					$items_names[$result->item_id] = $result->item->name;
					$items_unit_names[$result->item_id] = $result->item->unit->name;
				
				}
			}
		$ItemLedgers = $this->ItemLedgers->find()->contain(['Items'=>function ($q) use($where){
			return $q->where($where);
		}])->where(['ItemLedgers.company_id'=>$st_company_id,'ItemLedgers.rate >'=>0]);
		//pr(sizeof($item_stocks)); exit;
		$item_rate=[];
		$in_qty=[];
		foreach($ItemLedgers as $ItemLedger){
				if($ItemLedger->in_out == 'In'){
					@$item_rate[$ItemLedger->item_id] += ($ItemLedger->quantity*$ItemLedger->rate);
					@$in_qty[$ItemLedger->item_id] += $ItemLedger->quantity;
				}
		}
		
		
		$where=[];
		if(!empty($item_name)){ 
			$where['Items.id']=$item_name;
			$ItemsName = $this->ItemLedgers->Items->find()->where(['Items.id' => $item_name])->first();
		}
		if(!empty($item_category)){
			$where['Items.item_category_id']=$item_category;
			$ItemCategories = $this->ItemLedgers->Items->ItemCategories->find()->where(['ItemCategories.id' => $item_category])->first();
		}
		if(!empty($item_group)){
			$where['Items.item_group_id ']=$item_group;
			$itemGroups = $this->ItemLedgers->Items->ItemGroups->find()->where(['ItemGroups.id' => $item_group])->first();
		}
		if(!empty($item_sub_group)){
			$where['Items.item_sub_group_id ']=$item_sub_group;
			$ItemSubGroups = $this->ItemLedgers->Items->ItemSubGroups->find()->where(['ItemSubGroups.id' => $item_sub_group])->first();

		}
		
		if(!empty($search_date)){
			$search_date=date("Y-m-d",strtotime($search_date));
            $where1['processed_on <=']=$search_date;
		}
		 $ItemDatas=[];
		 $ItemUnits=[];
		if(!$stock){
		$Items =$this->ItemLedgers->Items->find()->contain(['Units','ItemCompanies'=>function($p) use($st_company_id){
						return $p->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
		}])->where($where);
		
		
		foreach($Items as $Item){ 
			$ItemLedgersexists = $this->ItemLedgers->exists(['item_id' => $Item->id,'company_id'=>$st_company_id]);
			if(empty($ItemLedgersexists)){
				$ItemDatas[$Item->id]=$Item->name;
				$ItemUnits[$Item->id]=$Item->unit->name;
			}
		}
	}		
		//$ItemCategories = $this->ItemLedgers->Items->ItemCategories->find('list')->order(['ItemCategories.name' => //'ASC']);
		//pr($ItemCategories);exit;
		//$ItemGroups = $this->ItemLedgers->Items->ItemGroups->find('list')->order(['ItemGroups.name' => 'ASC']);
		//$ItemSubGroups = $this->ItemLedgers->Items->ItemSubGroups->find('list')->order(['ItemSubGroups.name' => 'ASC']);
		$Items = $this->ItemLedgers->Items->find('list')->order(['Items.name' => 'ASC']);
        $this->set(compact('itemLedgers', 'item_name','item_stocks','items_names','ItemCategories','itemGroups','ItemSubGroups','item_rate','in_qty','Items','from_date','to_date','ItemDatas','items_unit_names','ItemUnits','url','ItemsName','itemGroup','stock'));
		$this->set('_serialize', ['itemLedgers']); 
	}
	
	public function redirectStock(){
		//exit;
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$Itemdatas = $this->ItemLedgers->find()->where(['ItemLedgers.company_id'=>$st_company_id,'in_out'=>'In','rate >'=>0]);
		
		foreach($Itemdatas as $Itemdata){
				$Itemledger_rate=0;
				$Itemledger_qty=0;
				$Itemledgers = $this->ItemLedgers->find()->where(['item_id'=>$Itemdata['item_id'],'in_out'=>'In','processed_on <='=>$Itemdata['processed_on'],'rate >'=>0]);
				//pr($Itemledgers->toArray()); 
				if($Itemledgers){ 
					$j=0; $qty_total=0; $total_amount=0;
						foreach($Itemledgers as $Itemledger){
							$Itemledger_qty = $Itemledger_qty+$Itemledger['quantity'];
							$Itemledger_rate = $Itemledger_rate+($Itemledger['rate']*$Itemledger['quantity']);
						}
						$per_unit_cost=$Itemledger_rate/$Itemledger_qty;
				}
				else{
					$per_unit_cost=0;
				}
				
				$query2 = $this->ItemLedgers->query();
						$query2->update()
							->set(['rate' => $per_unit_cost,'in_out' => 'In'])
							->where(['id' => $Itemdata['id']])
							->execute();
			}
			 return $this->redirect(['action'=>'stockReport?status=completed']);
			
	}
	
	 public function materialindentreport(){
		 $url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
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
			
		$this->set(compact('material_report','mit','url'));
			
	 }
	
	
	public function excelMetarialExport(){
		$this->viewBuilder()->layout(''); 
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
	public function fetchLedger($item_id=null,$from_date=null,$to_date=null)
    {
		//$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
        $st_company_id = $session->read('st_company_id');
        $this->paginate = [
            'contain' => ['Items']
        ];
		$where =[];
		$where['item_id']=$item_id;
		$where['company_id']=$st_company_id;
		if(!empty($from_date)){
			$From=date("Y-m-d",strtotime($from_date));
			$where['processed_on >=']=$From;
		}
		if(!empty($to_date)){
			$To=date("Y-m-d",strtotime($to_date));
			$where['processed_on <=']=$To;
		}
        $itemLedgers2 = $this->paginate($this->ItemLedgers->find()->where($where)->order(['processed_on'=>'DESC']));
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
	}
	
	public function inventoryDailyReport(){ 
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
        $st_company_id = $session->read('st_company_id');
		$from_date=$this->request->query('From');
		$to_date=$this->request->query('To');
		$where =[];
		if(!empty($from_date)){
			$From=date("Y-m-d",strtotime($from_date));
			$where['processed_on >=']=$From;
		}
		if(!empty($to_date)){
			$To=date("Y-m-d",strtotime($to_date));
			$where['processed_on <=']=$To;
		}
		$itemLedgers = $this->ItemLedgers->find()
						->where($where)
						->order(['processed_on'=>'DESC'])
						->contain(['Items'])
						->where(['ItemLedgers.company_id' => $st_company_id]); 
		
		$itemDatas=[];
		foreach($itemLedgers as $itemLedger){
			$itemDatas[$itemLedger['source_model'].$itemLedger['source_id']][]=$itemLedger;
			
		}
		$serial_nos=[];
		$voucher_no=[];
		foreach($itemDatas as $key=>$itemData){
			foreach($itemData as $itemDetail){
				///query in item serial nos where source model && sourch id invoice_id
				if($itemDetail['source_model']=='Invoices'){
					$serialnoarray=$this->ItemLedgers->Items->ItemSerialNumbers->find()->where(['invoice_id'=>$itemDetail['source_id'],'item_id'=>$itemDetail['item_id']]);
					//pr($serialnoarray->toArray());
					$serialnoarray=$this->ItemLedgers->Invoices->find()
					$serial_nos[$key][$itemDetail->item_id]=$serialnoarray->toArray();
				}
				if($itemDetail['source_model']=='Grns'){
					$serialnoarray=$this->ItemLedgers->Items->ItemSerialNumbers->find()->where(['grn_id'=>$itemDetail['source_id'],'item_id'=>$itemDetail['item_id']]);
					//pr($serialnoarray->toArray());
					$serial_nos[$key][$itemDetail->item_id]=$serialnoarray->toArray();
				}if($itemDetail['source_model']=='Inventory Vouchers'){
					$serialnoarray=$this->ItemLedgers->Items->ItemSerialNumbers->find()->where(['invoice_id'=>$itemDetail['source_id'],'item_id'=>$itemDetail['item_id']]);
					//pr($serialnoarray->toArray());
					$serial_nos[$key][$itemDetail->item_id]=$serialnoarray->toArray();
				}if($itemDetail['source_model']=='Inventory Transfer Voucher'){
					$serialnoarray=$this->ItemLedgers->Items->ItemSerialNumbers->find()->where(['inventory_transfer_voucher_id'=>$itemDetail['source_id'],'item_id'=>$itemDetail['item_id']]);
					//pr($serialnoarray->toArray());
					$serial_nos[$key][$itemDetail->item_id]=$serialnoarray->toArray();
				}
				
			}
			
		}
	//pr($serial_nos);
	//	exit;
		$this->set(compact('itemDatas','serial_nos'));
	}
	

	
	
	
	public function entryCount(){
		$this->viewBuilder()->layout('');
		
		$ItemLedgers=$this->ItemLedgers->find()->distinct(['item_id'])->where(['company_id'=>25]);
		//echo $ItemLedgers->count();
		?>
		<table border="1">
		<?php foreach($ItemLedgers as $ItemLedger){ 
			$countItemLedgers=$this->ItemLedgers->find()->where(['company_id'=>25,'item_id'=>$ItemLedger->item_id]);
		?>
			<tr>
				<td><?php echo $ItemLedger->item_id; ?></td>
				<td><?php echo $countItemLedgers->count(); ?></td>
			</tr>
		<?php } ?>
		<table> <?php exit;
	}
}
