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
<?php $ref_types=['New Reference'=>'New Ref','Against Reference'=>'Agst Ref','Advance Reference'=>'Advance']; ?>
<?php $cr_dr_options=['Cr'=>'Cr','Dr'=>'Dr']; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Edit Receipt</span>
		</div>
	</div>
	<div class="portlet-body form">
    <?= $this->Form->create($receipt,['id'=>'form_sample_3']) ?>
        <div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Transaction Date<span class="required" aria-required="true">*</span></label>
					<?php echo $this->Form->input('transaction_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','value' => date("d-m-Y",strtotime($receipt->transaction_date)),'data-date-start-date' => date("d-m-Y",strtotime($financial_year->date_from)),'data-date-end-date' => date("d-m-Y",strtotime($financial_year->date_to))]); ?>
				</div>

					<span style="color: red;">
						<?php if($chkdate == 'Not Found'){  ?>
							You are not in Current Financial Year
						<?php } ?>
					</span>				

				</div>
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Bank/Cash Account<span class="required" aria-required="true">*</span></label>
					<?php echo $this->Form->input('bank_cash_id', ['empty'=>'--Select-','label' => false,'class' => 'form-control input-sm select2me']); ?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Mode of Payment<span class="required" aria-required="true">*</span></label>
					<div class="radio-list">
						<div class="radio-inline" >
						<?php echo $this->Form->radio(
							'payment_mode',
							[
								['value' => 'Cheque', 'text' => 'Cheque','checked'],
								['value' => 'Cash', 'text' => 'Cash'],
								['value' => 'NEFT/RTGS', 'text' => 'NEFT/RTGS']
							]
						); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group" id="chq_no">
					<label class="control-label">Cheque No<span class="required" aria-required="true">*</span></label>
					<?php echo $this->Form->input('cheque_no', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Cheque No']); ?>
				</div>
			</div>
		</div>
		
		<div style="overflow: auto;">
		<table width="100%" id="main_table">
			<thead>
				<th width="25%"><label class="control-label">Received From</label></th>
				<th width="20%"><label class="control-label">Amount</label></th>
				<th></th>
				<th width="3%"></th>
			</thead>
			<tbody id="main_tbody">
			<?php foreach($receipt->receipt_rows as $receipt_row){ ?> 
				<tr class="main_tr" old_received_from_id="<?php echo $receipt_row->received_from_id; ?>">
					<td><?php echo $this->Form->input('received_from_id', ['empty'=>'--Select-','options'=>$receivedFroms,'label' => false,'class' => 'form-control input-sm received_from','value'=>$receipt_row->received_from_id]); ?></td>
					<td>
					<div class="row">
						<div class="col-md-7" style="padding-right: 0;">
							<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm mian_amount','placeholder'=>'Amount','value'=>$receipt_row->amount]); ?>
						</div>
						<div class="col-md-5"style="padding-left: 0;">
							<?php echo $this->Form->input('cr_dr', ['label' => false,'options'=>$cr_dr_options,'class' => 'form-control input-sm cr_dr','value'=>$receipt_row->cr_dr]); ?>
						</div>
					</div>
					</td>
					<td>
					
						<div class="ref" style="padding:4px;">
						<table width="100%" class="ref_table">
							<thead>
								<tr>
									<th width="25%">Ref Type</th>
									<th width="40%">Ref No.</th>
									<th width="30%">Amount</th>
									<th width="5%"></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($old_ref_rows[$receipt_row->received_from_id] as $old_ref_row){ ?>
								<tr>
									<td><?php echo $this->Form->input('ref_types', ['empty'=>'--Select-','options'=>$ref_types,'label' => false,'class' => 'form-control input-sm ref_type','value'=>$old_ref_row->reference_type]); ?></td>
									<td class="ref_no">
									<?php if($old_ref_row->reference_type=="Against Reference"){
										echo $this->requestAction('Receipts/fetchRefNumbersEdit/'.$receipt_row->received_from_id.'/'.$old_ref_row->reference_no.'/'.$old_ref_row->credit.'/'.$old_ref_row->debit.'/'.$receipt_row->cr_dr);
									}else{
										echo '<input type="text" class="form-control input-sm" placeholder="Ref No." value="'.$old_ref_row->reference_no.'" readonly="readonly" is_old="yes">';
									}?>
									</td>
									<td>
									<?php if($receipt_row->cr_dr=="Cr"){
											echo $this->Form->input('old_amount', ['label' => false,'class' => '','type'=>'hidden','value'=>$old_ref_row->credit]);
											echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount','value'=>$old_ref_row->credit]);
										}else{
											echo $this->Form->input('old_amount', ['label' => false,'class' => '','type'=>'hidden','value'=>$old_ref_row->debit]);
											echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount','value'=>$old_ref_row->debit]);
										}							
									?>
									</td>
									<td><a class="btn btn-xs btn-default deleterefrow" href="#" role="button" old_ref="<?php echo $old_ref_row->reference_no; ?>" old_ref_type="<?php echo $old_ref_row->reference_type; ?>"><i class="fa fa-times"></i></a></td>
								</tr>
							<?php } ?>
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
						
					</td>
					<td><a class="btn btn-xs btn-default deleterow" href="#" role="button"><i class="fa fa-times"></i></a></td>
				</tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<td><a class="btn btn-xs btn-default addrow" href="#" role="button"><i class="fa fa-plus"></i> Add row</a></td>
				<td id="receipt_amount" style="font-size: 14px;font-weight: bold;"></td>
				<td><?php echo $this->Form->input('narration', ['type'=>'textarea','label' => false,'class' => 'form-control input-sm','placeholder'=>'Narration']); ?></td>
				<td></td>
			</tfoot>
		</table>
				<?php if($chkdate == 'Not Found'){  ?>
					<label class="btn btn-danger"> You are not in Current Financial Year </label>
				<?php } else { ?>
					<button type="submit" id='submitbtn' class="btn btn-primary" >EDIT RECEIPT</button>
				<?php } ?>	
		
		</div>
    <?= $this->Form->end() ?>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<script>
$(document).ready(function() {
	//--------- FORM VALIDATION
	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	}, "No space allowed");
	
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
	}, jQuery.format("Reference number should unique for one party."))


	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
				bank_cash_id:{
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
			success3.show();
			error3.hide();
			form[0].submit(); // submit the form
		}

	});
	//--	 END OF VALIDATION
	
	
		
	$('input[name="payment_mode"]').die().live("click",function() {
		var payment_mode=$(this).val();
		alert(payment_mode);
		if(payment_mode=="Cheque"){
			$("#chq_no").show();
		}else{
			$("#chq_no").hide();
		}
	});
	
	var payment_mode=$('input[name="payment_mode"]:checked').val();
	if(payment_mode=="Cheque"){
		$("#chq_no").show();
	}else{
		$("#chq_no").hide();
	}
	//rename_rows();
	
	
	function function2(){
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){
			var sel=$(this);
			var received_from_id=$(this).find('td:nth-child(1) select').val();
			rename_ref_rows(sel,received_from_id);
		});
	}
	$.when(rename_rows()).then(function2());
	function add_row(){
		var tr=$("#sample_table tbody tr").clone();
		$("#main_table tbody#main_tbody").append(tr);
		rename_rows();
	}
	
	function rename_rows(){
		var i=0;
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){
			$(this).find("td:eq(0) select.received_from").select2().attr({name:"receipt_rows["+i+"][received_from_id]", id:"quotation_rows-"+i+"-received_from_id"}).rules('add', {
						required: true,
						notEqualToGroup: ['.received_from'],
						messages: {
							notEqualToGroup: "Do not select same party again."
						}
					});
			$(this).find("td:eq(1) input").attr({name:"receipt_rows["+i+"][amount]", id:"quotation_rows-"+i+"-amount"}).rules('add', {
						required: true,
						min: 0.01,
					});
			$(this).find("td:eq(1) select").attr({name:"receipt_rows["+i+"][cr_dr]", id:"quotation_rows-"+i+"-cr_dr"});
			i++;
		});
	}
	
	$('.addrow').live("click",function() {
		add_row();
	});
	$('.deleterow').live("click",function() {
		var sel=$(this);
		delete_all_ref_no(sel);
		$(this).closest("tr").remove();
		do_mian_amount_total();
	});
	
	$('.addrefrow').live("click",function() {
		var sel=$(this).closest('tr.main_tr');
		var received_from_id=$(this).closest('tr.main_tr').find('td:nth-child(1) select').val();
		add_ref_row(sel,received_from_id);
	});
	
	function add_ref_row(sel,received_from_id){
		var tr=$("#sample_ref table.ref_table tbody tr").clone();
		sel.find("table.ref_table tbody").append(tr);
		rename_ref_rows(sel,received_from_id);
	}
	
	function rename_ref_rows(sel,received_from_id){
		var i=0;
		$(sel).find("table.ref_table tbody tr").each(function(){
			$(this).find("td:nth-child(1) select").attr({name:"ref_rows["+received_from_id+"]["+i+"][ref_type]", id:"ref_rows-"+received_from_id+"-"+i+"-ref_type"}).rules("add", "required");
			var is_select=$(this).find("td:nth-child(2) select").length;
			var is_input=$(this).find("td:nth-child(2) input").length;
			
			if(is_select){
				$(this).find("td:nth-child(2) select").attr({name:"ref_rows["+received_from_id+"]["+i+"][ref_no]", id:"ref_rows-"+received_from_id+"-"+i+"-ref_no"}).rules("add", "required");
			}else if(is_input){
				var url='<?php echo $this->Url->build(['controller'=>'Receipts','action'=>'checkRefNumberUniqueEdit']); ?>';
				var is_old=$(this).find("td:nth-child(2) input").attr('is_old');
				url=url+'/'+received_from_id+'/'+i+'/'+is_old;
				$(this).find("td:nth-child(2) input").attr({name:"ref_rows["+received_from_id+"]["+i+"][ref_no]", id:"ref_rows-"+received_from_id+"-"+i+"-ref_no", class:"form-control input-sm ref_number-"+received_from_id}).rules('add', {
														required: true,
														noSpace: true,
														notEqualToGroup: ['.ref_number-'+received_from_id],
														remote: {
															url: url,
														},
														messages: {
															remote: "Not an unique."
														}
													});
			}
			
			var is_ref_old_amount=$(this).find("td:nth-child(3) input:eq(0)").length;
			if(is_ref_old_amount){
				$(this).find("td:nth-child(3) input:eq(0)").attr({name:"ref_rows["+received_from_id+"]["+i+"][ref_old_amount]", id:"ref_rows-"+received_from_id+"-"+i+"-ref_old_amount"});
			}
			$(this).find("td:nth-child(3) input:eq(1)").attr({name:"ref_rows["+received_from_id+"]["+i+"][ref_amount]", id:"ref_rows-"+received_from_id+"-"+i+"-ref_amount"}).rules("add", "required");
			i++;
		});
		var amount_id=$(sel).find("td:nth-child(2) input").attr('id');
		var is_tot_input=$(sel).find("table.ref_table tfoot tr:eq(1) td:eq(1) input").length;
		if(is_tot_input){
			$(sel).find("table.ref_table tfoot tr:eq(1) td:eq(1) input").attr({name:"ref_rows_total["+received_from_id+"]", id:"ref_rows_total-"+received_from_id}).rules('add', {
														equalTo: "#"+amount_id
													});
		}
		
	}
	
	$('.deleterefrow').live("click",function() {
		var sel=$(this);
		delete_one_ref_no(sel);
		$(this).closest("tr").remove();
		do_ref_total();
	});
	
	$('.received_from').live("change",function() {
		var sel=$(this);
		load_ref_section(sel);
	});
	
	$('.cr_dr').live("change",function() {
		var sel=$(this);
		load_ref_section(sel);
		do_mian_amount_total();
	});
	
	function load_ref_section(sel){
		$(sel).closest("tr.main_tr").find("td:nth-child(3)").html("Loading...");
		var sel2=$(sel).closest('tr.main_tr');
		var received_from_id=$(sel).closest("tr.main_tr").find("td:nth-child(1) select").find('option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'LedgerAccounts','action'=>'checkBillToBillAccountingStatus']); ?>";
		url=url+'/'+received_from_id,
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'text'
		}).done(function(response) {
			if(response.trim()=="Yes"){
				var ref_table=$("#sample_ref div.ref").clone();
				$(sel).closest("tr").find("td:nth-child(3)").html(ref_table);
			}else{
				$(sel).closest("tr").find("td:nth-child(3)").html("");
			}
			rename_ref_rows(sel2,received_from_id);
		});
	}
	
	
	$('.ref_type').live("change",function() {
		var current_obj=$(this);
		var sel3=$(this).closest('tr.main_tr');
		var cr_dr=$(this).closest('tr.main_tr').find('td:nth-child(2) select').val();
		var ref_type=$(this).find('option:selected').val();
		var received_from_id=$(this).closest('tr.main_tr').find('td select:eq(0)').val();
		if(ref_type=="Against Reference"){
			var url="<?php echo $this->Url->build(['controller'=>'Receipts','action'=>'fetchRefNumbers']); ?>";
			url=url+'/'+received_from_id+'/'+cr_dr,
			$.ajax({
				url: url,
				type: 'GET',
			}).done(function(response) {
				current_obj.closest('tr').find('td:eq(1)').html(response);
				rename_ref_rows(sel3,received_from_id);
			});
		}else if(ref_type=="New Reference" || ref_type=="Advance Reference"){
			current_obj.closest('tr').find('td:eq(1)').html('<input type="text" class="form-control input-sm" placeholder="Ref No." >');
			rename_ref_rows(sel3,received_from_id);
		}else{
			current_obj.closest('tr').find('td:eq(1)').html('');
		}
		
	});
	
	
	$('.ref_type').live("change",function() {
		var sel=$(this);
		delete_one_ref_no(sel);
	});
	
	
	$('.ref_list').live("change",function() {
		var sel=$(this);
		var due_amount=$(this).find('option:selected').attr('due_amount');
		$(this).closest('tr').find('td:eq(2) input').val(due_amount);
		do_ref_total();
		delete_one_ref_no(sel);
	});
	
	$('.ref_amount_textbox').live("keyup",function() {
		do_ref_total();
	});
	
	do_ref_total();
	function do_ref_total(){
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){
			var main_amount=$(this).find('td:nth-child(2) input').val();
			var total_ref=0;
			$(this).find("table.ref_table tbody tr").each(function(){
			
				var am=parseFloat($(this).find('td:nth-child(3) input:eq(1)').val());
				if(!am){ am=0; }
				total_ref=total_ref+am;
			});
			var on_acc=main_amount-total_ref;
			if(on_acc>=0){
				$(this).find("table.ref_table tfoot tr:nth-child(1) td:nth-child(3) input").val(on_acc.toFixed(2));
				total_ref=total_ref+on_acc;
			}else{
				$(this).find("table.ref_table tfoot tr:nth-child(1) td:nth-child(3) input").val(0);
			}
			$(this).find("table.ref_table tfoot tr:nth-child(2) td:nth-child(2) input").val(total_ref.toFixed(2));
		});
	}
	
	$('.mian_amount').live("blur",function() {
		var v=parseFloat($(this).val());
		if(!v){ v=0; }
		$(this).val(v.toFixed(2));
	});
	
	$('.mian_amount').live("keyup",function() {
		do_mian_amount_total();
		do_ref_total();
	});
	
	do_mian_amount_total();
	function do_mian_amount_total(){
		var mian_amount_total_cr=0; var mian_amount_total_dr=0;
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){
			var v=parseFloat($(this).find("td:nth-child(2) input").val());
			var cr_dr=($(this).find("td:nth-child(2) select").val());
			if(!v){ v=0; }
			if(cr_dr=="Cr"){
				mian_amount_total_cr=mian_amount_total_cr+v;
			}else{
				mian_amount_total_dr=mian_amount_total_dr+v;
			}
			
			mian_amount_total=mian_amount_total_cr-mian_amount_total_dr;
			$('#receipt_amount').text(mian_amount_total.toFixed(2));
		});
	}
	
	
	$('.received_from').live("change",function() {
		var sel=$(this);
		delete_all_ref_no(sel);
	});
	
	$('.cr_dr').live("change",function() {
		var sel=$(this);
		delete_all_ref_no(sel);
	});
	
	function delete_all_ref_no(sel){
		var old_received_from_id=sel.closest('tr').attr('old_received_from_id');
		var url="<?php echo $this->Url->build(['controller'=>'Receipts','action'=>'deleteAllRefNumbers']); ?>";
		url=url+'/'+old_received_from_id+'/'+<?php echo $receipt->id; ?>,
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			//alert(response);
		});
	}
	
	function delete_one_ref_no(sel){
		var old_received_from_id=sel.closest('tr.main_tr').attr('old_received_from_id');
		var old_ref=sel.closest('tr').find('a.deleterefrow').attr('old_ref');
		var old_ref_type=sel.closest('tr').find('a.deleterefrow').attr('old_ref_type');
		var url="<?php echo $this->Url->build(['controller'=>'Receipts','action'=>'deleteOneRefNumbers']); ?>";
		url=url+'?old_received_from_id='+old_received_from_id+'&receipt_id=<?php echo $receipt->id; ?>&old_ref='+old_ref+'&old_ref_type='+old_ref_type,
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			//alert(response);
		});
	}
	
	$("#main_table tbody#main_tbody tr.main_tr").each(function(){
		var sel2=$(this);
		var received_from_id=$(this).find("td:nth-child(1) select").find('option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'LedgerAccounts','action'=>'checkBillToBillAccountingStatus']); ?>";
		url=url+'/'+received_from_id,
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'text'
		}).done(function(response) {
			if(response.trim()=="Yes"){
				
			}else{
				$(sel2).find("td:nth-child(3)").html("");
			}
			rename_ref_rows(sel2,received_from_id);
		});
	});
	
});
</script>


<table id="sample_table" style="display:none;">
	<tbody>
		<tr class="main_tr">
			<td><?php echo $this->Form->input('received_from_id', ['empty'=>'--Select-','options'=>$receivedFroms,'label' => false,'class' => 'form-control input-sm received_from']); ?></td>
			<td>
			<div class="row">
				<div class="col-md-7" style="padding-right: 0;">
					<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm mian_amount','placeholder'=>'Amount']); ?>
				</div>
				<div class="col-md-5"style="padding-left: 0;">
					<select name="cr_dr" class="form-control input-sm cr_dr" >
						<option value="Cr">Cr</option>
						<option value="Dr">Dr</option>
					</select>
				</div>
			</div>
			</td>
			<td></td>
			<td><a class="btn btn-xs btn-default deleterow" href="#" role="button"><i class="fa fa-times"></i></a></td>
		</tr>
	</tbody>
</table>


<div id="sample_ref" style="display:none;">
	<div class="ref" style="padding:4px;">
	<table width="100%" class="ref_table">
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
				<td>
				<?php echo $this->Form->input('old_amount', ['label' => false,'class' => '','type'=>'hidden']); ?>
				<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount']); ?>
				</td>
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
