<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RightRivs Controller
 *
 * @property \App\Model\Table\RightRivsTable $RightRivs
 */
class RightRivsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['LeftRivs', 'Items']
        ];
        $rightRivs = $this->paginate($this->RightRivs);

        $this->set(compact('rightRivs'));
        $this->set('_serialize', ['rightRivs']);
    }

    /**
     * View method
     *
     * @param string|null $id Right Riv id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rightRiv = $this->RightRivs->get($id, [
            'contain' => ['LeftRivs', 'Items']
        ]);

        $this->set('rightRiv', $rightRiv);
        $this->set('_serialize', ['rightRiv']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rightRiv = $this->RightRivs->newEntity();
        if ($this->request->is('post')) {
            $rightRiv = $this->RightRivs->patchEntity($rightRiv, $this->request->data);
            if ($this->RightRivs->save($rightRiv)) {
                $this->Flash->success(__('The right riv has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The right riv could not be saved. Please, try again.'));
            }
        }
        $leftRivs = $this->RightRivs->LeftRivs->find('list', ['limit' => 200]);
        $items = $this->RightRivs->Items->find('list', ['limit' => 200]);
        $this->set(compact('rightRiv', 'leftRivs', 'items'));
        $this->set('_serialize', ['rightRiv']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Right Riv id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rightRiv = $this->RightRivs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rightRiv = $this->RightRivs->patchEntity($rightRiv, $this->request->data);
            if ($this->RightRivs->save($rightRiv)) {
                $this->Flash->success(__('The right riv has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The right riv could not be saved. Please, try again.'));
            }
        }
        $leftRivs = $this->RightRivs->LeftRivs->find('list', ['limit' => 200]);
        $items = $this->RightRivs->Items->find('list', ['limit' => 200]);
        $this->set(compact('rightRiv', 'leftRivs', 'items'));
        $this->set('_serialize', ['rightRiv']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Right Riv id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rightRiv = $this->RightRivs->get($id);
        if ($this->RightRivs->delete($rightRiv)) {
            $this->Flash->success(__('The right riv has been deleted.'));
        } else {
            $this->Flash->error(__('The right riv could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
