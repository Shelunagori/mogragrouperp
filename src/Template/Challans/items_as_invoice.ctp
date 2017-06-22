
<?php 
$options=array();
if($source_model=="Invoices"){
	foreach($Invoices->invoice_rows as $invoice_row){
		$options[]=['text' =>$invoice_row->item->name, 'value' => $invoice_row->item->id];
	}
}
elseif($source_model=="Invoice_Booking"){
	foreach($Invoices->invoice_booking_rows as $invoice_booking_row){
		$options[]=['text' =>$invoice_booking_row->item->name, 'value' => $invoice_booking_row->item->id];
	}
}
echo $this->Form->input('item_id', ['empty'=>'Select','options' => $options,'label' => false,'class' => 'form-control input-sm  item_box item_id','placeholder' => 'Item']);
