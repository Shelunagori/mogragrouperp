<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
	vertical-align: top !important;
}
</style>

<div class="row">
	<div class="col-md-12" style="background-color:#FFF;">
		<div class="row">
			<div class="col-md-12"> 
				<?= $this->Form->create($sale_return_data,['id'=>'form_sample_3']) ?>
				<table class="table table-bordered " width="100%" id="main_tb" border="1">
					<thead>
						<th width="30%" class="text-center"><label class="control-label">Production</label></th>
						<th align="center" class="text-center"><label class="control-label">Consumption</label></th>
					</thead>
					<tbody id="maintbody">
					<?php foreach($inventory_return as $key=>$inventory_return){ ?>
						<tr class="main_tr">
							<td valign="top" class="text-center">
							<br/><b><?= h($inventory_return['item_name']) ?> ( <?= h($inventory_return['qty']) ?> )</b>
							</td>
							<td>
							<table class="table">
								<thead>
									<th width="50%">Item</th>
									<th width="20%">Quantity</th>
									<th>Item Serial No.</th>
								</thead>
									<tbody>
									<?php $q=0;  foreach($InventoryVoucherRows[$key] as $InventoryVoucherRow)  { 
									$total_quant=($inventory_return['qty']*$InventoryVoucherRow->quantity)/$Invoice_qty[$key]['quantity'];
									?>
										<tr>
											<td>
											<?php echo $this->Form->input('item_ledgers.'.$q.'.item_id', ['type' => 'hidden','value' => @$InventoryVoucherRow->item->id]); ?>
											<?= h($InventoryVoucherRow->item->name) ?>
											</td>
											<td>
											<?php echo $this->Form->input('item_ledgers.'.$q.'.quantity', ['type' => 'hidden','value' => @$total_quant]); ?>
											<?= h($total_quant) ?></td>
												<?php if($InventoryVoucherRow->item->item_companies[0]->serial_number_enable==1){ ?>
													<?php $options1=[];
														foreach($InventoryVoucherRow->item->item_serial_numbers as $item_serial_number){
															$options1[]=['text' =>$item_serial_number->serial_no, 'value' => $item_serial_number->id];
														} 
												?>
												<td ><?php echo $this->Form->input('item_serial_numbers[]', ['label'=>false,'options' => $options1,'multiple' => 'multiple','class'=>'form-control select2me','style'=>'width:100%','readonly']);  ?></td>
												<?php } ?>
										</tr>
									<?php $q++; } ?>
									</tbody>
							</table>
							</td>
						</tr>
						
					<?php } ?>
					</tbody>
				</table>
			
					<button type="submit" class="btn btn-primary" id='submitbtn' >Save & Next</button>
			

				
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>