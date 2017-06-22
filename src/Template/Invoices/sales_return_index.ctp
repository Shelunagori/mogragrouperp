<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Invoices</span> 
			<?php if($sales_return==true){ echo " :Select invoice for sales return"; } ?>
		</div>
		<div class="portlet-body">
			<div class="row">
				<div class="col-md-12">
					<?php if($status==0){?>
					<form method="GET" >
						<table class="table table-bordered table-striped table-hover">
							<tbody>
								<tr>
									<td width="18%">  
										<input type='hidden' name='sales_return' value='<?php echo $sales_return; ?>' />
										<input type='hidden' name='status' value='1' />
										<div class="input-group" style="" id="pnf_text">
											<span class="input-group-addon">IN-</span><input type="text" name="invoice_no" class="form-control input-sm" placeholder="Invoice No" value="<?php echo @$invoice_no; ?>">
										</div>
									</td>
									<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
								</tr>
							</tbody>
						</table>
					</form>
					<?php } else if($status==1){ 
				$page_no=$this->Paginator->current('Invoices'); $page_no=($page_no-1)*20; ?>
				<form method="GET" >
					<table class="table table-bordered table-striped table-hover">
						<tbody>
							<tr>
								<td width="18%">  
									<input type='hidden' name='sales_return' value='<?php echo $sales_return; ?>' />
									<input type='hidden' name='status' value='1' />
									<div class="input-group" style="" id="pnf_text">
										<span class="input-group-addon">IN-</span><input type="text" name="invoice_no" class="form-control input-sm" placeholder="Invoice No" value="<?php echo @$invoice_no; ?>">
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
							<th width="10%">Invoice No.</th>
							<th width="10%">Sales Order No.</th>
							<th width="12%">Customer</th>
							<th width="8%">Items</th>
							<th width="8%">Created Date</th>
							<th style="text-align:right;" width="10%">Total</th>
							<th width="10%">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($invoices as $invoice): ?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							<td><?= h(($invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4)) ?></td>
							<?php if($invoice->sales_order_id != 0){ ?>
							<td>
							<?php echo $this->Html->link( $invoice->sales_order->so1.'/SO-'.str_pad($invoice->sales_order->so2, 3, '0', STR_PAD_LEFT).'/'.$invoice->sales_order->so3.'/'.$invoice->sales_order->so4,[
							'controller'=>'SalesOrders','action' => 'confirm',$invoice->sales_order->id],array('target'=>'_blank')); ?>
							</td>
							<?php }else{?>
							<td></td><?php } ?>
							<td><?php echo $invoice->customer->customer_name.'('.$invoice->customer->alias.')' ?></td>
							<td>
								<div class="btn-group">
									<button id="btnGroupVerticalDrop5" type="button" class="btn  btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Items <i class="fa fa-angle-down"></i></button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="btnGroupVerticalDrop5">
										<?php  foreach($invoice->invoice_rows as $invoice_row){
											if($invoice_row->invoice_id == $invoice->id){?>
											<li><p><?= h($invoice_row->item->name) ?></p></li>
											<?php }}?>
										</ul>
								</div>
							</td>
							<td><?php echo date("d-m-Y",strtotime($invoice->date_created)); ?></td>
							<td align="right"><?= h($this->Number->format($invoice->total_after_pnf,[ 'places' => 2])) ?></td>
							<td class="actions">
								<?php 
								
								echo $this->Html->link('<i class="fa fa-repeat"></i>  Sale Return','/SaleReturns/Add?invoice='.$invoice->id,array('escape'=>false,'class'=>'btn btn-xs default blue-stripe'));
								if($sales_return=="true" && $invoice->sale_return_status=='Yes'){
									echo $this->Html->link('<i class="fa fa-repeat"></i> Edit Sale Return','/SaleReturns/Edit?invoice='.$invoice->id,array('escape'=>false,'class'=>'btn btn-xs default blue-stripe'));
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