<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TermsConditions Model
 *
 * @method \App\Model\Entity\TermsCondition get($primaryKey, $options = [])
 * @method \App\Model\Entity\TermsCondition newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TermsCondition[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TermsCondition|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TermsCondition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TermsCondition[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TermsCondition findOrCreate($search, callable $callback = null)
 */
class TermsConditionsTable extends Table
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

        $this->table('terms_conditions');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->requirePresence('text_line', 'create')
            ->notEmpty('text_line');

        return $validator;
    }
}
