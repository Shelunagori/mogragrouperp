<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InventoryTransferVouchers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\HasMany $InventoryTransferVoucherRows
 *
 * @method \App\Model\Entity\InventoryTransferVoucher get($primaryKey, $options = [])
 * @method \App\Model\Entity\InventoryTransferVoucher newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InventoryTransferVoucher[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InventoryTransferVoucher|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InventoryTransferVoucher patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InventoryTransferVoucher[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InventoryTransferVoucher findOrCreate($search, callable $callback = null)
 */
class InventoryTransferVouchersTable extends Table
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

        $this->table('inventory_transfer_vouchers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);

		$this->hasMany('InventoryTransferVoucherRows', [
            'foreignKey' => 'inventory_transfer_voucher_id',
            'saveStrategy' => 'replace'
        ]);
		
        //$this->belongsTo('InventoryTransferVoucherRows');
		$this->belongsTo('Items');
		$this->belongsTo('ItemLedgers');
		$this->belongsTo('ItemSerialNumbers');
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
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
