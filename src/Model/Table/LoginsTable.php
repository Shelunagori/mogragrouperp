<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class LoginsTable extends Table
{
    public function initialize(array $config)
    {
		$this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('UserRights');
		$this->belongsTo('UserLogs');
		$this->belongsTo('RequestLeaves');
		
    }
	
	 public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('username', 'create')
            ->notEmpty('username');
		
		$validator->add(
				'username', 
				['unique' => [
					'rule' => 'validateUnique', 
					'provider' => 'table', 
					'message' => 'Not unique']
				]
			);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');
			
		 $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        return $validator;
    }
	
}