<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContraVoucherRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ContraVouchers
 * @property \Cake\ORM\Association\BelongsTo $ReceivedFroms
 *
 * @method \App\Model\Entity\ContraVoucherRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContraVoucherRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContraVoucherRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContraVoucherRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContraVoucherRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContraVoucherRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContraVoucherRow findOrCreate($search, callable $callback = null)
 */
class ContraVoucherRowsTable extends Table
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

        $this->table('contra_voucher_rows');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('ContraVouchers', [
            'foreignKey' => 'contra_voucher_id',
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
        $rules->add($rules->existsIn(['contra_voucher_id'], 'ContraVouchers'));
        $rules->add($rules->existsIn(['received_from_id'], 'ReceivedFroms'));

        return $rules;
    }
}
