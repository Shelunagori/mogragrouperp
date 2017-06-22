<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InvoiceBookingRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $InvoiceBookings
 * @property \Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\InvoiceBookingRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\InvoiceBookingRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InvoiceBookingRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceBookingRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InvoiceBookingRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceBookingRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceBookingRow findOrCreate($search, callable $callback = null)
 */
class InvoiceBookingRowsTable extends Table
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
		$this->primaryKey('id');
        $this->table('invoice_booking_rows');
      

        $this->belongsTo('InvoiceBookings', [
            'foreignKey' => 'invoice_booking_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('InvoiceBookings');
		
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
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->decimal('rate')
            ->requirePresence('rate', 'create')
            ->notEmpty('rate');

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
        $rules->add($rules->existsIn(['invoice_booking_id'], 'InvoiceBookings'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));

        return $rules;
    }
}
