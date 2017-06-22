<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HotelExpenses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $RequestTravellings
 *
 * @method \App\Model\Entity\HotelExpense get($primaryKey, $options = [])
 * @method \App\Model\Entity\HotelExpense newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HotelExpense[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HotelExpense|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HotelExpense patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HotelExpense[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HotelExpense findOrCreate($search, callable $callback = null)
 */
class HotelExpensesTable extends Table
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

        $this->table('hotel_expenses');
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
            ->date('stay_from')
            ->requirePresence('stay_from', 'create')
            ->notEmpty('stay_from');

        $validator
            ->date('stay_to')
            ->requirePresence('stay_to', 'create')
            ->notEmpty('stay_to');

        $validator
            ->integer('no_of_day')
            ->requirePresence('no_of_day', 'create')
            ->notEmpty('no_of_day');

        $validator
            ->integer('per_day_rate')
            ->requirePresence('per_day_rate', 'create')
            ->notEmpty('per_day_rate');

        $validator
            ->integer('amount_paid')
            ->requirePresence('amount_paid', 'create')
            ->notEmpty('amount_paid');

        $validator
            ->integer('bill')
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
