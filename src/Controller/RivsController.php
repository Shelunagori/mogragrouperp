<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Rivs Controller
 *
 * @property \App\Model\Table\RivsTable $Rivs
 */
class RivsController extends AppController
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
        
        //$rivs = $this->paginate($this->Rivs);
		$rivs = $this->paginate($this->Rivs->find()->contain(['SaleReturns'])->where(['Rivs.company_id'=>$st_company_id])->order(['Rivs.id' => 'DESC']));
		//pr($rivs->toArray()); exit;
        $this->set(compact('rivs'));
        $this->set('_serialize', ['rivs']);
    }

    /**
     * View method
     *
     * @param string|null $id Riv id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $riv = $this->Rivs->get($id, [
            'contain' => ['SaleReturns', 'LeftRivs'=>['Items','RightRivs'=>['Items']], 'Companies','Creator']
        ]);
		//pr($riv); exit;
        $this->set('riv', $riv);
        $this->set('_serialize', ['riv']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = null,$data=null)
    {
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$sale_return_data=$this->Rivs->SaleReturns->get($id,[
			'contain'=>['SaleReturnRows'=>['Items']]
		]);
		$data1=json_decode($data);
		//pr($data1); exit;
		$InventoryVoucherRows=[];
		$inventory_return=[];
		$Item_serial_no=[];
		foreach($data1 as $item_id=>$qty){
				$Item=$this->Rivs->SaleReturns->Items->get($item_id);
				$inventory_return[$item_id]=['qty'=>$qty,'item_name'=>$Item->name];
				$InventoryVoucherRows[$item_id]=$this->Rivs->SaleReturns->InventoryVouchers->InventoryVoucherRows->find()->contain(['Items'=>['ItemCompanies'=>function ($q) use($st_company_id) {  return $q
				->where(['ItemCompanies.company_id' => $st_company_id ]); },'ItemSerialNumbers'=>function ($q) use($sale_return_data) {  return $q
				->where(['ItemSerialNumbers.iv_invoice_id' => $sale_return_data->invoice_id ]); }
				
				]])->where(['invoice_id'=>$sale_return_data->invoice_id,'left_item_id'=>$item_id]);
				$Invoice_qty[$item_id]=$this->Rivs->SaleReturns->InventoryVouchers->InvoiceRows->find()->where(['invoice_id'=>$sale_return_data->invoice_id,'item_id'=>$item_id])->first();
			
			}
        $riv = $this->Rivs->newEntity();
        if ($this->request->is('post')) {
            $riv = $this->Rivs->patchEntity($riv, $this->request->data,[
			'associated'=>['LeftRivs','LeftRivs.RightRivs']
			]);
			$last_voucher_no=$this->Rivs->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			
			if($last_voucher_no){
				$riv->voucher_no=$last_voucher_no->voucher_no+1;
			}else{
				$riv->voucher_no=1;
			}

			
			$riv->created_on = date("Y-m-d");
			//pr($sale_return_data); exit;
			$riv->transaction_date = $sale_return_data->transaction_date;
			$riv->company_id = $st_company_id;
			$riv->created_by=$s_employee_id; 
			$riv->sale_return_id = $id;
			if ($this->Rivs->save($riv)) {
			
			foreach($riv->left_rivs as $left_riv){
					foreach($left_riv->right_rivs as $right_riv){
						
						
						
						$itemLedger_in = $this->Rivs->ItemLedgers->newEntity();
						$itemLedger_in->item_id = $right_riv->item_id;
						$itemLedger_in->quantity = $right_riv->quantity;
						$itemLedger_in->source_model = 'Inventory Return';
						$itemLedger_in->source_id = $riv->id;
						$itemLedger_in->in_out = 'In';
						$itemLedger_in->rate = 0;
						$itemLedger_in->company_id = $st_company_id;
						$itemLedger_in->processed_on = $sale_return_data->transaction_date;
						$this->Rivs->ItemLedgers->save($itemLedger_in);
					}
				$itemLedger_out = $this->Rivs->ItemLedgers->newEntity();
				$itemLedger_out->item_id = $left_riv->item_id;
				$itemLedger_out->quantity = $left_riv->quantity;
				$itemLedger_out->source_model = 'Inventory Return';
				$itemLedger_out->source_id = $riv->id;
				$itemLedger_out->in_out = 'Out';
				$itemLedger_out->rate = 0;
				$itemLedger_out->company_id = $st_company_id;
				$itemLedger_out->processed_on = $sale_return_data->transaction_date;
				$this->Rivs->ItemLedgers->save($itemLedger_out);
			}
				
				foreach($riv->left_rivs as $left_rivs){
				foreach($left_rivs->right_rivs as $right_riv){
					@$item_serial_numbers=array_filter(@$right_riv->item_serial_numbers);
					if(!empty(@$item_serial_numbers)){
								foreach(@$item_serial_numbers as $item_serial_number){
									foreach(@$item_serial_number as $item_serial_number_data){
									$item_serial_number_data=$this->Rivs->ItemSerialNumbers->get($item_serial_number);
									$ItemSerialNumbers = $this->Rivs->ItemSerialNumbers->newEntity();
										$ItemSerialNumbers->status='In';
										$ItemSerialNumbers->sale_return_id=$id;
										$ItemSerialNumbers->serial_no=$item_serial_number_data->serial_no;
										$ItemSerialNumbers->item_id=$item_serial_number_data->item_id;
										$this->Rivs->ItemSerialNumbers->save($ItemSerialNumbers);
									} 
								}
							}
						}
					}
							$query = $this->Rivs->SaleReturns->query();
							$query->update()
							->set(['inventory_return_voucher_status' => 'Completed'])
							->where(['id' => $id])
							->execute();
                $this->Flash->success(__('The riv has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else { //pr($riv); exit;
                $this->Flash->error(__('The riv could not be saved. Please, try again.'));
            }
        }
        $saleReturns = $this->Rivs->SaleReturns->find('list', ['limit' => 200]);
       
		$this->set(compact('Invoice_qty','sale_return_data','InventoryVoucherRows','inventory_return','Item_serial_no','riv'));
		//$this->set(compact('riv', 'saleReturns'));
        $this->set('_serialize', ['riv']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Riv id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	 
	public function Prnding()
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$sale_return_data=$this->Rivs->SaleReturns->get($id,[
			'contain'=>['SaleReturnRows'=>['Items']]
	]);
	}
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
        $saleReturns = $this->Rivs->get($id);
        $riv = $this->Rivs->get($id, [
            'contain' => ['LeftRivs'=>['Items','RightRivs'=>['Items'=>['ItemSerialNumbers','ItemCompanies'=>function($q) use($st_company_id){
							return $q->where(['ItemCompanies.company_id' => $st_company_id]);
							}]]]]
        ]);
		//pr($riv); exit;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $riv = $this->Rivs->patchEntity($riv, $this->request->data,[
							'associated'=>['LeftRivs','LeftRivs.RightRivs']
							]);
		//pr($riv); exit;
            if ($this->Rivs->save($riv)) {
				//pr($riv->sale_return_id); exit;
				$this->Rivs->ItemLedgers->deleteAll(['source_id' =>$riv->id, 'source_model' => 'Inventory Return','company_id'=>$st_company_id]);
				
				foreach($riv->left_rivs as $left_riv){
					foreach($left_riv->right_rivs as $right_riv){
						
						//pr($left_riv['quantity']); exit;
						$itemLedgers = $this->Rivs->ItemLedgers->find()->where(['item_id'=>$right_riv['item_id'],'in_out'=>'In','company_id' => $st_company_id,'processed_on <=' =>$riv->transaction_date])->toArray();
						
							$rate=0; $count=0;
							foreach($itemLedgers as $itemLedger){ //pr($itemLedger['quantity']); exit;
								if($itemLedger->rate > 0 ){
									$count=$count+$itemLedger['quantity'];
									$rate=$rate+($itemLedger['rate']*$itemLedger['quantity']);
								}
							}
						if($count>0){
							$toupdate_rate=$rate/$count;
							}else{
							$toupdate_rate=$rate;	
							}
						
						$itemLedger_in = $this->Rivs->ItemLedgers->newEntity();
						$itemLedger_in->item_id = $right_riv->item_id;
						$itemLedger_in->quantity = $right_riv->quantity;
						$itemLedger_in->source_model = 'Inventory Return';
						$itemLedger_in->source_id = $riv->id;
						$itemLedger_in->in_out = 'In';
						$itemLedger_in->rate = $toupdate_rate/$left_riv['quantity'];
						$itemLedger_in->company_id = $st_company_id;
						$itemLedger_in->processed_on = $riv->transaction_date;
						$this->Rivs->ItemLedgers->save($itemLedger_in);
					}
					
				$itemLedger_out = $this->Rivs->ItemLedgers->newEntity();
				$itemLedger_out->item_id = $left_riv->item_id;
				$itemLedger_out->quantity = $left_riv->quantity;
				$itemLedger_out->source_model = 'Inventory Return';
				$itemLedger_out->source_id = $riv->id;
				$itemLedger_out->in_out = 'Out';
				$itemLedger_out->rate = 0;
				$itemLedger_out->company_id = $st_company_id;
				$itemLedger_out->processed_on = $riv->transaction_date;
				$this->Rivs->ItemLedgers->save($itemLedger_out);
			}
				
				foreach($riv->left_rivs as $left_rivs){
					foreach($left_rivs->right_rivs as $right_riv){
						@$item_serial_numbers=array_filter(@$right_riv->item_serial_numbers);
						if(!empty(@$item_serial_numbers)){
								foreach(@$item_serial_numbers as $item_serial_number){
									foreach(@$item_serial_number as $item_serial_number_data){
									$item_serial_number_data=$this->Rivs->ItemSerialNumbers->get($item_serial_number);
									$ItemSerialNumbers = $this->Rivs->ItemSerialNumbers->newEntity();
										$ItemSerialNumbers->status='In';
										$ItemSerialNumbers->sale_return_id=$id;
										$ItemSerialNumbers->serial_no=$item_serial_number_data->serial_no;
										$ItemSerialNumbers->item_id=$item_serial_number_data->item_id;
										$this->Rivs->ItemSerialNumbers->save($ItemSerialNumbers);
									} 
								}
							}
						}
					}
                $this->Flash->success(__('The riv has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else { //pr($riv); exit;
                $this->Flash->error(__('The riv could not be saved. Please, try again.'));
            }
        }
        $saleReturns = $this->Rivs->SaleReturns->find('list', ['limit' => 200]);
        $this->set(compact('riv', 'saleReturns'));
        $this->set('_serialize', ['riv']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Riv id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $riv = $this->Rivs->get($id);
        if ($this->Rivs->delete($riv)) {
            $this->Flash->success(__('The riv has been deleted.'));
        } else {
            $this->Flash->error(__('The riv could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
