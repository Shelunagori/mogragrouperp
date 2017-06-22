<?php 

	if(!empty($status)){
		$url_excel=$status."/?".$url;
	}else{
		$url_excel="/?".$url;
	}

?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Transporters</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-6">
		 <?= $this->Form->create($transporter,['id'=>'form_sample_3'], array("class"=>"form-horizontal")) ?>
			<div class="form-body">
				<div class="form-group col-md-12">
					<label class="control-label col-md-3">Transporter Name  <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('transporter_name', ['label' => false,'class' => 'form-control firstupercase']); ?>
						</div>
					</div>
				</div>
				</br>
				<div class="form-group col-md-12">
					<label class="control-label col-md-3">Mobile <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('mobile', ['label' => false,'class' => 'form-control nospace allLetter','maxlength'=>10,'minlength'=>10]); ?>
						</div>
					</div>
				</div>
				</br>
				</br>
				<div class="form-group col-md-12">
					<label class="control-label col-md-3">Address <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('address', ['label' => false,'class' => 'form-control']); ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-offset-4 col-md-8">
						<button type="submit" class="btn btn-primary">Add Transporter</button>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		</div>
		<div class="col-md-6">
			<div class="portlet-body">
			<div class="row">
			<div class="col-md-12">
				<form method="GET" >
				<div class="row">
									
									<div class="col-md-6">
										<input type="text" name="transporter_alise" class="form-control input-sm" placeholder="Transporter Name" value="<?php echo @$transporter_alise; ?>">
									</div>
									<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
				</div>
				</form>
			<div class="table-scrollable">
			<?php $page_no=$this->Paginator->current('Transporters'); $page_no=($page_no-1)*20; ?>
			<table class="table table-hover">
				 <thead>
					<tr>
						<th>Sr. No.</th>
						<th>Transporter Name</th>
						<th>Mobile</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; foreach ($transporters as $transporter): $i++; ?>
					<tr>
						<td><?= h(++$page_no) ?></td>
						<td><?= h($transporter->transporter_name) ?></td>
						<td><?= h($transporter->mobile) ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $transporter->id],array('escape'=>false,'class'=>'btn btn-xs blue')); ?>
							<?= $this->Form->postLink('<i class="fa fa-trash"></i> ',
								['action' => 'delete', $transporter->id], 
								[
									'escape' => false,
									'class' => 'btn btn-xs btn-danger',
									'confirm' => __('Are you sure ?', $transporter->id)
								]
							) ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div>
			<div class="paginator">
				<ul class="pagination">
					<?= $this->Paginator->prev('<') ?>
					<?= $this->Paginator->numbers() ?>
					<?= $this->Paginator->next('>') ?>
				</ul>
				<p><?= $this->Paginator->counter() ?></p>
			</div>
			</div>
		</div>
		<!-- END FORM-->
	</div>
</div>
</div>

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
			transporter_name:{
				required: true
				
			},
			mobile:{
				required: true,
				digits: true,
				minlength: 10,
				maxlength: 10,
			},
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			transporter_name  : {
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
	

});
</script>
