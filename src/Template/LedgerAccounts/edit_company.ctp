<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">EDIT COMPANY FOR : "<?php echo $LedgerAccount_data->name ?>"</span>
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
					</tr>
				</thead>
				<tbody>
				<?php $i=0; foreach ($Company_array as $key=>$Company_array){ $i++;
				$c_namrr=$Company_array1[$key];
				$ledger_id=$Company_array2[$key];
//pr($ledger_id);
				?>
					<tr>
						<td><?= h($i) ?></td>
						<td><?php echo $c_namrr; ?></td>
						<td class="actions">
						 	<?php if($Company_array =='Yes') { ?>
							 <?= $this->Form->postLink('Added ',
								['action' => 'CheckCompany',$ledger_id, $key,],
								[
									'escape' => false,
									'class'=>' blue tooltips','data-original-title'=>'Click To Remove'
									
								]
							) ?>
							<?php  } else { ?>
							<?= $this->Form->postLink(' Removed ',
								['action' => 'AddCompany',$ledgerAccount_id, $key],
								[
									'escape' => false,
									'class'=>' blue tooltips','data-original-title'=>'Click To Add'
									
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

