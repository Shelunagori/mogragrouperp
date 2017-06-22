<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel">Item opening balance view</span>
		</div>
		
		<div class="actions">
			<?= $this->Html->link(
				'Add',
				'/Items/Cost',
				['class' => 'btn btn-default']
			); ?>
			<?= $this->Html->link(
				'View',
				'/Items/Cost-View',
				['class' => 'btn btn-default']
			); ?>
		</div>
	</div>
	<div class="portlet-body form">
		<?php $page_no=$this->Paginator->current('Items'); $page_no=($page_no-1)*20; ?>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Sr. No.</th>
					<th>Item</th>
					<th>Dynamic Cost</th>
					<th>Minimum Selling Price Factor</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($Items as $Item){ ?>
				<tr>
					<td><?= h(++$page_no) ?></td>
					<td><?= h($Item->name) ?></td>
					<td><?= h($Item['_matchingData']['ItemCompanies']['dynamic_cost']) ?></td>
					<td><?= h($Item['_matchingData']['ItemCompanies']['minimum_selling_price_factor']) ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
