<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">CUSTOMERS</span>
		</div>
	</div>
	<div class="portlet-body">
		<div class="table-scrollable">
			<form method="GET" >
				<table class="table table-condensed">
				
				<tbody>
					<tr>
						<td><input type="text" name="customer" class="form-control input-sm" placeholder="Customer Name" value="<?php echo @$customer; ?>"></td>
						<td><input type="text" name="district" class="form-control input-sm" placeholder="District" value="<?php echo @$district; ?>"></td>
						<td><input type="text" name="customer_seg" class="form-control input-sm" placeholder="Customer Seg" value="<?php echo @$customer_seg; ?>"></td>
						<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
					</tr>
				</tbody>
			</table>
			</form>
			<?php $page_no=$this->Paginator->current('Customers'); $page_no=($page_no-1)*20; ?>
			 <table class="table table-hover">
				 <thead>
					<tr>
						<th width="3%">Sr. No.</th>
						<th>Customer Name</th>
						<th width="10%">District</th>
						<th width="10%">Customer Seg</th>
						<th width="10%">Tin No</th>
						<th width="10%">Gst No</th>
						<th width="13%">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; foreach ($customers as $customer): $i++; ?>
					<tr>
						<td><?= h(++$page_no) ?></td>
						<td><?php echo $customer->customer_name.'('; echo $customer->alias.')'; ?></td>
						<td><?= h($customer->district->district) ?></td>
						<td><?= h($customer->customer_seg->name) ?></td>
						<td><?= h($customer->tin_no) ?></td>
						<td><?= h($customer->gst_no) ?></td>
						<td class="actions">
							<?php if(in_array(43,$allowed_pages)){?>
						 	<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'view', $customer->id],array('escape'=>false,'class'=>'btn btn-xs yellow tooltips','data-original-title'=>'View')); ?>
							<?php } ?>
							<?php if(in_array(44,$allowed_pages)){?>
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $customer->id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
							
							 <!--<?= $this->Form->postLink('<i class="fa fa-trash"></i> ',
								['action' => 'delete', $customer->id], 
								[
									'escape' => false,
									'class'=>'btn btn-xs red tooltips','data-original-title'=>'Delete',
									
									'confirm' => __('Are you sure ?', $customer->id)
								]
							) ?>!-->
							<?php } ?>
							<?php if(in_array(45,$allowed_pages)){?>
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'EditCompany', $customer->id],array('escape'=>false,'class'=>'btn btn-xs green tooltips','data-original-title'=>'EditCompany')); ?>
							<?php } ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
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