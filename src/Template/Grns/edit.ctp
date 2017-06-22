<?php if($financial_year_data['Response'] == "Close" ){
 			echo "Financial Year Closed"; 

 		} else { ?>
<style>
.sr_no{
	float: left;
	margin-left: 5px;
	margin-top: 5px;
}
</style>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Edit Goods Receipt Note</span>
		
		</div>
		
	</div>
	
	<div class="portlet-body form">
		<?= $this->Form->create($grn,['id'=>'form_sample_3']) ?>
		<div class="form-body">
			<div class="form-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Company <span class="required" aria-required="true">*</span></label>
							<br/>
							<?php echo @$grn->company->name; ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">GRN No. <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<div class="col-md-4">
									<?php echo $this->Form->input('grn1', ['label' => false,'class' => 'form-control input-sm','readonly','value'=>@$grn->company->alias]); ?>
								</div>
								<div class="col-md-4">
									<?php echo $this->Form->input('grn3', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'File', 'value'=>@$grn->grn3,'readonly']); ?>
								</div>
								<div class="col-md-4">
									<?php echo $this->Form->input('grn4', ['label' => false,'class' => 'form-control input-sm','readonly']); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">Date</label>
							<br/>
							<?php echo date("d-m-Y"); ?>
						</div>
					</div>
				</div><br/>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Supplier <span class="required" aria-required="true">*</span></label>
							<br/>
							<?php echo @$grn->vendor->company_name; ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Road Permit No<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('road_permit_no', ['label' => false,'class' => 'form-control input-sm','placeholder' => 'Road permit No']); ?>
						</div>
					</div>
				</div>
			
				<table class="table tableitm" id="main_tb">
					<thead>
						<tr>
							<th width="10%">Sr.No. </th>
							<th width="70%">Items</th>
							<th width="15%">Quantity</th>
							<th width="5%"></th>
							
						</tr>
					</thead>
					<tbody>
					
						<?php 
							foreach($grn->purchase_order->grns as $data){
								foreach($data->grn_rows as $data2){
									//pr(@$data2->quantity);
									$processed_items[$data2->item_id]=@$processed_items[$data2->item_id]+$data2->quantity;
								}
							}
							foreach($grn->purchase_order->purchase_order_rows as $data3){
								//pr($data3->quantity);
								$total_items[$data3->item_id]=@$total_items[$data3->item_id]+$data3->quantity;
								//pr($total_items[$data3->item_id]);
							}
							$q=0; foreach ($grn->grn_rows as $grn_rows): ?>
							<tr class="tr1" row_no='<?php echo @$grn_rows->id; ?>'>
								<td rowspan="2"><?php echo ++$q; --$q; ?></td>
								<td>
									<?php echo $this->Form->input('q', ['type' => 'hidden','value'=>@$grn_rows->item_id]); 
									echo $this->Form->input('q', ['type' => 'hidden','value'=>@$grn_rows->item->serial_number_enable]);
									echo $grn_rows->item->name;
									?>								
								</td>
								<td>
								
								<?php echo $this->Form->input('q', ['label' => false,'type' => 'text','class' => 'form-control input-sm quan quantity','placeholder'=>'Quantity','value' => @$grn_rows->quantity-$grn_rows->processed_quantity,'min'=>'1','max'=>$total_items[$grn_rows->item_id]-$processed_items[$grn_rows->item_id]+$grn_rows->quantity]); ?>
								</td>
								<td>
									<label><?php echo $this->Form->input('check.'.$q, ['label' => false,'type'=>'checkbox','class'=>'rename_check','value' => @$grn_rows->id,'checked'=>"checked"]); ?></label>
								</td>
								
							</tr>
							<tr class="tr2" row_no='<?php echo @$grn_rows->id; ?>'>
								<td colspan="3">
								<?php foreach($grn->item_serial_numbers as $item_serial_number){
									if($item_serial_number->item_id == $grn_rows->item_id){ ?>
									<?php echo $item_serial_number->serial_no; ?>

								<?php }}?><br/></td>
							</tr>
						<?php $q++; endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php echo $this->Form->input('purchase_order_id', ['type' => 'hidden','value'=>@$grn->purchase_order_id]); ?>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-primary" id='submitbtn'>EDIT GRN</button>
					</div>
				</div>
			</div>
		</div>
		<?= $this->Form->end() ?>
	</div>
