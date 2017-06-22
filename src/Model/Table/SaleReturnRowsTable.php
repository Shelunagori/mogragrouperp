<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SaleReturnRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $SaleReturns
 * @property \Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\SaleReturnRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\SaleReturnRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SaleReturnRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SaleReturnRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SaleReturnRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SaleReturnRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SaleReturnRow findOrCreate($search, callable $callback = null)
 */
class SaleReturnRowsTable extends Table
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

        $this->table('sale_return_rows');
        $this->displayField('id');
        $this->primaryKey('id');
		$this->belongsTo('ItemSerialnumbers');
        $this->belongsTo('SaleReturns', [
            'foreignKey' => 'sale_return_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['sale_return_id'], 'SaleReturns'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));

        return $rules;
    }
}
