
<style>
table > thead > tr > th, table > tbody > tr > th, table > tfoot > tr > th, table > thead > tr > td, table > tbody > tr > td, table > tfoot > tr > td{
	vertical-align: top !important;
	border-bottom:solid 1px #CCC;
}
.help-block-error{
	font-size: 10px;
}
</style>
<?php 	$first="01";
		$last="31";
		$start_date=$first.'-'.$financial_month_first->month;
		$end_date=$last.'-'.$financial_month_last->month;
		$start_date=strtotime(date("Y-m-d",strtotime($start_date)));
		$transaction_date=strtotime($saleReturn->transaction_date);
if($transaction_date <  $start_date && !empty(@$saleReturn->transaction_date)) {
	echo "Financial Month has been Closed";
} else { ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Sale Return</span>
		</div>
	</div>
	<div class="portlet-body form">
		<?= $this->Form->create($saleReturn,['id'=>'form_sample_3']) ?>
		<?php 	$first="01";
				$last="31";
				$start_date=$first.'-'.$financial_month_first->month;
				$end_date=$last.'-'.$financial_month_last->month;
				//pr($start_date); exit;
		?>
		<div class="form-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-4 control-label">Sales Account<span class="required" aria-required="true">*</span></label>
						<div class="col-md-8">
							<?php echo $ledger_account_details->name ?>
							
						</div>
					</div>
				</div>
				<?php 
//pr($ledger_account_details->toArray()); exit;?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-6 control-label">Transaction Date</label>
						<div class="col-md-6">
							<?php echo $this->Form->input('transaction_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','required','value'=>date("d-m-Y",strtotime($saleReturn->transaction_date)),'data-date-start-date' => $start_date,'data-date-end-date' => $end_date]); ?>
					<span style="color: red;">
						<?php if($chkdate == 'Not Found'){  ?>
							You are not in Current Financial Year
						<?php } ?>
					</span>
							</div>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Customer</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('customer_id', ['type'=>'hidden','value' => @$saleReturn->customer->id]); ?>
							<?php echo $invoice->customer->customer_name.'('; echo $invoice->customer->alias.')'; ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Sales Return No.</label>
						<div class="col-md-3 padding-right-decrease">
							<?php echo $this->Form->input('in1', ['label' => false,'class' => 'form-control input-sm','readonly','value' => @$saleReturn->sr1]); ?>
						</div>
						<div class="col-md-3 padding-right-decrease">
							<?php echo @$saleReturn->sr3; ?>
						</div>
						<div class="col-md-3">
							<?php echo $this->Form->input('in4', ['label' => false,'class' => 'form-control input-sm','readonly','value' => @$saleReturn->sr4]); ?>
						</div>
					</div>
				</div>
			</div>
			<br/>


			
			<input type="text"  name="checked_row_length" id="checked_row_length" style="height: 0px;padding: 0;border: none;" />
			<table class="table tableitm" id="main_tb">
				<thead>
					<tr>
						<th width="50">Sr.No. </th>
						<th>Items</th>
						<th width="130">Quantity</th>
						<th width="130">Rate</th>
						<th width="130">Amount</th>
						<th width="130">Sale Tax</th>
						<th width="70"></th>
					</tr>
				</thead>
				<tbody id='main_tbody'>
					<?php 
					$q=0; $p=1; 
					foreach ($invoice->invoice_rows as $invoice_row){ ?>
						<tr class="tr1" row_no="<?= h($q) ?>">
							<td ><?php echo $p++; ?></td>
							<td>
								<?php 
								echo $this->Form->input('sale_return_rows.'.$q.'.item_id', ['type'=>'hidden','value'=>$invoice_row->item_id]);
								echo $invoice_row->item->name;
								?>
							</td>
							<td>
								<?php  
								echo $this->Form->input('sale_return_rows.'.$q.'.quantity', ['type' => 'text','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Quantity'
								,'max'=>$invoice_row->quantity ,'value'=>$invoice_row->sale_return_quantity]); 
								?>
							</td>
							<td>
								<?php echo $this->Form->input('sale_return_rows.'.$q.'.rate', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly','placeholder' => 'Rate','step'=>0.01,'value'=>$invoice_row->rate]); ?>
							</td>
							<td>
								<?php echo $this->Form->input('sale_return_rows.'.$q.'.amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly','placeholder' => 'Amount','step'=>0.01,'value'=>$invoice_row->amount]); ?>
							</td>
							<td>
								<?php echo @$invoice->sale_tax->tax_figure.'('.@$invoice->sale_tax->invoice_description.')'; ?>
							</td>
							<td>
								<?php $checked2="";
									if($invoice_row->sale_return_quantity == 0){ 
											$check='';
									} 
									else{	$check='checked';
									} 
								?>
								<div class="checkbox-list" data-error-container="#form_2_services_error">
								<label><?php echo $this->Form->input('check.'.$q, ['label' => false,'type'=>'checkbox','class'=>'rename_check',$check,'value' => @$invoice_row->item_id]); ?></label>
								</div>
							</td>
						</tr>
						
						<?php if($invoice_row->item->item_companies[0]->serial_number_enable==1){
						?>
						
						<tr class="tr2" row_no="<?= h($q) ?>">
						<?php $options1=[]; $choosen=[];
							 
								foreach($invoice_row->item->item_serial_numbers as $item_serial_numbers){
									$options1[]=['text' =>$item_serial_numbers->serial_no, 'value' => $item_serial_numbers->id];
									
									if($item_serial_numbers->sale_return_id==$saleReturn->id){
										$item_serial_no=$invoice_row->item_serial_number;
										$choosen[]=$item_serial_no;
									}
										//pr()
								}
						?>
							<td></td>
							<td colspan="6">
							<?php echo $this->Form->input('sale_return_rows.'.$q.'.itm_serial_number', ['label'=>false,'options' => $options1,'multiple' => 'multiple','class'=>'form-control select2me','style'=>'width:100%','value'=>$choosen,'readonly']);  ?></td>
						</tr>
					<?php  } 
					$q++; 
					}?>
					<?php   ?>
				</tbody>
			</table>
			<table class="table tableitm" id="tbl2">
				<tr>
					<td  align="right">
						<?php 
						if($saleReturn->discount_type==1){ $checked2="Checked";
							 } 
						else{	$checked2="";
							 } 
					?> 
					<b>Discount <label style="display:none"><?php echo $this->Form->input('discount_type', ['type' => 'checkbox','label' => false,'class' => 'form-control input-sm','id'=>'discount_per','Checked'=>$checked2]); ?></label>(in %)</b>
						<div class="input-group col-md-2"  id="discount_text">
						<input type="text" name="discount_per" class="form-control input-sm" placeholder="5.5"  'step'=0.01 readonly value="<?php echo $saleReturn->discount_per; ?> "><span class="input-group-addon">%</span>
						</div>
					</td>
					<td><?php echo $this->Form->input('discount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly','placeholder' => 'Discount','step'=>0.01,'value'=>$saleReturn->discount]); ?></td>
				</tr>
				
				<tr style="background-color:#e6faf9;">
					<td align="right"><b><?php echo $this->Form->input('ed_description', ['type' => 'textarea','label' => false,'class' => 'form-control input-sm','value'=>$saleReturn->ed_description,'placeholder' => 'Excise-Duty Description','style'=>['text-align:left']]); ?> </b></td>
					<td><?php echo $this->Form->input('exceise_duty', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly','placeholder' => 'Excise-Duty','value'=>$saleReturn->exceise_duty]); ?></td>
				</tr>
				<tr>
					<td align="right"><b>Total</b></td>
					<td width="20%"><?php echo $this->Form->input('total', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total','step'=>0.01,'readonly','value'=>$saleReturn->total]); ?></td>
				</tr>
				<tr>
				<?php 
					if($saleReturn->pnf_type==1){ $checked3="Checked";
					}else{	$checked3="";
					} 
					$val = $this->Number->format($invoice->grand_total,['places'=>2]);
					$val = str_replace(",",".",$val);
					$val1 = preg_replace('/\.(?=.*\.)/', '', $val);
					?> 
					<td  align="right">
					<b>P&F <label style="display:none"><?php echo $this->Form->input('pnf_type', ['type' => 'checkbox','label' => false,'class' => 'form-control input-sm','id'=>'pnfper','Checked'=>$checked2]); ?></label>(in %)</b>
					<?php if($saleReturn->pnf_type=='1'){ ?>
						<div class="input-group col-md-2"  id="pnf_text">
							<input type="text" name="pnf_per" class="form-control input-sm" placeholder="5.5"  'step'=0.01  readonly value='<?= h($saleReturn->pnf_per) ?>'><span class="input-group-addon">%</span>
						</div>
					<?php }else{ ?>
						<div class="input-group col-md-2"  id="pnf_text" style="display:none;">
							<input type="text" name="pnf_per" class="form-control input-sm" placeholder="5.5"  'step'=0.01 readonly value='0'><span class="input-group-addon">%</span>
						</div>
					<?php } ?>
					
					</td>
					<td><?php echo $this->Form->input('pnf', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly','placeholder' => 'P&F','step'=>0.01]); ?></td>
				</tr>
				<tr>
					<td  align="right"><b>Total after P&F </b></td>
					<td><?php echo $this->Form->input('total_after_pnf', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total after P&F','readonly','step'=>0.01]); ?></td>
				</tr>
				<tr>
					<td  align="right"><b>Sale Tax Amount </b></td>

					<td><?php echo $this->Form->input('sale_tax_per', ['type' => 'hidden','label' => false,'class' => 'form-control input-sm','readonly','step'=>0.01,'value'=>$saleReturn->sale_tax_per]); ?>
					<?php echo $this->Form->input('sale_tax_amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly','step'=>0.01]); ?></td>
				</tr>
				<tr>
					<td  align="left">
					<?php echo $this->Form->input('fright_text', ['type'=>'textarea','label' => false,'class' => 'form-control input-sm','value'=>$saleReturn->fright_text,'placeholder'=>'Additional text for Fright Amount','style'=>['text-align:left']]); ?>
					</td>
					<td>
					<?php echo $ledger_account_details_for_fright->name; ?>
					<?php echo $this->Form->input('fright_amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly','placeholder' => 'Fright Amount','value'=>$saleReturn->fright_amount]); ?></td>
				</tr>
				<tr>
					<td  align="right"><b>Grand Total </b></td>
					<td><?php echo $this->Form->input('grand_total', ['type' => 'text','label' => false,'class' => 'form-control input-sm grand_total','placeholder' => 'Grand Total','readonly','step'=>0.01,'value'=>$val1]); ?></td>
				</tr>
			</table>
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
							<?php foreach($ReferenceDetails as $old_ref_row){ 
								$val = $this->Number->format($old_ref_row->credit,['places'=>2]);
								$val = str_replace(",",".",$val);
								$val1 = preg_replace('/\.(?=.*\.)/', '', $val);
							
							
							?>
								<tr>
									<td><?php echo $this->Form->input('ref_types', ['empty'=>'--Select-','options'=>$ref_types,'label' => false,'class' => 'form-control input-sm ref_type','value'=>$old_ref_row->reference_type]); ?></td>
									<td class="ref_no">
									<?php if($old_ref_row->reference_type=="Against Reference"){
										echo $this->requestAction('SaleReturns/fetchRefNumbersEdit/'.$c_LedgerAccount->id.'/'.$old_ref_row->reference_no.'/'.$old_ref_row->credit);
									}else{
										echo '<input type="text" class="form-control input-sm" placeholder="Ref No." value="'.$old_ref_row->reference_no.'" readonly="readonly" is_old="yes">';
									}?>
									</td>
									<td>
									<?php 
										echo $this->Form->input('old_amount', ['label' => false,'class' => 'ref_old_amount','type'=>'hidden','value'=>$val1]);
										echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount','value'=>$val1]);
																
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
		</div>
		<?php echo $this->Form->input('process_status', ['type' => 'hidden','value' => @$process_status]); ?>
		<?php echo $this->Form->input('in_id', ['type' => 'hidden','value' => @$invoice->id]); ?>
		<div class="form-actions">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					<?php if($chkdate == 'Not Found'){  ?>
										<label class="btn btn-danger"> You are not in Current Financial Year </label>
									<?php } else { ?>
					<?= $this->Form->button(__('SALE RETURN'),['class'=>'btn btn-primary','type'=>'Submit']) ?>
									<?php } ?>											
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

<?php } ?>

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

		submitHandler: function (form3) {
			$('#add_submit').prop('disabled', true);
			$('#add_submit').text('Submitting.....');	
			success3.show();
			error3.hide();
			form3[0].submit();
		}

	});
	
	//--	 END OF VALIDATION
 
