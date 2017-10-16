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
<table border='1'>
		<thead>
				<tr>
					<td colspan="3" align="center">
					<b> Material Indent Report
					<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));  } ?> 
					
					</b>
					</td>
				</tr>
				<tr>
				<td style="font-size:120%;">Sr.No.</td>
				<td style="font-size:120%;">Material Indent No</td>
				<td style="font-size:120%;">Created on</td>
				</tr>
		</thead>
        <tbody>
            <?php $i=1; foreach($materialIndents as $materialIndent):  ?>
			<tr>
			   <td><?= h($i++) ?></td>
			   <td>
				<?= h('#'.str_pad($materialIndent->mi_number, 4, '0', STR_PAD_LEFT)) ?>
			    </td>
				<td><?php echo date("d-m-Y",strtotime($materialIndent->created_on)); ?></td>
			</tr>
            <?php endforeach; ?>
        </tbody>
    </table>