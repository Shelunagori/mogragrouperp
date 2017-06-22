<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RequestLeaves Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Employees
 * @property \Cake\ORM\Association\BelongsTo $LeaveTypes
 * @property \Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\RequestLeave get($primaryKey, $options = [])
 * @method \App\Model\Entity\RequestLeave newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RequestLeave[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RequestLeave|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RequestLeave patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RequestLeave[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RequestLeave findOrCreate($search, callable $callback = null)
 */
class RequestLeavesTable extends Table
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

        $this->table('request_leaves');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('LeaveTypes', [
            'foreignKey' => 'leave_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
		 $this->belongsTo('FinancialYears');
		 $this->belongsTo('ApproveLeaves');
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
            ->requirePresence('reason', 'create')
            ->notEmpty('reason');

       

        $validator
            ->requirePresence('leave_status', 'create')
            ->notEmpty('leave_status');

        $validator
            ->requirePresence('remarks', 'create')
            ->notEmpty('remarks');

        $validator
            ->requirePresence('half_day', 'create')
            ->notEmpty('half_day');

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
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
        $rules->add($rules->existsIn(['leave_type_id'], 'LeaveTypes'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
