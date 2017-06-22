<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MaterialIndents Controller
 *
 * @property \App\Model\Table\MaterialIndentsTable $MaterialIndents
 */
class MaterialIndentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($status=null)
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		//pr($url); exit;
		$this->viewBuilder()->layout('index_layout');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
	
	 if($status==null or $status=='Open' ){
			$having=['total_open_rows >' => 0];
		}elseif($status=='Close'){
			$having=['total_open_rows =' => 0];
		}
	
	
	$materialIndents=$this->paginate(
			$this->MaterialIndents->find()->select(['total_open_rows' => 
				$this->MaterialIndents->find()->func()->count('MaterialIndentRows.id')])
					->leftJoinWith('MaterialIndentRows', function ($q) {
						return $q->where(['MaterialIndentRows.required_quantity >MaterialIndentRows.processed_quantity']);
					})	
					->group(['MaterialIndents.id'])
					->autoFields(true)
					->having($having)
					->where(['company_id'=>$st_company_id])
					->order(['MaterialIndents.id' => 'DESC'])
			);
	 
		//pr($MaterialIndents); exit;
	  
	
        $this->set(compact('materialIndents','url','status'));
        $this->set('_serialize', ['materialIndents']);
    }
	
/**
     * View method
     *
     * @param string|null $id Material Indent id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->layout('index_layout');
		$materialIndent = $this->MaterialIndents->get($id, [
            'contain' => ['Companies','Creator',  'MaterialIndentRows'=>['Items']]
        ]);

        $this->set('materialIndent', $materialIndent);
        $this->set('_serialize', ['materialIndent']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
	 
	public function AddNew($material=null)
    {
		
		$this->viewBuilder()->layout('index_layout');
		$pull_request=$this->request->query('pull-request');
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$mireport=$this->MaterialIndents->newEntity();
		 
		$query = $this->MaterialIndents->MaterialIndentRows->find()
			->select(['r_quantity'=>'SUM(MaterialIndentRows.required_quantity)','p_quantity'=>'SUM(MaterialIndentRows.processed_quantity)','MaterialIndentRows.item_id','Items.name'])
			->where(['MaterialIndentRows.status'=>'open'])
			->group(['MaterialIndentRows.item_id']);
		$query->matching('MaterialIndents', function ($q) use($st_company_id){
			return $q->where(['MaterialIndents.company_id' => $st_company_id]);
		});
		$MaterialIndentRows=$query->contain(['Items']);
		//pr($MaterialIndentRows->toArray()); exit;
		
	  
		if ($this->request->is(['post'])) {
			$to_be_send=$this->request->data['to_be_send'];
			$this->redirect(['controller'=>'PurchaseOrders','action' => 'add/'.json_encode($to_be_send).'']);
		}
        $this->set(compact('MaterialIndentRows','pull_request','mireport'));
        $this->set('_serialize', ['materialIndents']);
	}
    public function add($material=null)
    {
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
		if(!empty($material)){
			$Employees=$this->MaterialIndents->Employees->get($s_employee_id);
			$employee_name=$Employees->name; 
			$company=$this->MaterialIndents->Companies->get($st_company_id);
			$company_name=$company->name;
			$material_items=array();
			$materials=json_decode($material);
			foreach($materials as $key=>$value){
				$item=$this->MaterialIndents->Items->get($key);
				$item_name=$item->name;
				$material_items[]=array('item_name'=>$item_name,'item_id'=>$key,'quantity'=>$value,'company_id'=>$st_company_id,'employee_name'=>$employee_name,'company_name'=>$company_name);
			}
			//pr($material_items); exit;
			$this->set(compact('material_items'));
		}

		
		
		$materialIndent = $this->MaterialIndents->newEntity();
		
		$last_company_no=$this->MaterialIndents->find()->select(['mi_number'])->where(['company_id' => $st_company_id])->order(['mi_number' => 'DESC'])->first();
		if(!empty($last_company_no)){
			$materialIndent->mi_number=$last_company_no->mi_number+1;
		}else{
			$materialIndent->mi_number=1;
		}
		
        if ($this->request->is('post')) {
			
            $materialIndent = $this->MaterialIndents->patchEntity($materialIndent, $this->request->data);
			$materialIndent->created_by=$s_employee_id; 
			$materialIndent->created_on=date("Y-m-d");
			$materialIndent->company_id=$st_company_id;
			
			//pr($materialIndent); exit;
			
            if ($this->MaterialIndents->save($materialIndent)) {
				//pr($materialIndent); exit;
				/* foreach($materialIndent)
					{
						$query2 = $this->DebitNotes->ReferenceBalances->query();
						$query2->update()
							->set(['credit' => $this->request->data['credit'][$row]+$data[0]->credit])
							->where(['reference_no' => $this->request->data['reference_no'][$row],'ledger_account_id' => $this->request->data['sales_acc_id']])
							->execute();
					} */
				
                $this->Flash->success(__('The material indent has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else { 
                $this->Flash->error(__('The material indent could not be saved. Please, try again.'));
            }
        }
		/* $last_mi_no=$this->MaterialIndents->find()->select(['mi2'])->where(['company_id' => $st_company_id])->order(['mi2' => 'DESC'])->first();
			if($last_mi_no){
				@$last_mi_no->mi2=$last_mi_no->mi2+1;
			}else{
				@$last_mi_no->mi2=1;
			} */
		
        $companies = $this->MaterialIndents->Companies->find('list', ['limit' => 200]);
        $items = $this->MaterialIndents->Items->find('list', ['limit' => 200]);
        //$jobCards = $this->MaterialIndents->JobCards->find('list', ['limit' => 200]);
        $this->set(compact('materialIndent', 'companies','items','current_stock'));
        $this->set('_serialize', ['materialIndent']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Material Indent id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		
        $materialIndent = $this->MaterialIndents->get($id, [
            'contain' => ['MaterialIndentRows'=>['Items']]
        ]); 
        if ($this->request->is(['patch', 'post', 'put'])) {
            $materialIndent = $this->MaterialIndents->patchEntity($materialIndent, $this->request->data);
			foreach($materialIndent->material_indent_rows as $material_indent_row){
				$material_indent_row->required_quantity+=$material_indent_row->processed_quantity;
			}
			if ($this->MaterialIndents->save($materialIndent)) {
				
                $this->Flash->success(__('The material indent has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The material indent could not be saved. Please, try again.'));
            }
        }
        $companies = $this->MaterialIndents->Companies->find('list', ['limit' => 200]);
      
        $this->set(compact('materialIndent', 'companies', 'jobCards'));
        $this->set('_serialize', ['materialIndent']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Material Indent id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $materialIndent = $this->MaterialIndents->get($id);
        if ($this->MaterialIndents->delete($materialIndent)) {
            $this->Flash->success(__('The material indent has been deleted.'));
        } else {
            $this->Flash->error(__('The material indent could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function report()
	{
		$this->viewBuilder()->layout('index_layout');
		$s_employee_id=$this->viewVars['s_employee_id'];
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$mi = $this->MaterialIndents->newEntity();
		
		if ($this->request->is('post')) {
			
			$mi_data=$this->request->data['selected_data'];

 			$check=json_encode(); 
			$this->redirect(['controller'=>'PurchaseOrders','action' => 'add/'.$check.'']);
		}
		
		$materialIndents=$this->MaterialIndents->find()->contain(['MaterialIndentRows'=>['Items']])->toArray();
		$this->set(compact('materialIndents','mi'));
	}
}
