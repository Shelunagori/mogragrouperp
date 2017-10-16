<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Contra_voucher_report_".$date.'_'.$time;

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
				 Contra Vouchers Report 
				 <?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));} ?>
			</td>
		</tr>
		<tr>
			<th>Sr. No.</th>
			<th>Transaction Date</th>
			<th>Vocher No</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0; foreach ($contravouchers as $contravoucher){ ?>
		<tr>
			<td><?= h(++$i) ?></td>
			<td><?= h(date("d-m-Y",strtotime($contravoucher->transaction_date)))?></td>
			<td><?= h('#'.str_pad($contravoucher->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
			<td align="right"><?= h($this->Number->format($contravoucher->contra_voucher_rows[0]->total_dr - $contravoucher->contra_voucher_rows[0]->total_cr,[ 'places' => 2])) ?></td>
			
		</tr>
		<?php } ?>
	</tbody>
</table>	
	