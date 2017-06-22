<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Invoices Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\BelongsTo $SalesOrders
 * @property \Cake\ORM\Association\HasMany $InvoiceRows
 *
 * @method \App\Model\Entity\Invoice get($primaryKey, $options = [])
 * @method \App\Model\Entity\Invoice newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Invoice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invoice|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice findOrCreate($search, callable $callback = null)
 */
class InvoicesTable extends Table
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

        $this->table('invoices');
        $this->displayField('id');
        $this->primaryKey('id');

		$this->belongsTo('CustomerGroups');
		$this->belongsTo('ItemLedgers');
		$this->belongsTo('Ledgers');
		$this->belongsTo('ReferenceDetails');
		$this->belongsTo('ReferenceBalances');
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SalesOrders', [
            'foreignKey' => 'sales_order_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('TermsConditions');
		$this->belongsTo('SalesOrderRows');
		$this->belongsTo('Transporters', [
            'foreignKey' => 'transporter_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('InvoiceRows', [
            'foreignKey' => 'invoice_id',
			'saveStrategy' => 'replace'
        ]);
		
		$this->hasMany('InvoiceBreakups', [
            'foreignKey' => 'invoice_id',
			'saveStrategy' => 'replace'
        ]);
		$this->hasMany('ItemSerialNumbers');
		$this->belongsTo('SaleTaxes');
		$this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('Creator', [
			'className' => 'Employees',
			'foreignKey' => 'created_by',
			'propertyName' => 'creator',
		]);
		
		$this->belongsTo('SaleTaxes', [
            'foreignKey' => 'sale_tax_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('InventoryVouchers', [
            'foreignKey' => 'invoice_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('AccountReferences');
		$this->belongsTo('AccountFirstSubgroups');
		$this->belongsTo('AccountSecondSubgroups');
		$this->belongsTo('LedgerAccounts');
		$this->belongsTo('ReceiptVouchers');
		$this->belongsTo('Ledgers');
		$this->belongsTo('SaleReturns');
		
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
            ->decimal('total')
            ->requirePresence('total', 'create')
            ->notEmpty('total');

        $validator
            ->requirePresence('process_status', 'create')
            ->notEmpty('process_status');
			
		$validator
          ->notEmpty('description');

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
