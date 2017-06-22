<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * JournalVoucherRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $JournalVouchers
 * @property \Cake\ORM\Association\BelongsTo $LedgerAccounts
 *
 * @method \App\Model\Entity\JournalVoucherRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\JournalVoucherRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\JournalVoucherRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\JournalVoucherRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\JournalVoucherRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\JournalVoucherRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\JournalVoucherRow findOrCreate($search, callable $callback = null)
 */
class JournalVoucherRowsTable extends Table
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

        $this->table('journal_voucher_rows');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('JournalVouchers', [
            'foreignKey' => 'journal_voucher_id',
            'joinType' => 'INNER'
        ]);
         $this->belongsTo('LedgerAccounts', [
            'foreignKey' => 'ledger_account_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('ReceivedFroms', [
			'className' => 'LedgerAccounts',
            'foreignKey' => 'received_from_id',
            'propertyName' => 'ReceivedFrom',
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
        $rules->add($rules->existsIn(['journal_voucher_id'], 'JournalVouchers'));
		$rules->add($rules->existsIn(['received_from_id'], 'ReceivedFroms'));
       // $rules->add($rules->existsIn(['ledger_account_id'], 'LedgerAccounts'));

        return $rules;
    }
}
