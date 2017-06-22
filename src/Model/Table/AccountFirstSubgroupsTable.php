<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccountFirstSubgroups Model
 *
 * @property \Cake\ORM\Association\BelongsTo $AccountGroups
 *
 * @method \App\Model\Entity\AccountFirstSubgroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccountFirstSubgroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccountFirstSubgroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccountFirstSubgroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccountFirstSubgroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccountFirstSubgroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccountFirstSubgroup findOrCreate($search, callable $callback = null)
 */
class AccountFirstSubgroupsTable extends Table
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

        $this->table('account_first_subgroups');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('AccountGroups', [
            'foreignKey' => 'account_group_id',
            'joinType' => 'INNER'
        ]);
		
		$this->hasMany('AccountSecondSubgroups', [
            'foreignKey' => 'account_first_subgroup_id'
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
        $rules->add($rules->existsIn(['account_group_id'], 'AccountGroups'));

        return $rules;
    }
}
