<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Districts</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-6">
		 <?= $this->Form->create($district,array("class"=>"form-horizontal",'id'=>'form_sample_3')) ?>
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-3">State  <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('state', ['label' => false,'class' => 'form-control firstupercase']); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">District <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('district', ['label' => false,'class' => 'form-control firstupercase']); ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-offset-4 col-md-8">
						<?php echo $this->Form->button(__('ADD DISTRICT'),['class'=>'btn green']); ?>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		</div>
		<div class="col-md-6">
			<div class="portlet-body">
			<form method="GET" >
				<div class="row">
					<div class="col-md-5">
						<input type="text" name="customer_state" class="form-control input-sm" placeholder="State" value="<?php echo @$customer_state; ?>">
					</div>
					<div class="col-md-5">
						<input type="text" name="customer_district" class="form-control input-sm" placeholder="District" value="<?php echo @$customer_district; ?>">
					</div>
					<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
				</div>
				</form>
			<div class="table-scrollable">
			<?php $page_no=$this->Paginator->current('Districts'); $page_no=($page_no-1)*20; ?>
			<table class="table table-hover">
				 <thead>
					<tr>
						<th>Sr. No.</th>
						<th><?= $this->Paginator->sort('state') ?></th>
						<th><?= $this->Paginator->sort('district') ?></th>
						<th class="actions"><?= __('Actions') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; foreach ($listdistricts as $district): $i++; ?>
					<tr>
						<td><?= h(++$page_no) ?></td>
						<td><?= h($district->state) ?></td>
						<td><?= h($district->district) ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $district->id],array('escape'=>false,'class'=>'btn btn-xs blue')); ?>
							<?= $this->Form->postLink('<i class="fa fa-trash"></i> ',
								['action' => 'delete', $district->id], 
								[
									'escape' => false,
									'class' => 'btn btn-xs btn-danger',
									'confirm' => __('Are you sure ?', $district->id)
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
	//--------- FORM VALIDATION
	jQuery.validator.addMethod("alphabetsAndSpacesOnly", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\s]+$/.test(value); });
	
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
			state:{
				required: true,
				alphabetsAndSpacesOnly: true,
				maxlength:30,
			},
			
			district:{
				required: true,
				alphabetsAndSpacesOnly: true,
				maxlength:30,
			},
		
		},

		messages: { // custom messages for radio buttons and checkboxes
			district  : {
				alphabetsAndSpacesOnly: "Enter Letters only",
			},
			state  : {
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
