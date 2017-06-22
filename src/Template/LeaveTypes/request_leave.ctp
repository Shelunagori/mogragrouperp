<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Leave Application Form</span>
			
		</div>

	</div>
	<div class="portlet-body form">
		<?=  $this->Form->create($leaveAllowance,['id'=>'form_sample_3']) ?>
		<div class="form-body">
			<div class="row">
				<div class="col-md-6">
				</div>
				<div class="col-md-3">
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="col-md-3 control-label">Date</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('created_on', ['type' => 'text','label' => false,'class' => 'form-control input-sm','value' => date("d-m-Y"),'readonly']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label class="col-md-4 control-label">Employee Name</label>
						<div class="col-md-8">
							<?php echo $Employee->name; ?>
						</div>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label class="col-md-4 control-label">Leave Type</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('sales_ledger_account', ['empty' => "--Select--",'label' => false,'options' => $LeaveType,'class' => 'form-control input-sm select2me','required']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label class="col-md-4 control-label">Half Day </label>
						<div class="col-md-8">
							<div class="radio-inline" >
									<?php echo $this->Form->radio(
											'over_time',
											[
												['value' => 'Yes', 'text' => 'Yes'],
												['value' => 'No', 'text' => 'No']
											]
									); ?>
								</div>
						</div>
					</div>
				</div>
			</div><br/>
			
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label class="col-md-4 control-label">Date Of Leave Required</label>
						<div class="col-md-4">
							<?php echo $this->Form->input('leave_from',['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','placeholder' => 'Leave From']); ?>
						</div>
						
						<div class="col-md-4">
							<?php echo $this->Form->input('leave_to',['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','placeholder' => 'Leave To']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label class="col-md-4 control-label">Reason For Leave</label>
						<div class="col-md-8">
							<?php echo $this->Form->textarea('date_of_submission',['type' => 'text','label' => false,'class' => 'form-control input-sm ','placeholder' => 'Reason For Leave']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label class="col-md-4 control-label">Place Of Visit</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('date_of_submission',['type' => 'text','label' => false,'class' => 'form-control input-sm ','placeholder' => 'Place Of Visit']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			
				
			</div>
			<br/>
		</div>
		<div class="form-actions">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					
					<button type="submit" class="btn btn-primary" >ADD</button>
					</div>
			</div>
		</div>
		<?= $this->Form->end() ?>
	</div>
</div>
<style>

.padding-right-decrease{
	padding-right: 0;
}
.padding-left-decrease{
	padding-left: 0;
}
</style>