<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Sales_orders_report_".$date.'_'.$time;

	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );

?>	
				<table border="1">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Invoice No.</th>
							<th>Customer</th>
							<th>Date</th>
							<th>Total</th>
							
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($invoices as $invoice): ?>
						<tr>
							<td><?= h(++$i) ?></td>
							<td><?= h(($invoice->in1.'/IN-'.str_pad($invoice->id, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4)) ?></td>
							<td><?= h($invoice->customer->customer_name) ?></td>
							<td><?php echo date("d-m-Y",strtotime($invoice->date_created)); ?></td>
							<td><?= h($invoice->total_after_pnf) ?></td>
							
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				
