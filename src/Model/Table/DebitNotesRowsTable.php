<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DebitNotesRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $DebitNotes
 * @property \Cake\ORM\Association\BelongsTo $Heads
 *
 * @method \App\Model\Entity\DebitNotesRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\DebitNotesRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DebitNotesRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DebitNotesRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DebitNotesRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DebitNotesRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DebitNotesRow findOrCreate($search, callable $callback = null)
 */
class DebitNotesRowsTable extends Table
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

        $this->table('debit_notes_rows');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('DebitNotes', [
            'foreignKey' => 'debit_note_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Heads', [
			'className' => 'LedgerAccounts',
			'foreignKey' => 'head_id',
			'propertyName' => 'heads',
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
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->requirePresence('narration', 'create')
            ->notEmpty('narration');

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
        $rules->add($rules->existsIn(['debit_note_id'], 'DebitNotes'));
        $rules->add($rules->existsIn(['head_id'], 'Heads'));

        return $rules;
    }
}
