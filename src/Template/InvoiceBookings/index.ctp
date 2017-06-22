<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Invoice Book</span>
			<?php if($purchase_return=="true"){ echo " :Select Invoice for Purchase Return"; } ?>
		</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
				<form method="GET">
					<table class="table table-condensed">
						<tbody>
							<tr>
								<td width="18%">
									<div class="input-group" style="" id="pnf_text">
									<span class="input-group-addon">IB-No</span><input type="text" name="book_no" class="form-control input-sm" placeholder="Invoice Booking No" value="<?php echo @$book_no; ?>">
									</div>
								</td>
								<td width="9%">
									<input type="text" name="file" class="form-control input-sm" placeholder="IB File" value="<?php echo @$file; ?>">
								</td>
								<td width="15%">
									<div class="input-group" style="" id="pnf_text">
									<span class="input-group-addon">Grn-No</span><input type="text" name="grn_no" class="form-control input-sm" placeholder="Grn No" value="<?php echo @$grn_no; ?>">
									</div>
								</td>
								<td width="5%">
									<input type="text" name="file_grn_no" class="form-control input-sm" placeholder="Grn File" value="<?php echo @$file_grn_no; ?>">
								</td>
								<td width="13%">
									<div class="input-group" style="" id="pnf_text">
									<span class="input-group-addon">IN</span><input type="text" name="in_no" class="form-control input-sm" placeholder="Invoice No" value="<?php echo @$in_no; ?>">
									</div>
								</td>
								<td width="14%">
									<input type="text" name="vendor_name" class="form-control input-sm" placeholder="Supplier Name" value="<?php echo @$vendor_name; ?>">
								</td>
								<td width="10%">
									<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Date From" value="<?php echo @$From; ?>" data-date-format="dd-mm-yyyy" >
								</td>
								<td width="10%">
									<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Date To" value="<?php echo @$To; ?>" data-date-format="dd-mm-yyyy" >
								</td>
								<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
						</tr>
					</tbody>
				</table>
			</form>
			<?php $page_no=$this->Paginator->current('InvoiceBookings'); $page_no=($page_no-1)*20; ?>
				
					<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th width="5%">Sr. No.</th>
							<th width="15%">Invoice Booking No.</th>
							<th width="15%">GRN No.</th>
							<th width="10%">Invoice No.</th>
							<th width="10%">Supplier Name</th>
							<th width="10%">Invoice Booked On</th>
							<th width="10%">Actions</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($invoiceBookings as $invoiceBooking):
						if($invoiceBooking->grn->status=='Converted Into Invoice Booking'){ $tr_color='#f4f4f4'; }
						if($invoiceBooking->grn->status=='Pending'){ $tr_color='#FFF'; }
					?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							<td><?php echo $invoiceBooking->ib1.'/IB-'.str_pad($invoiceBooking->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoiceBooking->ib3.'/'.$invoiceBooking->ib4; ?></td>
							<td><?php echo $this->Html->link( $invoiceBooking->grn->grn1.'/GRN-'.str_pad($invoiceBooking->grn->grn2, 3, '0', STR_PAD_LEFT).'/'.$invoiceBooking->grn->grn3.'/'.$invoiceBooking->grn->grn4,[
							'controller'=>'Grns','action' => 'view', $invoiceBooking->grn->id],array('target'=>'_blank')); ?></td>
							
							<td><?= h($invoiceBooking->invoice_no) ?></td>
							<td><?= h($invoiceBooking->vendor->company_name) ?></td>
							<td><?php echo date("d-m-Y",strtotime($invoiceBooking->created_on)) ?></td>
							<td class="actions">
								<?php if(in_array(18,$allowed_pages)){ ?>
								<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $invoiceBooking->id,],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
								<?php } ?>
								<?php if(in_array(123,$allowed_pages)){ ?>
                                <?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'view', $invoiceBooking->id,],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-xs yellow tooltips','data-original-title'=>'View')); ?>
                                <?php } ?>
								<?php if($purchase_return=="true"  && $invoiceBooking->purchase_return_status=='No'){
								echo $this->Html->link('<i class="fa fa-repeat"></i>  Purchase Return','/PurchaseReturns/Add?invoiceBooking='.$invoiceBooking->id,array('escape'=>false,'class'=>'btn btn-xs default blue-stripe'));
								}elseif($purchase_return=="true" && $invoiceBooking->purchase_return_status=='Yes'){
									echo $this->Html->link('<i class="fa fa-repeat"></i> Edit Purchase Return','/PurchaseReturns/Edit?invoice-booking='.$invoiceBooking->id,array('escape'=>false,'class'=>'btn btn-xs default blue-stripe'));
								} ?> 
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

<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

