
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
		<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Account Categories</span> 
		</div>
	</div>
		
		
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-6">
				<?php $page_no=$this->Paginator->current('Account Categories'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Name</th>
							</tr>
					
					</thead>
					<tbody>
						   <?php foreach ($accountCategories as $accountCategory): ?>
						<tr>
							<td><?= h(++$page_no) ?></td>
							
							<td><?= h($accountCategory->name) ?></td>
										
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

