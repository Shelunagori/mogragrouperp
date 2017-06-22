<div class="portlet light bordered">
<div class="portlet-title">
	<div class="caption">
		<i class="icon-globe font-blue-steel"></i>
		<span class="caption-subject font-blue-steel uppercase">Job Cards</span>
	</div>
	<div class="actions">
		<?php
			if($status==null or $status=='Pending'){ $class1='btn btn-primary'; }else{ $class1='btn btn-default'; }
			if($status=='Closed'){ $class3='btn btn-primary'; }else{ $class3='btn btn-default'; }
			?>
		<?= $this->Html->link(
			'Pending',
			'/JobCards/index/Pending',
			['class' => $class1]
		); ?>
		<?= $this->Html->link(
			'Closed',
			'/JobCards/index/Closed',
			['class' => $class3]
		); ?>
	</div>
<div class="portlet-body">
	<div class="row">
		<div class="col-md-12">
			<form method="GET" >
				<input type="hidden">
				<table class="table table-condensed">
					<tbody>
					<tr>
							<td>
								<div class="input-group" >
											<span class="input-group-addon">JC-</span><input type="text" name="jc_no" class="form-control input-sm" placeholder="JC No" value="<?php echo @$jc_no; ?>"></div>
										
									</td>
									<td>
										<input type="text" name="jc_file_no" class="form-control input-sm" placeholder="File" value="<?php echo @$jc_file_no; ?>">
									</td>
									
							<td>
										<div class="input-group" >
											<span class="input-group-addon">SO-</span><input type="text" name="so_no" class="form-control input-sm" placeholder="SO No" value="<?php echo @$so_no; ?>">
										</div>
									</td>
									<td>
										<input type="text" name="so_file_no" class="form-control input-sm" placeholder="File" value="<?php echo @$so_file_no; ?>">
									</td>
									
								<td>
										<input type="text" name="Required_From" class="form-control input-sm date-picker" placeholder="Required From" value="<?php echo @$Required_From; ?>" data-date-format="dd-mm-yyyy" >
									</td><td>
										<input type="text" name="Required_To" class="form-control input-sm date-picker" placeholder="Required To" value="<?php echo @$Required_To; ?>" data-date-format="dd-mm-yyyy" >
									</td>
							<td>
								
										<input type="text" name="Created_From" class="form-control input-sm date-picker" placeholder="Created From" value="<?php echo @$Created_From; ?>" data-date-format="dd-mm-yyyy" >
									</td>
									<td>
										<input type="text" name="Created_To" class="form-control input-sm date-picker" placeholder="Created To" value="<?php echo @$Created_To; ?>" data-date-format="dd-mm-yyyy" >
									
							</td>
							
							<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
						</tr>
					</tbody>
				</table>
			</form>
		
			<?php $page_no=$this->Paginator->current('JobCards'); $page_no=($page_no-1)*20; ?>	 
			<table class="table table-bordered table-striped table-hover ">
				<thead>
				<tr>
					<th >Sr.No.</th>
					<th>Job Card No.</th>
					<th>Sales Order</th>
					<th>Required Date</th>
					<th>Created Date</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
		    <?php foreach ($jobCards as $jobCard): ?>
				<tr>
					<td><?= h(++$page_no) ?></td>
					<td><?= h(($jobCard->jc1.'/JC-'.str_pad($jobCard->jc2, 3, '0', STR_PAD_LEFT).'/'.$jobCard->jc3.'/'.$jobCard->jc4))?></td>
					<td><?= h(($jobCard->sales_order->so1.'/SO-'.str_pad($jobCard->sales_order->so2, 3, '0', STR_PAD_LEFT).'/'.$jobCard->sales_order->so3.'/'.$jobCard->sales_order->so4))?></td> 
 					<td><?= date("d-m-Y",strtotime($jobCard->required_date));?></td>
					<td><?= date("d-m-Y",strtotime($jobCard->created_on));?></td>
					<td class="actions">
					<?php if(in_array(24,$allowed_pages)){ ?>
					<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'view', $jobCard->id],array('escape'=>false,'class'=>'btn btn-xs yellow tooltips','target'=>'blank','data-original-title'=>'View')); ?>
					<?php } ?>
					<?php if(in_array(6,$allowed_pages)){  ?>
					<?php
					if(!in_array(date("m-Y",strtotime($jobCard->created_on)),$closed_month))
					{ 
					echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $jobCard->id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
					<?php } } ?>

				
					<?php if(in_array(34,$allowed_pages)) {?>

					<?php if($status==null or $status=='Pending'){ ?>
					<?= $this->Form->postLink('Close',
						['action' => 'close', $jobCard->id], 
						[
							'escape' => false,
							'class'=>'btn btn-xs red tooltips','data-original-title'=>'Close',
							'confirm' => __('Are you sure ?')
						]
					) ?>
					<?php } } ?>
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
 
 