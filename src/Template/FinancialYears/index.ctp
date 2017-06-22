
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Financial Years</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-6">
		 <?= $this->Form->create($financialYear,['id'=>'form_sample_3'], array("class"=>"form-horizontal")) ?>
			<div class="form-body">
				<div class="form-group col-md-12">
					<label class="control-label col-md-3">Date From <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							<?php echo $this->Form->input('date_from', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'','data-date-format'=>'dd-mm-yyyy']); ?>
						</div>
					</div>
				</div>
				</br>
				<div class="form-group col-md-12">
					<label class="control-label col-md-3">Date To <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
								<?php echo $this->Form->input('date_to', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'','data-date-format'=>'dd-mm-yyyy']); ?>
						</div>
					</div>
				</div>
				</br>
			
				<div class="row">
					<div class="col-md-offset-4 col-md-8">
						<button type="submit" class="btn btn-primary">Add Financial Year</button>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		</div>
		<div class="col-md-6">
			<div class="portlet-body">
			<div class="row">
			<div class="col-md-12">
				
			<div class="table-scrollable">
			<table class="table table-hover">
				 <thead>
					<tr>
						<th><?= $this->Paginator->sort('date_from') ?></th>
						<th><?= $this->Paginator->sort('date_to') ?></th>
						<th><?= $this->Paginator->sort('status') ?></th>
						<th class="actions"><?= __('Actions') ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				
					  <?php $i =0; $count=1; foreach ($financialYears as $financialYear): 
							
					  ?>
					<tr>
						<?php ++$i; ?>
						<td><?= h(date("d-m-Y",strtotime($financialYear->date_from)))?>
						<td><?= h(date("d-m-Y",strtotime($financialYear->date_to)))?>
						<td><?= h($financialYear->status) ?></td>
						<td class="actions">
							<?= $this->Html->link(__('Edit'), ['action' => 'edit', $financialYear->id]) ?>
						</td>
						<td>
							<?php if($financialYear->status=='Open'){
									echo $this->Form->postLink('<i class="fa fa-minus-circle"> Closed</i> ',['action' =>'closed', $financialYear->id],['escape' => false,'class' => 'btn btn-xs red tooltips','data-original-title'=>'Closed','confirm' => __('Are you sure, you want to Closed ?', $financialYear->id)]
									);
								}
							
							 ?>
							<?php if($financialYear->status=='Closed'){
									echo $this->Form->postLink('<i class="fa fa-plus-circle"> Open</i> ',['action' =>'open', $financialYear->id],['escape' => false,'class' => 'btn btn-xs green tooltips','data-original-title'=>'Opened','confirm' => __('Are you sure, you want to Open ?', $financialYear->id)]
									);
							}
							?>
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
			
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			
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
