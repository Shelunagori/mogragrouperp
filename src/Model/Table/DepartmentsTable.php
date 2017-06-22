<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Dipartments Model
 *
 * @property \Cake\ORM\Association\HasMany $Employees
 *
 * @method \App\Model\Entity\Dipartment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Dipartment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Dipartment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Dipartment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Dipartment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Dipartment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Dipartment findOrCreate($search, callable $callback = null)
 */
class DepartmentsTable extends Table
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

        $this->table('departments');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Employees', [
            'foreignKey' => 'department_id'
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

        return $validator;
    }
}
