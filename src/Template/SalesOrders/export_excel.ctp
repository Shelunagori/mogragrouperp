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
						<td colspan="7" align="center">
						<b> Sales Order Report
						<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));} ?> </b>
						</td>
					</tr>
						<tr>
							<th>S. No.</th>
							<th>Sales Order No</th>
							<th>Quotation No</th>
							<th>Customer</th>
							<th>Date</th>
							<th>PO No.</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($salesOrders as $salesOrder): ?>
						<tr>
							<td><?= h(++$i) ?></td>
							<td><?= h(($salesOrder->so1.'/SO-'.str_pad($salesOrder->so2, 3, '0', STR_PAD_LEFT).'/'.$salesOrder->so3.'/'.$salesOrder->so4)) ?></td>
							<td><?= h($salesOrder->customer->customer_name) ?></td>
							<?php if($salesOrder->quotation_id != 0){ ?>
							<td>
							<?php echo $salesOrder->quotation->qt1.'/QT-'.str_pad($salesOrder->quotation->qt2, 3, '0', STR_PAD_LEFT).'/'.$salesOrder->quotation->qt3.'/'.$salesOrder->quotation->qt4; ?>
							</td><?php }else{ ?><td>-</td><?php } ?>
							<td><?php echo date("d-m-Y",strtotime($salesOrder->created_on)); ?></td>
							<td><?= h($salesOrder->customer_po_no) ?></td>
							
							
							<td>
								<?php if($salesOrder->total_rows > 0 ){ 
									echo "Pending";
								}else{
									echo "Converted Into Invoice";
								} ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				
