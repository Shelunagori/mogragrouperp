<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccountReferences Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LedgerAccounts
 *
 * @method \App\Model\Entity\AccountReference get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccountReference newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccountReference[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccountReference|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccountReference patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccountReference[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccountReference findOrCreate($search, callable $callback = null)
 */
class AccountReferencesTable extends Table
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

        $this->table('account_references');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('LedgerAccounts');
		$this->belongsTo('AccountCategories');
		$this->belongsTo('AccountGroups');
		$this->belongsTo('AccountFirstSubgroups');
		$this->belongsTo('AccountSecondSubgroups');
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
            ->requirePresence('entity_description', 'create')
            ->notEmpty('entity_description');

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
       // $rules->add($rules->existsIn(['ledger_account_id'], 'LedgerAccounts'));

        return $rules;
    }
}
