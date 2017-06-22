<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccountGroups Model
 *
 * @property \Cake\ORM\Association\BelongsTo $AccountCategories
 * @property \Cake\ORM\Association\HasMany $AccountFirstSubgroups
 *
 * @method \App\Model\Entity\AccountGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccountGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccountGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccountGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccountGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccountGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccountGroup findOrCreate($search, callable $callback = null)
 */
class AccountGroupsTable extends Table
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

        $this->table('account_groups');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('AccountCategories', [
            'foreignKey' => 'account_category_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AccountFirstSubgroups', [
            'foreignKey' => 'account_group_id'
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
        $rules->add($rules->existsIn(['account_category_id'], 'AccountCategories'));

        return $rules;
    }
}
