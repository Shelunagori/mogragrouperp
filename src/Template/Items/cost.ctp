<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel">Update Selling Price Factor</span>
		</div>
		<div class="actions">
			<?= $this->Html->link(
				'Add',
				'/Items/cost',
				['class' => 'btn btn-default']
			); ?>
			<?= $this->Html->link(
				'View',
				'/Items/cost-View',
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
					<?php echo $this->Form->input('Item_id', ['empty'=>'--select--','label' => false,'class' => 'form-control input-sm select2me','options'=>$Items]); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Dynamic Cost <span class="required" aria-required="true">*</span></label>
					<?php echo $this->Form->input('dynamic_cost', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Dynamic Cost']); ?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Minimum Selling Price Factor <span class="required" aria-required="true">*</span></label>
					<?php echo $this->Form->input('minimum_selling_price_factor', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'minimum_selling_price_factor']); ?>
				</div>
			</div>
		</div>
		<button type="submit" class="btn blue-hoki">Submit</button>
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
			dynamic_cost  : {
				  required: true,
			},
			minimum_selling_price_factor  : {
				  required: true,
			},
			rate    : {
				  required: true,
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
	
	


	$('input[name="serial_number_enable"]').die().live("change",function() {
		add_sr_textbox();
	});
		
   function add_sr_textbox(){
	   var serial_number=$('input[name=serial_number_enable]:checked').val(); 
	   var quantity=$('input[name="quantity"]').val();
	   
		if(serial_number=='1'){ 
			var p=1;
			var r=0;
			$('#itm_srl_num').find('input.sr_no').remove();
			for (i = 0; i < quantity; i++) {
			$('#itm_srl_num').append('<input type="text" class="sr_no" name="serial_numbers['+r+'][]" placeholder="'+p+' serial number" id="sr_no'+r+'" />');
			//$('#itm_srl_num').rules('add', {required: true});
			$('#itm_srl_num').find('input#sr_no'+r).rules('add', {required: true});
			p++;
			r++;
			}
		}
		else if(serial_number=='0'){ 
			$('#itm_srl_num').find('input.sr_no').remove();
			
		}
	   
   }
   $('input[name="quantity"]').die().live("keyup",function() {
	  $('#itm_srl_num').find('input.sr_no').remove();
		add_sr_textbox();
    });
   
});
</script>