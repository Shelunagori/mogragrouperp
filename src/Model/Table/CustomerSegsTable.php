<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerSegs Model
 *
 * @method \App\Model\Entity\CustomerSeg get($primaryKey, $options = [])
 * @method \App\Model\Entity\CustomerSeg newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CustomerSeg[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CustomerSeg|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CustomerSeg patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerSeg[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerSeg findOrCreate($search, callable $callback = null)
 */
class CustomerSegsTable extends Table
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

        $this->table('customer_segs');
        $this->displayField('name');
        $this->primaryKey('id');
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('flag')
            ->requirePresence('flag', 'create')
            ->notEmpty('flag');
			
		$validator->add(
				'name', 
				['unique' => [
					'rule' => 'validateUnique', 
					'provider' => 'table', 
					'message' => 'Not unique']
				]
			);

        return $validator;
    }
}
