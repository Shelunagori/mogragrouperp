<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challans Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\BelongsTo $Invoices
 * @property \Cake\ORM\Association\BelongsTo $Transporters
 *
 * @method \App\Model\Entity\Challan get($primaryKey, $options = [])
 * @method \App\Model\Entity\Challan newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Challan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Challan|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Challan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Challan[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Challan findOrCreate($search, callable $callback = null)
 */
class ChallansTable extends Table
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

        $this->table('challans');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'LEFT'
        ]);
		 $this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Invoices', [
            'foreignKey' => 'invoice_id',
            'joinType' => 'LEFT'
        ]);
		$this->belongsTo('InvoiceBookings', [
            'foreignKey' => 'invoice_booking_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Transporters', [
            'foreignKey' => 'transporter_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
		
		 $this->hasMany('ChallanRows', [
            'foreignKey' => 'challan_id',
			'saveStrategy' => 'replace'
        ]);
		
		$this->belongsTo('Creator', [
			'className' => 'Employees',
			'foreignKey' => 'created_by',
			'propertyName' => 'creator',
		]);
			
		$this->belongsTo('Filenames');
		$this->belongsTo('ItemLedgers');
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
            ->requirePresence('lr_no', 'create')
            ->notEmpty('lr_no');

		$validator
            ->requirePresence('transporter_id', 'create')
            ->notEmpty('transporter_id');
		
		$validator
            ->requirePresence('challan_type', 'create')
            ->notEmpty('challan_type');
		
        $validator
            ->requirePresence('reference_detail', 'create')
            ->notEmpty('reference_detail');

        $validator
            ->decimal('total')
            ->requirePresence('total', 'create')
            ->notEmpty('total');

        $validator
            ->requirePresence('documents', 'create')
            ->notEmpty('documents');
		
	

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
        $rules->add($rules->existsIn(['transporter_id'], 'Transporters'));

        return $rules;
    }
}
