<?php //pr($pettyCashReceiptVouchers); exit; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Receipt Vouchers</span>
		</div>
	
	<div class="portlet-body">
		<div class="row">
		<form method="GET" >
				<table class="table table-condensed">
					<tbody>
						<tr>
							<td width="15%">
								<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction Date From" value="<?php echo @$From; ?>" data-date-format="dd-mm-yyyy" >
							</td>
							<td width="15%">
								<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction Date To" value="<?php echo @$To; ?>" data-date-format="dd-mm-yyyy" >
							</td>
							<td width="10%"> 
								<input type="text" name="vouch_no" class="form-control input-sm" placeholder="Voucher No" value="<?php echo @$vouch_no; ?>">
							</td>
							<td width="10%"><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>

							<td>
								<?php echo $this->Html->link('<i class="fa fa-file-excel-o"></i> Export',['action' => 'ReceiptVoucherExport'],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-primary btn-sm','data-original-title'=>'Export')); ?>
							
							</td>
							</tr>
					</tbody>
				</table>
				</form>
			<div class="col-md-12">
				<?php $page_no=$this->Paginator->current('Receipts'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Transaction Date</th>
							<th>Vocher No</th>
							<th style="text-align:right;">Amount</th>
							<th class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($receipts as $receipt): $i++; 
						
					?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							<td><?= h(date("d-m-Y",strtotime($receipt->transaction_date)))?></td>
							<td><?= h('#'.str_pad($receipt->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
							<td align="right"><?= h($this->Number->format($receipt->receipt_rows[0]->total_cr-$receipt->receipt_rows[0]->total_dr,[ 'places' => 2])) ?></td>
							<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'view', $receipt->id],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-xs yellow tooltips','data-original-title'=>'View ')); ?>
							 <?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $receipt->id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				</div>
			</div>
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
	

