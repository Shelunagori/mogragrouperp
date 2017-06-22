<?php
$this->Form->templates([
    'inputContainer' => '{{content}}'
]);
?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Edit Company</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= $this->Form->create($company,['type' => 'file','id'=>'form_sample_3']) ?>
			<div class="form-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Company Group <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('company_group_id', ['options' => $companyGroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'company_group_id']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Name <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('name', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Enter Company Name']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Alias <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('alias', ['label' => false,'class' => 'form-control input-sm ','placeholder'=>'Enter Company Alias']); ?>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">Pan No</label>
							<?php echo $this->Form->input('pan_no', ['label' => false,'class' => 'form-control input-sm nospace']); ?>
						</div>
					</div>
					<div class="col-md-2">
						<div class="orm-group">
							<label class="control-label">Tin No</label>
							<?php echo $this->Form->input('tin_no', ['label' => false,'class' => 'form-control input-sm nospace']); ?>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">Tan No</label>
							<?php echo $this->Form->input('tan_no', ['label' => false,'class' => 'form-control input-sm nospace']); ?>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">Service Tax No</label>
							<?php echo $this->Form->input('service_tax_no', ['label' => false,'class' => 'form-control input-sm']); ?>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">CIN No</label>
							<?php echo $this->Form->input('cin_no', ['label' => false,'class' => 'form-control input-sm nospace']); ?>
						</div>
					</div>
				</div>
			
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Mobile No <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('mobile_no', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Enter Mobile No','maxlength'=>'10','minlength'=>'10']); ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Landline No<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('landline_no', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Enter Landline No']); ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Email ID <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('email', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Enter Email ID']); ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Website</label>
							<?php echo $this->Form->input('website', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Enter Website URL']); ?>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Inventory <span class="required" aria-required="true">*</span></label>
							<div class="radio-list" data-error-container="#inventory_status_error">
							<?php echo $this->Form->radio(
								'inventory_status',
								[
									['value' => 'With Inventory', 'text' => 'With'],
									['value' => 'Without Inventory', 'text' => 'Without'],
								]
							); ?>
							</div>
                            <div id="inventory_status_error"></div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Company Logo <span class="required" aria-required="true">*</span></label>
							<div><?php echo $this->Html->image('/logos/'.$company->logo, ['height' => '50px']); ?></div>
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<span class="btn default btn-file">
								<span class="fileinput-new">
								Change </span>
								<span class="fileinput-exists">
								Change </span>
								<?php echo $this->Form->input('logo', ['type' => 'file','label' => false,'required' => false]);?>
								</span>
								<span class="fileinput-filename">
								</span>
								&nbsp; <a href="#" class="close fileinput-exists" data-dismiss="fileinput">
								</a>
							</div>
							<span class="help-block">Only PNG format is allowed | Upload transparent logo of size 420 x 165 </span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Address <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('address', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Address']); ?>
						</div>
					</div>
				</div>
				<div class="portlet-title">
					<div class="caption" >
						<i class="icon-globe font-blue-steel"></i>
						<span class="caption-subject font-blue-steel uppercase">Bank Details</span>
					</div>
				</div><br/>
				<table class="table tableitm" id="main_tb">
					<thead>
						<tr>
							<th>Sr.No.</th>
							<th>BANK NAME</th>
							<th>BRANCH</th>
							<th>ACCOUNT NO</th>
							<th>IFSC CODE</th>
							<th>DEFAULT</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php $i=0; foreach($company->company_banks as $company_bank){ $i++; 
					if($company_bank->default_bank=='1'){ $checked="checked"; }else{ $checked=""; } ?>
					<tr>
						<td><?= h($i) ?></td>
						<td><?php echo $this->Form->input('company_banks.'.$i.'.bank_name', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Bank Name','value'=>$company_bank->bank_name]); ?></td>
						<td><?php echo $this->Form->input('company_banks.'.$i.'.branch', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Branch','value'=>$company_bank->branch]); ?></td>
						<td><?php echo $this->Form->input('company_banks.'.$i.'.account_no', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Account No','value'=>$company_bank->account_no,'maxlength'=>20]); ?></td>
						<td><?php echo $this->Form->input('company_banks.'.$i.'.ifsc_code', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'IFSC Code','value'=>$company_bank->ifsc_code]); ?></td>
						<td width="90"><?php echo $this->Form->input('company_banks.'.$i.'.default_bank', ['type'=>'checkbox','label' => false,'class' => 'form-control default_btn','checked'=>$checked]); ?></td>
						<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
                
			</div>
		
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">UPDATE COMPANY</button>
			</div>
		</div>
		<?= $this->Form->end() ?>
		<!-- END FORM-->
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
	
	jQuery.validator.addMethod("alphabetsAndSpacesOnly", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\s&.]+$/.test(value); });
	//--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
	rules: {
			company_group_id:{
				required: true,
			},
			name  : {
				  required: true,
				    //alphabetsAndSpacesOnly: true,
			},
			alias  : {
				  required: true,
			},
			landline_no   : {
				  required: true,
				  digits: true,
			},
			email   :{
				required: true,
				email:true,
			},
			inventory_status :{
				required: true,
			},
			
			address : {
				  required: true,
			},
			mobile_no:{
				required: true,
				digits: true,
				minlength: 10,
				maxlength: 10,
			},
			inventory_status:{
				 required: true,
			}
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			name  : {
				alphabetsAndSpacesOnly: "Enter Letters only",
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
	
	
    $('.addrow').die().live("click",function() {
		add_row();
    });
	
	
	$('.default_btn').die().live("click",function() { 
		$('.default_btn').removeAttr('checked');
		$(this).attr('checked','checked');
		$.uniform.update();
    });
	
	$('.deleterow').die().live("click",function() {
		$('input[name="customer_contacts[0][default_address]"]').val("DEFAULT").css('background-color','#DDD');
		var l=$(this).closest("table tbody").find("tr").length;
		if (confirm("Are you sure to remove row ?") == true) {
			if(l>1){
				$(this).closest("tr").remove();
				rename_rows();
				calculate_total();
			}
		} 
    });
	
	
	function add_row(){
		var tr=$("#sample_tb tbody tr").clone();
		$("#main_tb tbody").append(tr);
		rename_rows();
		calculate_total();
	}
	
	function rename_rows(){
		var i=1;
		$("#main_tb tbody tr").each(function(){
			$(this).find("td:nth-child(1)").html(i);
			$(this).find("td:nth-child(2) input").attr({name:"company_banks["+i+"][bank_name]", id:"company_banks-"+i+"-bank_name"}).rules('add', {
						required: true,
					
			});
			$(this).find("td:nth-child(3) input").attr({name:"company_banks["+i+"][branch]", id:"company_banks-"+i+"-branch"}).rules('add', {
						required: true,
						
			});
			$(this).find("td:nth-child(4) input").attr({name:"company_banks["+i+"][account_no]", id:"company_banks-"+i+"-account_no"}).rules('add', {
						required: true,
						number: true,
						min: 0,
						maxlength: 20,
					});
			$(this).find("td:nth-child(5) input").attr({name:"company_banks["+i+"][ifsc_code]", id:"company_banks-"+i+"-ifsc_code"}).rules("add", "required");
			$(this).find("td:nth-child(6) input[type=checkbox]").attr("name","company_banks["+i+"][default_bank]");
			var test = $("input[type=radio]:not(.toggle),input[type=checkbox]:not(.toggle)");
			if (test) { test.uniform(); }
			i++;
		});
	}
	
	
	
});
</script>

<table id="sample_tb" style="display:none;">
	<tbody>
		<tr>
			<td>0</td>
			<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Bank Name']); ?></td>
			<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Branch']); ?></td>
			<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Account No','maxlength'=>20]); ?></td>
			<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'IFSC Code']); ?></td>
			<td width="90"><?php echo $this->Form->input('q', ['type'=>'checkbox','label' => false,'class' => 'form-control default_btn','value'=>1]); ?></td>
			<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
	</tbody>
</table>
