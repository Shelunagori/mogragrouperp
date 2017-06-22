<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IvRightRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $IvLeftRows
 * @property \Cake\ORM\Association\BelongsTo $Items
 * @property \Cake\ORM\Association\HasMany $IvRightSerialNumbers
 *
 * @method \App\Model\Entity\IvRightRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\IvRightRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IvRightRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IvRightRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IvRightRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IvRightRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IvRightRow findOrCreate($search, callable $callback = null)
 */
class IvRightRowsTable extends Table
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

        $this->table('iv_right_rows');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('IvLeftRows', [
            'foreignKey' => 'iv_left_row_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('IvRightSerialNumbers', [
            'foreignKey' => 'iv_right_row_id',
            'targetForeignKey' => 'item_serial_number_id',
            'joinTable' => 'iv_right_serial_numbers'
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
            ->decimal('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

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
        $rules->add($rules->existsIn(['item_id'], 'Items'));

        return $rules;
    }
}
