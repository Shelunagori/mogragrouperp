<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">User Logs</span>
		</div>
	</div>
	<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3"  style="width: 20%;" >
	<div class="portlet-body">
		<div class="table-scrollable">
		<?php $page_no=$this->Paginator->current('Customers'); $page_no=($page_no-1)*20; ?>
			 <table class="table table-bordered table-striped table-hover" id="main_tble">
				 <thead>
					<tr>
						<th>Sr. No.</th>
						<th>Employee Name</th>
						<th>Login Time</th>
						
					</tr>
				</thead>
				<tbody>
					<?php $i=0; foreach ($userLogs as $userlog): $i++; 	 ?>
					<tr>
						<td><?= h(++$page_no) ?></td>
						<td><?= h($userlog->login->employee->name) ?></td>
						<td><?php echo date("d-m-Y h:i:s A" ,strtotime($userlog->datetime)); ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		 <div class="paginator">
			<ul class="pagination">
				<?= $this->Paginator->prev('< ' . __('previous')) ?>
				<?= $this->Paginator->numbers() ?>
				<?= $this->Paginator->next(__('next') . ' >') ?>
			</ul>
			<p><?= $this->Paginator->counter() ?></p>
		</div>
	</div>
</div>

<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
var $rows = $('#main_tble tbody tr');
	$('#search3').on('keyup',function() {
	
			var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    		var v = $(this).val();
    		if(v){ 
    			$rows.show().filter(function() {
    				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
		
    				return !~text.indexOf(val);
    			}).hide();
    		}else{
    			$rows.show();
    		}
    	});
});
</script>
