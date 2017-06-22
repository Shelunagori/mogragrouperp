<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Stock Report</span>
		</div>
		<div class="portlet-body">
			<div class="row">
				<div class="col-md-12">
				<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3"  style="width: 20%;">
				
				<div class="col-md-12"><br/></div>
				<table class="table table-bordered table-striped table-hover" id="main_tble">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Item</th>
							<th>Current Stock</th>
						</tr>
					</thead>
					<tbody>
						<?php $page_no=0; foreach ($item_stocks as $key=> $item_stock): ?>
							
						<tr>
							<td><?= h(++$page_no) ?></td>
							<td><?= $this->Html->link($items_names[$key], ['controller' => 'ItemLedgers', 'action' => 'index',$key]) ?></td>
							<td><?= h($item_stock) ?></td>
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