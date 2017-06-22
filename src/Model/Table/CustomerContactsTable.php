<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerContacts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \App\Model\Entity\CustomerContact get($primaryKey, $options = [])
 * @method \App\Model\Entity\CustomerContact newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CustomerContact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CustomerContact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CustomerContact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerContact[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerContact findOrCreate($search, callable $callback = null)
 */
class CustomerContactsTable extends Table
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

        $this->table('customer_contacts');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
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
            ->requirePresence('contact_person', 'create')
            ->notEmpty('contact_person');

        $validator
            ->requirePresence('designation', 'create')
            ->notEmpty('designation');

        $validator
            ->requirePresence('telephone', 'create')
            ->notEmpty('telephone');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('mobile', 'create')
            ->notEmpty('mobile');

        $validator
            ->boolean('default_contact')
            ->requirePresence('default_contact', 'create')
            ->notEmpty('default_contact');

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
       // $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));

        return $rules;
    }
}
