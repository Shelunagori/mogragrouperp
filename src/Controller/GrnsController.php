<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Grns Controller
 *
 * @property \App\Model\Table\GrnsTable $Grns
 */
class GrnsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($status=null)
    {
		$this->viewBuilder()->layout('index_layout');
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $this->paginate = [
            'contain' => ['PurchaseOrders', 'Companies','Vendors']
        ];
		$pull_request=$this->request->query('pull-request');
		
		$where1=[];
		$grn_no=$this->request->query('grn_no');
		$po_no=$this->request->query('po_no');
		$vendor=$this->request->query('vendor');
		$From=$this->request->query('From');
		$To=$this->request->query('To');
		$this->set(compact('grn_no','vendor','From','po_no','To'));
		if(!empty($grn_no)){
			//pr($grn_no); exit;
			$where1['grn2 LIKE']=$grn_no;
		}
		if(!empty($po_no)){
			$where1['PurchaseOrders.po3 LIKE']='%'.$po_no.'%';
		}
		
		if(!empty($vendor)){
			$where1['Vendors.company_name LIKE']='%'.$vendor.'%';
		}
		if(!empty($From)){
			$From=date("Y-m-d",strtotime($this->request->query('From')));
			$where1['Grns.date_created >=']=$From;
		}
		if(!empty($To)){
			$To=date("Y-m-d",strtotime($this->request->query('To')));
			$where1['Grns.date_created <=']=$To;
		}
      
		$where=[];
		if($status==null or $status=='Pending'){
			$where['status']='Pending';
		}elseif($status=='Invoice-Booked'){
			$where['status']='Invoice-Booked';
		}
		$grns = $this->paginate($this->Grns->find()->where($where)->where($where1)->where(['Grns.company_id'=>$st_company_id])->order(['Grns.id' => 'DESC']));
        $this->set(compact('grns','pull_request','status'));
        $this->set('_serialize', ['grns']);
    }

    /**
     * View method
     *
     * @param string|null $id Grn id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$grn = $this->Grns->get($id, [
            'contain' => ['Companies','ItemSerialNumbers','Creator','Vendors','PurchaseOrders'=>['PurchaseOrderRows','Grns'=>['GrnRows']],'GrnRows'=>['Items' => ['ItemSerialNumbers','ItemCompanies' =>function($q) use($st_company_id){
									return $q->where(['company_id'=>$st_company_id]);
								}]]
        ]]);
		//pr($grn->grn_rows->item); exit;

        $this->set('grn', $grn);
        $this->set('_serialize', ['grn']);
    }

	
	
	
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
		$purchase_order_id=@(int)$this->request->query('purchase-order');
		
		$purchase_order=array();
		
		if(!empty($purchase_order_id)){
			$purchase_order = $this->Grns->PurchaseOrders->get($purchase_order_id, [
				'contain' => [
						'PurchaseOrderRows.Items' => function ($q) {
						   return $q
								->where(['PurchaseOrderRows.quantity > PurchaseOrderRows.processed_quantity'])
								->contain(['ItemCompanies']);
						},'Companies','Vendors'
					]
			]);
			//pr($purchase_order); exit;
		}
		$this->set(compact('purchase_order'));
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


		 $grn = $this->Grns->newEntity();
        if ($this->request->is('post')) {
			$grn->vendor_id=$purchase_order->vendor_id;
			$last_grn_no=$this->Grns->find()->select(['grn2'])->where(['company_id' => $st_company_id])->order(['grn2' => 'DESC'])->first();
			if($last_grn_no){
				$grn->grn2=(int)$last_grn_no->grn2+1;
			}else{
				$grn->grn2=1;
			}
			if($this->request->data['serial_numbers']){
			$serial_numbers=$this->request->data['serial_numbers']; 
			$item_serial_numbers=[];
			foreach($serial_numbers as $item_id=>$data){
				foreach($data as $sr)
				$item_serial_numbers[]=['item_id'=>$item_id,'serial_no'=>$sr,'status'=>'In'];
			}
			
			$this->request->data['item_serial_numbers']=$item_serial_numbers;
			//pr($this->request->data); exit;
			}
			$grn = $this->Grns->patchEntity($grn, $this->request->data);
			$grn->date_created=date("Y-m-d");
			$grn->purchase_order_id=$purchase_order_id;
			$grn->company_id=$st_company_id ;
			$grn->created_by=$this->viewVars['s_employee_id'];
			//
			 if ($this->Grns->save($grn)) {
				
					if(!empty($purchase_order_id)){
						$grn->check=array_filter($grn->check);
						$i=0; 
						
						foreach($grn->check as $purchase_order_row_id){
							$qty=$grn->grn_rows[$i]['quantity'];
							$item_id=$grn->grn_rows[$i]['item_id'];
							$PurchaseOrderRows = $this->Grns->PurchaseOrderRows->get($purchase_order_row_id);
							$PurchaseOrderRows->processed_quantity=$PurchaseOrderRows->processed_quantity+$qty;
							$this->Grns->PurchaseOrderRows->save($PurchaseOrderRows);
							$i++;
							
							//Insert in Item Ledger//
							$itemLedger = $this->Grns->ItemLedgers->newEntity();
							$itemLedger->item_id = $item_id;
							$itemLedger->quantity = $qty;
							$itemLedger->company_id = $grn->company_id;
							$itemLedger->source_model = 'Grns';
							$itemLedger->source_id = $grn->id;
							$itemLedger->in_out = 'In';
							$itemLedger->processed_on = date("Y-m-d");
							$this->Grns->ItemLedgers->save($itemLedger);
						} 
						
					} 
					
					$this->Flash->success(__('The grn has been saved.'));

					return $this->redirect(['action' => 'index']);
				} else {// pr($grn); exit;
					$this->Flash->error(__('The grn could not be saved. Please, try again.'));
				}
			}
		$items = $this->Grns->Items->find('list');
		$companies = $this->Grns->Companies->find('all');
        $purchaseOrders = $this->Grns->PurchaseOrders->find('all');
		
        
        $this->set(compact('grn', 'purchaseOrders', 'companies','customers','chkdate'));
        $this->set('_serialize', ['grn']);
    }

	
	public function AddNew()
    {
		$this->viewBuilder()->layout('index_layout');
		$purchase_order_id=@(int)$this->request->query('purchase-order');
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$purchase_order=array();
		
		if(!empty($purchase_order_id)){
			$purchase_order = $this->Grns->PurchaseOrders->get($purchase_order_id, [
				'contain' => [
						'PurchaseOrderRows.Items' => function ($q) use($st_company_id){
						   return $q
								->where(['PurchaseOrderRows.quantity > PurchaseOrderRows.processed_quantity'])
								->contain(['ItemCompanies'=>function($q) use($st_company_id){
									return $q->where(['company_id'=>$st_company_id]);
								}]);
						},'Companies','Vendors'
					]
			]);
			//pr($purchase_order); exit;
		}
		
		$this->set(compact('purchase_order'));
		

			   $st_year_id = $session->read('st_year_id');

			   $SessionCheckDate = $this->FinancialYears->get($st_year_id);
			   $fromdate1 = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
			   $todate1 = date("Y-m-d",strtotime($SessionCheckDate->date_to)); 
			   $tody1 = date("Y-m-d");

			   $fromdate = strtotime($fromdate1);
			   $todate = strtotime($todate1); 
			   $tody = strtotime($tody1);

			  if($fromdate > $tody || $todate < $tody || $SessionCheckDate['status'] == 'Closed')
			   {
				   $chkdate = 'Not Found';
			   }
			   else
			   {
				  $chkdate = 'Found';
			   }


		 $grn = $this->Grns->newEntity();
        if ($this->request->is('post')) {
			$grn->vendor_id=$purchase_order->vendor_id;
			$last_grn_no=$this->Grns->find()->select(['grn2'])->where(['company_id' => $st_company_id])->order(['grn2' => 'DESC'])->first();
			if($last_grn_no){
				$grn->grn2=(int)$last_grn_no->grn2+1;
			}else{
				$grn->grn2=1;
			}
			
			$serial_numbers=@$this->request->data['serial_numbers']; 
			if(sizeof($serial_numbers)>0){
			$item_serial_numbers=[];
			foreach($serial_numbers as $item_id=>$data){
				foreach($data as $sr)
				$item_serial_numbers[]=['item_id'=>$item_id,'serial_no'=>$sr,'company_id'=>$st_company_id,'status'=>'In'];
			}
			
			$this->request->data['item_serial_numbers']=$item_serial_numbers;
			//pr($this->request->data); exit;
			}
			$grn = $this->Grns->patchEntity($grn, $this->request->data);
			$grn->date_created=date("Y-m-d");
			$grn->purchase_order_id=$purchase_order_id;
			$grn->company_id=$st_company_id ;
			$grn->created_by=$this->viewVars['s_employee_id'];
			//
			 if ($this->Grns->save($grn)) {
				
					if(!empty($purchase_order_id)){
						$grn->check=array_filter($grn->check);
						$i=0; 
						
						foreach($grn->check as $purchase_order_row_id){
							$qty=$grn->grn_rows[$i]['quantity'];
							$item_id=$grn->grn_rows[$i]['item_id'];
							$PurchaseOrderRows = $this->Grns->PurchaseOrderRows->get($purchase_order_row_id);
							$PurchaseOrderRows->processed_quantity=$PurchaseOrderRows->processed_quantity+$qty;
							$this->Grns->PurchaseOrderRows->save($PurchaseOrderRows);
							$i++;
							
							//Insert in Item Ledger//
							$itemLedger = $this->Grns->ItemLedgers->newEntity();
							$itemLedger->item_id = $item_id;
							$itemLedger->quantity = $qty;
							$itemLedger->company_id = $grn->company_id;
							$itemLedger->source_model = 'Grns';
							$itemLedger->source_id = $grn->id;
							$itemLedger->in_out = 'In';
							$itemLedger->processed_on = date("Y-m-d");
							$this->Grns->ItemLedgers->save($itemLedger);
						} 
						
					} 
					
					$this->Flash->success(__('The grn has been saved.'));

					return $this->redirect(['action' => 'index']);
				} else {// pr($grn); exit;
					$this->Flash->error(__('The grn could not be saved. Please, try again.'));
				}
			}
		$items = $this->Grns->Items->find('list');
		$companies = $this->Grns->Companies->find('all');
        $purchaseOrders = $this->Grns->PurchaseOrders->find('all');
		
        
        $this->set(compact('grn', 'purchaseOrders', 'companies','customers','chkdate'));
        $this->set('_serialize', ['grn']);
    }
    /**
     * Edit method
     *
     * @param string|null $id Grn id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

	////
	
	
	public function EditNew($id = null)
    {
	
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$this->viewBuilder()->layout('index_layout');
		
		$grn = $this->Grns->get($id, [
				'contain' => [
						'Companies','ItemSerialNumbers','Vendors','PurchaseOrders'=>['PurchaseOrderRows','Grns'=>['GrnRows']],'GrnRows'=>['Items' => ['ItemCompanies' =>function($q) use($st_company_id){
									return $q->where(['company_id'=>$st_company_id]);
								}]]
					]
			]);

			   $st_year_id = $session->read('st_year_id');

			   $SessionCheckDate = $this->FinancialYears->get($st_year_id);
			   $fromdate1 = date("Y-m-d",strtotime($SessionCheckDate->date_from));   
			   $todate1 = date("Y-m-d",strtotime($SessionCheckDate->date_to)); 
			   $tody1 = date("Y-m-d");

			   $fromdate = strtotime($fromdate1);
			   $todate = strtotime($todate1); 
			   $tody = strtotime($tody1);

			  if($fromdate > $tody || $todate < $tody || $SessionCheckDate['status'] == 'Closed')
			   {
				   $chkdate = 'Not Found';
			   }
			   else
			   {
				  $chkdate = 'Found';
			   }			
	
	
		if ($this->request->is(['patch', 'post', 'put'])) {

			$serial_numbers=@$this->request->data['serial_numbers']; 
			$item_serial_numbers=[];
			if(sizeof($serial_numbers)>0){
			foreach($serial_numbers as $item_id=>$data){
				foreach($data as $sr)
				$item_serial_numbers[]=['item_id'=>$item_id,'serial_no'=>$sr,'company_id'=>$st_company_id,'status'=>'In'];
			}
		//pr($serial_numbers); exit;
			$this->request->data['item_serial_numbers']=$item_serial_numbers;
			}
            $grn = $this->Grns->patchEntity($grn, $this->request->data);
				if ($this->Grns->save($grn)) {
					foreach($grn->grn_rows as $grn_row){
							$qty=$grn_row->quantity;
							$item_id=$grn_row->item_id;
							$query = $this->Grns->ItemLedgers->query();
							$query->update()
							->set(['quantity' => $qty])
							->where(['item_id' => $item_id, 'source_id' => $grn->id, 'source_model'=> 'Grns'])
							->execute();
					}
					$qq=0; foreach($grn->grn_rows as $grn_row){
						//pr($grn->purchase_order_id); exit;
						$purchaseorderrow=$this->Grns->PurchaseOrderRows->find()->where(['purchase_order_id'=>$grn->purchase_order_id,'item_id'=>$grn_row->item_id])->first();
						$purchaseorderrow->processed_quantity=$purchaseorderrow->processed_quantity-@$grn->getOriginal('grn_rows')[$qq]->quantity+$grn_row->quantity;
						$this->Grns->PurchaseOrderRows->save($purchaseorderrow);
						$qq++; 
					} 
					$this->Flash->success(__('The grn has been saved.'));
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('The grn could not be saved. Please, try again.'));
				}
			}
        $purchaseOrders = $this->Grns->PurchaseOrders->find('list', ['limit' => 200]);
        $companies = $this->Grns->Companies->find('list', ['limit' => 200]);
        $this->set(compact('grn', 'purchaseOrders', 'companies','chkdate'));
        $this->set('_serialize', ['grn']);
    }
    /**
     * Delete method
     *
     * @param string|null $id Grn id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $grn = $this->Grns->get($id);
        if ($this->Grns->delete($grn)) {
            $this->Flash->success(__('The grn has been deleted.'));
        } else {
            $this->Flash->error(__('The grn could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	public function DeleteSerialNumbers($id=null,$item_id=null,$grn_id=null){
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$ItemLedger=$this->Grns->ItemLedgers->find()->where(['item_id'=>$item_id,'source_model'=>'Grns'])->first();
		
		$GrnRow=$this->Grns->GrnRows->find()->where(['item_id'=>$item_id,'grn_id'=>$grn_id])->first();
		
		$GRN=$this->Grns->get($grn_id);
		$PO=$this->Grns->PurchaseOrders->get($GRN->purchase_order_id);
		$PurchaseOrderRow=$this->Grns->PurchaseOrderRows->find()->where(['item_id'=>$item_id,'purchase_order_id'=>$GRN->purchase_order_id])->first();
		
		$ItemSerialNumber = $this->Grns->ItemSerialNumbers->get($id);
		
		if($ItemSerialNumber->status=='In'){
			$query = $this->Grns->ItemLedgers->query();
			$query->update()
				->set(['quantity' => $ItemLedger->quantity-1])
				->where(['item_id' => $item_id,'company_id'=>$st_company_id,'source_model'=>'Grns'])
				->execute();
			$query1 = $this->Grns->GrnRows->query();
			$query1->update()
				->set(['quantity' => $GrnRow->quantity-1])
				->where(['item_id'=>$item_id,'grn_id'=>$grn_id])
				->execute();
			$query2 = $this->Grns->PurchaseOrderRows->query();
			$query2->update()
				->set(['processed_quantity' => $PurchaseOrderRow->processed_quantity-1])
				->where(['item_id' => $item_id,'purchase_order_id'=>$PO->id])
				->execute();
						
			$this->Grns->ItemSerialNumbers->delete($ItemSerialNumber);
			$this->Flash->success(__('The Serial Number has been deleted.'));
		}
		
		return $this->redirect(['action' => 'EditNew/'.$grn_id]);
	}
}
