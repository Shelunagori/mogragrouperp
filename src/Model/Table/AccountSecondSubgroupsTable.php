<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccountSecondSubgroups Model
 *
 * @property \Cake\ORM\Association\BelongsTo $AccountFirstSubgroups
 *
 * @method \App\Model\Entity\AccountSecondSubgroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccountSecondSubgroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccountSecondSubgroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccountSecondSubgroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccountSecondSubgroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccountSecondSubgroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccountSecondSubgroup findOrCreate($search, callable $callback = null)
 */
class AccountSecondSubgroupsTable extends Table
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

        $this->table('account_second_subgroups');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('AccountFirstSubgroups', [
            'foreignKey' => 'account_first_subgroup_id',
            'joinType' => 'INNER'
        ]);
		
		
		$this->hasMany('LedgerAccounts', [
            'foreignKey' => 'account_second_subgroup_id'
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
		
		/* $validator->add(
				'name', 
				['unique' => [
					'rule' => 'validateUnique', 
					'provider' => 'table', 
					'message' => 'Not unique']
				]
			); */
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
        $rules->add($rules->existsIn(['account_first_subgroup_id'], 'AccountFirstSubgroups'));

        return $rules;
    }
}
