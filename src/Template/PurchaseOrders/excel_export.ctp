<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Purchase_Order_report_".$date.'_'.$time;

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
					<td colspan="3" align="center">
					<b> Purchase Order Report
					<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));  } ?> 
					
					</b>
					</td>
				</tr>
				<tr>
					<th>S.No</th>
					<th>Purchase No.</th>
					<th>Supplier Name</th>
					<th>Created Date</th>
					<th style="text-align:right">Total</th>
					<th>Status</th>
				</tr>
		</thead>
<tbody>
						<?php $i=1; foreach ($purchaseOrders as $purchaseOrder): ?>
						<tr>
							<td><?= h($i++) ?></td>
							
							<td><?= h(($purchaseOrder->po1.'/PO-'.str_pad($purchaseOrder->po2, 3, '0', STR_PAD_LEFT).'/'.$purchaseOrder->po3.'/'.$purchaseOrder->po4)) ?></td>
							
							<td><?= h($purchaseOrder->vendor->company_name) ?></td>
							
							<td><?php echo date("d-m-Y",strtotime( $purchaseOrder->date_created)) 	 ?></td>
							<td align="right"><?= $this->Number->format($purchaseOrder->total,['places'=>2]) ?></td>
						
						<td>
							<?php if($purchaseOrder->total_rows > 0 ){ 
									echo "Pending";
								}else{
									echo "Converted-Into-GRN";
								} ?>
						
						</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>		