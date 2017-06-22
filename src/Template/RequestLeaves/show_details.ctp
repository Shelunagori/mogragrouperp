
	<div class="list-group">
		<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th colspan="2">Total Eligible</th>
						<th colspan="2">Leave taken till date</th>
						
					</tr>
					<tr>
						<th>SL</th>
						<th>CL</th>
						<th>SL</th>
						<th>CL</th>
						
					</tr>
				</thead>
				<tbody>
				<?php foreach ($requestLeaves as $RequestLeave): ?>
					<tr>
						<td>15</td>
						<td>15</td>
						<td><?php echo $RequestLeave->SickLeave; ?></td>
						<td><?php echo $RequestLeave->CasualLeave; ?></td>
						
					</tr>
				<?php endforeach; ?>
				
				</tbody>
			</table>
			
	</div>
