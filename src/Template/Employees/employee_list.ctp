 
<?php 

	if(!empty($status)){
		$url_excel=$status."/?".$url;
	}else{
		$url_excel="/?".$url;
	}

?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Employees</span>
		</div>
	</div>
	<div class="portlet-body">
	<div class="row">
				<div class="col-md-12">
				<form method="GET" >
				<div class="row">
									
									<div class="col-md-3">
										<input type="text" name="employee_name" class="form-control input-sm" placeholder="Employee Name" value="<?php echo @$employee_name; ?>">
									</div>
									<div class="col-md-3">
										<input type="text" name="department_name" class="form-control input-sm" placeholder="Department Name" value="<?php echo @$department_name; ?>">
									</div>
									<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
				</div>
				</form>
		<div class="table-scrollable">
			 <table class="table table-hover">
				 <thead>
					<tr>
						<th><?= $this->Paginator->sort('id') ?></th>
						<th><?= $this->Paginator->sort('name') ?></th>
						<th><?= $this->Paginator->sort('sex') ?></th>
						<th><?= $this->Paginator->sort('department_id') ?></th>
						<th><?= $this->Paginator->sort('mobile') ?></th>
						<th><?= $this->Paginator->sort('Email') ?></th>
						<th class="actions"><?= __('Actions') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; foreach ($employees as $employee): $i++; ?>
					<tr>
						<td><?= h($i) ?></td>
						<td><?= h($employee->name) ?></td>
						<td><?= h($employee->sex) ?></td>
						<td><?= h($employee->department->name) ?></td>
						<td><?= h($employee->mobile) ?></td>
						<td><?= h($employee->email) ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-repeat"></i>Show Detail','/Employees/employeeInformation?id='.$employee->id,array('escape'=>false,'class'=>'btn btn-xs default blue-stripe')); ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		 <div class="paginator">
			<ul class="pagination">
				<?= $this->Paginator->prev('< ' . __('previous')) ?>
				<?= $this->Paginator->numbers() ?>
				<?= $this->Paginator->next(__('next') . ' >') ?>
			</ul>
			<p><?= $this->Paginator->counter() ?></p>
		</div>
	</div>
</div>
</div>
