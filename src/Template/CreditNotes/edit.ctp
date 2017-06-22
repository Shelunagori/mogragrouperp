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
<?php if(@$ErrorsalesAccs){
		?> 
		<div class="actions">
				<?php echo $this->Html->link('Create Ledger Account For Credit Notes -> Customer/Suppiler','/VouchersReferences/edit/'.$CreditNotesSalesAccount,array('escape'=>false,'class'=>'btn btn-primary')); ?>
		</div>
		<?php } 
		 else if(@$Errorparties){
		?> 
		<div class="actions">
				<?php echo $this->Html->link('Create Ledger Account For Credit Notes -> Heads','/VouchersReferences/edit/'.$CreditNotesParty,array('escape'=>false,'class'=>'btn btn-primary')); ?>
		</div>
		<?php }  else { ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Edit Credit Note</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= //pr($debitNote->toArray());exit;
		 
		 $this->Form->create($creditNote,['type' => 'file','id'=>'form_sample_3']) ?>
			<div class="form-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Customer/Suppiler<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('customer_suppiler_id', ['empty'=>'--Select-','options' => $customer_suppiler_id,'label' => false,'id'=>'customer_suppiler_id','class' => 'form-control input-sm select2me']); ?>
						
						</div>
					</div>
				<?php //pr($debitNote); exit; ?>
				<div class="col-md-4" >
						<div class="form-group">
						<label class=" control-label">Transaction Date<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('transaction_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','value' => date("d-m-Y",strtotime($creditNote->transaction_date)),'data-date-start-date' => date("d-m-Y",strtotime($financial_year->date_from)),'data-date-end-date' => date("d-m-Y",strtotime($financial_year->date_to)) ]); ?>
						
						</div>
					</div>					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Date</label>
							
								<?php echo $this->Form->input('created_on', ['type' => 'text','label' => false,'class' => 'form-control input-sm','value' => date("d-m-Y"),'readonly']); ?>
							
						</div>
					</div>
				</div>

				<div class='row'>
				  <div class='col-md-12'>	
						<div style="overflow: auto;">
						 <table width="100%" id="main_table">
							<thead>
								<th width="25%"><label class="control-label">Paid TO</label></th>
								<th width="15%"><label class="control-label">Amount</label></th>
							    <th width="15%"><label class="control-label">Narration</label></th>
								<th width="3%"></th>
							</thead>
							<tbody id="main_tbody">
							<?php 
							//pr($debitNote->debit_notes_rows); exit;
							foreach($creditNote->credit_notes_rows as $credit_note_row ) { ?>
								<tr class="main_tr">
									<td>
										<div class="row">
												<div class="col-md-10" style="padding-right: 0;">
											<?php echo $this->Form->input('heads', ['empty'=>'--Select-','options'=>$heads,'label' => false,'class' => 'form-control input-sm ','value'=>$credit_note_row->head_id]); ?>
											</div>
										</div>	
									</td>
									<td>
										<div class="row">
											<div class="col-md-10" style="padding-right: 0;">
												<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm mian_amount','placeholder'=>'Amount','value'=>$credit_note_row->amount]); ?>
											</div>
										</div>
									</td>
									<td>
										<div class="row">
											<div class="col-md-10" style="padding-right: 0;">
												<?php echo $this->Form->input('narration', ['type'=>'textarea','label' => false,'class' => 'form-control input-sm','placeholder'=>'Narration','value'=>$credit_note_row->narration]); ?>
											</div>
										</div>	
									</td>
									<td>
										 <a class="btn btn-xs btn-default deleterow" href="#" role="button"><i class="fa fa-times"></i></a>
									</td>
								</tr>							
							
							<?php } ?>
							</tbody>
							<tfoot>
								<td><a class="btn btn-xs btn-default addrow" href="#" role="button"><i class="fa fa-plus"></i> Add row</a></td>
								<td  align="right"><b>Grand Total </b></td>
								<td><?php echo $this->Form->input('grand_total', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Grand Total','readonly','step'=>0.01,'value'=>0]); ?></td>
								<td></td>

							</tfoot>
						</table>
						</div>
					</div>				
			   </div>
			</div>
			
			<br /> </br />

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
							<?php //pr($ReferenceDetails->toArray()); exit; 
								foreach($ReferenceDetails as $old_ref_row){ ?>
								<tr>
									<td><?php echo $this->Form->input('ref_types', ['empty'=>'--Select-','options'=>$ref_types,'label' => false,'class' => 'form-control input-sm ref_type','value'=>$old_ref_row->reference_type]); ?></td>
									<td class="ref_no">
									<?php if($old_ref_row->reference_type=="Against Reference"){
										echo $this->requestAction('CreditNotes/fetchRefNumbersEdit/'.$creditNote->customer_suppiler_id.'/'.$old_ref_row->reference_no.'/'.$old_ref_row->credit);
									}else{
										echo '<input type="text" class="form-control input-sm" placeholder="Ref No." value="'.$old_ref_row->reference_no.'" readonly="readonly" is_old="yes">';
									}?>
									</td>
									<td>
									<?php  
											echo $this->Form->input('old_amount', ['label' => false,'class' => 'old_amount','type'=>'hidden','value'=>$old_ref_row->credit]);
											echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount','value'=>$old_ref_row->credit]);
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
				</div>

			
			<div class="form-actions">
				<button type="submit" id='submitbtn' class="btn btn-primary">EDIT CREDIT NOTE</button>
			</div>
		</div>
		<?= $this->Form->end() ?>
		<!-- END FORM-->
		
	</div>
</div>
<?php } ?>
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
	
	rename_rows();
	calculate_total();
	function add_row(){
		var tr=$("#sample_table tbody tr.main_tr").clone();
		$("#main_table tbody#main_tbody").append(tr);
		rename_rows();
	}	

	$('.addrow').live("click",function() {
		add_row();
	});

	$('.deleterow').live("click",function() {
		
		
		$(this).closest("tr").remove();
		calculate_total();
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
			var am=parseFloat($(this).find('td:nth-child(3) input:eq(1)').val());
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

	function calculate_total(){
		 var grand_total = 0; var total = 0;
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){
				var amount = parseInt($(this).find("td:nth-child(2) input").val());
			    total = parseInt(total) + amount;
		}); 
		
		$('input[name="grand_total"]').val(total);
		
		do_ref_total();
	}

	$('.mian_amount').die().live("keyup","blur",function() { 
		calculate_total();
    });

	
	
	function rename_rows(){
		var i=0;
		
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){
			
			$(this).find("td:eq(0) select").attr({name:"credit_notes_rows["+i+"][head_id]", id:"credit_notes_rows-"+i+"-head_id"}).select2().rules("add", "required");			

			$(this).find("td:eq(1) input").attr({name:"credit_notes_rows["+i+"][amount]", id:"credit_notes_rows-"+i+"-amount"}).rules("add", "required");
		    
			$(this).find("td:eq(2) textarea").attr({name:"credit_notes_rows["+i+"][narration]", id:"credit_notes_rows-"+i+"-narration"}).rules("add", "required");
		 	i++;
		});
	}

	$('.deleterefrow').live("click",function() {
		$(this).closest("tr").remove();
		do_ref_total();
	});	
	
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
		var customer_suppiler_id = $('#customer_suppiler_id').val();
		$("table.main_ref_table tbody tr").each(function(){
			$(this).find("td:nth-child(1) select").attr({name:"ref_rows["+i+"][ref_type]", id:"ref_rows-"+i+"-ref_type"}).rules("add", "required");
			var is_select=$(this).find("td:nth-child(2) select").length;
			var is_input=$(this).find("td:nth-child(2) input").length;
			
			if(is_select){
				$(this).find("td:nth-child(2) select").attr({name:"ref_rows["+i+"][ref_no]", id:"ref_rows-"+i+"-ref_no"}).rules("add", "required");
			}else if(is_input){
				var url='<?php echo $this->Url->build(['controller'=>'CreditNotes','action'=>'checkRefNumberUnique']); ?>';
				url=url+'/'+customer_suppiler_id+'/'+i;
				
				$(this).find("td:nth-child(2) input").attr({name:"ref_rows["+i+"][ref_no]", id:"ref_rows-"+i+"-ref_no", class:"form-control input-sm ref_number"});
			}

			var is_ref_old_amount=$(this).find("td:nth-child(3) input:eq(0)").length;
			
			if(is_ref_old_amount){
				$(this).find("td:nth-child(3) input:eq(0)").attr({name:"ref_rows["+i+"][ref_old_amount]", id:"ref_rows-"+i+"-ref_old_amount"});
			}
			$(this).find("td:nth-child(3) input:eq(1)").attr({name:"ref_rows["+i+"][ref_amount]",
			id:"ref_rows-"+i+"-ref_amount"}).rules("add", "required");
			
			
			i++;
		});
		
		var is_tot_input=$("table.main_ref_table tfoot tr:eq(1) td:eq(1) input").length;
		
		if(is_tot_input){
			$("table.main_ref_table tfoot tr:eq(1) td:eq(1) input").attr({name:"ref_rows_total", id:"ref_rows_total"});
		}
	}

	$('.ref_type').live("change",function() {
		var sel=$(this);
		delete_one_ref_no(sel);
	});	
	
	$('.deleterefrow').live("click",function() {
		$(this).closest("tr").remove();
		do_ref_total();
		var sel=$(this);
		delete_one_ref_no(sel);
	});	
	
	function delete_one_ref_no(sel){
		var old_received_from_id='<?php echo $creditNote->customer_suppiler_id; ?>';		
		var old_ref=sel.closest('tr').find('a.deleterefrow').attr('old_ref');
		var old_ref_type=sel.closest('tr').find('a.deleterefrow').attr('old_ref_type');
		var url="<?php echo $this->Url->build(['controller'=>'CreditNotes','action'=>'deleteOneRefNumbers']); ?>";
		url=url+'?old_received_from_id='+old_received_from_id+'&creditNote_id=<?php echo $creditNote->id; ?>&old_ref='+old_ref+'&old_ref_type='+old_ref_type;
		
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			//alert(response);
		});
	}	
	
	
	$('.ref_type').live("change",function() {
	    var current_obj=$(this);
	    var ledger_account_id = $('#customer_suppiler_id').val();
		//alert(ledger_account_id);
		
		if(ledger_account_id == '')
		{ 
			alert('Please Select Customer/Suppiler');
			current_obj.val('');
		}
		else
		{
			var ref_type=$(this).find('option:selected').val();
			if(ref_type=="Against Reference"){
				var url="<?php echo $this->Url->build(['controller'=>'CreditNotes','action'=>'fetchRefNumbers']); ?>";
				url=url,
				$.ajax({
					url: url+'/'+ledger_account_id,
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

		}
		
	});	


	
});	
</script>


		<table id="sample_table" style="display:none;">
			<tbody>
				<tr class="main_tr">
					<td>
						<div class="row">
								<div class="col-md-10" style="padding-right: 0;">
							<?php echo $this->Form->input('heads', ['empty'=>'--Select-','options'=>$heads,'label' => false,'class' => 'form-control input-sm ']); ?>
							</div>
						</div>	
					</td>
					<td>
						<div class="row">
							<div class="col-md-10" style="padding-right: 0;">
								<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm mian_amount','placeholder'=>'Amount']); ?>
							</div>
						</div>
					</td>
					<td>
						<div class="row">
							<div class="col-md-10" style="padding-right: 0;">
								<?php echo $this->Form->input('narration', ['type'=>'textarea','label' => false,'class' => 'form-control input-sm','placeholder'=>'Narration']); ?>
							</div>
						</div>	
					</td>
					<td>
						 <a class="btn btn-xs btn-default deleterow" href="#" role="button"><i class="fa fa-times"></i></a>
					</td>
				</tr>
			</tbody>
		</table>



	<?php $ref_types=['New Reference'=>'New Ref','Against Reference'=>'Agst Ref','Advance Reference'=>'Advance']; ?>
	<div id="sample_ref" style="display:none;">
		<table width="100%" class="ref_table">
			<tbody>
				<tr>
					<td><?php echo $this->Form->input('ref_types', ['empty'=>'--Select-','options'=>$ref_types,'label' => false,'class' => 'form-control input-sm ref_type']); ?></td>
					<td class="ref_no"></td>
					<td>
					<?php echo $this->Form->input('old_amount', ['label' => false,'class' => '','type'=>'hidden']); ?>
					<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount']); ?></td>
					<td><a class="btn btn-xs btn-default deleterefrow" href="#" role="button"><i class="fa fa-times"></i></a></td>
				</tr>
			</tbody>
		</table>
	</div>