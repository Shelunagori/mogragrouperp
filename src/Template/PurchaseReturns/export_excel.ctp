<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Purchase_Return_report_".$date.'_'.$time;

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
			<td colspan="3" align="center">
				<b> Purchase Return Report
				<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));} ?> </b>
			</td>
		</tr>	
		<tr>
							<th>Sr. No.</th>
							<th>Voucher No</th>
							<th>Date</th>
						</tr>
				</thead>
				<tbody>
						<?php $i=1; foreach ($purchaseReturns as $purchaseReturn): 
						//pr($saleReturn); 
						?>
						<tr>
							<td><?= h($i++) ?></td>
							<td><?= h('#'.str_pad($purchaseReturn->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
							
							<td><?php echo date("d-m-Y",strtotime($purchaseReturn->created_on)); ?></td>
						
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>