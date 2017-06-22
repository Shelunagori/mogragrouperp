<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vendors Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ItemGroups
 * @property \Cake\ORM\Association\HasMany $PurchaseOrders
 * @property \Cake\ORM\Association\HasMany $VendorContactPersons
 *
 * @method \App\Model\Entity\Vendor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Vendor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Vendor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Vendor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vendor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Vendor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Vendor findOrCreate($search, callable $callback = null)
 */
class VendorsTable extends Table
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

        $this->table('vendors');
        $this->displayField('company_name');
        $this->primaryKey('id');
		
		$this->hasOne('LedgerAccounts');
		$this->belongsTo('Ledgers');
        $this->belongsTo('ItemGroups', [
            'foreignKey' => 'item_group_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('VendorContactPersons', [
            'foreignKey' => 'vendor_id',
			'saveStrategy' => 'replace'
        ]);
		
		$this->belongsTo('AccountCategories', [
            'foreignKey' => 'account_category_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('AccountGroups', [
            'foreignKey' => 'account_group_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('AccountFirstSubgroups', [
			'foreignKey' => 'account_first_subgroup_id',
            'joinType' => 'INNER'
        ]);

		   
		$this->belongsTo('AccountSecondSubgroups', [
            'foreignKey' => 'account_second_subgroup_id',
            'joinType' => 'INNER'
        ]);
		
		$this->hasMany('VendorCompanies', [
            'foreignKey' => 'vendor_id'
        ]);
		
		$this->belongsToMany('Companies', [
            'foreignKey' => 'vendor_id',
            'targetForeignKey' => 'company_id',
            'joinTable' => 'vendor_companies'
        ]);
		$this->belongsTo('VoucherLedgerAccounts');
		$this->belongsTo('VouchersReferences');
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
            ->requirePresence('company_name', 'create')
            ->notEmpty('company_name');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->requirePresence('tin_no', 'create')
            ->notEmpty('tin_no');
      
        $validator
            ->requirePresence('pan_no', 'create')
            ->notEmpty('pan_no');

        $validator
            ->integer('payment_terms')
            ->requirePresence('payment_terms', 'create')
            ->notEmpty('payment_terms');

        $validator
            ->requirePresence('mode_of_payment', 'create')
            ->notEmpty('mode_of_payment');

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
        $rules->add($rules->existsIn(['item_group_id'], 'ItemGroups'));

        return $rules;
    }
}
