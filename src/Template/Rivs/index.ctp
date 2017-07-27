 
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Inventory Vouchers</span> 
		</div>
		<div class="actions">
			<?php  /* echo $this->Html->link('<i class="fa fa-puzzle-piece"></i> Pending',array('controller'=>'Rivs','action'=>'Pending'),array('escape'=>false,'class'=>'btn btn-primary')); */ ?>
				
		</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
				<?php $page_no=$this->Paginator->current('materialIndents'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Inventory Voucher No</th>
							<th>Sales Return No</th>
							<th class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php  $i=0; foreach ($rivs as $riv): $i++;?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							<td><?= h('#'.str_pad($riv->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>

							<td><?= h($riv->sale_return->sr1.'/SR-'.str_pad($riv->sale_return->sr2, 3, '0', STR_PAD_LEFT).'/'.$riv->sale_return->sr3.'/'.$riv->sale_return->sr4); ?>
							<td>
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit/'.$riv->id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
							<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'view', $riv->id],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-xs yellow tooltips','data-original-title'=>'View ')); ?>
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
<style>
#sortable li{
	cursor: -webkit-grab;
}
</style>
<?php echo $this->Html->css('/drag_drop/jquery-ui.css'); ?>


