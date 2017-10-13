<div class="portlet light bordered">
	<div class="portlet-title"></div>
<div class="portlet-body">
		<div class="row">


<table class="table table-bordered table-striped">
	<tr>
		<th colspan='8'>26</th>
	</tr>
	<tr>
		<th>id</th>
		<th>Item ID</th>
		<th>Item Category</th>
		<th>Item Group</th>
		<th>Item Subgroup</th>
		<th>Item Name</th>
		<th>Min Selling Factor</th>
		<th>Min Stock</th>
	</tr>
	<?php $i=1; foreach($Items as $item){ 
	if(sizeof(@$company27[$item->id]) > 0){
	?>
	<tr>
		<td><?php echo $i++; ?></td>
		<td><?php  echo @$company27[$item->id]; ?></td>
		<td><?php  echo @$item_cat27[$item->id]; ?></td>
		<td><?php  echo @$item_grp27[$item->id]; ?></td>
		<td><?php  echo @$item_subgrp27[$item->id]; ?></td>
		<td><?php  echo @$item_name27[$item->id];  ?></td>
		
		<td></td>
		<td></td>
	</tr>
	<?php } } ?>
</table>
</div>
</div>
</div>