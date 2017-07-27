<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Stock Report</span>
		</div>
		<div class="portlet-body">
			<div class="row">
				<div class="col-md-12">
					<form method="GET" >
						<table class="table table-condensed">
							<tbody>
								<tr>
									<td width="15%">
											<label class="control-label">Items </label>
											<?php echo $this->Form->input('item_name', ['empty'=>'--Select--','options' => $Items,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category','value'=> h(@$item_name) ]); ?>
									</td>
									<td width="15%">
											<label class="control-label">Category </label>
											<?php echo $this->Form->input('item_category', ['empty'=>'--Select--','options' => $ItemCategories,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category','value'=> h(@$item_category) ]); ?>
									</td>
									<td width="15%">
										<label class="control-label">Group</label>
										<div id="item_group_div">
										<?php echo $this->Form->input('item_group_id', ['empty'=>'--Select--','options' =>$ItemGroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Group','value'=> h(@$item_group)]); ?></div>
									</td>
									<td width="15%">
										<label class="control-label">Sub-Group</label>
										<div id="item_sub_group_div">
										<?php echo $this->Form->input('item_sub_group_id', ['empty'=>'--Select--','options' =>$ItemSubGroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Sub-Group','value'=> h(@$item_sub_group)]); ?></div>
									</td>
									<td width="15%">
										<label class="control-label">Stock</label>
										<div id="item_sub_group_div">
										<?php 
											$options = [];
											$options = [['text'=>'All','value'=>'All'],['text'=>'Negative','value'=>'Negative'],['text'=>'Zero','value'=>'Zero'],['text'=>'Close Stock','value'=>'Positive']];
										echo $this->Form->input('stock', ['empty'=>'--Select--','options' => $options,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Sub-Group','value'=> h(@$stock)]); ?></div>
									</td>
									<td width="15%">
										<label class="control-label">Date</label>
										<div>
										<?php 
										if(!empty($search_date))
										{
											$date=date("d-m-Y",strtotime($search_date));
											echo $this->Form->input('search_date', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'Date','data-date-format'=>'dd-mm-yyyy','value' =>@$date]);
											
										}else{
											echo $this->Form->input('search_date', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'Date','data-date-format'=>'dd-mm-yyyy','value' =>date('d-m-Y')]);
										} ?>
									</div>	
									</td>
									<td><button type="submit" style="margin-top: 24px;" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				
				
				<div class="col-md-12"><br/></div>
				<table class="table table-bordered table-striped table-hover" id="main_tble">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Item</th>
							<th>Current Stock</th>
							<th>Unit</th>
							<th style="text-align:right;">Unit Rate</th>
							<th style="text-align:right;">Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php $total_inv=0; $page_no=0; foreach ($item_stocks as $key=> $item_stock):
						if($item_stock!=0){
							if(@$in_qty[$key]==0){ 
								$per_unit=@$item_rate[$key];
							}else{
							$per_unit=@$item_rate[$key]/@$in_qty[$key];
							}
						}else{ 
							if(@$in_qty[$key]==0){ 
								$per_unit=@$item_rate[$key];
							}else{
							$per_unit=@$item_rate[$key]/@$in_qty[$key];
							}
							
						}
						
						$amount=@$item_stock*abs($per_unit);
						$total_inv+=$amount;
						?>
							
						<tr class="main_tr" id="<?= h($key) ?>">
							<td><?= h(++$page_no) ?></td>
							<td width="90%" id="<?= h($key) ?>" class="loop_class"><button type="button"  class="btn btn-xs tooltips revision_hide show_data" id="<?= h($key) ?>" value="" style="margin-left:5px;margin-bottom:2px;"><i class="fa fa-plus-circle"></i></button>
								<button type="button" class="btn btn-xs tooltips revision_show" style="margin-left:5px;margin-bottom:2px; display:none;"><i class="fa fa-minus-circle"></i></button>
								&nbsp;&nbsp;<?= h($items_names[$key]) ?><div class="show_ledger"></div></td>
							<td><?= h($item_stock) ?></td>
							<td><?= h($items_unit_names[$key]) ?></td>
							<td align="right"><?= h($this->Number->format(@$per_unit,['places'=>2])) ?></td>
							<td align="right"><?= h($this->Number->format($amount,['places'=>2])) ?></td>
						</tr>
						
						<?php endforeach; ?>
						<?php $page_no1=$page_no; foreach($ItemDatas as $key=>$ItemData){ ?>
						
						<tr>
							<td><?= h(++$page_no1) ?></td>
							<td><?= $this->Html->link(@$ItemData, ['controller' => 'ItemLedgers', 'action' => 'index',$key]) ?></td>
							<td><?= h(0) ?></td>
							<td align="right"><?= h($this->Number->format(0,['places'=>2])) ?></td>
							<td align="right"><?= h($this->Number->format(0,['places'=>2])) ?></td>
						</tr>
						<?php } ?>
						<tr>
							<td colspan="4" align="right">Total</td>
							<td align="right"><?= h($this->Number->format($total_inv,['places'=>2])) ?></td>
						</tr>
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
	////////
	$('select[name="item_category"]').on("change",function() {
		$('#item_group_div').html('Loading...');
		var itemCategoryId=$('select[name="item_category"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'ItemGroups','action'=>'ItemGroupDropdown']); ?>";
		url=url+'/'+itemCategoryId,
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			$('#item_group_div').html(response);
			$('select[name="item_group_id"]').select2();
		});
	});	
	//////
	$('select[name="item_group_id"]').die().live("change",function() {
		$('#item_sub_group_div').html('Loading...');
		var itemGroupId=$('select[name="item_group_id"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'ItemSubGroups','action'=>'ItemSubGroupDropdown']); ?>";
		url=url+'/'+itemGroupId,
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			$('#item_sub_group_div').html(response);
			$('select[name="item_sub_group_id"]').select2();
		});
	});
	
		
		$('.show_data').live("click",function() {
		var sel=$(this); 
		var item_id=$(this).attr("id");
		show_ledger_data(sel,item_id);
	});
	 function show_ledger_data(sel,item_id)
	 {
		//var from_date = $("#from_date").val();
		//var to_date = $("#to_date").val();
		//alert(from_date+'-'+to_date);
		var url="<?php echo $this->Url->build(['controller'=>'ItemLedgers','action'=>'fetchLedger']); ?>";
		url=url+'/'+item_id;
		
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
});
		
</script>