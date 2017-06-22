<style> 
.checkbox {
    margin-top:0px !important;
    margin-bottom:0px !important;
}
</style>
<?php //pr($material_report); exit; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Material Indent Report</span>
		</div>
		<div class="portlet-body">
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
						

						?>
						<tr class="tr1" row_no='<?php echo @$i; ?>'>
						<td ><?php echo $i; ?> </td>
						<td><?php echo $item_name; ?></td>
						<td style="text-align:center; valign:top" valign="top"><?php echo $Current_Stock; ?></td>
						<td style="text-align:center"><?php echo @$sales_order; ?></td>
						<td style="text-align:center"><?php echo $job_card_qty; ?></td>
						<td style="text-align:center"><?php echo $Current_Stock-@$sales_order-$job_card_qty; ?></td>

						<td ><label ><?php echo $this->Form->input('check[]', ['label' => false,'type'=>'checkbox','class'=>'rename_check','style'=>' ','value' => @$item_id,'hiddenField'=>false]);  ?>

						
						<?php echo $this->Form->input('suggestindent.'.$item_id, ['label' => false,'type'=>'hidden','value' => @abs($Current_Stock-@$sales_order-$job_card_qty)]); ?>
						
						
						</label>
						</td>						
						</tr>
						<?php } ?>
					</tbody>
				</table>
					<div class="form-actions">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
				<div class="paginator">
					<ul class="pagination">
						
					</ul>
					<p></p>
				</div>
				</div>
			</div>
			<?= $this->Form->end() ?>		
		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<script>
$(document).ready(function() {
	$('.rename_check').die().live("click",function() {
 		rename_rows();
    })
	var p=0;
	function rename_rows(){ 
		$("#main_tb tbody tr.tr1").each(function(){
			var val=$(this).find('td:nth-child(7) input[type="checkbox"]:checked').val();
			if(val){
				$(this).css('background-color','#fffcda');
 			}else{
 				$(this).css('background-color','#FFF');
			}
		});
	}	
});		
</script>