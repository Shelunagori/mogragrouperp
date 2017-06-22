<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurchaseReturns Model
 *
 * @property \Cake\ORM\Association\BelongsTo $InvoiceBookings
 * @property \Cake\ORM\Association\BelongsTo $Companies
 * @property \Cake\ORM\Association\HasMany $PurchaseReturnRows
 *
 * @method \App\Model\Entity\PurchaseReturn get($primaryKey, $options = [])
 * @method \App\Model\Entity\PurchaseReturn newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PurchaseReturn[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseReturn|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchaseReturn patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseReturn[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseReturn findOrCreate($search, callable $callback = null)
 */
class PurchaseReturnsTable extends Table
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

        $this->table('purchase_returns');
        $this->displayField('id');
        $this->primaryKey('id');
		$this->belongsTo('ItemLedgers');
        $this->belongsTo('InvoiceBookings', [
            'foreignKey' => 'invoice_booking_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('LedgerAccounts');
		$this->belongsTo('Vendors');
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('PurchaseReturnRows', [
            'foreignKey' => 'purchase_return_id',
			'saveStrategy' => 'replace'
        ]);
		$this->belongsTo('Creator', [
			'className' => 'Employees',
			'foreignKey' => 'created_by',
			'propertyName' => 'creator',
		]);
		
		$this->belongsTo('ReferenceDetails');
		$this->belongsTo('ReferenceBalances');
		$this->belongsTo('Ledgers');
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
      //  $rules->add($rules->existsIn(['invoice_booking_id'], 'InvoiceBookings'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
