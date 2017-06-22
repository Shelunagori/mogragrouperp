
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Leave Types</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-6">
		 <?= $this->Form->create($leaveType,array("class"=>"form-horizontal")) ?>
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-5">Leave Type<span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-7">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('leave_name', ['label' => false,'class' => 'form-control','placeholder' => 'Leave Type']); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-5">Maximum Leave in Month <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-7">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('maximum_leave_in_month', ['label' => false,'class' => 'form-control']); ?>
						</div>
					</div>
				</div>
			
				<div class="row">
					<div class="col-md-offset-4 col-md-8">

					<div class="col-md-offset-6 col-md-6">
						<button type="submit" class="btn btn-primary">Add Leave Type</button>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		</div>
		</div>
		<div class="col-md-6">
			<div class="portlet-body">
			<div class="row">
			<div class="col-md-12">
				
			<div class="table-scrollable">
			<table class="table table-hover">
				 <thead>
					<tr>
						<th>S.no</th>
						<th>Leave Type</th>
						<th>Maximum Leave in Month</th>
						<th class="actions"><?= __('Actions') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; foreach ($leaveTypes as $leaveType): $i++; ?>
					<tr>
						<td><?= $i ?></td>
						<td><?= h($leaveType->leave_name) ?></td>
						<td><?= $this->Number->format($leaveType->maximum_leave_in_month) ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $leaveType->id],array('escape'=>false,'class'=>'btn btn-xs blue')); ?>
							<?= $this->Form->postLink('<i class="fa fa-trash"></i> ',
								['action' => 'delete', $leaveType->id], 
								[
									'escape' => false,
									'class' => 'btn btn-xs btn-danger',
									'confirm' => __('Are you sure ?', $leaveType->id)
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
