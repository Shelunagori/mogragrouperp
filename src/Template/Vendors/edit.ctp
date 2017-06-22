<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Edit Supplier</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= $this->Form->create($vendor,['type' => 'file','id'=>'form_sample_3']) ?>
			<div class="form-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Company Name <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('company_name', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Company Name']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Address <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('address', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Address']); ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Item Group Id <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('item_group_id', ['empty'=>'--Select--','options'=>$ItemGroups,'label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Tin No <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('tin_no', ['label' => false,'class' => 'form-control input-sm ','placeholder'=>'Tin No']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Gst No</label>
							<?php echo $this->Form->input('gst_no', ['label' => false,'class' => 'form-control input-sm nospace','placeholder'=>'Gst No']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">ECC No</label>
							<?php echo $this->Form->input('ecc_no', ['label' => false,'class' => 'form-control input-sm nospace','placeholder'=>'ECC No']); ?>
						</div>
					</div>
				</div>
				<div class="row">
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Pan No</label>
							<?php echo $this->Form->input('pan_no', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Pan No']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Payment Terms</label>
							<?php $options=[];
							for($q=0; $q<100; $q++){
								$options[$q]=$q;
							}
							echo $this->Form->input('payment_terms', ['options'=>$options,'label' => false,'class' => 'form-control input-sm','placeholder'=>'Payment Terms']); ?>
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
				<h4 style="font-size:13px'">Contact Persons</h4>
				<table class="table table-condensed tableitm" id="main_tb">
					<thead>
						<tr>
							<th><label class="control-label">Sr.No.<label></th>
							<th><label class="control-label">NAME<label></th>
							<th><label class="control-label">EMAIL<label></th>
							<th><label class="control-label">MOBILE<label></th>
							<th><label class="control-label">DEFAULT<label></th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; $j=0;  foreach($vendor->vendor_contact_persons as $vendor_contact_person){ $j++;
						if($vendor_contact_person->default_person =='1'){
							 $checked2=1;
						} else{ 
							 $checked2=0; } 
							?>
						<tr>
							<td><?= h($j) ?></td>
							<td><?php echo $this->Form->input('vendor_contact_persons.'.$i.'.name', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Name','value'=>$vendor_contact_person->name,'required']); ?></td>
							<td><?php echo $this->Form->input('vendor_contact_persons.'.$i.'.email', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Email','value'=>$vendor_contact_person->email,'required']); ?></td>
							<td><?php echo $this->Form->input('vendor_contact_persons.'.$i.'.mobile', ['label' => false,'class' => 'form-control input-sm allLetter','value'=>$vendor_contact_person->mobile,'placeholder'=>'Mobile','maxlength'=>10,'minlength'=>10,'required']); ?></td>
							<td width="90"><?php echo $this->Form->input('vendor_contact_persons.'.$i.'.default_person', ['type'=>'checkbox','label' => false,'class' => 'form-control input-sm default_btn','checked'=>$checked2]); ?></td>
							<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
						</tr>
						<?php $i++; } ?>
					</tbody>
				</table>

			</div>
		
			<div class="form-actions">
				<button type="submit" class="btn btn-primary" id='submitbtn'>EDIT VENDOR</button>
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
	jQuery.validator.addMethod("alphabetsAndSpacesOnly", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\s.,]+$/.test(value); });
		
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
			company_name:{
				required: true,
				alphabetsAndSpacesOnly: true,
			},
			address  : {
				  required: true,
			},
			tin_no  : {
				  required: true,
			},
			pan_no   :{
				required: true,
			},
			payment_terms :{
				required: true,
			},
			mode_of_payment   :{
				required: true,
			},
			address : {
				  required: true,
			},
			item_group_id : {
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
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			company_name: {
				alphabetsAndSpacesOnly: "Enter Letters only",
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
				q="ok";
			$("#main_tb tbody tr").each(function(){
				var t=$(this).find("td:nth-child(2) input").val();
				var w=$(this).find("td:nth-child(3) input").val();
				var r=$(this).find("td:nth-child(4) input").val();
				if(t=="" || w=="" || r==""){
					q="e";
				}
			});
			if(q=="e"){
				$("#row_error").show();
				return false;
			}else{
				success3.show();
				error3.hide();
				form[0].submit(); // submit the form
			}
		}

	});
	
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
	//rename_rows();
	//add_row(); 
	$('.default_btn:first').attr('checked','checked'); $.uniform.update();
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
			}
		} 
    });
	
	function add_row(){
		var tr=$("#sample_tb tbody tr").clone();
		$("#main_tb tbody").append(tr);
		rename_rows();
		
	}
	
	function rename_rows(){
	var i=0;
		$("#main_tb tbody tr").each(function(){
			
			$(this).find("td:nth-child(1)").html(++i); --i;
			$(this).find("td:nth-child(2) input").attr({name:"vendor_contact_persons["+i+"][name]",id:"vendor_contact_persons-"+i+"-name"}).rules('add', {
						required: true,
						alphabetsAndSpacesOnly: true,
						messages: {
							alphabetsAndSpacesOnly: "Enter Letters Only.",
						}
					
			});
			$(this).find("td:nth-child(3) input").attr({name:"vendor_contact_persons["+i+"][email]",id:"vendor_contact_persons-"+i+"-email"}).rules("add", "required");
			$(this).find("td:nth-child(4) input").attr({name:"vendor_contact_persons["+i+"][mobile]",id:"vendor_contact_persons-"+i+"-mobile"}).rules('add', {
						required: true,
						number: true,
						minlength:10,
					});
			$(this).find("td:nth-child(5) input[type=checkbox]").attr("name","vendor_contact_persons["+i+"][default_person]");
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
			<td><?php echo $this->Form->input('name', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Name']); ?></td>
			<td><?php echo $this->Form->input('email', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Email']); ?></td>
			<td><?php echo $this->Form->input('mobile', ['label' => false,'class' => 'form-control input-sm allLetter','placeholder'=>'Mobile','maxlength'=>10]); ?></td>
			<td width="90"><?php echo $this->Form->input('q', ['type'=>'checkbox','label' => false,'class' => 'form-control default_btn']); ?></td>
			<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
	</tbody>
</table>
