<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 */
class ItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
	public $helpers = [
         'Paginator' => ['templates' => 'paginator-templates']
         ];
		 
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
       
		
		
		$where=[];
		$item_name=$this->request->query('item_name');
		$item_category=$this->request->query('item_category');
		$item_group=$this->request->query('item_group');
		$item_subgroup=$this->request->query('item_subgroup');
		$page=$this->request->query('page');
		
		$this->set(compact('item_name','item_category','item_group','item_subgroup'));
		
		if(!empty($item_name)){ 
			$where['Items.name LIKE']='%'.$item_name.'%';
		}
		
		if(!empty($item_category)){
			$where['ItemCategories.name LIKE']='%'.$item_category.'%';
		}
		
		if(!empty($item_group)){
			$where['ItemGroups.name LIKE']='%'.$item_group.'%';
		}
		
		
		if(!empty($item_subgroup)){
			$where['ItemSubGroups.name LIKE']='%'.$item_subgroup.'%';
		}
		
        $items =$this->Items->find()->contain(['ItemCategories','ItemGroups','ItemSubGroups','Units',
				'ItemCompanies'=> function ($q)use($st_company_id) {
				return $q->where(['company_id'=>$st_company_id]);
				}])
				->where($where)->order(['Items.name' => 'ASC']);
		//pr( $items); exit;

        $this->set(compact('items'));
        $this->set('_serialize', ['items']);
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => [ 'Units', 'ItemUsedByCompanies']
        ]);

        $this->set('item', $item);
        $this->set('_serialize', ['item']);
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
        $item = $this->Items->newEntity();
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->data);
			if ($this->Items->save($item)) {
				
				 $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'Add']);
            } else { 
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        }
		$ItemCategories = $this->Items->ItemCategories->find('list')->order(['ItemCategories.name' => 'ASC']);
        $units = $this->Items->Units->find('list')->order(['Units.name' => 'ASC']);
		$Companies = $this->Items->Companies->find('list');
		//$sources = $this->Items->Sources->find('list', ['Sources' => 200]);
        $this->set(compact('item','ItemCategories', 'units', 'Companies','sources'));
        $this->set('_serialize', ['item']);

    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $item = $this->Items->get($id, [
            'contain' => ['Companies','ItemSerialNumbers'=> function ($q) use($id) {
						   return $q
								->where(['master_item_id'=> $id]);
						}]
        ]);
	
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->data);
			$item->ob_quantity=$item->ob_quantity;
            if ($this->Items->save($item)) {
				$item_id=$item->id;
				$this->Items->ItemLedgers->deleteAll(['source_id' => $item_id, 'source_model' => 'Items']);
				$this->Items->ItemSerialNumbers->deleteAll(['master_item_id' => $item_id,'status'=>'In']);
				$itemLedger = $this->Items->ItemLedgers->newEntity();
					$itemLedger->item_id = $item_id;
					$itemLedger->quantity = $item->ob_quantity;
					$itemLedger->company_id = $st_company_id;
					$itemLedger->source_model = 'Items';
					$itemLedger->source_id = $item_id;
					$itemLedger->in_out = 'In';
					$itemLedger->processed_on = date("Y-m-d");
					if($item->ob_quantity>0)
					{
						$this->Items->ItemLedgers->save($itemLedger);
					}
					
				
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        }
		$ItemCategories = $this->Items->ItemCategories->find('list')->order(['ItemCategories.name' => 'ASC']);
		$ItemGroups = $this->Items->ItemGroups->find('list')->where(['item_category_id'=>$item->item_category_id])->order(['ItemGroups.name' => 'ASC']);
		$ItemSubGroups = $this->Items->ItemSubGroups->find('list')->where(['item_group_id'=>$item->item_group_id])->order(['ItemSubGroups.name' => 'ASC']);
        $units = $this->Items->Units->find('list')->order(['Units.name' => 'ASC']);
		$Companies = $this->Items->Companies->find('list');
		//$sources = $this->Items->Sources->find('list', ['Sources' => 200]);
        $this->set(compact('item','ItemCategories','ItemGroups','ItemSubGroups', 'units', 'Companies'));
        $this->set('_serialize', ['item']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$QuotationRowsexists = $this->Items->QuotationRows->exists(['item_id' => $id]);
		$SalesOrderRowsexists = $this->Items->SalesOrderRows->exists(['item_id' => $id]);
		$InvoiceRowsexists = $this->Items->InvoiceRows->exists(['item_id' => $id]);
		if(!$QuotationRowsexists and !$SalesOrderRowsexists and !$InvoiceRowsexists){
			$item = $this->Items->get($id);
			//$this->Items->ItemLedgers->deleteAll(['source_id' => $id, 'source_model' => 'Items']);
			if ($this->Items->delete($item)) {
				$this->Flash->success(__('The item has been deleted.'));
			} else {
				$this->Flash->error(__('The item could not be deleted. Please, try again.'));
			}			
		}elseif($QuotationRowsexists){
			$this->Flash->error(__('Once the item has used in quotation, the item cannot be deleted.'));
		}elseif($SalesOrderRowsexists){
			$this->Flash->error(__('Once the item has used in sales-order, the item cannot be deleted.'));
		}elseif($InvoiceRowsexists){
			$this->Flash->error(__('Once the item has used in invoice, the item cannot be deleted.'));
		}
        

        return $this->redirect(['action' => 'index']);
    }
	
	public function openingBalance(){
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$st_year_id = $session->read('st_year_id');
		$financial_year = $this->Items->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		
		$ItemLedger = $this->Items->ItemLedgers->newEntity();
		$Items=$this->Items->find('list')->matching('ItemCompanies', function ($q) use($st_company_id) {
			return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
			 
		});
		
		if ($this->request->is('post')) {
			$item_id=$this->request->data['Item_id'];
		
			$ItemLedgersexists = $this->Items->ItemLedgers->exists(['source_model'=>'Items','item_id' => $item_id,'company_id'=>$st_company_id]);
			if($ItemLedgersexists){
				$this->Flash->error(__('Item opening balance already exists'));
				return $this->redirect(['action' => 'openingBalance']);
			}
			
			
			$ItemLedger->item_id = $this->request->data['Item_id'];
			$ItemLedger->quantity = $this->request->data['quantity'];
			$ItemLedger->rate = $this->request->data['rate'];
			$ItemLedger->source_model = 'Items';
			$ItemLedger->source_id = $this->request->data['Item_id'];
			$ItemLedger->company_id = $st_company_id;
			$ItemLedger->rate_updated = 'Yes';
			$ItemLedger->in_out = 'In';
			$ItemLedger->left_item_id = 0;
			$ItemLedger->processed_on = date('Y-m-d',strtotime($this->request->data['date']));
			
			$this->Items->ItemLedgers->save($ItemLedger);
			
			if($this->request->data['serial_number_enable']==1){
				
				foreach($this->request->data['serial_numbers'] as $serial_number){
					$ItemSerialNumber = $this->Items->ItemSerialNumbers->newEntity();
					$ItemSerialNumber->item_id = $this->request->data['Item_id'];
					$ItemSerialNumber->serial_no = $serial_number[0];
					$ItemSerialNumber->status = 'In';
					$ItemSerialNumber->master_item_id = $this->request->data['Item_id'];
					$ItemSerialNumber->company_id = $st_company_id;
					$this->Items->ItemSerialNumbers->save($ItemSerialNumber);
				}
			}
			$this->Flash->success(__('Item Opening Balance has been saved.'));
			return $this->redirect(['action' => 'Opening-Balance']);
		}
		
		$this->set(compact('Items','ItemLedger','financial_year','ItemCompanies'));
		$this->set('_serialize', ['ItemLedger']);
	}
	
	public function openingBalanceView(){
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$where=[];
		$item=$this->request->query('item');
		//pr($item); exit;
		$this->set(compact('item'));
		
		if(!empty($item)){
			$where['Items.name LIKE']='%'.$item.'%';
		}
		
		$ItemLedgers=$this->Items->ItemLedgers->find()->where($where)->where(['source_model'=>'Items','quantity >'=>0,'company_id'=>$st_company_id])->order(['ItemLedgers.processed_on'])->contain(['Items'=>['ItemCompanies'=>function($q) use($st_company_id){
			return $q->where(['ItemCompanies.company_id'=>$st_company_id]);
		}]]);
		
		$this->set(compact('ItemLedgers'));
	}
	
	public function EditItemOpeningBalance($id = null){
		
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$st_year_id = $session->read('st_year_id');
		
		
		$financial_year = $this->Items->FinancialYears->find()->where(['id'=>$st_year_id])->first();
		$ItemLedger = $this->Items->ItemLedgers->get($id);

		$Items = $this->Items->find()->where(['id'=>$ItemLedger->item_id])->first();
		$SerialNumberEnable = $this->Items->ItemCompanies->find()->where(['item_id'=>$ItemLedger->item_id
		,'company_id'=>$st_company_id])->toArray();
		$ItemSerialNumbers = $this->Items->ItemSerialNumbers->find()->where(['item_id'=>$ItemLedger->item_id
		,'company_id'=>$st_company_id,'grn_id'=>0])->toArray();
		//pr($ItemSerialNumbers);exit;
		
		if ($this->request->is(['patch', 'post', 'put'])) {
			$item_id=$this->request->data['item_id'];
			$serial_number_enable=$this->request->data['serial_number_enable'];
			$oldquantity = $this->request->data['quantity'];
			$newquantity = $this->request->data['new_quantity'];
			$totalquantity = $oldquantity + $newquantity ;
			$ItemLedger=$this->Items->ItemLedgers->find()->where(['item_id'=>$item_id,'company_id'=>$st_company_id,'source_model'=>'Items'])->first();
			$ItemLedger=$this->Items->ItemLedgers->get($ItemLedger->id);
			$ItemLedger->quantity=$totalquantity;
			$ItemLedger->rate=$this->request->data['rate'];
			$date=$this->request->data['date'];
			$ItemLedger->processed_on=date("Y-m-d",strtotime($date)); 
			$rows=@$this->request->data['serial_numbers'];
			if($rows>0){
			
			if($serial_number_enable == '1'){
			foreach($this->request->data['serial_numbers'] as $serial_number){
					$ItemSerialNumber = $this->Items->ItemSerialNumbers->newEntity();
					$ItemSerialNumber->item_id = $ItemLedger->item_id;
					$ItemSerialNumber->serial_no = $serial_number[0];
					$ItemSerialNumber->status = 'In';
					$ItemSerialNumber->master_item_id = $item_id;
					$ItemSerialNumber->company_id = $st_company_id;
					$this->Items->ItemSerialNumbers->save($ItemSerialNumber);
				}
			}	
		}
				
			if($totalquantity != 0){	
			$this->Items->ItemLedgers->save($ItemLedger);
			$this->Flash->success(__('Item Opening Balance has been saved.'));
			}else{
				$this->Flash->error(__('Item Opening Balance cant not save when Quantity is 0.Please Enter Quantity'));
			}
			
			
			
			return $this->redirect(['action' => 'EditItemOpeningBalance/'.$id]);
		}
		
		
		
		$this->set(compact('Items','ItemLedger','financial_year','ItemSerialNumbers',
		'SerialNumberEnable'));
		$this->set('_serialize', ['ItemLedger']);
	}	
	
	public function checkSerial($item_id = null){
		$this->viewBuilder()->layout('');
		
		//pr($item_id);exit;
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$ItemCompanies = $this->Items->ItemCompanies->find()->where(['company_id'=>$st_company_id,'item_id'=>$item_id])->first();
		//pr($ItemCompanies);
		$this->set(compact('ItemCompanies'));
		
	}
	
	
	public function DeleteItemOpeningBalance($id = null)
	{
		//pr($id);exit;
	//	$this->request->allowMethod(['post', 'delete']);
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$ItemLedger = $this->Items->ItemLedgers->get($id);
		$ItemSerialexists = $this->Items->ItemSerialNumbers->exists(['status'=>'In','item_id' => $ItemLedger->item_id]);
		if($ItemSerialexists){
			$this->Items->ItemSerialNumbers->deleteAll(['item_id' => $ItemLedger->item_id,'status'=>'In','company_id'=>$st_company_id]); 
		} 
		if ($this->Items->ItemLedgers->delete($ItemLedger)) {
			$this->Flash->success(__('The Opening Balance has been deleted.'));
		} else {
			$this->Flash->error(__('The Opening Balance could not be deleted. Please, try again.'));
		}
        return $this->redirect(['action' => 'openingBalanceView']);
    }
	
	
	public function DeleteSerialNumbers($id=null,$item_id=null,$item_ledger=null){
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$ItemLedger=$this->Items->ItemLedgers->find()->where(['item_id'=>$item_id,'source_model'=>'Items'])->first();
		//pr($ItemLedger);exit;
		$ItemSerialNumber = $this->Items->ItemSerialNumbers->get($id);
		$ItemSerialNumber_invoice_id= $this->Items->ItemSerialNumbers->Invoices->find()->where(['id'=>$ItemSerialNumber->invoice_id])->first();
		
		$ItemSerialNumber_inventory_vouch__id= $this->Items->ItemSerialNumbers->InventoryVouchers->find()->where(['id'=>$ItemSerialNumber->in_inventory_voucher_id])->first();
		
		$ItemSerialNumber_inventory_transfer_vouch= $this->Items->ItemSerialNumbers->InventoryTransferVouchers->find()->where(['id'=>$ItemSerialNumber->inventory_transfer_voucher_id])->first();
		
		$ItemSerialNumber_purchase_return= $this->Items->ItemSerialNumbers->PurchaseReturns->find()->where(['id'=>$ItemSerialNumber->purchase_return_id])->first();
		
		if($ItemSerialNumber->status=='In'){
			$ItemQuantity = $ItemLedger->quantity-1;
			//pr($ItemQuantity);exit;
			if($ItemQuantity == 0){
				$this->Items->ItemLedgers->delete($ItemLedger);
				$this->Items->ItemSerialNumbers->delete($ItemSerialNumber);
				$this->Flash->success(__('The Item has been deleted.'));
				return $this->redirect(['action' => 'Opening-Balance']);
				
			}else{
			$query = $this->Items->ItemLedgers->query();
			$query->update()
				->set(['quantity' => $ItemQuantity])
				->where(['item_id' => $item_id,'company_id'=>$st_company_id,'source_model'=>'Items'])
				->execute();
			$this->Items->ItemSerialNumbers->delete($ItemSerialNumber);
			$this->Flash->success(__('The Serial Number has been deleted.'));
			}	
			
			
		}else{ 
			if($ItemSerialNumber_invoice_id->id != 0){
				$this->Flash->error(__('The Serial Number could not be deleted. These item out from invoice number: '.$ItemSerialNumber_invoice_id->in1.'-'.$ItemSerialNumber_invoice_id->in2.'/'.$ItemSerialNumber_invoice_id->in4.'/'.$ItemSerialNumber_invoice_id->in3));
			}else if($ItemSerialNumber_inventory_vouch__id->id != 0){
				$this->Flash->error(__('The Serial Number could not be deleted. These item out from Inventory Voucher number: '.str_pad($ItemSerialNumber_inventory_vouch__id->iv_number, 3, '0', STR_PAD_LEFT)));
			}else if($ItemSerialNumber_inventory_transfer_vouch->id !=0){
				$this->Flash->error(__('The Serial Number could not be deleted. These item out from Inventory Transfer Voucher number: '.str_pad($ItemSerialNumber_inventory_transfer_vouch->voucher_no, 3, '0', STR_PAD_LEFT)));
			}else if($ItemSerialNumber_purchase_return->id !=0){
				$this->Flash->error(__('The Serial Number could not be deleted. These item out from Inventory Transfer Voucher number: '.str_pad($ItemSerialNumber_purchase_return->voucher_no, 3, '0', STR_PAD_LEFT)));
			}
		}
		
		
		return $this->redirect(['action' => 'EditItemOpeningBalance/'.$item_ledger]);
	}
	
	
	
	public function cost($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$ItemLedger = $this->Items->ItemLedgers->newEntity();
		
		$Items=$this->Items->find('list')->matching('ItemCompanies', function ($q) use($st_company_id) {
			return $q->where(['ItemCompanies.company_id' => $st_company_id]);
		});
		
		if ($this->request->is('post')) {
			$query = $this->Items->ItemCompanies->query();
			$query->update()
				->set(['dynamic_cost' => $this->request->data['dynamic_cost'],'minimum_selling_price_factor' => $this->request->data['minimum_selling_price_factor']])
				->where(['item_id' => $this->request->data['Item_id'],'company_id'=>$st_company_id])
				->execute();
			$this->Flash->success(__('Dynamic cost & Minimum selling price factor has been saved.'));
			return $this->redirect(['action' => 'cost']);
		}
		
		$this->set(compact('Items','ItemLedger'));
		$this->set('_serialize', ['ItemLedger']);
	}
	
	public function costView(){
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		
		$Items=$this->Items->find()->matching('ItemCompanies', function ($q) use($st_company_id) {
			return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.minimum_selling_price_factor >'=>0]);
		});
		$this->set(compact('Items'));
	}

	public function EditCompany($item_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		$Companies = $this->Items->Companies->find();
		$Company_array=[];
		$Company_array1=[];
		$Company_array2=[];
		$Company_array3=[];
		foreach($Companies as $Company){
			$Company_exist= $this->Items->ItemCompanies->exists(['item_id' => $item_id,'company_id'=>$Company->id]);
			if($Company_exist){
				$item_data= $this->Items->ItemCompanies->find()->where(['item_id' => $item_id,'company_id'=>$Company->id])->first();
				$Company_array[$Company->id]='Yes';
				$Company_array1[$Company->id]=$Company->name;
				$Company_array2[$Company->id]=$item_data->freeze;
				$Company_array3[$Company->id]=$item_data->serial_number_enable;
				
			}else{

				$Company_array[$Company->id]='No';
				$Company_array1[$Company->id]=$Company->name;
				$Company_array2[$Company->id]=1;
				$Company_array3[$Company->id]=0;
			}

		} 
		$item_data= $this->Items->get($item_id);
		$this->set(compact('item_data','Companies','customer_Company','Company_array','item_id','Company_array1','Company_array2','Company_array3'));

	}
	public function ItemFreeze($company_id=null,$item_id=null,$freeze=null)
	{
		$query2 = $this->Items->ItemCompanies->query();
		$query2->update()
			->set(['freeze' => $freeze])
			->where(['item_id' => $item_id,'company_id'=>$company_id])
			->execute();

		return $this->redirect(['action' => 'EditCompany/'.$item_id]);
	}

