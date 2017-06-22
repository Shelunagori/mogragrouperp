<style>
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
<?php 
$this->Form->templates([
				'inputContainer' => '{{content}}'
			]);
			?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Add Purchase Return</span>
		</div>
		
	</div>
	
	
	<div class="portlet-body form">
		<?= $this->Form->create($purchaseReturn,['id'=> 'form_sample_3']) ?>
		
			<div class="form-body">
			
				<div class="row">
					
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">GRN No.</label>
							<br/>
							<?= h(($invoiceBooking->grn->grn1.'/GRN-'.str_pad($invoiceBooking->grn->grn2, 3, '0', STR_PAD_LEFT).'/'.$invoiceBooking->grn->grn3.'/'.$invoiceBooking->grn->grn4)) ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Supplier </label>
							<br/>
							<?php  echo @$invoiceBooking->grn->vendor->company_name; ?>
						</div>
					</div>
					<div class="col-md-3" >
						<div class="form-group">
							<label class="control-label">Invoice Booking No</label></br>
							<?php echo $invoiceBooking->ib1.'/IB-'.str_pad($invoiceBooking->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoiceBooking->ib3.'/'.$invoiceBooking->ib4; ?>
							<br/>
							<? ?>
						</div>
					</div>
					<div class="col-md-2 pull-right">
									<div class="form-group">
										<label class="control-label">Date</label>
										<br/>
										<?php echo date("d-m-Y"); ?> <br >
											<span style="color: red;">
												<?php if($chkdate == 'Not Found'){  ?>
													You are not in Current Financial Year
												<?php } ?>
											</span>
									</div>
								</div>
				</div><br/>
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Supplier Invoice Date. <span class="required" aria-required="true">*</span></label><br/>
							<?php echo @date("d-m-Y",strtotime($invoiceBooking->supplier_date)); ?>
							
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Invoice No. <span class="required" aria-required="true">*</span></label><br/>
							<?php echo @$invoiceBooking->ib1; ?>/<?php echo @$invoiceBooking->ib3; ?>/<?php echo substr($s_year_from, -2).'-'.substr($s_year_to, -2); ?>
							<br/>
							<? ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Purchase Account <span class="required" aria-required="true">*</span></label><br/>
							<?php echo $ledger_account_details->name; ?>
							<br/>
							<? ?>
						</div>
					</div>
					<?php if(($st_company_id==25 && $ledger_account_details->id != 35) || ($st_company_id==26 && $ledger_account_details->id != 161) || ($st_company_id==27 && $ledger_account_details->id != 309) ) {?>
					<div class="col-md-3">
						<div class="form-group" >
							<label class="control-label">Ledger Account for VAT<span class="required" aria-required="true">*</span></label><br/>
							<?php echo $ledger_account_vat->name; ?>
							<br/>
							<? ?>
						</div>
					</div>
					<?php } ?>
				</div>
			<div style="overflow: auto;">
			<input type="text"  name="checked_row_length" id="checked_row_length" style="height: 0px;padding: 0;border: none;" value="" />
				<table class="table tableitm" id="main_tb">
				<thead>
					<tr>
						<th width="5%">Sr.No. </th>
						<th >Items</th>
						<th  width="4%"></th>
						<th align="center" width="10%">Quantity</th>
						<th align="center" width="10%">Ammount</th>
						<th  width="4%"></th>
						
					</tr>
				</thead>
				<tbody>
					<?php
					$q=0; foreach ($invoiceBooking->invoice_booking_rows as $invoice_booking_row): ?>
						<tr class="tr1" row_no='<?php echo @$invoice_booking_row->id; ?>'>
							<td ><?php echo ++$q; ?></td>
							<td style="white-space: nowrap;"><?php echo $invoice_booking_row->item->name; ?>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.item_id', ['label' => false,'class' => 'form-control input-sm','type'=>'hidden','value' => @$invoice_booking_row->item->id]); ?>
							</td>
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.ib_ammount',['label' => false,'class' => 'form-control input-sm','type'=>'hidden','value'=>$invoice_booking_row->total]); ?>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.ib_quantity',['label' => false,'class' => 'form-control input-sm','type'=>'hidden','value'=>$invoice_booking_row->quantity]); ?>
							</td>
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.quantity',['label' => false,'class' => 'form-control input-sm quantity','type'=>'text','value'=>$invoice_booking_row->quantity,'max'=>$invoice_booking_row->quantity]); ?></td>
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.ib_ammount',['label' => false,'class' => 'form-control input-sm','type'=>'hidden','value'=>$invoice_booking_row->total]); ?>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.total',['label' => false,'class' => 'form-control input-sm','type'=>'text','value'=>$invoice_booking_row->total]); ?></td>
							<td>
								<label><?php echo $this->Form->input('check.'.$q, ['label' => false,'type'=>'checkbox','class'=>'rename_check','value' => @$invoice_booking_row->item->id]); ?></label>
							</td>
						</tr>
					<?php   endforeach; ?>
				</tbody>
			</table>
			</div>
			<div class="row">
				<div class="col-md-9" ></div>
				<div class="col-md-3">
					<div class="col-md-3">Total</div>
						<div class="col-md-9"><input type="text" id="grand-total" name="grand_total" class="form-control input-sm" placeholder="0.0"  value=""></div>
					
				</div>
			</div>
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
		<div class="form-actions">
			<div class="row">
				<div class="col-md-3">

				<?php if($chkdate == 'Not Found'){  ?>
					<label class="btn btn-danger"> You are not in Current Financial Year </label>
				<?php } else { ?>
				<?= $this->Form->button(__('UPDATE BOOK INVOICE'),['class'=>'btn btn-primary','id'=>'add_submit','type'=>'Submit']) ?>
				<?php } ?>	


					
				</div>
			</div>
		</div>
	</div>	
		<?= $this->Form->end() ?>
