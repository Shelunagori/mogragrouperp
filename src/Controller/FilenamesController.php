<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Filenames Controller
 *
 * @property \App\Model\Table\FilenamesTable $Filenames
 */
class FilenamesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		
		$filename = $this->Filenames->newEntity();
        if ($this->request->is('post')) {
            $filename = $this->Filenames->patchEntity($filename, $this->request->data);
            if ($this->Filenames->save($filename)) {
                $this->Flash->success(__('The filename has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The filename could not be saved. Please, try again.'));
            }
        }
		
		$where=[];
		$filename = $this->Filenames->newEntity();
		
		$file_inc_be=$this->Filenames->find()->select(['file2'])->where(['file1' => 'BE'])->order(['file2' => 'DESC'])->first();
        $customers = $this->Filenames->Customers->find('all')->order(['Customers.customer_name' => 'ASC']);
        $this->set(compact('filename', 'customers','file_inc_be'));
        $this->set('_serialize', ['filename']);
		
        
		$file_number=$this->request->query('file_number');
		$customer=$this->request->query('customer');
		
		$this->set(compact('file_number','customer')); 
		
		
		if(!empty($file_number)){
			$where['Filenames.file2']=$file_number;
		}
		
		if(!empty($customer)){
			$where['Customers.customer_name LIKE']='%'.$customer.'%';
		}
		
		
		$this->paginate = [
            'contain' => ['Customers']
        ];
		
		$BEfilenames = $this->paginate($this->Filenames->find()->where(['file1' => 'BE'])->order(['file2' => 'DESC'])->where($where));
        $this->set(compact('BEfilenames'));
        $this->set('_serialize', ['filenames']);
    }
	
	public function index2()
    {
		$this->viewBuilder()->layout('index_layout');
		
		$filename = $this->Filenames->newEntity();
        if ($this->request->is('post')) {
            $filename = $this->Filenames->patchEntity($filename, $this->request->data);
            if ($this->Filenames->save($filename)) {
                $this->Flash->success(__('The filename has been saved.'));

                return $this->redirect(['action' => 'index2']);
            } else {
                $this->Flash->error(__('The filename could not be saved. Please, try again.'));
            }
        }
		
		
		$where=[];
		
		$file_inc_dc=$this->Filenames->find()->select(['file2'])->where(['file1' => 'DC'])->order(['file2' => 'DESC'])->first();
        $customers = $this->Filenames->Customers->find('all')->order(['Customers.customer_name' => 'ASC']);
        $this->set(compact('filename', 'customers','file_inc_dc'));
        $this->set('_serialize', ['filename']);

		$file_number=$this->request->query('file_number');
		$customer2=$this->request->query('customer'); 
		
		$this->set(compact('files2_first','files2_second','customer2')); 
		
		if(!empty($file_number)){
			$where['Filenames.file2']=$file_number;
		}
		
		if(!empty($customer)){
			$where['Customers.customer_name LIKE']='%'.$customer.'%';
		}
		
		$this->paginate = [
            'contain' => ['Customers']
        ];
		
		$DCfilenames = $this->paginate($this->Filenames->find()->where(['file1' => 'DC'])->order(['file2' => 'DESC'])->where($where));
        $this->set(compact('DCfilenames'));
        $this->set('_serialize', ['filenames']);
    }

    /**
     * View method
     *
     * @param string|null $id Filename id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $filename = $this->Filenames->get($id, [
            'contain' => ['Customers']
        ]);

        $this->set('filename', $filename);
        $this->set('_serialize', ['filename']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customers = $this->Filenames->Customers->find('list', ['limit' => 200]);
        $this->set(compact('filename', 'customers'));
        $this->set('_serialize', ['filename']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Filename id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $filename = $this->Filenames->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $filename = $this->Filenames->patchEntity($filename, $this->request->data);
            if ($this->Filenames->save($filename)) {
                $this->Flash->success(__('The filename has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The filename could not be saved. Please, try again.'));
            }
        }
        $customers = $this->Filenames->Customers->find('list', ['limit' => 200]);
        $this->set(compact('filename', 'customers'));
        $this->set('_serialize', ['filename']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Filename id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		
		
        $filename = $this->Filenames->get($id);
		$merge=$filename->file1.'-'.$filename->file2;
				//pr($merge); exit;
		$filenameQuotationsexists = $this->Filenames->Quotations->exists(['qt3' => $merge]);
		
		$filenameSalesOrdersexists = $this->Filenames->SalesOrders->exists(['so3' => $merge]);
		//pr($filenameSalesOrdersexists); exit;
		$filenameInvoicesexists = $this->Filenames->Invoices->exists(['in3' =>  $merge]);
		
		if(!$filenameQuotationsexists && !$filenameSalesOrdersexists && !$filenameInvoicesexists){
		if ($this->Filenames->delete($filename)) {
            $this->Flash->success(__('The filename has been deleted.'));
        } else {
            $this->Flash->error(__('The filename could not be deleted. Please, try again.'));
        }
		}else{
			$this->Flash->error(__('Once the Quotation/Sales-order/Invoice has generated with Filename, the Filename cannot be deleted.'));
		}

        return $this->redirect(['action' => 'index']);
    }
	
	public function delete2($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $filename = $this->Filenames->get($id);
		
		$merge=$filename->file1.'-'.$filename->file2;
		$filenameQuotationsexists = $this->Filenames->Quotations->exists(['qt3' => $merge]);
		//pr($filenameQuotationsexists);exit;
		$filenameSalesOrdersexists = $this->Filenames->SalesOrders->exists(['so3' => $merge]);
		$filenameInvoicesexists = $this->Filenames->Invoices->exists(['in3' =>  $merge]);
		
		if(!$filenameQuotationsexists && !$filenameSalesOrdersexists && !$filenameInvoicesexists){
        if ($this->Filenames->delete($filename)) {
            $this->Flash->success(__('The filename has been deleted.'));
        } else {
            $this->Flash->error(__('The filename could not be deleted. Please, try again.'));
        }
		}else{
			$this->Flash->error(__('Once the Quotation/Sales-order/Invoice has generated with Filename, the Filename cannot be deleted.'));
		}

        return $this->redirect(['action' => 'index2']);
    }
	
	public function listFilename($id = null,$rqstfrom = null){
		$this->viewBuilder()->layout('');
		if(empty($id)){ exit; }
		if($rqstfrom=='so'){ $where=['customer_id' => $id,'file1' => 'BE']; }
		elseif($rqstfrom=='in'){ $where=['customer_id' => $id,'file1' => 'BE']; }
		else{ $where=['customer_id' => $id]; }
		$files = $this->Filenames->find('list', ['valueField' => function ($row) {
				return $row['file1'] . '-' . $row['file2'];
			},
			'keyField' => function ($row) {
				return $row['file1'] . '-' . $row['file2'];
			}])->where($where);
		$this->set(compact('files'));
	}
}
