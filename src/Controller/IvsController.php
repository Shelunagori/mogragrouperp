<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ivs Controller
 *
 * @property \App\Model\Table\IvsTable $Ivs
 */
class IvsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Invoices', 'Companies']
        ];
        $ivs = $this->paginate($this->Ivs);

        $this->set(compact('ivs'));
        $this->set('_serialize', ['ivs']);
    }

    /**
     * View method
     *
     * @param string|null $id Iv id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $iv = $this->Ivs->get($id, [
            'contain' => ['Invoices', 'Companies', 'IvLeftRows']
        ]);

        $this->set('iv', $iv);
        $this->set('_serialize', ['iv']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($invoice_id=null)
    {
		$this->viewBuilder()->layout('index_layout');
		
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$invoice=$this->Ivs->Invoices->get($invoice_id, [
			'contain' => ['InvoiceRows'=>['Items'=>['ItemCompanies'=>function($q) use($st_company_id){
				return $q->where(['company_id'=>$st_company_id]);
			}]]]
		]);
		
		
        $iv = $this->Ivs->newEntity();
        if ($this->request->is('post')) {
            $iv = $this->Ivs->patchEntity($iv, $this->request->data, [
								'associated' => ['IvLeftRows', 'IvLeftRows.IvLeftSerialNumbers', 'IvLeftRows.IvRightRows' ]
							]);
			$iv->company_id=$st_company_id;
			
			$last_in_no=$this->Ivs->find()->select(['voucher_no'])->where(['company_id' => $st_company_id])->order(['voucher_no' => 'DESC'])->first();
			if($last_in_no){
				$iv->voucher_no=$last_in_no->voucher_no+1;
			}else{
				$iv->voucher_no=1;
			}
			
			$iv->invoice_id=$invoice_id;
			
            if ($this->Ivs->save($iv)) {
				//pr($iv); exit;
				//insert in IvRightSerialNumbers//
				foreach($iv->iv_left_rows as $iv_left_row){
					foreach($iv_left_row->iv_right_rows as $iv_right_row){
						if(sizeof($iv_right_row->iv_right_serial_numbers['_ids'])>0){
							foreach($iv_right_row->iv_right_serial_numbers['_ids'] as $item_serial_number_id){
								$query = $this->Ivs->IvLeftRows->IvRightRows->IvRightSerialNumbers->query();
								$query->insert(['iv_right_row_id', 'item_serial_number_id'])
								->values([
									'iv_right_row_id' => $iv_right_row->id,
									'item_serial_number_id' => $item_serial_number_id
								]);
								$query->execute();
							}
						}
					}					
				}
				
				//out from stock//
				foreach($iv->iv_left_rows as $iv_left_row){ 
					$InvoiceRow=$this->Ivs->Invoices->InvoiceRows->get($iv_left_row->invoice_row_id);
					
					$total_value=0;
					foreach($iv_left_row->iv_right_rows as $iv_right_row){
						$itemLedgers = $this->Ivs->ItemLedgers->find()->where(['item_id'=>$iv_right_row->item_id,'in_out'=>'In','rate_updated'=>'Yes','company_id' => $st_company_id]);
						$total_quantity=0; $total_amount=0;
						foreach($itemLedgers as $itemLedger){
							$total_quantity+=$itemLedger->quantity;
							$total_amount+=$itemLedger->quantity*$itemLedger->rate;
						} 
						if($total_quantity>0){ $waighted_avr_rate=$total_amount/$total_quantity; }
						else{ $waighted_avr_rate=0; }
						
						$total_value+=$waighted_avr_rate*$iv_right_row->quantity;
						
						//Item ledger posting for IN//
						$query = $this->Ivs->ItemLedgers->query();
						$query->insert(['item_id', 'quantity', 'rate', 'source_model', 'source_id', 'in_out', 'processed_on', 'company_id', 'rate_updated', 'left_item_id'])
						->values([
							'item_id' => $iv_right_row->item_id,
							'quantity' => $iv_right_row->quantity,
							'rate' => $waighted_avr_rate,
							'source_model' => 'Iv',
							'source_id' => $iv->id,
							'in_out' => 'Out',
							'processed_on' => $iv->transaction_date,
							'company_id' => $st_company_id,
							'rate_updated' => 'yes',
							'left_item_id' => 0
						]);
						$query->execute();
						
						//Serial number Update status out for right//
						if(sizeof($iv_right_row->iv_right_serial_numbers['_ids'])>0){
								foreach($iv_right_row->iv_right_serial_numbers['_ids'] as $item_serial_number_id){
								$ItemSerialNumber=$this->Ivs->ItemSerialNumbers->get($item_serial_number_id);
								$ItemSerialNumber->status='Out';
								$ItemSerialNumber->iv_id=$iv->id;
								$this->Ivs->ItemSerialNumbers->save($ItemSerialNumber);
							}
						}
						
					}
					$unit_rate_for_In=$total_value/$InvoiceRow->quantity;
					
					//Item ledger posting for IN//
					$query = $this->Ivs->ItemLedgers->query();
					$query->insert(['item_id', 'quantity', 'rate', 'source_model', 'source_id', 'in_out', 'processed_on', 'company_id', 'rate_updated', 'left_item_id'])
					->values([
						'item_id' => $InvoiceRow->item_id,
						'quantity' => $InvoiceRow->quantity,
						'rate' => $unit_rate_for_In,
						'source_model' => 'Iv',
						'source_id' => $iv->id,
						'in_out' => 'In',
						'processed_on' => $iv->transaction_date,
						'company_id' => $st_company_id,
						'rate_updated' => 'yes',
						'left_item_id' => 0
					]);
					$query->execute();
					
					//Serial number insert for left//
					if(sizeof($iv_left_row->iv_left_serial_numbers)>0){
						foreach($iv_left_row->iv_left_serial_numbers as $iv_left_serial_number){
							$query = $this->Ivs->ItemSerialNumbers->query();
							$query->insert(['item_id', 'serial_no', 'status', 'company_id', 'iv_id'])
							->values([
								'item_id' => $InvoiceRow->item_id,
								'serial_no' => $iv_left_serial_number->sr_number,
								'status' => 'In',
								'company_id' => $st_company_id,
								'iv_id' => $iv->id
							]);
							$query->execute();
						}
					}
				}
				exit;
                $this->Flash->success(__('The iv has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The iv could not be saved. Please, try again.'));
            }
        }
        $invoices = $this->Ivs->Invoices->find('list',
				['keyField' => function ($row) {
					return $row['id'];
				},
				'valueField' => function ($row) {
					return  $row['in2'];
					
				}]);
        $items = $this->Ivs->IvLeftRows->IvRightRows->Items->find()->select(['id','name'])->contain(['ItemCompanies'=>function($q) use($st_company_id){
				return $q->where(['company_id'=>$st_company_id]);
			}]);
        $this->set(compact('iv', 'invoices', 'invoice', 'items'));
        $this->set('_serialize', ['iv']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Iv id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $iv = $this->Ivs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $iv = $this->Ivs->patchEntity($iv, $this->request->data);
            if ($this->Ivs->save($iv)) {
                $this->Flash->success(__('The iv has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The iv could not be saved. Please, try again.'));
            }
        }
        $invoices = $this->Ivs->Invoices->find('list', ['limit' => 200]);
        $companies = $this->Ivs->Companies->find('list', ['limit' => 200]);
        $this->set(compact('iv', 'invoices', 'companies'));
        $this->set('_serialize', ['iv']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Iv id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $iv = $this->Ivs->get($id);
        if ($this->Ivs->delete($iv)) {
            $this->Flash->success(__('The iv has been deleted.'));
        } else {
            $this->Flash->error(__('The iv could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function ItemSerialNumber($select_item_id = null){
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		$selectedSerialNumbers=$this->Ivs->IvLeftRows->IvRightRows->IvRightSerialNumbers->ItemSerialNumbers->find()->where(['item_id'=>$select_item_id,'status'=>'In','company_id'=>$st_company_id]);
		
		
		$this->set(compact('selectedSerialNumbers'));
	}
}
