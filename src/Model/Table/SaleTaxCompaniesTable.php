<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SaleTaxCompanies Model
 *
 * @property \Cake\ORM\Association\BelongsTo $SaleTaxes
 * @property \Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\SaleTaxCompany get($primaryKey, $options = [])
 * @method \App\Model\Entity\SaleTaxCompany newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SaleTaxCompany[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SaleTaxCompany|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SaleTaxCompany patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SaleTaxCompany[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SaleTaxCompany findOrCreate($search, callable $callback = null)
 */
class SaleTaxCompaniesTable extends Table
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

        $this->table('sale_tax_companies');
        $this->displayField('sale_tax_id');
       // $this->primaryKey(['company_id']);
		$this->primaryKey(['sale_tax_id', 'company_id']);

        $this->belongsTo('SaleTaxes', [
            'foreignKey' => 'sale_tax_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['sale_tax_id'], 'SaleTaxes'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
