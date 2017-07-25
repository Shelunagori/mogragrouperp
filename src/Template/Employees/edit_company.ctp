<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
<span class="caption-subject font-blue-steel uppercase">EDIT COMPANY FOR : "<?php echo $employe_data->name ?>"</span>		</div>
	</div>
	<div class="portlet-body" >
		
			<div class="row">
			 <div class="col-md-6">
			 <table class="table table-hover">
				 <thead>
					<tr>
						<th width="20%">Sr. No.</th>
						<th>Company Name</th>
						<th width="10%">Action</th>
						<th width="10%">Freeze</th>
						
					</tr>
				</thead>
				<tbody>
				<?php $i=0; foreach ($Company_array as $key=>$Company_array){ $i++;
				$c_namrr=$Company_array1[$key];
				$bill_to_bill=@$Company_array2[$key];
				?>
					<tr>
						<td><?= h($i) ?></td>
						<td><?php echo $c_namrr; ?></td>
						<td class="actions">
						 	<?php if($Company_array =='Yes') { ?>
							 <?= $this->Form->postLink('Added ',
								['action' => 'CheckCompany', $key,$employee_id],
								[
									'escape' => false,
									'class'=>' red tooltips','data-original-title'=>'Click To Remove'
									
								]
							) ?>
							<?php  } else { ?>
							<?= $this->Form->postLink('Removed ',
								['action' => 'AddCompany', $key,$employee_id],
								[
									'escape' => false,
									'class'=>' red tooltips','data-original-title'=>'Click To Add'
									
								]
							) ?>
							<?php }  ?>
						</td>
						<td class="actions">
						 	<?php if($bill_to_bill =='No' && $Company_array=='Yes') { ?>
							 <?= $this->Form->postLink('Unfreezed ',
								['action' => 'EmployeeFreeze', $key,$employee_id,$bill_to_bill="1"],
								[
									'escape' => false,
									'class'=>' blue tooltips','data-original-title'=>'Click To Freeze'
									
								]
							) ?>
							<?php  } else if($Company_array=='Yes')  { ?>
							<?= $this->Form->postLink(' Freezed ',
								['action' => 'EmployeeFreeze', $key,$employee_id,$bill_to_bill="0"],
								[
									'escape' => false,
									'class'=>' blue tooltips','data-original-title'=>'Click To Unfreeze'
									
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

<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
	
});
</script>