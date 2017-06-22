<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Companies Model
 *
 * @property \Cake\ORM\Association\HasMany $ItemUsedByCompanies
 *
 * @method \App\Model\Entity\Company get($primaryKey, $options = [])
 * @method \App\Model\Entity\Company newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Company[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Company|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Company patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Company[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Company findOrCreate($search, callable $callback = null)
 */
class CompaniesTable extends Table
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

        $this->table('companies');
        $this->displayField('name');
        $this->primaryKey('id');
		
		$this->belongsTo('CompanyGroups', [
            'foreignKey' => 'company_group_id',
        ]);

        $this->hasMany('ItemUsedByCompanies', [
            'foreignKey' => 'company_id'
        ]);
		$this->hasMany('CompanyBanks', [
            'foreignKey' => 'company_id',
			'saveStrategy' => 'replace'
        ]);
		
		$this->hasMany('Quotations', [
            'foreignKey' => 'company_id',
			'saveStrategy' => 'replace'
        ]);
		
		$this->hasMany('SalesOrders', [
            'foreignKey' => 'company_id',
			'saveStrategy' => 'replace'
        ]);
		
		$this->hasMany('Invoices', [
            'foreignKey' => 'company_id',
			'saveStrategy' => 'replace'
        ]);

		
		
		
		$this->belongsToMany('Employees', [
            'foreignKey' => 'company_id',
            'targetForeignKey' => 'employee_id',
            'joinTable' => 'employee_companies'
        ]);
		
		$this->belongsToMany('Customers', [
            'foreignKey' => 'company_id',
            'targetForeignKey' => 'custome_id',
            'joinTable' => 'customer_companies'
        ]);

		$this->belongsToMany('Vendors', [
            'foreignKey' => 'company_id',
            'targetForeignKey' => 'vendor_id',
            'joinTable' => 'vendor_companies'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');
			
		$validator->add(
				'name', 
				['unique' => [
					'rule' => 'validateUnique', 
					'provider' => 'table', 
					'message' => 'Not unique']
				]
			);
		
		$validator
            ->requirePresence('alias', 'create')
            ->notEmpty('alias');
			
		$validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');
		
			
		$validator
			->integer('mobile_no')
            ->requirePresence('mobile_no', 'create')
            ->notEmpty('mobile_no');
			
		$validator
            ->requirePresence('email', 'create')
            ->notEmpty('email_id');
		
		$validator
            ->requirePresence('inventory_status', 'create')
            ->notEmpty('inventory_status');
			
		$validator
		   ->requirePresence('logo', 'create')
		   ->notEmpty('logo')
		   ->add('logo', [
                'validExtension' => [
                    'rule' => ['extension',['png']], // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('These files extension are allowed: .png')
                ]
			]);

        return $validator;
    }
	
	public function validationCustom($validator)
	{
		$validator->remove('logo');
		return $validator;
	}
	
}

