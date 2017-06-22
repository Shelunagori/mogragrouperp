<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NppaymentRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Nppayments
 * @property \Cake\ORM\Association\BelongsTo $ReceivedFroms
 *
 * @method \App\Model\Entity\NppaymentRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\NppaymentRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NppaymentRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NppaymentRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NppaymentRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NppaymentRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NppaymentRow findOrCreate($search, callable $callback = null)
 */
class NppaymentRowsTable extends Table
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

        $this->table('nppayment_rows');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Receipts', [
            'foreignKey' => 'receipt_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ReceivedFroms', [
            'className' => 'LedgerAccounts',
            'foreignKey' => 'received_from_id',
            'propertyName' => 'ReceivedFrom',
        ]);

        $this->belongsTo('Nppayments', [
            'foreignKey' => 'nppayment_id',
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
        $rules->add($rules->existsIn(['nppayment_id'], 'Nppayments'));
        $rules->add($rules->existsIn(['received_from_id'], 'ReceivedFroms'));

        return $rules;
    }
}
