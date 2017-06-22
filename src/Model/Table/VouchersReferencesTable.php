<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VouchersReferences Model
 *
 * @property \Cake\ORM\Association\HasMany $VouchersReferencesGroups
 *
 * @method \App\Model\Entity\VouchersReference get($primaryKey, $options = [])
 * @method \App\Model\Entity\VouchersReference newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VouchersReference[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VouchersReference|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VouchersReference patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VouchersReference[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VouchersReference findOrCreate($search, callable $callback = null)
 */
class VouchersReferencesTable extends Table
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

        $this->table('vouchers_references');
        $this->displayField('id');
        $this->primaryKey('id');
		
		$this->belongsTo('AccountGroups');
		$this->hasMany('VoucherLedgerAccounts', [
            'foreignKey' => 'vouchers_reference_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsToMany('LedgerAccounts', [
            'foreignKey' => 'vouchers_reference_id',
            'targetForeignKey' => 'ledger_account_id',
            'joinTable' => 'voucher_ledger_accounts'
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
            ->requirePresence('voucher_entity', 'create')
            ->notEmpty('voucher_entity');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        return $validator;
    }
}
