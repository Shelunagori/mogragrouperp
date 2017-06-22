<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Material Indents</span> 
			<?php if($pull_request=="true"){ ?>
			: Select a Material Indent to convert into Purchase Order
			<?php } ?>
	    </div>
<div class="portlet-body">
	<?= $this->Form->create($mireport) ?>
	<div class="row">
		<div class="col-md-12">				 
			<?php $page_no=$this->Paginator->current('MaterialIndentS'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered " width="100%" id="main_tb" border="1">
					<thead>
						<th>S.No</th>
						<th>Item</th>
						<th>Total Quantity</th>
						<th>Action</th>
					</thead>
					<tbody >
					<?php foreach($MaterialIndentRows as $MaterialIndentRow){ ?>
						<tr class="main_tr">
							<td><?= h(++$page_no) ?></td>
							<td><?= h($MaterialIndentRow->item->name) ?></td>
							<td><?= h($MaterialIndentRow->r_quantity-$MaterialIndentRow->p_quantity) ?></td>
							<td>
								<?php echo $this->Form->input('to_be_send['.$MaterialIndentRow->item_id.']', ['label' => false,'type'=>'checkbox','class'=>'rename_check','value' => (@$MaterialIndentRow->r_quantity-$MaterialIndentRow->p_quantity),'hiddenField'=>false]);  ?>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<div align="right" class="form-actions">
					<button type="submit" class="btn btn-primary">Pull & Create Purchase Order</button>
					<?php echo $this->Html->link("Skip And Next", array('controller' => 'PurchaseOrders','action'=> 'Add'), array( 'class' => 'btn green')); ?>
					
				</div>
			</div>
		</div>
		<?= $this->Form->end() ?>		
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
		var i=0;
		$("#main_tb tbody tr.tr1").each(function(){
			var val=$(this).find('td:nth-child(3) input[type="checkbox"]:checked').val();
			var mi=$(this).find('td:nth-child(1) input[type="hidden"]').val();
			if(val){
				$(this).css('background-color','#fffcda');
				
				$(this).find('td:nth-child(1) input').attr("name","prepo["+mi+"]["+val+"][item_id]").attr("id","prepo-"+val+"-item_id");
				$(this).find('td:nth-child(2) input').attr("name","prepo["+mi+"]["+val+"][quantity]").attr("id","prepo-"+val+"-quantity");
				
				
 			}else{
 				$(this).css('background-color','#FFF');
				
			}
		});
	}	
		
		//rename_rows();
    
});		
</script>
