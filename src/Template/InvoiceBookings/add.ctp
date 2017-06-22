<?php  
$item_po_info=[];
foreach($grn->purchase_order->purchase_order_rows as $purchase_order_row){
	$item_po_info[$purchase_order_row->item_id]=$purchase_order_row;
} 
?>
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
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Add Invoice Booking</span>
		</div>
	</div>
	
	<?php if(!empty($grn)) { ?>
	<div class="portlet-body form">
		<?= $this->Form->create($invoiceBooking,['id'=> 'form_sample_3']) ?>
		
			<div class="form-body">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">GRN No.</label>
							<br/>
							<?= h(($grn->grn1.'/GRN-'.str_pad($grn->grn2, 3, '0', STR_PAD_LEFT).'/'.$grn->grn3.'/'.$grn->grn4)) ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Supplier</label>
							<br/>
							<?php echo $this->Form->input('vendor_ledger_id', ['label' => false,'class' => 'form-control input-sm','type' =>'hidden','value'=>@$vendor_ledger_acc_id]); ?>
							<?php echo @$grn->vendor->company_name; ?>
						</div>
					</div>
					<div class="col-md-3" >
						<div class="form-group">
							<label class="control-label">Invoice Booking No</label></br>
							<?php echo $grn->grn1.'/IB-'.str_pad($last_ib_no->ib2, 3, '0', STR_PAD_LEFT).'/'.$grn->grn3.'/'.$grn->grn4; ?>
							<br/>
							<? ?>
						</div>
					</div>
					<div class="col-md-2 pull-right">
									<div class="form-group">
										<label class="control-label">Date</label>
										<br/>
										<?php echo date("d-m-Y"); ?>
									</div>
					<span style="color: red;"><?php if($chkdate == 'Not Found'){  ?>
					You are not in Current Financial Year
				<?php } ?></span>				
					</div>
				</div><br/>
				
				<div class="row" style="display:none;">
						<div class="form-group">
							<label class="control-label">Invoice Booking No. <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<div class="col-md-3">
									<?php echo $this->Form->input('ib1', ['label' => false,'class' => 'form-control input-sm','readonly','value'=>@$grn->company->alias]); ?>
								</div>
								<div class="col-md-3">
									<?php echo $this->Form->input('ib2', ['label' => false,'class' => 'form-control input-sm', 'value'=>@$last_ib_no->ib2, 'readonly']); ?>
								</div>
								<div class="col-md-3">
									<?php echo $this->Form->input('ib3', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'File', 'value'=>@$grn->grn3,'readonly']); ?>
								</div>
								<div class="col-md-3">
									<?php echo $this->Form->input('ib4', ['label' => false,'value'=>substr($s_year_from, -2).'-'.substr($s_year_to, -2),'class' => 'form-control input-sm','readonly']); ?>
								</div>
								<?php echo $this->Form->input('vendor_id', ['label' => false,'class' => 'form-control input-sm','type' =>'hidden','value'=>@$grn->vendor_id]); ?>
							</div>
						</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Supplier Invoice Date. <span class="required" aria-required="true">*</span></label>
								<?php echo $this->Form->input('supplier_date', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'Supplier Date','data-date-format'=>'dd-mm-yyyy','data-date-start-date' => date("d-m-Y",strtotime($fromdate1)),'data-date-end-date' => date("d-m-Y",strtotime($tody1))]); ?>
							
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
					<?php $total=0; $sum=0;
					$q=0; foreach ($grn->grn_rows as $grn_rows): ?>
						<tr class="tr1" row_no='<?php echo @$grn_rows->id; ?>'>
							<td rowspan="2"><?php echo ++$q; --$q; ?></td>
							<?php
							
							$dis=($discount*$grn->purchase_order->purchase_order_rows[$q]->amount)/$grn->purchase_order->total;
							;
							$item_discount=$dis/$grn->purchase_order->purchase_order_rows[$q]->quantity;
							
							$item_rate=$grn->purchase_order->purchase_order_rows[$q]->amount-$dis;
							$total_sale=($tot_sale_tax*$item_rate)/$item_total_rate;
							$item_sale=$total_sale/$grn->purchase_order->purchase_order_rows[$q]->quantity;
							
						
							$excise_duty_discount=($excise_duty*$item_rate)/$item_total_rate;
							$total_exicese_duty=$excise_duty_discount/$grn->purchase_order->purchase_order_rows[$q]->quantity;
							
							?>
							<td style="white-space: nowrap;"><?php echo $grn_rows->item->name; ?>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.item_id', ['label' => false,'class' => 'form-control input-sm','type'=>'hidden','value' => @$grn_rows->item->id,'popup_id'=>$q]); ?>
							</td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.unit_rate_from_po',['value'=>$item_po_info[$grn_rows->item->id]->rate,'type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox','readonly']); ?></td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.quantity',['label' => false,'class' => 'form-control input-sm ', 'value'=>$grn_rows->quantity,'readonly','type'=>'text','style'=>'width:50px;']); ?></td>
							
							<td align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.misc',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox','value'=>0]); ?>
							</td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.amount',['label' => false,'class' => 'form-control input-sm row_textbox','value'=>$grn->purchase_order->purchase_order_rows[$q]->rate*$grn_rows->quantity,'type'=>'text','readonly']); ?></td>
							
							<td align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.discount',['value'=>0,'type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox']); ?>
							<input name="invoice_booking_rows[<?php echo $q; ?>][discount_per]" type="checkbox" class="tooltips per_check" data-original-title="percentages" data-placement="bottom"/> <span class="check_text">In Amount</span>
							</td>
							
							<td align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.pnf',['label' => false,'class' => 'form-control input-sm required row_textbox','id'=>'update_pnf','type'=>'text','placeholder' => 'pnf','value'=>0]); ?>
							<input name="invoice_booking_rows[<?php echo $q; ?>][pnf_per]" type="checkbox" class="tooltips per_check" data-original-title="percentages" data-placement="bottom"/> <span class="check_text">In Amount</span>
							</td>
								
							<td align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.excise_duty',['value'=>0,'type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox']); ?>
							<span class="check_text">In percentages</span>
							</td>
							
							<td align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.sale_tax',['value'=>0,'type'=>'text','label'=>false,'class'=>'vattext rmvcls form-control input-sm row_textbox ']); ?>
							<span class="check_text">In percentages</span>
							</td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.other_charges',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox','value'=>0]); ?>
							</td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.total',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox','readonly']); ?></td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.rate',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox','readonly']); ?></td>
							
						</tr>
						<tr class="tr2" row_no='<?php echo @$grn_rows->id; ?>'>
							<td colspan="11">
							<?php echo $this->Text->autoParagraph($grn->purchase_order->purchase_order_rows[$q]->description); ?>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.description',['label' => false,'class' => 'form-control input-sm','type'=>'hidden','value'=>$grn->purchase_order->purchase_order_rows[$q]->description]); ?>
							</td>
							<td></td>
						</tr>
						<tr>
							 
						
						
						</tr>

					<?php $q++; $total=$total+$sum; endforeach; ?>

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
		<div class="form-actions">
						<div class="row">
							<div class="col-md-3">
									<?php if($chkdate == 'Not Found'){  ?>
					<label class="btn btn-danger"> You are not in Current Financial Year </label>
				<?php } else { ?>
					<?= $this->Form->button(__('BOOK INVOICE'),['class'=>'btn btn-primary','id'=>'add_submit','type'=>'Submit']) ?>
				<?php } ?>	
				
						</div>
				</div>
		</div>
	</div>	
	
	<?php } ?> <?= $this->Form->end() ?>
			
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
	}else if(purchase_ledger_account=="538"){
		$('#main_tb thead th:eq(9)').text('VAT');
		$('input[name="cst_vat"]').val('VAT');
		$('#ledger_account_for_vat').show();
		 
	}else if(purchase_ledger_account=="161"){
		$('#main_tb thead th:eq(9)').text('CST');
		$('input[name="cst_vat"]').val('CST');
		$('#ledger_account_for_vat').hide();
	}else if(purchase_ledger_account=="160"){
		$('#main_tb thead th:eq(9)').text('VAT');
		$('input[name="cst_vat"]').val('VAT');
		$('#ledger_account_for_vat').show();
	}else if(purchase_ledger_account=="309"){
		$('#main_tb thead th:eq(9)').text('CST');
		$('input[name="cst_vat"]').val('CST');
		$('#ledger_account_for_vat').hide();
	}else if(purchase_ledger_account=="308"){
		$('#main_tb thead th:eq(9)').text('VAT');
		$('input[name="cst_vat"]').val('VAT');
		$('#ledger_account_for_vat').show();
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
			$(this).find("td:nth-child(13) input").val((total_for_rate/qty).toFixed(5));
			
			
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
		ignore: ":hidden",
		rules: {
			advance: {
				min:0,
			},
			pnf: {
				required: true,
			},
			cheque_no :{
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
			
			success3.show();
			error3.hide();
			form[0].submit();
		}

	});

	
	//ref no //
	
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
			
			$(this).find("td:nth-child(3) input").attr({name:"ref_rows["+i+"][ref_amount]", id:"ref_rows-"+i+"-ref_amount"}).rules("add", "required");
			i++;
		});
		var is_tot_input=$("table.main_ref_table tfoot tr:eq(1) td:eq(1) input").length;
		if(is_tot_input){
			$("table.main_ref_table tfoot tr:eq(1) td:eq(1) input").attr({name:"ref_rows_total", id:"ref_rows_total"}).rules('add', { equalTo: "#total" });
		}
		
	}
	$('.deleterefrow').live("click",function() {
		$(this).closest("tr").remove();
		do_ref_total();
	});
	
	$('.ref_type').live("change",function() {
		var current_obj=$(this);
		//alert('<?php echo $v_LedgerAccount->id; ?>');
		
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
	});
	
	$('.ref_amount_textbox').live("keyup",function() {
		do_ref_total();
	});
	
	function do_ref_total(){
		var main_amount=parseFloat($('input[name="total"]').val());
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
