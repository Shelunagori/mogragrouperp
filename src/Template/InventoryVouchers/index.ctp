 <?php $url_excel="/?".$url; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Inventory Vouchers</span> 
		</div>
		<div class='actions'>
			<?php echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Excel', '/InventoryVouchers/Excel-Export/'.$url_excel.'',['class' =>'btn  green tooltips','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>
		</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
			<form method="GET" >
				<input type="hidden" name="pull-request" value="<?php echo @$pull_request; ?>">
				<input type="hidden" name="gst" value="<?php echo @$gst; ?>">
				<input type="hidden" name="job-card" value="<?php echo @$job_card; ?>">
				<table class="table table-condensed">
					<tbody>
						<tr>
							<td width="17%">
								<div class="input-group" id="pnf_text">
									<span class="input-group-addon">IV-</span><input type="text" name="iv_no" class="form-control input-sm" placeholder="Inventory Voucher No" value="<?php echo @$iv_no; ?>">
								</div>
							</td>
							
							
							<td width="15%">
								<input type="text" name="invoice_no" class="form-control input-sm" placeholder="Invoice No." value="<?php echo @$invoice_no; ?>">
							</td>
							
							<td width="13%">
								<input type="text" name="customer" class="form-control input-sm" placeholder="Customer" value="<?php echo @$customer; ?>">
							</td>
							<td width="9%">
								<input type="text" name="From" class="form-control input-sm date-picker" placeholder="From" value="<?php echo @$From; ?>" data-date-format="dd-mm-yyyy" >
							</td>
							<td width="9%">
								<input type="text" name="To" class="form-control input-sm date-picker" placeholder="To" value="<?php echo @$To; ?>" data-date-format="dd-mm-yyyy" >
							</td>
							<td>
								<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
							</td>
						</tr>
					</tbody>
				</table>
				</form>
				<?php $page_no=$this->Paginator->current('InventoryVouchers'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Inventory Voucher No</th>
							<th>Transaction Date</th>
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
							<td><?php if(!empty($inventoryVoucher->transaction_date)){echo date("d-m-Y",strtotime($inventoryVoucher->transaction_date));} ?></td>
							<td><?php 
							if($inventoryVoucher->invoice->invoice_type=="GST"){
							echo $this->Html->link($inventoryVoucher->invoice->in1.'/IN-'.str_pad($inventoryVoucher->invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$inventoryVoucher->invoice->in3.'/'.$inventoryVoucher->invoice->in4,[
							'controller'=>'Invoices','action' => 'gst-confirm',$inventoryVoucher->invoice->id],array('target'=>'_blank')); 
							}else{
								echo $this->Html->link($inventoryVoucher->invoice->in1.'/IN-'.str_pad($inventoryVoucher->invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$inventoryVoucher->invoice->in3.'/'.$inventoryVoucher->invoice->in4,[
								'controller'=>'Invoices','action' => 'confirm',$inventoryVoucher->invoice->id],array('target'=>'_blank')); 
							}
							
							
							?></td>
							<td><?php echo $inventoryVoucher->invoice->customer->customer_name.'('.$inventoryVoucher->invoice->customer->alias.')' ?></td>
							<?php if(in_array(10,$allowed_pages)){  ?>
							<td>
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit?invoice='.$inventoryVoucher->invoice_id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
							<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'view', $inventoryVoucher->id],array('escape'=>false,'class'=>'btn btn-xs yellow tooltips','target'=>'blank','data-original-title'=>'View')); ?>
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


