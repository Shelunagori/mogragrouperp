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
						<td width="5%"></td>
						<td width="5%"></td>
						<td width="5%"></td>
						<td width="12%"></td>
						<td></td>
						<td></td>
						<td ></td>
						<td align="right"></td>
					</tr>
				</tbody>
			</table>
		</form>
		<div class="portlet-body">
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-12"><br/></div>
				<table class="table table-bordered table-striped table-hover" id="main_tble" width="100%">
					<thead>
						<tr>
							<th>Sr. No.</th>

							<th>Processed On</th>
							<th>Item</th>
							<th>Voucher Source</th>
							<th>Voucher No.</th>
							<th>In</th>
							<th>Out</th>
							<th style="text-align:right;">Rate</th>
						</tr>
					</thead>
					<tbody>
						<?php  $page_no=0; foreach ($stockLedgers as $key=> $stockLedger): ?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							<td width="10%"><?= h(date("d-m-Y",strtotime($stockLedger->processed_on))) ?></td>

							<td width="20%"><?= h($stockLedger->item->name) ?></td>
							<td><?= h($stockLedger->source_model) ?></td>
							<td>
							<?php 
							if(!empty($url_path)){
								echo $this->Html->link($voucher_no ,$url_path,['target' => '_blank']); 
							}else{
								echo $voucher_no;
							}
							?>
							</td>
							<td><?php if($stockLedger->in_out=='In'){ echo $stockLedger->quantity; } else { echo '-'; } ?></td>
							<td><?php if($stockLedger->in_out=='Out'){ echo $stockLedger->quantity; } else { echo '-'; } ?></td>
							<td style="text-align:right;"><?= h($stockLedger->rate) ?></td>
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