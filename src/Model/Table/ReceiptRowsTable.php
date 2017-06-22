<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReceiptRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Receipts
 * @property \Cake\ORM\Association\BelongsTo $ReceivedFroms
 *
 * @method \App\Model\Entity\ReceiptRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReceiptRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ReceiptRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReceiptRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReceiptRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReceiptRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReceiptRow findOrCreate($search, callable $callback = null)
 */
class ReceiptRowsTable extends Table
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

        $this->table('receipt_rows');
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
        $rules->add($rules->existsIn(['receipt_id'], 'Receipts'));
        $rules->add($rules->existsIn(['received_from_id'], 'ReceivedFroms'));

        return $rules;
    }
}
