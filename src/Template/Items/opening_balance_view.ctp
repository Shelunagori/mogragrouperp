<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel">Item opening balance view</span>
		</div>
		
		<div class="actions">
			<?= $this->Html->link(
				'Add',
				'/Items/Opening-Balance',
				['class' => 'btn btn-default']
			); ?>
			<?= $this->Html->link(
				'View',
				'/Items/Opening-Balance-View',
				['class' => 'btn btn-default']
			); ?>
		</div>
	
	<div class="portlet-body form">
	
		<form method="GET" >
			<input type="hidden" name="pull-request" value="<?php echo @$pull_request; ?>">
				<table class="table table-condensed" width="20%">
					<tbody>
						<tr>
							<td width="20%"><input type="text" name="item" class="form-control input-sm" placeholder="Item Name" value="<?php echo @$item; ?>"></td>
							<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
							<td align="right"><input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3"  style="width: 40%;"></td>
							</tr>
						</tbody>
				</table>
				
		</form>
		
		<?php $page_no=$this->Paginator->current('ItemLedgers'); $page_no=($page_no-1)*20; ?>
		<table class="table table-condensed table-bordered table-hover" id="main_tble">
			<thead >
				<tr>
					<th>Sr. No.</th>
					<th width="100">Date</th>
					<th>Item</th>
					<th>Quantity</th>
					<th style="text-align:right;">Rate</th>
					<th style="text-align:right;">Amout</th>
					<th width="50" style="font-size: 9px !important;">Serial Number Enable</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($ItemLedgers as $ItemLedger){ ?>
				<tr>
					<td><?= h(++$page_no) ?></td>
					<td><?= date('d-m-Y',strtotime($ItemLedger->processed_on)) ?></td>
					<td><?= h($ItemLedger->item->name) ?></td>
					<td align="center"><?= h((int)$ItemLedger->quantity) ?></td>
					<td align="right"><?= h($this->Number->format($ItemLedger->rate,['places'=>2])) ?></td>
					<td align="right"><?= h($this->Number->format($ItemLedger->quantity*$ItemLedger->rate,['places'=>2])) ?></td>
					<td><?= $ItemLedger->item->item_companies[0]->serial_number_enable ? 'Yes' : 'No'?></td>
					<td>
					<?= $this->Html->link('<i class="fa fa-pencil-square-o"></i> ',
							['action' => 'EditItemOpeningBalance', $ItemLedger->id], 
							[
								'escape' => false,
								'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit'
							]
						) ?>
					
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
var $rows = $('#main_tble tbody tr');
	$('#search3').on('keyup',function() {
	
			var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    		var v = $(this).val();
    		if(v){ 
    			$rows.show().filter(function() {
    				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
		
    				return !~text.indexOf(val);
    			}).hide();
    		}else{
    			$rows.show();
    		}
    	});
});
		
</script>