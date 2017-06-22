<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-comments"></i>Company Groups
		</div>
	</div>
	<div class="portlet-body">
		<div class="table-scrollable">
			 <table class="table table-hover">
				<thead>
					<tr>
						<th><?= $this->Paginator->sort('id') ?></th>
						<th><?= $this->Paginator->sort('name') ?></th>
						<th class="actions"><?= __('Actions') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($companyGroups as $companyGroup): ?>
					<tr>
						<td><?= $this->Number->format($companyGroup->id) ?></td>
						<td><?= h($companyGroup->name) ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $companyGroup->id],array('escape'=>false,'class'=>'btn btn-xs btn-primary')); ?>
							<?= $this->Form->postLink('<i class="fa fa-trash"></i> ',
									['action' => 'delete', $companyGroup->id], 
									[
										'escape' => false,
										'class' => 'btn btn-xs btn-danger',
										'confirm' => __('Are you sure?', $companyGroup->id)
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
				<?= $this->Paginator->prev('< ' . __('previous')) ?>
				<?= $this->Paginator->numbers() ?>
				<?= $this->Paginator->next(__('next') . ' >') ?>
			</ul>
			<p><?= $this->Paginator->counter() ?></p>
		</div>
	</div>
</div>