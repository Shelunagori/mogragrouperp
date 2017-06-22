<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Leave allowance form</span>
			
		</div>

	</div>
	<div class="portlet-body form">
		<?=   $this->Form->create($leaveAllowance,['id'=>'form_sample_3']) ?>
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
						<label class="col-md-4 control-label">Date Of Submission</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('date_of_submission',['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','placeholder' => 'Date of Submission']); ?>
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
						<label class="col-md-4 control-label">Proposed Date Of Onward Journey</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('date_of_submission',['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','placeholder' => 'Date of Submission']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label class="col-md-4 control-label">Probable Date Of Return Journey</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('date_of_submission',['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','placeholder' => 'Return Journey']); ?>
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
			
							<h4 style="font-size:13px'">Particulars Of Family Members Availing The Facility:-</h4>
				<table class="table table-condensed tableitm">
					<thead>
						<tr>
							<th><label class="control-label">Name<label></th>
							<th><label class="control-label">Age<label></th>
							<th><label class="control-label">Relation <label></th>
							<th><label class="control-label">Whether Dependent <label></th>
						</tr>
					</thead>
					<tbody>
					<tr>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.0.name', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Name']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.0.mobile', ['type' => 'text','label' => false,'class' => 'form-control input-sm allLetter','placeholder' => 'Age','maxlength'=>10]); ?>
							
						</td>
						<td>
						<?php echo $this->Form->input('employee_contact_persons.0.landline', ['type' => 'text','label' => false,'class' => 'form-control input-sm land_line','placeholder' => 'Relation','maxlength'=>30]); ?>
						
						</td>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.0.email', ['label' => false,'class' => 'form-control input-sm nospace','placeholder'=>'Whether Dependent']); ?>
						</td>
						
					</tr>
					
					<tr>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.1.name', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Name']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.1.mobile', ['type' => 'text','label' => false,'class' => 'form-control input-sm allLetter','placeholder' => 'Age']); ?>
							
						</td>
						<td>
						<?php echo $this->Form->input('employee_contact_persons.1.landline', ['type' => 'text','label' => false,'class' => 'form-control input-sm land_line','placeholder' => 'Relation','maxlength'=>30]); ?>
						
						</td>
						<td>
							<?php echo $this->Form->input('employee_contact_persons.1.email', ['label' => false,'class' => 'form-control input-sm nospace','placeholder'=>'Whether Dependent']); ?>
						</td>
						
					</tr>
						
						
					</tbody>
					
				</table>
			
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