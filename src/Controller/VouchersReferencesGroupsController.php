<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * VouchersReferencesGroups Controller
 *
 * @property \App\Model\Table\VouchersReferencesGroupsTable $VouchersReferencesGroups
 */
class VouchersReferencesGroupsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['VouchersReferences', 'AccountGroups']
        ];
        $vouchersReferencesGroups = $this->paginate($this->VouchersReferencesGroups);

        $this->set(compact('vouchersReferencesGroups'));
        $this->set('_serialize', ['vouchersReferencesGroups']);
    }

    /**
     * View method
     *
     * @param string|null $id Vouchers References Group id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vouchersReferencesGroup = $this->VouchersReferencesGroups->get($id, [
            'contain' => ['VouchersReferences', 'AccountGroups']
        ]);

        $this->set('vouchersReferencesGroup', $vouchersReferencesGroup);
        $this->set('_serialize', ['vouchersReferencesGroup']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vouchersReferencesGroup = $this->VouchersReferencesGroups->newEntity();
        if ($this->request->is('post')) {
            $vouchersReferencesGroup = $this->VouchersReferencesGroups->patchEntity($vouchersReferencesGroup, $this->request->data);
            if ($this->VouchersReferencesGroups->save($vouchersReferencesGroup)) {
                $this->Flash->success(__('The vouchers references group has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vouchers references group could not be saved. Please, try again.'));
            }
        }
        $vouchersReferences = $this->VouchersReferencesGroups->VouchersReferences->find('list', ['limit' => 200]);
        $accountGroups = $this->VouchersReferencesGroups->AccountGroups->find('list', ['limit' => 200]);
        $this->set(compact('vouchersReferencesGroup', 'vouchersReferences', 'accountGroups'));
        $this->set('_serialize', ['vouchersReferencesGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Vouchers References Group id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $vouchersReferencesGroup = $this->VouchersReferencesGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vouchersReferencesGroup = $this->VouchersReferencesGroups->patchEntity($vouchersReferencesGroup, $this->request->data);
            if ($this->VouchersReferencesGroups->save($vouchersReferencesGroup)) {
                $this->Flash->success(__('The vouchers references group has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vouchers references group could not be saved. Please, try again.'));
            }
        }
        $vouchersReferences = $this->VouchersReferencesGroups->VouchersReferences->find('list', ['limit' => 200]);
        $accountGroups = $this->VouchersReferencesGroups->AccountGroups->find('list', ['limit' => 200]);
        $this->set(compact('vouchersReferencesGroup', 'vouchersReferences', 'accountGroups'));
        $this->set('_serialize', ['vouchersReferencesGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Vouchers References Group id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vouchersReferencesGroup = $this->VouchersReferencesGroups->get($id);
        if ($this->VouchersReferencesGroups->delete($vouchersReferencesGroup)) {
            $this->Flash->success(__('The vouchers references group has been deleted.'));
        } else {
            $this->Flash->error(__('The vouchers references group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
