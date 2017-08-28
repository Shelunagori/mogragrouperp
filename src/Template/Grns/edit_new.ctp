
<?php $this->Form->templates([
     'inputContainer' => '{{content}}'
                                               ]); 
?>
<?php 	$first="01";
		$last="31";
		$start_date=$first.'-'.$financial_month_first->month;
		$end_date=$last.'-'.$financial_month_last->month;
		$start_date=strtotime(date("Y-m-d",strtotime($start_date)));
		$transaction_date=strtotime($grn->transaction_date);
if($transaction_date <  $start_date ) {
	echo "Financial Month has been Closed";
} else { ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Edit Goods Receipt Note</span>
		
		</div>
		
	</div>
	
	<div class="portlet-body form">
		<?= $this->Form->create($grn,['id'=>'form_sample_3']) ?>
		<?php 	$first="01";
				$last="31";
				$start_date=$first.'-'.$financial_month_first->month;
				$end_date=$last.'-'.$financial_month_last->month;
				//pr($start_date); exit;
		?>
		<div class="form-body">
			<div class="form-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Company <span class="required" aria-required="true">*</span></label>
							<br/>
							<?php echo @$grn->company->name; ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">GRN No. <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<div class="col-md-4">
									<?php echo $this->Form->input('grn1', ['label' => false,'class' => 'form-control input-sm','readonly','value'=>@$grn->company->alias]); ?>
								</div>
								<div class="col-md-4">
									<?php echo $this->Form->input('grn3', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'File', 'value'=>@$grn->grn3,'readonly']); ?>
								</div>
								<div class="col-md-4">
									<?php echo $this->Form->input('grn4', ['label' => false,'class' => 'form-control input-sm','readonly']); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">Transaction Date</label>
							<br/>
							<?php echo $this->Form->input('transaction_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','data-date-start-date' => $start_date,'data-date-end-date' => $end_date,'value' => date("d-m-Y",strtotime($grn->transaction_date))]); ?>
						</div>
						<span style="color: red;"><?php if($chkdate == 'Not Found'){  ?>
					You are not in Current Financial Year
				<?php } ?></span>
					</div>
				</div><br/>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Supplier <span class="required" aria-required="true">*</span></label>
							<br/>
							<?php echo @$grn->vendor->company_name; ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Road Permit No<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('road_permit_no', ['label' => false,'class' => 'form-control input-sm','placeholder' => 'Road permit No']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Narration</label>
							<?php echo $this->Form->input('narration', ['type' => 'textarea','label' => false,'class' => 'form-control input-sm ','placeholder' => 'Narration']); ?>
						</div>
					</div>
				</div>
			
				<table class="table tableitm" id="main_tb">
					<thead>
						<tr>
							<th width="10%">Sr.No. </th>
							<th width="70%">Items</th>
							<th width="15%">Quantity</th>
							<th width="5%"></th>
							
						</tr>
					</thead>
					<tbody>
					
						<?php  
							$existing_rows=[];
							$current_rows=[];
							$current_row_items=[];
							foreach($grn->purchase_order->grns as $data){
								foreach($data->grn_rows as $data2){
									$existing_rows[$data2->item_id]=@$existing_rows[$data2->item_id]+$data2->quantity;
								}
							}
							
							foreach($grn->grn_rows as $current_invoice_row){ //pr($current_invoice_row); 
								@$existing_rows[$current_invoice_row->item_id]=$existing_rows[$current_invoice_row->item_id]-$current_invoice_row->quantity;
								$current_rows[]=$current_invoice_row->item_id;
								$current_row_items[$current_invoice_row->item_id]=$current_invoice_row->quantity;
								$descriptions[$current_invoice_row->item_id]=$current_invoice_row->description;
								
							}
								//pr($current_rows); 	 exit;
							
							foreach($grn->purchase_order->purchase_order_rows as $data3){
								$total_items[$data3->item_id]=@$total_items[$data3->item_id]+$data3->quantity;
								//pr($total_items[$data3->item_id]);
							}
							
							
							
							
							$q=0; foreach ($grn->purchase_order->purchase_order_rows as $grn_rows): ?>
							<?php  
							$min_val=0;
							$min_val1=0;
							foreach($grn->item_serial_numbers as $item_serial_number){
									if($item_serial_number->item_id == $grn_rows->item_id){ 
										if($item_serial_number->status=='Out'){ 
										$min_val=$min_val+1;
										}
										$min_val1++;
									}
							} 
							?>
							<?php if(@$existing_rows[$grn_rows->item_id]!=$grn_rows->quantity) { 
							//pr($grn_rows); ?> 
							<tr class="tr1" row_no='<?php echo @$grn_rows->id; ?>'>
								<td rowspan="2"><?php echo ++$q; --$q; ?></td>
								<td>
									<?php echo $this->Form->input('q', ['type' => 'hidden','value'=>@$grn_rows->item_id]); 
									echo $this->Form->input('q', ['type' => 'hidden','value'=>@$grn_rows->item->item_companies[0]->serial_number_enable]);
									echo $grn_rows->item->name;
									?>								
								</td>
								<td>
								
								<?php  
								echo $this->Form->input('q', ['type' => 'text','label' => false,'class' => 'form-control input-sm quan quantity','placeholder' => 'Quantity','value' => @$current_row_items[$grn_rows->item_id]]); 
								
								
								?>
								<span>Max: <?= h($grn_rows->quantity-@$existing_rows[$grn_rows->item_id]) ?></span>
								
								</td>
								<td>
									<label class="hide_lebel"><?php 
									if(in_array($grn_rows->item_id,$current_rows)){
									$check='checked';
										}else{
											$check=' ';
										}
									
									echo $this->Form->input('check.'.$q, ['label' => false,'type'=>'checkbox','class'=>'rename_check','old_qty'=>@$current_row_items[$grn_rows->item_id],'value' => @$grn_rows->id,$check,'max_qty'=>$grn_rows->quantity-@$existing_rows[$grn_rows->item_id]]); ?></label>
								</td>
								
							</tr>
							<tr class="tr2" row_no='<?php echo @$grn_rows->id; ?>'>
								<?php  $i=1; foreach($grn->item_serial_numbers as $item_serial_number){
									if($item_serial_number->item_id == $grn_rows->item_id){ ?>
									<div style="margin-bottom:6px;">
									<?php echo $this->Form->input('serial_numbers['.$grn_rows->item_id.']['.$i.']', ['label' => false,'type'=>'hidden','class'=>'sr_no','ids'=>'sr_no['.$i.']','value' => $item_serial_number->serial_no,'readonly']); ?>
									</div>
									<?php  $i++;  }  }?><br/>
								<td colspan="2" class="td_append">
								
								</td>
								<td colspan="1" class="demo">
									
								<?php  $i=1; foreach($grn->item_serial_numbers as $item_serial_number){
									if($item_serial_number->item_id == $grn_rows->item_id){ ?>
										<?php if($item_serial_number->status=='Out'){  ?>
										<div class="row">
										<div class="col-md-10"><?php echo $this->Form->input('q', ['label' => false,'type'=>'text','value' => $item_serial_number->serial_no,'readonly']); ?></div>
										</div>
										<div class="col-md-2"></div>
										<?php  } else {?>
										<div class="row">
										<div class="col-md-10"><?php echo $this->Form->input('q', ['label' => false,'type'=>'text','value' => $item_serial_number->serial_no,'readonly']); ?></div>
										
										<div class="col-md-2">
											<?= $this->Html->link('<i class="fa fa-trash"></i> ',
													['action' => 'DeleteSerialNumbers', $item_serial_number->id, $item_serial_number->item_id,$grn->id], 
													[
														'escape' => false,
														'class' => 'btn btn-xs red',
														'confirm' => __('Are you sure, you want to delete {0}?', $item_serial_number->id)
													]
												) ?>
											
										</div>
										</div>
									<?php  $i++; } }  }?>
									
								</td>
							</tr>
							<?php } 
							?>
						<?php $q++; endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php echo $this->Form->input('purchase_order_id', ['type' => 'hidden','value'=>@$grn->purchase_order_id]); ?>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
					<?php if($chkdate == 'Not Found'){  ?>
						<label class="btn btn-danger"> You are not in Current Financial Year </label>
					<?php } else { ?>
						<button type="submit" class="btn btn-primary">EDIT GRN</button>	
					<?php } ?>						
					</div>
				</div>
			</div>
		</div>
		<?= $this->Form->end() ?>
	</div>
</div>	
<?php } ?>
<style>
.table thead tr th {
    color: #FFF;
	background-color: #254b73;
}
</style>

