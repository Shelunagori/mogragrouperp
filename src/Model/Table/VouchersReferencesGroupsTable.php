<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VouchersReferencesGroups Model
 *
 * @property \Cake\ORM\Association\BelongsTo $VouchersReferences
 * @property \Cake\ORM\Association\BelongsTo $AccountGroups
 *
 * @method \App\Model\Entity\VouchersReferencesGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\VouchersReferencesGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VouchersReferencesGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VouchersReferencesGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VouchersReferencesGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VouchersReferencesGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VouchersReferencesGroup findOrCreate($search, callable $callback = null)
 */
class VouchersReferencesGroupsTable extends Table
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

        $this->table('vouchers_references_groups');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('VouchersReferences', [
            'foreignKey' => 'vouchers_reference_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('LedgerAccounts', [
            'foreignKey' => 'ledger_accounts_id',
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
        $rules->add($rules->existsIn(['vouchers_reference_id'], 'VouchersReferences'));
        $rules->add($rules->existsIn(['account_group_id'], 'LedgerAccounts'));

        return $rules;
    }
}
