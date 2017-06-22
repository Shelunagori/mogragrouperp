<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Create Login</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-12">
		<?= $this->Form->create($login,array("class"=>"form-horizontal",'autocomplete'=>'off')) ?>
			<div class="form-body">
				<div class="form-group">
					<div class="col-md-3">
						<?php echo $this->Form->input('employee_id', ['options'=>$employees,'label' => false,'class' => 'form-control input-sm select2me']); ?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->input('username', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Username']); ?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->input('password', ['label' => false,'class' => 'form-control input-sm ','placeholder'=>'Password']); ?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->button(__('Create'),['class'=>'btn btn-primary btn-sm']); ?>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		</div>
		<!-- END FORM-->
		</div>
	</div>
</div>


<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Logins</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-12">
			<div class="table-scrollable">
			<table class="table table-hover">
				 <thead>
					<tr>
						<th>Sr. No.</th>
						<th>Name</th>
						<th>Username</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					 <?php $i=0; foreach ($Logins as $Login): $i++; ?>
					<tr>
						<td><?= h($i) ?></td>
						<td><?= h($Login->employee->name) ?></td>
						<td><?= h($Login->username) ?></td>
						<?php if(in_array(20,$allowed_pages)){?>
						<td><?= $this->Html->link(__('UserRights'), ['controller'=>'UserRights','action' => 'add', $Login->id]) ?></td> 
						<?php } ?>
						<td>	<?= $this->Form->postLink('<i class="fa fa-trash"></i> ',
                            								['action' => 'delete', $Login->id],
                            								[
                            									'escape' => false,
                            									'class' => 'btn btn-xs btn-danger',
                            									'confirm' => __('Are you sure ?', $Login->id)
                            								]
                            							) ?></td>
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
		<!-- END FORM-->
		</div>
	</div>
</div>
