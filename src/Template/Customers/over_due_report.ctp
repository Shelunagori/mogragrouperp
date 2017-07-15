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
						<th style="text-align:center"><?php echo $to_range_datas->range0.'-'.$to_range_datas->range1?></th>
						<th style="text-align:center"><?php echo $to_range_datas->range2.'-'.$to_range_datas->range3?></th>
						<th style="text-align:center"><?php echo $to_range_datas->range4.'-'.$to_range_datas->range5?></th>
						<th style="text-align:center"><?php echo $to_range_datas->range6.'-'.$to_range_datas->range7?></th>
						<th style="text-align:center"><?php echo $to_range_datas->range7?> ></th>
						<th style="text-align: right;">Total Over-Due</th>
					</tr>
				</thead>
				<tbody>
					<?php  $page_no=0;					
					foreach ($LedgerAccounts as $LedgerAccount){ 
					?>
					<tr>
						<td><?= h(++$page_no) ?></td>
						<td><?php echo $LedgerAccount->name."(". $LedgerAccount->alias.")"?></td>
						<td><?php echo $custmer_payment_terms[$LedgerAccount->id];?></td>
						<?php if((!empty($total_debit_1)) || (!empty($total_credit_1))){
									$total1=@$total_debit_1[ $LedgerAccount->id] - @$total_credit_1[ $LedgerAccount->id];
									echo  @$total_debit_1[ $LedgerAccount->id];
									echo  @$total_credit_1[ $LedgerAccount->id]; exit;
									
									if(@$total_debit_1[ $LedgerAccount->id] > @$total_credit_1[ $LedgerAccount->id]){ ?>
									<td align="right"><?php echo $this->Number->format($total1,['places'=>2]); ?></td>
						<?php } else { ?>
									<td align="right"><?php echo $this->Number->format($total1,['places'=>2]); ?></td>
						<?php } } else { ?> 
									<td align="right"><?php echo  "-"; ?></td>
						<?php } ?>
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