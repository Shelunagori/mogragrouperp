<script>
	$('select').select2();
</script>
<div class="form-group">
	<label class="control-label">Invoice Booking No. <span class="required" aria-required="true">*</span></label>
	<div class="row">
		<?php
			$options=array();
			foreach($invoice_bookings as $invoice_booking){
			$merge=(($invoice_booking->ib1.'/IB-'.str_pad($invoice_booking->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoice_booking->ib3.'/'.$invoice_booking->ib4));
			$options[]=['text' =>$merge, 'value' => $invoice_booking->id];
			}
			echo $this->Form->input('invoice_booking_id', ['empty' => "--Select--",'label' => false,'options' => $options,'class' => 'form-control input-sm select2me']); ?>
	</div>
</div>