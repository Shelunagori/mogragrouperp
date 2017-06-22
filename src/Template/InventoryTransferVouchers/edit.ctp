<style>
.help-block-error{
	font-size: 10px;
}

.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
	vertical-align: top !important;
}
</style>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
				<span class="caption-subject font-blue-steel uppercase">Update Inventory Transfer Voucher</span>
		</div>
	</div>
	<div class="portlet-body form">
	<?= $this->Form->create($inventoryTransferVoucher,['id'=>'form_sample_3']) ?>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-3">
			<input type="text" name="transaction_date" class="form-control input-sm date-picker" value="<?php echo date('d-m-Y',strtotime($inventoryTransferVouchersout->transaction_date)); ?>" placeholder="Transaction Date" data-date-format="dd-mm-yyyy" >
		</div>
	</div>
		<div class="row">
			<div class="col-md-6">
			<h5>For Out</h5>
					<table id="main_table" width="50%"  class="table table-condensed">
									<thead>
										<tr>
											<th>Item</th>
											<th >Qty</th>
											<th >Serial Number</th>
											<th></th>
											<th></th>
										</tr>
									</thead>
							<tbody id="maintbody">
						<?php $options1= [];	foreach($inventoryTransferVouchersout->inventory_transfer_voucher_rows as $inventory_transfer_voucher_row){ 
										?>
								<tr class="main">
									<td width="30%">
										<?php echo $inventory_transfer_voucher_row->item->name;
										echo $this->Form->input('q', ['type'=>'hidden','readonly','value'=>$inventory_transfer_voucher_row->item->id,'label' => false,'class' => 'form-control input-sm  ']); ?>
									</td>
									<td width="15%">
										<?php echo $this->Form->input('q', ['type' => 'text','label' => false,'value'=>$inventory_transfer_voucher_row->quantity,'class' => 'form-control input-sm qty_bx','placeholder' => 'Quantity']); ?>
									</td>
									<td>
									<?php
									$selected=[]; $options=[];
									
									foreach($inventory_transfer_voucher_row->item->item_serial_numbers as $item_serial_number){
									
										if($item_serial_number->inventory_transfer_voucher_id == $id &&$item_serial_number->item_id == $inventory_transfer_voucher_row->item_id 
										&&$item_serial_number->status=='Out'){
										
										$selected[$item_serial_number->id]=$item_serial_number->id;
										}
									} 
								
									foreach($inventory_transfer_voucher_row->item->item_serial_numbers as $item_serial_number){
										$options[]=['text' =>$item_serial_number->serial_no, 'value' => $item_serial_number->id];
									}
									if(!empty($options)){
									 echo $this->Form->input('q', ['label'=>false,'options' => $options,'multiple' => 'multiple','class'=>'form-control input-sm select2me','required ','style'=>'width:100%','value'=>$selected]); 
									}else{
										//echo "Serial No Not Selected";
									} 
									 ?>
										
									</td>
									<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
							</tr>
							<?php } ?>
						</tbody>
				</table>
			</div>
			<div class="col-md-6">
			<h5>For In</h5>
				<table id="main_table_1" width="50%"  class="table table-condensed">
					<thead>
						<tr>
							<th>Item</th>
							<th >Qty</th>
							<th>Serial Number</th>
							<th >Rate</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody id="maintbody_1">
						<?php $options1= [];	foreach($inventoryTransferVouchersins->inventory_transfer_voucher_rows as $inventory_transfer_voucher_row_in){ 
									?>
							<tr class="main">
								<td  width="25%">
									<?php echo $inventory_transfer_voucher_row_in->item->name;
									echo $this->Form->input('q', ['type'=>'hidden','readonly','value'=>$inventory_transfer_voucher_row_in->item->id,'label' => false,'item_sr'=>$inventory_transfer_voucher_row_in->item->item_companies[0]->serial_number_enable,'class' => 'form-control input-sm  ']); ?>
								</td>
								<td  width="15%"> 
									<?php echo $this->Form->input('q', ['type' => 'text','label' => false,'value'=>$inventory_transfer_voucher_row_in->quantity,'class' => 'form-control input-sm qty_bx_in','placeholder' => 'Quantity','old_qty'=>$inventory_transfer_voucher_row_in->quantity]); ?>
								</td>
								
								<td width="30%">
									<div class="row">
										<div class="col-md-6 offset sr_container"></div>
										<div class="col-md-6">
											<table width="20%">
												<tbody>
													<tr>
														<td>
															<?php 
									//pr($inventory_transfer_voucher_row_in); exit;
									$i=1; foreach($inventory_transfer_voucher_row_in->item->item_serial_numbers as $item_serial_number){
										if($item_serial_number->item_id == $inventory_transfer_voucher_row_in->item_id && $item_serial_number->inventory_transfer_voucher_id == $inventoryTransferVouchersins->id && $item_serial_number->status=='In' ){ ?>
											<?php if($item_serial_number->status=='Out'){  ?>
											<?php echo $this->Form->input('q', ['label' => false,'type'=>'text','style'=>'width: 65px;','value' => $item_serial_number->serial_no,'disabled'=>true]); ?>
											
											<?php  } else {?>
											<?php echo $this->Form->input('q', ['label' => false,'type'=>'text','style'=>'width: 65px;','value' => $item_serial_number->serial_no,'disabled'=>true]); ?>
											
											
												<?= $this->Html->link('<i class="fa fa-trash"></i> ',
														['action' => 'DeleteSerialNumbers', $item_serial_number->id, $inventory_transfer_voucher_row_in->id,$inventory_transfer_voucher_row_in->inventory_transfer_voucher_id,$inventory_transfer_voucher_row_in->item_id], 
														[
															'escape' => false,
															'class' => 'btn btn-xs red',
															'confirm' => __('Are you sure, you want to delete {0}?', $item_serial_number->id)
														]
													) ?>
												
										<?php  $i++; } }  }?>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									
								</td>
								
								<td width="20%">
									<?php echo $this->Form->input('amount', ['type' => 'text','label' => false,'style'=>'width: 79px;','value'=>$inventory_transfer_voucher_row->amount,'class' => 'form-control input-sm ','placeholder' => 'Rate']); ?>
								</td>
								<td><a class="btn btn-xs btn-default addrow_1" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow_1" href="#" role='button'><i class="fa fa-times"></i></a></td>
							</tr>
						<?php }?>
						</tbody>
					</table>
				
			</div>
		
		
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>	
	<?= $this->Form->end(); ?>