</div>	
<style>
.table thead tr th {
    color: #FFF;
	background-color: #254b73;
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
			grn1:{
				required: true,
			},
			grn3:{
				required: true,
			},
			grn4:{
				required: true,
			},
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.parent(".input-group").size() > 0) {
				error.insertAfter(element.parent(".input-group"));
			} else if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else if (element.parents('.radio-list').size() > 0) { 
				error.appendTo(element.parents('.radio-list').attr("data-error-container"));
			} else if (element.parents('.radio-inline').size() > 0) { 
				error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
			} else if (element.parents('.checkbox-list').size() > 0) {
				error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
			} else if (element.parents('.checkbox-inline').size() > 0) { 
				error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
			success3.hide();
			error3.show();
			Metronic.scrollTo(error3, -200);
		},

		highlight: function (element) { // hightlight error inputs
		   $(element)
				.closest('.form-group').addClass('has-error'); // set error class to the control group
		},

		unhighlight: function (element) { // revert the change done by hightlight
			$(element)
				.closest('.form-group').removeClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label
				.closest('.form-group').removeClass('has-error'); // set success class to the control group
		},

		submitHandler: function (form) {
			$('#submitbtn').prop('disabled', true);
			$('#submitbtn').text('Submitting.....');			
			success1.show();
			error1.hide();
			form[0].submit(); // submit the form
		}

	});
	//--	 END OF VALIDATION
	
	$('.quan').die().live("keyup",function() {
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
	add_sr_textbox();
	
		function add_sr_textbox(){
		var r=0;
		$("#main_tb tbody tr.tr1").each(function(){
			var row_no=$(this).attr('row_no');
			var val=$(this).find('td:nth-child(4) input[type="checkbox"]:checked').val();
			var serial_number_enable=$(this).find('td:nth-child(2) input[type="hidden"]:nth-child(2)').val();
			
			var item_id=$(this).find('td:nth-child(2) input[type="hidden"]:nth-child(1)').val();
			var quantity=$(this).find('td:nth-child(3) input[type="text"]').val();
			if(val && serial_number_enable){ 
			
			var p=1;
				$('tr.tr2[row_no="'+row_no+'"] td:nth-child(1)').find('input.sr_no').remove();
				for (i = 0; i < quantity; i++) {
					
					$('tr.tr2[row_no="'+row_no+'"] td:nth-child(1)').append('<input type="text" class="sr_no" name="serial_numbers['+item_id+'][]" placeholder="'+p+' serial number" id="sr_no'+r+'" />');
					p++;
					r++;
				}
			}else{
				$('tr.tr2[row_no="'+row_no+'"] td:nth-child(1)').find('input.sr_no').remove();
			}
		});
	}
	
	$('.rename_check').die().live("click",function() { 
		add_sr_textbox();
		rename_rows();
    });
	$('.quantity').die().live("keyup",function() {
		add_sr_textbox();
		rename_rows();
    });
	rename_rows();
	
	
	function rename_rows(){
		$("#main_tb tbody tr.tr1").each(function(){
			var row_no=$(this).attr('row_no');
			var val=$(this).find('td:nth-child(4) input[type="checkbox"]:checked').val();
						
			if(val){
				$(this).find('td:nth-child(2) input[type="hidden"]:nth-child(1)').attr({ name:"grn_rows["+val+"][item_id]"});
				$(this).find('td:nth-child(3) input').attr({ name:"grn_rows["+val+"][quantity]", id:"grn_rows-"+val+"-quantity"}).removeAttr('readonly');
				
				$(this).css('background-color','#fffcda');
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').css('background-color','#fffcda');
			}else{
				$(this).find('td:nth-child(2) input').attr({ name:"q"});
				$(this).find('td:nth-child(3) input').attr({ name:"q", id:"q",readonly:"readonly"});
				
				$(this).css('background-color','#FFF');
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').css('background-color','#FFF');
			}
		});
	}
});		
</script>
<?php } ?>