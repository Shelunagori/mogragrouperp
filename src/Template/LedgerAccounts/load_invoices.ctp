<?php 
if(!empty($invoice)){
	$option='';
	foreach($invoice as $invoice1)
	{
        $invoice_no=$invoice1->in1.'/IN-'.str_pad($invoice1->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice1->in3.'/'.$invoice1->in4;
		$option[]=['text' =>$invoice_no, 'value' => $invoice1->id];
	}
echo $this->Form->input('q[]', ['label'=>false,'options' => $option,'multiple' => 'multiple','class'=>'form-control select2me invoices','style'=>'width:100%']);   } ?>