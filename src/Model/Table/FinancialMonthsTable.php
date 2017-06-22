<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FinancialMonths Model
 *
 * @property \Cake\ORM\Association\BelongsTo $FinancialYears
 *
 * @method \App\Model\Entity\FinancialMonth get($primaryKey, $options = [])
 * @method \App\Model\Entity\FinancialMonth newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FinancialMonth[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FinancialMonth|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FinancialMonth patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FinancialMonth[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FinancialMonth findOrCreate($search, callable $callback = null)
 */
class FinancialMonthsTable extends Table
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

        $this->table('financial_months');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('FinancialYears', [
            'foreignKey' => 'financial_year_id',
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
            ->requirePresence('month', 'create')
            ->notEmpty('month');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['financial_year_id'], 'FinancialYears'));

        return $rules;
    }
}
