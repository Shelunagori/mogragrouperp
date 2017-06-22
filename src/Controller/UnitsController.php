<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Units Controller
 *
 * @property \App\Model\Table\UnitsTable $Units
 */
class UnitsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		
        $units = $this->paginate($this->Units->find()->order(['Units.name' => 'ASC']));
		
		$unit = $this->Units->newEntity();
        if ($this->request->is('post')) {
            $unit = $this->Units->patchEntity($unit, $this->request->data);
            if ($this->Units->save($unit)) {
                $this->Flash->success(__('The unit has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The unit could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('unit'));
        $this->set('_serialize', ['unit']);

        $this->set(compact('units'));
        $this->set('_serialize', ['units']);
    }

    /**
     * View method
     *
     * @param string|null $id Unit id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $unit = $this->Units->get($id, [
            'contain' => ['Items']
        ]);

        $this->set('unit', $unit);
        $this->set('_serialize', ['unit']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $unit = $this->Units->newEntity();
        if ($this->request->is('post')) {
            $unit = $this->Units->patchEntity($unit, $this->request->data);
            if ($this->Units->save($unit)) {
                $this->Flash->success(__('The unit has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The unit could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('unit'));
        $this->set('_serialize', ['unit']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Unit id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $unit = $this->Units->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $unit = $this->Units->patchEntity($unit, $this->request->data);
            if ($this->Units->save($unit)) {
                $this->Flash->success(__('The unit has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The unit could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('unit'));
        $this->set('_serialize', ['unit']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Unit id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $unit = $this->Units->get($id);
        if ($this->Units->delete($unit)) {
            $this->Flash->success(__('The unit has been deleted.'));
        } else {
            $this->Flash->error(__('The unit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
