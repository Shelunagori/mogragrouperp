<?php
 $this->Form->templates([
				'inputContainer' => '{{content}}'
			]); 
		
foreach($ReferenceDetails as $ReferenceDetail)
{
	//$amount=$ReferenceDetail->credit-$ReferenceDetail->debit;
	$amount=$ReferenceDetail->debit-$ReferenceDetail->credit;
	
	if($amount>0)
	{
		$itemGroups[]=['text'=>$ReferenceDetail->reference_no, 'value' =>$ReferenceDetail->reference_no,  'amount' => $amount];
	}
}
?>
<?php if(@$itemGroups){ echo $this->Form->input('against_references_no', ['empty'=>'--Select-','label' => false,'options' =>$itemGroups,'class' => 'form-control input-sm select2me']); }?>
