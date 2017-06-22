<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Pending Item For Inventory Voucher</span>
			
		</div>
		
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
				
				<?php $page_no=$this->Paginator->current('Invoices'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Inoice No.</th>
							<th>Item Name</th>
							<th>Action</th>
							
						</tr>
					</thead>
					<tbody>
						<?php foreach ($invoices as $invoice_rows): ?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							
							<td><?= h(($invoice_rows->invoice->in1.'/IN-'.str_pad($invoice_rows->invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice_rows->invoice->in3.'/'.$invoice_rows->invoice->in4)) ?></td>
							<td><?= h($invoice_rows->item->name) ?></td>
							<td class="actions">
								<?php echo $this->Html->link('<i class=" "></i>  Create Inventory Voucher',['controller'=>'InventoryVouchers','action' => '/add', $invoice_rows->invoice->id, $invoice_rows->id ],array('escape'=>false,'class'=>'','data-original-title'=>'Inventory Voucher')); ?>
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
