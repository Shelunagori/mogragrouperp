<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-gift"></i>Sale Taxes
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-6">
		 <?= $this->Form->create($saleTax,array("class"=>"form-horizontal")) ?>
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-3">Figure  <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('tax_figure', ['label' => false,'class' => 'form-control','placeholder'=>'Figure']); ?>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">Description (Quotation)
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('quote_description', ['label' => false,'class' => 'form-control','placeholder'=>'Description for Quotation']); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Description (Invoice)
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('invoice_description', ['label' => false,'class' => 'form-control','placeholder'=>'Description for Invoice']); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Account Category <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
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
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							<div id="account_group_div">
							<?php echo $this->Form->input('account_group_id', ['options' => [],'label' => false,'class' => 'form-control input-sm select2me','empty'=>'--Select Account Group--']); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Account First Sub Group <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							<div id="account_first_subgroup_div">
							<?php echo $this->Form->input('account_first_subgroup_id', ['options' => [],'label' => false,'class' => 'form-control input-sm select2me','empty'=>'--Select Account First Sub Group--']); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Account Second Sub Group <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							<div id="account_second_subgroup_div">
							<?php echo $this->Form->input('account_second_subgroup_id', ['options' => [],'label' => false,'class' => 'form-control input-sm select2me','empty'=>'--Select Account Second Sub Group--']); ?>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">Use In Companies </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							<div id="account_second_subgroup_div">
							<?php echo $this->Form->input('companies._ids', ['label' => false,'options' => $Companies,'multiple' => 'checkbox']); ?>
							</div>
						</div>
					</div>
				</div>
				
				
					
				<div class="row">
					<div class="col-md-offset-4 col-md-8">
						<button type="submit" class="btn btn-primary">Add Sale Tax</button>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		</div>
		<div class="col-md-6">
			<div class="portlet-body">
			<div class="table-scrollable">
			<table class="table table-hover">
				 <thead>
					<tr>
						<th>Sr. No.</th>
						<th>Figure</th>
						<th>Freeze</th>
						
						<th class="actions"><?= __('Actions') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; foreach ($saleTaxes as $saleTax): $i++; ?>
					<tr>
						<?php if($saleTax->freeze==1) { $saletax ="Yes"; } else 
							{ $saletax ="No"; } ?>
						<td><?= h($i) ?></td>
						<td><?= $this->Number->format($saleTax->tax_figure,[ 'places' => 2]) ?></td>
						<td><?php echo $saletax; ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $saleTax->id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
							 <!--<?= $this->Form->postLink('<i class="fa fa-trash"></i> ',
								['action' => 'delete', $saleTax->id], 
								[
									'escape' => false,
									'class'=>'btn btn-xs red tooltips','data-original-title'=>'Delete',
									
									'confirm' => __('Are you sure ?', $saleTax->id)
								]
							) ?>-->
							
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'EditCompany', $saleTax->id],array('escape'=>false,'class'=>'btn btn-xs green tooltips','data-original-title'=>'Add/Remove in other companies, Freeze/Unfreeze, Serial Number Enable/Disable')); ?>
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

});
</script>