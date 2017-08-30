<table class="table table-hover">
				 <thead>
					<tr>
					
					
					<td width="30%">File No:    <?php echo $merge; ?></td>
							
					</tr>
					<tr>
						<th>Sr. No.</th>
						<th>Items</th>	
					</tr>
				</thead>
				<tbody>
					<?php $i=0;
						foreach($showitem as $key=>$showitem): $i++; ?>
					<tr>
						<td><?= h($i) ?></td>
						<td><?php echo $showitem; ?></td>
						
					</tr>
					<?php endforeach; ?>
		</tbody>
</table>