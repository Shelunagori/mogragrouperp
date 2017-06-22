<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SaleTaxes Model
 *
 * @method \App\Model\Entity\SaleTax get($primaryKey, $options = [])
 * @method \App\Model\Entity\SaleTax newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SaleTax[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SaleTax|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SaleTax patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SaleTax[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SaleTax findOrCreate($search, callable $callback = null)
 */
class SaleTaxesTable extends Table
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

        $this->table('sale_taxes');
        $this->displayField('tax_figure');
        $this->primaryKey('id');
		$this->hasOne('LedgerAccounts');
		
        $this->hasMany('SalesOrderRows', [
            'foreignKey' => 'sale_tax_id'
        ]);
		
		$this->hasMany('Invoices', [
            'foreignKey' => 'sale_tax_id'
        ]); 
		

		$this->belongsToMany('Companies', [
            'foreignKey' => 'sale_taxe_id',
            'targetForeignKey' => 'company_id',
            'joinTable' => 'sale_tax_companies'
        ]);
        $this->hasMany('SaleTaxCompanies', [
            'foreignKey' => 'sale_tax_id',
			'saveStrategy' => 'replace'

        ]);


		$this->belongsTo('AccountCategories', [
            'foreignKey' => 'account_category_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('AccountGroups', [
            'foreignKey' => 'account_group_id',
            'joinType' => 'INNER'
        ]);
		
		$this->belongsTo('AccountFirstSubgroups', [
			'foreignKey' => 'account_first_subgroup_id',
            'joinType' => 'INNER'
        ]);

		   
		$this->belongsTo('AccountSecondSubgroups', [
            'foreignKey' => 'account_second_subgroup_id',
            'joinType' => 'INNER'
        ]);
		
		
		
		$this->belongsTo('Ledgers');
		$this->belongsTo('VoucherLedgerAccounts');
		$this->belongsTo('VouchersReferences');

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
            ->decimal('tax_figure')
            ->requirePresence('tax_figure', 'create')
            ->notEmpty('tax_figure');

        return $validator;
    }
}
