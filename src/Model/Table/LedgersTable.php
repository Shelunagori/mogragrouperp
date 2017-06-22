<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ledgers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LedgerAccounts
 * @property \Cake\ORM\Association\BelongsTo $Vouchers
 *
 * @method \App\Model\Entity\Ledger get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ledger newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Ledger[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ledger|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ledger patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ledger[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ledger findOrCreate($search, callable $callback = null)
 */
class LedgersTable extends Table
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

        $this->table('ledgers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('LedgerAccounts', [
            'foreignKey' => 'ledger_account_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('ReferenceDetails');
		$this->belongsTo('ReferenceBalances');
		$this->belongsTo('FinancialYears');
		$this->belongsTo('VouchersReferences');
		$this->belongsTo('Invoices');
		$this->belongsTo('JournalVouchers');
		$this->belongsTo('PurchaseReturns');
		$this->belongsTo('CreditNotes');
		$this->belongsTo('DebitNotes');
		$this->belongsTo('Nppayments');
		$this->belongsTo('InvoiceBookings');
		$this->belongsTo('Receipts');
		$this->belongsTo('ContraVouchers');
		$this->belongsTo('Payments');
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
            ->decimal('debit')
            ->notEmpty('debit');

        $validator
            ->decimal('credit')
            ->notEmpty('credit');

        $validator
            ->requirePresence('voucher_source', 'create')
            ->notEmpty('voucher_source');

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
