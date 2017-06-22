
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel">Edit Item opening balance</span>
		</div>
		
		<div class="actions">
			<?= $this->Html->link(
				'Add',
				'/Items/Opening-Balance',
				['class' => 'btn btn-default']
			); ?>
			<?= $this->Html->link(
				'View',
				'/Items/Opening-Balance-View',
				['class' => 'btn btn-default']
			); ?>
		</div>
	</div>
	<div class="portlet-body form">
	<?= $this->Form->create($ItemLedger,['id'=>'form_sample_3']) ?>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Item <span class="required" aria-required="true">*</span></label>
					<br/>
					<label><?php echo $Items->name; ?></label>
					<?php echo $this->Form->input('item_id', ['type' => 'hidden','value' =>$Items->id]); ?>
					
				</div>
			</div>
			<div class="col-md-5"></div>
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Date <span class="required" aria-required="true">*</span></label>
					<?php echo $this->Form->input('date', ['type' => 'text','label' => false,'class' => 'form-control input-sm ','data-date-format' => 'dd-mm-yyyy','value' =>date("d-m-Y",strtotime($financial_year->date_from)),'readonly']); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label class="control-label">Old Quantity <span class="required" aria-required="true">*</span></label>
					<?php 
					echo $this->Form->input('quantity', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Quantity']); ?>
				</div>
			</div>
			<div class="col-md-2" id="hide_quantity">
				<div class="form-group">
					<label class="control-label">New Quantity <span class="required" aria-required="true">*</span></label>
					<?php echo $this->Form->input('new_quantity', ['type'=>'text','label' => false,'class' => 'form-control input-sm','value' => 0,'placeholder'=>'New Quantity']); ?>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label class="control-label">Rate <span class="required" aria-required="true">*</span></label>
					<?php echo $this->Form->input('rate', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Rate']); ?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Value <span class="required" aria-required="true">*</span></label>
					<?php 
					echo $this->Form->input('value', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Value']); ?>
				</div>
			</div>
			<div class="col-md-1"  >
			
				<?php 
					echo $this->Form->input('serial_number_enable', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm','placeholder'=>'Value','value'=>$SerialNumberEnable[0]->serial_number_enable]); ?>
			</div>
		</div>
		
		<div class="row" >
			<div class="col-md-3" id="itm_srl_num"></div>
			<div class="col-md-4"></div>
			<div class="col-md-5" id="show_data" >
			 <table   class="table table-hover" >
				 <thead>
					<tr>
						<th width="20%">Sr. No.</th>
						<th>Serial Number</th>
						<th width="10%">Action</th>
						
					</tr>
				</thead>
				<tbody>
				<?php $i=0; foreach ($ItemSerialNumbers as $ItemSerialNumber){ $i++;?>
				<tr>
						<td><?= h($i) ?></td>
						<td><?= h($ItemSerialNumber->serial_no); ?></td>
						<td>
						 	
							<?= $this->Html->link('<i class="fa fa-trash"></i> ',
									['action' => 'DeleteSerialNumbers', $ItemSerialNumber->id, $ItemSerialNumber->item_id,$ItemLedger->id], 
									[
										'escape' => false,
										'class' => 'btn btn-xs red',
										'confirm' => __('Are you sure, you want to delete {0}?', $ItemSerialNumber->id)
									]
								) ?>
							
						</td>
					</tr>
				<?php  } ?>
				</tbody>
			</table>
			</div>
		</div>
		
		
		
		<button type="submit" class="btn blue-hoki">Submit</button>

		<?php 
		
		if(empty($ItemSerialNumbers[0]->serial_no)){?>
		
		<?= $this->Html->link('Delete',
							['action' => 'DeleteItemOpeningBalance', $ItemLedger->id], 
							[
								'escape' => false,
								'class'=>'btn btn-danger'
							]
						); 

		}?>
	<?= $this->Form->end() ?>
	</div>
</div>
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
			item_id :{
				required: true,
			},
			quantity  : {
				  required: true,
			},
			rate    : {
				  required: true,
				  min:0.01
			}
		},

		messages: { // custom messages for radio buttons and checkboxes
			membership: {
				required: "Please select a Membership type"
			},
			service: {
				required: "Please select  at least 2 types of Service",
				minlength: jQuery.validator.format("Please select  at least {0} types of Service")
			}
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
			//Metronic.scrollTo(error3, -200);
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
			success3.show();
			error3.hide();
			form[0].submit(); // submit the form
		}

	});
	//--	 END OF VALIDATION
	function calculate_value()
	{
		var quantity=parseFloat($('input[name="quantity"]').val());
		//alert(quantity);
		var newquantity=parseFloat($('input[name="new_quantity"]').val());
		
		var totalquantity = quantity+newquantity;
		if(isNaN(totalquantity)) { var totalquantity = 0; }
		var rate=parseFloat($('input[name="rate"]').val());
		if(isNaN(rate)) { var rate = 0; }
		var total=totalquantity*rate;
		$('input[name="value"]').val(total.toFixed(2));
	}	
	
	calculate_value();
	
	
	var serial_number_enable='<?php echo $SerialNumberEnable[0]->serial_number_enable;?>';
	if(serial_number_enable==1){
		$('input[name="new_quantity"],input[name="rate"]').die().live("blur",function() { 
		calculate_value();
    });
	}else{
		$('input[name="quantity"],input[name="rate"]').die().live("blur",function() { 
		calculate_value();
    });
	}
		
   
	
	$('input[name="value"]').die().live("blur",function() { 
		var quantity=parseFloat($('input[name="quantity"]').val());
		var newquantity=parseFloat($('input[name="new_quantity"]').val());
		var totalquantity = quantity+newquantity;
		if(isNaN(totalquantity)) { var totalquantity = 0; }
		var value=parseFloat($('input[name="value"]').val());
		if(isNaN(value)) { var value = 0; }
		
		var total=value/totalquantity;
	
		$('input[name="rate"]').val(total.toFixed(6));
    });

   $('input[name="quantity"]').die().live("keyup",function() {
	  $('#itm_srl_num').find('input.sr_no').remove();
		add_sr_textbox();
	
    });
	$('input[name="new_quantity"]').die().live("keyup",function() {
	  $('#itm_srl_num').find('input.sr_no').remove();
		add_sr_textbox();
	
    });
	
	
	show_table();
	
	var serial_numbers='<?php echo $SerialNumberEnable[0]->serial_number_enable; ?>';
	if(serial_numbers == '1'){
			$('input[name="quantity"]').attr('readonly','readonly');
			$('#hide_quantity').show();
		}else{
			$('input[name="quantity"]').removeAttr('readonly');
			$('#hide_quantity').hide();
			$('input[name="new_quantity"]').val(0);
			
		}
		
		$('input[name=serial_number_enable]').on("click",function() {
			var serial_numbers='<?php echo $SerialNumberEnable[0]->serial_number_enable; ?>'; 
				if(serial_numbers == '1'){
						$('input[name="quantity"]').attr('readonly','readonly');
						$('#hide_quantity').show();
				}else{
						$('input[name="quantity"]').removeAttr('readonly');
						$('#hide_quantity').hide();
						$('input[name="new_quantity"]').val(0);
				}
		});
	
	function show_table(){
		var serial_numbers='<?php echo $SerialNumberEnable[0]->serial_number_enable; ?>';
		if(serial_numbers == '1'){
			$('#show_data').css("display", "block");
		}else{
			$('#show_data').css("display", "none");
		}
	}
	
	$('select[name="Item_id"]').on("change",function() {
	
	$('#itm_srl_num').hide();

		var Item_id=$('select[name="Item_id"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'Items','action'=>'check_serial']); ?>";
		url=url+'/'+Item_id,
		$.ajax({
			url: url,
		}).done(function(response) { 
			$('#itm_srl_num_enable').html(response);
			$('input[name="quantity"]').val(0);
			
		});
	});
	
	$('input[name="quantity"]').on("keyup",function() {
		add_sr_textbox(); 
	});	
   function add_sr_textbox(){
	   $('#itm_srl_num').show();
	  // var serial_number=$('input[name=serial_number_enable]').val();
	var itemserial_number_status = '<?php echo $SerialNumberEnable[0]->serial_number_enable;?>';	  
	   //alert(serial_number);
	   var quantity=$('input[name="quantity"]').val();
	  
		if(itemserial_number_status=='1'){ 
		var tq=parseInt($('input[name="new_quantity"]').val());
		
			var p=1;  //alert(quantity);	
			var r=0;
			$('#itm_srl_num').find('input.sr_no').remove();
			$('#itm_srl_num').find('span.help-block-error').remove();
			for (i = 0; i < tq; i++) {
			$('#itm_srl_num').append('<input type="text" class="sr_no" name="serial_numbers['+r+'][]" placeholder="'+p+' serial number" id="sr_no'+r+'" />');
			
			$('#itm_srl_num').find('input#sr_no'+r).rules('add', {required: true});
			p++;
			r++;
			}
		}
		else{ 
			$('#itm_srl_num').html('');
			
		}
	   
   }
	
	
	
   old_quantity();
   function old_quantity(){
	   var total_out=$('input[name="new_quantity"]').val();
			if(total_out < 1){
				$('#itm_srl_num').find('input.sr_no').remove();
				}
			if(total_out > 1){
				add_sr_textbox();
			}
   }
	
	
});
</script>