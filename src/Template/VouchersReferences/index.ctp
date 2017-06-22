
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Vouchers</span>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Voucher</th>
							<th>Discription</th>
							<th class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach($vouchersReferences as $vouchersReference): $i++;
							$groups=[];
						?>
						<tr>
							<td><?= h($i) ?></td>
							<td><?= h($vouchersReference->voucher_entity) ?></td>
							<td><?= h($vouchersReference->description) ?></td>
							
							<td class="actions">
							<?php if(in_array(119,$allowed_pages)){ ?>
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $vouchersReference->id],array('escape'=>false,'class'=>'btn btn-xs blue')); ?>
							<?php } ?>
							</td>
							
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
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
</div>
