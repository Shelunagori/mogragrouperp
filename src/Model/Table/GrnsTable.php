<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Grns Model
 *
 * @property \Cake\ORM\Association\BelongsTo $PurchaseOrders
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\HasMany $GrnRows
 * @property \Cake\ORM\Association\HasMany $InvoiceBookings
 *
 * @method \App\Model\Entity\Grn get($primaryKey, $options = [])
 * @method \App\Model\Entity\Grn newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Grn[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Grn|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Grn patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Grn[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Grn findOrCreate($search, callable $callback = null)
 */
class GrnsTable extends Table
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

        $this->table('grns');
        $this->displayField('id');
        $this->primaryKey('id');

		$this->belongsTo('PurchaseOrderRows');
		$this->belongsTo('ItemLedgers');
		
        $this->belongsTo('PurchaseOrders', [
            'foreignKey' => 'purchase_order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('GrnRows', [
            'foreignKey' => 'grn_id',
			'saveStrategy' => 'replace'
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
		
		$this->belongsTo('Creator', [
			'className' => 'Employees',
			'foreignKey' => 'created_by',
			'propertyName' => 'creator',
		]);
		 $this->hasMany('ItemSerialNumbers', [
            'foreignKey' => 'grn_id',
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
            ->date('date_created')
            ->requirePresence('date_created', 'create')
            ->notEmpty('date_created');

        $validator
            ->requirePresence('grn1', 'create')
            ->notEmpty('grn1');

        $validator
            ->requirePresence('grn3', 'create')
            ->notEmpty('grn3');

        $validator
            ->requirePresence('grn4', 'create')
            ->notEmpty('grn4');

		$validator
            ->requirePresence('road_permit_no', 'create')
            ->notEmpty('road_permit_no');
			
        $validator
            ->date('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

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
        $rules->add($rules->existsIn(['purchase_order_id'], 'PurchaseOrders'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
