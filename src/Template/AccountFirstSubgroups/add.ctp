<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Add Account First Subgroup</span>
		</div>
	</div>
	
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-12">
		<?= $this->Form->create($accountFirstSubgroup) ?>
			<div class="form-body">
				<div class="form-group">
					<div class="col-md-5">
					<label class="control-label">Account Group <span class="required" aria-required="true">*</span></label>
						<?php 
						echo $this->Form->input('account_group_id', ['options' => $accountGroups,'empty' => "--Select--",'label' => false,'class' => 'form-control select2me ','required']); 
						?>
					</div>
					<div class="col-md-5">
					<label class="control-label">Name <span class="required" aria-required="true">*</span></label>
						<?php 
						echo $this->Form->input('name', ['label' => false,'class' => 'form-control input-sm ','placeholder'=>'Name']); 
						?>
					</div>
					
					<div class="col-md-2">
					<label class="control-label"> <span class="required" aria-required="true"></span> </label><br/>
						<?php 
						echo $this->Form->button(__('ADD'),['class'=>'btn btn-primary']); 
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


