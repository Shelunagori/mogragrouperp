<style> 
.checkbox {
    margin-top:0px !important;
    margin-bottom:0px !important;
}
</style>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Material Indent Report</span>
		</div>
		<div class="actions">
		<?php 
			if(sizeof($company_name)==1){
			foreach($company_name as $names){			
						if(@$names == @$st_company_id){ ?>
			<?= $this->Html->link(
					'Add To Cart',
					'/MaterialIndents/AddToCart',
					['class' => 'btn btn-success']
			); }}}?>
			<!--<?php echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Excel', '/ItemLedgers/Excel-Metarial-Export/'.$url_excel.'',['class' =>'btn btn-sm green tooltips','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>-->
		</div>
		<div class="portlet-body">
					<form method="GET" >
			<table width="50%" class="table table-condensed">
				<tbody>
					<tr>
						<td width="35%">
						<?php if(!empty($company_name)){ ?>
								<?php echo $this->Form->input('company_name', ['empty'=>'---Companies---','options' => $Companies,'label' => false,'class'=>'form-control input-sm select2me','multiple'=>'multiple','value'=> $company_name]); ?>
						<?php }else{ ?>  
							<?php echo $this->Form->input('company_name', ['empty'=>'---Companies---','options' => $Companies,'label' => false,'class'=>'form-control input-sm select2me','multiple'=>'multiple','value'=> $st_company_id]); ?>
						<?php } ?>		
						</td>
						<td width="15%">
								<?php echo $this->Form->input('item_name', ['empty'=>'---Items---','options' => $Items,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category','value'=> h(@$item_name) ]); ?>
						</td>
						<td width="15%">
								<?php echo $this->Form->input('item_category', ['empty'=>'---Category---','options' => $ItemCategories,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category','value'=> h(@$item_category) ]); ?>
						</td>
						<td width="15%">
							<div id="item_group_div">
							<?php echo $this->Form->input('item_group_id', ['empty'=>'---Group---','options' =>$ItemGroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Group','value'=> h(@$item_group)]); ?></div>
						</td>
						<td width="15%">
							<div id="item_sub_group_div">
							<?php echo $this->Form->input('item_sub_group_id', ['empty'=>'---Sub-Group---','options' =>$ItemSubGroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Sub-Group','value'=> h(@$item_sub_group)]); ?></div>
						</td>
					
						<td width="10%">
							<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
						</td>
					</tr>
				</tbody>
			</table>
			</form>
		
			<?= $this->Form->create($mit) ?>
			<div class="row">
				<div class="col-md-12">
				
				<?php $page_no=$this->Paginator->current('ItemLedgers'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered "  id="main_tb">
					<thead>
						<tr>
							<th width="3%">Sr. No.</th>
							<th>Item Name</th>
							<th width="13%"  >Current Stock</th>
							<th width="10%">Sales Order </th>
							<th width="10%">Job card  </th>
							<th width="10%">Open PO  </th>
							<th width="10%">Open QO  </th>
							<th width="10%">Open MI  </th>
							<th width="15%">Suggested Indent</th>
							<th width="10%">Action</th>
						</tr>
					</thead>
					<tbody  >
						<?php $i=0; foreach($material_report as $data){
							$i++;
							$item_name=$data['item_name'];
							$item_id=$data['item_id'];
							$Current_Stock=$data['Current_Stock'];
							$sales_order=$data['sales_order'];
							$job_card_qty=$data['job_card_qty'];
							$po_qty=$data['po_qty'];
							$qo_qty=$data['qo_qty'];
							$mi_qty=$data['mi_qty'];
							$total = $Current_Stock-@$sales_order-$job_card_qty+$po_qty-$qo_qty+$mi_qty;
						?>
						<tr class="tr1" row_no='<?php echo @$i; ?>'>
						<td ><?php echo $i; ?> </td>
						<td><?php echo $item_name; ?></td>
						<td style="text-align:center; valign:top" valign="top"><?php if(!empty($Current_Stock)){ echo $Current_Stock; }else{ echo "-"; } ?></td>
						<td style="text-align:center"><?php if(!empty($sales_order)){ echo @$sales_order; }else{ echo "-"; } ?></td>
						<td style="text-align:center"><?php if(!empty($job_card_qty)){ echo $job_card_qty; }else{ echo "-"; } ?></td>
						<td style="text-align:center"><?php if(!empty($po_qty)){ echo $po_qty; }else{ echo "-"; }  ?></td>
						<td style="text-align:center"><?php if(!empty($qo_qty)){ echo $qo_qty; }else{ echo "-"; } ?></td>
						<td style="text-align:center"><?php if(!empty($mi_qty)){ echo $mi_qty; }else{ echo "-"; } ?></td>
						<td style="text-align:center">
							<?php if($total < 0){
								echo abs($total);
							}else{
								echo "-";
							} ?>
						</td>
						<td>
							<label>
							<?php 
							if(sizeof($company_name)==1){
							foreach($company_name as $names){			
										if(@$names == @$st_company_id){ ?>
											<button type="button" id="item<?php echo $item_id;?>" class="btn btn-primary btn-sm add_to_bucket" item_id="<?php echo $item_id; ?>" suggestindent="<?php echo abs($total); ?>">Add</button>
										<?php 		}						
							else{ ?>
								
							<?php }} } ?>	
							</label>
						</td>						
						</tr>
						<?php } ?>
					</tbody>
				</table>
					
				
				</div>
			</div>
			<?= $this->Form->end() ?>		
		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<script>
$(document).ready(function() {
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
	////
	$('.add_to_bucket').die().live("click",function() {
		var t=$(this);
		var item_id=$(this).attr('item_id');
		var id=$(this).attr('id');
		var suggestindent=$(this).attr('suggestindent');
		var url="<?php echo $this->Url->build(['controller'=>'ItemLedgers','action'=>'addToBucket']); ?>";
		url=url+'/'+item_id+'/'+suggestindent,
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			t.text('');
			t.text('Added to Cart').removeClass('btn-primary add_to_bucket').addClass('btn-success remove_bucket');
		});
 		
    })
	var p=0;
	function rename_rows(){ 
		$("#main_tb tbody tr.tr1").each(function(){
			var val=$(this).find('td:nth-child(9) input[type="checkbox"]:checked').val();
			if(val){
				$(this).css('background-color','#fffcda');
 			}else{
 				$(this).css('background-color','#FFF');
			}
		});
	}	
});		
</script>