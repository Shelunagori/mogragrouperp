<?php //pr($SalesOrders); exit; ?>


<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption">
    <i class="icon-globe font-blue-steel"></i>
	<span class="caption-subject font-blue-steel uppercase">Pending Sales Order To Create Job Cards</span> 
</div>
<div class="portlet-body">
	<div class="row">
		<div class="col-md-12">
		<form method="GET" >
				
				<table class="table table-condensed">
					<tbody>
						<tr>
							<td>
								
										<div class="input-group" id="pnf_text">
											<span class="input-group-addon">SO-</span><input type="text" name="sales_order_no" class="form-control input-sm" placeholder="Sales Order No" value="<?php echo @$sales_order_no; ?>">
										</div>
									</td>
									<td>
										<input type="text" name="file" class="form-control input-sm" placeholder="File" value="<?php echo @$file; ?>">
									</td>
							<td><input type="text" name="customer" class="form-control input-sm" placeholder="Customer" value="<?php echo @$customer; ?>"></td>
							<td>
								
										<input type="text" name="From" class="form-control input-sm date-picker" placeholder="From" value="<?php echo @$From; ?>" data-date-format="dd-mm-yyyy" >
									</td>
									<td>
										<input type="text" name="To" class="form-control input-sm date-picker" placeholder="To" value="<?php echo @$To; ?>" data-date-format="dd-mm-yyyy" >
									
							</td>
							<td><input type="text" name="po_no" class="form-control input-sm" placeholder="PO No." value="<?php echo @$po_no; ?>"></td>
							<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
						</tr>
					</tbody>
				</table>
				</form>
			<?php $page_no=$this->Paginator->current('JobCards'); $page_no=($page_no-1)*20; ?>	 
			<table class="table table-bordered table-striped ">
				<thead>
				<tr>
					<th >Sr.No.</th>
					<th>Sales Order</th>
					<th>Customer</th>
					<th>Date</th>
					<th>PO No.</th>
					<th>Action</th>
				</tr></thead>
				<tbody>
		    <?php foreach ($SalesOrders as $SalesOrder): ?>
				<tr>
					<td><?= h(++$page_no) ?></td>
					<td><?= h(($SalesOrder->so1.'/SO-'.str_pad($SalesOrder->so2, 3, '0', STR_PAD_LEFT).'/'.$SalesOrder->so3.'/'.$SalesOrder->so4))?></td> 
					<td><?php echo $SalesOrder->customer->customer_name; ?></td> 
					<td><?php echo date("d-m-Y",strtotime($SalesOrder->po_date)); ?></td> 
					<td><?php echo $SalesOrder->customer_po_no; ?></td> 
					
					<td class="actions">
						<?php if(sizeof($SalesOrder->job_card)==0){
							if(sizeof($SalesOrder->sales_order_rows)>0){
								echo $this->Html->link('<i class="fa fa-repeat "></i>  Create Job Card','/JobCards/Pre-Add?sales-order='.$SalesOrder->id,array('escape'=>false,'class'=>'btn btn-xs default blue-stripe'));
							}else{
								echo $this->Html->link('<i class="fa fa-repeat "></i>  Create Job Card','/JobCards/Add?sales-order='.$SalesOrder->id,array('escape'=>false,'class'=>'btn btn-xs default blue-stripe'));
							}
						}else{
							if(sizeof($SalesOrder->sales_order_rows)>0){
								echo $this->Html->link('<i class="fa fa-repeat "></i>  Edit Job Card','/JobCards/Pre-Edit?job-card='.$SalesOrder->job_card->id.'&sales-order='.$SalesOrder->id,array('escape'=>false,'class'=>'btn btn-xs default blue-stripe'));
							}else{
								echo $this->Html->link('<i class="fa fa-repeat "></i> Edit Job Card',['action' => 'edit', $SalesOrder->job_card->id],array('escape'=>false,'class'=>'btn btn-xs default blue-stripe'));
							}
						} ?>
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
 
 