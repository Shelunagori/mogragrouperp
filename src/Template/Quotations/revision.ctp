<tr>
	<td colspan="7">
	<table class="table">
		<tbody>
		<?php $i=0; foreach ($quotations as $quotation): $i++;?>
			
			<tr>
			<td ><?php echo ' (#R'.$quotation->revision.' )'; ?></td>
			<td colspan="2"><?= h($quotation->customer->customer_name) ?></td>
			<td><?= h($quotation->employee->name) ?></td>
			<td><?= h($quotation->item_group->name) ?></td>
			<td><?php echo date("d-m-Y",strtotime($quotation->finalisation_date)); ?></td>
			<td class="actions">
				<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'confirm', $quotation->id],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-xs default tooltips','data-original-title'=>'View as PDF')); ?>
			</td>
			</tr>
		<?php endforeach; ?>
	</table>
	</td>
</tr>