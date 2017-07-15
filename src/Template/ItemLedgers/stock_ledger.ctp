
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Item Ledger Report</span>
		</div>
		<div class="actions hide_at_print"> 
			<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3" style="width: 200px;">
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
					</tr>
				</tbody>
			</table>
		</form>
		<div class="portlet-body">
			<div class="row">
				<div class="col-md-12">
					
					<table class="table table-bordered table-striped table-hover">
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
							<?php  $page_no=0; foreach ($itemLedgersdata as  $itemLedger){ 
							$url_path="";
							$in_out_type=$itemLedger->in_out;
							$source_model=$itemLedger->source_model;
							 if($source_model=='Invoices')
								{
									$voucher_no=$itemLedger->voucher_info->in1.'/IN-'.str_pad($itemLedger->voucher_info->in2, 3, '0', STR_PAD_LEFT).'/'.$itemLedger->voucher_info->in3.'/'.$itemLedger->voucher_info->in4;
									if($itemLedger->voucher_info->invoice_type=='GST'){ 
									$url_path="/Invoices/GstConfirm/".$itemLedger->voucher_info->id;
									}else{
										$url_path="/Invoices/confirm/".$itemLedger->voucher_info->id;
									}
								}else if($source_model=='Grns')
								{
									$voucher_no=$itemLedger->voucher_info->grn1.'/GRN-'.str_pad($itemLedger->voucher_info->grn2, 3, '0', STR_PAD_LEFT).'/'.$itemLedger->voucher_info->grn3.'/'.$itemLedger->voucher_info->grn4;
									$url_path="/InvoiceBookings/view/".$itemLedger->voucher_info->id;
							}
								else if($source_model=='Inventory Transfer Voucher')
								{
									$voucher_no='#'.str_pad($itemLedger->voucher_info->voucher_no, 4, '0', STR_PAD_LEFT);
									if($itemLedger->in_out=='in_out'){
										$url_path="/inventory-transfer-vouchers/view/".$itemLedger->voucher_info->id;
									}else if($itemLedger->in_out=='In'){
										$url_path="/inventory-transfer-vouchers/inView/".$itemLedger->voucher_info->id;
									}else{
										$url_path="/inventory-transfer-vouchers/outView/".$itemLedger->voucher_info->id;
							}

								}
								else if($source_model=='Inventory Return')
								{
									$voucher_no='#'.str_pad($itemLedger->voucher_info->voucher_no, 4, '0', STR_PAD_LEFT);
									$url_path="/Rivs/view/".$itemLedger->voucher_info->id;
								}
								else if($source_model=='Sale Return')
								{
									$voucher_no=$itemLedger->voucher_info->sr1.'/GRN-'.str_pad($itemLedger->voucher_info->sr2, 3, '0', STR_PAD_LEFT).'/'.$itemLedger->voucher_info->sr3.'/'.$itemLedger->voucher_info->sr4;
									$url_path="/saleReturns/View/".$itemLedger->voucher_info->id;
								}
								else if($source_model=="Purchase Return"){
									$voucher_no='#'.str_pad($itemLedger->voucher_info->voucher_no, 4, '0', STR_PAD_LEFT);
									$url_path="";
								}
								else if($source_model=="Inventory Vouchers"){
									$voucher_no='#'.str_pad($itemLedger->voucher_info->iv_number, 4, '0', STR_PAD_LEFT);
									$url_path="/inventory-vouchers/view/".$itemLedger->voucher_info->id;
								}
								else if($source_model=="Challan"){
									$voucher_no=$itemLedger->voucher_info->ch1.'/CH-'.str_pad($itemLedger->voucher_info->ch2, 3, '0', STR_PAD_LEFT).'/'.$itemLedger->voucher_info->ch3.'/'.$itemLedger->voucher_info->ch4;
								}
								$status= '-';
								if($in_out_type=='Out'){
							if($itemLedger->voucher_info->challan_type=='Returnable'){
								$status=$this->Number->format($itemLedger->quantity);
							} else{
								$status= $this->Number->format($itemLedger->quantity);
							}
						}
						?>
							<tr>
								<td><?= h(++$page_no) ?></td>
								<td width="10%"><?= h(date("d-m-Y",strtotime($itemLedger->processed_on))) ?></td>
								<td width="20%"><?= h($itemLedger->item->name) ?></td>
								<td><?= h($itemLedger->source_model) ?></td>
								<td><?php if($in_out_type=='In'){ echo $itemLedger->quantity; } else { echo '-'; } ?></td>
							<td><?php echo $status; ?></td>
							<td align="right"><?php echo $this->Number->format($itemLedger->rate,['places'=>2]); ?></td>
							</tr>	
							<?php } ?>
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