<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ConveyanceExpenses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $RequestTravellings
 *
 * @method \App\Model\Entity\ConveyanceExpense get($primaryKey, $options = [])
 * @method \App\Model\Entity\ConveyanceExpense newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ConveyanceExpense[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ConveyanceExpense|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ConveyanceExpense patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ConveyanceExpense[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ConveyanceExpense findOrCreate($search, callable $callback = null)
 */
class ConveyanceExpensesTable extends Table
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

        $this->table('conveyance_expenses');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('RequestTravellings', [
            'foreignKey' => 'request_travelling_id',
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
            ->date('date_of_departure')
            ->requirePresence('date_of_departure', 'create')
            ->notEmpty('date_of_departure');

        $validator
            ->date('date_of_arrival')
            ->requirePresence('date_of_arrival', 'create')
            ->notEmpty('date_of_arrival');

        $validator
            ->requirePresence('transport_from', 'create')
            ->notEmpty('transport_from');

        $validator
            ->requirePresence('transport_to', 'create')
            ->notEmpty('transport_to');

        $validator
            ->requirePresence('transport_maode', 'create')
            ->notEmpty('transport_maode');

        $validator
            ->integer('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->requirePresence('bill', 'create')
            ->notEmpty('bill');

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
        $rules->add($rules->existsIn(['request_travelling_id'], 'RequestTravellings'));

        return $rules;
    }
}
