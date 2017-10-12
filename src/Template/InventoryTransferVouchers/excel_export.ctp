<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Inventory_Transfer_Voucher_report_".$date.'_'.$time;

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
			<b> Inventory Transfer Voucher Report
			<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));  } ?> 

			</b>
			</td>
		</tr>
		<tr>
			<th>Sr. No.</th>
			<th>Vocher No</th>
			<th>Transaction Date</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0; foreach ($inventory_transfer_vouchs as $inventory_transfer_vouch_data): $i++; ?>
	<tr>
		<td><?= h($i) ?></td>		
		<?php if($inventory_transfer_vouch_data->in_out=='in_out'){ ?>
		<td><?= h('ITV-'.str_pad($inventory_transfer_vouch_data->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
		<?php }else if($inventory_transfer_vouch_data->in_out=='in') { ?>
		<td><?= h('ITVI-'.str_pad($inventory_transfer_vouch_data->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
		<?php }else { ?>
		<td><?= h('ITVO-'.str_pad($inventory_transfer_vouch_data->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
		<?php } ?>
		<td><?= h(date("d-m-Y",strtotime($inventory_transfer_vouch_data->transaction_date)))?></td>
	</tr>
	<?php endforeach; ?>
</tbody>
</table>