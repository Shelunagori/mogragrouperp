<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Account_Statement_Ref_report_".$date.'_'.$time;

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
			<th colspan="5" align="center">
				 Account Statement Reference Report For <?php
				if(!empty($Ledger_Account_data->alias)){	
				 echo $Ledger_Account_data->name.' ('.$Ledger_Account_data->alias.')';
				}else{
					echo $Ledger_Account_data->name;
				}				 ?>
			</th>
		</tr>
		<tr>
			<th>Reference</th>
			<th>Transaction Date</th>
			<th>Due Date</th>
			<th style="text-align:right;">Dr</th>
			<th style="text-align:right;">Cr</th>
		</tr>
	</thead>
	<tbody>
		<?php $total_debit=0; $total_credit=0; foreach($ReferenceBalances as $ReferenceBalance){  
			if($ReferenceBalance->credit != $ReferenceBalance->debit){
		?>

		<tr>
				<td><?php echo $ReferenceBalance->reference_no; ?></td>
				<td><?php echo (date('d-m-Y',strtotime($ReferenceBalance->transaction_date))); ?></td>
				<td><?php echo (date('d-m-Y',strtotime($ReferenceBalance->due_date))); ?></td>
				<td align="right"><?= $this->Number->format($ReferenceBalance->debit,[ 'places' => 2]); ?></td>
				<td align="right"><?= $this->Number->format($ReferenceBalance->credit,[ 'places' => 2]);  ?></td>
				<?php $total_debit+=$ReferenceBalance->debit;
					  $total_credit+=$ReferenceBalance->credit  ?>

		</tr>
		<?php } } ?>
		<tr>
			<td align="right" colspan="3">Total</td>
			<td align="right"><?= $this->Number->format($total_debit,[ 'places' => 2]); ?>Dr.</td>
			<td align="right"><?= $this->Number->format($total_credit,[ 'places' => 2]); ?>Cr.</td>
		</tr>
		<tr>
			<td  align="right" colspan="3">On Account</td>	
			<?php 
				$on_acc=0;
				$closing_balance=0;
				$on_dr=@$ledger_amt['Debit']-@$ref_amt['debit'];
				$on_cr=@$ledger_amt['Credit']-@$ref_amt['credit'];
				
				$on_acc=$on_dr-$on_cr;
				
				
				?>
			<?php if($on_acc >= 0){ 
			$closing_balance=($on_acc+$total_debit)-$total_credit;
			
			
			?>
						<td align="right"><?php echo $this->Number->format(abs($on_acc),['places'=>2]); ?>Dr.</td>	
						<td align="right">0 Cr.</td>
					<?php } else{ 
					$closing_balance=(abs($on_acc)+$total_credit)-abs($total_debit);
					?>
						<td align="right">0 Dr.</td>
						<td align="right"><?php echo $this->Number->format(abs($on_acc),['places'=>2]); ?>Cr.</td>
			
			<?php } ?>
		</tr>
		<tr>
			<td colspan="5" align="right">Closing Balance :
				<b><?php if(($on_acc+$total_debit)>$total_credit){
					echo $this->Number->format(abs($closing_balance),['places'=>2]).'Dr.'; 
				}else{
					echo $this->Number->format(abs($closing_balance),['places'=>2]).'Cr.'; 
				}	
				?></b></td>
		</tr>
	</tbody>
</table>				