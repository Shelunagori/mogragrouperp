<?php //pr($customers); exit;?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Break-Up Range For Overdue</span>
		</div>
	</div>

	<div class="portlet-body">
	<form method="get">
	<input type="hidden" name="request" value="<?php echo @$request; ?>">
	</form>
	
		<?= $this->Form->create() ?>
	<div class="row">
	 <div class="col-md-3"></div>
	 <div class="col-md-6">
		<div class="table-scrollable">
			<table width="50%" class="table table-bordered table-striped"  id="main_tble">
					 <thead>
						<tr>
							<th>Range From</th>
							<th>Range To</th>
						</tr>
					 </thead>
					 <tbody>
					 <tr>
						<td>
							<?php echo $this->Form->input('range_0', ['label' => false,'class' => 'form-control input-sm ','tabindex'=>'-1','value'=>'0','readonly'=>'readonly']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('range_1', ['label' => false,'class' => 'form-control input-sm ','placeholder'=>'Enter Range','value'=>'30']); ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php echo $this->Form->input('range_2', ['label' => false,'class' => 'form-control input-sm ','tabindex'=>'-1','readonly'=>'readonly','value'=>'31']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('range_3', ['label' => false,'class' => 'form-control input-sm ','placeholder'=>'Enter Range','value'=>'45']); ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php echo $this->Form->input('range_4', ['label' => false,'class' => 'form-control input-sm ','tabindex'=>'-1','readonly'=>'readonly','value'=>'46']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('range_5', ['label' => false,'class' => 'form-control input-sm ','placeholder'=>'Enter Range','value'=>'60']); ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php echo $this->Form->input('range_6', ['label' => false,'class' => 'form-control input-sm ','tabindex'=>'-1','readonly'=>'readonly','value'=>'61']); ?>
						</td>
						<td>
							<?php echo $this->Form->input('range_7', ['label' => false,'class' => 'form-control input-sm ','placeholder'=>'Enter Range','value'=>'75']); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-md-6"></div>
		<div class="col-md-4">
			<?php echo $this->Form->input('to', ['type' => 'text','label' => false,'class' => 	'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','value' => @date('d-m-Y')]); ?>
		</div>	
		<button type="submit" class="btn btn-primary pull-right">Go</button>
	</div>
</div>
	<?= $this->Form->end() ?>
</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
	$('input[name="range_1"]').die().live("change",function() {
		var range_val=parseInt($('input[name="range_1"]').val());
		var ranges = range_val+1;
		$('input[name="range_2"]').val(ranges);
	});
	$('input[name="range_3"]').die().live("change",function() {
		var range_val=parseInt($('input[name="range_3"]').val());
		var ranges = range_val+1 	;
		$('input[name="range_4"]').val(ranges);
	});
	$('input[name="range_5"]').die().live("change",function() {
		var range_val=parseInt($('input[name="range_5"]').val());
		var ranges = range_val+1 	;
		$('input[name="range_6"]').val(ranges);
	});
	
});
</script>