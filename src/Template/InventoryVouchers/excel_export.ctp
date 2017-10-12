<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Inventory_Voucher_report_".$date.'_'.$time;

	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );

?>
<table border='1'>
	<thead>
		<tr>
			<th>Sr. No.</th>
			<th>Inventory Voucher No</th>
			<th>Transaction Date</th>
			<th>Invoice No</th>
			<th>Customer</th>
		</tr>
	</thead>
	<tbody>
		<?php  $i=0; foreach ($inventoryVouchers as $inventoryVoucher): $i++;?>
	<tr>
		<td><?= h($i) ?></td>
		<td><?= h('#'.str_pad($inventoryVoucher->iv_number, 4, '0', STR_PAD_LEFT)) ?></td>
		<td><?php if(!empty($inventoryVoucher->transaction_date)){echo date("d-m-Y",strtotime($inventoryVoucher->transaction_date));} ?></td>
		<td><?php 
		if($inventoryVoucher->invoice->invoice_type=="GST"){
		echo $this->Html->link($inventoryVoucher->invoice->in1.'/IN-'.str_pad($inventoryVoucher->invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$inventoryVoucher->invoice->in3.'/'.$inventoryVoucher->invoice->in4,[
		'controller'=>'Invoices','action' => 'gst-confirm',$inventoryVoucher->invoice->id],array('target'=>'_blank')); 
		}else{
			echo $this->Html->link($inventoryVoucher->invoice->in1.'/IN-'.str_pad($inventoryVoucher->invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$inventoryVoucher->invoice->in3.'/'.$inventoryVoucher->invoice->in4,[
			'controller'=>'Invoices','action' => 'confirm',$inventoryVoucher->invoice->id],array('target'=>'_blank')); 
		}?>
		</td>
		<td><?php echo $inventoryVoucher->invoice->customer->customer_name.'('.$inventoryVoucher->invoice->customer->alias.')' ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>