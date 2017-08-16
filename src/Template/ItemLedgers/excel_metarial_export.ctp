<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Material_Indent_report_".$date.'_'.$time;

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
				 Material Indent Report 
			</td>
		</tr>
		<tr>
			<th width="3%">Sr. No.</th>
			<th>Item Name</th>
			<th width="13%"  >Current Stock</th>
			<th width="10%">Sales Order </th>
			<th width="10%">Job card  </th>
			<th width="15%">Suggested Indent</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0; foreach($material_report as $data){
			$i++;
			$item_name=$data['item_name'];
			$item_id=$data['item_id'];
			$Current_Stock=$data['Current_Stock'];
			$sales_order=$data['sales_order'];
			$job_card_qty=$data['job_card_qty'];
		

		?>
		<tr class="tr1">
			<td ><?php echo $i; ?> </td>
			<td><?php echo $item_name; ?></td>
			<td style="text-align:center; valign:top" valign="top"><?php echo $Current_Stock; ?></td>
			<td style="text-align:center"><?php echo @$sales_order; ?></td>
			<td style="text-align:center"><?php echo $job_card_qty; ?></td>
			<td style="text-align:center"><?php echo $Current_Stock-@$sales_order-$job_card_qty; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>	