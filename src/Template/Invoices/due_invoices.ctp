<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<span class="caption-subject font-blue-steel ">Invoices for "<?php echo $Customer->customer_name; ?>"</span>
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
							<th>Invoice No.</th>
							<th>Date</th>
							<th>Total After P & F</th>
							<th>Grand Total</th>
							<th>Due Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($invoices as $invoice): ?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							<td><?= h(($invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4)) ?></td>
							<td><?php echo date("d-m-Y",strtotime($invoice->date_created)); ?></td>
							<td><?= h($invoice->total_after_pnf) ?></td>
							<td><?= h($invoice->grand_total) ?></td>
							<td><?= h($invoice->due_payment) ?></td>
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
