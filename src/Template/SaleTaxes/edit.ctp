<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-gift"></i>Edit Sale Taxe
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-12">
		 <?= $this->Form->create($saleTax,array("class"=>"form-horizontal")) ?>
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-3">Figure  <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-4">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('tax_figure', ['label' => false,'class' => 'form-control','placeholder'=>'Figure','value'=>$this->Number->format($saleTax->tax_figure,[ 'places' => 2])]); ?>
						</div>
					</div>
					
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Description(Quote)  <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-4">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('quote_description', ['label' => false,'class' => 'form-control','placeholder'=>'Description']); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Description(Invoice)  <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-4">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('invoice_description', ['label' => false,'class' => 'form-control','placeholder'=>'Description']); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Account Category <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-4">
						<div class="input-icon right">
							<i class="fa"></i>
							<?php echo $this->Form->input('account_category_id', ['options'=>$AccountCategories,'empty' => "--Select Account Category--",'label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Account Group <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-4">
						<div class="input-icon right">
							<i class="fa"></i>
							<div id="account_group_div">
							<?php echo $this->Form->input('account_group_id', ['options' => $AccountGroups,'label' => false,'class' => 'form-control input-sm select2me','empty'=>'--Select Account Group--']); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Account First Sub Group <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-4">
						<div class="input-icon right">
							<i class="fa"></i>
							<div id="account_first_subgroup_div">
							<?php echo $this->Form->input('account_first_subgroup_id', ['options' => $AccountFirstSubgroups,'label' => false,'class' => 'form-control input-sm select2me','empty'=>'--Select Account First Sub Group--']); ?>
							</div>
						</div>
					</div>
				</div>
					<div class="form-group">
					<label class="control-label col-md-3">Account Second Sub Group <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-4">
						<div class="input-icon right">
							<i class="fa"></i>
							<div id="account_second_subgroup_div">
							<?php echo $this->Form->input('account_second_subgroup_id', ['options' => $AccountSecondSubgroups,'label' => false,'class' => 'form-control input-sm select2me','empty'=>'--Select Account Second Sub Group--']); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
								<label class="control-label col-md-4"> <span class="required" aria-required="true">
					</span>
					</label>
							<?php echo $this->Form->input('freeze'); ?>
				</div>
				
				
					
				<div class="row">
					<div class="col-md-offset-4 col-md-8">
						<button type="submit" class="btn btn-primary">Edit Sale Tax</button>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		</div>
		<!-- END FORM-->
	</div>
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
			ecc_no   : {
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
	add_row(); $('.default_btn:first').attr('checked','checked'); $.uniform.update();
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
			<td><?php echo $this->Form->input('mobile', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Mobile','maxlength'=>10]); ?></td>
			<td width="90"><?php echo $this->Form->input('q', ['type'=>'checkbox','label' => false,'class' => 'form-control default_btn','value'=>1]); ?></td>
			<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
	</tbody>
</table>
