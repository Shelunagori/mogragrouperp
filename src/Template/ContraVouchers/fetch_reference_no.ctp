<?php
 $this->Form->templates([
				'inputContainer' => '{{content}}'
			]); 
		
foreach($ReferenceBalances as $ReferenceBalance)
{
	$amount=$ReferenceBalance->credit-$ReferenceBalance->debit;
	
	
	if($amount>0)
	{
		$itemGroups[]=['text'=>$ReferenceBalance->reference_no, 'value' =>$ReferenceBalance->reference_no,  'amount' => $amount];
	}
}

?>
<?php if(@$itemGroups){ echo $this->Form->input('against_references_no', ['empty'=>'--Select-','label' => false,'options' =>$itemGroups,'class' => 'form-control input-sm select2me']); } ?>
