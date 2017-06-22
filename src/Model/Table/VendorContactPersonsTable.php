<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VendorContactPersons Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Vendors
 *
 * @method \App\Model\Entity\VendorContactPerson get($primaryKey, $options = [])
 * @method \App\Model\Entity\VendorContactPerson newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VendorContactPerson[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VendorContactPerson|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VendorContactPerson patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VendorContactPerson[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VendorContactPerson findOrCreate($search, callable $callback = null)
 */
class VendorContactPersonsTable extends Table
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

        $this->table('vendor_contact_persons');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id',
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
        //$rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['vendor_id'], 'Vendors'));

        return $rules;
    }
}
