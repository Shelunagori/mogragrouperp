<style>
table > thead > tr > th, table > tbody > tr > th, table > tfoot > tr > th, table > thead > tr > td, table > tbody > tr > td, table > tfoot > tr > td{
	vertical-align: top !important;
	border-bottom:solid 1px #CCC;
}
.page-content-wrapper .page-content {
    padding: 5px;
}
.portlet.light {
    padding: 4px 10px 4px 10px;
}
.help-block-error{
	font-size: 10px;
}
</style>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Create Inventory Voucher</span>
		</div>
	</div>
	<div class="portlet-body form">
		<?= $this->Form->create($iv) ?>
			<?php echo $this->Form->input('transaction_date'); ?>
			<table class="table table-bordered main_table">
				<thead>
					<tr>
						<th>Item in Invoice</th>
						<th>Qty</th>
						<th>Seria_nos</th>
						<th>consumption</th>
					</tr>
				</thead>
				<tbody class="main_tbody">
					<?php foreach($invoice->invoice_rows as $invoice_row){ ?>
					<tr class="main_tr" invoice_row_id='<?php echo $invoice_row->id; ?>'>
						<td><?php echo $invoice_row->item->name; ?></td>
						<td><?php echo $invoice_row->quantity; ?></td>
						<td>
							<input type="hidden" name="iv_left_rows[<?php echo $invoice_row->id; ?>][invoice_row_id]" placeholder="Serial number" required value="<?php echo $invoice_row->id; ?>"/>
							<?php if(!empty($invoice_row->item->item_companies[0]->serial_number_enable)){
								for($i=0; $i<$invoice_row->quantity; $i++){ ?>
									<input type="text" name="iv_left_rows[<?php echo $invoice_row->id; ?>][iv_left_serial_numbers][<?php echo $i; ?>][sr_number]" placeholder="Serial number" required/><br/>
								<?php }
							} ?>
						</td>
						<td>
							<table class="table consumption_table" invoice_row_id='<?php echo $invoice_row->id; ?>'>
								<thead>
									<tr>
										<td>item</td>
										<td width="100">Qty</td>
										<td>Serial</td>
										<td></td>
									</tr>
								</thead>
								<tbody class="consumption_tbody">
									<tr class="consumption_tr">
										<td>
											<?php 
											$item_option=[];
											foreach($items as $item){ 
												$item_option[]=['text' =>$item->name, 'value' => $item->id, 'serial_number_enable' => (int)@$item->item_companies[0]->serial_number_enable];
											}
											echo $this->Form->input('q', ['empty'=>'Select','options' => $item_option,'label' => false,'class' => 'form-control input-sm select_item item_id']); ?>
										</td>
										<td>
											<?php echo $this->Form->input('q', ['type' => 'text','label' => false,'class' => 'form-control input-sm qty_bx','placeholder' => 'Quntity']); ?>
										</td>
										<td></td>
										<td><a class="btn btn-xs btn-default deleterow" href="#" role='button' ><i class="fa fa-times"></i></a></td>
									</tr>
								</tbody>
							</table>
							<a class="btn btn-xs btn-default addrow" href="#" role='button'  invoice_row_id='<?php echo $invoice_row->id; ?>'><i class="fa fa-plus"></i>Add Row</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		<?= $this->Form->button(__('Submit')) ?>
		<?= $this->Form->end() ?>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<script>
$(document).ready(function() {
	$('.addrow').die().live("click",function() {
		var clicked_object=$(this);
		var invoice_row_id=$(this).attr('invoice_row_id');
		addrow(clicked_object,invoice_row_id);
    });
	$('.deleterow').die().live("click",function() {
		$(this).closest('tr').remove();
		rename_rows();
    });
	function addrow(clicked_object,invoice_row_id){
		var tr=$('table.sample_table').find('tbody tr').clone();
		$('table.consumption_table[invoice_row_id='+invoice_row_id+']').find('tbody.consumption_tbody').append(tr);
		rename_rows();
	}
	rename_rows();
	function rename_rows(){
		var q=0;
		$(".main_table tbody.main_tbody tr.main_tr").each(function(){
			var invoice_row_id=$(this).attr('invoice_row_id');
			var i=0;
			$(this).find('table.consumption_table tbody.consumption_tbody tr.consumption_tr').each(function(){
				$(this).find('td:nth-child(1) select').select2().attr({name:"iv_left_rows["+invoice_row_id+"][iv_right_rows]["+i+"][item_id]", id:"iv_right_rows-"+i+"-item_id"});
				$(this).find('td:nth-child(2) input').attr({name:"iv_left_rows["+invoice_row_id+"][iv_right_rows]["+i+"][quantity]", id:"iv_right_rows-"+i+"-quantity"});
				select_count=$(this).find('td:nth-child(3) select').length;
				if(select_count>0){
					$(this).find('td:nth-child(3) select').select2().attr({name:"iv_left_rows["+invoice_row_id+"][iv_right_rows]["+i+"][iv_right_serial_numbers][_ids][]", id:"iv_right_rows-"+i+"-serial_numbers"});
				}
			 i++; });
		q++; });
	}
	
	$('.select_item').die().live("change",function() {
		var t=$(this);
		var serial_number_enable=$(this).find('option:selected').attr('serial_number_enable');
		if(serial_number_enable!=0){
			var select_item_id=$(this).find('option:selected').val();
			var url1="<?php echo $this->Url->build(['controller'=>'Ivs','action'=>'ItemSerialNumber']); ?>";
			url1=url1+'/'+select_item_id,
			$.ajax({
				url: url1,
			}).done(function(response) {
				t.closest('tr.consumption_tr').find('td:nth-child(3)').html(response);
				rename_rows();
			});
		}else{
			t.closest('tr.consumption_tr').find('td:nth-child(3)').html("");
		}
	});
});
</script>

<table class="sample_table" style="display:none;">
		<tbody>
			<tr class="consumption_tr">
				<td>
					<?php 
					$item_option=[];
					foreach($items as $item){ 
						$item_option[]=['text' =>$item->name, 'value' => $item->id, 'serial_number_enable' => (int)@$item->item_companies[0]->serial_number_enable];
					}
					echo $this->Form->input('q', ['empty'=>'Select','options' => $item_option,'label' => false,'class' => 'form-control input-sm select_item item_id']); ?>
				</td>
				<td>
					<?php echo $this->Form->input('q', ['type' => 'text','label' => false,'class' => 'form-control input-sm qty_bx','placeholder' => 'Quntity']); ?>
				</td>
				<td></td>
				<td><a class="btn btn-xs btn-default deleterow" href="#" role='button' ><i class="fa fa-times"></i></a></td>
			</tr>
		</tbody>
	</table>

