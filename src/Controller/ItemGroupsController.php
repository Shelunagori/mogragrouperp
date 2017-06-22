<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemGroups Controller
 *
 * @property \App\Model\Table\ItemGroupsTable $ItemGroups
 */
class ItemGroupsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		$itemGroup = $this->ItemGroups->newEntity();
        if ($this->request->is('post')) {
            $itemGroup = $this->ItemGroups->patchEntity($itemGroup, $this->request->data);
            if ($this->ItemGroups->save($itemGroup)) {
                $this->Flash->success(__('The item group has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item group could not be saved. Please, try again.'));
            }
        }
		
		$where=[];
		$item_category=$this->request->query('item_category');
		$item_group=$this->request->query('item_group');
		 
		$this->set(compact('item_category','item_group'));
		
		if(!empty($item_category)){
			$where['ItemCategories.name LIKE']='%'.$item_category.'%';
		}
		
		
		if(!empty($item_group)){
			$where['ItemGroups.name LIKE']='%'.$item_group.'%';
		}
		
        $itemCategories = $this->ItemGroups->ItemCategories->find('list', ['limit' => 200]);
        $this->set(compact('itemGroup', 'itemCategories'));
        $this->set('_serialize', ['itemGroup']);
		
        $this->paginate = [
            'contain' => ['ItemCategories']
        ];
        $itemGroups = $this->paginate($this->ItemGroups->find()->where($where)->order(['ItemGroups.name' => 'ASC']));

        $this->set(compact('itemGroups'));
        $this->set('_serialize', ['itemGroups']);
    }

    /**
     * View method
     *
     * @param string|null $id Item Group id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemGroup = $this->ItemGroups->get($id, [
            'contain' => ['ItemCategories', 'ItemSubGroups', 'Items']
        ]);

        $this->set('itemGroup', $itemGroup);
        $this->set('_serialize', ['itemGroup']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemGroup = $this->ItemGroups->newEntity();
        if ($this->request->is('post')) {
            $itemGroup = $this->ItemGroups->patchEntity($itemGroup, $this->request->data);
            if ($this->ItemGroups->save($itemGroup)) {
                $this->Flash->success(__('The item group has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item group could not be saved. Please, try again.'));
            }
        }
        $itemCategories = $this->ItemGroups->ItemCategories->find('list', ['limit' => 200]);
        $this->set(compact('itemGroup', 'itemCategories'));
        $this->set('_serialize', ['itemGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Group id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $itemGroup = $this->ItemGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemGroup = $this->ItemGroups->patchEntity($itemGroup, $this->request->data);
            if ($this->ItemGroups->save($itemGroup)) {
                $this->Flash->success(__('The item group has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The item group could not be saved. Please, try again.'));
            }
        }
        $itemCategories = $this->ItemGroups->ItemCategories->find('list', ['limit' => 200]);
        $this->set(compact('itemGroup', 'itemCategories'));
        $this->set('_serialize', ['itemGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Group id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		$ItemSubGroupsexists = $this->ItemGroups->ItemSubGroups->exists(['item_group_id' => $id]);
		if(!$ItemSubGroupsexists){
			$itemGroup = $this->ItemGroups->get($id);
			if ($this->ItemGroups->delete($itemGroup)) {
				$this->Flash->success(__('The item group has been deleted.'));
			} else {
				$this->Flash->error(__('The item group could not be deleted. Please, try again.'));
			}	
		}else{
			$this->Flash->error(__('Once the item sub groups has generated with item group, the item group cannot be deleted.'));
		}
        

        return $this->redirect(['action' => 'index']);
    }
	
	public function ItemGroupDropdown($itemCategoryId = null)
    {
        $this->viewBuilder()->layout('');
		$itemGroups = $this->ItemGroups->find('list')->where(['item_category_id'=>$itemCategoryId])->order(['ItemGroups.name' => 'ASC']);
		$this->set(compact('itemGroups'));
    }
}
