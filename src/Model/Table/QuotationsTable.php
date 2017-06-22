<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Quotations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 * @property \Cake\ORM\Association\HasMany $QuotationRows
 *
 * @method \App\Model\Entity\Quotation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Quotation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Quotation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Quotation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Quotation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Quotation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Quotation findOrCreate($search, callable $callback = null)
 */
class QuotationsTable extends Table
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

        $this->table('quotations');
        $this->displayField('ref_no');
        $this->primaryKey('id');
		
		
		$this->belongsTo('FinancialYears');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Creator', [
			'className' => 'Employees',
			'foreignKey' => 'created_by',
			'propertyName' => 'creator',
		]);
		$this->belongsTo('Editor', [
			'className' => 'Employees',
			'foreignKey' => 'edited_by',
			'propertyName' => 'editor',
		]);
		$this->belongsTo('ItemGroups', [
            'foreignKey' => 'item_group_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('TermsConditions');
		$this->belongsTo('Filenames');
		$this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('QuotationCloseReasons');
		$this->hasMany('QuotationRows', [
            'foreignKey' => 'quotation_id',
			'saveStrategy' => 'replace'
        ]);
		
		
		$this->belongsTo('Rquotations', [
			'className' => 'Quotations',
			'foreignKey' => 'quotation_id',
			'propertyName' => 'rquotations',
			'conditions' => ['Quotations.quotation_id=Rquotations.quotation_id']
		]);
		$this->belongsTo('CustomerContacts');
		
    }
	
	public $virtualFields = array(
			'full_name' => 'CONCAT(Company.name, " ", Company.alias)'
		);

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
            ->requirePresence('customer_id', 'create')
            ->notEmpty('customer_id');

        $validator
            ->requirePresence('customer_address', 'create')
            ->notEmpty('customer_address');


        $validator
            ->requirePresence('finalisation_date', 'create')
            ->notEmpty('finalisation_date');

        $validator
            ->requirePresence('customer_for_attention', 'create')
            ->notEmpty('customer_for_attention');


        $validator
            ->requirePresence('subject', 'create')
            ->notEmpty('subject');

        $validator
            ->requirePresence('text', 'create')
            ->notEmpty('text');

        $validator
            ->requirePresence('terms_conditions', 'create')
            ->notEmpty('terms_conditions');
		
		$validator
            ->requirePresence('qt3', 'create')
            ->notEmpty('qt3');
		

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));

        return $rules;
    }
}