</div>
</div>
		
		
		
	

<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<script>
$(document).ready(function() {
	jQuery.validator.addMethod("notEqualToGroup", function (value, element, options) {
		// get all the elements passed here with the same class
		var elems = $(element).parents('form').find(options[0]);
		// the value of the current element
		var valueToCompare = value;
		// count
		var matchesFound = 0;
		// loop each element and compare its value with the current value
		// and increase the count every time we find one
		jQuery.each(elems, function () {
			thisVal = $(this).val();
			if (thisVal == valueToCompare) {
				matchesFound++;
			}
		});
		// count should be either 0 or 1 max
		if (this.optional(element) || matchesFound <= 1) {
			//elems.removeClass('error');
			return true;
		} else {
			//elems.addClass('error');
		}
	}, jQuery.format(""))
	//--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
				item_id :{
							required: true,
						  },
				quantity :{
							required: true,
						  }
			},

		messages: { // custom messages for radio buttons and checkboxes
			
		},

		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.parent(".input-group").size() > 0) {
				error.insertAfter(element.parent(".input-group"));
			} else if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else if (element.parents('.radio-list').size() > 0) { 
				error.appendTo(element.parents('.radio-list').attr("data-error-container"));
			} else if (element.parents('.radio-inline').size() > 0) { 
				error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
			} else if (element.parents('.checkbox-list').size() > 0) {
				error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
			} else if (element.parents('.checkbox-inline').size() > 0) { 
				error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
			success3.hide();
			error3.show();
			
			//Metronic.scrollTo(error3, -200);
		},

		highlight: function (element) { // hightlight error inputs
		   $(element)
				.closest('.form-group').addClass('has-error'); // set error class to the control group
		},

		unhighlight: function (element) { // revert the change done by hightlight
			$(element)
				.closest('.form-group').removeClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label
				.closest('.form-group').removeClass('has-error'); // set success class to the control group
		},

		submitHandler: function (form) {
			validate_serial();
			success3.show();
			error3.hide();
			form[0].submit(); // submit the form
		}

	});
	
	
	//add_row_in();
	//add_row_out();

	$('.addrow_1').die().live("click",function() { 
		add_row_in();
	});
	
	$('.addrow').die().live("click",function() { 
		add_row_out();
	});
	
	$('.deleterow').live("click",function() {
		var l=$(this).closest("table tbody").find("tr").length;
		if (confirm("Are you sure to remove row ?") == true) {
			if(l>1){
				var row_no=$(this).closest("tr").attr("row_no");
				var del=$(this).closest("tr");
				$(del).remove();
				rename_rows_out();
			}
		} 
	});
	
	$('.deleterow_1').live("click",function() {
		var l=$(this).closest("table tbody").find("tr").length;
		if (confirm("Are you sure to remove row ?") == true) {
			if(l>1){
				var row_no=$(this).closest("tr").attr("row_no");
				var del=$(this).closest("tr");
				$(del).remove();
				rename_rows_in();
			}
		} 
	});
	
	function add_row_in(){
		var tr2=$("#sampletable_1 tbody tr").clone();
		$("#main_table_1 tbody#maintbody_1").append(tr2);
		rename_rows_in();
		
	}
	
	function add_row_out(){
		var tr2=$("#sampletable tbody tr").clone();
		$("#main_table tbody#maintbody").append(tr2);
		rename_rows_out();
		
	}
	rename_rows_out();
	rename_rows_in();
	
	$('.select_item_in').die().live("change",function() {
		rename_rows_in();
		var tr_obj=$(this).closest('tr');
		sr_nos(tr_obj);
	});
	
	$('.qty_bx_in').die().live("blur",function() {
		var tr_obj=$(this).closest('tr');
		sr_nos(tr_obj);
    });
	
	function sr_nos(tr_obj){
		
		var len=tr_obj.find("td:nth-child(1) select").length; 
		if(len>0){
			var serial_number_enable=tr_obj.find('td:nth-child(1) select option:selected').attr('serial_number_enable');
		}else{
			var serial_number_enable=tr_obj.find('td:nth-child(1) input').attr('item_sr');
		}
		var old_qty=tr_obj.find('td:nth-child(2) input').attr('old_qty');
		alert(old_qty);		
		if(serial_number_enable==1){
			var qty=tr_obj.find('td:nth-child(2) input').val();
			var row_no=tr_obj.attr('row_no');
			tr_obj.find('td:nth-child(3) div.sr_container').html('');
			for(var w=0; w < (qty-old_qty); w++){
				tr_obj.find('td:nth-child(3) div.sr_container').append('<input type="text" name="inventory_transfer_voucher_rows[in]['+row_no+'][sr_no]['+w+']" id="inventory_transfer_voucher_rows-in-'+row_no+'-sr_no-'+w+'" style=" width: 92px;" required="required" placeholder="serial number '+w+'" /><br/>');
			}
		}else{
			tr_obj.find('td:nth-child(3)').html('');
		}
	}
	
	rename_rows_in();
	function rename_rows_in(){
		var j=0;
		$("#main_table_1 tbody#maintbody_1 tr.main").each(function(){
			$(this).attr('row_no',j);
			var len=$(this).find("td:nth-child(1) select").length; 
			if(len>0){
			$(this).find("td:nth-child(1) select").select2().attr({name:"inventory_transfer_voucher_rows[in]["+j+"][item_id_in]", id:"inventory_transfer_voucher_rows-"+j+"-item_id_in"}).rules("add", "required");
			}else{
			$(this).find("td:nth-child(1) input").attr({name:"inventory_transfer_voucher_rows[in]["+j+"][item_id_in]", id:"inventory_transfer_voucher_rows-"+j+"-item_id_in"}).rules("add", "required");	
			}
			$(this).find('td:nth-child(2) input').attr({name:"inventory_transfer_voucher_rows[in]["+j+"][quantity_in]", id:"inventory_transfer_voucher_rows-"+j+"-quantity_in"}).rules("add", "required");
			$(this).find('td:nth-child(4) input').attr({name:"inventory_transfer_voucher_rows[in]["+j+"][amount]", id:"inventory_transfer_voucher_rows-"+j+"-amount"}).rules("add", "required");
			
			j++; 
	   });
	}	
	
	$('.select_item_out').die().live("change",function() {
		var t=$(this);
		var row_no=t.closest('tr').attr('row_no');
		var select_item_id=$(this).find('option:selected').val();
		var url1="<?php echo $this->Url->build(['controller'=>'InventoryTransferVouchers','action'=>'ItemSerialNumber']); ?>";
		url1=url1+'/'+select_item_id,
		$.ajax({
			url: url1,
		}).done(function(response) { 
		$(t).closest('tr').find('td:nth-child(3)').html(response);
		$(t).closest('tr').find('td:nth-child(3) select').attr({name:"inventory_transfer_voucher_rows[out]["+row_no+"][serial_number_data][]", id:"inventory_transfer_voucher_rows-"+row_no+"-serial_number_data"});
			$(t).closest('tr').find('td:nth-child(3) select').select2({ placeholder: "Serial Number"});
  			
		});
	});
	
	function rename_rows_out(){
		
		var i=0;
		$("#main_table tbody#maintbody tr.main").each(function(){
			
			$(this).attr('row_no',i);
			var len=$(this).find("td:nth-child(1) select").length; 
			if(len>0){
			$(this).find("td:nth-child(1) select").select2().attr({name:"inventory_transfer_voucher_rows[out]["+i+"][item_id]", id:"inventory_transfer_voucher_rows-"+i+"-item_id"}).rules("add", "required");
			}else{
			$(this).find("td:nth-child(1) input").attr({name:"inventory_transfer_voucher_rows[out]["+i+"][item_id]", id:"inventory_transfer_voucher_rows-"+i+"-item_id"}).rules("add", "required");	
			}
			$(this).find('td:nth-child(2) input').attr({name:"inventory_transfer_voucher_rows[out]["+i+"][quantity]", id:"inventory_transfer_voucher_rows-"+i+"-quantity"}).rules("add", "required");
			if($(this).find('td:nth-child(3) select').length>0){
				$(this).find('td:nth-child(3) select').select2().attr({name:"inventory_transfer_voucher_rows[out]["+i+"][serial_number_data][]", id:"inventory_transfer_voucher_rows-"+i+"-serial_number_data"}).rules("add", "required");
			}
			i++; 
		});
	}
	
	$('.qty_bx').die().live("keyup",function() {
		validate_serial();
    });
	
	function validate_serial(){
		$("#main_table tbody#maintbody tr.main").each(function(){
			var qty=$(this).find('td:nth-child(2) input').val();
			if($(this).find('td:nth-child(3) select').length>0){
				$(this).find('td:nth-child(3) select').attr('test',qty).rules('add', {
							required: true,
							minlength: qty,
							maxlength: qty,
							messages: {
								maxlength: "select serial number equal to quantity.",
								minlength: "select serial number equal to quantity."
							}
					});
			}
		});	
	}
});

	
	
