<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReferenceBalances Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LedgerAccounts
 *
 * @method \App\Model\Entity\ReferenceBalance get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReferenceBalance newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ReferenceBalance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReferenceBalance|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReferenceBalance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReferenceBalance[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReferenceBalance findOrCreate($search, callable $callback = null)
 */
class ReferenceBalancesTable extends Table
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

        $this->table('reference_balances');
        $this->displayField('reference_no');
        $this->primaryKey('id');

        $this->belongsTo('LedgerAccounts', [
            'foreignKey' => 'ledger_account_id',
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
            ->requirePresence('reference_no', 'create')
            ->notEmpty('reference_no');

        $validator
            ->decimal('credit')
            ->requirePresence('credit', 'create')
            ->notEmpty('credit');

        $validator
            ->decimal('debit')
            ->requirePresence('debit', 'create')
            ->notEmpty('debit');

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
        $rules->add($rules->existsIn(['ledger_account_id'], 'LedgerAccounts'));

        return $rules;
    }
}
