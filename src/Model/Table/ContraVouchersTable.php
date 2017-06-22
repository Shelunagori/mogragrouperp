<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContraVouchers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $BankCashes
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\HasMany $ContraVoucherRows
 *
 * @method \App\Model\Entity\ContraVoucher get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContraVoucher newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContraVoucher[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContraVoucher|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContraVoucher patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContraVoucher[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContraVoucher findOrCreate($search, callable $callback = null)
 */
class ContraVouchersTable extends Table
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

        $this->table('contra_vouchers');
        $this->displayField('id');
        $this->primaryKey('id');


        $this->belongsTo('VouchersReferences');
        $this->belongsTo('FinancialYears');
        $this->belongsTo('ReferenceBalances');
        $this->belongsTo('ReferenceDetails');
        $this->belongsTo('Ledgers');
        $this->belongsTo('BankCashes', [
            'className' => 'LedgerAccounts',
            'foreignKey' => 'bank_cash_id',
            'propertyName' => 'BankCash',
        ]);
        
        $this->belongsTo('ReceivedFroms', [
            'className' => 'LedgerAccounts',
            'foreignKey' => 'received_from_id',
            'propertyName' => 'ReceivedFrom',
        ]);
        
        $this->belongsTo('Creator', [
            'className' => 'Employees',
            'foreignKey' => 'created_by',
            'propertyName' => 'creator',
        ]);
        

        
        $this->belongsTo('BankCashes', [
            'className' => 'LedgerAccounts',
            'foreignKey' => 'bank_cash_id',
            'propertyName' => 'BankCash',
        ]);

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);

        
        $this->hasMany('ContraVoucherRows', [
            'foreignKey' => 'contra_voucher_id',
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
            ->integer('voucher_no')
            ->requirePresence('voucher_no', 'create')
            ->notEmpty('voucher_no');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        $validator
            ->date('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');


        $validator
            ->integer('voucher_no')
            ->requirePresence('voucher_no', 'create')
            ->notEmpty('voucher_no');

        $validator

            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        $validator
            ->date('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        

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
        $rules->add($rules->existsIn(['bank_cash_id'], 'BankCashes'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
