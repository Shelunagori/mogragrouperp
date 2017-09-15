<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NewItem Model
 *
 * @method \App\Model\Entity\NewItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\NewItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NewItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NewItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NewItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NewItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NewItem findOrCreate($search, callable $callback = null)
 */
class NewItemTable extends Table
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

        $this->table('new_item');
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
            ->requirePresence('id', 'create')
            ->notEmpty('id');

        $validator
            ->integer('hsn_code')
            ->requirePresence('hsn_code', 'create')
            ->notEmpty('hsn_code');

        return $validator;
    }
}
