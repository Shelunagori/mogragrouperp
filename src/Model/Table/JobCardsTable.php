<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * JobCards Model
 *
 * @property \Cake\ORM\Association\BelongsTo $SalesOrders
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\HasMany $JobCardRows
 *
 * @method \App\Model\Entity\JobCard get($primaryKey, $options = [])
 * @method \App\Model\Entity\JobCard newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\JobCard[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\JobCard|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\JobCard patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\JobCard[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\JobCard findOrCreate($search, callable $callback = null)
 */
class JobCardsTable extends Table
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

        $this->table('job_cards');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('SalesOrders', [
            'foreignKey' => 'sales_order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('JobCardRows', [
            'foreignKey' => 'job_card_id',
			'saveStrategy' => 'replace'
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

		$this->belongsTo('Customers');
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
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

        $validator
            ->date('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

		$validator
            ->requirePresence('dispatch_destination', 'create')
            ->notEmpty('dispatch_destination');
        
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
        $rules->add($rules->existsIn(['sales_order_id'], 'SalesOrders'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
