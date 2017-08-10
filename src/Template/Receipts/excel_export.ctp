<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Receipt_vouchers_".$date.'_'.$time;

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
			<td colspan="4" align="center">
				 Receipt Voucher 
				<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));} ?>
			</td>
		</tr>
		<tr>
			<th>Sr. No.</th>
			<th>Transaction Date</th>
			<th>Vocher No</th>
			<th style="text-align:right;">Amount</th>
		</tr>
		</thead>
		<tbody>
			<?php $i=0; foreach ($receipts as $receipt){  
			
		?>
			<tr>
				<td><?= h(++$i) ?></td>
				<td><?= h(date("d-m-Y",strtotime($receipt->transaction_date)))?></td>
				<td><?= h('#'.str_pad($receipt->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
				<td align="right"><?= h($this->Number->format($receipt->receipt_rows[0]->total_cr-$receipt->receipt_rows[0]->total_dr,[ 'places' => 2])) ?></td>
			</tr>
			<?php } ?>
		</tbody>
</table>	