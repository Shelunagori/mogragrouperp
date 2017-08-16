

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Ledger Account</span>
		</div>
		

	<div class="portlet-body form">
	<div class="row ">
		<div class="col-md-12">
		<form method="GET" >
			<table class="table table-condensed">
				<tbody>
					<tr>
						<td width="20%">
							<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" value="<?php echo @$From; ?>"  data-date-format="dd-mm-yyyy" >
						</td>
						<td width="20%">
									<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" value="<?php echo @$To; ?>"  data-date-format="dd-mm-yyyy" >
						</td>
						<td>
							<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
						</td>
						
					</tr>
				</tbody>
			</table>
		</form>
		
		
		<!-- BEGIN FORM-->
		
			<table class="table table-bordered  ">
				<thead>
					<tr>
						<th width="10%">Transaction Date</th>
						<th width="10%">Voucher</th>
						<th width="10%">Item</th>
						<th width="10%">In</th>
						<th width="5%">Out</th>
						<th width="5%">Serial No.</th>
					</tr>
				</thead>
				<tbody>
				<tbody>
					<?php foreach ($itemDatas as $itemData){ 
					
					$row_count=count($itemData);
					
					?>
					
						<?php $flag=0; foreach($itemData as $itemData) { pr( );  ?>
						<tr>
						<?php if($flag==0){?>
						<td rowspan="<?php echo $row_count; ?>"><?php echo date("d-m-Y",strtotime($itemData['processed_on'])); ?></td>
						<td rowspan="<?php echo $row_count; ?>"><?php echo $itemData['source_model'];  echo $itemData['source_id'];?></td>
						<?php $flag=1; }?>
						<td><?php echo $itemData['item']['name']; ?></td>
						<?php if($itemData['in_out']=="Out"){ ?>
						<td><?php echo $itemData['quantity']; ?></td>
						<?php }else{ ?>
						<td><?php echo "-"; ?></td>
						<?php } ?>
						<?php if($itemData['in_out']=="In"){ ?>
						<td><?php echo $itemData['quantity']; ?></td>
						<?php }else{ ?>
						<td><?php echo "-"; ?></td>
						<?php } ?>
						<?php if($itemData['item']['item_companies'][0]['serial_number_enable']==1) {?>
						
						
						<td><?php echo $itemData['item_id']; ?></td>
						<?php } ?>
						</tr>
						<?php } ?>
						
					
					<?php } ?>
				</tbody>
				</table>
			
		</div>
	</div>
  </div>
</div>
</div>