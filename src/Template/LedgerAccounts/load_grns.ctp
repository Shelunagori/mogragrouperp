<?php 
if(!empty($grn)){
	$option='';
	foreach($grn as $grn1)
	{
        $grn_no=$grn1->grn1.'/GRN-'.str_pad($grn1->grn2, 3, '0', STR_PAD_LEFT).'/'.$grn1->grn3.'/'.$grn1->grn4;
		$option[]=['text' =>$grn_no, 'value' => $grn1->id];
	}
echo $this->Form->input('q[]', ['label'=>false,'options' => $option,'multiple' => 'multiple','class'=>'form-control select2me grns','style'=>'width:100%']);   } ?>
