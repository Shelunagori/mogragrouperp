
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
			<table class="table table-condensed" >
				<tbody>
					<tr>
					    <td width="20%">
					    <?php echo $this->Form->input('items', ['empty'=>'--Items--','options' => $Items_list,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category','value'=> h(@$items) ]); ?>
						</td>
						<td width="20%">
							<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" id="from_date" value="<?php echo @$From; ?>"  data-date-format="dd-mm-yyyy" >
						</td>
						<td width="20%">
									<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" id="to_date" value="<?php echo @$To; ?>"  data-date-format="dd-mm-yyyy" >
						</td>
						<td>
							<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<!--<div class="radio-list" >
			<div class="radio-inline" style="margin-left:0px;">
			<?php echo $this->Form->radio(
				'bill_to_bill_account',
				[
					['value' => 'Expand', 'text' => 'Expand','class'=>'items_show'],
					['value' => 'Collapse', 'text' => 'Collapse','class'=>'items_hide']
					
				]
			); ?>
			</div>
		</div>-->
		
		<div class="portlet-body">
			<div class="row">
				<div class="col-md-12">
					
					<table class="table table-bordered table-striped table-hover" id="main_table">
						<thead>
							<tr>
								<th>Sr. No.</th>
								<!--<th>Processed On</th>-->
								<th>Item</th>
								<!--<th>Voucher Source</th>
								<th>Voucher No.</th>
								<th>In</th>
								<th>Out</th>
								<th style="text-align:right;">Rate</th>-->
							</tr>
						</thead>
						<tbody id="main_tbody">
							<?php  $page_no=0; foreach ($Items as $key =>  $Item){ ?>
							<tr class="main_tr" id="<?= h($key) ?>">
								<td ><?= h(++$page_no) ?></td>
								<!--<td width="10%"><?php //h(date("d-m-Y",strtotime($itemLedger->processed_on))) ?></td>-->
								<td width="90%" id="<?= h($key) ?>" class="loop_class">
								<button type="button"  class="btn btn-xs tooltips revision_hide show_data" id="<?= h($key) ?>" value="" style="margin-left:5px;margin-bottom:2px;"><i class="fa fa-plus-circle"></i></button>
								<button type="button" class="btn btn-xs tooltips revision_show" style="margin-left:5px;margin-bottom:2px; display:none;"><i class="fa fa-minus-circle"></i></button>
								&nbsp;&nbsp;<?= h($Item) ?><div class="show_ledger"></div>
								</td>
								<!--<td><?php //h($itemLedger->source_model) ?></td>
								<td><?php 
									/*if(!empty($url_path)){
										echo $this->Html->link(@$voucher_no ,@$url_path,['target' => '_blank']); 
									}else{
										echo @$voucher_no;
									}*/
								?>
								</td>
									<td><?php //if($in_out_type=='In'){ echo $itemLedger->quantity; } else { echo '-'; } ?></td>
								<td><?php //echo $status; ?></td>
								<td align="right"><?php //echo $this->Number->format($itemLedger->rate,['places'=>2]); ?></td>-->
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
var $rows = $('#main_table tbody tr');
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
	
	$('.show_data').live("click",function() {
		var sel=$(this); 
		var item_id=$(this).attr("id");
		show_ledger_data(sel,item_id);
	});
	 function show_ledger_data(sel,item_id)
	 {
		var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
		//alert(from_date+'-'+to_date);
		var url="<?php echo $this->Url->build(['controller'=>'ItemLedgers','action'=>'fetchLedger']); ?>";
		url=url+'/'+item_id+'/'+from_date+'/'+to_date;
		
	       $.ajax({
				url: url,
				type: 'GET',
				dataType: 'text'
			}).done(function(response) {  
			    $(sel).closest('tr.main_tr').find('.revision_show').show();
				$(sel).closest('tr.main_tr').find('.revision_hide').hide();
				$(sel).closest('tr.main_tr').find('.show_ledger').html(response);
				
			});
		 
	 }
	 $('.revision_show').live("click",function() { 
		var sel=$(this);
		$(sel).closest('tr.main_tr').find('.revision_show').hide();
		$(sel).closest('tr.main_tr').find('.revision_hide').show();
		$(sel).closest('tr.main_tr').find('.show_ledger').html('');
	 });
	 
	 $('.items_show').live("click",function() {
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){
			var sel=$(this).closest('tr.main_tr');
			var item_id=$(this).attr("id"); 
		     var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
		var url="<?php echo $this->Url->build(['controller'=>'ItemLedgers','action'=>'fetchLedger']); ?>";
		url=url+'/'+item_id+'/'+from_date+'/'+to_date;
		
	       $.ajax({
				url: url,
				type: 'GET',
				dataType: 'text'
			}).done(function(response) {  
			    $(sel).find('.revision_show').show();
				$(sel).find('.revision_hide').hide();
				$(sel).find('.show_ledger').html(response);
				
			});
		
		});
	}); 
	
	$('.items_hide').live("click",function() {
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){
			    var sel=$(this).closest('tr.main_tr');
			    $(sel).find('.revision_show').hide();
				$(sel).find('.revision_hide').show();
				$(sel).find('.show_ledger').html('');
			});
			
		});
});
		
</script>