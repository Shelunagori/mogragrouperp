<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InvoiceBookings Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Grns
 *
 * @method \App\Model\Entity\InvoiceBooking get($primaryKey, $options = [])
 * @method \App\Model\Entity\InvoiceBooking newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InvoiceBooking[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceBooking|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InvoiceBooking patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceBooking[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceBooking findOrCreate($search, callable $callback = null)
 */
class InvoiceBookingsTable extends Table
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

        $this->table('invoice_bookings');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Grns', [
            'foreignKey' => 'grn_id',
            'joinType' => 'INNER'
        ]);
		
		$this->hasMany('InvoiceBookingRows', [
            'foreignKey' => 'invoice_booking_id',
			'saveStrategy' => 'replace'
        ]);
		
		$this->belongsTo('Creator', [
			'className' => 'Employees',
			'foreignKey' => 'created_by',
			'propertyName' => 'creator',
		]);
		
		$this->belongsTo('PurchaseOrders', [
            'foreignKey' => 'purchase_order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('GrnRows', [
            'foreignKey' => 'grn_id'
        ]);
        $this->hasMany('InvoiceBookings', [
            'foreignKey' => 'grn_id'
        ]);
		
		$this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('ItemLedgers');
		$this->belongsTo('AccountReferences');
		$this->belongsTo('Ledgers');
		$this->belongsTo('ReferenceBalances');
		$this->belongsTo('ReferenceDetails');
		$this->belongsTo('LedgerAccounts');
		
		$this->hasMany('InvoiceBookingRows', [
            'foreignKey' => 'invoice_booking_id',
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
            ->requirePresence('invoice_no', 'create')
            ->notEmpty('invoice_no');

        $validator
            ->date('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

		 $validator
			->requirePresence('supplier_date', 'create')
            ->notEmpty('supplier_date');

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
        $rules->add($rules->existsIn(['grn_id'], 'Grns'));

        return $rules;
    }
}
