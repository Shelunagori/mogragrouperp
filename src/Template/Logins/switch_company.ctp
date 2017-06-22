
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row">

		<div class="col-md-12">
			<div class="portlet-body">
					<h5>Select Company</h5>
			<div class="table-scrollable">
			
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Sr. No.</th>
						<th>Company</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					 <?php $i=0; foreach ($Employee->companies as $company):  $i++; ?>
					<tr>
						<td><?= h($i) ?></td>
						<td><?= h($company->name) ?></td>
						<td class="actions">
							<?= $this->Form->postLink(__('Select'),'/Logins/SwitchCompany/'.$company->id) ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div>
			</div>
		</div>
		<!-- END FORM-->
	</div>
</div>


