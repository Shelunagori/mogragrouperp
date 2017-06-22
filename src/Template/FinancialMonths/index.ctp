
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Financial Months</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		
			<div class="portlet-body">
			<div class="row">
			<div class="col-md-12">
				
			<div class="table-scrollable">
			<table class="table table-hover">
				 <thead>
					<tr>
						<th><?php echo 'S.No'; ?></th>
						<th><?php echo 'Month'; ?></th>
						<th><?php echo 'Year'; ?></th>
						<th><?php echo 'Status'; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
					 <?php $i=0; $count=1; $j=1; foreach ($financialMonths as $financialMonth): 
						
							if($financialMonth->status=='Closed'){
								$count++;
							}
							
							$month = substr($financialMonth->month,0,2);
							$year = substr($financialMonth->month,3,6);
							$monthName = date('F', mktime(0, 0, 0, $month,10)); 
					 ?>
					<tr>
						<td><?= ++$i ?></td>
						<td><?= h($monthName)?>
						<td><?= h($year)?></td>
						<td><?= h($financialMonth->status) ?></td>
						<td class="actions">
						<?php if($financialMonth->status=='Open'){
							if(($count>=$i) && (($l_year_status=='Closed')|| ($l_year_status==' '))){
								echo $this->Form->postLink('<i class="fa fa-minus-circle"> Closed</i> ',['action' =>'closed', $financialMonth->id],['escape' => false,'class' => 'btn btn-xs red tooltips','data-original-title'=>'Closed','confirm' => __('Are you sure, you want to Closed ?', $financialMonth->id)]
								);
							}
						} ?>
						
						<?php if(($financialMonth->status=='Closed') && (($l_year_status=='Closed')|| ($l_year_status==' '))){
							if($financialMonth->id == $l_close){
								echo $this->Form->postLink('<i class="fa fa-plus-circle"> Open</i> ',['action' =>'open', $financialMonth->id],['escape' => false,'class' => 'btn btn-xs green tooltips','data-original-title'=>'Opened','confirm' => __('Are you sure, you want to Open ?', $financialMonth->id)]
							);
							}
							else{
								echo ' ';
							}	
								
									
						} ?>
						</td>
					</tr>
            <?php endforeach; ?>
				</tbody>
			</table>
			</div>
			<div class="paginator">
				<ul class="pagination">
					<?= $this->Paginator->prev('<') ?>
					<?= $this->Paginator->numbers() ?>
					<?= $this->Paginator->next('>') ?>
				</ul>
				<p><?= $this->Paginator->counter() ?></p>
			</div>
			</div>
		</div>
		<!-- END FORM-->
	</div>
</div>
</div>
