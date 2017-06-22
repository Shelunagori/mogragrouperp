<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * InventoryTransferVouchers Controller
 *
 * @property \App\Model\Table\InventoryTransferVouchersTable $InventoryTransferVouchers
 */
class InventoryTransferVouchersController extends AppController
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
		$where = [];
        $vouch_no = $this->request->query('vouch_no');
		$From = $this->request->query('From');
		$To = $this->request->query('To');
		//pr($vouch_no);exit;
		
		$this->set(compact('vouch_no','From','To'));
		
		if(!empty($vouch_no)){
			$where['InventoryTransferVouchers.voucher_no LIKE']=$vouch_no;
		}
		
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where['InventoryTransferVouchers.transaction_date >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where['InventoryTransferVouchers.transaction_date <=']=$To;
		}
		
		$inventory_transfer_vouchs = $this->InventoryTransferVouchers->find()->where($where);
		//pr($inventory_transfer_vouchs->toArray());exit;
		
		
		$this->paginate = [
            'contain' => ['Companies']
        ];
        $inventoryTransferVouchers = $this->paginate($this->InventoryTransferVouchers);

        $this->set(compact('inventoryTransferVouchers','inventory_transfer_vouchs'));
        $this->set('_serialize', ['inventoryTransferVouchers']);
    }

    /**
     * View method
     *
     * @param string|null $id Inventory Transfer Voucher id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inventoryTransferVoucher = $this->InventoryTransferVouchers->get($id, [
            'contain' => ['Companies', 'InventoryTransferVoucherRows']
        ]);

        $this->set('inventoryTransferVoucher', $inventoryTransferVoucher);
        $this->set('_serialize', ['inventoryTransferVoucher']);
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
		$s_employee_id=$this->viewVars['s_employee_id'];
		
			
		
		$display_items = $this->InventoryTransferVouchers->Items->find()->matching(
					'ItemCompanies', function ($q) use($st_company_id) {
						return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
					} 
				);
		
		//pr($display_items->toArray()); exit;
		$inventoryTransferVoucher = $this->InventoryTransferVouchers->newEntity();
	
        if ($this->request->is('post')) {
			$inventory_transfer_voucher_rows=[];
			foreach($this->request->data['inventory_transfer_voucher_rows']['out'] as $inventory_transfer_voucher_row){
				$inventory_transfer_voucher_row['status']='out';
				$inventory_transfer_voucher_rows[]=$inventory_transfer_voucher_row;
			}
			foreach($this->request->data['inventory_transfer_voucher_rows']['in'] as $inventory_transfer_voucher_row){
				$inventory_transfer_voucher_row['status']='in';
				$inventory_transfer_voucher_row['item_id']=$inventory_transfer_voucher_row['item_id_in'];
				$inventory_transfer_voucher_row['quantity']=$inventory_transfer_voucher_row['quantity_in'];
				unset($inventory_transfer_voucher_row['item_id_in']);
				unset($inventory_transfer_voucher_row['quantity_in']);
				$inventory_transfer_voucher_rows[]=$inventory_transfer_voucher_row;
				
			}
			$this->request->data['inventory_transfer_voucher_rows']=$inventory_transfer_voucher_rows;
			
            $inventoryTransferVoucher = $this->InventoryTransferVouchers->patchEntity($inventoryTransferVoucher, $this->request->data);
			$inventoryTransferVoucher->transaction_date=date("Y-m-d",strtotime($inventoryTransferVoucher->transaction_date));
			$inventoryTransferVoucher->created_on=date("Y-m-d");
			//pr($inventoryTransferVoucher->transaction_date);exit;
			//pr( date("Y-m-d",strtotime($transaction_date)));exit;
			
			$last_voucher_no=$this->InventoryTransferVouchers->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_voucher_no){
				$inventoryTransferVoucher->voucher_no=$last_voucher_no->voucher_no+1;
			}else{
				$inventoryTransferVoucher->voucher_no=1;
			}
			$inventoryTransferVoucher->company_id=$st_company_id;
			$inventoryTransferVoucher->in_out='in_out';
			$inventoryTransferVoucher->created_by=$s_employee_id;
			

	
			if ($this->InventoryTransferVouchers->save($inventoryTransferVoucher)) {
				
			foreach($inventory_transfer_voucher_rows as $inventory_transfer_voucher_row_data){
				//pr($inventory_transfer_voucher_row_data); exit;
				if($inventory_transfer_voucher_row_data['status'] == 'out'){
				$serial_data=0;
				$serial_data=sizeof(@$inventory_transfer_voucher_row_data['serial_number_data']);
				if($serial_data>0){
					$serial_number_datas=$inventory_transfer_voucher_row_data['serial_number_data'];
					foreach($serial_number_datas as $key=>$serial_number_data){
						$query2 = $this->InventoryTransferVouchers->Items->ItemSerialNumbers->query();
						$query2->update()
							->set(['inventory_transfer_voucher_id' => $inventoryTransferVoucher->id,'status' => 'Out'])
							->where(['id' => $serial_number_data])
							->execute();
					}
					}
					
					
				$Itemledgers = $this->InventoryTransferVouchers->ItemLedgers->find()->where(['item_id'=>$inventory_transfer_voucher_row_data['item_id'],'in_out'=>'In']);
				$ledger_data=$Itemledgers->count();
				
				if($ledger_data>0){ 
					$j=0; $qty_total=0; $total_amount=0;
					foreach($Itemledgers as $Itemledger){
						$Itemledger_qty = $Itemledger->quantity;
						$Itemledger_rate = $Itemledger->rate;
						$total_amount = $total_amount+($Itemledger_qty * $Itemledger_rate);
						$qty_total=$qty_total+$Itemledger_qty;
						$j++;
						
				}
				}else{
					$total_amount=0;
					$qty_total=1;
				}
				
				
				$per_unit_cost=$total_amount/$qty_total;
				$today_date =  Time::now();
				$query= $this->InventoryTransferVouchers->ItemLedgers->query();
						$query->insert(['item_id','quantity' ,'rate', 'in_out','source_model','processed_on','company_id','source_id'])
							  ->values([
											'item_id' => $inventory_transfer_voucher_row_data['item_id'],
											'quantity' => $inventory_transfer_voucher_row_data['quantity'],
											'rate' => $per_unit_cost,
											'source_model' => 'Inventory Transfer Voucher',
											'processed_on' => date("Y-m-d",strtotime($inventoryTransferVoucher->transaction_date)),
											'in_out'=>'Out',
											'company_id'=>$st_company_id,
											'source_id'=>$inventoryTransferVoucher->id
										])
					    ->execute();
						
						$avg_cost_data = $per_unit_cost*$inventory_transfer_voucher_row_data['quantity'];
						
						
						$query21 = $this->InventoryTransferVouchers->InventoryTransferVoucherRows->query();
						$query21->update()
							->set(['amount' => $avg_cost_data])
							->where(['inventory_transfer_voucher_id'=>$inventoryTransferVoucher->id,'item_id' => $inventory_transfer_voucher_row_data['item_id'],'status' => 'Out'])
							->execute();
							
				}else if($inventory_transfer_voucher_row_data['status'] == 'in'){
					$serial_data=0;
					$serial_data=sizeof(@$inventory_transfer_voucher_row_data['sr_no']);
					if($serial_data>0){
					$serial_number_datas=$inventory_transfer_voucher_row_data['sr_no'];
					foreach($serial_number_datas as $key=>$serial_number_data){
						$query2 = $this->InventoryTransferVouchers->Items->ItemSerialNumbers->query();
						$query2->insert(['item_id','serial_no','status','company_id','inventory_transfer_voucher_id'])
							->values([
										'item_id' =>$inventory_transfer_voucher_row_data['item_id'],
										'serial_no'=>$serial_number_data,
										'status'=>'In',
										'company_id'=>$st_company_id,
										'inventory_transfer_voucher_id'=>$inventoryTransferVoucher->id
										])
							->execute();
					}
				}
				
				
				$query= $this->InventoryTransferVouchers->ItemLedgers->query();
						$query->insert(['item_id','quantity' ,'rate', 'in_out','source_model','company_id','processed_on','source_id'])
							  ->values([
											'item_id' => $inventory_transfer_voucher_row_data['item_id'],
											'quantity' => $inventory_transfer_voucher_row_data['quantity'],
											'rate' =>$inventory_transfer_voucher_row_data['amount'],
											'source_model' => 'Inventory Transfer Voucher',
											'processed_on' => date("Y-m-d",strtotime($inventoryTransferVoucher->transaction_date)),
											'in_out'=>'In',
											'company_id'=>$st_company_id,
											'source_id'=>$inventoryTransferVoucher->id
										])
					    ->execute();
			} 
			
					
				}
			
			}	
			$this->Flash->success(__('The inventory transfer voucher has been saved.'));

                return $this->redirect(['action' => 'add']);
            } 
       
        $companies = $this->InventoryTransferVouchers->Companies->find('list', ['limit' => 200]);
        $this->set(compact('inventoryTransferVoucher', 'companies','display_items','options'));
        $this->set('_serialize', ['inventoryTransferVoucher']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Transfer Voucher id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	public function ItemSerialNumber($select_item_id = null)
    {
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$flag=0; 
		$Item = $this->InventoryTransferVouchers->Items->get($select_item_id, [
            'contain' => ['ItemCompanies'=>function($q) use($st_company_id){
				return $q->where(['company_id'=>$st_company_id]);
			}]
        ]);
		//pr($Item->item_companies[0]->serial_number_enable);
		if($Item->item_companies[0]->serial_number_enable=="1"){
			$SerialNumbers=$this->InventoryTransferVouchers->Items->ItemSerialNumbers->find()->where(['item_id'=>$select_item_id,'status'=>'In','company_id'=>$st_company_id]);
			
			$selectedSerialNumbers=$this->InventoryTransferVouchers->Items->ItemSerialNumbers->find()->where(['item_id'=>$select_item_id,'status'=>'Out','company_id'=>$st_company_id]);
			
			//pr($selectedSerialNumbers);exit;
			$flag=1;
		}
		$this->set(compact('SerialNumbers','flag','select_item_id','selectedSerialNumbers'));
    }


    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$display_items = $this->InventoryTransferVouchers->Items->find()->contain(['ItemSerialNumbers'])->toArray();
	
        $inventoryTransferVouchersout = $this->InventoryTransferVouchers->get($id, [
            'contain' => ['InventoryTransferVoucherRows'=>
						function($q) use($st_company_id,$id){
											return $q->where(['inventory_transfer_voucher_id'=>$id,'status'=>'Out'])->contain(['Items'=>['ItemCompanies','ItemLedgers','ItemSerialNumbers']]);
				}]
				
        ]);
		
		$inventoryTransferVouchersins = $this->InventoryTransferVouchers->get($id, [
            'contain' => ['InventoryTransferVoucherRows'=>
						function($q) use($st_company_id,$id){
											return $q->where(['inventory_transfer_voucher_id'=>$id,'status'=>'In'])->contain(['Items'=>['ItemCompanies','ItemLedgers','ItemSerialNumbers']]);
				}]
				
        ]);		
		
		
		$inventoryTransferVoucher = $this->InventoryTransferVouchers->get($id, [
            'contain' => ['InventoryTransferVoucherRows']
        ]);
		
		//$inventoryTransferVoucher = $this->InventoryTransferVouchers->newEntity();
		if ($this->request->is(['patch', 'post', 'put'])) {
			$inventory_transfer_voucher_rows=[];
			foreach($this->request->data['inventory_transfer_voucher_rows']['out'] as $inventory_transfer_voucher_row){
				$inventory_transfer_voucher_row['status']='out';
				$inventory_transfer_voucher_rows[]=$inventory_transfer_voucher_row;
			}
			foreach($this->request->data['inventory_transfer_voucher_rows']['in'] as $inventory_transfer_voucher_row){
				$inventory_transfer_voucher_row['status']='in';
				$inventory_transfer_voucher_row['item_id']=$inventory_transfer_voucher_row['item_id_in'];
				$inventory_transfer_voucher_row['quantity']=$inventory_transfer_voucher_row['quantity_in'];
				unset($inventory_transfer_voucher_row['item_id_in']);
				unset($inventory_transfer_voucher_row['quantity_in']);
				$inventory_transfer_voucher_rows[]=$inventory_transfer_voucher_row;
				
			}
			$this->request->data['inventory_transfer_voucher_rows']=$inventory_transfer_voucher_rows;
			
            $inventoryTransferVoucher = $this->InventoryTransferVouchers->patchEntity($inventoryTransferVoucher, $this->request->data);
			
			if ($this->InventoryTransferVouchers->save($inventoryTransferVoucher)) {
				//pr($inventory_transfer_voucher_rows); exit;
				foreach($inventory_transfer_voucher_rows as $inventory_transfer_voucher_row_data){
				
				if($inventory_transfer_voucher_row_data['status'] == 'out'){
					
			$query_in = $this->InventoryTransferVouchers->Items->ItemSerialNumbers->query();
			$query_in->update()
					->set(['status' => 'In'])
					->where(['inventory_transfer_voucher_id' => $id,'item_id'=>$inventory_transfer_voucher_row_data['item_id'],'status'=>'Out'])
					->execute();
					
					
				$serial_data=0;
				$serial_data=sizeof(@$inventory_transfer_voucher_row_data['serial_number_data']);
				if($serial_data>0){
					$serial_number_datas=$inventory_transfer_voucher_row_data['serial_number_data'];
					foreach($serial_number_datas as $key=>$serial_number_data){
						$query2 = $this->InventoryTransferVouchers->Items->ItemSerialNumbers->query();
						$query2->update()
							->set(['inventory_transfer_voucher_id' => $inventoryTransferVoucher->id,'status' => 'Out'])
							->where(['id' => $serial_number_data])
							->execute();
					}
					}
					
					
				$Itemledgers = $this->InventoryTransferVouchers->ItemLedgers->find()->where(['item_id'=>$inventory_transfer_voucher_row_data['item_id'],'in_out'=>'In']);
				$ledger_data=$Itemledgers->count();
				
				if($ledger_data>0){ 
					$j=0; $qty_total=0; $total_amount=0;
					foreach($Itemledgers as $Itemledger){
						$Itemledger_qty = $Itemledger->quantity;
						$Itemledger_rate = $Itemledger->rate;
						$total_amount = $total_amount+($Itemledger_qty * $Itemledger_rate);
						$qty_total=$qty_total+$Itemledger_qty;
						$j++;
						
				}
				}else{
					$total_amount=0;
					$qty_total=1;
				}
				
				
				$per_unit_cost=$total_amount/$qty_total;
				//pr($per_unit_cost); exit;
				$today_date =  Time::now();
				//pr($today_date);exit;
				$query= $this->InventoryTransferVouchers->ItemLedgers->query();
						$query->insert(['item_id','quantity' ,'rate', 'in_out','source_model','processed_on','company_id','source_id'])
							  ->values([
											'item_id' => $inventory_transfer_voucher_row_data['item_id'],
											'quantity' => $inventory_transfer_voucher_row_data['quantity'],
											'rate' => $per_unit_cost,
											'source_model' => 'Inventory Transfer Voucher',
											'processed_on' => date("Y-m-d",strtotime($inventoryTransferVoucher->transaction_date)),
											'in_out'=>'Out',
											'company_id'=>$st_company_id,
											'source_id'=>$inventoryTransferVoucher->id
										])
					    ->execute();
						$qw=$per_unit_cost*$inventory_transfer_voucher_row_data['quantity'];
						//pr($qw); exit;
						$query21 = $this->InventoryTransferVouchers->InventoryTransferVoucherRows->query();
						$query21->update()
							->set(['amount' => $qw])
							->where(['inventory_transfer_voucher_id'=>$inventoryTransferVoucher->id,'item_id' => $inventory_transfer_voucher_row_data['item_id'],'status' => 'out'])
							->execute();
							
				}else if($inventory_transfer_voucher_row_data['status'] == 'in'){ 
					$serial_data=0;
					$serial_data=sizeof(@$inventory_transfer_voucher_row_data['sr_no']);
					
					if($serial_data>0){
					$serial_number_datas=$inventory_transfer_voucher_row_data['sr_no'];
					foreach($serial_number_datas as $key=>$serial_number_data){
						
						
						$query2 = $this->InventoryTransferVouchers->Items->ItemSerialNumbers->query();
						$query2->insert(['item_id','serial_no','status','company_id','inventory_transfer_voucher_id'])
							->values([
										'item_id' =>$inventory_transfer_voucher_row_data['item_id'],
										'serial_no'=>$serial_number_data,
										'status'=>'In',
										'company_id'=>$st_company_id,
										'inventory_transfer_voucher_id'=>$inventoryTransferVoucher->id
										])
							->execute();
					}
				}
				
				
				$query= $this->InventoryTransferVouchers->ItemLedgers->query();
						$query->insert(['item_id','quantity' ,'rate', 'in_out','source_model','company_id','processed_on','source_id'])
							  ->values([
											'item_id' => $inventory_transfer_voucher_row_data['item_id'],
											'quantity' => $inventory_transfer_voucher_row_data['quantity'],
											'rate' =>$inventory_transfer_voucher_row_data['amount'],
											'source_model' => 'Inventory Transfer Voucher',
											'processed_on' => date("Y-m-d",strtotime($inventoryTransferVoucher->transaction_date)),
											'in_out'=>'In',
											'company_id'=>$st_company_id,
											'source_id'=>$inventoryTransferVoucher->id
										])
					    ->execute();
			}
			
					
				} 
				
				
				
				
                $this->Flash->success(__('The inventory transfer voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The inventory transfer voucher could not be saved. Please, try again.'));
            }
        }
        $companies = $this->InventoryTransferVouchers->Companies->find('list', ['limit' => 200]);
        $this->set(compact('inventoryTransferVoucher', 'companies','inventoryTransferVouchersout','inventoryTransferVouchersins','id','display_items'));
        $this->set('_serialize', ['inventoryTransferVoucher']);
    }

	function DeleteSerialNumbers($id=null,$in_id=null,$in_voucher_id=null,$item_id=null){
		//pr($in_id);
		//pr($in_voucher_id);exit;
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$ItemLedger=$this->InventoryTransferVouchers->InventoryTransferVoucherRows->Items->ItemLedgers->find()->where(['source_id'=>$in_voucher_id,'item_id'=>$item_id,'in_out'=>'In','source_model'=>'Inventory Transfer Voucher'])->first();
		//pr($ItemLedger);exit;
		
		$ItemSerialNumber = $this->InventoryTransferVouchers->ItemSerialNumbers->get($id);
		$InventoryTransferVoucherRows = $this->InventoryTransferVouchers->InventoryTransferVoucherRows->get($in_id);
		//pr($InventoryTransferVoucherRows);exit;
		
		if($ItemSerialNumber->status=='In'){
			$ItemQuantity = $ItemLedger->quantity-1;
			//pr($ItemQuantity);exit;
			if($ItemQuantity == 0){
				$this->InventoryTransferVouchers->ItemLedgers->delete($ItemLedger);
				$this->InventoryTransferVouchers->InventoryTransferVoucherRows->delete($InventoryTransferVoucherRows);
				$this->Flash->success(__('The Item has been deleted.'));
				return $this->redirect(['action' => 'Opening-Balance']);
				
			}else{
				
			$query_in = $this->InventoryTransferVouchers->InventoryTransferVoucherRows->query();
			
			$query_in->update()
				->set(['quantity' => $InventoryTransferVoucherRows->quantity-1])
				->where(['inventory_transfer_voucher_id' => $in_voucher_id,'item_id'=>$item_id,'status'=>'In'])
				->execute();	
				
			$query = $this->InventoryTransferVouchers->InventoryTransferVoucherRows->Items->ItemLedgers->query();
			$query->update()
				->set(['quantity' => $ItemLedger->quantity-1])
				->where(['item_id'=>$item_id,'company_id'=>$st_company_id,'source_model'=>'Inventory Transfer Voucher','in_out'=>'In'])
				->execute();
					
			$this->InventoryTransferVouchers->ItemSerialNumbers->delete($ItemSerialNumber);
			$this->Flash->success(__('The Serial Number has been deleted.'));
			}
		}
		return $this->redirect(['action' => 'edit/'.$in_voucher_id]);
	}
    /**
     * Delete method
     *
     * @param string|null $id Inventory Transfer Voucher id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryTransferVoucher = $this->InventoryTransferVouchers->get($id);
        if ($this->InventoryTransferVouchers->delete($inventoryTransferVoucher)) {
            $this->Flash->success(__('The inventory transfer voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory transfer voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	 public function ItemLedgerRate($item_id = null)
    {
		$Itemledgers = $this->InventoryTransferVouchers->ItemLedgers->find()->where(['item_id'=>$item_id,'in_out'=>'In']);
				
				$j=0; $qty_total=0; $total_amount=0;
				foreach($Itemledgers as $Itemledger){
					$Itemledger_qty = $Itemledger->quantity;
					$Itemledger_rate = $Itemledger->rate;
					$total_amount = $total_amount+($Itemledger_qty * $Itemledger_rate);
					$qty_total=$qty_total+$Itemledger_qty;
					$j++;
				}
		$per_unit_cost=$total_amount/$qty_total;
		
		$this->set(compact('per_unit_cost'));
	}
	
	public function InventoryIn()
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$display_items = $this->InventoryTransferVouchers->Items->find()->matching(
					'ItemCompanies', function ($q) use($st_company_id) {
						return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
					} 
				);
		$inventoryTransferVoucher = $this->InventoryTransferVouchers->newEntity();
		
		if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryTransferVoucher = $this->InventoryTransferVouchers->patchEntity($inventoryTransferVoucher, $this->request->data);
			//pr($inventoryTransferVoucher); exit;
			$last_voucher_no=$this->InventoryTransferVouchers->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_voucher_no){
				$inventoryTransferVoucher->voucher_no=$last_voucher_no->voucher_no+1;
			}else{
				$inventoryTransferVoucher->voucher_no=1;
			}
			$inventoryTransferVoucher->company_id=$st_company_id;
			$inventoryTransferVoucher->in_out='in';
			$inventoryTransferVoucher->created_by=$s_employee_id;
			
			if ($this->InventoryTransferVouchers->save($inventoryTransferVoucher)) {
			
				foreach($inventoryTransferVoucher->inventory_transfer_voucher_rows as $inventory_transfer_voucher_row){
					$dt=sizeof($inventory_transfer_voucher_row->sr_no);
						$query= $this->InventoryTransferVouchers->ItemLedgers->query();
						$query->insert(['item_id','quantity' ,'rate', 'in_out','source_model','company_id','processed_on','source_id'])
							  ->values([
											'item_id' =>$inventory_transfer_voucher_row->item_id,
											'quantity' =>$inventory_transfer_voucher_row->quantity,
											'rate' =>$inventory_transfer_voucher_row->amount,
											'source_model' => 'Inventory Transfer Voucher',
											'processed_on' => date("Y-m-d",strtotime($inventoryTransferVoucher->transaction_date)),
											'in_out'=>'In',
											'company_id'=>$st_company_id,
											'source_id'=>$inventoryTransferVoucher->id
											
										])
					    ->execute();
						
						if($dt > 0){
							foreach($inventory_transfer_voucher_row->sr_no as $sr_no){ 	
								$query2 = $this->InventoryTransferVouchers->Items->ItemSerialNumbers->query();
								$query2->insert(['item_id','serial_no','status','company_id','inventory_transfer_voucher_id'])
								->values([
											'item_id' =>$inventory_transfer_voucher_row->item_id,
											'serial_no'=>$sr_no,
											'status'=>'In',
											'company_id'=>$st_company_id,
											'inventory_transfer_voucher_id'=>$inventoryTransferVoucher->id
											])
								->execute();
								
							}
						}
				}
				$this->Flash->success(__('The Inventory Transfer Vouchers has been saved.'));
                return $this->redirect(['action' => 'InventoryIn']);
			}
			
		}
		
		$this->set(compact('display_items','inventoryTransferVoucher'));
	}
	
	public function InventoryOut()
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$display_items = $this->InventoryTransferVouchers->Items->find()->matching(
					'ItemCompanies', function ($q) use($st_company_id) {
						return $q->where(['ItemCompanies.company_id' => $st_company_id,'ItemCompanies.freeze' => 0]);
					} 
				);
		$inventoryTransferVoucher = $this->InventoryTransferVouchers->newEntity();
		
		if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryTransferVoucher = $this->InventoryTransferVouchers->patchEntity($inventoryTransferVoucher, $this->request->data);
			//pr($inventoryTransferVoucher); exit;
			$last_voucher_no=$this->InventoryTransferVouchers->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_voucher_no){
				$inventoryTransferVoucher->voucher_no=$last_voucher_no->voucher_no+1;
			}else{
				$inventoryTransferVoucher->voucher_no=1;
			}
			$inventoryTransferVoucher->company_id=$st_company_id;
			$inventoryTransferVoucher->in_out='in';
			$inventoryTransferVoucher->created_by=$s_employee_id;
			
				if ($this->InventoryTransferVouchers->save($inventoryTransferVoucher)) {
				
					foreach($inventoryTransferVoucher->inventory_transfer_voucher_rows as $inventory_transfer_voucher_row){
				$Itemledgers = $this->InventoryTransferVouchers->ItemLedgers->find()->where(['item_id'=>$inventory_transfer_voucher_row->item_id,'in_out'=>'In']);
				
				$ledger_data=$Itemledgers->count();
				
				if($ledger_data>0){ 
					$j=0; $qty_total=0; $total_amount=0;
					foreach($Itemledgers as $Itemledger){
						
						$Itemledger_qty = $Itemledger->quantity;
						$Itemledger_rate = $Itemledger->rate;
						$total_amount = $total_amount+($Itemledger_qty * $Itemledger_rate);
						
						$qty_total=$qty_total+$Itemledger_qty;
						$j++;
						
				}
				}else{
					$total_amount=0;
					$qty_total=1;
				}
				
				
				$per_unit_cost=$total_amount/$qty_total;
			
				$today_date =  Time::now();
				$query= $this->InventoryTransferVouchers->ItemLedgers->query();
						$query->insert(['item_id','quantity' ,'rate', 'in_out','source_model','processed_on','company_id','source_id'])
							  ->values([
											'item_id' => $inventory_transfer_voucher_row->item_id,
											'quantity' => $inventory_transfer_voucher_row->quantity,
											'rate' => $per_unit_cost,
											'source_model' => 'Inventory Transfer Voucher',
											'processed_on' => date("Y-m-d",strtotime($inventoryTransferVoucher->transaction_date)),
											'in_out'=>'Out',
											'company_id'=>$st_company_id,
											'source_id'=>$inventoryTransferVoucher->id
										])
					    ->execute();
						
						$avg_cost_data = $per_unit_cost*$inventory_transfer_voucher_row->quantity;
						
					$serial_data=sizeof($inventory_transfer_voucher_row->serial_number_data);
					if($serial_data>0){
						foreach($inventory_transfer_voucher_row->serial_number_data as $serial_number_data){
						$query2 = $this->InventoryTransferVouchers->Items->ItemSerialNumbers->query();
						$query2->update()
							->set(['inventory_transfer_voucher_id' => $inventoryTransferVoucher->id,'status' => 'Out'])
							->where(['id' => $serial_number_data])
							->execute();
						}
					}
					
					
					$query21 = $this->InventoryTransferVouchers->InventoryTransferVoucherRows->query();
						$query21->update()
							->set(['amount' => $avg_cost_data,'status' => 'Out'])
							->where(['inventory_transfer_voucher_id'=>$inventoryTransferVoucher->id,'item_id' => $inventory_transfer_voucher_row->item_id])
							->execute();
					}
					
					$this->Flash->success(__('The Inventory Transfer Vouchers has been saved.'));

                return $this->redirect(['action' => 'InventoryOut']);
				}
		
		}
		$this->set(compact('display_items','inventoryTransferVoucher'));
	}
	
	    public function editOut($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$display_items = $this->InventoryTransferVouchers->Items->find()->contain(['ItemSerialNumbers'])->toArray();
	
        $inventoryTransferVouchersout = $this->InventoryTransferVouchers->get($id, [
            'contain' => ['InventoryTransferVoucherRows'=>
						function($q) use($st_company_id,$id){
											return $q->where(['inventory_transfer_voucher_id'=>$id,'status'=>'Out'])->contain(['Items'=>['ItemCompanies','ItemLedgers','ItemSerialNumbers']]);
				}]
				
        ]);
	
		$inventoryTransferVoucher = $this->InventoryTransferVouchers->get($id, [
            'contain' => ['InventoryTransferVoucherRows']
        ]);
		
		$this->set(compact('display_items','inventoryTransferVoucher'));
	}
	
	
}