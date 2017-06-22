<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transporters Model
 *
 * @method \App\Model\Entity\Transporter get($primaryKey, $options = [])
 * @method \App\Model\Entity\Transporter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Transporter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transporter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transporter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Transporter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transporter findOrCreate($search, callable $callback = null)
 */
class TransportersTable extends Table
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

        $this->table('transporters');
        $this->displayField('transporter_name');
        $this->primaryKey('id');
		
		$this->belongsTo('SalesOrders');
		$this->belongsTo('Customers');
		$this->belongsTo('CustomerAddress');
		
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
            ->requirePresence('transporter_name', 'create')
            ->notEmpty('transporter_name');

        $validator
			->integer('mobile')
            ->requirePresence('mobile', 'create')
            ->notEmpty('mobile');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        return $validator;
    }
}
