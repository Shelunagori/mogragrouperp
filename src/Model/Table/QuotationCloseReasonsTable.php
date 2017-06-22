<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QuotationCloseReasons Model
 *
 * @method \App\Model\Entity\QuotationCloseReason get($primaryKey, $options = [])
 * @method \App\Model\Entity\QuotationCloseReason newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\QuotationCloseReason[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\QuotationCloseReason|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QuotationCloseReason patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\QuotationCloseReason[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\QuotationCloseReason findOrCreate($search, callable $callback = null)
 */
class QuotationCloseReasonsTable extends Table
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

        $this->table('quotation_close_reasons');
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
            ->requirePresence('reason', 'create')
            ->notEmpty('reason');

        return $validator;
    }
}
