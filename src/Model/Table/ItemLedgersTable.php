<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemLedgers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Items
 * @property \Cake\ORM\Association\BelongsTo $Sources
 * @property \Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\ItemLedger get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemLedger newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemLedger[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemLedger|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemLedger patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemLedger[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemLedger findOrCreate($search, callable $callback = null)
 */
class ItemLedgersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('item_ledgers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('Grns');
		$this->belongsTo('InventoryVouchers');
		$this->belongsTo('Vendors');
		$this->belongsTo('Customers');
		$this->belongsTo('Invoices');
		$this->belongsTo('Challans');
		$this->belongsTo('SalesOrders');
		$this->belongsTo('JobCards');
		$this->belongsTo('SaleReturns');
		$this->belongsTo('PurchaseReturns');
		$this->belongsTo('InventoryTransferVouchers');
		$this->belongsTo('InvoiceBookings');
		
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->decimal('rate')
            ->requirePresence('rate', 'create')
            ->notEmpty('rate');

        $validator
            ->requirePresence('source_model', 'create')
            ->notEmpty('source_model');

        $validator
            ->requirePresence('in_out', 'create')
            ->notEmpty('in_out');

        $validator
            ->date('processed_on')
            ->requirePresence('processed_on', 'create')
            ->notEmpty('processed_on');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
