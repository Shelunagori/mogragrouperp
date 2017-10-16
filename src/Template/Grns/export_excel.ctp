<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Grns_report_".$date.'_'.$time;

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
					<td colspan="6" align="center">
					<b> Grns Report
					<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));  } ?> 
					
					</b>
					</td>
				</tr>
				<tr>
							<th width="9%">Sr. No.</th>
							<th width="19%" >GRN No.</th>
							<th width="19%" >PO No.</th>
							<th width="19%">Supplier</th>
							<th width="19%" >Date Created</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
					
						<?php $i=1; foreach ($grns as $grn): ?>
						<tr>
							<td><?= h($i++) ?></td>
							<td><?= h(($grn->grn1.'/GRN-'.str_pad($grn->grn2, 3, '0', STR_PAD_LEFT).'/'.$grn->grn3.'/'.$grn->grn4)) ?></td>
							<td><?php echo $grn->purchase_order->po1.'/PO-'.str_pad($grn->purchase_order->po2, 3, '0', STR_PAD_LEFT).'/'.$grn->purchase_order->po3.'/'.$grn->purchase_order->po4; ?>
							</td>
							<td><?= h($grn->vendor->company_name) ?></td>
							<td><?php echo date("d-m-Y",strtotime($grn->date_created)); ?></td>
							<td><?php echo $grn->status; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>