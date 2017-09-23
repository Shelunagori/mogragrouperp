<?php
//pr(@$itemSerialNumberStatus); exit;
 $url_excel="/?".$url; ?>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Stock Report</span>
		</div>
		<div class="actions">
			<?php echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Excel', '/ItemLedgers/Excel-Stock/'.$url_excel.'',['class' =>'btn btn-sm green tooltips','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>
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
										<label class="control-label">From</label>
										<div>
										<?php 
										if(!empty($from_date))
										{
											$from_date=date("d-m-Y",strtotime($from_date));
											echo $this->Form->input('from_date', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'Date','data-date-format'=>'dd-mm-yyyy','id'=>'from_date','value' =>@$from_date]);
											
											
										}else{
											echo $this->Form->input('from_date', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'Date','id'=>'from_date','data-date-format'=>'dd-mm-yyyy','value' =>date('d-m-Y')]);
											
										} ?>
									</div>	
									
									</td>
									<td width="15%">
									<label class="control-label">To</label>
									<div><?php 
										if(!empty($to_date))
										{
											$to_date=date("d-m-Y",strtotime($to_date));
											echo $this->Form->input('to_date', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'Date','data-date-format'=>'dd-mm-yyyy','id'=>'to_date','value' =>@$to_date]);
										}else{
											echo $this->Form->input('to_date', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'Date','data-date-format'=>'dd-mm-yyyy','id'=>'to_date','value' =>date('d-m-Y')]);
										}
									?>
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
						<?php $total_inv=0; $totalColumn=0; $page_no=0;  $RowTotal=0;
						foreach ($item_stocks as $key=> $item_stock){
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
							<td align="right">
								<?php 
								//pr($key);
								//pr(@$itemSerialNumberStatus[$key]);
								 if(@$itemSerialNumberStatus[$key]==1){
									if($item_stock > 0){
										//echo @$unitRate[$key]."yes";
										echo $this->Number->format(@$unitRate[$key],['places'=>2]);
										$RowTotal=@$unitRate[$key]*$item_stock;
									}else{
										echo '0';
										$RowTotal=0;
									}
								}else{
									if($item_stock > 0){
										$UR=@$sumValue[$key]/$item_stock;
										echo $this->Number->format($UR,['places'=>2]);
										$RowTotal=$UR*@$item_stock;
									}else{
										echo '0';
										$RowTotal=0;
									}
								} 
								
								?>
							</td>
							<td align="right">
								<?php
								    echo $this->Number->format($RowTotal,['places'=>2]);
									$totalColumn+=$RowTotal;
								?>
							</td>
						</tr>
						
						<?php } ?>
						<?php if($to_date == date('d-m-Y') && !($stockstatus== "Positive")){ ?>
						<?php $page_no1=$page_no; foreach($ItemDatas as $key=>$ItemData){ ?>
						
						<tr class="main_tr1" id="<?= h($key) ?>">
							<td><?= h(++$page_no1) ?></td>
							<td width="90%" id="<?= h($key) ?>" class="loop_class"><button type="button"  class="btn btn-xs tooltips revision_hide1 show_data1" id="<?= h($key) ?>" value="" style="margin-left:5px;margin-bottom:2px;"><i class="fa fa-plus-circle"></i></button>
								<button type="button" class="btn btn-xs tooltips revision_show1" style="margin-left:5px;margin-bottom:2px; display:none;"><i class="fa fa-minus-circle"></i></button>
								&nbsp;&nbsp;<?= h($ItemData) ?><div class="show_ledger1"></div></td>
							
							<td><?= h(0) ?></td>
							
							<td><?= h($ItemUnits[$key]) ?></td>
							<td align="right"><?= h($this->Number->format(0,['places'=>2])) ?></td>
							<td align="right"><?= h($this->Number->format(0,['places'=>2])) ?></td>
						</tr>
						<?php } } ?>
						<tr>
							<td colspan="5" align="right">Total</td>
							<td align="right"><?= h($this->Number->format($totalColumn,['places'=>2])) ?></td>
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
		var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
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
	 
	 $('.show_data1').live("click",function() { 
		var sel=$(this); 
		
		var item_id=$(this).attr("id");
		show_ledger_data1(sel,item_id);
	});
	 function show_ledger_data1(sel,item_id)
	 {
		 $(sel).closest('tr.main_tr1').find('.revision_show1').show();
		$(sel).closest('tr.main_tr1').find('.revision_hide1').hide();
		$(sel).closest('tr.main_tr1').find('.show_ledger1').html('<span >No Transacaction</span>');
		 
	 }
	 $('.revision_show1').live("click",function() {  
		var sel=$(this);
		$(sel).closest('tr.main_tr1').find('.revision_show1').hide();
		$(sel).closest('tr.main_tr1').find('.revision_hide1').show();
		$(sel).closest('tr.main_tr1').find('.show_ledger1').html('');
	 });
});
		
</script>