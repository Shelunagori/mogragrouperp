<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PettyCashVoucherRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $PettyCashVouchers
 * @property \Cake\ORM\Association\BelongsTo $ReceivedFroms
 *
 * @method \App\Model\Entity\PettyCashVoucherRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\PettyCashVoucherRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PettyCashVoucherRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PettyCashVoucherRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PettyCashVoucherRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PettyCashVoucherRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PettyCashVoucherRow findOrCreate($search, callable $callback = null)
 */
class PettyCashVoucherRowsTable extends Table
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

        $this->table('petty_cash_voucher_rows');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('PettyCashVouchers', [
            'foreignKey' => 'petty_cash_voucher_id',
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

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->requirePresence('cr_dr', 'create')
            ->notEmpty('cr_dr');

        $validator
            ->requirePresence('narration', 'create')
            ->notEmpty('narration');

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
        $rules->add($rules->existsIn(['petty_cash_voucher_id'], 'PettyCashVouchers'));
        $rules->add($rules->existsIn(['received_from_id'], 'ReceivedFroms'));

        return $rules;
    }
}
