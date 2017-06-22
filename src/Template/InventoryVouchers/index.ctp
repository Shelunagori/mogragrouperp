 
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Inventory Vouchers</span> 
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
							<th>Invoice No</th>
							<th>Customer</th>
							<th class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php  $i=0; foreach ($inventoryVouchers as $inventoryVoucher): $i++;?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							<td><?= h('#'.str_pad($inventoryVoucher->iv_number, 4, '0', STR_PAD_LEFT)) ?></td>

							<td><?php echo $this->Html->link($inventoryVoucher->invoice->in1.'/IN-'.str_pad($inventoryVoucher->invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$inventoryVoucher->invoice->in3.'/'.$inventoryVoucher->invoice->in4,[
							'controller'=>'Invoices','action' => 'confirm',$inventoryVoucher->invoice->id],array('target'=>'_blank')); ?>
							<td><?php echo $inventoryVoucher->invoice->customer->customer_name.'('.$inventoryVoucher->invoice->customer->alias.')' ?></td>
							<?php if(in_array(10,$allowed_pages)){  ?>
							<td>
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit?invoice='.$inventoryVoucher->invoice_id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
							</td>
							<?php } ?>
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


