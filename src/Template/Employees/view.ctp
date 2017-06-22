<?php //pr($employee); exit;?>
<style>
.control-label1{
font-weight: 600;
font-size: 12px;
text-transform: titlecase;
color: #113775;
}
</style>
<div class="portlet light bordered">
<div class="employees view large-9 medium-8 columns content">
    <h3 >Employee Details</h3>
	<table class="table table-bordered table-striped table-hover">
					<tbody>
						<tr>
							<td><label class="control-label1"><?= __('Name') ?></label></td>
							<td><?= h($employee->name) ?></td>
							<td><label class="control-label1"><?= __('Email') ?></label></td>
							<td><?= h($employee->email) ?></td>
						</tr>
						<tr>
							
							<td><label class="control-label1"><?= __('Date of Birth') ?></label></td>
							<td><?= h($employee->dob) ?></td>
							<td><label class="control-label1"><?= __('Sex') ?></label></td>
							<td><?= h($employee->sex) ?></td>
						</tr>
						<tr>
							<td><label class="control-label1"><?= __('Mobile') ?></label></td>
							<td><?= h($employee->mobile) ?></td>
							<td><label class="control-label1"><?= __('Landline') ?></label></td>
							<td><?= h($employee->phone_no) ?></td>
						</tr>
						<tr>
							<td><label class="control-label1"><?= __('Qualification') ?></label></td>
							<td><?= h($employee->qualification) ?></td>
							<td><label class="control-label1"><?= __('Blood Group') ?></label></td>
							<td><?= h($employee->blood_group) ?></td>
						</tr>
						<tr>
							 <td><label class="control-label1"><?= __('Department') ?></label></td>
							<td><?= h($employee->department->name) ?></td>
							<td><label class="control-label1"><?= __('Designation') ?></label></td>
							<td><?= h($employee->designation->name) ?></td>
						</tr>
						<tr>
							<td><label class="control-label1"><?= __('Date of Joinning') ?></label></td>
							<td><?= h($employee->join_date) ?></td>
							<td><label class="control-label1"><?= __('Date of Confirmation') ?></label></td>
							<td><?= h($employee->permanent_join_date) ?></td>
						</tr>
						
						<tr>
							<td><label class="control-label1"><?= __('Last Comapany Name') ?></label></td>
							<td><?= h($employee->last_company) ?></td>
							<td><label class="control-label1"><?= __('Marital_Status') ?></label></td>
							<td><?=h($employee->marital_status) ?></td>
						</tr>
						<?php if(h($employee->marital_status)=='Married') 
						{?>
						<tr>
							<td><label class="control-label1"><?= __('Date of Anniversary') ?></label></td>
							<td><?= h($employee->date_of_anniversary) ?></td>
							<td><label class="control-label1"><?= __('Spouse Name') ?></b></td>
							<td><?= h($employee->spouse_name) ?></td>
						</tr>	
						<tr>
							<td><label class="control-label1"><?= __('Number of child') ?></label></td>
							<td><?= h($employee->children) ?></td>
							<td><label class="control-label1"><?= __('Whether Spouse Working?') ?></label></td>
							<td><?= h($employee->spouse_working) ?></td>
						</tr>	
						<?php
						}
						?>
						<tr>
							<td><label class="control-label1"><?= __('Permanent Address') ?></label></td>
							<td colspan="6"> <?= $this->Text->autoParagraph(h($employee->permanent_address)); ?>
							</td>
							</tr>
							<tr>
							<td><label class="control-label1"><?= __('Residence Address') ?></label></td>
							<td colspan="6"> <?= $this->Text->autoParagraph(h($employee->residence_address)); ?>
							</td>
						</tr>				
						<tr>
							<td colspan="6"><h4 style="font-size:16px'">Bank's Detail</h4></td>
							
						</tr>
						<tr>
							<th>Sr.No.</th>
							<th><label class="control-label1">Bank Name<label></th>
							<th><label class="control-label1">Branch Name<label></th>
							<th><label class="control-label1">Account Number<label></th>
							<th><label class="control-label1">IFSC Code<label></th>
							<th></th>
						
						</tr>
						<tr>
							<td>1.</td>
							<td><?= h($employee->bank_name) ?></td>
							<td><?= h($employee->branch_name) ?></td>
							<td><?= h($employee->account_no) ?></td>	
							<td><?= h($employee->ifsc_code) ?></td>
							<td></td>
							
						</tr>
						
						<tr>
							<td colspan="6"><h4 style="font-size:16px'">Employee Emerjency Contact Detail</h4></td>
							
						</tr>
						<tr>
							<th><label class="control-label1">Sr.No<label></th>
							<th><label class="control-label1">Name<label></th>
							<th><label class="control-label1">Mobile<label></th>
							<th><label class="control-label1">Landline<label></th>
							<th><label class="control-label1">Email<label></th>
							<th><label class="control-label1">Relation<label></th>
							
						</tr>
						<?php $i=0;  foreach($employee->employee_contact_persons as $employee_contact_persons): $i++; ?>
						<tr>
							<td><?= h($i) ?></td>
							<td><?= h($employee_contact_persons->name) ?></td>	
							<td><?= h($employee_contact_persons->mobile) ?></td>
							<td><?= h($employee_contact_persons->landline) ?></td>
							<td><?= h($employee_contact_persons->email) ?></td>
							<td><?= h($employee_contact_persons->relation) ?></td>
						</tr>
						<?php endforeach ?>
					</tbody>
					
				
	
				</table>
				
		
   
				
</div>
</div>