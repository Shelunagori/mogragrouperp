<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TermsConditions Controller
 *
 * @property \App\Model\Table\TermsConditionsTable $TermsConditions
 */
class TermsConditionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		
		$termsCondition = $this->TermsConditions->newEntity();
        if ($this->request->is('post')) {
            $termsCondition = $this->TermsConditions->patchEntity($termsCondition, $this->request->data);
            if ($this->TermsConditions->save($termsCondition)) {
                $this->Flash->success(__('The terms condition has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The terms condition could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('termsCondition'));
        $this->set('_serialize', ['termsCondition']);
		
        $termsConditions = $this->paginate($this->TermsConditions);

        $this->set(compact('termsConditions'));
        $this->set('_serialize', ['termsConditions']);
    }

    /**
     * View method
     *
     * @param string|null $id Terms Condition id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $termsCondition = $this->TermsConditions->get($id, [
            'contain' => []
        ]);

        $this->set('termsCondition', $termsCondition);
        $this->set('_serialize', ['termsCondition']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $termsCondition = $this->TermsConditions->newEntity();
        if ($this->request->is('post')) {
            $termsCondition = $this->TermsConditions->patchEntity($termsCondition, $this->request->data);
            if ($this->TermsConditions->save($termsCondition)) {
                $this->Flash->success(__('The terms condition has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The terms condition could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('termsCondition'));
        $this->set('_serialize', ['termsCondition']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Terms Condition id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $termsCondition = $this->TermsConditions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $termsCondition = $this->TermsConditions->patchEntity($termsCondition, $this->request->data);
            if ($this->TermsConditions->save($termsCondition)) {
                $this->Flash->success(__('The terms condition has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The terms condition could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('termsCondition'));
        $this->set('_serialize', ['termsCondition']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Terms Condition id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $termsCondition = $this->TermsConditions->get($id);
        if ($this->TermsConditions->delete($termsCondition)) {
            $this->Flash->success(__('The terms condition has been deleted.'));
        } else {
            $this->Flash->error(__('The terms condition could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
