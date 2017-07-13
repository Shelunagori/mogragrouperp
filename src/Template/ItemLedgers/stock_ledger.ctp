<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Stock Ledger Report</span>
		</div>
		<div class="actions hide_at_print"> 
					<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3" style="width: 200px;">
				</div>
	</div>
		<div class="portlet-body">
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-12"><br/></div>
				<table class="table table-bordered table-striped table-hover" id="main_tble" width="100%">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Item</th>
							<th>Quantity</th>
							<th>Company</th>
							<th>In/Out</th>
							<th>Rate</th>
							<th>Source Model</th>
							<th>Processed Date</th>
						</tr>
					</thead>
					<tbody>
						<?php  $page_no=0; foreach ($stockLedgers as $key=> $stockLedger): ?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							<td><?= h($stockLedger->item->name) ?></td>
							<td><?= h($stockLedger->quantity) ?></td>
							<td><?= h($stockLedger->company->name) ?></td>
							<td><?= h($stockLedger->in_out) ?></td>
							<td><?= h($stockLedger->rate) ?></td>
							<td><?= h($stockLedger->source_model) ?></td>
							<td width="10%"><?= h(date("d-m-Y",strtotime($stockLedger->processed_on))) ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				</div>
			</div>
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