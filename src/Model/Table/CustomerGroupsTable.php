<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerGroups Model
 *
 * @property \Cake\ORM\Association\HasMany $Customers
 *
 * @method \App\Model\Entity\CustomerGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\CustomerGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CustomerGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CustomerGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CustomerGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerGroup findOrCreate($search, callable $callback = null)
 */
class CustomerGroupsTable extends Table
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

        $this->table('customer_groups');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Customers', [
            'foreignKey' => 'customer_group_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');
		
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
