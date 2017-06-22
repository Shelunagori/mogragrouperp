<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * VouchersReferences Controller
 *
 * @property \App\Model\Table\VouchersReferencesTable $VouchersReferences
 */
class VouchersReferencesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$this->viewBuilder()->layout('index_layout');
        $vouchersReferences = $this->paginate($this->VouchersReferences->find()->where(['company_id'=>$st_company_id]));
		
        $this->set(compact('vouchersReferences'));
        $this->set('_serialize', ['vouchersReferences']);
    }

    /**
     * View method
     *
     * @param string|null $id Vouchers Reference id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		
		$this->viewBuilder()->layout('index_layout');
        $vouchersReference = $this->VouchersReferences->get($id, [
            'contain' => ['VouchersReferencesGroups']
        ]);

        $this->set('vouchersReference', $vouchersReference);
        $this->set('_serialize', ['vouchersReference']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $vouchersReference = $this->VouchersReferences->newEntity();
        if ($this->request->is('post')) {
            $vouchersReference = $this->VouchersReferences->patchEntity($vouchersReference, $this->request->data);
			
            if ($this->VouchersReferences->save($vouchersReference)) {
				//pr($vouchersReference); exit;
                $this->Flash->success(__('The vouchers reference has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vouchers reference could not be saved. Please, try again.'));
            }
        }
		$accountGroups = $this->VouchersReferences->AccountGroups->find('all');
        $this->set(compact('vouchersReference','accountGroups'));
        $this->set('_serialize', ['vouchersReference']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Vouchers Reference id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$session = $this->request->session();
		$st_company_id = $session->read('st_company_id');
		$this->viewBuilder()->layout('index_layout');

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

		
        $vouchersReference = $this->VouchersReferences->get($id, [
            'contain' => ['VoucherLedgerAccounts']
        ]);
		//pr($vouchersReference); exit;
		$ledger_arr=[];
		foreach($vouchersReference->voucher_ledger_accounts as $row)
		{
		@$ledger_arr[]=$row->ledger_account_id;
		}
		//pr($ledger_arr);exit;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vouchersReference = $this->VouchersReferences->patchEntity($vouchersReference, $this->request->data);
			//pr($vouchersReference);exit;
            if ($this->VouchersReferences->save($vouchersReference)) {
				//pr($vouchersReference);exit;
                $this->Flash->success(__('The vouchers reference has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vouchers reference could not be saved. Please, try again.'));
            }
        }
		$AccountGroups = $this->VouchersReferences->AccountGroups->find('all')->contain(['AccountFirstSubgroups'=>['AccountSecondSubgroups'=>['LedgerAccounts' => function ($q) use($st_company_id){
			return $q->where(['company_id'=>$st_company_id]);
		}]]]);
        $this->set(compact('vouchersReference','AccountGroups','ledger_arr','st_company_id','chkdate'));
        $this->set('_serialize', ['vouchersReference']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Vouchers Reference id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vouchersReference = $this->VouchersReferences->get($id);
        if ($this->VouchersReferences->delete($vouchersReference)) {
            $this->Flash->success(__('The vouchers reference has been deleted.'));
        } else {
            $this->Flash->error(__('The vouchers reference could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
