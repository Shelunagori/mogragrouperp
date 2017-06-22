
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Edit Account References</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= $this->Form->create($accountReference) ?>
			<div class="form-body">
			<div class="row">
				<div class="col-md-4" >
						<div class="form-group">
						<label class=" control-label">Entity Description<span class="required" aria-required="true">*</span></label>
							<?php 
							
							echo $this->Form->input('entity_description',['label' => false,'class' => 'form-control input-sm '] ); ?>
						
						</div>
				</div>
	
				<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Account Category<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('account_category_id', ['options'=>$AccountCategories,'label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
			
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Account Group <span class="required" aria-required="true">*</span></label>
							<div id="account_group_div">
							<?php echo $this->Form->input('account_group_id', ['options' => $AccountGroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Account Group']); ?>
							</div>
						</div>
					</div>
			</div>
			
			<div class="row">
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Account First Sub Group <span class="required" aria-required="true">*</span></label>
							<div id="account_first_subgroup_div">
							<?php echo $this->Form->input('account_first_subgroup_id', ['options'=>$AccountFirstSubgroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Account First Sub Group']); ?>
							</div>
						</div>
					</div>
					
					
				</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Edit ACCOUNT REFERENCE</button>
			</div>
		</div>
		<?= $this->Form->end() ?>
		<!-- END FORM-->
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
	
/* $('select[name="account_first_subgroup_id"]').die().live("change",function() {
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

$('select[name="account_second_subgroup_id"]').die().live("change",function() {
	
	$('#account_ledger_div').html('Loading...');
	var accountSecondSubgroupId=$('select[name="account_second_subgroup_id"] option:selected').val();
	//alert(accountSecongSubgroupId);
	var url="<?php echo $this->Url->build(['controller'=>'LedgerAccounts','action'=>'LedgerAccountDropdown']); ?>";
	url=url+'/'+accountSecondSubgroupId,
	$.ajax({
		url: url,
		type: 'GET',
	}).done(function(response) {
		$('#account_ledger_div').html(response);
		$('select[name="ledger_account_id"]').select2();
	});
});	 */

});
</script>