public function SerialNumberEnabled($company_id=null,$item_id=null,$item_serial_no=null)
	{
		if($item_serial_no == 0){
			$ItemSerialNumbers = $this->Items->ItemSerialNumbers->exists(['item_id'=>$item_id,'company_id'=>$company_id]);
			if($ItemSerialNumbers){ 
				$this->Flash->error(__('Item Can not Disabled.These Item has Serial Number , Firstly, you can delete serial number then you can disabled'));
			}else{
				$query2 = $this->Items->ItemCompanies->query();
				$query2->update()
						->set(['serial_number_enable' => $item_serial_no])
						->where(['item_id' => $item_id,'company_id'=>$company_id])
						->execute();
				$this->Flash->success(__('Item Serial Number Disabled Successfully '));		
			}
		}else{
				$Item_ledger_out = $this->Items->Itemledgers->exists(['item_id'=>$item_id,'company_id'=>$company_id,'in_out'=>'In']);
				if($Item_ledger_out){
					return $this->redirect(['action' => 'ItemSerialNo/'.$item_id,$company_id]);
				}
			
			
				$query2 = $this->Items->ItemCompanies->query();
				$query2->update()
						->set(['serial_number_enable' => $item_serial_no])
						->where(['item_id' => $item_id,'company_id'=>$company_id])
						->execute();
			$this->Flash->success(__('Item Serial Number Enabled Successfully '));
		}
		return $this->redirect(['action' => 'EditCompany/'.$item_id]);
	}

