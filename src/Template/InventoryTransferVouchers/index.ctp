<?php $url_excel="/?".$url; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Inventory Transfer Vouchers</span>
		</div>
		<div class='actions'>
			<?php echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Excel', '/InventoryTransferVouchers/Excel-Export/'.$url_excel.'',['class' =>'btn  green tooltips','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>
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
							
							<td ><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
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
							<th>Action</th>
							
							
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($inventory_transfer_vouchs as $inventory_transfer_vouch_data): $i++; 
						//pr($inventory_transfer_vouch_data); exit;
					?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							<?php if($inventory_transfer_vouch_data->in_out=='in_out'){ ?>
							<td><?= h('ITV-'.str_pad($inventory_transfer_vouch_data->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
							<?php }else if($inventory_transfer_vouch_data->in_out=='in') { ?>
							<td><?= h('ITVI-'.str_pad($inventory_transfer_vouch_data->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
							<?php }else { ?>
							<td><?= h('ITVO-'.str_pad($inventory_transfer_vouch_data->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
							<?php } ?>
							<td><?= h(date("d-m-Y",strtotime($inventory_transfer_vouch_data->transaction_date)))?></td>
							<td>
							<?php if($inventory_transfer_vouch_data->in_out=='Out'){ ?>
							<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'outView', $inventory_transfer_vouch_data->id],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-xs yellow tooltips','data-original-title'=>'View '));  ?>
							<?php }else if($inventory_transfer_vouch_data->in_out=='in') { ?>
							<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'inView', $inventory_transfer_vouch_data->id],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-xs yellow tooltips','data-original-title'=>'View '));  ?>
							<?php }else { ?>
							<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'view', $inventory_transfer_vouch_data->id],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-xs yellow tooltips','data-original-title'=>'View '));  ?>
							<?php } ?>
							
							<?php if($inventory_transfer_vouch_data->in_out=='Out'){ ?>
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'editInventoryOut', $inventory_transfer_vouch_data->id,],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit'));    ?>
							<?php }else if($inventory_transfer_vouch_data->in_out=='in') { ?>
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'editInventoryIn', $inventory_transfer_vouch_data->id,],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit'));   ?>
							<?php }else { ?>
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $inventory_transfer_vouch_data->id,],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit'));  ?>
							<?php } ?>
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
	

