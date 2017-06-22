<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Add Voucher Reference</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= $this->Form->create($vouchersReference,['type' => 'file','id'=>'form_sample_3']) ?>
			<div class="form-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Voucher Entity <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('voucher_entity', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Voucher Entity']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Description <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('description', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Description']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Account Group<span class="required" aria-required="true">*</span></label>
							
							<?php
							
							foreach($accountGroups as $accountGroup){
							echo $this->Form->input('vouchers_references_groups.0.account_group_id', ['label' => false,'class' => 'form-control input-sm','value' => $accountGroup->name]); 
							} ?>
						</div>
					</div>
				</div>
				<div class="row">
				<div class="panel-group accordion" id="accordion3">
					<?php
							$options=array();
							foreach($accountGroups as $accountGroup){
								$options[]=['text' => $accountGroup->name, 'value' => $accountGroup->id];
							}
					?>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<ul>
										
										<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1" aria-expanded="false">
										
										
										<?php echo $this->Form->input('account_groups._ids', ['options'=>$AccountGroups,'multiple' => 'checkbox','label' => false,'class' => 'form-control input-sm ']); ?>
										
										</h4>
									</div>
									<div id="collapse_3_1" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
										<div class="panel-body">
											<p>
												 Duis autem vel eum iriure dolor in hendrerit in vulputate. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut.
											</p>
											<p>
												 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
											</p>
										</div>
									</div>
								</div>
								
			</div>
		
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">ADD VOUCHER REFERENCE</button>
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
			voucher_entity:{
				required: true,
			},
			description  : {
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
	

	
});
</script>