</script>	

<table id="sampletable" style="display:none;">
	<tbody>
		<tr class="main">
			<td width="20%">
				<?php 
				$item_option=[];
				foreach($display_items as $Item){ 
					$item_option[]=['text' =>$Item->name, 'value' => $Item->id, 'serial_number_enable' => (int)$Item->serial_number_enable];
				}
				echo $this->Form->input('q', ['empty'=>'Select','options' => $item_option,'label' => false,'style'=>'width: 200px; display: block;','class' => 'form-control input-sm select_item_out item_id']); ?>
			</td>
			<td>
				<?php echo $this->Form->input('q', ['type' => 'text','label' => false,'class' => 'form-control input-sm qty_bx','placeholder' => 'Quantity']); ?>
			</td>
			<td></td>
			<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
	</tbody>
</table>
<table id="sampletable_1" style="display:none;">
	<tbody>
		<tr class="main">
			<td width="20%">
				<?php 
				$item_option=[];
				foreach($display_items as $Item){ 
					$item_option[]=['text' =>$Item->name, 'value' => $Item->id, 'serial_number_enable' => (int)$Item->serial_number_enable];
				}
				echo $this->Form->input('q', ['empty'=>'Select','options' => $item_option,'label' => false,'style'=>'width: 150px; display: block;','class' => 'form-control input-sm select_item_in item_id']); ?>
			</td>
			<td width="20%"> 
				<?php echo $this->Form->input('q', ['type' => 'text','label' => false,'class' => 'form-control input-sm qty_bx_in','old_qty'=>0,'placeholder' => 'Quantity']); ?>
			</td>
			<td width="20%" ><div class="offset sr_container"></div></td>
			<td width="20%">
				<?php echo $this->Form->input('amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm ','placeholder' => 'Rate']); ?>
			</td>
			<td width="20%"><a class="btn btn-xs btn-default addrow_1" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow_1" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
	</tbody>
</table>