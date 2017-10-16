<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="PettyCash_voucher_report_".$date.'_'.$time;

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
				 PettyCash Vouchers Report 
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
		<?php $i=0; foreach ($pettycashvouchers as $pettycashvoucher){  ?>
		<tr>
			<td><?= h(++$i) ?></td>
			<td><?= h(date("d-m-Y",strtotime($pettycashvoucher->transaction_date)))?></td>
			<td><?= h('#'.str_pad($pettycashvoucher->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
			<?php $total_dr=0; $total_cr=0; $total=0;  foreach($pettycashvoucher->petty_cash_voucher_rows as $petty_cash_voucher_row){ 
				if($petty_cash_voucher_row->cr_dr=='Dr'){
					$total_dr=$total_dr+$petty_cash_voucher_row->amount;
				}else{
					$total_cr=$total_cr+$petty_cash_voucher_row->amount;
				}
			}  $total= $total_dr-$total_cr?>
			<td align="right"><?= h($this->Number->format($total,[ 'places' => 2])) ?></td>
			
		</tr>
		<?php } ?>
	</tbody>
</table>