<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmployeeContactPersons Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\EmployeeContactPerson get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeeContactPerson newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeeContactPerson[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeContactPerson|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeContactPerson patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeContactPerson[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeContactPerson findOrCreate($search, callable $callback = null)
 */
class EmployeeContactPersonsTable extends Table
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

        $this->table('employee_contact_persons');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
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
            ->integer('mobile')
            ->requirePresence('mobile', 'create')
            ->notEmpty('mobile');

		$validator
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('relation', 'create')
            ->notEmpty('relation');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    
}
