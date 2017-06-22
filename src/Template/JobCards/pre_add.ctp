<?php //pr($jobCard); exit; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel ">Define Item Source for "Purchessed/Manufactured" items.</span>
		</div>
		
	</div>
	
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= $this->Form->create($jobCard,['id'=>'form_sample_3']) ?>
			<div class="form-body">

			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-5 control-label">Sales Order No</label>
						<div class="col-md-7">
							
							<?= h($jobCard->so1.'/'.str_pad($jobCard->so2, 3, '0', STR_PAD_LEFT).'/'.$jobCard->so3.'/'.$jobCard->so4) ?>
							
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-5 control-label">Customer Name </label>
						<div class="col-md-7">
						<?php echo $this->Form->input('customer_id', ['type'=>'hidden','value' => @$salesOrder->customer_id]); ?>
						<?php echo $jobCard->customer->customer_name; ?>
						</div>
					</div>
				</div>
			</div><br/>
			
			<div class="row">
				<div class="col-md-6">
					<div class="table-scrollable">
						<table class="table tableitm" id="main_tb">
							<thead>
								<tr>
									<th width="50">Sr.No. </th>
									<th>Items</th>
									<th width="130">Source</th>
									
								</tr>
							</thead>
							<tbody id="main_tbody">
								<?php $sn=1; $q=0; foreach ($jobCard->sales_order_rows as $sales_order_row): ?>
								<tr>
									<td><?php echo $sn; ?></td>
									<td><?php echo $sales_order_row->item->name ?></td>
									<td>
										<?php echo $this->Form->input('sales_order_rows.'.$q.'.id', ['type' => 'hidden','value' => @$jobCard->sales_order_rows->id]); ?>
										<?php echo $this->Form->radio('sales_order_rows.'.$q.'.source_type',[['value' => 'Purchessed', 'text' => 'Purchessed'],['value' => 'Manufactured', 'text' => 'Manufactured']]); ?>
									</td>
								</tr>
								<?php $sn++; $q++; endforeach; ?>
							</tbody>
							
						</table>
					</div>
				</div>
			</div>
			
		
				
				
				
			</div>
		
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">NEXT</button>
			</div>
		<?= $this->Form->end() ?>
	</div>

		<!-- END FORM-->
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<style>
#sortable li{
	cursor: -webkit-grab;
}
 
.table thead tr th {
    color: #FFF;
	background-color: #254b73;
}
</style>