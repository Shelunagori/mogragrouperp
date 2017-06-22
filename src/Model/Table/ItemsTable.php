<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Items Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ItemCategories
 * @property \Cake\ORM\Association\BelongsTo $ItemGroups
 * @property \Cake\ORM\Association\BelongsTo $ItemSubGroups
 * @property \Cake\ORM\Association\BelongsTo $Units
 * @property \Cake\ORM\Association\HasMany $ItemUsedByCompanies
 *
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, callable $callback = null)
 */
class ItemsTable extends Table
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

        $this->table('items');
        $this->displayField('name');
        $this->primaryKey('id');

		$this->belongsTo('ItemCategories', [
            'foreignKey' => 'item_category_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('ItemGroups', [
            'foreignKey' => 'item_group_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('ItemSubGroups', [
            'foreignKey' => 'item_sub_group_id',
            'joinType' => 'INNER'
        ]);
       
        $this->belongsTo('Units', [
            'foreignKey' => 'unit_id',
            'joinType' => 'INNER'
        ]);
		
		
		$this->belongsToMany('Sources', [
            'foreignKey' => 'item_id',
            'targetForeignKey' => 'source_id',
            'joinTable' => 'item_sources'
        ]);
		$this->belongsToMany('Companies', [
            'foreignKey' => 'item_id',
            'targetForeignKey' => 'company_id',
            'joinTable' => 'item_companies'
        ]);
        $this->hasMany('ItemCompanies', [
            'foreignKey' => 'item_id'
        ]);
		$this->hasMany('InvoiceRows', [
            'foreignKey' => 'item_id'
        ]);
		$this->belongsTo('InventoryTransferVouchers');
		
		$this->belongsTo('QuotationRows');
		$this->belongsTo('SalesOrderRows');
		
		$this->hasMany('ItemLedgers', [
            'foreignKey' => 'item_id'
        ]);
		
		$this->hasMany('JobCardRows', [
            'foreignKey' => 'item_id'
        ]);
		$this->hasMany('ItemSerialNumbers', [
            'foreignKey' => 'item_id'
        ]);
		$this->belongsTo('FinancialYears');
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('freeze')
            ->requirePresence('freeze', 'create')
            ->notEmpty('freeze');

        

        $validator
            ->integer('minimum_quantity')
            ->requirePresence('minimum_quantity', 'create')
            ->notEmpty('minimum_quantity');

        $validator
            ->integer('maximum_quantity')
            ->requirePresence('maximum_quantity', 'create')
            ->notEmpty('maximum_quantity');


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
        $rules->add($rules->existsIn(['unit_id'], 'Units'));

        return $rules;
    }
}
