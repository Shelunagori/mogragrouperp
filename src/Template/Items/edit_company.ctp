<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">EDIT COMPANY FOR : "<?php echo $item_data->name ?>"</span>
		</div>
	</div>
	<div class="portlet-body" >
		
			<div class="row">
			 <div class="col-md-12">
			 <table class="table table-hover" id='main_table'>
				 <thead>
					<tr>
						<th width="15%">Sr. No.</th>
						<th width="20%">Company Name</th>
						<th width="10%">Action</th>
						<th width="10%">Freeze</th>
						<th width="10%">Serial Number</th>
						<th width='10%'>Min. Selling Factor</th>
						<th width='10%'>Minimum Stock</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=0; foreach ($Company_array as $key=>$Company_array){ $i++;
				$c_namrr=$Company_array1[$key];
				$bill_to_bill=@$Company_array2[$key];
				$item_serial_no=@$Company_array3[$key];
				$selling_factor=@$Company_array4[$key];
				$stock=@$Company_array5[$key];
				?>
					<tr class='main_tr'>
						<input type='hidden' class='form-control item_id' value='<?php echo $item_data->id ?>'>
						<td><?= h($i) ?></td>
						<td><?php echo $c_namrr; ?>
							<input type='hidden' class='company_id' value='<?php echo $key; ?>'>
						</td>
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
						<td>
						<?php if($Company_array=='Yes') {
							 echo $this->Form->input('minimum_selling_price_factor', ['type' => 'text','style'=>'width:65%;','label' => false,'class' => 'form-control input-sm selling_factor','value'=>$selling_factor]); 
						}?>
						</td>
						<td>
						<?php if($Company_array=='Yes') { ?>
							<?php echo $this->Form->input('minimum_stock', ['type' => 'text','style'=>'width:65%;','label' => false,'class' => 'form-control input-sm min_stock','value'=>$stock]); 
						}?>	
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
	$('.min_stock').live("blur",function() {
		var sel=$(this).closest('tr.main_tr');
		var min_stock =sel.find('.min_stock').val();
		var company_id =sel.find('.company_id').val();
		var item_id =$('.item_id').val();
		
		var url="<?php echo $this->Url->build(['controller'=>'Items','action'=>'updateMinStock']); ?>";
		url=url+'/'+item_id+'/'+min_stock+'/'+company_id,
			$.ajax({
				url: url,
				type: 'GET',
			}).done(function(response) {
				
				//alert("Save Minimum Stock");
			});
	});
	/////minimum_selling_price_factor//////
	$('.selling_factor').live("blur",function() {
		var sel=$(this).closest('tr.main_tr');
		var selling_factors =sel.find('.selling_factor').val();
		var company_id =sel.find('.company_id').val();
		var item_id =$('.item_id').val();
		
		var url="<?php echo $this->Url->build(['controller'=>'Items','action'=>'updateMinSellingFactor']); ?>";
		url=url+'/'+item_id+'/'+selling_factors+'/'+company_id,
			$.ajax({
				url: url,
				type: 'GET',
			}).done(function(response) {
				
				//alert("Save Minimum Selling Factor");
			});
	});
});
</script>
