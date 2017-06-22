<?php //pr($pettyCashReceiptVouchers); exit; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Receipt Vouchers</span>
		</div>
	
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
				<?php $page_no=$this->Paginator->current('Receipts'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Leave Type</th>
							<th>No Of Days</th>
							<th>Remark</th>
							<th>Leave Status</th>
							
							<th class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($requestLeaves as $requestLeave): $i++; 
						
					?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							<td><?= h($requestLeave->leave_type->leave_name) ?></td>
							<td><?php echo $requestLeave->no_of_days; ?></td>
							<td><?= h($requestLeave->remarks) ?></td>
							<?php if($requestLeave->leave_status=='Approve'){ ?>
							<td><span class="label label-sm label-success"><?= h($requestLeave->leave_status) ?></span></td>
							<?php } elseif($requestLeave->leave_status=='Cancle') { ?>
							<td><span class="label label-sm label-danger"><?= h($requestLeave->leave_status) ?></span></td>
							<?php } else { ?>
							<td><span class="label label-sm label-warning"><?= h($requestLeave->leave_status) ?></span></td>
							<?php } ?>
							<td>
							<?php if($requestLeave->leave_status=='In-Process'){ ?>
							<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['controller'=>'RequestLeaves','action' => 'Edit', $requestLeave->id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
							<?php } ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				</div>
			</div>
		</div>
				
			</div>
		</div>
	

