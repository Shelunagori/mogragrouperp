<?php if(@$ErrorpaidTos){
		?> 
		<div class="actions">
				<?php echo $this->Html->link('Create Ledger Account For PaymentVoucher -> Paid To','/VouchersReferences/edit/'.$paymentVoucherpaidTo,array('escape'=>false,'class'=>'btn btn-primary')); ?>
		</div>
		<?php } 
		 else if(@$ErrorbankCashes){
		?> 
		<div class="actions">
				<?php echo $this->Html->link('Create Ledger Account For PaymentVoucher -> Cash/Bank','/VouchersReferences/edit/'.$paymentVoucherBankCash,array('escape'=>false,'class'=>'btn btn-primary')); ?>
		</div>
<?php }  else { ?>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Add Payment Voucher</span></br>
			
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= $this->Form->create($paymentVoucher,['type' => 'file','id'=>'form_sample_3']) ?>
		<div class="form-body">
			<div class="row">
			   <div class="col-md-3">
					<div class="form-group">
						<label class="col-md-3 control-label">Date</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('created_on', ['type' => 'text','label' => false,'class' => 'form-control input-sm','value' => date("d-m-Y"),'readonly']); ?>

					
					<span style="color: red;">
						<?php if($chkdate == 'Not Found'){  ?>
							You are not in Current Financial Year
						<?php } ?>
					</span>
							
						</div>
					</div>
				</div>

					<div class="col-md-3">
						<div class="form-group">
						<label class=" control-label">Transaction Date<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('transaction_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','placeholder' => 'Transaction Date','value' => date("d-m-Y"),'data-date-start-date' => date("d-m-Y",strtotime($financial_year->date_from)),'data-date-end-date' => date("d-m-Y",strtotime($financial_year->date_to))]); ?>
						
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Paid To <span class="required" aria-required="true">*</span></label>
							<?php 
							echo $this->Form->input('paid_to_id', ['options'=>$paidTos,'empty'=>'--Select-','label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Cash/Bank<span class="required" aria-required="true">*</span></label>
							<?php 
							echo $this->Form->input('cash_bank_account_id', ['options'=>$bankCashes,'empty'=>'--Select-','label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
						
					</div>


			</div>
			  <div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Mode of Payment<span class="required" aria-required="true">*</span></label>
							<div class="radio-list">
								<div class="radio-inline" >
								<?php echo $this->Form->radio(
									'payment_mode',
									[
										['value' => 'Cheque', 'text' => 'Cheque', 'checked'],
										['value' => 'Cash', 'text' => 'Cash'],
										['value' => 'NEFT/RTGS', 'text' => 'NEFT/RTGS']
									]); ?>
								</div>
                                
							</div>
                             <div class="form-group" id="chq_no">
						     <?php echo $this->Form->input('cheque_no', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Cheque No']); ?>
						     </div>

						</div>
						
					</div>
					
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Amount<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Amount','id'=>'total_paid_amount','type'=>'text']); ?>
						</div>
				   </div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Narration<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('narration', ['label' => false,'class' => 'form-control input-sm','placeholder' => 'Narration']); ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
						<?php echo $this->Form->button('<i class="fa fa-plus"></i> New Ref', ['label' => false,'class' => 'btn btn-primary new_ref','type'=>'button']); ?>
						<?php echo $this->Form->button('<i class="fa fa-plus"></i> Agst Ref', ['label' => false,'class' => 'btn btn-primary agst_ref','type'=>'button']); ?>
						<?php echo $this->Form->button('<i class="fa fa-plus"></i> Advance', ['label' => false,'class' => 'btn btn-primary adv_ref','type'=>'button']); ?>
						</div>
					</div>
				  </div>
				  <div class="row">
					<div class="col-md-12">
						<table class="table table-bordered" id="main_table" style="text-align:center;">
						<thead>
						<tr>
						<td>Ref. Type</td>
						<td>Ref. No.</td>
						<td>Amount</td>
						<td></td>
						</tr>
						</thead>
						<tbody>
						</tbody>
						</table>
					</div>
				  </div>

				
				<?php echo $this->Form->input('bill_to_bill', ['label' => false,'class' => 'form-control input-sm','type'=>'text','id'=>'bill_to_bill','style'=>'height:0px; border:none; widht:0px;']); ?>
			
				<div id="bill_to_bill_show" style="display:none;">
					<table width="100%">
						<tr>
							<td width="45%" valign="top" id="pending_invoice_container"></td>
							<td></td>
							
						</tr>
					</table>
				</div>
			</div>
			<div class="form-actions">

				<?php if($chkdate == 'Not Found'){  ?>
					<label class="btn btn-danger"> You are not in Current Financial Year </label>
				<?php } else { ?>
					<?= $this->Form->button(__('ADD PAYMENT VOUCHER'),['class'=>'btn btn-primary','id'=>'add_submit','type'=>'Submit']) ?>
				<?php } ?>	


			
			</div>
		</div>
		<?= $this->Form->end() ?>
		<!-- END FORM-->
		<table class="table table-bordered" id="new_ref" style="display:none;">
			<tbody>
			<tr>
			<td>New Ref<?= $this->Form->hidden('reference_type[]',['class'=>'','label'=>false, 'value'=>'New Reference']) ?></td>
			<td><?= $this->Form->input('reference_no[]',['type'=>'text','class'=>'form-control distinctreference','label'=>false,'id'=>'reference_no_2']) ?></td>
			<td><?= $this->Form->input('credit[]',['type'=>'text','class'=>'form-control ','label'=>false, 'value'=>0]) ?></td>
			<td><?= $this->Form->button(__('<i class="fa fa-trash-o"></i>'),['type'=>'button','class'=>'btn btn-danger btn-sm remove_row','label'=>false]) ?></td>
			</tr>
			</tbody>
		</table>
		<table class="table table-bordered" id="agst_ref" style="display:none;">
		<tbody>
			<tr class="against_references_no">
			<td>Agst Ref<?= $this->Form->hidden('reference_type[]',['class'=>'','label'=>false, 'value'=>'Against Reference']) ?><?= $this->Form->hidden('reference_no[]',['type'=>'text','class'=>'form-control ','label'=>false,'id'=>'reference_no_2']) ?></td>
			<td id="against_references_no"></td>
			<td><?= $this->Form->input('credit[]',['type'=>'text','class'=>'form-control ','label'=>false, 'value'=>0]) ?></td>
			<td><?= $this->Form->button(__('<i class="fa fa-trash-o"></i>'),['type'=>'button','class'=>'btn btn-danger btn-sm remove_row','label'=>false]) ?></td>
			</tr>
			</tbody>
		</table>
		<table class="table table-bordered" id="adv_ref" style="display:none;">
		<tbody>
			<tr>
			<td>Adv Ref<?= $this->Form->hidden('reference_type[]',['class'=>'','label'=>false, 'value'=>'Advance Reference']) ?></td>
			<td><?= $this->Form->input('reference_no[]',['type'=>'text','class'=>'form-control distinctreference','label'=>false,'id'=>'reference_no_2']) ?></td>
			<td><?= $this->Form->input('credit[]',['type'=>'text','class'=>'form-control ','label'=>false, 'value'=>0]) ?></td>
			<td><?= $this->Form->button(__('<i class="fa fa-trash-o"></i>'),['type'=>'button','class'=>'btn btn-danger btn-sm remove_row','label'=>false]) ?></td>
			</tr>
			</tbody>
		</table>
	</div>

<?php } ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
	
	$( document ).on( 'keyup', 'input[name="credit[]"]', function() {
			var credit=parseFloat($(this).val());
			var amount=$(this).closest('tr').find('select[name="against_references_no"] option:selected').attr('amount');
			amount=parseFloat(amount);

			if(amount<credit)
			{
				$(this).val(amount);
			}	
	});
	
	$('select[name="against_references_no"]').live("change",function() {
		var against_references_no=$(this).val();
		var amount=eval($('option:selected',this).attr('amount'));
		
		$(this).closest('tr').find('input[name="reference_no[]"]').val(against_references_no);
		$(this).closest('tr').find('input[name="credit[]"]').val(amount);
	});
	$('select[name="paid_to_id"]').live("change",function() {
		var received_from_id=$(this).val();
		
		var url="<?php echo $this->Url->build(['controller'=>'PaymentVouchers','action'=>'fetchReferenceNo']); ?>";
		url=url+'/'+received_from_id,
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'text'
		}).done(function(response) {
			$("#main_table tbody").find('tr.against_references_no').remove();
			if(!response)
			{ 
				$('#agst_ref').remove();
				
			}
			$('#against_references_no').html(response);
		});
		
	});
	$('input[name="amount"],[name^=credit]').live("blur",function() {
		var val=$(this).val();
		$(this).val(parseFloat($(this).val()).toFixed(2));
	});
	
	

	$('input[name="payment_mode"]').die().live("click",function() {
		var payment_mode=$(this).val();
		
		if(payment_mode=="Cheque"){
			$("#chq_no").show();
		}else{
			$("#chq_no").hide();
		}
	});
	
	$( document ).on( 'click', '.new_ref', function() {
		var new_line=$('#new_ref tbody').html();
		$("#main_table tbody").append(new_line);
		var i=1;
		var len=$("[name^=reference_no]").length;
		
		$("[name^=reference_no]").each(function () {
			
			$(this).attr('id','reference_no_'+i);
			
			$(this).rules("add", {
				required: true,
				noSpace: true,
				notEqualToGroup: ['.distinctreference']
			});
			i++;
		});
	});
	$( document ).on( 'click', '.agst_ref', function() {
		var new_line=$('#agst_ref tbody').html();
		$("#main_table tbody").append(new_line);
		var i=1;
		var len=$("[name^=reference_no]").length;
		
		$("[name^=reference_no]").each(function () {
			
			$(this).attr('id','reference_no_'+i);
			
			$(this).rules("add", {
				required: true,
				noSpace: true,
				notEqualToGroup: ['.distinctreference']
			});
			i++;
		});
	});
	$( document ).on( 'click', '.adv_ref', function() {
		var new_line=$('#adv_ref tbody').html();
		$("#main_table tbody").append(new_line);
		var i=1;
		var len=$("[name^=reference_no]").length;
		
		$("[name^=reference_no]").each(function () {
			
			$(this).attr('id','reference_no_'+i);
			
			$(this).rules("add", {
				required: true,
				noSpace: true,
				notEqualToGroup: ['.distinctreference']
			});
			i++;
		});
	});
	$( document ).on( 'click', '.remove_row', function() {
		$(this).closest("#main_table tr").remove();
		var i=1;
		var len=$("[name^=reference_no]").length;
		
		$("[name^=reference_no]").each(function () {
			
			$(this).attr('id','reference_no_'+i);
			
			$(this).rules("add", {
				required: true,
				noSpace: true,
				notEqualToGroup: ['.distinctreference']
			});
			i++;
		});
	});
	
	////////////////  Validation  ////////////////////////
	
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
		ignore: ":hidden",
		rules: {
			advance: {
				min:0,
			},
			cheque_no :{
				required: true,
			},
			'reference_no[]':{
					required: true,
					noSpace: true,
					notEqualToGroup: ['.distinctreference'],
					remote : {
                    url: '<?php echo $this->Url->build(['controller'=>'Ledgers','action'=>'check_reference_no']); ?>',
                    type: "get",
                    data:
                        {
                            ledger_account_id: function(){return $('select[name=paid_to_id] option:selected').val();}
                        },
					},
				}
		},
		messages: {
			'reference_no[]': {
				remote: "Reference no. is alredy taken."
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
			var amount=parseFloat($('input[name="amount"]').val());
		
				var credit=0;
				$("[name^=credit]").each(function () {
					credit=credit+parseFloat($(this).val());
				});
				
				if(amount==credit)
				{
					success3.show();
					error3.hide();
					form[0].submit();
				}
				else
				{
					$("#add_submit").removeAttr("disabled");
					alert("Amount mismatch.");
				}
				
			
			// // submit the form
		}

	});
	
	
	
	
	
	
});
</script>


