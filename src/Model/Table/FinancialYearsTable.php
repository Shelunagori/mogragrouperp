<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FinancialYears Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\FinancialYear get($primaryKey, $options = [])
 * @method \App\Model\Entity\FinancialYear newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FinancialYear[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FinancialYear|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FinancialYear patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FinancialYear[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FinancialYear findOrCreate($search, callable $callback = null)
 */
class FinancialYearsTable extends Table
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

        $this->table('financial_years');
        $this->displayField('id');
        $this->primaryKey('id');
		 $this->hasMany('FinancialMonths', [
            'foreignKey' => 'financial_year_id',
			'joinType' => 'inner'
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ReceiptVouchers');
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
            ->requirePresence('date_from', 'create')
            ->notEmpty('date_from');

        $validator
            ->requirePresence('date_to', 'create')
            ->notEmpty('date_to');

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
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
