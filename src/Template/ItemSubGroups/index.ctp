<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Item Sub Groups</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-6">
		 <?= $this->Form->create($itemSubGroup,array("class"=>"form-horizontal",'id'=>'form_sample_3')) ?>
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-3">Item Category  <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('item_category_id', ['empty'=>'--Select--','options' => $itemCategories,'label' => false,'class' => 'form-control input-sm']); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Item Group  <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9" id="item_group_div">
						
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Name<span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('name', ['label' => false,'class' => 'form-control input-sm firstupercase']); ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-offset-4 col-md-8">
						<button type="submit" class="btn btn-primary">Add Item Sub Group</button>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		</div>
		<div class="col-md-6">
		
		<form method="GET" >
								<table class="table table-condensed">
									<thead>
										<tr>
											<th>ITEMS GROUP</th>
											
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<div class="row">
												<div class="col-md-4">
													<input type="text" name="item_category_name" class="form-control input-sm" placeholder="Item Category" value="<?php echo @$item_category_name; ?>">
												</div>
												
												<div class="col-md-4">
													<input type="text" name="item_group_name" class="form-control input-sm" placeholder="Item Group" value="<?php echo @$item_group_name; ?>">
												</div>
												
												<div class="col-md-4">
													<input type="text" name="item_subgroup_name" class="form-control input-sm" placeholder="Item Subgroup" value="<?php echo @$item_subgroup_name; ?>">
												</div>
												
											</div>
											</td>
											<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
										</tr>
									</tbody>
								</table>
		</form>
			<div class="portlet-body">
			<div class="table-scrollable">
				<?php $page_no=$this->Paginator->current('ItemSubGroups'); $page_no=($page_no-1)*20; ?>
			<table class="table table-hover">
				<thead>
					<tr>
						<th><?= $this->Paginator->sort('id') ?></th>
						<th>Category Name</th>
						<th>Group Name</th>
						<th>Sub Group Name</th>
						<th class="actions"><?= __('Actions') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($itemSubGroups as $itemSubGroup): ?>
					<tr>
						<td><?= h(++$page_no) ?></td>
						<td><?= h($itemSubGroup->item_group->item_category->name) ?></td>
						<td><?= h($itemSubGroup->item_group->name) ?></td>
						<td><?= h($itemSubGroup->name) ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $itemSubGroup->id],array('escape'=>false,'class'=>'btn btn-xs blue')); ?>
							<?= $this->Form->postLink('<i class="fa fa-trash"></i> ',
								['action' => 'delete', $itemSubGroup->id], 
								[
									'escape' => false,
									'class' => 'btn btn-xs btn-danger',
									'confirm' => __('Are you sure ?', $itemSubGroup->id)
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
			name:{
				required: true,
				//alphabetsAndSpacesOnly: true,
				maxlength:40,
			},
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			
			name  : {
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

	$('select[name="item_category_id"]').on("change",function() {
		$('#item_group_div').html('Loading...');
		var itemCategoryId=$('select[name="item_category_id"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'ItemGroups','action'=>'ItemGroupDropdown']); ?>";
		url=url+'/'+itemCategoryId,
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			$('#item_group_div').html(response);
		});
    });
});
</script>