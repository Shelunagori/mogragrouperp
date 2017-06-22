<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * JobCardRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $JobCards
 * @property \Cake\ORM\Association\BelongsTo $SalesOrderRows
 * @property \Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\JobCardRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\JobCardRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\JobCardRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\JobCardRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\JobCardRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\JobCardRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\JobCardRow findOrCreate($search, callable $callback = null)
 */
class JobCardRowsTable extends Table
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

        $this->table('job_card_rows');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('JobCards', [
            'foreignKey' => 'job_card_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SalesOrderRows', [
            'foreignKey' => 'sales_order_row_id',
            'joinType' => 'INNER',
			'counterCache' => true
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
        $rules->add($rules->existsIn(['job_card_id'], 'JobCards'));
        //$rules->add($rules->existsIn(['job_card_row_id'], 'JobCardRows'));
        //$rules->add($rules->existsIn(['sales_order_row_id'], 'SalesOrderRows'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));

        return $rules;
    }
}
