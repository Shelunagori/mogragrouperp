<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IvLeftSerialNumbers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $IvLeftRows
 *
 * @method \App\Model\Entity\IvLeftSerialNumber get($primaryKey, $options = [])
 * @method \App\Model\Entity\IvLeftSerialNumber newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IvLeftSerialNumber[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IvLeftSerialNumber|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IvLeftSerialNumber patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IvLeftSerialNumber[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IvLeftSerialNumber findOrCreate($search, callable $callback = null)
 */
class IvLeftSerialNumbersTable extends Table
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

        $this->table('iv_left_serial_numbers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('IvLeftRows', [
            'foreignKey' => 'iv_left_row_id',
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
            ->requirePresence('sr_number', 'create')
            ->notEmpty('sr_number');

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
        $rules->add($rules->existsIn(['iv_left_row_id'], 'IvLeftRows'));

        return $rules;
    }
}
