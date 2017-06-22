<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemSubGroups Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ItemGroups
 * @property \Cake\ORM\Association\HasMany $Items
 *
 * @method \App\Model\Entity\ItemSubGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemSubGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemSubGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemSubGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemSubGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemSubGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemSubGroup findOrCreate($search, callable $callback = null)
 */
class ItemSubGroupsTable extends Table
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

        $this->table('item_sub_groups');
        $this->displayField('name');
        $this->primaryKey('id');
		$this->belongsTo('ItemCategories', [
            'foreignKey' => 'item_category_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ItemGroups', [
            'foreignKey' => 'item_group_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'item_sub_group_id'
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['item_group_id'], 'ItemGroups'));

        return $rules;
    }
}
