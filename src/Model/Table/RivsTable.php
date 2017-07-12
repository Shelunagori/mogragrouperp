<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rivs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $SaleReturns
 * @property \Cake\ORM\Association\HasMany $LeftRivs
 *
 * @method \App\Model\Entity\Riv get($primaryKey, $options = [])
 * @method \App\Model\Entity\Riv newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Riv[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Riv|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Riv patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Riv[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Riv findOrCreate($search, callable $callback = null)
 */
class RivsTable extends Table
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

        $this->table('rivs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('SaleReturns', [
            'foreignKey' => 'sale_return_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('LeftRivs', [
            'foreignKey' => 'riv_id',
			'saveStrategy' => 'replace'
        ]);
		 $this->belongsTo('RightRivs');
		 $this->belongsTo('ItemSerialNumbers');
		 $this->belongsTo('ItemLedgers');

		$this->belongsTo('Creator', [
			'className' => 'Employees',
			'foreignKey' => 'created_by',
			'propertyName' => 'creator',
		]);
		
		$this->belongsTo('Companies', [
			'foreignKey' => 'company_id',
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
            ->integer('voucher_no')
            ->requirePresence('voucher_no', 'create')
            ->notEmpty('voucher_no');

        $validator
            ->date('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

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

        return $rules;
    }
}
