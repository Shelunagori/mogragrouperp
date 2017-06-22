<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Leave Application Form</span>
			
		</div>

	</div>
	<div class="portlet-body form">
		<?=  $this->Form->create($RequestLeavesData,['id'=>'form_sample_3']) ?>
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
				<div class="col-md-5">
					<div class="form-group">
						<label class="col-md-6 control-label">Employee Name</label>
						<div class="col-md-6">
							<?php echo $employeedata->name; ?>
							<?php echo $this->Form->input('employee_id',['type' => 'hidden','value'=> $employeedata->id]); ?>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<label class="col-md-6 control-label">Leave Type</label>
						<div class="col-md-6">
							<?php echo $RequestLeavesData->leave_type->leave_name; ?>
						</div>
					</div>
				</div>
			</div><br/>
			
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
						<label class="col-md-6 control-label">Leave From</label>
						<div class="col-md-6">
							<?php echo date("d-m-Y",strtotime($RequestLeavesData->leave_from));?>
							
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<label class="col-md-6 control-label">Leave To</label>
						<div class="col-md-6">
							<?php echo date("d-m-Y",strtotime($RequestLeavesData->leave_to));?>
						</div>
					</div>
				</div>
			</div><br/>
			
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
						<label class="col-md-6 control-label">Reason For Leave</label>
						<div class="col-md-6">
							<?php echo $RequestLeavesData->reason; ?>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<label class="col-md-6 control-label">Total days Of Leave</label>
						<div class="col-md-6">
							<?php echo $RequestLeavesData->no_of_days; ?>
						</div>
					</div>
				</div>
			</div><br/>
			
			
			<br/><div class="row">
				<div class="col-md-10">
					<div class="form-group">
						<label class="col-md-3 control-label">Remark</label>
						<div class="col-md-8">
							<?php echo $RequestLeavesData->remarks; ?>
						</div>
					</div>
				</div>
			</div><br/>
			
			
			<div class="row">
				<div class="col-md-10">
					<div class="form-group">
						<label class="col-md-3 control-label">Message</label>
						<div class="col-md-8">
							<?php echo $this->Form->textarea('message',['type' => 'text','label' => false,'class' => 'form-control input-sm ','placeholder' => 'Message']); ?>
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
					
					<button type="submit" class="btn btn-primary">Approve</button>
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