<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
	//--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
			grn1:{
				required: true,
			},
			grn3:{
				required: true,
			},
			grn4:{
				required: true,
			},
			
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
			Metronic.scrollTo(error3, -200);
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
			
			success1.show();
			error1.hide();
			form[0].submit(); // submit the form
		}

	});
	//--	 END OF VALIDATION
	
	$('.quan').die().live("keyup",function() {
		var asc=$(this).val();
		var numbers =  /^[0-9]*\.?[0-9]*$/;
		if(asc==0)
		{
			$(this).val('');
			return false; 
		}
		else if(asc.match(numbers))  
		{  
		} 
		else  
		{  
			$(this).val('');
			return false;  
		}
	});
	update_sr_textbox();
	//$('.update_serial_number').on("click",function() {
		function update_sr_textbox(){
		var r=0;
		
		$("#main_tb tbody tr.tr1").each(function(){ 
			var serial_number_enable=$(this).find('td:nth-child(2) input[type="hidden"]:nth-child(2)').val();
			var old_qty=parseInt($(this).closest('tr').find('td:nth-child(4) input[type="checkbox"]:checked').attr('old_qty'));
			if(serial_number_enable && old_qty)
			{ 
				$(this).find('.hide_lebel').hide();
			}
			
				
		});
	}
		
	
	$('.rename_check').die().live("click",function() { 
		rename_rows();
		update_sr_textbox();
    });
	$('.quantity').die().live("blur",function() {
			var is_checked=$(this).closest('tr').find('td:nth-child(4) input[type="checkbox"]:checked').val();
			
			var serial_number_enable=$(this).closest('tr').find('td:nth-child(2) input[type="hidden"]:nth-child(2)').val();
			var qty=parseInt($(this).closest('tr').find('td:nth-child(3) input[type="text"]').val());
			var old_qty=parseInt($(this).closest('tr').find('td:nth-child(4) input[type="checkbox"]:checked').attr('old_qty'));
			if(!old_qty){ old_qty=0; }
			
			var row_no=$(this).closest('tr').attr('row_no');
			var l=$('.tr2[row_no="'+row_no+'"]').find('input').length;
			var item_id=$(this).closest('tr').find('td:nth-child(2) input[type="hidden"]:nth-child(1)').val();
			console.log(is_checked);
			console.log(serial_number_enable);
			console.log(old_qty);
			console.log(row_no);
			if(is_checked && serial_number_enable=='1'){
			
			for(i=0; i <= old_qty; i++){ 
			$('.tr2[row_no="'+row_no+'"]').find('td div.td_append'+i+row_no+'').remove();
			}
			$('.tr2[row_no="'+row_no+'"]').find('td.td_append').html('');
			for(i=0; i < (qty-old_qty); i++){ 
			
				 $('.tr2[row_no="'+row_no+'"]').find('td.td_append').append('<div style="margin-bottom:6px;" class="td_append'+i+row_no+'"><input type="text" class="sr_no" name="serial_numbers['+item_id+'][new_'+i+']" ids="sr_no['+i+']" id="sr_no'+l+row_no+'"/></div>');
				
				$('.tr2[row_no="'+row_no+'"] td:nth-child(1)').find('input#sr_no'+l+row_no).rules('add', {required: true}); 
				
				
			}
		} 
    });
	rename_rows();
	
	
	function rename_rows(){
		$("#main_tb tbody tr.tr1").each(function(){
			var row_no=$(this).attr('row_no');
			var val=$(this).find('td:nth-child(4) input[type="checkbox"]:checked').val();
			var qty=$(this).find('td:nth-child(4) input[type="checkbox"]:checked').attr('max_qty');			
			if(val){
				$(this).find('td:nth-child(2) input[type="hidden"]:nth-child(1)').attr({ name:"grn_rows["+val+"][item_id]"});
				
				$(this).find('td:nth-child(3) input').attr({ name:"grn_rows["+val+"][quantity]", id:"grn_rows-"+val+"-quantity"}).removeAttr('readonly').attr('max',qty).rules('add', {
						    
							max: qty,
							messages: {
								max: "please select equal to the max quantity",
							}
					});
				$(this).css('background-color','#fffcda');
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').css('background-color','#fffcda');
			}
			else{
				$(this).find('td:nth-child(2) input').attr({ name:"q"});
				$(this).find('td:nth-child(3) input').attr({ name:"q", id:"q",readonly:"readonly"});
				
				$(this).css('background-color','#FFF');
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').css('background-color','#FFF');
			}
		});
	}
});		
</script>
