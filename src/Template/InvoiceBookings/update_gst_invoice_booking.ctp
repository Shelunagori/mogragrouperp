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
			<span class="caption-subject font-blue-steel uppercase">Edit Gst Invoice Booking</span>
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
							<?php $option =[];
							foreach($ledger_account_details as $key => $ledger_account_detail)
							{ 
								if(($key!= 35 && $key!= 538 && $st_company_id==25))
								{
									$option[$key] = $ledger_account_detail;
								}
								elseif(($key!= 161 && $key!= 160 && $st_company_id==26))
								{
									$option[$key] = $ledger_account_detail;
								}
								elseif(($key!= 309 && $key!= 308 && $st_company_id==27))
								{
									$option[$key] = $ledger_account_detail;
								}
								
							}
							echo $this->Form->input('purchase_ledger_account', ['options' => $option,'label' => false,'class' => 'form-control input-sm']); ?>
							<?php echo $this->Form->input('cst_vat', ['label' => false,'type' => 'hidden']); ?>
							<br/>
							<? ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group" id="ledger_account_for_vat">
							<!--<label class="control-label">Ledger Account for VAT<span class="required" aria-required="true">*</span></label>-->
							<?php //echo $this->Form->input('ledger_account_for_vat', ['options' => $ledger_account_vat,'label' => false,'class' => 'form-control input-sm']); ?>
							<br/>
							<? ?>
						</div>
					</div>					
				</div>
				<div style="overflow: auto;">
				<table class="table tableitm" id="main_tb" border="1" >
				<thead>
					<tr>
						<th width="50" rowspan="2"><b>Sr.No. </b></th>
						<th style="white-space: nowrap;" rowspan="2"><b>Items</b></th>
						<th width="100" rowspan="2"><b>Unit Rate From PO</b></th>
						<th width="100" rowspan="2"><b>Quantity</b></th>
						<th width="100" rowspan="2"><b>Misc</b></th>
						<th width="100" rowspan="2"><b>Amount</b></th>
						<th width="100" colspan="2"><div align="center"><b>Discount</b></div></th>
						<th width="100" colspan="2" align="center"><div align="center"><b>P & F</b></div></th>
						<th width="100" rowspan="2"><b>Taxable Value </b></th>
						<th  class="cgst_display" width="100" colspan="2" align="center"><div align="center"><b>CGST</b></div></th>
						<th class="sgst_display" width="100" colspan="2" align="center"><div align="center"><b>SGST</b></div></th>
						<th class="igst_display" width="100" colspan="2" align="center"><div align="center"><b>IGST</b></div></th>
						<th width="100" rowspan="2"><b>Others</b></th>
						<th width="100" rowspan="2"><b>Total</b></th>
						<th width="100" rowspan="2"><b>rate to be posted</b></th>
					</tr>
					<tr>
						<th align="right">%</th>
						<th align="right">Rs</th>
						<th align="right">%</th>
						<th align="right">Rs</th>
						<th class="cgst_display" align="right">%</th>
						<th class="cgst_display" align="right">Rs</th>
						<th class="sgst_display" align="right">%</th>
						<th class="sgst_display" align="right">Rs</th>
						<th class="igst_display" align="right">%</th>
						<th class="igst_display" align="right">Rs</th>
					</tr>
				</thead>
				<tbody>
					<?php
							$cgst_options=array();
							$sgst_options=array();
							$igst_options=array();
							foreach($GstTaxes as $GstTaxe){
								if($GstTaxe->cgst=="Yes"){
									$merge_cgst=$GstTaxe->tax_figure.' ('.$GstTaxe->invoice_description.')';
									$cgst_options[]=['text' =>$merge_cgst, 'value' => $GstTaxe->id,'percentage'=>$GstTaxe->tax_figure];
								}else if($GstTaxe->sgst=="Yes"){
									$merge_sgst=$GstTaxe->tax_figure.' ('.$GstTaxe->invoice_description.')';
									$sgst_options[]=['text' =>$merge_sgst, 'value' => $GstTaxe->id,'percentage'=>$GstTaxe->tax_figure];
								}else if($GstTaxe->igst=="Yes"){
									$merge_igst=$GstTaxe->tax_figure.' ('.$GstTaxe->invoice_description.')';
									$igst_options[]=['text' =>$merge_igst, 'value' => $GstTaxe->id,'percentage'=>$GstTaxe->tax_figure];
								}
								
							}
					
					$q=0; foreach ($invoiceBooking->invoice_booking_rows as $invoice_booking_row): ?>
						<tr class="tr1" row_no='<?php echo @$invoice_booking_row->id; ?>'>
							<td rowspan="2"><?php echo ++$q; --$q; ?></td>
							
							<td style="white-space: nowrap;"><?php echo @$invoice_booking_row->item->name; ?>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.item_id', ['label' => false,'class' => 'form-control input-sm cal','type'=>'hidden','value' => @$invoice_booking_row->item->id,'popup_id'=>$q]); ?>
							</td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.unit_rate_from_po',['value'=>$invoice_booking_row->unit_rate_from_po,'type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox cal','readonly']); ?></td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.quantity',['label' => false,'class' => 'form-control input-sm cal', 'value'=>@$invoice_booking_row->quantity,'readonly','type'=>'text','style'=>'width:50px;']); ?></td>
							
							<td align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.misc',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox cal','value'=>0,'value'=>$invoice_booking_row->misc]); ?>
							</td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.amount',['label' => false,'class' => 'form-control input-sm row_textbox cal','value'=>$invoice_booking_row->amount,'type'=>'text','readonly']); ?></td>
							
							<td align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.gst_discount_per',['value'=>0,'type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox cal','value'=>$invoice_booking_row->gst_discount_per]); ?>
							</td>
							
							<td align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.discount',['value'=>0,'type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox dis_per','value'=>$invoice_booking_row->discount]); ?>
							</td>
							
							<td align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.gst_pnf_per',['label' => false,'class' => 'form-control input-sm required row_textbox cal','id'=>'update_pnf','type'=>'text','placeholder' => 'pnf','value'=> $invoice_booking_row->gst_pnf_per]); ?>
							</td>
							
							<td align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.pnf',['label' => false,'class' => 'form-control input-sm required row_textbox dis_per','id'=>'update_pnf','type'=>'text','placeholder' => 'pnf','value'=>0,'value'=> $invoice_booking_row->pnf]); ?>
							</td>
							
							<td align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.taxable_value',['value'=>0,'type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox cal','value'=> $invoice_booking_row->taxable_value]); ?>
							</td>
							
							<td class="cgst_display" align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.cgst_per', ['label' => false,'empty'=>'Select','options'=>$cgst_options,'class' => 'form-control input-sm row_textbox igst_percentage  fright_igst_percent cgst_percent','placeholder'=>'%','step'=>0.01,'value' => $invoice_booking_row->cgst_per,'required']); ?>
							</td>
							
							<td class="cgst_display" align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.cgst',['value'=>0,'type'=>'text','label'=>false,'class'=>'vattext rmvcls form-control input-sm row_textbox cal','readonly','value' => $invoice_booking_row->cgst,'required']); ?>
							</td>
							
							<td class="sgst_display"><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.sgst_per', ['label' => false,'empty'=>'Select','options'=>$sgst_options,'class' => 'form-control input-sm row_textbox igst_percentage  fright_igst_percent sgst_percent','placeholder'=>'%','step'=>0.01,'value' => $invoice_booking_row->sgst_per,'required']); ?>
							</td>
							
							<td class="sgst_display" align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.sgst',['value'=>0,'type'=>'text','label'=>false,'class'=>'vattext rmvcls form-control input-sm row_textbox cal','readonly','value' => $invoice_booking_row->sgst,'required']); ?>
							</td>
							
							<td class="igst_display" align="center"><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.igst_per', ['label' => false,'empty'=>'Select','options'=>$igst_options,'class' => 'form-control input-sm row_textbox igst_percentage  fright_igst_percent igst_percent','placeholder'=>'%','step'=>0.01,'value' => $invoice_booking_row->igst_per,'required']); ?></td>
							
							<td class="igst_display" align="center">
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.igst',['value'=>0,'type'=>'text','label'=>false,'class'=>'vattext rmvcls form-control input-sm row_textbox cal','readonly','value' => $invoice_booking_row->igst_per,'required']); ?>
							</td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.other_charges',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox cal','value' => $invoice_booking_row->other_charges]); ?>
							</td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.total',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox cal','readonly']); ?></td>
							
							<td><?php echo $this->Form->input('invoice_booking_rows.'.$q.'.rate',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox','readonly','value'=>$this->Number->format($invoice_booking_row->rate)]); ?>
							
							</td>
							
						</tr>
						<tr class="tr2" row_no='<?php echo @$invoice_booking_row->id; ?>'>
							<td colspan="11">
							<?php echo $this->Text->autoParagraph($invoice_booking_row->description); ?>
							<?php echo $this->Form->input('invoice_booking_rows.'.$q.'.description',['label' => false,'class' => 'form-control input-sm','type'=>'hidden','value'=>$invoice_booking_row->description]); ?>
							</td>
							<td></td>
						</tr>

					<?php $q++;  endforeach; ?>
				
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5" align="right"><b>Total</b></td>
						<td><?php echo $this->Form->input('total_amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td><td></td>
						<td><?php echo $this->Form->input('total_discount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td></td>
						<td><?php echo $this->Form->input('total_pnf', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td><?php echo $this->Form->input('taxable_value', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td class="cgst_display" ></td>
						<td class="cgst_display" ><?php echo $this->Form->input('total_cgst', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td class="sgst_display" ></td>
						<td class="sgst_display" ><?php echo $this->Form->input('total_sgst', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td class="igst_display" ></td>
						<td class="igst_display" ><?php echo $this->Form->input('total_igst', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td><?php echo $this->Form->input('total_other_charge', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total','readonly']); ?></td>
						<td><?php echo $this->Form->input('total', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total','readonly','id'=>'total']); ?></td>
						<td><?php echo $this->Form->input('total_rate_to_post', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'rate to be post','readonly']); ?></td>
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
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Narration </label>
								<?php echo $this->Form->input('narration', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Narration','rows'=>'2']); ?>							
						</div>
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
	
	$('.dis_per').die().live("blur",function() {
		calculate_pnf_discount(); 
	});
	function calculate_pnf_discount()
	{ 
		var total_amount=0; var total_misc=0; var total_discount=0; 
		var total_pnf=0; var total_ex=0; var total_rate_to_post=0; var total_other=0; var total_row_amount=0; 
		var total_cgst=0;var total_sgst=0;var total_igst=0; var total_taxable_value=0;
		$("#main_tb tbody tr.tr1").each(function()
		{   var row_total=0;
			var urate=parseFloat($(this).find("td:nth-child(3) input").val());
			var qty=parseFloat($(this).find("td:nth-child(4) input").val());
			var amount=urate*qty;
			row_total=row_total+amount;
			
			var misc=parseFloat($(this).find("td:nth-child(5) input").val());
			if(!misc){ misc=0; $(this).find("td:nth-child(6) input").val('');}
			var amount_after_misc=amount+misc;
			total_amount = total_amount+amount_after_misc;
			row_total=row_total+misc;
			$(this).find("td:nth-child(6) input").val(amount_after_misc.toFixed(2));
			
			var discount_amt=parseFloat($(this).find("td:nth-child(8) input").val());
            total_discount = total_discount+discount_amt;			
			var discount_per=100*(discount_amt)/amount_after_misc;
			if(!discount_per){discount_per=0;}
			$(this).find("td:nth-child(7) input").val(discount_per.toFixed(8));
			row_total=row_total-discount_amt;
			var amount_after_discount = amount_after_misc-discount_amt;
			var pnf_amt=parseFloat($(this).find("td:nth-child(10) input").val());
			total_pnf = total_pnf+pnf_amt;
			var pnf_per=100*(pnf_amt)/amount_after_discount;
			if(!pnf_per){pnf_per=0;}
			$(this).find("td:nth-child(9) input").val(pnf_per.toFixed(8));
			row_total = row_total+pnf_amt;
			total_taxable_value = total_taxable_value+parseFloat(row_total.toFixed(2));
			$(this).find("td:nth-child(11) input").val(row_total.toFixed(2));
			
			var cgst_percentage=parseFloat($(this).find("td:nth-child(12) option:selected").attr("percentage"));
			if(isNaN(cgst_percentage))
			{ 
					var cgst_amount = 0; 
					$(this).find("td:nth-child(13) input").val(cgst_amount.toFixed(2));
			}else
			{  
					var taxable_value=parseFloat($(this).find("td:nth-child(11) input").val());
					var cgst_amount = (taxable_value*cgst_percentage)/100;
					$(this).find("td:nth-child(13) input").val(cgst_amount.toFixed(2));
					row_total=row_total+((taxable_value*cgst_percentage)/100);
			}
			total_cgst=total_cgst+cgst_amount;
			
			var sgst_percentage=parseFloat($(this).find("td:nth-child(14) option:selected").attr("percentage"));
			if(isNaN(sgst_percentage)){ 
				 var sgst_amount = 0; 
				$(this).find("td:nth-child(15) input").val(sgst_amount.toFixed(2));
			}else{ 
			    var taxable_value=parseFloat($(this).find("td:nth-child(11) input").val());
				var sgst_amount = (taxable_value*sgst_percentage)/100;
				$(this).find("td:nth-child(15) input").val(sgst_amount.toFixed(2));
				row_total=row_total+((taxable_value*sgst_percentage)/100);
			}
			total_sgst=total_sgst+sgst_amount;
			var igst_percentage=parseFloat($(this).find("td:nth-child(16) option:selected").attr("percentage"));
			if(isNaN(igst_percentage)){ 
				 var igst_amount = 0; 
				$(this).find("td:nth-child(17) input").val(igst_amount.toFixed(2));
			}else{ 
				var taxable_value=parseFloat($(this).find("td:nth-child(11) input").val());
				var igst_amount = (taxable_value*igst_percentage)/100; 
				$(this).find("td:nth-child(17) input").val(igst_amount.toFixed(2));
				row_total=row_total+((taxable_value*igst_percentage)/100);
			}
			total_igst=total_igst+igst_amount;
		    var other=parseFloat($(this).find("td:nth-child(18) input").val());
			if(!other){ other=0; }
			row_total=row_total+other;
			total_other=total_other+other;
			var qty=parseFloat($(this).find("td:nth-child(4) input").val());
			var taxable_amount=parseFloat($(this).find("td:nth-child(11) input").val());
			$(this).find("td:nth-child(20) input").val((taxable_amount/qty).toFixed(5));
			total_rate_to_post = total_rate_to_post+parseFloat(((taxable_amount/qty).toFixed(5)));
			$(this).find("td:nth-child(19) input").val(row_total.toFixed(2));
			total_row_amount = total_row_amount+row_total;
		});
		$('input[name="total_amount"]').val(total_amount.toFixed(2));
		$('input[name="total_discount"]').val(total_discount.toFixed(2));
		$('input[name="total_pnf"]').val(total_pnf.toFixed(2));
		$('input[name="taxable_value"]').val(total_taxable_value.toFixed(2));
		$('input[name="total_cgst"]').val(total_cgst.toFixed(2));
		$('input[name="total_sgst"]').val(total_sgst.toFixed(2));
		$('input[name="total_igst"]').val(total_igst.toFixed(2));
		$('input[name="total_other_charge"]').val(total_other.toFixed(2));
		$('input[name="total"]').val(total_row_amount.toFixed(2));
		$('input[name="total_rate_to_post"]').val(total_rate_to_post);
	}
	
   calculate_total();
	$('.cal').die().live("blur",function() { 
		calculate_total();
    });
	$('.fright_igst_percent').die().live("change",function() 
	{
		calculate_total();
	});
	function calculate_total(){ 
		var total_amount=0; var total_misc=0; var total_discount=0; 
		var total_pnf=0; var total_ex=0; var total_rate_to_post=0; var total_other=0; var total_row_amount=0;  var taxable_value=0; 
		var total_cgst=0;var total_sgst=0;var total_igst=0; var total_taxable_value=0;
		$("#main_tb tbody tr.tr1").each(function(){ var row_total=0;
			var urate=parseFloat($(this).find("td:nth-child(3) input").val());
			var qty=parseFloat($(this).find("td:nth-child(4) input").val());
			var amount=urate*qty;
			row_total=row_total+amount;
			
			var misc=parseFloat($(this).find("td:nth-child(5) input").val());
			if(!misc){ misc=0; $(this).find("td:nth-child(6) input").val('');}
			var amount_after_misc=amount+misc;
			row_total=row_total+misc;
			total_amount=total_amount+amount_after_misc;
			$(this).find("td:nth-child(6) input").val(amount_after_misc.toFixed(2));
		
			var discount=parseFloat($(this).find("td:nth-child(7) input").val()); 
			//alert(discount_amt);
			if(!discount){ discount=0; $(this).find("td:nth-child(8) input").val(discount);}
			    var amount_after_discount=amount_after_misc*(discount)/100;
				total_discount=total_discount+(amount_after_misc*discount/100);
				row_total=row_total-(amount_after_misc*discount/100);
				
				if(discount){ 
			    $(this).find("td:nth-child(8) input").val(amount_after_discount.toFixed(2));}
			
			var pnf=parseFloat($(this).find("td:nth-child(9) input").val()); 
			var pnf_amt=parseFloat($(this).find("td:nth-child(10) input").val()); 
			if(!pnf && pnf_amt){ pnf=0; 
					$(this).find("td:nth-child(10) input").val(pnf);
			}
			    
				var amount_after_pnf = row_total*(pnf)/100;
				total_pnf = total_pnf+(row_total*(pnf)/100);
				row_total = row_total+(row_total*(pnf)/100);
				total_taxable_value = total_taxable_value+parseFloat(row_total.toFixed(2));
				if(pnf)
				{ 
					$(this).find("td:nth-child(10) input").val(amount_after_pnf.toFixed(2));
				}
				$(this).find("td:nth-child(11) input").val(row_total.toFixed(2));
			    
			var cgst_percentage=parseFloat($(this).find("td:nth-child(12) option:selected").attr("percentage"));
			if(isNaN(cgst_percentage))
			{ 
					var cgst_amount = 0; 
					$(this).find("td:nth-child(13) input").val(cgst_amount.toFixed(2));
			}else
			{  
					var taxable_value=parseFloat($(this).find("td:nth-child(11) input").val());
					var cgst_amount = (taxable_value*cgst_percentage)/100;
					$(this).find("td:nth-child(13) input").val(cgst_amount.toFixed(2));
					row_total=row_total+((taxable_value*cgst_percentage)/100);
			}
			total_cgst=total_cgst+cgst_amount;
			
			var sgst_percentage=parseFloat($(this).find("td:nth-child(14) option:selected").attr("percentage"));
			if(isNaN(sgst_percentage)){ 
				 var sgst_amount = 0; 
				$(this).find("td:nth-child(15) input").val(sgst_amount.toFixed(2));
			}else{ 
			    var taxable_value=parseFloat($(this).find("td:nth-child(11) input").val());
				var sgst_amount = (taxable_value*sgst_percentage)/100;
				$(this).find("td:nth-child(15) input").val(sgst_amount.toFixed(2));
				row_total=row_total+((taxable_value*sgst_percentage)/100);
			}
			total_sgst=total_sgst+sgst_amount;
			var igst_percentage=parseFloat($(this).find("td:nth-child(16) option:selected").attr("percentage"));
			if(isNaN(igst_percentage)){ 
				 var igst_amount = 0; 
				$(this).find("td:nth-child(17) input").val(igst_amount.toFixed(2));
			}else{ 
				var taxable_value=parseFloat($(this).find("td:nth-child(11) input").val());
				var igst_amount = (taxable_value*igst_percentage)/100; 
				$(this).find("td:nth-child(17) input").val(igst_amount.toFixed(2));
				row_total=row_total+((taxable_value*igst_percentage)/100);
			}
			total_igst=total_igst+igst_amount;
			var other=parseFloat($(this).find("td:nth-child(18) input").val());
			if(!other){ other=0; }
			//row_total=row_total+other;
			total_other=total_other+other;
			
			var taxable_value=parseFloat($(this).find("td:nth-child(11) input").val());
			taxable_value=parseFloat(taxable_value.toFixed(2));
			cgst_amount=parseFloat(cgst_amount.toFixed(2));
			sgst_amount=parseFloat(sgst_amount.toFixed(2));
			igst_amount=parseFloat(igst_amount.toFixed(2));
			other=parseFloat(other.toFixed(2));
			
			row_total=taxable_value+cgst_amount+sgst_amount+igst_amount+other;
			var qty=parseFloat($(this).find("td:nth-child(4) input").val());
			var taxable_amount=parseFloat($(this).find("td:nth-child(11) input").val());
			$(this).find("td:nth-child(20) input").val((taxable_amount/qty).toFixed(5));
			total_rate_to_post = total_rate_to_post+parseFloat(((taxable_amount/qty).toFixed(5)));
			$(this).find("td:nth-child(19) input").val(row_total.toFixed(2));
			total_row_amount = total_row_amount+row_total;
		});
		$('input[name="total_amount"]').val(total_amount.toFixed(2));
		$('input[name="total_discount"]').val(total_discount.toFixed(2));
		$('input[name="total_pnf"]').val(total_pnf.toFixed(2));
		$('input[name="taxable_value"]').val(total_taxable_value.toFixed(2));
		$('input[name="total_cgst"]').val(total_cgst.toFixed(2));
		$('input[name="total_sgst"]').val(total_sgst.toFixed(2));
		$('input[name="total_igst"]').val(total_igst.toFixed(2));
		$('input[name="total_other_charge"]').val(total_other.toFixed(2));
		$('input[name="total"]').val(total_row_amount.toFixed(2));
		$('input[name="total_rate_to_post"]').val(total_rate_to_post);
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
		rules: {
			
		
		},
		messages: {
			
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

		submitHandler: function (form3) {
			$('#add_submit').prop('disabled', true);
			$('#add_submit').text('Submitting.....');
			success3.show();
			error3.hide();
			form3[0].submit();
				
				
			
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
			$("table.main_ref_table tfoot tr:eq(1) td:eq(1) input").attr({name:"ref_rows_total", id:"ref_rows_total"}).rules('add', { equalTo: "#total" });
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
	
	
	var purchase_ledger_account=$('select[name="purchase_ledger_account"]').val();
	var gst_ledger_id=$('select[name="purchase_ledger_account"] option:selected').val();
		if(gst_ledger_id=="799" || gst_ledger_id=="800" )
		{  
				$('.igst_display').css("display", "none");
				$('.cgst_display').css("display", "");
				$('.sgst_display').css("display", "");
				$('.igst_percent option:selected').prop('selected', false);
				calculate_total();
				
		}else{
				$('.igst_display').css("display", "");
				$('.cgst_display').css("display", "none");
				$('.sgst_display').css("display", "none");
				$('.cgst_percent option:selected').prop('selected', false);
				$('.sgst_percent option:selected').prop('selected', false);
				calculate_total();
				
	
		}
	
		$('select[name="purchase_ledger_account"]').on("change",function() { 
		var gst_ledger_id=$('select[name="purchase_ledger_account"] option:selected').val();
			if(gst_ledger_id=="799" || gst_ledger_id=="800" )
			{  
					$('.igst_display').css("display", "none");
					$('.cgst_display').css("display", "");
					$('.sgst_display').css("display", "");
					$('.igst_percent option:selected').prop('selected', false);
					calculate_total();
					
			}else{
					$('.igst_display').css("display", "");
					$('.cgst_display').css("display", "none");
					$('.sgst_display').css("display", "none");
					$('.cgst_percent option:selected').prop('selected', false);
					$('.sgst_percent option:selected').prop('selected', false);
					 calculate_total();
			}
		});


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

