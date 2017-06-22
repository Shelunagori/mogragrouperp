<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IvRightSerialNumbers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $IvRightRows
 * @property \Cake\ORM\Association\BelongsTo $ItemSerialNumbers
 *
 * @method \App\Model\Entity\IvRightSerialNumber get($primaryKey, $options = [])
 * @method \App\Model\Entity\IvRightSerialNumber newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IvRightSerialNumber[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IvRightSerialNumber|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IvRightSerialNumber patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IvRightSerialNumber[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IvRightSerialNumber findOrCreate($search, callable $callback = null)
 */
class IvRightSerialNumbersTable extends Table
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

        $this->table('iv_right_serial_numbers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('IvRightRows', [
            'foreignKey' => 'iv_right_row_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ItemSerialNumbers', [
            'foreignKey' => 'item_serial_number_id',
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
        $rules->add($rules->existsIn(['iv_right_row_id'], 'IvRightRows'));
        $rules->add($rules->existsIn(['item_serial_number_id'], 'ItemSerialNumbers'));

        return $rules;
    }
}
