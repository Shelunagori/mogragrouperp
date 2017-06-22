<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Daily_report_".$date.'_'.$time;

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
							<th>S. No.</th>
							<th>Transaction Date</th>
							<th>Ledger Account</th>
							<th>Source</th>
							<th>Reference</th>
							<th>Debit</th>
							<th>Credit</th>
							
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($ledgers as $ledger): 
					
					?>
						<tr>
						<td><?= h(++$i) ?></td>
						<td><?php echo date("d-m-Y",strtotime($ledger->transaction_date)); ?></td>
						<td><?= h($ledger->ledger_account->name); ?></td>
						<td><?= h($ledger->voucher_source); ?></td>
						<td>
						<?php echo str_pad($ledger->voucher_id,4,'0',STR_PAD_LEFT);?>
						</td>
						<td ><?= $this->Number->format($ledger->debit) ?></td>
						<td ><?= $this->Number->format($ledger->credit) ?></td>
				</tr>
				<?php endforeach; ?>
					</tbody>
				</table>
				