</div>	
						

<style>
.table thead tr th {
    color: #FFF;
	background-color: #254b73;
}
</style>
<?php echo $this->Html->css('/drag_drop/jquery-ui.css'); ?>
<?php echo $this->Html->script('/drag_drop/jquery-1.12.4.js'); ?>
<?php echo $this->Html->script('/drag_drop/jquery-ui.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	}, "No space please and don't leave it empty");
	
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
	}, jQuery.format("Please enter a Unique Value."));
	//--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
			checked_row_length: {
				required: true,
				min : 1,
			},
		},

		messages: { // custom messages for radio buttons and checkboxes
			checked_row_length: {
				required : "Please select atleast one row.",
				min: "Please select atleast one row."
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
			
			rename_rows();
			success3.show();
			error3.hide();
			form[0].submit();
		}
	});	

	
	$('.rename_check').die().live("click",function() {
		rename_rows();    calculate_total();
    });	
	$('.quantity').die().live("keyup",function() {
		var qty =$(this).val();
			rename_rows(); 
    });
	rename_rows();
	function rename_rows(){
		var i=0;
		$("#main_tb tbody tr.tr1").each(function(){  //alert();
			var row_no=$(this).attr('row_no');
			var val=$(this).find('td:nth-child(6) input[type="checkbox"]:checked').val();
			if(val){
				i++;
				$(this).find('td:nth-child(2) input').attr("name","purchase_return_rows["+row_no+"][item_id]").attr("id","purchase_return_rows-"+row_no+"-item_id").rules("add", "required");
				$(this).find('td:nth-child(3) input:eq(0)').attr("name","purchase_return_rows["+row_no+"][ib_ammount]").attr("id","purchase_return_rows-"+row_no+"-ib_ammount").removeAttr("readonly").rules("add", "required");
				$(this).find('td:nth-child(3) input:eq(1)').attr("name","purchase_return_rows["+row_no+"][ib_quantity]").attr("id","purchase_return_rows-"+row_no+"-ib_quantity").removeAttr("readonly").rules("add", "required");
				
				$(this).find('td:nth-child(4) input').attr("name","purchase_return_rows["+row_no+"][quantity]").attr("id","purchase_return_rows-"+row_no+"-quantity").removeAttr("readonly").rules("add", "required");
				$(this).find('td:nth-child(5) input').attr("name","purchase_return_rows["+row_no+"][total]").attr("id","purchase_return_rows-"+row_no+"-total").rules("add", "required");
				$(this).css('background-color','#fffcda');
			}else{
				$(this).find('td:nth-child(2) input').attr({ name:"q" , readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(3) input').attr({ name:"q" , readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(3) input').attr({ name:"q" , readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(4) input').attr({ name:"q" , readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(5) input').attr({ name:"q" , readonly:"readonly"}).rules( "remove", "required" );
				$(this).css('background-color','#FFF');
				
			} 
			
			$('input[name="checked_row_length"]').val(i);
			
		});
	}
	$('.quantity').die().live("keyup",function() {
			calculate_total(); 
    });
	calculate_total();
	function calculate_total(){
		var grand_total=0;
		$("#main_tb tbody tr.tr1").each(function(){  
			var val=$(this).find('td:nth-child(6) input[type="checkbox"]:checked').val();
			if(val){
				var Rate=parseFloat($(this).find("td:nth-child(3) input:eq(0)").val());
				var id_qty=parseFloat($(this).find("td:nth-child(3) input:eq(1)").val());
				var per_qty=Rate/id_qty;
				var qty=parseInt($(this).find("td:nth-child(4) input").val());
				var Amount=per_qty*qty;
				
				grand_total=grand_total+Amount;
				$(this).find("td:nth-child(5) input").val(Amount.toFixed(2));
				}
				$('input[name="grand_total"]').val(grand_total.toFixed(2));
		});
	}
	$('.addrefrow').live("click",function() { 
		 add_ref_row();
	});
	add_ref_row();
	function add_ref_row(){
		var tr=$("#sample_ref table.ref_table tbody tr").clone();
		$("table.main_ref_table tbody").append(tr);
		rename_ref_rows();
	}
	//rename_ref_rows();
		function rename_ref_rows(){
		var i=0;
		$("table.main_ref_table tbody tr").each(function(){
			//alert();
			$(this).find("td:nth-child(1) select").attr({name:"ref_rows["+i+"][ref_type]", id:"ref_rows-"+i+"-ref_type"}).rules("add", "required");
			var is_select=$(this).find("td:nth-child(2) select").length;
			var is_input=$(this).find("td:nth-child(2) input").length;
			
			if(is_select){
				$(this).find("td:nth-child(2) select").attr({name:"ref_rows["+i+"][ref_no]", id:"ref_rows-"+i+"-ref_no"}).rules("add", "required");
			}else if(is_input){
				var url='<?php echo $this->Url->build(['controller'=>'PurchaseReturns','action'=>'checkRefNumberUnique']); ?>';
				url=url+'/<?php echo $v_LedgerAccount->id; ?>/'+i;
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
			var url="<?php echo $this->Url->build(['controller'=>'PurchaseReturns','action'=>'fetchRefNumbers']); ?>";
			//alert(<?php echo $v_LedgerAccount->id; ?>);
			url=url,
			$.ajax({
				url: url+'/<?php echo $v_LedgerAccount->id; ?>',
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
