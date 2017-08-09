<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Journal_voucher_report_".$date.'_'.$time;

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
				 Journal Voucher 
				<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));} ?>
			</td>
		</tr>
		<tr>
			<th>Sr.No</th>
			<th>Transaction Date</th>
			<th>Voucher No</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1; foreach ($journalVouchers as $journalVoucher){ ?>
			<tr>
				<td><?= h($i++) ?></td>
				<td><?= h(date("d-m-Y",strtotime($journalVoucher->transaction_date)))?>
				<td><?= h('#'.str_pad($journalVoucher->voucher_no,4,'0',STR_PAD_LEFT)); ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>