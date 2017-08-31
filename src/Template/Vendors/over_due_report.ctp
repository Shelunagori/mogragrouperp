<?php //pr($customers); exit;?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Overdues For Suppliers</span>
		</div>
	</div>
	<form method="GET" >
		<table width="100%">
			<tbody>
				<tr>
				<td width="15%">
						<label class="control-label">Stock</label>
						<div id="item_sub_group_div">
						<?php 
							$options = [];
							$options = [['text'=>'Zero','value'=>'Zero'],['text'=>'Negative','value'=>'Negative'],['text'=>'Positive','value'=>'Positive']];
						echo $this->Form->input('total', ['empty'=>'--Select--','options' => $options,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Sub-Group','value'=> h(@$stock)]); ?></div>
					</td>
				<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
					</td>
					<td align="right" width="15%"><input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3"  style="width: 100%;"></td>
				</tr>
			</tbody>
		</table>
	</form>
	
	<div class="portlet-body">
	 
		<div class="table-scrollable">
			<table style="font-size:11px;" class="table table-bordered table-striped" id="main_tble">
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
						<th style="text-align: right;">No-Due</th>
						<th style="text-align: right;">Close Bal</th>
					</tr>
				</thead>
				<tbody>
					<?php  $page_no=0;	$total_over_due_amount=0;				
					foreach ($LedgerAccounts as $LedgerAccount){ 
					@$hide ="style='display:;'";
					if((!empty($total_debit_1)) || (!empty($total_credit_1))){
					$total1=@$total_credit_1[ $LedgerAccount->id] - @$total_debit_1[ $LedgerAccount->id];}
					if((!empty($total_debit_2)) || (!empty($total_credit_2))){
					$total2=@$total_credit_2[ $LedgerAccount->id] - @$total_debit_2[ $LedgerAccount->id];}
					if((!empty($total_debit_3)) || (!empty($total_credit_3))){
					$total3=@$total_credit_3[ $LedgerAccount->id] - @$total_debit_3[ $LedgerAccount->id];}
					if((!empty($total_debit_4)) || (!empty($total_credit_4))){
					$total4=@$total_credit_4[ $LedgerAccount->id] - @$total_debit_4[ $LedgerAccount->id];}
					if((!empty($total_debit_5)) || (!empty($total_credit_5))){
					$total5=@$total_credit_5[ $LedgerAccount->id] - @$total_debit_5[ $LedgerAccount->id];}
					$grand_total=$total1+$total2+$total3+$total4+$total5;
					$on_acc=0;
						$on_dr=@$ledger_debit[ $LedgerAccount->id]-@$ref_bal_debit[ $LedgerAccount->id];
						$on_cr=@$ledger_credit[ $LedgerAccount->id]-@$ref_bal_credit[ $LedgerAccount->id];
						$on_acc=$on_cr-$on_dr;
						if($grand_total >= 0){
							if($on_acc >=0){
								$total_data=$grand_total+$on_acc;
							}else{
								//$total_data=$grand_total-abs($on_acc);
								//$on_acc=abs($on_acc);
								
								 $total_data=number_format((float)$grand_total, 2, '.', '') - number_format((float)abs($on_acc), 2, '.', '');
							}
						}else{
							if($on_acc >=0){
								$total_data=$grand_total+$on_acc;
							}else{
								//$total_data=$grand_total-abs($on_acc);
								
								 $total_data=number_format((float)$grand_total, 2, '.', '') - number_format((float)abs($on_acc), 2, '.', '');
							}
						}
						if(empty($stock))
						{
							$page_no =++$page_no; 
							$total_over_due_amount = $total_over_due_amount+$total_data;
						}
						if(@$stock=="Positive")
						{ 
							if($total_data <= 0 )
							{
								@$hide ="style='display:none;'";
							}
							else{
								$page_no =++$page_no;
								$total_over_due_amount = $total_over_due_amount+$total_data;
							}
						}
						if(@$stock=="Negative")
						{
							if($total_data > 0 || $total_data==0)
							{
								  @$hide ="style='display:none;'";
							}
							else{
								$page_no =++$page_no;
								$total_over_due_amount = $total_over_due_amount+$total_data;
							}
						}
						if(@$stock=="Zero")
						{
							if($total_data > 0 || $total_data < 0 )
							{
								@$hide ="style='display:none;'";
							}
							else{
								$page_no =++$page_no;
								$total_over_due_amount = $total_over_due_amount+$total_data;
							}
						}
					?>
					<tr <?php echo @$hide; ?>>
						<td><?= h($page_no) ?></td>
						<td><?php echo $LedgerAccount->name; ?></td>
						<td><?php echo $custmer_payment_terms[$LedgerAccount->id];?></td>
						<?php if((!empty($total_debit_1)) || (!empty($total_credit_1))){
									$total1=@$total_credit_1[ $LedgerAccount->id] - @$total_debit_1[ $LedgerAccount->id];
									
									
									if(@$total_debit_1[ $LedgerAccount->id] > @$total_credit_1[ $LedgerAccount->id]){ ?>
									<td align="right" style="color: red;"><?php echo $this->Number->format($total1,['places'=>2]); ?></td>
						<?php } else { ?>
									<td align="right"><?php echo $this->Number->format($total1,['places'=>2]); ?></td>
						<?php } }  ?>
						
						<?php if((!empty($total_debit_2)) || (!empty($total_credit_2))){
									$total2=@$total_credit_2[ $LedgerAccount->id] - @$total_debit_2[ $LedgerAccount->id];
									if(@$total_debit_2[ $LedgerAccount->id] < @$total_credit_2[ $LedgerAccount->id]){ ?>
									<td align="right" style="color: red;"><?php echo $this->Number->format($total2,['places'=>2]); ?></td>
						<?php } else { ?>
									<td align="right"><?php echo $this->Number->format($total2,['places'=>2]); ?></td>
						<?php } } ?>
						
						<?php if((!empty($total_debit_3)) || (!empty($total_credit_3))){
									
									$total3=@$total_credit_3[ $LedgerAccount->id] - @$total_debit_3[ $LedgerAccount->id];
									if(@$total_debit_3[ $LedgerAccount->id] < @$total_credit_3[ $LedgerAccount->id]){ ?>
									<td align="right" style="color: red;"><?php echo $this->Number->format($total3,['places'=>2]); ?></td>
						<?php } else { ?>
									<td align="right"><?php echo $this->Number->format($total3,['places'=>2]); ?></td>
						<?php } } ?>
						
						<?php if((!empty($total_debit_4)) || (!empty($total_credit_4))){
									$total4=@$total_credit_4[ $LedgerAccount->id] - @$total_debit_4[ $LedgerAccount->id];
									if(@$total_debit_4[ $LedgerAccount->id] < @$total_credit_4[ $LedgerAccount->id]){ ?>
									<td align="right" style="color: red;"><?php echo $this->Number->format($total4,['places'=>2]); ?></td>
						<?php } else { ?>
									<td align="right"><?php echo $this->Number->format($total4,['places'=>2]); ?></td>
						<?php } } ?>
						
						<?php if((!empty($total_debit_5)) || (!empty($total_credit_5))){
									$total5=@$total_credit_5[ $LedgerAccount->id] - @$total_debit_5[ $LedgerAccount->id];
									if(@$total_debit_5[ $LedgerAccount->id] < @$total_credit_5[ $LedgerAccount->id]){ ?>
									<td align="right" style="color: red;"><?php echo $this->Number->format($total5,['places'=>2]); ?></td>
						<?php } else { ?>
									<td align="right"><?php echo $this->Number->format($total5,['places'=>2]); ?></td>
						<?php } } 
						
						?>
						<?php $acc_color=""; if($on_acc > 0){ $acc_color="red"; } ?>
						<td align="right" style="color:<?php echo $acc_color; ?>"><?php echo $this->Number->format($on_acc,['places'=>2]); ?></td>
						<?php $acc_color2=""; if($total_data > 0){ $acc_color2="red"; } ?>
						<td align="right" style="color:<?php echo $acc_color2; ?>">
						<?php echo sprintf ("%.2f", $total_data); ?></td>
						
						<?php if((!empty($total_debit_6)) || (!empty($total_credit_6))){
									$total6=@$total_credit_6[ $LedgerAccount->id] - @$total_debit_6[ $LedgerAccount->id];
									if(@$total_debit_6[ $LedgerAccount->id] > @$total_credit_6[ $LedgerAccount->id]){ ?>
									<td align="right" style=""><?php echo $this->Number->format($total6,['places'=>2]); ?></td>
						<?php } else { ?>
									<td align="right"><?php echo $this->Number->format($total6,['places'=>2]); ?></td>
						<?php } } ?>
						<?php $close_bal=0; if($total_data > 0){ $close_bal=$total6+$total_data; ?>
						<td><?php echo $this->Number->format($close_bal,['places'=>2]); ?></td>
						<?php } else { $close_bal=$total6+$total_data; ?>
						<td><?php echo $this->Number->format($close_bal,['places'=>2]); ?></td>
						<?php } ?>
					</tr>
					<?php }  ?>	
				
				</tbody>
				<tfoot>
				<tr>
					<td colspan="9" align="right">Total : </td>
					<td align="right"><?php echo @$total_over_due_amount;?></td>
				</tr>
				</tfoot>
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