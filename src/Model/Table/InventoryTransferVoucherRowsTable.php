<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InventoryTransferVoucherRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $InventoryTransferVouchers
 * @property \Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\InventoryTransferVoucherRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\InventoryTransferVoucherRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InventoryTransferVoucherRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InventoryTransferVoucherRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InventoryTransferVoucherRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InventoryTransferVoucherRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InventoryTransferVoucherRow findOrCreate($search, callable $callback = null)
 */
class InventoryTransferVoucherRowsTable extends Table
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

        $this->table('inventory_transfer_voucher_rows');
        $this->displayField('id');
        $this->primaryKey('id');

		
        $this->belongsTo('InventoryTransferVouchers', [
            'foreignKey' => 'inventory_transfer_voucher_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('ItemLedgers');
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
        $rules->add($rules->existsIn(['inventory_transfer_voucher_id'], 'InventoryTransferVouchers'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));

        return $rules;
    }
}
