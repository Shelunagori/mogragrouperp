<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Sale_Return_report_".$date.'_'.$time;

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
			<td colspan="5" align="center">
				<b> Sales Return Report
				<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));} ?> </b>
			</td>
		</tr>	
		<tr>
						<th>Sr. No.</th>
						<th>Sales Return No.</th>
						<th>Invoice No.</th>
						<th>Date Created</th>
						<th style="text-align:right;">Total</th>
					</tr>
				</thead>
				<tbody>
						<?php $i=1; foreach ($saleReturns as $saleReturn): 
						
						?>
					<tr>
						<td><?= h($i++) ?></td>
						<td><?= h(($saleReturn->sr1.'/SR-'.str_pad($saleReturn->sr2, 3, '0', STR_PAD_LEFT).'/'.$saleReturn->sr3.'/'.$saleReturn->sr4)) ?></td>
						
						<td><?= h(($saleReturn->invoice->in1.'/IN-'.str_pad($saleReturn->invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$saleReturn->invoice->in3.'/'.$saleReturn->invoice->in4)) ?></td>
						
						<td><?php echo date("d-m-Y",strtotime($saleReturn->date_created)); ?></td>
						<td align="right"><?= h($this->Number->format($saleReturn->total_after_pnf,[ 'places' => 2])) ?></td>
						
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>