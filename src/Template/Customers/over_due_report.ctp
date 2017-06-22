<?php //pr($customers); exit;?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Overdues For CUSTOMERS</span>
		</div>
	</div>
	<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3"  style="width: 20%;">
	<div class="portlet-body">
	 
		<div class="table-scrollable">
			<table class="table table-bordered table-striped" id="main_tble">
				 <thead>
					<tr>
						<th>Sr. No.</th>
						<th>Customer Name</th>
						<th style="text-align:center">Payment Terms</th>
						<th style="text-align:center"><?php echo $custmer_payment_range_ctp->range0.'-'.$custmer_payment_range_ctp->range1?></th>
						<th style="text-align:center"><?php echo $custmer_payment_range_ctp->range2.'-'.$custmer_payment_range_ctp->range3?></th>
						<th style="text-align:center"><?php echo $custmer_payment_range_ctp->range4.'-'.$custmer_payment_range_ctp->range5?></th>
						<th style="text-align:center"><?php echo $custmer_payment_range_ctp->range6.'-'.$custmer_payment_range_ctp->range7?></th>
						<th style="text-align:center"><?php echo $custmer_payment_range_ctp->range7?> ></th>
						<th style="text-align: right;">Total Over-Due</th>
					</tr>
				</thead>
				<tbody>
					<?php  $page_no=0; //pr($over_due_report); exit;
					if($over_due_report>=0){ 
					foreach ($over_due_report as $key=>$over_due_reports){ 
					if($over_due_reports > 0 || $over_due_reports < 0 ){
					?>
					<tr>
						<td><?= h(++$page_no) ?></td>
						<td><?php echo $custmer_name[$key]."(". $custmer_alise[$key].")"?></td>
						<td style="text-align:center"><?php echo $custmer_payment_ctp[$key] ?></td>
						<td align="right"><?= h(number_format($over_due_report1[$key][1],2,',',''))?></td>
						<td align="right"><?= h(number_format($over_due_report1[$key][2],2,'.',',')) ?></td>
						<td align="right"><?= h(number_format($over_due_report1[$key][3],2,'.',',')) ?></td>
						<td align="right"><?= h(number_format($over_due_report1[$key][4],2,'.',',')) ?></td>
						<td align="right"><?= h(number_format($over_due_report1[$key][5],2,'.',',')) ?></td>
						<td align="right"><?= h(number_format($total_overdue[$key],2,'.',','))  ?></td>
						
					</tr>
					<?php }}
					}else{
						echo "NO DATA FOUND";
					}?>
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