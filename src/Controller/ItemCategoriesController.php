<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemCategories Controller
 *
 * @property \App\Model\Table\ItemCategoriesTable $ItemCategories
 */
class ItemCategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		
		$itemCategory = $this->ItemCategories->newEntity();
        if ($this->request->is('post')) {
            $itemCategory = $this->ItemCategories->patchEntity($itemCategory, $this->request->data);
            if ($this->ItemCategories->save($itemCategory)) {
                $this->Flash->success(__('The item category has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item category could not be saved. Please, try again.'));
            }
        }
		
		$where=[];
		$item_name=$this->request->query('item_name');
		$this->set(compact('item_name'));
		
		if(!empty($item_name)){
			$where['name LIKE']='%'.$item_name.'%';
		}
		//$itemname = $this->paginate($this->ItemCategories->find()
		
        $this->set(compact('itemCategory'));
        $this->set('_serialize', ['itemCategory']);
		
       
		$itemCategories = $this->paginate($this->ItemCategories->find()->where($where)->order(['ItemCategories.name' => 'ASC']));
        $this->set(compact('itemCategories'));
        $this->set('_serialize', ['itemCategories']);
    }

    /**
     * View method
     *
     * @param string|null $id Item Category id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemCategory = $this->ItemCategories->get($id, [
            'contain' => ['ItemGroups', 'Items']
        ]);

        $this->set('itemCategory', $itemCategory);
        $this->set('_serialize', ['itemCategory']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemCategory = $this->ItemCategories->newEntity();
        if ($this->request->is('post')) {
            $itemCategory = $this->ItemCategories->patchEntity($itemCategory, $this->request->data);
            if ($this->ItemCategories->save($itemCategory)) {
                $this->Flash->success(__('The item category has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item category could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('itemCategory'));
        $this->set('_serialize', ['itemCategory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Category id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		
        $itemCategory = $this->ItemCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemCategory = $this->ItemCategories->patchEntity($itemCategory, $this->request->data);
            if ($this->ItemCategories->save($itemCategory)) {
                $this->Flash->success(__('The item category has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item category could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('itemCategory'));
        $this->set('_serialize', ['itemCategory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$ItemGroupsexists = $this->ItemCategories->ItemGroups->exists(['item_category_id' => $id]);
		if(!$ItemGroupsexists){
			$itemCategory = $this->ItemCategories->get($id);
			if ($this->ItemCategories->delete($itemCategory)) {
				$this->Flash->success(__('The item category has been deleted.'));
			} else {
				$this->Flash->error(__('The item category could not be deleted. Please, try again.'));
			}
		}else{
			$this->Flash->error(__('Once the item groups has generated with item categories, the item categories cannot be deleted.'));
		}
        

        return $this->redirect(['action' => 'index']);
    }
}
