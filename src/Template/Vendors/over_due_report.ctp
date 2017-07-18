<?php //pr($customers); exit;?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Overdues For Suppliers</span>
		</div>
	</div>
	<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3"  style="width: 20%;">
	<div class="portlet-body">
	 
		<div class="table-scrollable">
			<table class="table table-bordered table-striped" id="main_tble">
				 <thead>
					<tr>
						<th>Sr. No.</th>
						<th>Suppliers Name</th>
						<th style="text-align:center">Payment Terms</th>
						<th style="text-align:center"><?php echo $to_range_datas->range0.'-'.$to_range_datas->range1?></th>
						<th style="text-align:center"><?php echo $to_range_datas->range2.'-'.$to_range_datas->range3?></th>
						<th style="text-align:center"><?php echo $to_range_datas->range4.'-'.$to_range_datas->range5?></th>
						<th style="text-align:center"><?php echo $to_range_datas->range6.'-'.$to_range_datas->range7?></th>
						<th style="text-align:center"><?php echo $to_range_datas->range7?> ></th>
						<th style="text-align: right;">On Account</th>
						<th style="text-align: right;">Total Over-Due</th>
					</tr>
				</thead>
				<tbody>
					<?php  $page_no=0;					
					foreach ($LedgerAccounts as $LedgerAccount){ 
					?>
					<tr>
						<td><?= h(++$page_no) ?></td>
						<td><?php echo $LedgerAccount->name; ?></td>
						<td><?php echo $custmer_payment_terms[$LedgerAccount->id];?></td>
						<?php if((!empty($total_debit_1)) || (!empty($total_credit_1))){
									$total1=@$total_credit_1[ $LedgerAccount->id] - @$total_debit_1[ $LedgerAccount->id];
									
									
									if(@$total_debit_1[ $LedgerAccount->id] > @$total_credit_1[ $LedgerAccount->id]){ ?>
									<td align="right"><?php echo $this->Number->format($total1,['places'=>2]); ?></td>
						<?php } else { ?>
									<td align="right"><?php echo $this->Number->format($total1,['places'=>2]); ?></td>
						<?php } }  ?>
						
						<?php if((!empty($total_debit_2)) || (!empty($total_credit_2))){
									$total2=@$total_credit_2[ $LedgerAccount->id] - @$total_debit_2[ $LedgerAccount->id];
									if(@$total_debit_2[ $LedgerAccount->id] < @$total_credit_2[ $LedgerAccount->id]){ ?>
									<td align="right"><?php echo $this->Number->format($total2,['places'=>2]); ?></td>
						<?php } else { ?>
									<td align="right"><?php echo $this->Number->format($total2,['places'=>2]); ?></td>
						<?php } } ?>
						
						<?php if((!empty($total_debit_3)) || (!empty($total_credit_3))){
									$total3=@$total_credit_3[ $LedgerAccount->id] - @$total_debit_3[ $LedgerAccount->id];
									if(@$total_debit_3[ $LedgerAccount->id] < @$total_credit_3[ $LedgerAccount->id]){ ?>
									<td align="right"><?php echo $this->Number->format($total3,['places'=>2]); ?></td>
						<?php } else { ?>
									<td align="right"><?php echo $this->Number->format($total3,['places'=>2]); ?></td>
						<?php } } ?>
						
						<?php if((!empty($total_debit_4)) || (!empty($total_credit_4))){
									$total4=@$total_credit_4[ $LedgerAccount->id] - @$total_debit_4[ $LedgerAccount->id];
									if(@$total_debit_4[ $LedgerAccount->id] < @$total_credit_4[ $LedgerAccount->id]){ ?>
									<td align="right"><?php echo $this->Number->format($total4,['places'=>2]); ?></td>
						<?php } else { ?>
									<td align="right"><?php echo $this->Number->format($total4,['places'=>2]); ?></td>
						<?php } } ?>
						
						<?php if((!empty($total_debit_5)) || (!empty($total_credit_5))){
									$total5=@$total_credit_5[ $LedgerAccount->id] - @$total_debit_5[ $LedgerAccount->id];
									if(@$total_debit_5[ $LedgerAccount->id] < @$total_credit_5[ $LedgerAccount->id]){ ?>
									<td align="right"><?php echo $this->Number->format($total5,['places'=>2]); ?></td>
						<?php } else { ?>
									<td align="right"><?php echo $this->Number->format($total5,['places'=>2]); ?></td>
						<?php } } 
						$grand_total=$total1+$total2+$total3+$total4+$total5;
						?>
						<?php 
						$on_acc=0;
						$on_dr=@$ledger_debit[ $LedgerAccount->id]-@$ref_bal_debit[ $LedgerAccount->id];
						$on_cr=@$ledger_credit[ $LedgerAccount->id]-@$ref_bal_credit[ $LedgerAccount->id];
						$on_acc=$on_cr-$on_dr;
						if($grand_total >= 0){
							if($on_acc >=0){
								$total_data=$grand_total+$on_acc;
							}else{
								$total_data=$grand_total-abs($on_acc);
							}
						}else{
							if($on_acc >=0){
								$total_data=$grand_total+$on_acc;
							}else{
								$total_data=$grand_total-abs($on_acc);
							}
						}
						
						?>
						<td align="right"><?php echo $this->Number->format($on_acc,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($total_data,['places'=>2]); ?></td>
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