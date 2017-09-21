<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Inventory_Daily_report_".$date.'_'.$time;

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
				 Inventory Daily Report
				<?php if(!empty($from_date) || !empty($to_date)){ echo date('d-m-Y',strtotime($from_date)); ?> TO <?php echo date('d-m-Y',strtotime($to_date));} ?>
			</td>
		</tr>
			<tr>
				<th width="2%">SR</th>
				<th width="10%">Transaction Date</th>
				<th width="10%">Voucher</th>
				<th width="10%">Item</th>
				<th width="10%">In</th>
				<th width="5%">Out</th>
				<th width="5%">Serial No.</th>
			</tr>
		</thead>
		<tbody>
					<?php $srn=0; foreach ($itemDatas as $key=>$itemData){ 
					
					$row_count=count($itemData);
					?>
					
						<?php $flag=0; foreach($itemData as $itemData) {  ?>
						<tr>
						<?php if($flag==0){?>
						<td style="vertical-align: top !important;" rowspan="<?php echo $row_count; ?>"><?php echo ++$srn; ?> </td>
						<td style="vertical-align: top !important;" rowspan="<?php echo $row_count; ?>"><?php echo date("d-m-Y",strtotime($itemData['processed_on'])); ?></td>
						
						<td style="vertical-align: top !important;" rowspan="<?php echo $row_count; ?>">
							<?php echo $voucher_no[$key][0]; ?>
						</td>
						
						
						
						<?php $flag=1; }?>
						<td style="vertical-align: top !important;"><?php echo $itemData['item']['name']; ?></td>
						<?php if($itemData['in_out']=="In"){ ?>
						<td style="vertical-align: top !important;"><?php echo $itemData['quantity']; ?></td>
						<?php }else{ ?>
						<td style="vertical-align: top !important;"><?php echo "-"; ?></td>
						<?php } ?>
						<?php if($itemData['in_out']=="Out"){ ?>
						<td><?php echo $itemData['quantity']; ?></td>
						<?php }else{ ?>
						<td><?php echo "-"; ?></td>
						<?php } ?>
						
						<td width="30px">
						<?php foreach($serial_nos[$key][$itemData['item_id']] as $sr){ 
							echo $no=$sr['serial_no']; echo "</br>";
							//$srn=implode(',', $no);
						} //echo $srn; ?>
						</td>
						</tr>
						<?php } ?>
						
					
					<?php } ?>
				</tbody>
				</table>