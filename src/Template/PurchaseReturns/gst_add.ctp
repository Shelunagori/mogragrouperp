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
			<span class="caption-subject font-blue-steel uppercase">Add Gst Purchase Return</span>
		</div>
	</div>
	
	<div class="portlet-body form">
		<?= $this->Form->create($purchaseReturn,['id'=> 'form_sample_3']) ?>
		<?php 	
				$first="01";
				$last="31";
				$start_date=$first.'-'.$financial_month_first->month;
				$end_date=$last.'-'.$financial_month_last->month;
		?>
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
							<label class="control-label">Supplier</label>
							<br/>
							<?php echo $this->Form->input('vendor_id', ['label' => false,'class' => 'form-control input-sm','type' =>'hidden','value'=>@$vendor_ledger_acc_id]); ?>
							<?php echo $this->Form->input('gst_type', ['label' => false,'type' =>'hidden','value'=>'Gst']); ?>
							<?php echo @$invoiceBooking->grn->vendor->company_name; ?>
						</div>
					</div>
					<div class="col-md-3" >
						<div class="form-group">
							<label class="control-label">Invoice Booking No</label></br>
							<?php echo @$invoiceBooking->ib1.'/IB-'.str_pad($invoiceBooking->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoiceBooking->ib3.'/'.$invoiceBooking->ib4; ?>
							<br/>
							<? ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Purchase Account </label><br/>
							<?php echo $ledger_account_details['name']; ?>
							<?php echo $this->Form->input('purchase_ledger_account', ['label' => false,'type'=>'hidden','class' => 'form-control input-sm','readonly','value'=>$ledger_account_details['id']]); ?>
						</div>
					</div>
				</div><br/>
				
				<div class="row" style="display:none;">
						<div class="form-group">
							<label class="control-label">Invoice Booking No. <span class="required" aria-required="true">*</span></label>
							<div class="row">
								<div class="col-md-3">
									<?php echo $this->Form->input('ib1', ['label' => false,'class' => 'form-control input-sm','readonly','value'=>@$invoiceBooking->company->alias]); ?>
								</div>
								<div class="col-md-3">
									<?php echo $this->Form->input('ib2', ['label' => false,'class' => 'form-control input-sm', 'value'=>@$invoiceBooking->ib2, 'readonly']); ?>
								</div>
								<div class="col-md-3">
									<?php echo $this->Form->input('ib3', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'File', 'value'=>@$invoiceBooking->ib3,'readonly']); ?>
								</div>
								<div class="col-md-3">
									<?php echo $this->Form->input('ib4', ['label' => false,'value'=>@$invoiceBooking->ib4,'class' => 'form-control input-sm','readonly']); ?>
								</div>
								<?php echo $this->Form->input('vendor_id', ['label' => false,'class' => 'form-control input-sm','type' =>'hidden','value'=>@$invoiceBooking->vendor_id]); ?>
							</div>
						</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Supplier Invoice Date. <span class="required" aria-required="true">*</span></label><br/>
							<?php echo @date("d-m-Y",strtotime($invoiceBooking->supplier_date)); ?>
								<?php echo $this->Form->input('supplier_date', ['type'=>'hidden','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'Supplier Date','data-date-format'=>'dd-mm-yyyy','data-date-start-date' 
										=>$start_date ,'data-date-end-date' => $end_date,'value' => date("d-m-Y",strtotime($invoiceBooking->supplier_date)),'readonly']); ?>
							
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Invoice No. <span class="required" aria-required="true">*</span></label><br/>
							<?php echo @$invoiceBooking->invoice_no; ?>
							<?php echo $this->Form->input('invoice_no', ['type' => 'hidden','label' => false,'class' => 'form-control input-sm','placeholder' => 'Invoice NO','readonly','value'=>$invoiceBooking->invoice_no]); ?>
							<br/>
							<? ?>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Transaction Date<span class="required" aria-required="true">*</span></label><br/>
							<?php echo $this->Form->input('transaction_date', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'Transaction Date','data-date-format'=>'dd-mm-yyyy','data-date-start-date' 
										=>$start_date ,'data-date-end-date' => $end_date,'required']); ?>
						</div>
						<span style="color: red;"><?php if($chkdate == 'Not Found'){  ?>
							You are not in Current Financial Year
						<?php } ?></span>				
					</div>
					<div class="col-md-3">
						<div class="form-group" id="ledger_account_for_vat">
							<!--<label class="control-label">Ledger Account for VAT<span class="required" aria-required="true">*</span></label>-->
							<?php //echo $this->Form->input('ledger_account_for_vat', ['options' => $ledger_account_vat,'label' => false,'class' => 'form-control input-sm']); ?>
							<br/>
							
						</div>
					</div>
				</div>
			
			
			<?php $gst_hide="style:display:;";
			  $igst_hide="style:display:;" ;
			  $tr2_colspan=15;
			  $tr3_colspan=10; 
			  $tr4_colspan=7; 
			?>
			
			<div style="overflow: auto;">
			<input type="text"  name="checked_row_length" id="checked_row_length" style="height: 0px;padding: 0;border: none;" value="" />
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
						<th rowspan="2" width="100px"></th>
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
							<?php echo $this->Form->input('purchase_return_rows.'.$q.'.item_id', ['label' => false,'class' => 'form-control input-sm cal','type'=>'hidden','value' => @$invoice_booking_row->item->id,'popup_id'=>$q]); ?>
							</td>
							
							<td><?php echo $this->Form->input('purchase_return_rows.'.$q.'.unit_rate_from_po',['value'=>$invoice_booking_row->unit_rate_from_po,'type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox cal','readonly']); ?></td>
							
							<td><?php echo $this->Form->input('purchase_return_rows.'.$q.'.quantity',['label' => false,'class' => 'form-control input-sm cal', 'value'=>@$invoice_booking_row->quantity,'readonly','max'=>@$invoice_booking_row->quantity,'type'=>'text','style'=>'width:50px;']); ?></td>
							
							<td align="center">
							<?php echo $this->Form->input('purchase_return_rows.'.$q.'.misc',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox cal','readonly','value'=>0,'value'=>$invoice_booking_row->misc]); ?>
							</td>
							
							<td><?php echo $this->Form->input('purchase_return_rows.'.$q.'.amount',['label' => false,'class' => 'form-control input-sm row_textbox cal','value'=>$invoice_booking_row->amount,'type'=>'text','readonly']); ?></td>
							
							<td align="center">
							<?php echo $this->Form->input('purchase_return_rows.'.$q.'.gst_discount_per',['value'=>0,'type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox cal','value'=>$invoice_booking_row->gst_discount_per,'readonly']); ?>
							</td>
							
							<td align="center">
							<?php echo $this->Form->input('purchase_return_rows.'.$q.'.discount',['value'=>0,'type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox dis_per','value'=>$invoice_booking_row->discount,'readonly']); ?>
							</td>
							
							<td align="center">
							<?php echo $this->Form->input('purchase_return_rows.'.$q.'.gst_pnf_per',['label' => false,'class' => 'form-control input-sm required row_textbox cal','id'=>'update_pnf','type'=>'text','placeholder' => 'pnf','value'=> $invoice_booking_row->gst_pnf_per,'readonly']); ?>
							</td>
							
							<td align="center">
							<?php echo $this->Form->input('purchase_return_rows.'.$q.'.pnf',['label' => false,'class' => 'form-control input-sm required row_textbox dis_per','id'=>'update_pnf','type'=>'text','placeholder' => 'pnf','value'=>0,'value'=> $invoice_booking_row->pnf,'readonly']); ?>
							</td>
							
							<td align="center">
							<?php echo $this->Form->input('purchase_return_rows.'.$q.'.taxable_value',['value'=>0,'type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox cal','value'=> $invoice_booking_row->taxable_value,'readonly']); ?>
							</td>
							
							<td class="cgst_display" align="center">
							<?php echo $this->Form->input('purchase_return_rows.'.$q.'.cgst_per', ['label' => false,'empty'=>'Select','options'=>$cgst_options,'class' => 'form-control input-sm row_textbox igst_percentage  fright_igst_percent cgst_percent','placeholder'=>'%','step'=>0.01,'value' => $invoice_booking_row->cgst_per,'readonly']); ?>
							</td>
							
							<td class="cgst_display" align="center">
							<?php echo $this->Form->input('purchase_return_rows.'.$q.'.cgst',['value'=>0,'type'=>'text','label'=>false,'class'=>'vattext rmvcls form-control input-sm row_textbox cal','readonly','value' => $invoice_booking_row->cgst,'readonly']); ?>
							</td>
							
							<td class="sgst_display"><?php echo $this->Form->input('purchase_return_rows.'.$q.'.sgst_per', ['label' => false,'empty'=>'Select','options'=>$sgst_options,'class' => 'form-control input-sm row_textbox igst_percentage  fright_igst_percent sgst_percent','placeholder'=>'%','step'=>0.01,'value' => $invoice_booking_row->sgst_per,'readonly']); ?>
							</td>
							
							<td class="sgst_display" align="center">
							<?php echo $this->Form->input('purchase_return_rows.'.$q.'.sgst',['value'=>0,'type'=>'text','label'=>false,'class'=>'vattext rmvcls form-control input-sm row_textbox cal','readonly','value' => $invoice_booking_row->sgst,'readonly']); ?>
							</td>
							
							<td class="igst_display" align="center"><?php echo $this->Form->input('purchase_return_rows.'.$q.'.igst_per', ['label' => false,'empty'=>'Select','options'=>$igst_options,'class' => 'form-control input-sm row_textbox igst_percentage  fright_igst_percent igst_percent','placeholder'=>'%','step'=>0.01,'value' => $invoice_booking_row->igst_per,'readonly']); ?></td>
							
							<td class="igst_display" align="center">
							<?php echo $this->Form->input('purchase_return_rows.'.$q.'.igst',['value'=>0,'type'=>'text','label'=>false,'class'=>'vattext rmvcls form-control input-sm row_textbox cal','readonly','value' => $invoice_booking_row->igst_per,'readonly']); ?>
							</td>
							
							<td><?php echo $this->Form->input('purchase_return_rows.'.$q.'.other_charges',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox cal','value' => $invoice_booking_row->other_charges,'readonly']); ?>
							</td>
							
							<td><?php echo $this->Form->input('purchase_return_rows.'.$q.'.total',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox cal','readonly']); ?></td>
							
							<td><?php echo $this->Form->input('purchase_return_rows.'.$q.'.rate',['type'=>'text','label'=>false,'class'=>'form-control input-sm row_textbox','readonly','value'=>$this->Number->format($invoice_booking_row->rate)]); ?>
							
							</td>
							<td><?php echo $this->Form->input('check.'.$q, ['label' => false,'type'=>'checkbox','class'=>'rename_check','value' => @$invoice_booking_row->id]); ?>
							</td>
						</tr>
						<tr class="tr2" row_no='<?php echo @$invoice_booking_row->id; ?>'>
							<td colspan="15">
							<?php echo $this->Text->autoParagraph($invoice_booking_row->description); ?>
							<?php echo $this->Form->input('purchase_return_rows.'.$q.'.description',['label' => false,'class' => 'form-control input-sm','type'=>'hidden','value'=>$invoice_booking_row->description]); ?>
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
						<td class="cgst_display" ><?php echo $this->Form->input('total_cgst_amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td class="sgst_display" ></td>
						<td class="sgst_display" ><?php echo $this->Form->input('total_sgst_amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td class="igst_display" ></td>
						<td class="igst_display" ><?php echo $this->Form->input('total_igst_amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly']); ?></td>
						<td><?php echo $this->Form->input('total_other_charge', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total','readonly']); ?></td>
						<td><?php echo $this->Form->input('total', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total','readonly','id'=>'total']); ?></td>
						<td><?php echo $this->Form->input('total_rate_to_post', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'rate to be post','readonly']); ?></td>
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
					<?= $this->Form->button(__('ADD PURCHASE  RETURN'),['class'=>'btn btn-primary','id'=>'add_submit','type'=>'Submit']) ?>
				<?php } ?>					
				</div>
			</div>
		</div>
	</div>	
	<?= $this->Form->end(); ?>
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
			$(this).find("td:nth-child(7) input").val(discount_per.toFixed(2));
			row_total=row_total-discount_amt;
			var amount_after_discount = amount_after_misc-discount_amt;
			var pnf_amt=parseFloat($(this).find("td:nth-child(10) input").val());
			total_pnf = total_pnf+pnf_amt;
			var pnf_per=100*(pnf_amt)/amount_after_discount;
			if(!pnf_per){pnf_per=0;}
			$(this).find("td:nth-child(9) input").val(pnf_per.toFixed(2));
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
		$('input[name="total_cgst_amount"]').val(total_cgst.toFixed(2));
		$('input[name="total_sgst_amount"]').val(total_sgst.toFixed(2));
		$('input[name="total_igst_amount"]').val(total_igst.toFixed(2));
		$('input[name="total_other_charge"]').val(total_other.toFixed(2));
		$('input[name="total"]').val(total_row_amount.toFixed(2));
		$('input[name="total_rate_to_post"]').val(total_rate_to_post);
	}
	
	
   calculate_total();
	$('.cal').die().live("keyup",function() { 
		calculate_total();
    });
	
	$('.fright_igst_percent').die().live("change",function() 
	{
		calculate_total();
	});
	function calculate_total(){ 
		var total_amount=0; var total_misc=0; var total_discount=0; 
		var total_pnf=0; var total_ex=0; var total_rate_to_post=0; var total_other=0; var total_row_amount=0; 
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
		$('input[name="total_cgst_amount"]').val(total_cgst.toFixed(2));
		$('input[name="total_sgst_amount"]').val(total_sgst.toFixed(2));
		$('input[name="total_igst_amount"]').val(total_igst.toFixed(2));
		$('input[name="total_other_charge"]').val(total_other.toFixed(2));
		$('input[name="total"]').val(total_row_amount.toFixed(2));
		$('input[name="total_rate_to_post"]').val(total_rate_to_post);
	}
	

	
	var purchase_ledger_account=$('input[name="purchase_ledger_account"]').val();
	var gst_ledger_id=$('input[name="purchase_ledger_account"]').val();
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
	/////////
	$('.rename_check').die().live("click",function() { 
		rename_rows();   calculate_total();
    });
	////////
	rename_rows();
	function rename_rows(){
		var i=0;
		$("#main_tb tbody tr.tr1").each(function(){  
			var row_no=$(this).attr('row_no');
			var val=$(this).find('td:nth-child(21) input[type="checkbox"]:checked').val();
			
			if(val){
				i++;
				$(this).find('td:nth-child(2) input').attr("name","purchase_return_rows["+row_no+"][item_id]").attr("id","purchase_return_rows-"+row_no+"-item_id").rules("add", "required");
				$(this).find('td:nth-child(3) input').attr("name","purchase_return_rows["+row_no+"][unit_rate_from_po]").attr("id","purchase_return_rows-"+row_no+"-unit_rate_from_po").removeAttr("readonly").rules("add", "required");
				$(this).find('td:nth-child(4) input').attr("name","purchase_return_rows["+row_no+"][quantity]").attr("id","purchase_return_rows-"+row_no+"-quantity").removeAttr("readonly").rules("add", "required");
				
				$(this).find('td:nth-child(5) input').attr("name","purchase_return_rows["+row_no+"][misc]").attr("id","purchase_return_rows-"+row_no+"-misc").removeAttr("readonly").rules("add", "required");
				$(this).find('td:nth-child(6) input').attr("name","purchase_return_rows["+row_no+"][amount]").attr("id","purchase_return_rows-"+row_no+"-amount").rules("add", "required");
				$(this).find('td:nth-child(7) input').attr("name","purchase_return_rows["+row_no+"][gst_discount_per]").attr("id","purchase_return_rows-"+row_no+"-gst_discount_per").rules("add", "required");
				$(this).find('td:nth-child(8) input').attr("name","purchase_return_rows["+row_no+"][discount]").attr("id","purchase_return_rows-"+row_no+"-discount").rules("add", "required");
				$(this).find('td:nth-child(9) input').attr("name","purchase_return_rows["+row_no+"][gst_pnf_per]").attr("id","purchase_return_rows-"+row_no+"-gst_pnf_per").rules("add", "required");
				$(this).find('td:nth-child(10) input').attr("name","purchase_return_rows["+row_no+"][pnf]").attr("id","purchase_return_rows-"+row_no+"-pnf").rules("add", "required");
				$(this).find('td:nth-child(11) input').attr("name","purchase_return_rows["+row_no+"][taxable_value]").attr("id","purchase_return_rows-"+row_no+"-taxable_value").rules("add", "required");
				$(this).find('td:nth-child(12) select').attr("name","purchase_return_rows["+row_no+"][cgst_per]").attr("id","purchase_return_rows-"+row_no+"-cgst_per").rules("add", "required");
				$(this).find('td:nth-child(13) input').attr("name","purchase_return_rows["+row_no+"][cgst]").attr("id","purchase_return_rows-"+row_no+"-cgst").rules("add", "required");
				$(this).find('td:nth-child(14) select').attr("name","purchase_return_rows["+row_no+"][sgst_per]").attr("id","purchase_return_rows-"+row_no+"-sgst_per").rules("add", "required");
				$(this).find('td:nth-child(15) input').attr("name","purchase_return_rows["+row_no+"][sgst]").attr("id","purchase_return_rows-"+row_no+"-sgst").rules("add", "required");
				$(this).find('td:nth-child(16) select').attr("name","purchase_return_rows["+row_no+"][igst_per]").attr("id","purchase_return_rows-"+row_no+"-igst_per").rules("add", "required");
				$(this).find('td:nth-child(17) input').attr("name","purchase_return_rows["+row_no+"][igst]").attr("id","purchase_return_rows-"+row_no+"-igst").rules("add", "required");
				$(this).find('td:nth-child(18) input').attr("name","purchase_return_rows["+row_no+"][other_charges]").attr("id","purchase_return_rows-"+row_no+"-other_charges").rules("add", "required");
				$(this).find('td:nth-child(19) input').attr("name","purchase_return_rows["+row_no+"][total]").attr("id","purchase_return_rows-"+row_no+"-total").rules("add", "required");
				$(this).find('td:nth-child(20) input').attr("name","purchase_return_rows["+row_no+"][rate]").attr("id","purchase_return_rows-"+row_no+"-rate").rules("add", "required");
				$(this).css('background-color','#fffcda');
				
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').find('td:nth-child(1) input').attr("name","purchase_return_rows["+row_no+"][description]").attr("id","purchase_return_rows-"+row_no+"-description").rules("add", "required");
				
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').css('background-color','#fffcda');
			}else{
				$(this).find('td:nth-child(2) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(3) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(4) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(5) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(6) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(7) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(8) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(9) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(10) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(11) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(12) select').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(13) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(14) select').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(15) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(16) select').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(17) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(18) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(19) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).find('td:nth-child(20) input').attr({ name:"q" , readonly:"readonly"}).removeAttr("required" );
				$(this).css('background-color','#FFF');
				var uncheck=$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]');
				$(uncheck).find('td:nth-child(1) input').attr({ name:"q", readonly:"readonly"});
				$(uncheck).css('background-color','#FFF');
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').css('background-color','#FFF');
				
			} 
			
			$('input[name="checked_row_length"]').val(i);
		
		});	
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
			checked_row_length: {
				required: true,
				min : 1,
			},
			advance: {
				min:0,
			},
			pnf: {
				required: true,
			},
			cheque_no :{
				required: true,
			},
			purchase_ledger_account :{
				required: true,
			},
			
		},

		messages: { // custom messages for radio buttons and checkboxes
			checked_row_length: {
				required : "Please select atleast one row.",
				min : "Please select atleast one row."
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
	add_ref_row();
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
			var url="<?php echo $this->Url->build(['controller'=>'PurchaseReturns','action'=>'fetchRefNumbers']); ?>";
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
	
	
	$('select[name="purchase_ledger_account"]').on("change",function() { 
	var gst_ledger_id=$('select[name="purchase_ledger_account"] option:selected').val();
	
		if(gst_ledger_id=="799" || gst_ledger_id=="800" )
		{  
			//$('.ledger_account_for_gst').val(gst_ledger_id);
				$('.igst_display').css("display", "none");
				$('.cgst_display').css("display", "");
				$('.sgst_display').css("display", "");
				$('.igst_percent option:selected').prop('selected', false);
				calculate_total();
				//$('.igst_percent :selected').attr('selected', '');
				//$('.igst_percent').removeAttr("selected");
				
		}else{
			//$('.ledger_account_for_gst').val(gst_ledger_id);
				$('.igst_display').css("display", "");
				$('.cgst_display').css("display", "none");
				$('.sgst_display').css("display", "none");
				$('.cgst_percent option:selected').prop('selected', false);
				$('.sgst_percent option:selected').prop('selected', false);
				 calculate_total();
				//$('.cgst_percent :selected').attr('selected', '');
				//$('.sgst_percent :selected').attr('selected', '');
				
	
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
				<td><?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount']); ?></td>
				<td><a class="btn btn-xs btn-default deleterefrow" href="#" role="button"><i class="fa fa-times"></i></a></td>
			</tr>
		</tbody>
	</table>
</div>
