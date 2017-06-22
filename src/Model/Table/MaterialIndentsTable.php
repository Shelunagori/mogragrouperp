<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MaterialIndents Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\BelongsTo $JobCards
 * @property \Cake\ORM\Association\HasMany $MaterialIndentRows
 *
 * @method \App\Model\Entity\MaterialIndent get($primaryKey, $options = [])
 * @method \App\Model\Entity\MaterialIndent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MaterialIndent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MaterialIndent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MaterialIndent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MaterialIndent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MaterialIndent findOrCreate($search, callable $callback = null)
 */
class MaterialIndentsTable extends Table
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

        $this->table('material_indents');
        $this->displayField('id');
        $this->primaryKey('id');
		$this->belongsTo('Customers');
		$this->belongsTo('Items');
		$this->belongsTo('ItemLedgers');
	   $this->belongsTo('Employees');
	   
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('MaterialIndentRows', [
            'foreignKey' => 'material_indent_id',
			'saveStrategy' => 'replace'
        ]);
		$this->belongsTo('Creator', [
			'className' => 'Employees',
			'foreignKey' => 'created_by',
			'propertyName' => 'creator',
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
            ->date('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');

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
        $rules->add($rules->existsIn(['company_id'], 'Companies'));
        //$rules->add($rules->existsIn(['job_card_id'], 'JobCards'));

        return $rules;
    }
}
