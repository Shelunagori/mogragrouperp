<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VoucherLedgerAccounts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $VouchersReferences
 * @property \Cake\ORM\Association\BelongsTo $LedgerAccounts
 *
 * @method \App\Model\Entity\VoucherLedgerAccount get($primaryKey, $options = [])
 * @method \App\Model\Entity\VoucherLedgerAccount newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VoucherLedgerAccount[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VoucherLedgerAccount|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VoucherLedgerAccount patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VoucherLedgerAccount[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VoucherLedgerAccount findOrCreate($search, callable $callback = null)
 */
class VoucherLedgerAccountsTable extends Table
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

        $this->table('voucher_ledger_accounts');
        $this->displayField('vouchers_reference_id');
        $this->primaryKey(['vouchers_reference_id', 'ledger_account_id']);

        $this->belongsTo('VouchersReferences', [
            'foreignKey' => 'vouchers_reference_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('LedgerAccounts', [
            'foreignKey' => 'ledger_account_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['ledger_account_id'], 'LedgerAccounts'));

        return $rules;
    }
}
