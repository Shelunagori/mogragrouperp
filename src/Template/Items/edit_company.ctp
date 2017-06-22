<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">EDIT COMPANY FOR : "<?php echo $item_data->name ?>"</span>
		</div>
	</div>
	<div class="portlet-body" >
		
			<div class="row">
			 <div class="col-md-8">
			 <table class="table table-hover">
				 <thead>
					<tr>
						<th width="15%">Sr. No.</th>
						<th width="20%">Company Name</th>
						<th width="10%">Action</th>
						<th width="10%">Freeze</th>
						<th width="10%">Serial Number</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=0; foreach ($Company_array as $key=>$Company_array){ $i++;
				$c_namrr=$Company_array1[$key];
				$bill_to_bill=@$Company_array2[$key];
				$item_serial_no=@$Company_array3[$key];
				?>
					<tr>
						<td><?= h($i) ?></td>
						<td><?php echo $c_namrr; ?></td>
						<td class="actions">
						 	<?php if($Company_array =='Yes') { ?>
							 <?= $this->Form->postLink('Added ',
								['action' => 'CheckCompany', $key,$item_id],
								[
									'escape' => false,
									'class'=>' red tooltips','data-original-title'=>'Click To Remove'
									
								]
							) ?>
							<?php  } else { ?>
							<?= $this->Form->postLink(' Removed ',
								['action' => 'AddCompany', $key,$item_id],
								[
									'escape' => false,
									'class'=>' blue tooltips','data-original-title'=>'Click To Add'
									
								]
							) ?>
							<?php }  ?>
						</td>
						
						<td class="actions">
						 	<?php if($bill_to_bill ==0 && $Company_array=='Yes') { ?>
							 <?= $this->Form->postLink('Unfreezed ',
								['action' => 'ItemFreeze', $key,$item_id,$bill_to_bill="1"],
								[
									'escape' => false,
									'class'=>' blue tooltips','data-original-title'=>'Click To Freeze'
									
								]
							) ?>
							<?php  } else if($Company_array=='Yes')  { ?>
							<?= $this->Form->postLink('Freezed ',
								['action' => 'ItemFreeze', $key,$item_id,$bill_to_bill="0"],
								[
									'escape' => false,
									'class'=>' red tooltips','data-original-title'=>'Click To Unfreeze'
									
								]
							) ?>
							<?php }  ?>
						</td>
						<td class="actions">
						 	<?php if($item_serial_no ==0 && $Company_array=='Yes') { ?>
							 <?= $this->Html->link('Disabled ',
								['action' => 'askSerialNumber',$item_id,$key],
								[
									'escape' => false,
									'class'=>' blue tooltips','data-original-title'=>'Click To Enable'
									
								]
							) ?>
							<?php  } else if($Company_array=='Yes')  { ?>
							<?= $this->Form->postLink(' Enabled ',
								['action' => 'SerialNumberEnabled', $key,$item_id,$item_serial_no="0"],
								[
									'escape' => false,
									'class'=>' red tooltips','data-original-title'=>'Click To Disable'
									
								]
							) ?>
							<?php }  ?>
						</td>	
					</tr>
				<?php  } ?>
				</tbody>
			</table>
		</div>
		
		</div>
		
	</div>
</div>

