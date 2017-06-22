<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FinancialMonths Controller
 *
 * @property \App\Model\Table\FinancialMonthsTable $FinancialMonths
 */
class FinancialMonthsController extends AppController
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
			$st_year_id = $session->read('st_year_id');
			$financial_year = $this->FinancialMonths->FinancialYears->find()->where(['id'=>$st_year_id])->first();
			$start_date = $financial_year->date_from;
			$lastyear = strtotime("-1 year", strtotime($start_date));
			$firstDate = date("Y-m-d", $lastyear);
			
			$last_financial_year = $this->FinancialMonths->FinancialYears->find()->where(['date_from >=' => $firstDate,'date_to <' => $start_date,'company_id' => $st_company_id])->first();
			if($last_financial_year){
				$l_year_status=$last_financial_year->status;
			}
			else{
				$l_year_status=' ';
			}
			 $this->paginate = [
            'contain' => ['FinancialYears']
        ];
        $financialMonths = $this->paginate($this->FinancialMonths->find()->where(['financial_year_id'=>$st_year_id]));
		
		$last_closed = $this->FinancialMonths->find()->select(['id'])->where(['status' => 'Closed','financial_year_id'=>$st_year_id])->order(['id' => 'DESC'])->first();
		if($last_closed){
		$l_close = $last_closed->id;
		}
        $this->set(compact('financialMonths','l_close','l_year_status'));
        $this->set('_serialize', ['financialMonths']);
    }

    /**
     * View method
     *
     * @param string|null $id Financial Month id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $financialMonth = $this->FinancialMonths->get($id, [
            'contain' => ['FinancialYears']
        ]);

        $this->set('financialMonth', $financialMonth);
        $this->set('_serialize', ['financialMonth']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $financialMonth = $this->FinancialMonths->newEntity();
        if ($this->request->is('post')) {
            $financialMonth = $this->FinancialMonths->patchEntity($financialMonth, $this->request->data);
            if ($this->FinancialMonths->save($financialMonth)) {
                $this->Flash->success(__('The financial month has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The financial month could not be saved. Please, try again.'));
            }
        }
        $financialYears = $this->FinancialMonths->FinancialYears->find('list', ['limit' => 200]);
        $this->set(compact('financialMonth', 'financialYears'));
        $this->set('_serialize', ['financialMonth']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Financial Month id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $financialMonth = $this->FinancialMonths->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $financialMonth = $this->FinancialMonths->patchEntity($financialMonth, $this->request->data);
            if ($this->FinancialMonths->save($financialMonth)) {
                $this->Flash->success(__('The financial month has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The financial month could not be saved. Please, try again.'));
            }
        }
        $financialYears = $this->FinancialMonths->FinancialYears->find('list', ['limit' => 200]);
        $this->set(compact('financialMonth', 'financialYears'));
        $this->set('_serialize', ['financialMonth']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Financial Month id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $financialMonth = $this->FinancialMonths->get($id);
        if ($this->FinancialMonths->delete($financialMonth)) {
            $this->Flash->success(__('The financial month has been deleted.'));
        } else {
            $this->Flash->error(__('The financial month could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function closed($id = null)
    {
        $financialMonth = $this->FinancialMonths->get($id);
		$financialMonth->status='Closed';
		 if ($this->FinancialMonths->save($financialMonth)) {
            $this->Flash->success(__('The Financial Month has been Closed.'));
        } else {
            $this->Flash->error(__('The Financial Month could not be Closed. Please, try again.'));
        }
		return $this->redirect(['action' => 'index']);
    }
	
	public function open($id = null)
    {
        $financialMonth = $this->FinancialMonths->get($id);
		$financialMonth->status='Open';
		 if ($this->FinancialMonths->save($financialMonth)) {
            $this->Flash->success(__('The Financial Month has been Opened.'));
        } else {
            $this->Flash->error(__('The Financial Month could not be Opened. Please, try again.'));
        }
		return $this->redirect(['action' => 'index']);
    }
}
