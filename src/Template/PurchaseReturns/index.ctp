<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Purchase Returns</span> 
			
		</div>
	
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
			<form method="GET" >
				<table class="table table-condensed">
					<tbody>
						<tr>
							<td width="10%">
								<input type="text" name="vouch_no" class="form-control input-sm" placeholder="Voucher No" value="<?php echo @$vouch_no; ?>">
							</td>
							<td width="15%">
								<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Date From" value="<?php echo @$From; ?>"  data-date-format="dd-mm-yyyy" >
							</td>
							<td width="15%">
								<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Date To" value="<?php echo @$To; ?>"  data-date-format="dd-mm-yyyy" >
							</td>
							<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
						</tr>
					</tbody>
				</table>
			</form>
				<?php $page_no=$this->Paginator->current('Invoices'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Voucher No</th>
							<th>Date</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($purchaseReturns as $purchaseReturn): 
						//pr($saleReturn); 
						?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							<td><?= h('#'.str_pad($purchaseReturn->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
							
							<td><?php echo date("d-m-Y",strtotime($purchaseReturn->created_on)); ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'view', $purchaseReturn->id],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-xs yellow tooltips','data-original-title'=>'View ')); 
							echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'Edit?invoiceBooking='.$purchaseReturn->invoice_booking_id,],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
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

