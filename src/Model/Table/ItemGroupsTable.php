<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemGroups Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ItemCategories
 * @property \Cake\ORM\Association\HasMany $ItemSubGroups
 * @property \Cake\ORM\Association\HasMany $Items
 *
 * @method \App\Model\Entity\ItemGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemGroup findOrCreate($search, callable $callback = null)
 */
class ItemGroupsTable extends Table
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

        $this->table('item_groups');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('ItemCategories', [
            'foreignKey' => 'item_category_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ItemSubGroups', [
            'foreignKey' => 'item_group_id'
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'item_group_id'
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
        $rules->add($rules->existsIn(['item_category_id'], 'ItemCategories'));

        return $rules;
    }
}
