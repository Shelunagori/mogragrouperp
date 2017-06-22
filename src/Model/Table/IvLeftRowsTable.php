<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IvLeftRows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Ivs
 * @property \Cake\ORM\Association\BelongsTo $InvoiceRows
 * @property \Cake\ORM\Association\HasMany $IvLeftSerialNumbers
 * @property \Cake\ORM\Association\HasMany $IvRightRows
 *
 * @method \App\Model\Entity\IvLeftRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\IvLeftRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IvLeftRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IvLeftRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IvLeftRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IvLeftRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IvLeftRow findOrCreate($search, callable $callback = null)
 */
class IvLeftRowsTable extends Table
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

        $this->table('iv_left_rows');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Ivs', [
            'foreignKey' => 'iv_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('InvoiceRows', [
            'foreignKey' => 'invoice_row_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('IvLeftSerialNumbers', [
            'foreignKey' => 'iv_left_row_id'
        ]);
        $this->hasMany('IvRightRows', [
            'foreignKey' => 'iv_left_row_id'
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
        $rules->add($rules->existsIn(['iv_id'], 'Ivs'));
        $rules->add($rules->existsIn(['invoice_row_id'], 'InvoiceRows'));

        return $rules;
    }
}
