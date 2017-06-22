<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemSerialNumbers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Items
 * @property \Cake\ORM\Association\BelongsTo $Grns
 *
 * @method \App\Model\Entity\ItemSerialNumber get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemSerialNumber newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemSerialNumber[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemSerialNumber|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemSerialNumber patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemSerialNumber[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemSerialNumber findOrCreate($search, callable $callback = null)
 */
class ItemSerialNumbersTable extends Table
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

        $this->table('item_serial_numbers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Grns', [
            'foreignKey' => 'grn_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Invoices');
		$this->belongsTo('InventoryVouchers');
		$this->belongsTo('InventoryTransferVouchers');
		$this->belongsTo('PurchaseReturns');
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
            ->requirePresence('serial_no', 'create')
            ->notEmpty('serial_no');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['grn_id'], 'Grns'));

        return $rules;
    }
}
