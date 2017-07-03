<style>
table > thead > tr > th, table > tbody > tr > th, table > tfoot > tr > th, table > thead > tr > td, table > tbody > tr > td, table > tfoot > tr > td{
	vertical-align: top !important;
	border-bottom:solid 1px #CCC;
}
.help-block-error{
	font-size: 10px;
}
.row_textbox{
	width: 100px;
}
.check_text{
	font-size:9px;
}
.add_check_text{
	font-size:9px;
}	
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
	vertical-align: top !important;
}
#main_tb thead th {
	font-size:10px;
}
</style>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Create Invoice (GST)</span>
		</div>
	</div>
	<div class="form-actions">
	</div>
	
	<div class="portlet-body form">
		<?= $this->Form->create($invoice,['id'=>'form_sample_3']) ?>
		<div class="form-body">
				<div class="row">
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Sales Account. <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<div class="col-md-12">
									<?php echo $this->Form->input('sales_ledger_account', ['empty' => "--Select--",'label' => false,'options' => $ledger_account_details,'class' => 'form-control input-sm select2me','required']); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">Date</label>
							<?php echo $this->Form->input('date_created', ['type' => 'text','label' => false,'class' => 'form-control input-sm','value' => date("d-m-Y"),'readonly']); ?>					
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Customer <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<div class="col-md-12">
									<?php echo $this->Form->input('customer_id', ['type'=>'hidden','value' => @$sales_order->customer_id]); ?>
									<?php echo $sales_order->customer->customer_name.'('; echo $sales_order->customer->alias.')'; ?>	
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Invoice No</label>
							<div class="row">
								<div class="col-md-4">
									<?php echo $this->Form->input('in1', ['label' => false,'class' => 'form-control input-sm','readonly','value'=>$sales_order->so1]); ?>
								</div>
								<div class="col-md-4">
									<?php echo $this->Form->input('in3', ['label' => false,'class' => 'form-control input-sm','readonly','value'=>$sales_order->so3]); ?>
								</div>
								<div class="col-md-4">
									<?php echo $this->Form->input('in4', ['label' => false,'value'=>substr($s_year_from, -2).'-'.substr($s_year_to, -2),'class' => 'form-control input-sm','readonly']); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Address <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<div class="col-md-12">
									<?php echo $this->Form->input('customer_address', ['label' => false,'class' => 'form-control','placeholder' => 'Address','value' => @$sales_order->customer_address]); ?>
									<a href="#" role="button" class="pull-right select_address" >
									Select Address </a>	
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">LR No</label>
							<div class="row">
								<div class="col-md-12">
									<?php echo $this->Form->input('lr_no', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'LR No']); ?>
								</div>
							</div><br/>
							<label class="control-label">Carrier</label>
							<div class="row">
								<div class="col-md-12">
									<?php echo $this->Form->input('transporter_id', ['empty' => "--Select--",'label' => false,'options' => $transporters,'class' => 'form-control input-sm select2me','value' => @$sales_order->transporter_id]); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Delivery Description <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<div class="col-md-12">
									<?php echo $this->Form->input('delivery_description', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Delivery Description','value'=>$sales_order->delivery_description]); ?>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Customer PO NO  </label>
							<div class="row">
								<div class="col-md-12">
									<?php echo $sales_order->customer_po_no; ?>
								</div>
							</div><br/>
							<label class="control-label">PO DATE</label>
							<div class="row">
								<div class="col-md-12">
									<?php echo @date("d-m-Y",strtotime($sales_order->po_date)); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="row">
				<?php if($sales_order->road_permit_required=='Yes') {?>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Road Permit No <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<div class="col-md-12">
									<?php echo $this->Form->input('form47', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Form 47','required']); ?>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
					<?php if($sales_order->road_permit_required=='Yes') {?>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Form 49 <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<div class="col-md-12">
									<?php echo $this->Form->input('form49', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Form 47','required']); ?>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			
	<div style='overflow-x:scroll;width:932px;'>	
		<div style="width:974px;">
		<input type="text"  name="checked_row_length" id="checked_row_length" style="height: 0px;padding: 0;border: none;" />
			<table  class="table tableitm" id="main_tb" border="1">
				<thead>
						<tr >
							<th rowspan="2" style="text-align: bottom;" width="50px">Sr.No. </th>
							<th rowspan="2" style="white-space: nowrap; width:50%;">Items</th>
							<th rowspan="2"  style="width:20%;">Quantity</th>
							<th rowspan="2"  style="width:20%;">Rate</th>
							<th rowspan="2"  style="width:20%;">Amount</th>
							<th style="text-align: center;" colspan="2" width="50%">Discount</th>
							<th style="text-align: center;" colspan="2" width="50%">P&F </th>
							<th rowspan="2"  width="100px">Taxable Value</th>
							<th style="text-align: center;" colspan="2" width="50%">CGST</th>
							<th style="text-align: center;" colspan="2" width="20%">SGST</th>
							<th style="text-align: center;" colspan="2" width="20%">IGST</th>
							
							<th rowspan="2" width="100px">Total</th>
							<th rowspan="2" width="100px"></th>
						</tr>
						<tr> <th style="text-align: center;" width="150px">%</th>
							<th style="text-align: center;" width="150px">Amt</th>
							<th style="text-align: center;" width="150px">%</th>
							<th style="text-align: center;" width="150px">Amt</th>
							<th style="text-align: center;" width="150px">%</th>
							<th style="text-align: center;" width="150px">Amt</th>
							<th style="text-align: center;" width="150px">%</th>
							<th style="text-align: center;" width="150px">Amt</th>
							<th style="text-align: center;" width="150px">%</th>
							<th style="text-align: center;" width="150px">Amt</th>
						</tr>
						
				</thead>
				<tbody>
				<?php 
						$options=array();
							foreach($GstTaxes as $GstTaxe){
								$merge=$GstTaxe->tax_figure.' ('.$GstTaxe->invoice_description.')';
								$options[]=['text' =>$merge, 'value' => $GstTaxe->id,'percentage'=>$GstTaxe->tax_figure];
							}
				if(!empty($sales_order->sales_order_rows)){
					$q=0; foreach ($sales_order->sales_order_rows as $sales_order_rows): 
					?>
						<tr class="tr1  firsttr " row_no='<?php echo @$sales_order_rows->id; ?>'>
							<td rowspan="2"><?php echo ++$q; --$q; ?></td>
							<td>
								<?php echo $this->Form->input('q', ['label' => false,'type' => 'hidden','value' => @$sales_order_rows->item_id,'readonly']); ?>
								<?php echo $sales_order_rows->item->name; ?>
							</td>
							<td>
								<?php echo $this->Form->input('q', ['label' => false,'type' => 'text','class' => 'form-control input-sm quantity row_textbox','placeholder'=>'Quantity','value' => @$sales_order_rows->quantity-$sales_order_rows->processed_quantity,'readonly','min'=>'1','max'=>@$sales_order_rows->quantity-$sales_order_rows->processed_quantity]); ?>
							</td>
							<td>
								<?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Rate','value' => @$sales_order_rows->rate,'readonly','step'=>0.01]); ?>
							</td>
							<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Amount','readonly','step'=>0.01]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm  row_textbox discount_percentage','placeholder'=>'%']); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Amount','readonly','step'=>0.01]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm row_textbox pnf_percentage','placeholder'=>'%','step'=>0.01]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Amount','readonly','step'=>0.01]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Taxable Value','readonly','step'=>0.01]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'empty'=>'Select','options'=>$options,'class' => 'form-control input-sm select2me row_textbox cgst_percentage','placeholder'=>'%','step'=>0.01]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Amount','readonly','step'=>0.01]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'empty'=>'Select','options'=>$options,'class' => 'form-control input-sm select2me','class' => 'form-control input-sm row_textbox sgst_percentage','placeholder'=>'%','step'=>0.01]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Amount','readonly','step'=>0.01]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'empty'=>'Select','options'=>$options,'class' => 'form-control input-sm select2me','class' => 'form-control input-sm row_textbox igst_percentage','placeholder'=>'%','step'=>0.01]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Amount','readonly','step'=>0.01]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Total','readonly','step'=>0.01]); ?></td>
							<td><label><?php echo $this->Form->input('check.'.$q, ['label' => false,'type'=>'checkbox','class'=>'rename_check','value' => @$sales_order_rows->id]); ?></label>
							</td>
						</tr>
						<tr class="tr2  secondtr" row_no='<?php echo @$sales_order_rows->id; ?>'>
							<td colspan="16">
							<div contenteditable="true" class="note-editable" id="summer<?php echo $q; ?>"><?php echo @$sales_order_rows->description; ?></div>
							<?php echo $this->Form->input('q', ['label' => false,'type' => 'textarea','class' => 'form-control input-sm ','placeholder'=>'Description','style'=>['display:none'],'value' => @$sales_order_rows->description,'readonly','required']); ?>
							</td>
							<td></td>
						</tr>
						<?php 
						
							$options1=[]; 
							foreach($sales_order_rows->item->item_serial_numbers as $item_serial_number){
								$options1[]=['text' =>$item_serial_number->serial_no, 'value' => $item_serial_number->id];
							} 
							if($sales_order_rows->item->item_companies[0]->serial_number_enable==1) { ?>
							<tr class="tr3" row_no='<?php echo @$sales_order_rows->id; ?>'>
							<td></td>
							<td colspan="5">
							<?php echo $this->Form->input('q', ['label'=>false,'options' => $options1,'multiple' => 'multiple','class'=>'form-control select2me','style'=>'width:100%']);  ?></td>
							</tr><?php } ?>
						<?php $q++; endforeach; }?>
				</tbody>
				<tfoot>
					<tr>
						<td align="right" colspan="5"><?php echo $this->Form->input('total_amt', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Amount','readonly','step'=>0.01]); ?></td>
						<td align="right" colspan="2"><?php echo $this->Form->input('total_discount', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Discount','readonly','step'=>0.01]); ?></td>
						<td align="right" colspan="2"><?php echo $this->Form->input('total_pnf', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'P&F','readonly','step'=>0.01]); ?></td>
						<td align="right"><?php echo $this->Form->input('total_taxable_value', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Total','readonly','step'=>0.01]); ?></td>
						<td align="right" colspan="2"><?php echo $this->Form->input('total_cgst', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Total CGST','readonly','step'=>0.01]); ?></td>
						<td align="right" colspan="2"><?php echo $this->Form->input('total_sgst', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Total SGST','readonly','step'=>0.01]); ?></td>
						<td align="right" colspan="2"><?php echo $this->Form->input('total_igst', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Total IGST','readonly','step'=>0.01]); ?></td>
						<td align="left" colspan="2"><?php echo $this->Form->input('all_row_total', ['label' => false,'class' => 'form-control input-sm row_textbox','placeholder'=>'Total','readonly','step'=>0.01]); ?></td>
					<tr>
				</tfoot>
			</table>
			</div>
		</div><br/>
		<div class="row">
				<div class="col-md-9">
					<?php echo $this->Form->input('fright_text', ['type'=>'textarea','label' => false,'class' => 'form-control input-sm','placeholder'=>'Additional text for Fright Amount','style'=>['text-align:right']]); ?>
				</div>
				<div class="col-md-3">
					<div class="form-group">
							<label class="control-label">Fright Ledger Account</label>
							<div class="row">
								<div class="col-md-12">
									<?php echo $this->Form->input('fright_ledger_account', ['empty' => "--Fright Account--",'label' => false,'options' =>$ledger_account_details_for_fright,'class' => 'form-control input-sm select2me','required']); ?>
								</div>
							</div>
							<br/>
							<div class="row">
								<div class="col-md-12">
									<?php echo $this->Form->input('fright_amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm fright_amount','placeholder' => 'Fright Amount','step'=>0.01,'value'=>@$sales_order->fright_amount]); ?>
								</div>
							</div>
						</div>
					</div>
		</div>
		
		<div class="row">
				<div class="col-md-9" align="right"><b>GRAND TOTAL</b></div>
				<div class="col-md-3">
				<?php echo $this->Form->input('grand_total', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Grand Total','readonly','step'=>0.01]); ?>
				</div>
		</div><br/>
		
		<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-3 control-label">Additional Note</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('additional_note', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Additional Note']); ?>
						</div>
					</div>
				</div>
			</div><br/>
		</div>
		
					<?php $ref_types=['New Reference'=>'New Ref','Against Reference'=>'Agst Ref','Advance Reference'=>'Advance']; ?>
				
				<div class="row">
					<div class="col-md-8">
					<table width="100%" class="main_ref_table">
						<thead>
							<tr>
								<th width="25%">Ref Type</th>
								<th width="40%">Ref No.</th>
								<th width="30%">Amount</th>
								<th width="5%"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $this->Form->input('ref_types', ['empty'=>'--Select-','options'=>$ref_types,'label' => false,'class' => 'form-control input-sm ref_type']); ?></td>
								<td class="ref_no"></td>
								<td><?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount']); ?></td>
								<td><a class="btn btn-xs btn-default deleterefrow" href="#" role="button"><i class="fa fa-times"></i></a></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td align="center" style="vertical-align: middle !important;">On Account</td>
								<td></td>
								<td><?php echo $this->Form->input('on_account', ['label' => false,'class' => 'form-control input-sm on_account','placeholder'=>'Amount','readonly']); ?></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2"><a class="btn btn-xs btn-default addrefrow" href="#" role="button"><i class="fa fa-plus"></i> Add row</a></td>
								<td><input type="text" class="form-control input-sm" placeholder="total" readonly></td>
								<td></td>
							</tr>
						</tfoot>
					</table>
					</div>
				</div>
		<?php echo $this->Form->input('process_status', ['type' => 'hidden','value' => @$process_status]); ?>
		<?php echo $this->Form->input('sales_order_id', ['type' => 'hidden','value' => @$sales_order_id]); ?>
		
		<div class="form-actions">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
			   <?php if($chkdate == 'Not Found'){  ?>
					<label class="btn btn-danger"> You are not in Current Financial Year </label>
				<?php } else { ?>
					<?= $this->Form->button(__('ADD INVOICE'),['class'=>'btn btn-primary','id'=>'add_submit','type'=>'Submit']) ?>
				<?php } ?>	

				</div>
			</div>
		</div>
		
		<?= $this->Form->end() ?>
	</div>
</div>
<style>
.table thead tr th {
    color: black;
	background-color: #97b8ef;
}
</style>
<?php echo $this->Html->css('/drag_drop/jquery-ui.css'); ?>
<?php echo $this->Html->script('/drag_drop/jquery-1.12.4.js'); ?>
<?php echo $this->Html->script('/drag_drop/jquery-ui.js'); ?>
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
			company_id:{
				required: true,
			},
			date_created : {
				  required: true,
			},
			customer_id : {
				  required: true,
			},
			in1 : {
				  required: true,
			},			
			in3:{
				required: true
			},
			in4:{
				required: true,
			},
			customer_address:{
				required: true,
			},
			lr_no : {
				  required: true,
			},
			customer_po_no  : {
				  required: true,
			},
			employee_id: {
				  required: true,
			},
			customer_tin: {
				  required: true,
			},
			checked_row_length: {
				required: true,
				max : 1,
			},
		},

		messages: { // custom messages for radio buttons and checkboxes
			checked_row_length: {
				required : "Please select atleast one row.",
				max: "You can not select multiple rows of different sale tax rate."
			},
			customer_tin: {
				required: "Can't generate Invoice,Customer has not TIN"
			},
			service: {
				required: "Please select  at least 2 types of Service",
				minlength: jQuery.validator.format("Please select  at least {0} types of Service")
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
			put_code_description();
			success3.hide();
			error3.show();
			$("#add_submit").removeAttr("disabled");
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
			$('#add_submit').prop('disabled', true);
			$('#add_submit').text('Submitting.....');
		
			put_code_description();
			success3.show();
			error3.hide();
			form[0].submit();
		}

	});
	$('.quantity').die().live("keyup",function() {
		var qty =$(this).val();
		rename_rows(); calculate_total();
    });
	$('.discount_percentage').die().live("keyup",function() {
		var qty =$(this).val();
		rename_rows(); calculate_total();
    });

	
	$('.pnf_percentage').die().live("keyup",function() {
		var qty =$(this).val();
		rename_rows(); calculate_total();
    });
	
	$("select.cgst_percentage").die().live("change",function(){ 
		rename_rows(); calculate_total();
	})
	
	$("select.sgst_percentage").die().live("change",function(){ 
		rename_rows(); calculate_total();
	})
	
	$("select.igst_percentage").die().live("change",function(){ 
		rename_rows(); calculate_total();
	})
	

	$('.fright_amount').die().live("keyup",function() {
		var qty =$(this).val();
		rename_rows(); calculate_total();
    });
	
		
	$('.rename_check').die().live("click",function() {
		rename_rows();   calculate_total();
    });
	
	rename_rows();
	function rename_rows(){
		var list = new Array();
		var p=0;
		$("#main_tb tbody tr.tr1").each(function(){  
			var row_no=$(this).attr('row_no');
			
			var val=$(this).find('td:nth-child(18) input[type="checkbox"]:checked').val();
			if(val){ 
				$(this).find('td:nth-child(2) input').attr("name","invoice_rows["+val+"][item_id]").attr("id","invoice_rows-"+val+"-item_id").rules("add", "required");
				$(this).find('td:nth-child(3) input').removeAttr("readonly").attr("name","invoice_rows["+val+"][quantity]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-quantity").rules("add", "required");
				$(this).find('td:nth-child(4) input').attr("name","invoice_rows["+val+"][rate]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-rate").rules("add", "required");
				$(this).find('td:nth-child(5) input').attr("name","invoice_rows["+val+"][amount]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-amount").rules("add", "required");
				$(this).find('td:nth-child(6) input').attr("name","invoice_rows["+val+"][discount_percentage]").removeAttr("readonly").attr("id","q"+val).attr("id","invoice_rows-"+val+"-discount_percentage").rules("add", "required");
				$(this).find('td:nth-child(7) input').attr("name","invoice_rows["+val+"][discount_amount]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-discount_amount").rules("add", "required");
				$(this).find('td:nth-child(8) input').attr("name","invoice_rows["+val+"][pnf_percentage]").removeAttr("readonly").attr("id","q"+val).attr("id","invoice_rows-"+val+"-pnf_percentage").rules("add", "required");
				$(this).find('td:nth-child(9) input').attr("name","invoice_rows["+val+"][pnf_amount]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-pnf_amount").rules("add", "required");
				$(this).find('td:nth-child(10) input').attr("name","invoice_rows["+val+"][taxable_value]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-taxable_value").rules("add", "required");
				$(this).find('td:nth-child(11) select').select2().attr("name","invoice_rows["+val+"][cgst_percentage]").removeAttr("readonly").attr("id","q"+val).attr("id","invoice_rows-"+val+"-cgst_percentage");
				$(this).find('td:nth-child(12) input').attr("name","invoice_rows["+val+"][cgst_amount]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-cgst_amount").rules("add", "required");
				$(this).find('td:nth-child(13) select').select2().attr("name","invoice_rows["+val+"][sgst_percentage]").removeAttr("readonly").attr("id","q"+val).attr("id","invoice_rows-"+val+"-sgst_percentage");
				$(this).find('td:nth-child(14) input').attr("name","invoice_rows["+val+"][sgst_amount]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-sgst_amount").rules("add", "required");
				$(this).find('td:nth-child(15) select').select2().attr("name","invoice_rows["+val+"][igst_percentage]").removeAttr("readonly").attr("id","q"+val).attr("id","invoice_rows-"+val+"-igst_percentage");
				$(this).find('td:nth-child(16) input').attr("name","invoice_rows["+val+"][igst_amount]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-igst_amount").rules("add", "required");
				$(this).find('td:nth-child(17) input').attr("name","invoice_rows["+val+"][row_total]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-row_total").rules("add", "required");
				
				var htm=$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] >td').find('div.note-editable').html();
				
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] td:nth-child(1)').closest('td').html('');
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] td:nth-child(1)').append('<div id=summer'+row_no+'>'+htm+'</div>');
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] td:nth-child(1)').find('div#summer'+row_no).summernote();
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] td:nth-child(1)').append('<textarea name="invoice_rows['+val+'][description]"style="display:none;"></textarea>');
				$(this).css('background-color','#fffcda');
				
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]');
				var qty=$(this).find('td:nth-child(3) input[type="text"]').val();
				var serial_l=$('#main_tb tbody tr.tr3[row_no="'+row_no+'"] td:nth-child(2) select').length;
				
				if(serial_l>0){
					$('#main_tb tbody tr.tr3[row_no="'+row_no+'"] td:nth-child(2) select').removeAttr("readonly").attr("name","invoice_rows["+val+"][item_serial_numbers][]").attr("id","invoice_rows-"+val+"-item_serial_no").attr('maxlength',qty).select2().rules('add', {
						    required: true,
							minlength: qty,
							maxlength: qty,
							messages: {
								maxlength: "select serial number equal to quantity.",
								minlength: "select serial number equal to quantity."
							}
					});
				}
				$('#main_tb tbody tr.tr3[row_no="'+row_no+'"]').css('background-color','#fffcda');
				var s_tax=$(this).find('td:nth-child(6)').text();
				$(this).css('background-color','#fffcda');
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').css('background-color','#fffcda');
				p++;
			}			
			else{
				$(this).find('td:nth-child(2) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(3) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(4) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(5) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(6) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(7) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(8) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(9) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(10) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(11) select').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(12) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(13) select').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(14) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(15) select').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(16) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).css('background-color','#FFF');
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').css('background-color','#FFF');
				
				}
				
			});
			
				
					//alert(p);
				$("#checked_row_length").val(p.length);
		}
		
	function put_code_description(){
		var i=0;
			$("#main_tb tbody tr.tr1").each(function(){ 
				var row_no=$(this).attr('row_no');			
				var val=$(this).find('td:nth-child(7) input[type="checkbox"]:checked').val();
				
				if(val){
				var code=$('#main_tb tbody tr.tr2').find('div#summer'+val).code();
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').find('td:nth-child(1) textarea').val(code);
				}
			i++; 
		});
		
	}
		
	function calculate_total(){ 
		var total=0; var grand_total=0; var total_amt=0; var total_discount=0; var total_pnf=0; var total_taxable_value=0; var total_cgst=0; var total_sgst=0; var total_igst=0;  var total_row_amount=0
		$("#main_tb tbody tr.tr1").each(function(){
			var val=$(this).find('td:nth-child(18) input[type="checkbox"]:checked').val();
			if(val){
				var qty=parseInt($(this).find("td:nth-child(3) input").val());
				var Rate=parseFloat($(this).find("td:nth-child(4) input").val());
				var Amount=qty*Rate;
				$(this).find("td:nth-child(5) input").val(Amount.toFixed(2));
				var amount=parseFloat($(this).find("td:nth-child(5) input").val());
				total_amt=total_amt+amount;
				var discount_percentage=parseFloat($(this).find("td:nth-child(6) input").val());
				if(isNaN(discount_percentage)){ 
					 var discount_amount = 0; 
					$(this).find("td:nth-child(7) input").val(discount_amount.toFixed(2));
				}else{ 
					var amount=parseFloat($(this).find("td:nth-child(5) input").val());
					var discount_amount = (amount*discount_percentage)/100;
					$(this).find("td:nth-child(7) input").val(discount_amount.toFixed(2));
				}
				total_discount=total_discount+discount_amount;
				var pnf_percentage=parseFloat($(this).find("td:nth-child(8) input").val());
				if(isNaN(pnf_percentage)){ 
					 var pnf_amount = 0; 
					$(this).find("td:nth-child(9) input").val(pnf_amount.toFixed(2));
				}else{ 
					var amount=parseFloat($(this).find("td:nth-child(5) input").val());
					var amount_after_dis=amount-discount_amount;
					var pnf_amount = (amount_after_dis*pnf_percentage)/100;
					$(this).find("td:nth-child(9) input").val(pnf_amount.toFixed(2));
				}
				total_pnf=total_pnf+pnf_amount;
				var amount=parseFloat($(this).find("td:nth-child(5) input").val());
				var discount_amount=parseFloat($(this).find("td:nth-child(7) input").val());
				var pnf_amount=parseFloat($(this).find("td:nth-child(9) input").val());
				var taxable_value=(amount-discount_amount)+pnf_amount;
				$(this).find("td:nth-child(10) input").val(taxable_value.toFixed(2));
				total_taxable_value=total_taxable_value+taxable_value;
				var cgst_percentage=parseFloat($(this).find("td:nth-child(11) option:selected").attr("percentage"));
				if(isNaN(cgst_percentage)){ 
					 var cgst_amount = 0; 
					$(this).find("td:nth-child(12) input").val(cgst_amount.toFixed(2));
				}else{ 
					var taxable_value=parseFloat($(this).find("td:nth-child(10) input").val());
					var cgst_amount = (taxable_value*cgst_percentage)/100;
					$(this).find("td:nth-child(12) input").val(cgst_amount.toFixed(2));
				}
				total_cgst=total_cgst+cgst_amount;
				var sgst_percentage=parseFloat($(this).find("td:nth-child(13) option:selected").attr("percentage"));
				if(isNaN(sgst_percentage)){ 
					 var sgst_amount = 0; 
					$(this).find("td:nth-child(14) input").val(sgst_amount.toFixed(2));
				}else{ 
					var taxable_value=parseFloat($(this).find("td:nth-child(10) input").val());
					var sgst_amount = (taxable_value*sgst_percentage)/100;
					$(this).find("td:nth-child(14) input").val(sgst_amount.toFixed(2));
				}
				total_sgst=total_sgst+sgst_amount;
				var igst_percentage=parseFloat($(this).find("td:nth-child(15) option:selected").attr("percentage"));
				if(isNaN(igst_percentage)){ 
					 var igst_amount = 0; 
					$(this).find("td:nth-child(16) input").val(igst_amount.toFixed(2));
				}else{ 
					var taxable_value=parseFloat($(this).find("td:nth-child(10) input").val());
					var igst_amount = (taxable_value*igst_percentage)/100;
					$(this).find("td:nth-child(16) input").val(igst_amount.toFixed(2));
				}
				total_igst=total_igst+igst_amount;
					var taxable_value=parseFloat($(this).find("td:nth-child(10) input").val());
					var cgst_amount=parseFloat($(this).find("td:nth-child(12) input").val());
					var sgst_amount=parseFloat($(this).find("td:nth-child(14) input").val());
					var igst_amount=parseFloat($(this).find("td:nth-child(16) input").val());
					var row_total=taxable_value+cgst_amount+sgst_amount+igst_amount;
					total_row_amount=total_row_amount+row_total;
					$(this).find("td:nth-child(17) input").val(row_total.toFixed(2));
					grand_total=grand_total+row_total;
			}
			
			
			$('input[name="total_amt"]').val(total_amt.toFixed(2));
			$('input[name="total_discount"]').val(total_discount.toFixed(2));
			$('input[name="total_pnf"]').val(total_pnf.toFixed(2));
			$('input[name="total_taxable_value"]').val(total_taxable_value.toFixed(2));
			$('input[name="total_cgst"]').val(total_cgst.toFixed(2));
			$('input[name="total_sgst"]').val(total_sgst.toFixed(2));
			$('input[name="total_igst"]').val(total_igst.toFixed(2));
			$('input[name="all_row_total"]').val(total_row_amount.toFixed(2));
			
			var all_row_total=parseFloat($('input[name="all_row_total"]').val());
			var fright_amount=parseFloat($('input[name="fright_amount"]').val());
			if(isNaN(fright_amount)) { var fright_amount = 0; }
			grand_total=all_row_total+fright_amount;
			$('input[name="grand_total"]').val(grand_total.toFixed(2));
		});
	}
	
	
	$('.addrefrow').live("click",function() {
		add_ref_row();
	});
	
	function add_ref_row(){
		var tr=$("#sample_ref table.ref_table tbody tr").clone();
		$("table.main_ref_table tbody").append(tr);
		rename_ref_rows();
	}
	rename_ref_rows();
	function rename_ref_rows(){
		var i=0;
		$("table.main_ref_table tbody tr").each(function(){
			$(this).find("td:nth-child(1) select").attr({name:"ref_rows["+i+"][ref_type]", id:"ref_rows-"+i+"-ref_type"}).rules("add", "required");
			var is_select=$(this).find("td:nth-child(2) select").length;
			var is_input=$(this).find("td:nth-child(2) input").length;
			
			if(is_select){
				$(this).find("td:nth-child(2) select").attr({name:"ref_rows["+i+"][ref_no]", id:"ref_rows-"+i+"-ref_no"}).rules("add", "required");
			}else if(is_input){
				var url='<?php echo $this->Url->build(['controller'=>'Invoices','action'=>'checkRefNumberUnique']); ?>';
				url=url+'/<?php echo $c_LedgerAccount->id; ?>/'+i;
				$(this).find("td:nth-child(2) input").attr({name:"ref_rows["+i+"][ref_no]", id:"ref_rows-"+i+"-ref_no", class:"form-control input-sm ref_number"}).rules('add', {
							required: true,
							noSpace: true,
							notEqualToGroup: ['.ref_number'],
							remote: {
								url: url,
							},
							messages: {
								remote: "Not an unique."
							}
						});
			}
			
			$(this).find("td:nth-child(3) input").attr({name:"ref_rows["+i+"][ref_amount]", id:"ref_rows-"+i+"-ref_amount"}).rules("add", "required");
			i++;
		});
		
		var is_tot_input=$("table.main_ref_table tfoot tr:eq(1) td:eq(1) input").length;
		if(is_tot_input){
			$("table.main_ref_table tfoot tr:eq(1) td:eq(1) input").attr({name:"ref_rows_total", id:"ref_rows_total"}).rules('add', { equalTo: "#grand-total" });
		}
	}
	
	$('.deleterefrow').live("click",function() {
		$(this).closest("tr").remove();
		do_ref_total();
	});
	
	$('.ref_type').live("change",function() {
		var current_obj=$(this);
		
		var ref_type=$(this).find('option:selected').val();
		if(ref_type=="Against Reference"){
			var url="<?php echo $this->Url->build(['controller'=>'Invoices','action'=>'fetchRefNumbers']); ?>";
			url=url,
			$.ajax({
				url: url+'/<?php echo $c_LedgerAccount->id; ?>',
				type: 'GET',
			}).done(function(response) {
				current_obj.closest('tr').find('td:eq(1)').html(response);
				rename_ref_rows();
			});
		}else if(ref_type=="New Reference" || ref_type=="Advance Reference"){
			current_obj.closest('tr').find('td:eq(1)').html('<input type="text" class="form-control input-sm" placeholder="Ref No." >');
			rename_ref_rows();
		}else{
			current_obj.closest('tr').find('td:eq(1)').html('');
		}
	});
	
	$('.ref_list').live("change",function() {
		var current_obj=$(this);
		var due_amount=$(this).find('option:selected').attr('due_amount');
		$(this).closest('tr').find('td:eq(2) input').val(due_amount);
		do_ref_total();
	});
	
	$('.ref_amount_textbox').live("keyup",function() {
		do_ref_total();
	});
	
	function do_ref_total(){
		var main_amount=parseFloat($('input[name="grand_total"]').val());
		if(!main_amount){ main_amount=0; }
		
		var total_ref=0;
		$("table.main_ref_table tbody tr").each(function(){
			var am=parseFloat($(this).find('td:nth-child(3) input').val());
			if(!am){ am=0; }
			total_ref=total_ref+am;
		});
		
		var on_acc=main_amount-total_ref; 
		if(on_acc>=0){
			$("table.main_ref_table tfoot tr:nth-child(1) td:nth-child(3) input").val(on_acc.toFixed(2));
			total_ref=total_ref+on_acc;
		}else{
			$("table.main_ref_table tfoot tr:nth-child(1) td:nth-child(3) input").val(0);
		}
		$("table.main_ref_table tfoot tr:nth-child(2) td:nth-child(2) input").val(total_ref.toFixed(2));
	}
	
	
});
</script>


<?php $ref_types=['New Reference'=>'New Ref','Against Reference'=>'Agst Ref','Advance Reference'=>'Advance']; ?>
<div id="sample_ref" style="display:none;">
	<table width="100%" class="ref_table">
		<tbody>
			<tr>
				<td><?php echo $this->Form->input('ref_types', ['empty'=>'--Select-','options'=>$ref_types,'label' => false,'class' => 'form-control input-sm ref_type']); ?></td>
				<td class="ref_no"></td>
				<td><?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount']); ?></td>
				<td><a class="btn btn-xs btn-default deleterefrow" href="#" role="button"><i class="fa fa-times"></i></a></td>
			</tr>
		</tbody>
	</table>
</div>