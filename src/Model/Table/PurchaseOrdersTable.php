<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurchaseOrders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\BelongsTo $Vendors
 * @property \Cake\ORM\Association\HasMany $Grns
 * @property \Cake\ORM\Association\HasMany $PurchaseOrderRows
 *
 * @method \App\Model\Entity\PurchaseOrder get($primaryKey, $options = [])
 * @method \App\Model\Entity\PurchaseOrder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PurchaseOrder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseOrder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchaseOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseOrder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseOrder findOrCreate($search, callable $callback = null)
 */
class PurchaseOrdersTable extends Table
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

        $this->table('purchase_orders');
        $this->displayField('id');
        $this->primaryKey('id');
		$this->belongsTo('Items');
		$this->belongsTo('LedgerAccounts');
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
		
		  $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('Filenames');
		$this->belongsTo('MaterialIndentRows');
		
        $this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('Transporters', [
            'foreignKey' => 'transporter_id',
            'joinType' => 'INNER'
        ]);
		
        $this->hasMany('Grns', [
            'foreignKey' => 'purchase_order_id'
        ]);
        $this->hasMany('PurchaseOrderRows', [
            'foreignKey' => 'purchase_order_id',
			'saveStrategy' => 'replace'
        ]);
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
            ->requirePresence('company_id', 'create')
            ->notEmpty('company_id');

		$validator
            ->requirePresence('vendor_id', 'create')
            ->notEmpty('vendor_id');
			
		$validator
            ->requirePresence('customer_id', 'create')
            ->notEmpty('customer_id');
			
        $validator
            ->requirePresence('po1', 'create')
            ->notEmpty('po1');

        $validator
            ->requirePresence('po3', 'create')
            ->notEmpty('po3');

        $validator
            ->requirePresence('po4', 'create')
            ->notEmpty('po4');
		
		$validator
            ->requirePresence('material_to_be_transported', 'create')
            ->notEmpty('material_to_be_transported');
			
		$validator
            ->requirePresence('sale_tax_per', 'create')
            ->notEmpty('sale_tax_per');
			
			
		$validator
            ->requirePresence('delivery', 'create')
            ->notEmpty('delivery');
		
		$validator
            ->requirePresence('lr_to_be_prepared_in_favour_of', 'create')
            ->notEmpty('lr_to_be_prepared_in_favour_of');
			
		$validator
            ->requirePresence('payment_terms', 'create')
            ->notEmpty('payment_terms');
			
		$validator
            ->requirePresence('road_permit_form47', 'create')
            ->notEmpty('road_permit_form47');
			
		$validator
            ->requirePresence('transporter_id', 'create')
            ->notEmpty('transporter_id');
			
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
        $rules->add($rules->existsIn(['company_id'], 'Companies'));
        $rules->add($rules->existsIn(['vendor_id'], 'Vendors'));

        return $rules;
    }
}
