<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccountCategories Model
 *
 * @property \Cake\ORM\Association\HasMany $AccountGroups
 *
 * @method \App\Model\Entity\AccountCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccountCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccountCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccountCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccountCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccountCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccountCategory findOrCreate($search, callable $callback = null)
 */
class AccountCategoriesTable extends Table
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

        $this->table('account_categories');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('AccountGroups', [
            'foreignKey' => 'account_category_id'
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
}
