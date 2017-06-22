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
						<th><?= $this->Paginator->sort('segment_description1') ?></th>
						<th><?= $this->Paginator->sort('segment_description2') ?></th>
						<th class="actions"><?= __('Actions') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($customerSegs as $customerSeg): ?>
					<tr>
						<td><?= $this->Number->format($customerSeg->id) ?></td>
						<td><?= h($customerSeg->name) ?></td>
						<td><?= h($customerSeg->segment_description1) ?></td>
						<td><?= h($customerSeg->segment_description2) ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $customerSeg->id],array('escape'=>false,'class'=>'btn btn-xs blue')); ?>
							<?= $this->Form->postLink('<i class="fa fa-trash"></i> ',
								['action' => 'delete', $customerSeg->id], 
								[
									'escape' => false,
									'class' => 'btn btn-xs red',
									'confirm' => __('Are you sure?', $customerSeg->id)
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
