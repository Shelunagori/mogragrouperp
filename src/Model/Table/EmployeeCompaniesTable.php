<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmployeeCompanies Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Employees
 * @property \Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\EmployeeCompany get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeeCompany newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeeCompany[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeCompany|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeCompany patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeCompany[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeCompany findOrCreate($search, callable $callback = null)
 */
class EmployeeCompaniesTable extends Table
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

        $this->table('employee_companies');
        $this->displayField('employee_id');
        $this->primaryKey(['employee_id', 'company_id']);

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
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
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));

        return $rules;
    }
}
