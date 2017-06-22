<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Invoice Book</span>
			<?php if($purchase_return=="true"){ echo " :Select Invoice for Purchase Return"; } ?>
		</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12"><?php if($status==0){?>
				<form method="GET">
					<table class="table table-condensed">
						<tbody>
							<tr>
								<td width="18%">
									<div class="input-group" style="" id="pnf_text">
									<span class="input-group-addon">IB-No</span><input type="text" name="book_no" class="form-control input-sm" placeholder="Invoice Booking No" value="<?php echo @$book_no; ?>">
									</div>
								</td>
								<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
						</tr>
					</tbody>
				</table>
			</form>
			<?php } else if($status==1){ 
			 $page_no=$this->Paginator->current('InvoiceBookings'); $page_no=($page_no-1)*20; ?>
				<form method="GET">
					<table class="table table-condensed">
						<tbody>
							<tr>
								<td width="18%">
									<input type='hidden' name='status' value='1' />
									<div class="input-group" style="" id="pnf_text">
									<span class="input-group-addon">IB-No</span><input type="text" name="book_no" class="form-control input-sm" placeholder="Invoice Booking No" value="<?php echo @$book_no; ?>">
									</div>
								</td>
								<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
						</tr>
					</tbody>
				</table>
			</form>
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
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>	