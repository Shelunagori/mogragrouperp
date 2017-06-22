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
				foreach($iv->iv_left_rows as $iv_left_row){
					foreach($iv_left_row->iv_right_rows as $iv_right_row){
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
