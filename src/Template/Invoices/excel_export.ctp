<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Invoice_report_".$date.'_'.$time;

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
						<td colspan="6" align="center">
						<b> Invoice Report
						<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));  } ?> 
						
						</b>
						</td>
					</tr>
						<tr>
							<th width="5%">Sr. No.</th>
							<th width="10%">Invoice No.</th>
							<th width="10%">Sales Order No.</th>
							<th width="12%">Customer</th>
							<th width="8%">Created Date</th>
							<th style="text-align:right;" width="10%">Total</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($invoices as $invoice): ?>
						<tr>
							<td><?= h(++$i) ?></td>
							<td><?= h(($invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4)) ?></td>
							<?php if($invoice->sales_order_id != 0){ ?>
							<td>
							<?php 
							if($invoice->sales_order->gst == 'yes'){
								echo $invoice->sales_order->so1.'/SO-'.str_pad($invoice->sales_order->so2, 3, '0', STR_PAD_LEFT).'/'.$invoice->sales_order->so3.'/'.$invoice->sales_order->so4; 
							}else{
								echo $invoice->sales_order->so1.'/SO-'.str_pad($invoice->sales_order->so2, 3, '0', STR_PAD_LEFT).'/'.$invoice->sales_order->so3.'/'.$invoice->sales_order->so4; 
							} ?>
							</td>
							<?php }else{?>
							<td></td><?php } ?>
							
						
							<td><?= h($invoice->customer->customer_name) ?></td>
							<td><?php echo date("d-m-Y",strtotime($invoice->date_created)); ?></td>
							<td><?= h($invoice->total_after_pnf) ?></td>
							
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				
