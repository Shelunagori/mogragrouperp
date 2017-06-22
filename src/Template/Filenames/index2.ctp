<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Add DC Files</span>
		</div>
		<div class="actions">
			<div class="btn-group">
			<?= $this->Html->link(
				'Add BE Files',
				'/Filenames/Index',
				['class' => 'btn btn-default']
			); ?>
			<?= $this->Html->link(
				'Add DC Files',
				'/Filenames/Index2',
				['class' => 'btn btn-primary']
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
						<?php $options=['DC'=>'DC'];
						echo $this->Form->input('file1', ['options'=>$options,'label' => false,'class' => 'form-control input-sm']); ?>
					</div>
					<div class="col-md-2">
						<?php echo $this->Form->input('file2', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'File Number','value'=>@$file_inc_dc->file2+1]); 
						
						?>
					</div>
					<div class="col-md-3">
						<?php 
						$options=array();
							foreach($customers as $customer){
								if(empty($customer->alias)){
									$merge=$customer->customer_name;
								}else{
									$merge=$customer->customer_name.'	('.$customer->alias.')';
								}
								
								$options[]=['text' =>$merge, 'value' => $customer->id, 'employee_id' => $customer->employee_id,'file' => ($customer->filenames)];

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
			<span class="caption-subject font-blue-steel uppercase">DC Files</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		
		<div class="col-md-6">
						<form method="GET" name="form2" >
								<table class="table table-condensed">
									<thead>
										<tr>
											<th>FILES</th>
											<th></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<div class="row">
												<div class="col-md-4">
													<div class="input-group" style="" id="pnf_text">
														<span class="input-group-addon">DC-</span>
														<input type="text" name="file_number" class="form-control input-sm" placeholder="File Number" value="<?php echo @$file2_second; ?>">
													</div>
												</div>
												<div class="col-md-4">
													<input type="text" name="customer" class="form-control input-sm" placeholder="Customer" value="<?php echo @$customer2; ?>">
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
						<th>File</th>
						<th>Customer</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0;foreach ($DCfilenames as $filename): $i++; ?>
					<tr>
						<td><?= h(++$page_no) ?></td>
						<td><?= h($filename->file1) ?>-<?= h($filename->file2) ?></td>
						<td><?= h($filename->customer->customer_name) ?></td>
						<td class="actions">
							<?= $this->Form->postLink(__('Delete'), ['action' => 'delete2', $filename->id], ['confirm' => __('Are you sure you want to delete # {0}?', $filename->id)]) ?>
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