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
							<th>S. No.</th>
							<th>Sales Order No</th>
							<th>Customer</th>
							<th>Date</th>
							<th>PO No.</th>
							<th>Total</th>
							
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($salesOrders as $salesOrder): ?>
						<tr <?php if($status=='Converted Into Invoice'){ echo 'style="background-color:#f4f4f4"'; } ?> >
							<td><?= h(++$i) ?></td>
							<td><?= h(($salesOrder->so1.'/SO-'.str_pad($salesOrder->id, 3, '0', STR_PAD_LEFT).'/'.$salesOrder->so3.'/'.$salesOrder->so4)) ?></td>
							<td><?= h($salesOrder->customer->customer_name) ?></td>
							<td><?php echo date("d-m-Y",strtotime($salesOrder->created_on)); ?></td>
							<td><?= h($salesOrder->customer_po_no) ?></td>
							
							<td><?= h($salesOrder->total_after_pnf) ?></td>
							
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				
