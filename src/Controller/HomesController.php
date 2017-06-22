<?php
namespace App\Controller;
class HomesController extends AppController
{
	public function index()
    {
       $this->viewBuilder()->layout('index_layout');
	   $Leaves = $this->Homes->RequestLeaves->find()->contain(['Employees', 'LeaveTypes']);
	    $this->set(compact('requestLeaves'));
		
    }
	
}

