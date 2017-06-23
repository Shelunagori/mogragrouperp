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
							<th>Source</th>
							<th>Reference</th>
							<th>Debit</th>
							<th>Credit</th>
							
						</tr>
					</thead>
					<tbody>
					<tr>
							<td colspan="6" align="center"><?php echo $ledger_acc_name; ?></td>
					</tr>
						<tr>
							<td colspan="5" align="right">Opening Balance</td>
							<?php $open_bal=0; 
							if(@$opening_balance_ar['debit'] > @$opening_balance_ar['credit']){ 
							$open_bal=@$opening_balance_ar['debit']-@$opening_balance_ar['credit']; 
							}else{
							$open_bal=@$opening_balance_ar['credit']-@$opening_balance_ar['debit']; 	
							}?>
							<?php if(@$opening_balance_ar['debit'] > @$opening_balance_ar['credit']){ ?>
							<td><?php echo abs($open_bal); ?>Dr.</td>
							<?php } else{ ?>
							<td><?php echo abs($open_bal); ?>Cr.</td>
						<?php 	} ?>
						</tr>
						<?php $total_dr=0; $total_cr=0; $i=0; foreach ($ledgers as $ledger): 
					
					?>
						
						<tr>
						<td><?= h(++$i) ?></td>
						<td><?php echo date("d-m-Y",strtotime($ledger->transaction_date)); ?></td>
						<td><?= h($ledger->voucher_source); ?></td>
						<td>
						<?php echo str_pad($ledger->voucher_id,4,'0',STR_PAD_LEFT);?>
						</td>
						<td ><?= $this->Number->format($ledger->debit) ?></td>
						<td ><?= $this->Number->format($ledger->credit) ?></td>
						<?php 
						if($ledger->credit == 0){
							$total_dr=$total_dr+$ledger->debit;
						}else{
							$total_cr=$total_cr+$ledger->credit;
						}
						?>
					</tr>
					
				<?php endforeach; ?>
				<tr>
					<td colspan="4" align="right">Total</td>
					<td><?php echo $total_dr; ?>Dr</td>
					<td><?php echo $total_cr; ?>Cr</td>
					</tr>
					<tr>
					<td colspan="5" align="right">Closing Balance</td>
					<?php $close_bal=0;
						if(@$opening_balance_ar['debit'] > @$opening_balance_ar['credit']){ 
						$close_bal=@$opening_balance_ar['debit']+$total_dr-@$total_cr;  ?>
							<td><?php echo abs($close_bal); ?>Dr.</td>
						<?php } else{ 
							$close_bal=@$opening_balance_ar['credit']+$total_cr-@$total_dr; ?>
							<td><?php echo abs($close_bal); ?>Cr.</td>
						<?php 	}
					?>
					
					</tr>
					</tbody>
				</table>
				
