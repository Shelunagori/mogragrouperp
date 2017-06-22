<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employees Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Dipartments
 *
 * @method \App\Model\Entity\Employee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Employee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Employee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Employee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employee findOrCreate($search, callable $callback = null)
 */
class EmployeesTable extends Table
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

        $this->table('employees');
        $this->displayField('name');
        $this->primaryKey('id');

		$this->hasOne('LedgerAccounts');
		
        $this->belongsTo('Departments', [
            'foreignKey' => 'dipartment_id',
            'joinType' => 'INNER'
        ]);
		
		
		$this->belongsTo('Designations', [
            'foreignKey' => 'designation_id',
            'joinType' => 'INNER'
        ]);
		
		$this->hasMany('EmployeeContactPersons', [
            'foreignKey' => 'employee_id',
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
		
		
		$this->belongsTo('Quotations');
		$this->belongsTo('Ledgers');
		$this->belongsTo('SalesOrders');
		$this->belongsTo('Invoices');
		$this->belongsTo('VoucherLedgerAccounts');
		$this->belongsTo('VouchersReferences');
        $this->belongsTo('Logins');
        $this->belongsTo('UserLogs');
//        $this->belongsTo('UserRights');

		$this->hasMany('EmployeeCompanies', [
            'foreignKey' => 'employee_id'
        ]);
		
		$this->belongsToMany('Companies', [
            'foreignKey' => 'employee_id',
            'targetForeignKey' => 'company_id',
            'joinTable' => 'employee_companies'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('sex', 'create')
            ->notEmpty('sex');

        $validator
            ->requirePresence('mobile', 'create')
            ->notEmpty('mobile');
		
		 $validator
            ->requirePresence('email', 'create')
            ->notEmpty('email');

       
		$validator
            ->requirePresence('marital_status', 'create')
            ->notEmpty('marital_status');
			
		$validator
            ->requirePresence('dob', 'create')
            ->notEmpty('dob');
        
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
        $rules->add($rules->existsIn(['department_id'], 'Departments'));

        return $rules;
    }
}
