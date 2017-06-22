<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MaterialIndentRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $MaterialIndents
 * @property \Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\MaterialIndentRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\MaterialIndentRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MaterialIndentRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MaterialIndentRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MaterialIndentRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MaterialIndentRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MaterialIndentRow findOrCreate($search, callable $callback = null)
 */
class MaterialIndentRowsTable extends Table
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

        $this->table('material_indent_rows');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('MaterialIndents', [
            'foreignKey' => 'material_indent_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
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
        $rules->add($rules->existsIn(['material_indent_id'], 'MaterialIndents'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));

        return $rules;
    }
}
