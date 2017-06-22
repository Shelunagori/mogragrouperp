<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Customers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Districts
 * @property \Cake\ORM\Association\BelongsTo $CompanyGroups
 * @property \Cake\ORM\Association\BelongsTo $CustomerSegs
 * @property \Cake\ORM\Association\HasMany $CustomerContacts
 * @property \Cake\ORM\Association\HasMany $Quotations
 *
 * @method \App\Model\Entity\Customer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Customer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Customer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Customer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Customer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Customer findOrCreate($search, callable $callback = null)
 */
class CustomersTable extends Table
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

        $this->table('customers');
        $this->displayField('customer_name');
        $this->primaryKey('id');

		$this->hasOne('LedgerAccounts');
		
        $this->belongsTo('Districts', [
            'foreignKey' => 'district_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CompanyGroups', [
            'foreignKey' => 'company_group_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('CustomerGroups', [
            'foreignKey' => 'customer_groups_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CustomerSegs', [
            'foreignKey' => 'customer_seg_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Transporters', [
            'foreignKey' => 'transporter_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('CustomerContacts', [
            'foreignKey' => 'customer_id',
			'saveStrategy' => 'replace'
        ]);
        $this->hasMany('Quotations', [
            'foreignKey' => 'customer_id'
        ]);
		$this->hasMany('CustomerAddress', [
            'foreignKey' => 'customer_id',
			'saveStrategy' => 'replace'
        ]);
		
		$this->hasMany('Quotations', [
            'foreignKey' => 'customer_id',
			'saveStrategy' => 'replace'
        ]);
		
		$this->hasMany('SalesOrders', [
            'foreignKey' => 'customer_id',
			'saveStrategy' => 'replace'
        ]);
		
		$this->hasMany('Invoices', [
            'foreignKey' => 'customer_id',
			'saveStrategy' => 'replace'
        ]);
		
		$this->hasMany('Filenames', [
            'foreignKey' => 'customer_id',
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
		
		
		$this->belongsTo('ReceiptVouchers');
		$this->belongsTo('ReferenceDetails');
		$this->belongsTo('Ledgers');
		$this->belongsTo('VoucherLedgerAccounts');
		$this->belongsTo('VouchersReferences');
		
		$this->belongsToMany('Companies', [
            'foreignKey' => 'customer_id',
            'targetForeignKey' => 'company_id',
            'joinTable' => 'customer_companies'
        ]);
		
		$this->hasMany('CustomerCompanies', [
            'foreignKey' => 'customer_id'
        ]);
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
            ->requirePresence('customer_name', 'create')
            ->notEmpty('customer_name');

		$validator
            ->requirePresence('alias', 'create')
            ->notEmpty('customer_name');
		
		$validator
			->integer('payment_terms')
			->add('payment_terms', [
				'length' => [
					'rule' => ['maxLength', 2],
					'message' => '2 digit long',
				]
			])
            ->requirePresence('payment_terms', 'create')
            ->notEmpty('payment_terms');

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
        $rules->add($rules->existsIn(['district_id'], 'Districts'));
        $rules->add($rules->existsIn(['company_group_id'], 'CompanyGroups'));
        $rules->add($rules->existsIn(['customer_seg_id'], 'CustomerSegs'));

        return $rules;
    }
}
