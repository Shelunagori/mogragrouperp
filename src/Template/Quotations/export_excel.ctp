<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Quotations_report_".$date.'_'.$time;

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
				<b> Quotation Report
				<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));} ?> </b>
			</td>
		</tr>	
		<tr>
			<th>Sr. No.</th>
			<th>Ref. No.</th>
			<th>Customer</th>
			<th>Salesman</th>
			<th>Product</th>
			<th>Total</th>
			<th>Finalisation Date</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0; foreach ($quotations as $quotation): ?>
		<tr >
			<td><?= h(++$i) ?></td>
			<td><?= h(($quotation->qt1.'/QT-'.str_pad($quotation->qt2, 3, '0', STR_PAD_LEFT).'/'.$quotation->qt3.'/'.$quotation->qt4)) ?></td>
			<td><?= h($quotation->customer->customer_name) ?></td>
			<td><?= h($quotation->employee->name) ?></td>
			<td><?= h($quotation->item_group->name) ?></td>
			<td><?= h($quotation->total) ?></td>
			<td><?php echo date("d-m-Y",strtotime($quotation->finalisation_date)); ?></td>
			<td><?php echo ucwords($quotation->status); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
			