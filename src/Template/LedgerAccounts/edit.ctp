<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Ledger Account</span>
		</div>
		<div class="actions">
			<?php echo $this->Html->link('Account Group','/AccountGroups/',array('escape'=>false,'class'=>'btn btn-default')); ?>
			<?php echo $this->Html->link('Account First Sub Group','/AccountFirstSubgroups/',array('escape'=>false,'class'=>'btn btn-default')); ?>
			<?php echo $this->Html->link('Account Second Sub Group','/AccountSecondSubgroups/',array('escape'=>false,'class'=>'btn btn-default')); ?>
			<?php echo $this->Html->link('Ledger Account','/LedgerAccounts/',array('escape'=>false,'class'=>'btn btn-primary')); ?>
		</div>
	</div>
	 <div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-12">
		<?= $this->Form->create($ledgerAccount) ?>
			<div class="form-body">
			
				</br>

				<div class="row">
				<div class="form-group">
					<label class="control-label col-md-3">Account Second Sub Group <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-4">
						<div class="input-icon right">
							<i class="fa"></i>
							<div id="account_second_subgroup_div">
							<?php echo $this->Form->input('account_second_subgroup_id', ['options' => $AccountSecondSubgroups,'label' => false,'class' => 'form-control input-sm select2me']); ?>
							</div>
						</div>
					</div>
				</div>
				</div>
				</br>

				<div class="row">
					<div class="form-group">
					<label class="control-label col-md-3">Name<span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-4">
						<div class="input-icon right">
							<i class="fa"></i>
						<?php 
						echo $this->Form->input('name', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Name']); 
						?>
					</div>
					</div>
				</div>	
				</div>
				</br>

					<div class="col-md-2">
					<label class="control-label"> <span class="required" aria-required="true"></span> </label><br/>
						<?php 
						echo $this->Form->button(__('EDIT'),['class'=>'btn btn-primary']); 
						?>
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