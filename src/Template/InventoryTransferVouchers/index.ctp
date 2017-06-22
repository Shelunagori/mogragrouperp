<?php //pr($pettyCashReceiptVouchers); exit; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Inventory Transfer Vouchers</span>
		</div>
	
	<div class="portlet-body">
		<div class="row">
		<form method="GET" >
				<table class="table table-condensed">
					<tbody>
						<tr>
							
							<td width="20%"> 
								<input type="text" name="vouch_no" class="form-control input-sm" placeholder="Voucher No" value="<?php echo @$vouch_no; ?>">
							</td>
							<td width="20%">
								<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction Date From" value="<?php echo @$From; ?>" data-date-format="dd-mm-yyyy" >
							</td>
							<td width="20%">
								<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction Date To" value="<?php echo @$To; ?>" data-date-format="dd-mm-yyyy" >
							</td>
							
							<td width="10%"><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
						</tr>
					</tbody>
				</table>
				</form>
			<div class="col-md-12">
				<?php $page_no=$this->Paginator->current('InventoryTransferVouchers'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Vocher No</th>
							<th>Transaction Date</th>
							
							
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($inventory_transfer_vouchs as $inventory_transfer_vouch_data): $i++; 
						
					?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							<td><?= h('#'.str_pad($inventory_transfer_vouch_data->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
							<td><?= h(date("d-m-Y",strtotime($inventory_transfer_vouch_data->transaction_date)))?></td>
							
						
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
	

