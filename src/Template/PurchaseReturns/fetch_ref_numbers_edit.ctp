<?php 
$options=[];
foreach($ReferenceBalances as $ReferenceBalance){

	if($ReferenceBalance->reference_no==$reference_no){
		$due_amount=$ReferenceBalance->credit-$ReferenceBalance->debit+$debit;
		
		
	}else{
		$due_amount=$ReferenceBalance->credit-$ReferenceBalance->debit;
		
	}
	$total=$ReferenceBalance->credit;
	
	if($due_amount>0){
		$options[]=['text' =>$ReferenceBalance->reference_no.' ( Due: '.$due_amount.', Total: '.$total.')', 'value' => $ReferenceBalance->reference_no, 'due_amount' => $due_amount];
	}
}
echo $this->Form->input('ref_no', ['empty'=>'--Select-','options'=>$options,'label' => false,'class' => 'form-control input-sm ref_list','value'=>$reference_no]); ?>

