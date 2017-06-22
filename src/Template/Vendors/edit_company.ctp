<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">EDIT COMPANY FOR : "<?php echo $vendor_data->company_name ?>"</span>
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
						<th width="15%">Bill To Bill Account</th>

						
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
								['action' => 'CheckCompany', $key,$vendor_id],
								[
									'escape' => false,
									'class'=>' red tooltips','data-original-title'=>'Click To Remove'
									
								]
							) ?>
							<?php  } else { ?>
							<?= $this->Form->postLink('Removed',
								['action' => 'AddCompany', $key,$vendor_id],
								[
									'escape' => false,
									'class'=>' red tooltips','data-original-title'=>'Click To Add'
									
								]
							) ?>
							<?php }  ?>
						</td>
						<td class="actions">
						 	<?php if($bill_to_bill =='No' && $Company_array=='Yes') { ?>
							 <?= $this->Form->postLink('No ',
								['action' => 'BillToBill', $key,$vendor_id,$bill_to_bill="Yes"],
								[
									'escape' => false,
									'class'=>' red tooltips','data-original-title'=>'Click To Yes'
									
								]
							) ?>
							<?php  } else if($Company_array=='Yes')  { ?>
							<?= $this->Form->postLink(' Yes ',
								['action' => 'BillToBill', $key,$vendor_id,$bill_to_bill="No"],
								[
									'escape' => false,
									'class'=>' red tooltips','data-original-title'=>'Click To No'
									
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

