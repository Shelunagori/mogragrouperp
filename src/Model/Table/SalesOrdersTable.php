<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SalesOrders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\BelongsTo $Quotations
 * @property \Cake\ORM\Association\HasMany $SalesOrderRows
 *
 * @method \App\Model\Entity\SalesOrder get($primaryKey, $options = [])
 * @method \App\Model\Entity\SalesOrder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SalesOrder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SalesOrder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SalesOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SalesOrder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SalesOrder findOrCreate($search, callable $callback = null)
 */
class SalesOrdersTable extends Table
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

        $this->table('sales_orders');
        $this->displayField('id');
        $this->primaryKey('id');
		$this->belongsTo('Filenames');
		$this->belongsTo('FinancialYears');
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Carrier', [
			'className' => 'Transporters',
			'foreignKey' => 'transporter_id',
			'propertyName' => 'carrier',
		]);
		$this->belongsTo('Courier', [
			'className' => 'Transporters',
			'foreignKey' => 'documents_courier_id',
			'propertyName' => 'courier'
		]);
        $this->belongsTo('Quotations');
		$this->belongsTo('TermsConditions');
		$this->belongsTo('TaxDetails');
		
		$this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('Creator', [
			'className' => 'Employees',
			'foreignKey' => 'created_by',
			'propertyName' => 'creator',
		]);
		
		$this->belongsTo('Editor', [
			'className' => 'Employees',
			'foreignKey' => 'edited_by',
			'propertyName' => 'editor',
		]);
        $this->hasMany('SalesOrderRows', [
            'foreignKey' => 'sales_order_id',
			'saveStrategy' => 'replace'
        ]);
		$this->hasMany('Invoices', [
            'foreignKey' => 'sales_order_id',
        ]);
		$this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('SaleTaxes', [
            'foreignKey' => 'sale_tax_id',
            'joinType' => 'INNER'
        ]);
		$this->hasOne('JobCards');
		$this->hasOne('InventoryVouchers');
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
            ->requirePresence('customer_address', 'create')
            ->notEmpty('customer_address');
			
		$validator
            ->requirePresence('customer_po_no', 'create')
            ->notEmpty('customer_po_no');

        $validator
            ->decimal('total')
            ->requirePresence('total', 'create')
            ->notEmpty('total');
			
		 $validator
            ->requirePresence('road_permit_required', 'create')
            ->notEmpty('road_permit_required');


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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));
        return $rules;
    }
}
