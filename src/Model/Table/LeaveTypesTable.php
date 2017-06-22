<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LeaveTypes Model
 *
 * @method \App\Model\Entity\LeaveType get($primaryKey, $options = [])
 * @method \App\Model\Entity\LeaveType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LeaveType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeaveType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeaveType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LeaveType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeaveType findOrCreate($search, callable $callback = null)
 */
class LeaveTypesTable extends Table
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

        $this->table('leave_types');
        $this->displayField('leave_name');
        $this->primaryKey('id');
		$this->belongsTo('Employees');
		$this->belongsTo('Ledgers');
		$this->belongsTo('Payments');
		$this->belongsTo('ReferenceBalances');
		$this->belongsTo('ReferenceDetails');
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
            ->requirePresence('leave_name', 'create')
            ->notEmpty('leave_name');

        $validator
            ->decimal('maximum_leave_in_month')
            ->requirePresence('maximum_leave_in_month', 'create')
            ->notEmpty('maximum_leave_in_month');

        return $validator;
    }
}
