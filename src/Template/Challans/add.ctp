<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Create Challan</span>
		</div>
	</div>
	<div class="portlet-body form">
		<?= $this->Form->create($challan,['id'=>'form_sample_3']) ?>
		<div class="form-body">
			<div class="row">
				<div class="col-md-2">
						<div class="form-group">
							<div class="radio-list" >
							<label class="control-label">Challan Type <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->radio('challan_type',[['value' => 'Returnable', 'text' => 'Returnable'],['value' => 'Non Returnable', 'text' => 'Non Returnable']]); ?>
							</div>
						</div>
				</div>
				<div class="col-md-2">
						<div class="form-group">
							<div class="radio-list" >
							<label class="control-label">Challan For<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->radio('challan_for',[['value' => 'Customer', 'text' => 'Customer','id' => 'id_radio1','checked'=>'checked'],['value' => 'Vendor', 'text' => 'Vendor','id' => 'id_radio2']]); ?>
							</div>
						</div>
				</div>
					
					<div class="col-md-3" id="customer_div">
						<div class="form-group">
							<label class="control-label">Customers <span class="required" aria-required="true">*</span></label>
							
								<?php
									$options=array();
									foreach($customers as $customer){
										$merge=$customer->customer_name.'	('.$customer->alias.')';
										$options[]=['text' =>$merge, 'value' => $customer->id, 'contact_person' => $customer->contact_person, 'employee_id' => $customer->employee_id,'transporter_id' => $customer->transporter_id];
									}
							echo $this->Form->input('customer_id', ['empty' => "--Select--",'label' => false,'options' => $options,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
					
					<div class="col-md-3" id="vendor_div" style="display:none;">
						<div class="form-group">
							<label class="control-label">Vendors <span class="required" aria-required="true">*</span></label>
							
								<?php
									$options=array();
									foreach($vendors as $vendor){
										$options[]=['text' =>$vendor->company_name, 'value' => $vendor->id, 'v_address'=>$vendor->address];
									}
							echo $this->Form->input('vendor_id', ['empty' => "--Select--",'label' => false,'options' => $options,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
					<div class="col-md-2">
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">Date</label>
							<?php echo $this->Form->input('created_on', ['type' => 'text','label' => false,'class' => 'form-control input-sm','value' => date("d-m-Y"),'readonly']); ?>
						</div>
						<span style="color: red;"><?php if($chkdate == 'Not Found'){  ?>
					You are not in Current Financial Year
				<?php } ?></span>
					</div>
				</div>
				<div class="row">
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Challan No. <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<div class="col-md-4">
									<?php echo $this->Form->input('ch1', ['label' => false,'class' => 'form-control input-sm','readonly','value'=>$Company->alias]); ?>
								</div>
								<div class="col-md-4" id="ch3_div">
									<?php echo $this->Form->input('ch3', ['empty' => "Select",'options'=>$filenames,'label' => false,'class' => 'form-control input-sm select2me']); ?>
								</div>
								<div class="col-md-4">
									<?php echo $this->Form->input('ch4', ['label' => false,'value'=>substr($s_year_from, -2).'-'.substr($s_year_to, -2),'class' => 'form-control input-sm','readonly']); ?>
								</div>
							</div>
						</div>
					</div>
					
				<div class="col-md-3" id="invoice_div">
						<div class="form-group">
							<label class="control-label">Invoice No. <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<?php
									$options=array();
									foreach($invoices as $invoice){
										$merge=(($invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4));
										$options[]=['text' =>$merge, 'value' => $invoice->id];
									}
									echo $this->Form->input('invoice_id', ['empty' => "--Select--",'label' => false,'options' => $options,'class' => 'form-control input-sm select2me']); ?>
							</div>
						</div>
					</div>
					
					<div class="col-md-3" id="invoice_booking_div" style="display:none;">
						<div class="form-group">
							<label class="control-label">Invoice Booking No. <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<?php
									$options=array();
									foreach($invoice_bookings as $invoice_booking){
									$merge=(($invoice_booking->ib1.'/IB-'.str_pad($invoice_booking->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoice_booking->ib3.'/'.$invoice_booking->ib4));
									$options[]=['text' =>$merge, 'value' => $invoice_booking->id];
									}
									echo $this->Form->input('invoice_booking_id', ['empty' => "--Select--",'label' => false,'options' => $options,'class' => 'form-control input-sm select2me']); ?>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Lr No. <span class="required" aria-required="true">*</span></label>
							
							<?php echo $this->Form->input('lr_no', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'LR No','type'=>'text']); ?>
							
						</div>
					</div>
					
				</div><br/>
		
				
				<div class="row">
					<div class="col-md-4" id="customer_address_div">
						<div class="form-group">
							<label class="control-label">Address <span class="required" aria-required="true">*</span></label>
							
							<?php echo $this->Form->textarea('customer_address', ['label' => false,'class' => 'form-control','placeholder' => 'Address']); ?>
							<a href="#" role="button" class="pull-right select_address" >
							Select Address </a>
						</div>
					</div>
					<div class="col-md-4" id="vendor_address_div" style="display:none;">
						<div class="form-group">
							<label class="control-label">Address <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->textarea('vendor_address', ['label' => false,'class' => 'form-control','placeholder' => 'Address']); ?>
						</div>
					</div>	
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Courier <span class="required" aria-required="true">*</span></label>
							<div class="row">
							<?php 
							echo $this->Form->input('transporter_id',['empty'=>'--Select--','options'=>$transporters,'label' => false,'class' => 'form-control input-sm select2me']); ?>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="radio-list" >
							<label class="control-label">Pass Credit Note<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->radio('pass_credit_note',[['value' => 'Yes', 'text' => 'Yes'],['value' => 'No', 'text' => 'No']]); ?>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="radio-list" >
							<label class="control-label">Pass Debit Note<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->radio('pass_debit_note',[['value' => 'Yes', 'text' => 'Yes'],['value' => 'No', 'text' => 'No']]); ?>
							</div>
						</div>
					</div>
				</div>
		
			<br/>
			
			<table class="table tableitm" id="main_tb">
				<thead>
					<tr>
						<th width="50">Sr.No. </th>
						<th>Items</th>
						<th width="130">Quantity</th>
						<th width="130">Rate</th>
						<th width="130">Amount</th>
						<th width="70"></th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" align="right"><b>Total</b></td>
						<td><?php echo $this->Form->input('total', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total']); ?></td>
						<td></td>
					</tr>
				</tfoot>
			</table>
			
			<label class="control-label">Documents  </label>
			<?php echo $this->Form->textarea('documents', ['label' => false,'class' => 'form-control ']); ?>
			<br/>
			
			
			<label class="control-label">Reference Detail  </label>
			<?php echo $this->Form->textarea('reference_detail', ['label' => false,'class' => 'form-control ']); ?>
			<br/>
			
			
			<br/>
			
		</div>
		<div class="form-actions">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					<?php if($chkdate == 'Not Found'){  ?>
					<label class="btn btn-danger"> You are not in Current Financial Year </label>
				<?php } else { ?>
					<button type="submit" class="btn btn-primary" id='submitbtn' >GENERATE CHALLAN</button>
				<?php } ?>	
					
				</div>
			</div>
		</div>
		
		<?= $this->Form->end() ?>
	</div>
</div>
<style>
.table thead tr th {
    color: #FFF;
	background-color: #254b73;
}
.padding-right-decrease{
	padding-right: 0;
}
.padding-left-decrease{
	padding-left: 0;
}
</style>


<table id="sample_tb" style="display:none;">
	<tbody>
		<tr class="tr1">
			<td rowspan="2" width="10">0</td>
			<td>
				<div class="row">
					<div class="col-md-11 padding-right-decrease" id="item_div">
						<?php echo $this->Form->input('item_id', ['empty'=>'Select','options' => $items,'label' => false,'class' => 'form-control input-sm select2-offscreen item_box item_id','placeholder' => 'Item']); ?>
					</div>
					<div class="col-md-1 padding-left-decrease">
						
						<div class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false" style="display: none; padding-right: 12px;"><div class="modal-backdrop fade in" ></div>
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-body" >
										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn default closebtn">Close</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</td>
			<td width="100"><?php echo $this->Form->input('quantity[]', ['label' => false,'class' => 'form-control input-sm','placeholder' => 'Quantity']); ?></td>
			<td width="130"><?php echo $this->Form->input('rate[]', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Rate']); ?></td>
			<td width="130"><?php echo $this->Form->input('amount[]', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Amount']); ?></td>
			<td  width="70"><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
		<tr class="tr2">
			<td colspan="4"><?php echo $this->Form->textarea('description', ['label' => false,'class' => 'form-control input-sm autoExpand','placeholder' => 'Description','rows'=>'1']); ?></td>
			<td></td>
		</tr>
	</tbody>
</table>

<div id="terms_conditions" style="display:none;"></div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<style>
#sortable li{
	cursor: -webkit-grab;
}
</style>
<?php echo $this->Html->css('/drag_drop/jquery-ui.css'); ?>
<?php echo $this->Html->script('/drag_drop/jquery-1.12.4.js'); ?>
<?php echo $this->Html->script('/drag_drop/jquery-ui.js'); ?>
<script>
$( function() {
$( "#sortable" ).sortable();
$( "#sortable" ).disableSelection();
} );
</script>
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
				company_id:{
					required: true,
				},
				customer_id : {
					required: true,
				},
				customer_address : {
					required: true,
				},
				vendor_id : {
					required: true,
				},
				invoice_id:{
					required: true,	
				},
				invoice_booking_id:{
					required: true,	
				},
				ch3:{
					required: true,	
				},
				pass_credit_note:{
					required: true,	
				},
				pass_debit_note:{
					required: true,	
				},
			},
	

		messages: { // custom messages for radio buttons and checkboxes
			membership: {
				required: "Please select a Membership type"
			},
			service: {
				required: "Please select  at least 2 types of Service",
				minlength: jQuery.validator.format("Please select  at least {0} types of Service")
			}
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
			$('#submitbtn').prop('disabled', true);
			$('#submitbtn').text('Submitting.....');		
		q="ok";
			$("#main_tb tbody tr.tr1").each(function(){
				var it=$(this).find("td:nth-child(2) select").val();
				var w=$(this).find("td:nth-child(3) input").val();
				var r=$(this).find("td:nth-child(4) input").val();
				if(it=="" || w=="" || r==""){
					q="e";
				}
			});
			$("#main_tb tbody tr.tr2").each(function(){
				var d=$(this).find("td:nth-child(1) textarea").val();
				if(d==""){
					q="e";
				}
			});
			if(q=="e"){
				$("#row_error").show();
				return false;
			}else{
				success3.show();
				error3.hide();
				form[0].submit(); // submit the form
			}
		}

	});
	//--	 END OF VALIDATION
	rename_rows();
    add_row();
    $('.addrow').die().live("click",function() { 
		add_row();
    });
	
	var terms_conditions=$("#terms_conditions").text();
	$('textarea[name="terms_conditions"]').val(terms_conditions);
	
	$('.deleterow').die().live("click",function() {
		var l=$(this).closest("table tbody").find("tr").length;
		if (confirm("Are you sure to remove row ?") == true) {
			if(l>2){
				var row_no=$(this).closest("tr").attr("row_no");
				var del="tr[row_no="+row_no+"]";
				$(del).remove();
				rename_rows();
				calculate_total();
			}
		} 
    });
	

	
		function add_row(){
		var tr1=$("#sample_tb tbody tr.tr1").clone();
		$("#main_tb tbody").append(tr1);
		var tr2=$("#sample_tb tbody tr.tr2").clone();
		$("#main_tb tbody").append(tr2);
		
		var w=0; var r=0;
		$("#main_tb tbody tr").each(function(){
			$(this).attr("row_no",w);
			r++;
			if(r==2){ w++; r=0; }
		});
		rename_rows();
		}
	
	rename_rows();	
	function rename_rows(){
	var i=0;
			$("#main_tb tbody tr.tr1").each(function(){
				$(this).find("td:nth-child(1)").html(++i); --i;
				//$(this).find("td:nth-child(2) select").select2().attr({name:"challan_rows["+i+"][item_id]", id:"challan_rows-"+i+"-item_id"}).rules("add", "required");
				$(this).find("td:nth-child(2) select").select2().attr({name:"challan_rows["+i+"][item_id]", id:"challan_rows-"+i+"-item_id",popup_id:i}).rules('add', {
							required: true,
							notEqualToGroup: ['.item_id'],
							messages: {
								notEqualToGroup: "Do not select same Item again."
							}
						});
				$(this).find("td:nth-child(3) input").attr({name:"challan_rows["+i+"][quantity]", id:"challan_rows-"+i+"-quantity"}).rules('add', {
						required: true,
						digits: true,
						min: 1,
						messages: {
							min: "Quantity can't be zero."
						}
					});
				$(this).find("td:nth-child(4) input").attr({name:"challan_rows["+i+"][rate]", id:"challan_rows-"+i+"-rate",r_popup_id:i}).rules('add', {
						required: true,
						number: true,
						min: 0.01
					});
				$(this).find("td:nth-child(5) input").attr({name:"challan_rows["+i+"][amount]", id:"challan_rows-"+i+"-amount"});
				i++; 
			});
			var i=0;
			$("#main_tb tbody tr.tr2").each(function(){
				
				$(this).find("td:nth-child(1) textarea").attr("name","challan_rows["+i+"][description]");
				i++; 
			});	
	}
	
	$('#main_tb input').die().live("keyup","blur",function() { 
		calculate_total();
    });
	function calculate_total(){
		var total=0;
		$("#main_tb tbody tr.tr1").each(function(){
			var unit=$(this).find("td:nth-child(3) input").val();
			var Rate=$(this).find("td:nth-child(4) input").val();
			var Amount=unit*Rate;
			$(this).find("td:nth-child(5) input").val(Amount.toFixed(2));
			total=total+Amount;
		});
		$('input[name="total"]').val(total.toFixed(2));
	}
	
	$('.select_address').on("click",function() { 
		open_address();
    });
	
	$('.closebtn').live("click",function() { 
		$(".modal").hide();
    });
	
	$('.popup_btn').live("click",function() {
		var popup_id=$(this).attr('popup_id');
		$("div[popup_div_id="+popup_id+"]").show();
    });
	
	function open_address(){
		var customer_id=$('select[name="customer_id"]').val();
		$("#result_ajax").html('<div align="center"><?php echo $this->Html->image('/img/wait.gif', ['alt' => 'wait']); ?> Loading</div>');
		var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'addressList']); ?>";
		url=url+'/'+customer_id,
		$("#myModal1").show();
		$.ajax({
			url: url,
		}).done(function(response) {
			$("#result_ajax").html(response);
		});
	}
	
	$('.insert_address').die().live("click",function() { 
		var addr=$(this).text();
		$('textarea[name="customer_address"]').val(addr);
		$("#myModal1").hide();
    });
	
	
	$('select[name="vendor_id"]').on("change",function() {
		var vaddress=$('select[name="vendor_id"] option:selected').attr('v_address');
		$('textarea[name="vendor_address"]').val(vaddress);
	});
	
	$('select[name="customer_id"]').on("change",function() {
		var contact_person=$('select[name="customer_id"] option:selected').attr('contact_person');
		$('input[name="customer_for_attention"]').val(contact_person);
		
		var transporter_id=$('select[name="customer_id"] option:selected').attr("transporter_id");
		$("select[name=transporter_id]").val(transporter_id).select2();	
		
		var customer_id=$('select[name="customer_id"] option:selected').val(); 
		var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'defaultAddress']); ?>";
		url=url+'/'+customer_id,
		$.ajax({
			url: url,
		}).done(function(response) {
			$('textarea[name="customer_address"]').val(response);
		});
		
		var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'defaultContact']); ?>";
		url=url+'/'+customer_id,
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json'
		}).done(function(response) {
			$('input[name="customer_for_attention"]').val(response.contact_person);
			$('input[name="customer_contact"]').val(response.mobile);
		});
		
		$("#ch3_div").html('Loading...');
		var url="<?php echo $this->Url->build(['controller'=>'Filenames','action'=>'listFilename']); ?>";
		url=url+'/'+customer_id,
		$.ajax({
			url: url,
		}).done(function(response) {
			$("#ch3_div").html(response);
		});
		
		var employee_id=$('select[name="customer_id"] option:selected').attr("employee_id");
		$("select[name=employee_id]").val(employee_id);
    });
	
	$('select[name="company_id"]').on("change",function() {
		var alias=$('select[name="company_id"] option:selected').attr("alias");
		$('input[name="qt1"]').val(alias);
    });
	
	$('.select_term_condition').die().live("click",function() { 
		var addr=$(this).text();
		$("#myModal2").show();
    });
	
	$('.closebtn2').on("click",function() { 
		$("#myModal2").hide();
    });
	
	$('.insert_tc').die().live("click",function() {
		$('#sortable').html("");
		
		$(".tabl_tc tbody tr").each(function(){
			var v=$(this).find('td:nth-child(1) input[type="checkbox"]:checked').val();
			if(v){
				var tc=$(this).find('td:nth-child(2)').text();
				$('#sortable').append('<li class="ui-state-default">'+tc+'</li>');
			}
		});
		var terms_conditions=$("#terms_conditions").text();
		$('textarea[name="terms_conditions"]').val(terms_conditions);
		$("#myModal2").hide();
    });
	
	function copy_term_condition_to_textarea(){
		$('#terms_conditions').html("");
		var inc=0;
		$("#sortable li").each(function(){
			var tc=$(this).text();
			++inc;
			$('#terms_conditions').append(inc+". "+tc+"&#13;&#10;");
		});
		var terms_conditions=$("#terms_conditions").text();
		$('textarea[name="terms_conditions"]').val(terms_conditions);
	}
	
	$(".updatetc").die().on("click",function(){
		copy_term_condition_to_textarea();
	})
	
	$('#id_radio2').click(function () {
		
        $('#vendor_div').show('fast');
		$('#customer_div').hide('fast');
		$('#vendor_address_div').show('fast');
		$('#customer_address_div').hide('fast');
		$('#invoice_div').hide('fast');
		$('#invoice_booking_div').show('fast');
	});
				 
	$('#id_radio1').click(function () {
        $('#vendor_div').hide('fast');
		$('#customer_div').show('fast');    
		$('#vendor_address_div').hide('fast');
		$('#customer_address_div').show('fast');
		$('#invoice_div').show('fast');
		$('#invoice_booking_div').hide('fast');
	});
	
	$('select[name="customer_id"]').on("change",function() {
		var in_id=$(this).val();
		customerInvoice(in_id,'Customers');
	});
	function customerInvoice(in_id,source_model){
		var url = "<?php echo $this->Url->build(['controller'=>'Challans','action'=>'customerInvoice']);?>";
		url=url+'/'+in_id+'/'+source_model,
        $.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) { 
			$('#invoice_div').html(response);
			
		});
		
	}
	$('select[name="vendor_id"]').on("change",function() {
		var in_id=$(this).val(); 
		invoice_bookings(in_id,'Vendors');
	});
	function invoice_bookings(in_id,source_model){
		var url = "<?php echo $this->Url->build(['controller'=>'Challans','action'=>'vendorInvoicebooking']);?>";
		url=url+'/'+in_id+'/'+source_model,
        $.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) { 
			$('#invoice_booking_div').html(response);
			
		});
		
	}
	
	$('select[name="invoice_id"]').live("change",function() {  
		var in_id=$(this).val(); 
		itemsAsInvoice(in_id,'Invoices');
	});
	
	$('select[name="invoice_booking_id"]').live("change",function() { 
		var in_id=$(this).val();
		itemsAsInvoice(in_id,'Invoice_Booking');
	});
     		
	function itemsAsInvoice(in_id,source_model){ 
		var url = "<?php echo $this->Url->build(['controller'=>'Challans','action'=>'itemsAsInvoice']);?>";
		url=url+'/'+in_id+'/'+source_model,
        $.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			$('#sample_tb #item_div').html(response);
			$("#main_tb tbody tr").remove();
			add_row();
		});
	}
	
	
});

</script>

	 
<div id="myModal1" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false" style="display: none; padding-right: 12px;"><div class="modal-backdrop fade in" ></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" id="result_ajax">
				
			</div>
			<div class="modal-footer">
				<button class="btn default closebtn">Close</button>
			</div>
		</div>
	</div>
</div>


