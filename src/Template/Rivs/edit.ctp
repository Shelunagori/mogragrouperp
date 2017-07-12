<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
	vertical-align: top !important;
}
</style>

<div class="row">
	<div class="col-md-12" style="background-color:#FFF;">
		<div class="row">
			<div class="col-md-12"> 
				<?= $this->Form->create($riv,['id'=>'form_sample_3']) ?>
				<table class="table table-bordered " width="100%" id="main_tb" border="1">
					<thead>
						<th width="30%" class="text-center"><label class="control-label">Out</label></th>
						<th align="center" class="text-center"><label class="control-label">In</label></th>
					</thead>
					<tbody id="maintbody">
					<?php $p=0; foreach($riv->left_rivs as $key=>$left_riv){ ?>
						<tr class="main_tr">
							<td valign="top" class="text-center">
							<br/><b>
							<?php echo $this->Form->input('left_rivs.'.$p.'.item_id', ['type' => 'hidden','value' => $left_riv->item_id]); ?>
							<?php echo $this->Form->input('left_rivs.'.$p.'.quantity', ['type' => 'hidden','value' => @$inventory_return['qty']]); ?>
							<?= h($left_riv->item->name) ?> ( <?= h($left_riv->quantity) ?> )</b>
							</td>
							<td>
							<table class="table">
								<thead>
									<th width="50%">Item</th>
									<th width="20%">Quantity</th>
									<th>Item Serial No.</th>
								</thead>
									<tbody>
									<?php $q=0;  foreach($left_riv->right_rivs as $right_riv)  { 
									
									?>
										<tr>
											<td>
											<?php echo $this->Form->input(
											'left_rivs.'.$p.'.right_rivs.'.$q.'.item_id', ['type' => 'hidden','value' => @$right_riv->item->id]); ?>
											<?= h($right_riv->item->name) ?>
											</td>
											<td>
											<?php echo $this->Form->input('left_rivs.'.$p.'.right_rivs.'.$q.'.quantity', ['label' => false,'class' => 'form-control input-sm','value' => @$right_riv->quantity]); ?>
											</td>
												<?php if($right_riv->item->item_companies[0]->serial_number_enable==1){ ?>
													<?php $options1=[];
														foreach($right_riv->item->item_serial_numbers as $item_serial_number){    $select_item=[];
															if($item_serial_number->sale_return_id==$riv->sale_return_id){
															$select_item=['text' =>$item_serial_number->serial_no, 'value' => $item_serial_number->id];	
															}
															$options1[]=['text' =>$item_serial_number->serial_no, 'value' => $item_serial_number->id];
														} 
												?>
												<td ><?php echo $this->Form->input('left_rivs.'.$p.'.right_rivs.'.$q.'.item_serial_numbers[]', ['label'=>false,'options' => $options1,'multiple' => 'multiple','class'=>'form-control select2me','style'=>'width:100%','readonly','value'=>$select_item]);  ?></td>
												<?php } ?>
										</tr>
									<?php $q++; } ?>
									</tbody>
							</table>
							</td>
						</tr>
						
					<?php $p++; } ?>
					</tbody>
				</table>
			
					<button type="submit" class="btn btn-primary" id='submitbtn' >Save & Next</button>
			

				
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>


