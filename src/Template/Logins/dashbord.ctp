
			<!-- END DASHBOARD STATS -->
			<div class="clearfix">
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<!-- BEGIN PORTLET-->
					<div class="portlet light ">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-bar-chart font-green-sharp hide"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Leave Request</span>
							</div>
							<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Employee Name</th>
							<th>No Of Days</th>
							<th class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($leaves as $requestLeave): $i++; 
						
					?>
						<tr>
							<td><?php echo $i; ?></td>
							<td>
							<a href="#" role="button" employee_id='<?php echo $requestLeave->employee_id; ?>' req_id='<?php echo $requestLeave->id; ?>' class="pull-right onhover" >
							<?php echo $requestLeave->employee->name; ?> </a>
							
							
							</td>
							<td><?php echo $requestLeave->no_of_days; ?></td>
							
							<td><?php echo $this->Html->link('Approve',['controller'=>'RequestLeaves','action' => 'approveLeaves', $requestLeave->id],array('escape'=>false,'employee_id'=>$requestLeave->employee_id,'class'=>'btn btn-sm default ','data-original-title'=>'Edit','req_id'=>$requestLeave->id)); 
							echo $this->Html->link('<i class="fa fa-minus-circle">Cancle</i> ',['controller'=>'RequestLeaves','action' => 'cancleLeaves', $requestLeave->id],array('escape'=>false,'class'=>'btn btn-xs red'));
						
							?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				
							
							
						</div>
						<?php ?>
					</div>
					<!-- END PORTLET-->
				</div>
				<div class="col-md-6 col-sm-6">
					<!-- BEGIN PORTLET-->
					<div class="portlet light ">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-share font-red-sunglo hide"></i>
								<span class="caption-subject font-red-sunglo bold uppercase">Loan Request</span>
								
							</div>
							<div class="actions">
								<div class="btn-group">
									
									
								</div>
							</div>
						</div>
						
					</div>
					<!-- END PORTLET-->
				</div>
			</div>
			<div class="clearfix">
	</div>
	
	
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() { 

    $('.onhover').die().live("click",function() { 
		
		var employee_id=$(this).attr('employee_id');
		var id=$(this).attr('req_id');
		open_details(employee_id,id);
	}); 
	
	function open_details(employee_id,id){
		
		$("#result_ajax").html('<div align="center"><?php echo $this->Html->image('/img/wait.gif', ['alt' => 'wait']); ?> Loading</div>');
		var url="<?php echo $this->Url->build(['controller'=>'RequestLeaves','action'=>'showDetails']); ?>";
		url=url+'/'+id+'/'+employee_id,
		
		$("#myModal12").show();
		$.ajax({
			url: url,
		}).done(function(response) {  
			$("#result_ajax").html(response);
		});
    }
	
	$('.closebtn').on("click",function() { 
		$("#myModal12").hide();
    });

});

</script>
<div id="myModal12" class="modal fade in" tabindex="-1"  style="display: none; padding-right: 12px;"><div class="modal-backdrop fade in" ></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" id="result_ajax">
				
			</div>
			<div class="modal-footer">
				<button class="btn default closebtn">Close</button>
			</div>
		</div>
	</div>
</div>
