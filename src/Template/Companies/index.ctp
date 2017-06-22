<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Companies</span>
		</div>
	
<div class="portlet-body">
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="5%">Sr.No.</th>
						<th width="20%">Name</th> 
						<th width="8%">Pan No</th>
						<th width="10%">Tin No</th>
						<th width="10%">Tan No</th>
						<th width="10%">Landline No</th>
						<th width="10%">Mobile No</th>
						<th width="10%"> Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; foreach ($companies as $company): $i++; ?>
					<tr>
						<td><?= $i ?></td>
						<td><?= h($company->name) ?></td>
						<td><?= h($company->pan_no) ?></td>
						<td><?= h($company->tin_no) ?></td>
						<td><?= h($company->tan_no) ?></td>
						<td><?= h($company->landline_no) ?></td>
						<td><?= h($company->mobile_no) ?></td>
						<td class="actions">
						<?php if(in_array(59,$allowed_pages)){ ?>
							<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'view', $company->id],array('escape'=>false,'class'=>'btn btn-xs yellow tooltips','data-original-title'=>'View')); ?>
						<?php } ?>
						<?php if(in_array(60,$allowed_pages)){ ?>
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $company->id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
							 <?= $this->Form->postLink('<i class="fa fa-trash"></i> ',
								['action' => 'delete', $company->id], 
								[
									'escape' => false,
									'class'=>'btn btn-xs red tooltips','data-original-title'=>'Delete',
									
									'confirm' => __('Are you sure ?', $company->id)
								]
							) ?>
						<?php } ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div>
	</div>
	</div></div>
	<div class="paginator">
		<ul class="pagination">
		<?= $this->Paginator->prev('< ' . __('previous')) ?>
		<?= $this->Paginator->numbers() ?>
		<?= $this->Paginator->next(__('next') . ' >') ?>
		</ul>
		<p><?= $this->Paginator->counter() ?></p>
	</div>
		
	</div>
