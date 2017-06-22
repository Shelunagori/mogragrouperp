<script>
	$('select').select2();
</script>
<div class="form-group">
	<label class="control-label">Invoice No. <span class="required" aria-required="true">*</span></label>
	<div class="row">
		<?php 
			$options=array();
			foreach($Invoices as $invoice){ 
			$merge=(($invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4));
			$options[]=['text' =>$merge, 'value' => $invoice->id];
			} 
			echo $this->Form->input('invoice_id', ['empty' => "--Select--",'label' => false,'options' => $options,'class' => 'form-control input-sm invoice_id select2me']); ?>
	</div>
</div>