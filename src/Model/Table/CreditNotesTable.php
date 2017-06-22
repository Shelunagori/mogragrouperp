<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CreditNotes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CustomerSuppilers
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\HasMany $CreditNotesRows
 * @property \Cake\ORM\Association\HasMany $ReferenceDetails
 *
 * @method \App\Model\Entity\CreditNote get($primaryKey, $options = [])
 * @method \App\Model\Entity\CreditNote newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CreditNote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CreditNote|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CreditNote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CreditNote[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CreditNote findOrCreate($search, callable $callback = null)
 */
class CreditNotesTable extends Table
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

        $this->table('credit_notes');
        $this->displayField('id');
        $this->primaryKey('id');
		$this->belongsTo('Ledgers');
		$this->belongsTo('VouchersReferences');
		$this->belongsTo('FinancialYears');		
		$this->belongsTo('ReferenceBalances');
		$this->belongsTo('ReferenceDetails');
		
        $this->belongsTo('CustomerSuppilers', [
			'className'=>'LedgerAccounts',
            'foreignKey' => 'customer_suppiler_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Heads', [
			'className'=>'LedgerAccounts',
            'foreignKey' => 'customer_suppiler_id',
            'joinType' => 'INNER'
        ]);

		$this->belongsTo('Creator', [
			'className' => 'Employees',
			'foreignKey' => 'created_by',
			'propertyName' => 'creator',
		]);
		
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('CreditNotesRows', [
            'foreignKey' => 'credit_note_id',
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
				->requirePresence('voucher_no', 'create')
				->notEmpty('voucher_no');

			$validator
				->date('created_on')
				->requirePresence('created_on', 'create')
				->notEmpty('created_on');

			$validator
				->date('transaction_date')
				->requirePresence('transaction_date', 'create')
				->notEmpty('transaction_date');

			$validator
				->integer('created_by')
				->requirePresence('created_by', 'create')
				->notEmpty('created_by');
			/*
			$validator
				->integer('edited_by')
				->requirePresence('edited_by', 'create')
				->notEmpty('edited_by');

			$validator
				->date('edited_on')
				->requirePresence('edited_on', 'create')
				->notEmpty('edited_on');

			$validator
				->requirePresence('subject', 'create')
				->notEmpty('subject'); */

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
        $rules->add($rules->existsIn(['customer_suppiler_id'], 'CustomerSuppilers'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
