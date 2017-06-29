<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LeftRivs Controller
 *
 * @property \App\Model\Table\LeftRivsTable $LeftRivs
 */
class LeftRivsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Rivs', 'Items']
        ];
        $leftRivs = $this->paginate($this->LeftRivs);

        $this->set(compact('leftRivs'));
        $this->set('_serialize', ['leftRivs']);
    }

    /**
     * View method
     *
     * @param string|null $id Left Riv id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leftRiv = $this->LeftRivs->get($id, [
            'contain' => ['Rivs', 'Items', 'RightRivs']
        ]);

        $this->set('leftRiv', $leftRiv);
        $this->set('_serialize', ['leftRiv']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $leftRiv = $this->LeftRivs->newEntity();
        if ($this->request->is('post')) {
            $leftRiv = $this->LeftRivs->patchEntity($leftRiv, $this->request->data);
            if ($this->LeftRivs->save($leftRiv)) {
                $this->Flash->success(__('The left riv has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The left riv could not be saved. Please, try again.'));
            }
        }
        $rivs = $this->LeftRivs->Rivs->find('list', ['limit' => 200]);
        $items = $this->LeftRivs->Items->find('list', ['limit' => 200]);
        $this->set(compact('leftRiv', 'rivs', 'items'));
        $this->set('_serialize', ['leftRiv']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Left Riv id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leftRiv = $this->LeftRivs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leftRiv = $this->LeftRivs->patchEntity($leftRiv, $this->request->data);
            if ($this->LeftRivs->save($leftRiv)) {
                $this->Flash->success(__('The left riv has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The left riv could not be saved. Please, try again.'));
            }
        }
        $rivs = $this->LeftRivs->Rivs->find('list', ['limit' => 200]);
        $items = $this->LeftRivs->Items->find('list', ['limit' => 200]);
        $this->set(compact('leftRiv', 'rivs', 'items'));
        $this->set('_serialize', ['leftRiv']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Left Riv id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leftRiv = $this->LeftRivs->get($id);
        if ($this->LeftRivs->delete($leftRiv)) {
            $this->Flash->success(__('The left riv has been deleted.'));
        } else {
            $this->Flash->error(__('The left riv could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
