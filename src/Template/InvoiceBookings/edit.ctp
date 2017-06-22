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
<?php $this->Form->templates([ 'inputContainer' => '{{content}}' ]);?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Edit Invoice Booking</span>
		</div>
		
	</div>
	
	
	<div class="portlet-body form">
		<?= $this->Form->create($invoiceBooking,['id'=> 'form_sample_3']) ?>
		
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
							<?php echo $this->Form->input('vendor_ledger_id', ['label' => false,'class' => 'form-control input-sm','type' =>'hidden','value'=>@$vendor_ledger_acc_id]); ?>
							<?php echo @$invoiceBooking->grn->vendor->company_name; ?>
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
										<?php echo date("d-m-Y"); ?> <br>
										<span style="color: red;">
											<?php if($chkdate == 'Not Found'){  ?>
												You are not in Current Financial Year
											<?php } ?>
										</span>
									</div>
								</div>
				</div><br/>
				<div class="row" style="display:none;">
						<div class="form-group">
							<label class="control-label">Invoice Booking No. <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<div class="col-md-3">
									<?php echo $this->Form->input('ib1', ['label' => false,'class' => 'form-control input-sm','readonly']); ?>
								</div>
								<div class="col-md-3">
									<?php echo $this->Form->input('ib2', ['label' => false,'class' => 'form-control input-sm','readonly']); ?>
								</div>
								<div class="col-md-3">
									<?php echo $this->Form->input('ib3', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'File', 'readonly']); ?>
								</div>
								<div class="col-md-3">
									<?php echo $this->Form->input('ib4', ['label' => false,'class' => 'form-control input-sm','readonly']); ?>
								</div>
								<?php echo $this->Form->input('grn_id', ['label' => false,'class' => 'form-control input-sm','readonly']); ?>
							</div>
						</div>
				</div>
				
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Supplier Invoice Date. <span class="required" aria-required="true">*</span></label>
								<?php echo $this->Form->input('supplier_date', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'Supplier Date','data-date-format'=>'dd-mm-yyyy','data-date-start-date' => date("d-m-Y",strtotime($fromdate1)),'data-date-end-date' => date("d-m-Y",strtotime($tody1)),'value' => date("d-m-Y",strtotime($invoiceBooking->supplier_date))]); ?>
							
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Invoice No. <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('invoice_no', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Invoice NO']); ?>
							<br/>
							<? ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Purchase Account <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('purchase_ledger_account', ['options' => $ledger_account_details,'label' => false,'class' => 'form-control input-sm']); ?>
							<?php echo $this->Form->input('cst_vat', ['label' => false,'type' => 'hidden']); ?>
							<br/>
							<? ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group" id="ledger_account_for_vat">
							<label class="control-label">Ledger Account for VAT<span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('ledger_account_for_vat', ['options' => $ledger_account_vat,'label' => false,'class' => 'form-control input-sm']); ?>
							<br/>
							<? ?>
						</div>
					</div>					
				</div>
				<div style="overflow: auto;">
				<table class="table tableitm" id="main_tb">
				<thead>
					<tr>
						<th width="50">Sr.No. </th>
						<th style="white-space: nowrap;">Items</th>
						<th width="100">Unit Rate From PO</th>
						<th width="100">Quantity</th>
						<th width="100">Misc</th>
						<th width="100">Amount</th>
						<th width="100">Discount</th>
						<th width="100">P & F</th>
						<th width="100">Excise Duty</th>
						<th width="100">CST</th>
						<th width="100">Others</th>
						<th width="100">Total</th>
						<th width="100">Rate to be post</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$q=0; foreach ($invoiceBooking->invoice_booking_rows as $invoice_booking_row): ?>
						<tr class="tr1" row_no='<?php echo @$invoice_booking_row->id; ?>'>
							<td rowspan="2"><?php echo ++$q; --$q; ?></td>
							
							<td style="white-space: nowrap;"><?php echo $invoice_booking_row->item->name; ?>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.item_id', ['label' => false,'class' => 'form-control input-sm','type'=>'hidden','value' => @$invoice_booking_row->item->id,'popup_id'=>$q]); ?>
							</td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.unit_rate_from_po',['value'=>$invoice_booking_row->unit_rate_from_po,'type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox','readonly']); ?></td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.quantity',['label' => false,'class' => 'form-control input-sm','type'=>'text','value'=>$invoice_booking_row->quantity,'readonly']); ?></td>
							
							
							<td align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.misc',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox','value'=>$invoice_booking_row->misc]); ?>
							</td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.amount',['label' => false,'class' => 'form-control input-sm row_textbox','type'=>'text','readonly']); ?></td>
							
							<td>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.discount',['value'=>$invoice_booking_row->discount,'label'=>false,'type'=>'text','class'=>'form-control input-sm row_textbox']); ?>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.discount_per',['label'=>false,'type'=>'checkbox','class'=>'per_check']); ?>
							<span class="check_text">In Amount</span>
							</td>
								
							<td>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.pnf',['value'=> $invoice_booking_row->pnf,'label'=>false,'type'=>'text','class'=>'form-control input-sm row_textbox']); ?>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.pnf_per',['label'=>false,'type'=>'checkbox','class'=>'per_check']); ?>
							<span class="check_text">In Amount</span>
							</td>
							
							<td>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.excise_duty',['value'=>$invoice_booking_row->excise_duty,'label'=>false,'type'=>'text','class'=>'form-control input-sm row_textbox']); ?>
							<span class="check_text">In percentages</span>
							</td>
							
							<td>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.sale_tax',['value'=>$invoice_booking_row->sale_tax,'label'=>false,'type'=>'text','class'=>'rmvcls vattext form-control input-sm row_textbox']); ?>
							<span class="check_text">In percentages</span>
							</td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.other_charges',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox','value'=>$invoice_booking_row->other_charges]); ?>
							</td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.total',['label' => false,'class' => 'form-control input-sm row_textbox','type'=>'text','readonly']); ?></td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.rate',['label' => false,'class' => 'form-control input-sm row_textbox','value'=>$this->Number->format($invoice_booking_row->rate,['places'=>2]),'type'=>'text','readonly']); ?></td>
							
							
						</tr>
						<tr class="tr2" row_no='<?php echo @$invoice_booking_row->id; ?>'>
							<td colspan="11">
							<?php echo $this->Text->autoParagraph(($invoice_booking_row->description)); ?>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.description',['label' => false,'class' => 'form-control input-sm','type'=>'hidden','value'=>$invoice_booking_row->description]); ?>
							</td>
							<td></td>
						</tr>

					<?php $q++;  endforeach; ?>
				
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5" align="right"><b>Total</b></td>
						<td><?php echo $this->Form->input('total_amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td><?php echo $this->Form->input('total_discount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td><?php echo $this->Form->input('total_pnf', ['type' => 'text','label' => false,'class' => 'form-control input-sm']); ?></td>
						<td><?php echo $this->Form->input('total_ex', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td><?php echo $this->Form->input('total_saletax', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td><?php echo $this->Form->input('total_other_charges', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td><?php echo $this->Form->input('total', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total','readonly']); ?></td>
						<td></td>
					</tr>
				</tfoot>
			</table>
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
							<?php foreach($ReferenceDetails as $old_ref_row){  ?>
								<tr>
									<td><?php echo $this->Form->input('ref_types', ['empty'=>'--Select-','options'=>$ref_types,'label' => false,'class' => 'form-control input-sm ref_type','value'=>$old_ref_row->reference_type]); ?></td>
									<td class="ref_no">
									<?php if($old_ref_row->reference_type=="Against Reference"){
										echo $this->requestAction('InvoiceBookings/fetchRefNumbersEdit/'.$v_LedgerAccount->id.'/'.$old_ref_row->reference_no.'/'.$old_ref_row->credit);
									}else{
										echo '<input type="text" class="form-control input-sm" placeholder="Ref No." value="'.$old_ref_row->reference_no.'" readonly="readonly" is_old="yes">';
									}?>
									</td>
									<td>
									<?php 
											echo $this->Form->input('old_amount', ['label' => false,'class' => '','type'=>'hidden','value'=>$old_ref_row->credit]);
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

<script>
$(document).ready(function() {
	//--------- FORM VALIDATION
	$('input[name="total_pnf"]').die().live("keyup",function() {
		totalpnf=parseFloat($(this).val());
		var total=0;
		$("#main_tb tbody tr.tr1").each(function(){
			var amout=parseFloat($(this).find("td:nth-child(6) input").val());
			
			var discount=parseFloat($(this).find("td:nth-child(7) input").val());
			if(!discount){ discount=0; }
			if($(this).find('td:nth-child(7) input[type="checkbox"]').is(':checked')==true){
				var amount_after_discount=amout*(100-discount)/100;
			}else{
				var amount_after_discount=amout-discount;
			}
			total=total+amount_after_discount;
		});
		
		$("#main_tb tbody tr.tr1").each(function(){
			var amout=parseFloat($(this).find("td:nth-child(6) input").val());
			
			var discount=parseFloat($(this).find("td:nth-child(7) input").val());
			if(!discount){ discount=0; }
			if($(this).find('td:nth-child(7) input[type="checkbox"]').is(':checked')==true){
				var amount_after_discount=amout*(100-discount)/100;
			}else{
				var amount_after_discount=amout-discount;
			}
			var pnf=(amount_after_discount/total)*totalpnf;
			$(this).find("td:nth-child(8) input").val(pnf.toFixed(5))
		});
	});
	
	
	var purchase_ledger_account=$('select[name="purchase_ledger_account"]').val();
	if(purchase_ledger_account=="35"){
		$('#main_tb thead th:eq(9)').text('CST');
		$('input[name="cst_vat"]').val('CST');
		$('#ledger_account_for_vat').hide();
		$(".rmvcls").removeClass("vattext");
	}else if(purchase_ledger_account=="538"){
		$('#main_tb thead th:eq(9)').text('VAT');
		$('input[name="cst_vat"]').val('VAT');
		$(".rmvcls").addClass("vattext");
			//$('.vattext').val(0);
		$('#ledger_account_for_vat').show();
			$('.vattext').die().live("blur",function() {
			var text = $(this).val();
				if(text!="5" && text!="14.50" && text!="14.5" && text!="5.50" && text!="5.5"){
					$(this).val(0);
				}
	});
	
	}else if(purchase_ledger_account=="161"){
		$('#main_tb thead th:eq(9)').text('CST');
		$('input[name="cst_vat"]').val('CST');
		$('#ledger_account_for_vat').hide();
		$(".rmvcls").removeClass("vattext");
	}else if(purchase_ledger_account=="160"){
		$('#main_tb thead th:eq(9)').text('VAT');
		$('input[name="cst_vat"]').val('VAT');
		$('#ledger_account_for_vat').show();
		$(".rmvcls").addClass("vattext");
			$('.vattext').val(0);
			$('.vattext').die().live("blur",function() {
			var text = $(this).val();
				if(text!="5" && text!="14.50" && text!="14.5" && text!="5.50" && text!="5.5"){
					$(this).val(0);
				}
	});
	}else if(purchase_ledger_account=="309"){ 
		$('#main_tb thead th:eq(9)').text('CST');
		$('input[name="cst_vat"]').val('CST');
		$('#ledger_account_for_vat').hide();
		$(".rmvcls").removeClass("vattext");
	}else if(purchase_ledger_account=="308"){
		$('#main_tb thead th:eq(9)').text('VAT');
		$('input[name="cst_vat"]').val('VAT');
		$('#ledger_account_for_vat').show();
		$(".rmvcls").addClass("vattext");
		$('.vattext').val(0);
			$('.vattext').die().live("blur",function() {
			var text = $(this).val();
				if(text!="5" && text!="14.50" && text!="14.5" && text!="5.50" && text!="5.5"){
					$(this).val(0);
				}
	});
	}
	
	
	$('select[name="purchase_ledger_account"]').die().live("change",function() {
		var purchase_ledger_account=$(this).val();
		if(purchase_ledger_account=="35"){ 
			$('#main_tb thead th:eq(9)').text('CST');
			$('input[name="cst_vat"]').val('CST');
			$('#ledger_account_for_vat').hide();
			$(".rmvcls").removeClass("vattext");
		}else if(purchase_ledger_account=="538"){ 
			
			$('#main_tb thead th:eq(9)').text('VAT');
			$('input[name="cst_vat"]').val('VAT');
			$('#ledger_account_for_vat').show(); 
			$(".rmvcls").addClass("vattext");
			$('.vattext').val(0);
			$('.vattext').die().live("blur",function() {
			var text = $(this).val(); 
				if(text!="5" && text!="14.50" && text!="14.5" && text!="5.50" && text!="5.5"){
					$(this).val(0);
				}
			});
		}else if(purchase_ledger_account=="161"){
			$('#main_tb thead th:eq(9)').text('CST');
			$('input[name="cst_vat"]').val('CST');
			$('#ledger_account_for_vat').hide();
			$(".rmvcls").removeClass("vattext");
		}else if(purchase_ledger_account=="160"){
			$('#main_tb thead th:eq(9)').text('VAT');
			$('input[name="cst_vat"]').val('VAT');
			$('#ledger_account_for_vat').show();
			$(".rmvcls").addClass("vattext");
			$('.vattext').val(0);
			$('.vattext').die().live("blur",function() {
			var text = $(this).val();
				if(text!="5" && text!="14.50" && text!="14.5" && text!="5.50" && text!="5.5"){
					$(this).val(0);
				}
			});
		}else if(purchase_ledger_account=="309"){
			$('#main_tb thead th:eq(9)').text('CST');
			$('input[name="cst_vat"]').val('CST');
			$('#ledger_account_for_vat').hide();
			$(".vattext").removeClass("vattext");
		}else if(purchase_ledger_account=="308"){
			$('#main_tb thead th:eq(9)').text('VAT');
			$('input[name="cst_vat"]').val('VAT');
			$('#ledger_account_for_vat').show();
			$(".rmvcls").addClass("vattext");
			$('.vattext').val(0);
			$('.vattext').die().live("blur",function() {
			var text = $(this).val();
				if(text!="5" && text!="14.50" && text!="14.5" && text!="5.50" && text!="5.5"){
					$(this).val(0);
				}
			});
		}
		calculate_total();
    });
   
	$('.per_check').die().live("click",function() {
		if($(this).is(':checked')==true){
			$(this).closest('td').find('span.check_text').text('In percentages');
		}else{
			$(this).closest('td').find('span.check_text').text('In amount');
		}
		calculate_total();
    });
	
	$('.add_check').die().live("click",function() {
		if($(this).is(':checked')==true){
			$(this).closest('td').find('span.add_check_text').text('To be subtract');
		}else{
			$(this).closest('td').find('span.add_check_text').text('To be add');
		}
		calculate_total();
    });
	
   calculate_total();
	$('#main_tb input:not(input[name="total_pnf"])').die().live("keyup",function() { 
		calculate_total();
    });
	function calculate_total(){
		 var total_amount=0; var total_misc=0; var total_discount=0; 
		var total_pnf=0; var total_ex=0; var total_cst=0; var total_other=0; var total_row_amount=0; 
		$("#main_tb tbody tr.tr1").each(function(){ var row_total=0;
			var urate=parseFloat($(this).find("td:nth-child(3) input").val());
			var qty=parseFloat($(this).find("td:nth-child(4) input").val());
			var amount=urate*qty;
			row_total=row_total+amount;
			
			var misc=parseFloat($(this).find("td:nth-child(5) input").val());
			if(!misc){ misc=0; }
			var amount_after_misc=amount+misc;
			row_total=row_total+misc;
			total_amount=total_amount+amount_after_misc;
			
			$(this).find("td:nth-child(6) input").val(amount_after_misc.toFixed(2));
		
			var discount=parseFloat($(this).find("td:nth-child(7) input").val());
			if(!discount){ discount=0; }
			if($(this).find('td:nth-child(7) input[type="checkbox"]').is(':checked')==true){
				var amount_after_discount=amount_after_misc*(100-discount)/100;
				total_discount=total_discount+(amount_after_misc*discount/100);
				row_total=row_total-(amount_after_misc*discount/100);
			}else{
				var amount_after_discount=amount_after_misc-discount;
				total_discount=total_discount+discount;
				row_total=row_total-discount;
			}
			
			
			var pnf=parseFloat($(this).find("td:nth-child(8) input").val());
			if(!pnf){ pnf=0; }
			if($(this).find('td:nth-child(8) input[type="checkbox"]').is(':checked')==true){
				var amount_after_pnf=amount_after_discount*(100+pnf)/100;
				total_pnf=total_pnf+(amount_after_discount*pnf/100);
				row_total=row_total+(amount_after_discount*pnf/100);
			}else{
				var amount_after_pnf=amount_after_discount+pnf;
				total_pnf=total_pnf+pnf;
				row_total=row_total+pnf;
			}
			var ex=parseFloat($(this).find("td:nth-child(9) input").val());
			if(!ex){ ex=0; }
			var amount_after_ex=amount_after_pnf*(100+ex)/100;
			total_ex=total_ex+(amount_after_pnf*ex/100);
			row_total=row_total+(amount_after_pnf*ex/100);
			
			var total_for_rate=amount_after_ex;
			
			var vat_cst=$('select[name="purchase_ledger_account"]').val();
			if(vat_cst==35){
				var cst=parseFloat($(this).find("td:nth-child(10) input").val());
				if(!cst){ cst=0; }
				var amount_after_cst=amount_after_ex*(100+cst)/100;
				total_cst=total_cst+(amount_after_ex*cst/100);
				total_for_rate=total_for_rate+(amount_after_ex*cst/100);
			}else if(vat_cst==538){
				var cst=parseFloat($(this).find("td:nth-child(10) input").val());
				if(!cst){ cst=0; }
				var amount_after_cst=amount_after_ex*(100+cst)/100;
				total_cst=total_cst+(amount_after_ex*cst/100);
				total_for_rate=amount_after_ex;
			}else if(vat_cst==161){
				var cst=parseFloat($(this).find("td:nth-child(10) input").val());
				if(!cst){ cst=0; }
				var amount_after_cst=amount_after_ex*(100+cst)/100;
				total_cst=total_cst+(amount_after_ex*cst/100);
				total_for_rate=total_for_rate+(amount_after_ex*cst/100);
			}else if(vat_cst==160){
				var cst=parseFloat($(this).find("td:nth-child(10) input").val());
				if(!cst){ cst=0; }
				var amount_after_cst=amount_after_ex*(100+cst)/100;
				total_cst=total_cst+(amount_after_ex*cst/100);
				total_for_rate=amount_after_ex;
			}else if(vat_cst==309){
				var cst=parseFloat($(this).find("td:nth-child(10) input").val());
				if(!cst){ cst=0; }
				var amount_after_cst=amount_after_ex*(100+cst)/100;
				total_cst=total_cst+(amount_after_ex*cst/100);
				total_for_rate=total_for_rate+(amount_after_ex*cst/100);
			}else if(vat_cst==308){
				var cst=parseFloat($(this).find("td:nth-child(10) input").val());
				if(!cst){ cst=0; }
				var amount_after_cst=amount_after_ex*(100+cst)/100;
				total_cst=total_cst+(amount_after_ex*cst/100);
				total_for_rate=amount_after_ex;
			}
			row_total=row_total+(amount_after_ex*cst/100);
			
			var other=parseFloat($(this).find("td:nth-child(11) input").val());
			if(!other){ other=0; }
			var amount_after_other=amount_after_cst+misc;
			row_total=row_total+other;
			total_for_rate=total_for_rate+other;
			total_other=total_other+other;
			
			$(this).find("td:nth-child(12) input").val(row_total.toFixed(2));
			$(this).find("td:nth-child(13) input").val((total_for_rate/qty).toFixed(2));
			
			
			total_row_amount=total_row_amount+row_total;
			
			
		});
		$('input[name="total_amount"]').val(total_amount.toFixed(2));
		$('input[name="total_discount"]').val(total_discount.toFixed(2));
		$('input[name="total_pnf"]').val(total_pnf.toFixed(2));
		$('input[name="total_ex"]').val(total_ex.toFixed(2));
		$('input[name="total_saletax"]').val(total_cst.toFixed(2));
		$('input[name="total_other_charges"]').val(total_other.toFixed(2));
		$('input[name="total"]').val(total_row_amount.toFixed(2));
	}
   
  
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
		ignore: ":hidden,[readonly=readonly]",
		rules: {
			advance: {
				min:0,
			},
			cheque_no :{
				required: true,
			},
		
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
			$('#add_submit').prop('disabled', true);
			$('#add_submit').text('Submitting.....');
			success3.show();
			error3.hide();
			form[0].submit();
				
				
			
			// // submit the form
		}

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
		$("table.main_ref_table tbody tr").each(function(){
			$(this).find("td:nth-child(1) select").attr({name:"ref_rows["+i+"][ref_type]", id:"ref_rows-"+i+"-ref_type"}).rules("add", "required");
			var is_select=$(this).find("td:nth-child(2) select").length;
			var is_input=$(this).find("td:nth-child(2) input").length;
			
			if(is_select){
				$(this).find("td:nth-child(2) select").attr({name:"ref_rows["+i+"][ref_no]", id:"ref_rows-"+i+"-ref_no"}).rules("add", "required");
			}else if(is_input){
				var url='<?php echo $this->Url->build(['controller'=>'InvoiceBookings','action'=>'checkRefNumberUnique']); ?>';
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
			var is_ref_old_amount=$(this).find("td:nth-child(3) input:eq(0)").length;
			if(is_ref_old_amount){
				$(this).find("td:nth-child(3) input:eq(0)").attr({name:"ref_rows["+i+"][ref_old_amount]", id:"ref_rows-"+i+"-ref_old_amount"});
				$(this).find("td:nth-child(3) input:eq(1)").attr({name:"ref_rows["+i+"][ref_amount]", id:"ref_rows-"+i+"-ref_amount"}).rules("add", "required");
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
			var url="<?php echo $this->Url->build(['controller'=>'InvoiceBookings','action'=>'fetchRefNumbers']); ?>";
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
		delete_one_ref_no(sel);
	});
	
	$('.ref_amount_textbox').live("keyup",function() {
		do_ref_total(); 
	});
	do_ref_total();
	function do_ref_total(){
		var main_amount=parseFloat($('input[name="total"]').val());
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
	
	$('.ref_type').live("change",function() {
		var sel=$(this);
		delete_one_ref_no(sel);
	});
	
	function delete_one_ref_no(sel){
		var old_received_from_id='<?php echo $v_LedgerAccount->id; ?>';
		var old_ref=sel.closest('tr').find('a.deleterefrow').attr('old_ref');
		var old_ref_type=sel.closest('tr').find('a.deleterefrow').attr('old_ref_type');
		var url="<?php echo $this->Url->build(['controller'=>'InvoiceBookings','action'=>'deleteOneRefNumbers']); ?>";
		url=url+'?old_received_from_id='+old_received_from_id+'&invoice_booking_id=<?php echo $invoiceBooking->id; ?>&old_ref='+old_ref+'&old_ref_type='+old_ref_type;
		
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
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
				<td><?php echo $this->Form->input('amount', ['type' =>'hidden','class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount']); ?>
				<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount']); ?>
				</td>
				<td><a class="btn btn-xs btn-default deleterefrow" href="#" role="button"><i class="fa fa-times"></i></a></td>
			</tr>
		</tbody>
	</table>
</div>

