<?php //echo @$customer; exit; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Add BE Files</span>
		</div>
		<div class="actions">
			<div class="btn-group">
			<?= $this->Html->link(
				'Add BE Files',
				'/Filenames/Index',
				['class' => 'btn btn-primary']
			); ?>
			<?= $this->Html->link(
				'Add DC Files',
				'/Filenames/Index2',
				['class' => 'btn btn-default']
			); ?>
			</div>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-12">
		<?= $this->Form->create($filename,array("class"=>"form-horizontal")) ?>
			<div class="form-body">
				<div class="form-group">
					<div class="col-md-2">
						<?php $options=['BE'=>'BE'];
						echo $this->Form->input('file1', ['options'=>$options,'label' => false,'class' => 'form-control input-sm']); ?>
					</div>
					<div class="col-md-2">
						<?php echo $this->Form->input('file2', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'File Number','value'=>@$file_inc_be->file2+1]); 
						
						?>
					</div>
					<div class="col-md-3">
					<?php
					$options=array();
							foreach($customers as $custmer){
								if(empty($custmer->alias)){
									$merge=$custmer->customer_name;
								}else{
									$merge=$custmer->customer_name.'	('.$custmer->alias.')';
								}
								
								$options[]=['text' =>$merge, 'value' => $custmer->id, 'employee_id' => $custmer->employee_id,'file' => ($custmer->filenames)];

							}


					echo $this->Form->input('customer_id', ['required','empty' => "--Select--",'options' => $options,'label' => false,'class' => 'form-control input-sm select2me']); ?>

					</div>
					<div class="col-md-3">
						<?php echo $this->Form->button(__('ADD'),['class'=>'btn btn-primary']); ?>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		</div>
		<!-- END FORM-->
		</div>
	</div>
</div>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">BE Files</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		
		<div class="col-md-6">
					<form method="GET" name="form1">
							<table class="table table-condensed">
								<thead>
									<tr>
										<th>FILES</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<div class="row">
												<div class="col-md-4">
													<div class="input-group" style="" id="pnf_text">
														<span class="input-group-addon">BE-</span>
														<input type="text" name="file_number" class="form-control input-sm" placeholder="File Number" value="<?php echo @$file_number; ?>">
													</div>
												</div>
												<div class="col-md-4"> 
													<input type="text" name="customer" class="form-control input-sm" placeholder="Customer" value="<?php echo @$customer; ?>">
												</div>
												<div class="col-md-4">
													<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
					</form>

		<div class="table-scrollable">
		 <?php $page_no=$this->Paginator->current('Filenames'); $page_no=($page_no-1)*20; ?>
			<table class="table table-hover">
				 <thead>
					<tr>
						<th>Sr. No.</th>
						<th width="30%">File</th>
						<th>Customer</th>	
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0;foreach ($BEfilenames as $filename): $i++; ?>
					<tr>
						<td><?= h(++$page_no) ?></td>
						<td><?= h($filename->file1) ?>-<?= h($filename->file2) ?></td>
						<td>
						<?php echo $filename->customer->customer_name.'('; echo $filename->customer->alias.')'; ?></td>
						<td class="actions">
							<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $filename->id], ['confirm' => __('Are you sure you want to delete # {0}?', $filename->id)]) ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div>
			<div class="paginator">
				<ul class="pagination">
					<?= $this->Paginator->prev('<') ?>
					<?= $this->Paginator->numbers() ?>
					<?= $this->Paginator->next('>') ?>
				</ul>
				<p><?= $this->Paginator->counter() ?></p>
			</div>
		</div>
		
		
		<!-- END FORM-->
	</div>
</div>
</div>