public function AddCompany($company_id=null,$item_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		

		$ItemCompany = $this->Items->ItemCompanies->newEntity();
		$ItemCompany->company_id=$company_id;
		$ItemCompany->item_id=$item_id;
		$ItemCompany->freeze=0;
		$ItemCompany->serial_number_enable=1;
		
		//pr($ItemCompany); exit;
		$this->Items->ItemCompanies->save($ItemCompany);
		
		return $this->redirect(['action' => 'EditCompany/'.$item_id]);
	}
public function CheckCompany($company_id=null,$item_id=null)
    {
		$this->viewBuilder()->layout('index_layout');	
		$this->request->allowMethod(['post', 'delete']);
		
		$ledgerexist = $this->Items->ItemLedgers->exists(['item_id' => $item_id,'company_id' => $company_id]);
		
		if(!$ledgerexist){
			$item_Company_dlt= $this->Items->ItemCompanies->find()->where(['ItemCompanies.item_id'=>$item_id,'company_id'=>$company_id])->first();
			$this->Items->ItemCompanies->delete($item_Company_dlt);
			$this->Flash->success(__('Company Deleted Successfully'));
			return $this->redirect(['action' => 'EditCompany/'.$item_id]);
		}else{
			$this->Flash->error(__('Company Can not Deleted'));
			return $this->redirect(['action' => 'EditCompany/'.$item_id]);
		}
	}
	public function ItemSerialNo($item_id=null,$company_id=null){
		$this->viewBuilder()->layout('index_layout');	
		$having=['total_rows' => 0];
		$item = $this->Items->newEntity();
		$ledger_data=
		$this->Items->ItemLedgers->find()->select(['total_rows' => 
			$this->Items->find()->func()->sum('ItemLedgers.quantity')])
				->where(['item_id' => $item_id,'company_id' => $company_id,'in_out'=>'In'])->first();
				
		if ($this->request->is('post')) {
			$data=$this->request->data();
			$query = $this->Items->ItemCompanies->query();
			$query->update()
				->set(['dynamic_cost' => $this->request->data['dynamic_cost'],'minimum_selling_price_factor' => $this->request->data['minimum_selling_price_factor']])
				->where(['item_id' => $this->request->data['Item_id'],'company_id'=>$st_company_id])
				->execute();
			$this->Flash->success(__('Dynamic cost & Minimum selling price factor has been saved.'));
			return $this->redirect(['action' => 'cost']);
		}	
				
			
		$this->set(compact('ledger_data','item'));
		//pr($ledger_data['total_rows']); exit;
	}
	
	public function itemSerialNumberManage(){
		$this->viewBuilder()->layout('index_layout');	
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');

		$Items=$this->Items->find()->matching('ItemCompanies', function ($q) use($st_company_id) {
			return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze'=>0,'ItemCompanies.serial_number_enable'=>1]);
		});
		foreach($Items as $Item){
			$ItemLedgers=$this->Items->ItemLedgers->find()
				->select(['total_quantity' => $this->Items->find()->func()->sum('ItemLedgers.quantity')])
				->where(['item_id'=>$Item->id,'company_id'=>$st_company_id,'in_out'=>'In'])
				->group(['item_id']);
				
			$ItemSerialNumbers=$this->Items->ItemSerialNumbers->find()->where(['item_id'=>$Item->id,'company_id'=>$st_company_id]);
			
			$ItemLedgers= (Array)$ItemLedgers->toArray();
			if($ItemSerialNumbers->count()!=@$ItemLedgers[0]->total_quantity){
				echo $Item->id.'-';
			}
		}
		
		exit;
	}
	
	public function askSerialNumber($item_id=null,$company_id=null){
		$this->viewBuilder()->layout('index_layout');
		
		$item = $this->Items->newEntity();
		if ($this->request->is('post')) {
			foreach($this->request->data['serial_numbers'] as $serial_number){
				$query = $this->Items->ItemSerialNumbers->query();
				$query->insert(['item_id', 'serial_no', 'status', 'master_item_id', 'company_id'])
					->values([
						'item_id' => $item_id,
						'serial_no' => $serial_number,
						'status' => 'In',
						'master_item_id' => $item_id,
						'company_id' => $company_id
					]);
				$query->execute();
			}
			$query = $this->Items->ItemCompanies->query();
			$query->update()
				->set(['serial_number_enable' => 1])
				->where(['item_id' => $item_id,'company_id'=>$company_id])
				->execute();
			
			return $this->redirect(['action' => 'edit-company',$item_id]);
		}
		
		
		$ItemLedgers=$this->Items->ItemLedgers->find()->where(['item_id'=>$item_id,'company_id'=>$company_id]);
		$item_qty=[];
		foreach($ItemLedgers as $ItemLedger){
			if($ItemLedger->in_out=='Out'){
				@$item_qty['Out']+=$ItemLedger->quantity;
			}else{
				@$item_qty['In']+=$ItemLedger->quantity;
			}
		}
		
		$current_qty=@$item_qty['In']-@$item_qty['Out'];
		if($current_qty <= 0){
			$query = $this->Items->ItemCompanies->query();
			$query->update()
				->set(['serial_number_enable' => 1])
				->where(['item_id' => $item_id,'company_id'=>$company_id])
				->execute();
			return $this->redirect(['action' => 'edit-company',$item_id]);
		}
		$this->set(compact('current_qty', 'item'));

	}
	
	
}
