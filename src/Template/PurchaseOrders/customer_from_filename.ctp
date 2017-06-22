<div class="col-md-3" >
	<div class="form-group">
	<label class="control-label">Customer</label>
	<?php 
	$options[]=['text' =>$Customer->customer_name.'('.$Customer->alias.')', 'value' => $Customer->id];
	echo $this->Form->input('customer_id', ['label' => false,'options' => $options,'class' => 'form-control input-sm ']); ?>
	</div>
</div>
<div class="col-md-3" >
	<div id="myModal1" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false" style="display: ; padding-right: 12px;"><div class="modal-backdrop fade in" ></div>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body" id="result_ajax">
					<?php foreach($Customer->customer_address as $customer_addres){ 
						if($customer_addres->default_address==1){
							$def_addrs=$customer_addres->address;
						}
					?>
						<div>
							<a href="#" class="list-group-item insert_address" role="button"><span><?= h($customer_addres->address) ?></span></a>
						</div>
						<?php
					} ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default closebtn">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label">Customer Address</label>
		<?php 
		echo $this->Form->input('customer_address', ['label' => false,'type' => 'textarea','class' => 'form-control','value'=>$def_addrs]); ?>
		<a href="#" role="button" class="pull-right select_address" >Select Address </a>
	</div>
</div>