$('.quantity').die().live("keyup",function() {
			calculate_total();  
    });	

	function calculate_total(){  
		var total=0; var grand_total=0;
		$("#main_tb tbody#main_tbody tr.tr1").each(function(){
			var qty=parseInt($(this).find("td:nth-child(3) input").val());
			var Rate=parseFloat($(this).find("td:nth-child(4) input").val());
			var Amount=qty*Rate;
			$(this).find("td:nth-child(5) input").val(Amount.toFixed(2));
			total=total+Amount;
			});
		if($("#discount_per").is(':checked')){
			var discount_per=parseFloat($('input[name="discount_per"]').val());
			var discount_amount=(total*discount_per)/100;
			if(isNaN(discount_amount)) { var discount_amount = 0; }
			$('input[name="discount"]').val(discount_amount.toFixed(2));
		}else{
			var discount_amount=parseFloat($('input[name="discount"]').val());
			if(isNaN(discount_amount)) { var discount_amount = 0; }
		}
		total=total-discount_amount;
		var exceise_duty=parseFloat($('input[name="exceise_duty"]').val());
		if(isNaN(exceise_duty)) { var exceise_duty = 0; }
		total=total+exceise_duty
		$('input[name="total"]').val(total.toFixed(2));
		if($("#pnfper").is(':checked')){
			var pnf_per=parseFloat($('input[name="pnf_per"]').val());
			var pnf_amount=(total*pnf_per)/100;
			if(isNaN(pnf_amount)) { var pnf_amount = 0; }
			$('input[name="pnf"]').val(pnf_amount.toFixed(2));
		}else{
			var pnf_amount=parseFloat($('input[name="pnf"]').val());
			if(isNaN(pnf_amount)) { var pnf_amount = 0; }
		}
		var total_after_pnf=total+pnf_amount;
		if(isNaN(total_after_pnf)) { var total_after_pnf = 0; }
		$('input[name="total_after_pnf"]').val(total_after_pnf.toFixed(2));
		
		var sale_tax_per=parseFloat($('input[name="sale_tax_per"]').val());
		
		var sale_tax=(total_after_pnf*sale_tax_per)/100;
		if(isNaN(sale_tax)) { var sale_tax = 0; }
		$('input[name="sale_tax_amount"]').val(sale_tax.toFixed(2));
		
		var fright_amount=parseFloat($('input[name="fright_amount"]').val());
		//alert(fright_amount);
		if(isNaN(fright_amount)) { var fright_amount = 0; }
		
		grand_total=total_after_pnf+sale_tax+fright_amount;
		$('input[name="grand_total"]').val(grand_total.toFixed(2));
	}
		$('.addrefrow').live("click",function() { 
		add_ref_row();
	});
	function add_ref_row(){
		var tr=$("#sample_ref table.ref_table tbody tr").clone();
		$("table.main_ref_table tbody").append(tr);
		rename_ref_rows();
	}
	
	
	$('.rename_check').die().live("click",function() {
		rename_rows(); calculate_total();
    });
	
	$('.quantity').die().live("keyup",function() {
			rename_rows(); 
			calculate_total();
    });	
	

	rename_rows();
	function rename_rows(){
		$("#main_tb tbody tr.tr1").each(function(){  //alert();
			var row_no=$(this).attr('row_no');
			var val=$(this).find('td:nth-child(7) input[type="checkbox"]:checked').val();
			if(val){
				$(this).find('td:nth-child(2) input').attr("name","sale_return_rows["+row_no+"][item_id]").attr("id","sale_return_rows-"+row_no+"-item_id").rules("add", "required");
				$(this).find('td:nth-child(3) input').attr("name","sale_return_rows["+row_no+"][quantity]").attr("id","sale_return_rows-"+row_no+"-quantity").removeAttr("readonly").rules("add", "required");
				$(this).find('td:nth-child(4) input').attr("name","sale_return_rows["+row_no+"][rate]").attr("id","sale_return_rows-"+row_no+"-rate").rules("add", "required");
				$(this).find('td:nth-child(5) input').attr("name","sale_return_rows["+row_no+"][amount]").attr("id","sale_return_rows-"+row_no+"-amount").rules("add", "required");
				$(this).css('background-color','#fffcda');
				var qty=$(this).find('td:nth-child(3) input[type="text"]').val();
				var serial_l=$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] td:nth-child(2) select').length;
				if(serial_l>0){ 	
					$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] td:nth-child(2) select').removeAttr("readonly").attr("name","sale_return_rows["+row_no+"][itm_serial_number][]").attr("id","sale_return_rows-"+row_no+"-item_serial_no").attr('maxlength',qty).rules('add', {
						    required: true,
							minlength: qty,
							maxlength: qty,
							messages: {
								maxlength: "select serial number equal to quantity.",
								minlength: "select serial number equal to quantity."
							}
					});
					$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').css('background-color','#fffcda');
				}
			}else{

				$(this).find('td:nth-child(2) input').attr({ name:"q" , readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(3) input').attr({ name:"q" , readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(4) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(5) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).css('background-color','#FFF');
				var serial_l=$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] td:nth-child(2) select').length;
				if(serial_l>0){
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] select').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').css('background-color','#FFF');
				}
			}
			
				
				
		});
	}
	
	calculate_total();
	function calculate_total(){
		var total=0; var grand_total=0;
		$("#main_tb tbody tr.tr1").each(function(){
			var val=$(this).find('td:nth-child(7) input[type="checkbox"]:checked').val();
			if(val){
			var qty=parseInt($(this).find("td:nth-child(3) input").val());
			var Rate=parseFloat($(this).find("td:nth-child(4) input").val());
			var Amount=qty*Rate;
			$(this).find("td:nth-child(5) input").val(Amount.toFixed(2));
			total=total+Amount;
			}
		});
		if($("#discount_per").is(':checked')){
			var discount_per=parseFloat($('input[name="discount_per"]').val());
			var discount_amount=(total*discount_per)/100;
			if(isNaN(discount_amount)) { var discount_amount = 0; }
			$('input[name="discount"]').val(discount_amount.toFixed(2));
		}else{
			var discount_amount=parseFloat($('input[name="discount"]').val());
			if(isNaN(discount_amount)) { var discount_amount = 0; }
		}
		total=total-discount_amount
		
		var exceise_duty=parseFloat($('input[name="exceise_duty"]').val());
		if(isNaN(exceise_duty)) { var exceise_duty = 0; }
		total=total+exceise_duty
		$('input[name="total"]').val(total.toFixed(2));
		
		if($("#pnfper").is(':checked')){
			var pnf_per=parseFloat($('input[name="pnf_per"]').val());
			var pnf_amount=(total*pnf_per)/100;
			if(isNaN(pnf_amount)) { var pnf_amount = 0; }
			$('input[name="pnf"]').val(pnf_amount.toFixed(2));
		}else{
			var pnf_amount=parseFloat($('input[name="pnf"]').val());
			if(isNaN(pnf_amount)) { var pnf_amount = 0; }
		}
		var total_after_pnf=total+pnf_amount;
		if(isNaN(total_after_pnf)) { var total_after_pnf = 0; }
		$('input[name="total_after_pnf"]').val(total_after_pnf.toFixed(2));
		
		var sale_tax_per=parseFloat($('input[name="sale_tax_per"]').val());
		
		var sale_tax=(total_after_pnf*sale_tax_per)/100;
		if(isNaN(sale_tax)) { var sale_tax = 0; }
		$('input[name="sale_tax_amount"]').val(sale_tax.toFixed(2));
		
		var fright_amount=parseFloat($('input[name="fright_amount"]').val());
		//alert(fright_amount);
		if(isNaN(fright_amount)) { var fright_amount = 0; }
		
		grand_total=total_after_pnf+sale_tax+fright_amount;
		$('input[name="grand_total"]').val(grand_total.toFixed(2));
		
	}
	
	rename_ref_rows();
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

				var is_old=$(this).find("td:nth-child(2) input").attr('is_old');				
				var url='<?php echo $this->Url->build(['controller'=>'SaleReturns','action'=>'checkRefNumberUniqueEdit']); ?>';
				url=url+'/<?php echo $c_LedgerAccount->id; ?>/'+i+'/'+is_old;
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
				var is_ref_old_amount=$(this).find("td:nth-child(3) input.ref_old_amount").length;
				if(is_ref_old_amount){
					$(this).find("td:nth-child(3) input:eq(0)").attr({name:"ref_rows["+i+"][ref_old_amount]", id:"ref_rows-"+i+"-ref_old_amount"});
					$(this).find("td:nth-child(3) input:eq(1)").attr({name:"ref_rows["+i+"][ref_amount]", id:"ref_rows-"+i+"-ref_amount"}).rules("add", "required");
				}else{
				$(this).find("td:nth-child(3) input:eq(0)").attr({name:"ref_rows["+i+"][ref_amount]", id:"ref_rows-"+i+"-ref_amount"}).rules("add", "required");
				}
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
		var sel=$(this);
		delete_one_ref_no(sel);
	});
	
	$('.ref_type').live("change",function() {
		var current_obj=$(this);
		
		var ref_type=$(this).find('option:selected').val();
		if(ref_type=="Against Reference"){
			var url="<?php echo $this->Url->build(['controller'=>'SaleReturns','action'=>'fetchRefNumbers']); ?>";
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
		var sel=$(this);
		do_ref_total();
		delete_one_ref_no(sel);
	});
	
	$('.ref_amount_textbox').live("keyup",function() {
		do_ref_total();  
	});
	
do_ref_total();
	function do_ref_total(){
		var main_amount=parseFloat($('input[name="grand_total"]').val()); 
		
		if(!main_amount){ main_amount=0; }
		
		var total_ref=0;
		$("table.main_ref_table tbody tr").each(function(){
			var is_ref_old_amount=$(this).find("td:nth-child(3) input.ref_old_amount").length;
				if(is_ref_old_amount){
					var am=parseFloat($(this).find('td:nth-child(3) input:eq(1)').val());
				}else{
				var am=parseFloat($(this).find('td:nth-child(3) input:eq(0)').val());
				}
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
	
	$('.ref_type').live("change",function() {
		var sel=$(this);
		delete_one_ref_no(sel);
	});
	
	
	
	
	function delete_one_ref_no(sel){
		var old_received_from_id='<?php echo $c_LedgerAccount->id; ?>';
		
		var old_ref=sel.closest('tr').find('a.deleterefrow').attr('old_ref');
		var old_ref_type=sel.closest('tr').find('a.deleterefrow').attr('old_ref_type');
		var url="<?php echo $this->Url->build(['controller'=>'SaleReturns','action'=>'deleteOneRefNumbers']); ?>";
		url=url+'?old_received_from_id='+old_received_from_id+'&sale_return_id=<?php echo $saleReturn->id; ?>&old_ref='+old_ref+'&old_ref_type='+old_ref_type;
		
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			//alert(response);
		});
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