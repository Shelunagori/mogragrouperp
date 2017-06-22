<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VisitReports Model
 *
 * @property \Cake\ORM\Association\BelongsTo $RequestTravellings
 *
 * @method \App\Model\Entity\VisitReport get($primaryKey, $options = [])
 * @method \App\Model\Entity\VisitReport newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VisitReport[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VisitReport|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VisitReport patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VisitReport[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VisitReport findOrCreate($search, callable $callback = null)
 */
class VisitReportsTable extends Table
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

        $this->table('visit_reports');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('RequestTravellings', [
            'foreignKey' => 'request_travelling_id',
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
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->requirePresence('visited_company', 'create')
            ->notEmpty('visited_company');

        $validator
            ->requirePresence('visit_person_name', 'create')
            ->notEmpty('visit_person_name');

        $validator
            ->requirePresence('descussion', 'create')
            ->notEmpty('descussion');

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
        $rules->add($rules->existsIn(['request_travelling_id'], 'RequestTravellings'));

        return $rules;
    }
}
