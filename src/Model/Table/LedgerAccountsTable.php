<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


/**
 * LedgerAccounts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $AccountSecondSubgroups
 * @property \Cake\ORM\Association\BelongsTo $Customers
 * @property \Cake\ORM\Association\HasMany $Ledgers
 *
 * @method \App\Model\Entity\LedgerAccount get($primaryKey, $options = [])
 * @method \App\Model\Entity\LedgerAccount newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LedgerAccount[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LedgerAccount|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LedgerAccount patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LedgerAccount[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LedgerAccount findOrCreate($search, callable $callback = null)
 */
class LedgerAccountsTable extends Table
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

        $this->table('ledger_accounts');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('AccountSecondSubgroups', [
            'foreignKey' => 'account_second_subgroup_id',
            'joinType' => 'INNER'
        ]);
		
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Ledgers', [
            'foreignKey' => 'ledger_account_id'
        ]);
		
		$this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('AccountCategories');
		$this->belongsTo('Companies');
		$this->belongsTo('AccountGroups');
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
        $rules->add($rules->existsIn(['account_second_subgroup_id'], 'AccountSecondSubgroups'));

        return $rules;
    }
}
