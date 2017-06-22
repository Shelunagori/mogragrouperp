<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-comments"></i>Districts
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse" data-original-title="" title="">
			</a>
			<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="">
			</a>
			<a href="javascript:;" class="reload" data-original-title="" title="">
			</a>
			<a href="javascript:;" class="remove" data-original-title="" title="">
			</a>
		</div>
	</div>
	<div class="portlet-body">
		<div class="table-scrollable">
			 <table class="table table-hover">
				 <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('state') ?></th>
                <th><?= $this->Paginator->sort('district') ?></th>
                <th><?= $this->Paginator->sort('district_description') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($districts as $district): ?>
            <tr>
                <td><?= $this->Number->format($district->id) ?></td>
                <td><?= h($district->state) ?></td>
                <td><?= h($district->district) ?></td>
                <td><?= h($district->district_description) ?></td>
                <td class="actions">
					<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $district->id],array('escape'=>false,'class'=>'btn btn-xs blue')); ?>
					<?= $this->Form->postLink('<i class="fa fa-trash"></i> ',
						['action' => 'delete', $district->id], 
						[
							'escape' => false,
							'class' => 'btn btn-xs btn-danger',
							'confirm' => __('Are you sure, you want to delete {0}?', $district->id)
						]
					) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
			</table>
			
		</div>
		 
	</div>
</div>