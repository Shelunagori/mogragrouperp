<style> 
.checkbox {
    margin-top:0px !important;
    margin-bottom:0px !important;
}
</style>
<?php $url_excel="/?".$url;?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Material Indent Report</span>
		</div>
		<div class="actions">
			<?= $this->Html->link(
					'Add To Cart',
					'/MaterialIndents/AddToCart',
					['class' => 'btn btn-primary']
				); ?>
			<?php echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Excel', '/ItemLedgers/Excel-Metarial-Export/'.$url_excel.'',['class' =>'btn btn-sm green tooltips','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>
		</div>
		<div class="portlet-body">
					<form method="GET" >
			<table width="50%" class="table table-condensed">
				<tbody>
					<tr>
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
						

						?>
						<tr class="tr1" row_no='<?php echo @$i; ?>'>
						<td ><?php echo $i; ?> </td>
						<td><?php echo $item_name; ?></td>
						<td style="text-align:center; valign:top" valign="top"><?php echo $Current_Stock; ?></td>
						<td style="text-align:center"><?php echo @$sales_order; ?></td>
						<td style="text-align:center"><?php echo $job_card_qty; ?></td>
						<td style="text-align:center"><?php echo $po_qty; ?></td>
						<td style="text-align:center"><?php echo $qo_qty; ?></td>
						<td style="text-align:center"><?php echo $Current_Stock-@$sales_order-$job_card_qty+$po_qty-$qo_qty; ?></td>

						<td>
							<label>
								<button type="button" id="item<?php echo $item_id;?>" class="btn btn-primary add_to_bucket" item_id="<?php echo $item_id; ?>" suggestindent="<?php echo abs($Current_Stock-@$sales_order-$job_card_qty+$po_qty-$qo_qty); ?>">Add</button>
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
	$('.add_to_bucket').die().live("click",function() {
		var t=$(this);
		var item_id=$(this).attr('item_id');
		var id=$(this).attr('id');
		var suggestindent=$(this).attr('suggestindent');
		var url="<?php echo $this->Url->build(['controller'=>'ItemLedgers','action'=>'addToBucket']); ?>";
		url=url+'/'+item_id+'/'+suggestindent,
		alert(url);
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			t.text('');
			t.text('Remove').removeClass('add_to_bucket').addClass('remove_bucket');
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