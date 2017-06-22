<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SaleReturns Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 * @property \Cake\ORM\Association\BelongsTo $SaleTaxes
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\BelongsTo $SalesOrders
 * @property \Cake\ORM\Association\BelongsTo $Employees
 * @property \Cake\ORM\Association\BelongsTo $Transporters
 * @property \Cake\ORM\Association\BelongsTo $StLedgerAccounts
 * @property \Cake\ORM\Association\HasMany $SaleReturnRows
 *
 * @method \App\Model\Entity\SaleReturn get($primaryKey, $options = [])
 * @method \App\Model\Entity\SaleReturn newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SaleReturn[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SaleReturn|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SaleReturn patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SaleReturn[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SaleReturn findOrCreate($search, callable $callback = null)
 */
class SaleReturnsTable extends Table
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
        $this->table('sale_returns');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SaleTaxes', [
            'foreignKey' => 'sale_tax_id',
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
        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Transporters', [
            'foreignKey' => 'transporter_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Invoices');
		$this->belongsTo('LedgerAccounts');
		$this->belongsTo('AccountReferences');
		$this->belongsTo('AccountFirstSubgroups');
		$this->belongsTo('AccountSecondSubgroups');
		$this->belongsTo('ReferenceDetails');
		$this->belongsTo('ReferenceBalances');
		$this->belongsTo('Ledgers');
		$this->belongsTo('ItemLedgers');
		$this->belongsTo('ItemSerialNumbers');
		$this->belongsTo('Items');
		$this->belongsTo('InventoryVouchers');

        $this->hasMany('SaleReturnRows', [
            'foreignKey' => 'sale_return_id',
			'saveStrategy'=>'replace'
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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        $rules->add($rules->existsIn(['sale_tax_id'], 'SaleTaxes'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));
        $rules->add($rules->existsIn(['sales_order_id'], 'SalesOrders'));
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
        $rules->add($rules->existsIn(['transporter_id'], 'Transporters'));

        return $rules;
    }
}
