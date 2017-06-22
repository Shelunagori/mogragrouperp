<?php //pr($company_dis);exit; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">EDIT EMPLOYEE</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= $this->Form->create($employee,['type' => 'file','class'=>'form-horizontal','id'=>'form_sample_3']) ?>
			<div class="form-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Name <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('name', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Name']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Date of Birth<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('dob',['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','value' => date("d-m-Y",strtotime($employee->dob)),'placeholder' => 'Date of Birth']); ?>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Gender <span class="required" aria-required="true">*</span></label>
							<div class="radio-list">
								<div class="radio-inline" data-error-container="#sex_required_error">
									<?php echo $this->Form->radio(
											'sex',
											[
												['value' => 'Male', 'text' => 'Male'],
												['value' => 'Female', 'text' => 'Female']
											]
									); ?>
								</div>
								<div id="sex_required_error"></div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Mobile <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('mobile', ['label' => false,'class' => 'form-control input-sm nospace allLetter','placeholder'=>'Mobile','maxlength'=>10]); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Landline</label>
							<?php echo $this->Form->input('phone_no', ['label' => false,'class' => 'form-control input-sm nospace allLetter','placeholder'=>'Landline','maxlength'=>15]); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Email <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('email', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Email']); ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Blood Group </label>
							<?php 
							$arrblood=array(""=>"Select Blood Group", 'A+'=>"A+",'A-'=>"A-",'B+'=>"B+",'B-'=>"B-",'AB+'=>"AB+",'AB-'=>"AB-",'O+'=>"O+",'O-'=>"O-");
							echo $this->Form->input('blood_group', ['options'=>$arrblood,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Blood Group']);?>
						</div>
					</div>
				
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Education Qualification</label>
							<?php echo $this->Form->input('qualification', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Education Qualification']); ?>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label"> Last Company worked Name</label>
							<?php echo $this->Form->input('last_company', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Last Company Name']); ?>
						</div>
					</div>
				</div>
					
					
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Department <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('dipartment_id', ['options' => $departments,'label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Designation <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('designation_id', ['options'=>$designations,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Designation']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Date Of Joining</label>
							<?php echo $this->Form->input('join_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','value' => date("d-m-Y",strtotime($employee->join_date)),'placeholder' => 'Date of Joining']); ?>
					</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Date Of Probation Period</label>
							<?php echo $this->Form->input('probation_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','placeholder' => 'Date of Probation Period']); ?>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Date Of Resignation</label>
							<?php echo $this->Form->input('resignation_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','placeholder' => 'Date of Resignation']); ?>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Date Of Releave</label>
							<?php echo $this->Form->input('releave_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','placeholder' => 'Date of Releave']); ?>
						</div>
					</div>
					
				</div>
				<div class="row">
				<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Date of Confirmation as Permanent</label>
							<?php echo $this->Form->input('permanent_join_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','value' => date("d-m-Y",strtotime($employee->permanent_join_date)),'placeholder' => 'Date of Confirmation']); ?>
					</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Marital Status<span class="required" aria-required="true">*</span></label>
								<div class="radio-list">
								<div class="radio-inline" data-error-container="#marital_status_required_error">
									<?php echo $this->Form->radio(
											'marital_status',
											[
												['value' => 'Single', 'text' => 'Single', 'id'=>'id_radio1'],
												['value' => 'Married', 'text' => 'Married', 'id'=>'id_radio2']
											]
									); ?>
								</div>
								<div id="marital_status_error"></div>
							</div>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Over Time Applicable<span class="required" aria-required="true">*</span></label>
								<div class="radio-list">
								<div class="radio-inline" >
									<?php echo $this->Form->radio(
											'over_time',
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
				<div class="row"  id="married_info" style="display:none;">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Spouse Name</label>
							<?php echo $this->Form->input('spouse_name', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Spouse Name']); ?>
						</div>
					</div>
				
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Date Of Anniversary</label>
							<?php echo $this->Form->input('date_of_anniversary', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','placeholder' => 'Date of Anniversary','value'=>date("d-m-Y",strtotime($employee->date_of_anniversary))]); ?>
					</div>
					</div>
						<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Number Of Child</label>
							<?php echo $this->Form->input('children', ['label' => false,'class' => 'form-control input-sm','placeholder' => 'Number Of Child']); ?>
					</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label"> Whether Spouse Working?</label>
								<div class="radio-list">
								<div class="radio-inline">
									<?php echo $this->Form->radio(
											'spouse_working',
											[
												['value' => 'Yes', 'text' => 'Yes'],
												['value' => 'No', 'text' => 'No']
											]
									); ?>
								</div>
								<div id="spouse_working_error"></div>
							</div>
						</div>
					</div>
				</div>
					
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Permanent Address </label>
							<?php echo $this->Form->input('permanent_address', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Permanent Address']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Residence Address </label>
							<?php echo $this->Form->input('residence_address', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Residence Address']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Signature <span class="required" aria-required="true">*</span></label>
							<div><?php echo $this->Html->image('/signatures/'.$employee->signature, ['height' => '50px']); ?></div>
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<span class="btn default btn-file">
								<span class="fileinput-new">
								Change </span>
								<span class="fileinput-exists">
								Change </span>
								<?php echo $this->Form->input('signature', ['type' => 'file','label' => false,'required' => false]);?>
								</span>
								<span class="fileinput-filename">
								</span>
								&nbsp; <a href="#" class="close fileinput-exists" data-dismiss="fileinput">
								</a>
							</div>
							<span class="help-block">Only PNG format is allowed | Upload transparent Signature of size 420 x 165 </span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
					<h4 style="font-size:13px'">Create Ledger</h4>
					</div>
				</div>
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
							<?php echo $this->Form->input('account_group_id', ['options' => $AccountGroups,'label' => false,'empty' => "--Select Account Group--",'class' => 'form-control input-sm select2me','placeholder'=>'Account Group']); ?>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Account First Sub Group <span class="required" aria-required="true">*</span></label>
							<div id="account_first_subgroup_div">
							<?php echo $this->Form->input('account_first_subgroup_id', ['options' => $AccountFirstSubgroups,'label' => false,'empty' => "--Select First Sub Group--",'class' => 'form-control input-sm select2me','placeholder'=>'Account First Sub Group']); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Account Second Sub Group <span class="required" aria-required="true">*</span></label>
							<div id="account_second_subgroup_div">
							<?php echo $this->Form->input('account_second_subgroup_id', ['empty' => "--Select Second Sub Group--",'options' => $AccountSecondSubgroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Account Second Sub Group']); ?>
							</div>
						</div>
					</div>
				</div>
				
				<h4 style="font-size:13px'">Employee Emergency Contact Persons</h4>
				<table class="table table-condensed tableitm">
					<thead>
						<tr>
							<th><label class="control-label">Name<label></th>
							<th><label class="control-label">Mobile<label></th>
							<th><label class="control-label">Landline<label></th>
							<th><label class="control-label">Email<label></th>
							<th><label class="control-label">Relation<label></th>
							
						</tr>
					</thead>
					<tbody>
					
					<tr>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.0.name', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Name']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.0.mobile', ['type' => 'text','label' => false,'class' => 'form-control input-sm allLetter','placeholder' => 'Mobile','maxlength'=>10]); ?>
							
						</td>
						<td>
						<?php echo $this->Form->input('employee_contact_persons.0.landline', ['type' => 'text','label' => false,'class' => 'form-control input-sm allLetter','placeholder' => 'LandLine','maxlength'=>15]); ?>
						
						</td>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.0.email', ['label' => false,'class' => 'form-control input-sm nospace','placeholder'=>'Email']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.0.relation', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Relation']); ?>
						</td>
					</tr>
					
					<tr>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.1.name', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Name']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.1.mobile', ['type' => 'text','label' => false,'class' => 'form-control input-sm allLetter','placeholder' => 'Mobile','maxlength'=>10,'minlength'=>10]); ?>
							
						</td>
						<td>
						<?php echo $this->Form->input('employee_contact_persons.1.landline', ['type' => 'text','label' => false,'class' => 'form-control input-sm allLetter','maxlength'=>15,'placeholder' => 'Landline']); ?>
						
						</td>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.1.email', ['label' => false,'class' => 'form-control input-sm nospace','placeholder'=>'Email']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.1.relation', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Relation']); ?>
						</td>
					</tr>
					</tbody>
				</table>
				
				<h4 style="font-size:13px'">Bank's Detail</h4>
				<table class="table table-condensed tableitm">
					<thead>
						<tr>
							<th><label class="control-label">Bank Name<label></th>
							<th><label class="control-label">Account Number<label></th>
							<th><label class="control-label">Branch Name<label></th>
							<th><label class="control-label">IFSC Code<label></th>
							
						</tr>
					</thead>
					<tbody>
						<td>
							<?php echo $this->Form->input('bank_name', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Bank Name']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('account_no', ['label' => false,'class' => 'form-control input-sm nospace','placeholder'=>'Account No']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('branch_name', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Branch Name']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('ifsc_code', ['label' => false,'class' => 'form-control input-sm nospace','placeholder'=>'IFSC Code']); ?>
						</td>
					</tbody>
				</table>
				
				<?php //pr($Companies) ?>
				<div class="row" id="used_comp">
					<div class="col-md-4">
		<label class="control-label">Used By Companies <span class="required" aria-required="true">*</span></label>
			<?php echo $this->Form->input('companies._ids', ['label' => false,'options' => $Companies,'multiple' => 'checkbox']); ?>
</div>
				</div>
				
				</div>
		</div>
		
			<div class="form-actions">
					<button type="submit" class="btn btn-primary">EDIT EMPLOYEE</button>
			</div>
		</div>
		<?= $this->Form->end() ?>
		<!-- END FORM-->
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
			name:{
				required: true,
			},
			dipartment_id : {
				  required: true,
			},
			sex : {
				  required: true,
			},
			mobile : {
				  required: true,
				  digits: true,
				  minlength: 10,
				  maxlength: 10,
			},
			email:{
				required: true,
			},
			designation_id:{
				required: true,
			},
			permanent_address:{
				required: true,
			},
			residence_address:{
				required: true,
			},
			marital_status:{
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
			bank_name:{
				 required: true,
			},
			account_no:{
				 required: true,
			},
			branch_name:{
				 required: true,
			},
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
	$('.allLetter').keyup(function(){
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
	
	/* var emp_id="<?php echo $employee->id; ?>";
	
	var url="<?php echo $this->Url->build(['controller'=>'Employees','action'=>'UsedCompany']); ?>";
	url=url+'/'+emp_id,
	$.ajax({
		url: url,
		type: 'GET',
	}).done(function(response) {
		alert(response);
		$('#used_comp').html(response);
		//$('select[name="account_group_id"]').select2();
	}); */
	
	<?php foreach($company_dis as $company_dis){ ?>
		
		company_dis=<?php echo $company_dis; ?>;
		$('#companies-ids-'+company_dis).prop('disabled',true);
	
<?php }?>
	
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
	
	
	add_row(); $('.default_btn2:first').attr('checked','checked'); $.uniform.update();
	$('.default_btn2').die().live("click",function() { 
		$('.default_btn2').removeAttr('checked');
		$(this).attr('checked','checked');
		$.uniform.update();
    });
	
    $('.addrow').die().live("click",function() { 
		add_row();
    });
	
	$('.deleterow').die().live("click",function() {
		$('input[name="customer_contacts[0][default_address]"]').val("DEFAULT").css('background-color','#DDD');
		var l=$(this).closest("table tbody").find("tr").length;
		if (confirm("Are you sure to remove row ?") == true) {
			if(l>1){
				$(this).closest("tr").remove();
				var i=0;
				$("#main_tb tbody tr").each(function(){
					$(this).find("td:nth-child(1)").html(++i); --i;
					$(this).find("td:nth-child(2) input").attr("name","customer_contacts["+i+"][contact_person]").attr("id","customer_contacts."+i+".contact_person");
					$(this).find("td:nth-child(3) input").attr("name","customer_contacts["+i+"][telephone]").attr("id","customer_contacts."+i+".telephone");
					$(this).find("td:nth-child(4) input").attr("name","customer_contacts["+i+"][mobile]").attr("id","customer_contacts."+i+".mobile");
					$(this).find("td:nth-child(5) input").attr("name","customer_contacts["+i+"][designation]").attr("id","customer_contacts."+i+".designation");
					$(this).find("td:nth-child(6) input").attr("name","customer_contacts["+i+"][default_contact]");
					i++;
					
				});
				calculate_total();
			}
		} 
    });
	
	function add_row(){
		
		var tr=$("#sample_tb tbody tr").clone();
		$("#main_tb tbody").append(tr);
		var i=0;
		$("#main_tb tbody tr").each(function(){
			
			$(this).find("td:nth-child(1)").html(++i); --i;
			$(this).find("td:nth-child(2) input").attr("name","customer_contacts["+i+"][contact_person]").attr("id","customer_contacts."+i+".contact_person").rules("add", "required");
			$(this).find("td:nth-child(3) input").attr("name","customer_contacts["+i+"][telephone]").attr("id","customer_contacts."+i+".telephone").rules("add", "required");
			$(this).find("td:nth-child(4) input").attr("name","customer_contacts["+i+"][mobile]").attr("id","customer_contacts."+i+".mobile").rules("add", "required");
			$(this).find("td:nth-child(5) input").attr("name","customer_contacts["+i+"][email]").attr("id","customer_contacts."+i+".email").rules("add", "required");
			$(this).find("td:nth-child(6) input").attr("name","customer_contacts["+i+"][designation]").attr("id","customer_contacts."+i+".designation").rules("add", "required");
			$(this).find("td:nth-child(7) input").attr("name","customer_contacts["+i+"][default_contact]");
			var test = $("input[type=radio]:not(.toggle),input[type=checkbox]:not(.toggle)");
			if (test) { test.uniform(); }
			i++;
		});
	}
	
	add_row2(); $('.default_btn:first').attr('checked','checked'); $.uniform.update();
	$('.default_btn').die().live("click",function() { 
		$('.default_btn').removeAttr('checked');
		$(this).attr('checked','checked');
		$.uniform.update();
    });
	
    $('.addrow2').die().live("click",function() { 
		add_row2();
    });
	
	$('.deleterow2').die().live("click",function() {
		$('input[name="customer_address[0][default_address]"]').val("DEFAULT").css('background-color','#DDD');
		var l=$(this).closest("table tbody").find("tr").length;
		if (confirm("Are you sure to remove row ?") == true) {
			if(l>1){
				$(this).closest("tr").remove();
				var i=0;
				$("#main_tb2 tbody tr").each(function(){
					
					$(this).find("td:nth-child(1)").html(++i); --i;
					$(this).find("td:nth-child(2) textarea").attr("name","customer_address["+i+"][address]");
					$(this).find("td:nth-child(3) select").attr("name","customer_address["+i+"][district_id]");
					$(this).find("td:nth-child(4) input").attr("name","customer_address["+i+"][courier_charge]");
					$(this).find("td:nth-child(5) input").attr("name","customer_address["+i+"][default_address]");
					i++;
				});
				calculate_total();
			}
		} 
    });
	
	function add_row2(){
		var tr=$("#sample_tb2 tbody tr").clone();
		$("#main_tb2 tbody").append(tr);
		var i=0;
		$("#main_tb2 tbody tr").each(function(){
			
			$(this).find("td:nth-child(1)").html(++i); --i;
			$(this).find("td:nth-child(2) textarea").attr("name","customer_address["+i+"][address]").attr("id","customer_address."+i+".address").rules("add", "required");
			$(this).find("td:nth-child(3) select").attr("name","customer_address["+i+"][district_id]").select2();
			$(this).find("td:nth-child(4) select").attr("name","customer_address["+i+"][courier_charge]").select2();
			$(this).find("td:nth-child(5) input").attr("name","customer_address["+i+"][default_address]");
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
			<td><?php echo $this->Form->input('contact_person', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Contact Person']); ?></td>
			<td><?php echo $this->Form->input('telephone', ['type' => 'text','label' => false,'class' => 'form-control input-sm allLetter','placeholder' => 'Telephone','maxlength'=>15]); ?></td>
			<td><?php echo $this->Form->input('mobile', ['type' => 'text','label' => false,'class' => 'form-control input-sm allLetter','placeholder' => 'Mobile','maxlength'=>10,'minlength'=>10]); ?></td>
			<td><?php echo $this->Form->input('email', ['type' => 'email','label' => false,'class' => 'form-control input-sm ','placeholder' => 'Email']); ?></td>
			<td><?php echo $this->Form->input('designation', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Designation']); ?></td>
			<td width="90"><?php echo $this->Form->input('default_contact', ['type'=>'checkbox','label' => false,'class' => 'form-control input-sm default_btn2']); ?></td>
			<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
	</tbody>
</table>

<table id="sample_tb2" style="display:none;">
	<tbody>
		<tr>
			<td>0</td>
			<td><?php echo $this->Form->input('address', ['label' => false,'type' => 'textarea','rows' => '2','style' => ['resize:none'],'class' => 'form-control input-sm','placeholder' => 'Address']); ?></td>
			<td><?php echo $this->Form->input('district_id', ['options' => $districts,'label' => false,'class' => 'form-control input-sm']); ?></td>
			<td><?php echo $this->Form->input('transporter_id', ['options'=>$transporters,'label' => false,'class' => 'form-control input-sm','placeholder' => 'Courier Charge']); ?></td>
			<td width="90"><?php echo $this->Form->input('default_address', ['type'=>'checkbox','label' => false,'class' => 'form-control input-sm default_btn']); ?></td>
			<td><a class="btn btn-xs btn-default addrow2" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow2" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
	</tbody>
</table>


 <script type="text/javascript">
 $(document).ready(function () {
                    $('#id_radio2').click(function () {
                     $('#married_info').show('fast');
                });
				 $('#id_radio1').click(function () {
                     $('#married_info').hide('fast');
                });
					 
				if ($('#id_radio2').is(':checked')) {
					$('#married_info').show('fast');
                }
				else{
					$('#married_info').hide('fast');
                }
	 });
</script>