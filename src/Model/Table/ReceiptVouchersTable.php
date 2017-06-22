<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReceiptVouchers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ReceivedFroms
 * @property \Cake\ORM\Association\BelongsTo $BankCashes
 *
 * @method \App\Model\Entity\ReceiptVoucher get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReceiptVoucher newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ReceiptVoucher[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReceiptVoucher|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReceiptVoucher patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReceiptVoucher[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReceiptVoucher findOrCreate($search, callable $callback = null)
 */
class ReceiptVouchersTable extends Table
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

        $this->table('receipt_vouchers');
        $this->displayField('id');
        $this->primaryKey('id');
		
		$this->belongsTo('VouchersReferences');
		$this->belongsTo('FinancialYears');
		$this->belongsTo('Ledgers');
		$this->belongsTo('Invoices');
		$this->belongsTo('Customers');
		$this->belongsTo('ReferenceDetails');
		$this->belongsTo('ReferenceBalances');
		$this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ReceivedFroms', [
			'className' => 'LedgerAccounts',
            'foreignKey' => 'received_from_id',
            'propertyName' => 'ReceivedFrom',
        ]);
		$this->belongsTo('BankCashes', [
			'className' => 'LedgerAccounts',
            'foreignKey' => 'bank_cash_id',
            'propertyName' => 'BankCash',
        ]);
		$this->belongsTo('Creator', [
			'className' => 'Employees',
			'foreignKey' => 'created_by',
			'propertyName' => 'creator',
		]);
		$this->hasMany('ReceiptBreakups', [
            'foreignKey' => 'receipt_voucher_id',
			'saveStrategy' => 'replace'
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
            ->requirePresence('narration', 'create')
            ->notEmpty('narration');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

		 $validator
            ->requirePresence('payment_mode', 'create')
            ->notEmpty('payment_mode');
		
        $validator
            ->requirePresence('received_from_id', 'create')
            ->notEmpty('received_from_id');
		
		$validator
            ->requirePresence('bank_cash_id', 'create')
            ->notEmpty('bank_cash_id');
       
       
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
        $rules->add($rules->existsIn(['received_from_id'], 'ReceivedFroms'));
        $rules->add($rules->existsIn(['bank_cash_id'], 'BankCashes'));

        return $rules;
    }
}
