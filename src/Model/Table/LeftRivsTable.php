<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LeftRivs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Rivs
 * @property \Cake\ORM\Association\BelongsTo $Items
 * @property \Cake\ORM\Association\HasMany $RightRivs
 *
 * @method \App\Model\Entity\LeftRiv get($primaryKey, $options = [])
 * @method \App\Model\Entity\LeftRiv newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LeftRiv[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeftRiv|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeftRiv patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LeftRiv[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeftRiv findOrCreate($search, callable $callback = null)
 */
class LeftRivsTable extends Table
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

        $this->table('left_rivs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Rivs', [
            'foreignKey' => 'riv_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('RightRivs', [
            'foreignKey' => 'left_riv_id',
			'saveStrategy' => 'replace'
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

       /*  $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity'); */

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
        $rules->add($rules->existsIn(['riv_id'], 'Rivs'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));

        return $rules;
    }
}
