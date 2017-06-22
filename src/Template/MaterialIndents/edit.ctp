<style>
.disabledbutton {
    pointer-events: none;
    opacity: 0.4;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
	vertical-align: top !important;
}
</style>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">UPDATE Material Indent</span>
		</div>
		
	</div>

	
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= $this->Form->create($materialIndent,['id'=>'form_sample_3']) ?>
		<div class="form-body">

			
			<table class="table tableitm">
				<thead>
					<tr>
						<th>Sr.No. </th>
						<th>Items name</th>
						<th>Quantity</th>
					</tr>
				</thead>
				<tbody>
				<?php $item_ar=[];
					
					$q=0;
					//pr($materialIndent); exit;
					foreach ($materialIndent->material_indent_rows as $material_item):
					if($material_item->required_quantity==$material_item->processed_quantity){
					$disable_class="disabledbutton";
					}else{ $disable_class=""; } ?>
					<tr class="tr1 <?php echo $disable_class; ?> "  >
							<td>
								<?php echo ++$q; $q--;?>
							</td>
							<td>
								<?php echo $this->Form->input('material_indent_rows.'.$q.'.item_id', ['label' => false,'type'=>'hidden','value'=>$material_item->item_id]); ?>
								<?php echo $material_item->item->name; ?></td>
							<td>
								<?php echo $this->Form->input('material_indent_rows.'.$q.'.processed_quantity', ['label' => false,'type'=>'hidden','value'=>$material_item->processed_quantity]); ?>
								<?php echo $this->Form->input('material_indent_rows.'.$q.'.required_quantity', ['label' => false,'type'=>'text','value'=>$material_item->required_quantity-$material_item->processed_quantity]); ?>
							</td>
					</tr>
					<?php $q++; endforeach;  ?>
				</tbody>
			</table>
		</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">UPDATE MATERIAL INDENT</button>
			</div>
		<?= $this->Form->end() ?>
	</div>
	
<style>
.table thead tr th {
    color: #FFF;
	background-color: #254b73;
}
.padding-right-decrease{
	padding-right: 0;
}
.padding-left-decrease{
	padding-left: 0;
}
</style>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<script>

$(document).ready(function() { 
//--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		
		rules: {
			rules: {
				packing:{
					required: true,
				},
				required_date : {
					  required: true,
				},
				remark : {
					  required: true,
				},
			},
		},
	});
	
	$('.quantity').die().live("keyup",function() {
			var asc=$(this).val();
			var numbers =  /^[0-9]*\.?[0-9]*$/;
			if(asc==0)
			{
				$(this).val('');
				return false; 
			}
			else if(asc.match(numbers))  
			{  
			} 
			else  
			{  
				$(this).val('');
				return false;  
			}
	});

});
</script>	
