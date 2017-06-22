<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReferenceDetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LedgerAccounts
 * @property \Cake\ORM\Association\BelongsTo $ReceiptVouchers
 * @property \Cake\ORM\Association\BelongsTo $PaymentVouchers
 * @property \Cake\ORM\Association\BelongsTo $Invoices
 * @property \Cake\ORM\Association\BelongsTo $InvoiceBookings
 * @property \Cake\ORM\Association\BelongsTo $CreditNotes
 *
 * @method \App\Model\Entity\ReferenceDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReferenceDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ReferenceDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReferenceDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReferenceDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReferenceDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReferenceDetail findOrCreate($search, callable $callback = null)
 */
class ReferenceDetailsTable extends Table
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

        $this->table('reference_details');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('LedgerAccounts', [
            'foreignKey' => 'ledger_account_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ReceiptVouchers', [
            'foreignKey' => 'receipt_voucher_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PaymentVouchers', [
            'foreignKey' => 'payment_voucher_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Invoices', [
            'foreignKey' => 'invoice_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('InvoiceBookings', [
            'foreignKey' => 'invoice_booking_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CreditNotes', [
            'foreignKey' => 'credit_note_id',
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

        $validator
            ->requirePresence('reference_type', 'create')
            ->notEmpty('reference_type');

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
        $rules->add($rules->existsIn(['receipt_voucher_id'], 'ReceiptVouchers'));
        $rules->add($rules->existsIn(['payment_voucher_id'], 'PaymentVouchers'));
        $rules->add($rules->existsIn(['invoice_id'], 'Invoices'));
        $rules->add($rules->existsIn(['invoice_booking_id'], 'InvoiceBookings'));
        $rules->add($rules->existsIn(['credit_note_id'], 'CreditNotes'));

        return $rules;
    }
}
