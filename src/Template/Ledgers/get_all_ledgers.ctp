<div class="portlet light bordered">
	<div class="portlet-title"></div>
<div class="portlet-body">
		<div class="row">


<table class="table table-bordered table-striped">
	<tr>
		<th colspan='5'>26</th>
	</tr>
	<tr>
		<th>id</th>
		<th>Ledger ID</th>
		<th>Ledger Account Name</th>
		<th>Debit</th>
		<th>Credit</th>
		
	</tr>
	<?php $i=1; foreach($Ledgers27 as $ledgers){ 
	
	?>
	<tr>
		<td><?php echo $i++; ?></td>
		<td><?php  echo $ledgers->ledger_account_id; ?></td>
	<td><?php 
	if(!empty($ledgers->ledger_account->alias)){

	echo $ledgers->ledger_account->name.'('.$ledgers->ledger_account->alias.')';
	}else{
	echo 	$ledgers->ledger_account->name;
	}	?></td>
		<td><?php  echo $ledgers->debit;  ?></td>
		<td><?php  echo $ledgers->credit; ?></td>
		<td></td>
		<td></td>
	</tr>
	<?php }  ?>
</table>
</div>
</div>
</div>