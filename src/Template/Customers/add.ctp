<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">ADD CUSTOMER</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= $this->Form->create($customer,array("class"=>"form-horizontal",'id'=>'form_sample_3')) ?>
			<div class="form-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Customer Name <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('customer_name', ['label' => false,'class' => 'form-control input-sm ','placeholder'=>'Enter Customer Name']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Alias <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('alias', ['label' => false,'class' => 'form-control input-sm ','placeholder'=>'Enter Customer Alias']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">District <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('district_id', ['empty' => "--Select District --",'options' => $districts,'label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Customer Seg <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('customer_seg_id', ['empty' => "--Select Segment --",'options' => $customerSegs,'label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Tin No</label>
							<?php echo $this->Form->input('tin_no', ['label' => false,'class' => 'form-control input-sm nospace']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Gst No </label>
							<?php echo $this->Form->input('gst_no', ['label' => false,'class' => 'form-control input-sm nospace']); ?>
						</div>
					</div>
				</div>
			
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Pan No </label>
							<?php echo $this->Form->input('pan_no', ['label' => false,'class' => 'form-control input-sm nospace']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Ecc No</label>
							<?php echo $this->Form->input('ecc_no', ['label' => false,'class' => 'form-control input-sm nospace']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Salesman <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('employee_id', ['empty' => "--Select--",'options'=>$employees,'label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Payment Terms<span class="required" aria-required="true">*</span></label>
							<?php $options=[];
							for($q=0; $q<100; $q++){
								$options[$q]=$q;
							}

							echo $this->Form->input('payment_terms', ['options'=>$options,'label' => false,'class' => 'form-control input-sm select2me','empty' => "--Select No. of Days--",]); ?>

						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Customer Group</label>
							<?php echo $this->Form->input('customer_group_id', ['options'=>$CustomerGroups,'empty' => "--Select Company Group--",'label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Mode of Payment<span class="required" aria-required="true">*</span></label>
							<div class="radio-list">
								<div class="radio-inline" data-error-container="#mode_of_payment_error">
								<?php echo $this->Form->radio(
									'mode_of_payment',
									[
										['value' => 'Cheque', 'text' => 'Cheque'],
										['value' => 'NEFT', 'text' => 'NEFT'],
										['value' => 'Cash', 'text' => 'Cash']
									]
								); ?>
								</div>
                                <div id="mode_of_payment_error"></div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Credit Limit</label>
							<?php echo $this->Form->input('credit_limit', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Enter Credit Limit']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Transporter<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('transporter_id', ['options'=>$transporters,'empty' => "--Select--",'label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Bill to Bill Account<span class="required" aria-required="true">*</span></label>
							<div class="radio-list">
								<div class="radio-inline">
								<?php echo $this->Form->radio(
									'bill_to_bill_account',
									[
										['value' => 'Yes', 'text' => 'Yes'],
										['value' => 'No', 'text' => 'No']
										
									]
								); ?>
								</div>
                               
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
					<h4 style="font-size:13px'">Create Ledger</h4>
					</div>
				</div>

				
				<!--<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Account Category<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('account_category_id', ['options'=>$AccountCategories,'empty' => "--Select Account Category--",'label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Account Group <span class="required" aria-required="true">*</span></label>
							<div id="account_group_div">
							<?php echo $this->Form->input('account_group_id', ['options' => [],'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Account Group']); ?>
							</div>
						</div>
					</div>
				</div>-->

				
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Account Category<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('account_category_id', ['options'=>$AccountCategories,'empty' => "--Select Account Category--",'label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Account Group <span class="required" aria-required="true">*</span></label>
							<div id="account_group_div">
							<?php echo $this->Form->input('account_group_id', ['options' => [],'label' => false,'class' => 'form-control input-sm select2me','empty' => "--Select Account Group--"]); ?>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Account First Sub Group <span class="required" aria-required="true">*</span></label>
							<div id="account_first_subgroup_div">
							<?php echo $this->Form->input('account_first_subgroup_id', ['options' => [],'label' => false,'class' => 'form-control input-sm select2me','empty' => "--Select Account First Sub Group--"]); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Account Second Sub Group <span class="required" aria-required="true">*</span></label>
							<div id="account_second_subgroup_div">
							<?php echo $this->Form->input('account_second_subgroup_id', ['options' => [],'label' => false,'class' => 'form-control input-sm select2me','empty' => "--Select Account Second Sub Group--"]); ?>
							</div>
						</div>
					</div>
				</div>
				<h4 style="font-size:13px'">Customer's Contacts</h4>
				<table class="table tableitm" id="main_tb">
					<thead>
						<tr>
							<th>Sr.No.</th>
							<th>Person</th>
							<th>Telephone</th>
							<th>Mobile</th>
							<th>Email</th>
							<th>Designation</th>
							<th>Default</th>
							<th width="10%"></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
				
				<h4 style="font-size:13px'">Customer's Address</h4>
				<table class="table tableitm" id="main_tb2">
					<thead>
						<tr>
							<th>Sr.No.</th>
							<th>Address</th>
							<th>District</th>
							<th>Courier</th>
							<th>Default</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-4">
						<label class="control-label">Work In Companies</label>
						<?php echo $this->Form->input('companies._ids', ['label' => false,'options' => $Companies,'multiple' => 'checkbox']); ?>
					</div>
				</div>
		</div>
		
			<div class="form-actions">
					<button type="submit" class="btn btn-primary">ADD CUSTOMER</button>
			</div>
		</div>
		<?= $this->Form->end() ?>
		<!-- END FORM-->
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<style>
.table thead tr th  {
    color: #FFF;
	background-color: #254b73;
}
</style>


<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
	

    jQuery.validator.addMethod("alphabetsAndSpacesOnly", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value); });
	//--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
			customer_name:{
				required: true,
				
			},
			district_id : {
				  required: true,
			},
			customer_seg_id : {
				  required: true,
			},
			
			employee_id : {
				  required: true,
			},
			payment_terms : {
				  required: true,
			},
			mode_of_payment : {
				  required: true,
			},
			account_category_id:{
				  required: true,
			},
			account_group_id:{
				  required: true,
			},
			account_first_subgroup_id:{
				  required: true,
			},
			account_second_subgroup_id:{
				  required: true,
			},
			bill_to_bill_account:{
				  required: true,

			},
			transporter_id:{
				  required: true,

			}
		},

		messages: { // custom messages for radio buttons and checkboxes
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
	$('.allLetter').live("keyup",function(){
		var inputtxt=  $(this).val();
		var numbers =  /^[0-9]*\.?[0-9]*$/;
		
		if(inputtxt.match(numbers))  
		{  
		} 
		else  
		{  
			$(this).val('');
			return false;  
		}
	});
	
	$('.allAlpha').live("keyup",function(){
		var inputtxt=  $(this).val();
		var numbers =  /^[a-zA-Z\s]+$/;
		
		if(inputtxt.match(numbers))  
		{  
		} 
		else  
		{  
			$(this).val('');
			return false;  
		}
	});	
	
	$('select[name="account_category_id"]').on("change",function() {
	$('#account_group_div').html('Loading...');
	var accountCategoryId=$('select[name="account_category_id"] option:selected').val();
	var url="<?php echo $this->Url->build(['controller'=>'AccountGroups','action'=>'AccountGroupDropdown']); ?>";
	url=url+'/'+accountCategoryId,
	$.ajax({
		url: url,
		type: 'GET',
	}).done(function(response) {
		$('#account_group_div').html(response);
		$('select[name="account_group_id"]').select2();
	});
});
	
	
$('select[name="account_group_id"]').die().live("change",function() {

	$('#account_first_subgroup_div').html('Loading...');
	var accountGroupId=$('select[name="account_group_id"] option:selected').val();
	var url="<?php echo $this->Url->build(['controller'=>'AccountFirstSubgroups','action'=>'AccountFirstSubgroupDropdown']); ?>";
	url=url+'/'+accountGroupId,
	$.ajax({
		url: url,
		type: 'GET',
	}).done(function(response) {
		$('#account_first_subgroup_div').html(response);
		$('select[name="account_first_subgroup_id"]').select2();
	});
});
	
$('select[name="account_first_subgroup_id"]').die().live("change",function() {
	$('#account_second_subgroup_div').html('Loading...');
	var accountFirstSubgroupId=$('select[name="account_first_subgroup_id"] option:selected').val();
	var url="<?php echo $this->Url->build(['controller'=>'AccountSecondSubgroups','action'=>'AccountSecondSubgroupDropdown']); ?>";
	url=url+'/'+accountFirstSubgroupId,
	$.ajax({
		url: url,
		type: 'GET',
	}).done(function(response) {
		$('#account_second_subgroup_div').html(response);
		$('select[name="account_second_subgroup_id"]').select2();
	});
});	
	
	$('.default_btn2').die().live("click",function() { 
		$('.default_btn2').removeAttr('checked');
		$(this).attr('checked','checked');
		$.uniform.update();
    });
	add_row();
    $('.addrow').die().live("click",function() { 
		add_row();
    });
	
	$('.deleterow').die().live("click",function() {
		$('input[name="customer_contacts[0][default_address]"]').val("DEFAULT").css('background-color','#DDD');
		var l=$(this).closest("table tbody").find("tr").length;
		if (confirm("Are you sure to remove row ?") == true) {
			if(l>1){$(this).closest("tr").remove();
				rename_rows();
				calculate_total();
			}
		} 
    });
	
	function add_row(){
		var tr=$("#sample_tb tbody tr").clone();
		$("#main_tb tbody").append(tr);
		rename_rows();
		
	}
	
	$('.default_btn').die().live("click",function() { 
		$('.default_btn').removeAttr('checked');
		$(this).attr('checked','checked');
		$.uniform.update();
    });
	add_row2();
    $('.addrow2').die().live("click",function() { 
		add_row2();
    });
	
	$('.deleterow2').die().live("click",function() {
		$('input[name="customer_address[0][default_address]"]').val("DEFAULT").css('background-color','#DDD');
		var l=$(this).closest("table tbody").find("tr").length;
		if (confirm("Are you sure to remove row ?") == true) {
			if(l>1){
				$(this).closest("tr").remove();
				rename_rows2();
				calculate_total();
			}
		} 
    });
	
	function add_row2(){
		var tr=$("#sample_tb2 tbody tr").clone();
		$("#main_tb2 tbody").append(tr);
		rename_rows2();
	}
	
	function rename_rows(){
		var i=0;
		
		$("#main_tb tbody tr").each(function(){
			
			$(this).find("td:nth-child(1)").html(++i); --i;
			$(this).find("td:nth-child(2) input").attr({name:"customer_contacts["+i+"][contact_person]", id:"customer_contacts-"+i+"-contact_person"}).rules('add', {
						required: true,
						//alphabetsAndSpacesOnly: true,
						
					
			});
			
			$(this).find("td:nth-child(3) input").attr({name:"customer_contacts["+i+"][telephone]", id:"customer_contacts-"+i+"-customer_contacts"}).rules('add', {
						required: true,
						number: true,
						minlength:10,
					});
			$(this).find("td:nth-child(4) input").attr({name:"customer_contacts["+i+"][mobile]", id:"customer_contacts-"+i+"-mobile"}).rules('add', {
						required: true,
						number: true,
						minlength:10,
						maxlength:10
					});
			$(this).find("td:nth-child(5) input").attr({name:"customer_contacts["+i+"][email]", id:"customer_contacts-"+i+"-email"}).rules("add", "required");
			$(this).find("td:nth-child(6) input").attr({name:"customer_contacts["+i+"][designation]", id:"customer_contacts-"+i+"-designation"}).rules('add', {
						required: true,
						//alphabetsAndSpacesOnly: true,
						messages: {
							alphabetsAndSpacesOnly: "Enter Letters Only.",
						}
			});
			
			$(this).find("td:nth-child(7) input").attr({name:"customer_contacts["+i+"][default_contact]", id:"customer_contacts-"+i+"-default_contact"});
			var test = $("input[type=radio]:not(.toggle),input[type=checkbox]:not(.toggle)");
			if (test) { test.uniform(); }
			i++;
		});
	}
	
	function rename_rows2(){
		var i=1;
		
		$("#main_tb2 tbody tr").each(function(){
			
			$(this).find("td:nth-child(1)").html(i);
			$(this).find("td:nth-child(2) textarea").attr({name:"customer_address["+i+"][address]", id:"customer_address-"+i+"-address"}).rules("add", "required");
			$(this).find("td:nth-child(3) select").select2().attr({name:"customer_address["+i+"][district_id]", id:"customer_address-"+i+"-district_id"}).rules("add", "required");
			$(this).find("td:nth-child(4) select").select2().attr({name:"customer_address["+i+"][transporter_id]", id:"customer_address-"+i+"-transporter_id"}).rules("add", "required");
			$(this).find("td:nth-child(5) input").attr({name:"customer_address["+i+"][default_address]", id:"customer_address-"+i+"-default_address"});
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
			<td><?php echo $this->Form->input('contact_person', ['type' => 'text','label' => false,'class' => 'form-control input-sm ','placeholder' => 'Contact Person']); ?></td>
			<td><?php echo $this->Form->input('telephone', ['type' => 'text','label' => false,'class' => 'form-control input-sm allLetter','placeholder' => 'Telephone','maxlength'=>15]); ?></td>
			<td><?php echo $this->Form->input('mobile', ['type' => 'text','label' => false,'class' => 'form-control input-sm allLetter','placeholder' => 'Mobile','maxlength'=>10,'minlength'=>10]); ?></td>
			<td><?php echo $this->Form->input('email', ['type' => 'email','label' => false,'class' => 'form-control input-sm','placeholder' => 'Email']); ?></td>
			<td><?php echo $this->Form->input('designation', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Designation']); ?></td>
			<td width="90"><?php echo $this->Form->input('default_contact', ['type'=>'checkbox','label' => false,'class' => 'form-control input-sm default_btn2','checked'=>'Checked']); ?></td>
			<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
	</tbody>
</table>

<table id="sample_tb2" style="display:none;">
	<tbody>
		<tr>
			<td>0</td>
			<td><?php echo $this->Form->input('address', ['label' => false,'type' => 'textarea','rows' => '2','style' => ['resize:none'],'class' => 'form-control input-sm','placeholder' => 'Address']); ?></td>
			<td><?php echo $this->Form->input('district_id', ['options' => $districts,'empty' => "--Select--",'label' => false,'class' => 'form-control input-sm']); ?></td>
			<td><?php echo $this->Form->input('transporter_id', ['options'=>$transporters,'empty' => "--Select--",'label' => false,'class' => 'form-control input-sm','placeholder' => 'Courier Charge']); ?></td>
			<td width="90"><?php echo $this->Form->input('default_address', ['type'=>'checkbox','label' => false,'class' => 'form-control input-sm default_btn','checked'=>'Checked']); ?></td>
			<td><a class="btn btn-xs btn-default addrow2" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow2" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
	</tbody>
</table>