<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RequestTravellings Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Employees
 * @property \Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\RequestTravelling get($primaryKey, $options = [])
 * @method \App\Model\Entity\RequestTravelling newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RequestTravelling[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RequestTravelling|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RequestTravelling patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RequestTravelling[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RequestTravelling findOrCreate($search, callable $callback = null)
 */
class RequestTravellingsTable extends Table
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

        $this->table('request_travellings');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
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
            ->requirePresence('destination', 'create')
            ->notEmpty('destination');

        $validator
            ->requirePresence('reason', 'create')
            ->notEmpty('reason');

        $validator
            ->date('request_from')
            ->requirePresence('request_from', 'create')
            ->notEmpty('request_from');

        $validator
            ->date('request_to')
            ->requirePresence('request_to', 'create')
            ->notEmpty('request_to');

        $validator
            ->date('request_date')
            ->requirePresence('request_date', 'create')
            ->notEmpty('request_date');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->decimal('total_ammount')
            ->requirePresence('total_ammount', 'create')
            ->notEmpty('total_ammount');

        $validator
            ->decimal('approved_ammount')
            ->requirePresence('approved_ammount', 'create')
            ->notEmpty('approved_ammount');

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
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
