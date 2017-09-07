<style>
@media print{
	.maindiv{
		width:100% !important;
	}	
	.hidden-print{
		display:none;
	}
}
p{
margin-bottom: 0;
}
.table_rows th{
		border: 1px solid  #000;
		font-size:'. h($invoice->pdf_font_size).' !important;
		margin:5%;
	}
	.table_rows td{
		border: 1px solid  #000;
		font-size:'. h($invoice->pdf_font_size).' !important;
		margin:5%;
	}
</style>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0 5px 0 5px;  /* this affects the margin in the printer settings */
}
</style>
<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: 5px;width: 90%;font-size:14px;" class="maindiv">	
	<table width="100%" class="divHeader">
		<tr>
			<td width="30%"><?php echo $this->Html->image('/logos/'.$invoiceBooking->company->logo, ['width' => '40%']); ?></td>
			<td align="center" width="40%" style="font-size: 12px;"><div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">INVOICE BOOKING</div></td>
			<td align="right" width="30%" style="font-size: 12px;">
			<span style="font-size: 14px;"><?= h($invoiceBooking->company->name) ?></span>
			<span><?= $this->Text->autoParagraph(h($invoiceBooking->company->address)) ?>
			</span>
			<span> <i class="fa fa-phone" aria-hidden="true"></i> <?= h($invoiceBooking->company->landline_no) ?></span> |
			<?= h($invoiceBooking->company->mobile_no) ?>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<div style="border:solid 2px #0685a8;margin-bottom:5px;margin-top: 5px;"></div>
			</td>
		</tr>
	</table>
		<table width="100%">
		<tr>
			<td width="50%" valign="top" align="left">
				<table>
					<tr>
						<td><b>Invoice Booking No</b></td>
						<td width="20" align="center">:</td>
						<td><?= h($invoiceBooking->ib1.'/IB-'.str_pad($invoiceBooking->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoiceBooking->ib3.'/'.$invoiceBooking->ib4) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td><b>Date</b></td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($invoiceBooking->created_on))) ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="50%" valign="top" align="left">
				<table>
					<tr>
						<td><b>Supplier Invoice No</b></td>
						<td width="20" align="center">:</td>
						<td><?= h($invoiceBooking->invoice_no) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td><b>Supplier Invoice Date</b></td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($invoiceBooking->supplier_date))) ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="50%" valign="top" align="left">
				<table>
					<tr>
						<td><b>Supplier Name</b></td>
						<td width="20" align="center">:</td>
						<td><?= h($invoiceBooking->vendor->company_name) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td><b>Purchase Account</b></td>
						<td width="20" align="center">:</td>
						<td><?= h($purchase_acc->name) ?></td>
					</tr>
				</table>
			</td>
			
		</tr>
		<tr>
			<td width="50%" valign="top" align="left">
				<table>
					<tr>
						<td><b>PO No</b></td>
						<td width="20" align="center">:</td>
						<td><?= h($invoiceBooking->grn->purchase_order->po1.'/PO-'.str_pad($invoiceBooking->grn->purchase_order->po2, 3, '0', STR_PAD_LEFT).'/'.$invoiceBooking->grn->purchase_order->po3.'/'.$invoiceBooking->grn->purchase_order->po4) ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
</br>
<?php $page_no=$this->Paginator->current('InvoiceBookings'); $page_no=($page_no-1)*20; ?>
<table width="100%" class="table_rows"  border="0">	
	<thead>
			<tr>
				<th rowspan="2" style="text-align: bottom; margin-left:2px;"> &nbsp;Sr.No. </th>
				<th style="text-align: center;" rowspan="2">Items</th>
				<th style="text-align: center;" rowspan="2"  >Quantity</th>
				<th style="text-align: center;" rowspan="2" >Rate</th>
				<th style="text-align: center;" rowspan="2" > Amount</th>
				<th style="text-align: center;" colspan="2" >Discount</th>
				<th style="text-align: center;" colspan="2" >P&F </th>
				<th style="text-align: center;" rowspan="2" >Taxable Value</th>
				<?php if($purchase_acc->name=='Purchase GST'){ ?>
				<th style="text-align: center;" colspan="2">CGST</th>
				<th style="text-align: center;" colspan="2" >SGST</th>
				<?php }else { ?>
				<th style="text-align: center;" colspan="2" >IGST</th> 
				<?php } ?>
				<th style="text-align: center;" rowspan="2" >Others</th>
				<th style="text-align: center;" rowspan="2" >Total</th>
			</tr>
			<tr> 
			<th style="text-align: center;" > %</th>
				<th style="text-align: center;">Amt</th>
				<th style="text-align: center;" > %</th>
				<th style="text-align: center;" >Amt</th>
				<?php if($purchase_acc->name=='Purchase GST'){ ?>
				<th style="text-align: center;" > %</th>
				<th style="text-align: center;" >Amt</th>
				<th style="text-align: center;" > %</th>
				<th style="text-align: center;" >Amt</th>
				<?php }else { ?>
				<th style="text-align: center; " >%</th>
				<th style="text-align: center;" >Amt</th>
				<?php }?>
			</tr>
		</thead>
	<tbody>
	<?php $Total=0; $total_sale_tax=0; $total_cgst=0; $total_sgst=0; $total_igst=0; $total_taxable=0; $total_amount=0;$other_charges=0;
	
	foreach ($invoiceBooking->invoice_booking_rows as $invoice_booking_row): ?>
		<tr>
			<td>&nbsp;<?= h(++$page_no) ?></td>
			<td ><?= $invoice_booking_row->item->name; ?></td>
			<td align="center" width="6%"><?= $invoice_booking_row->quantity; ?></td>
			<td align="right"><?=  number_format($invoice_booking_row->unit_rate_from_po, 2, '.', '');?></td>
			<td align="right"><?= number_format($invoice_booking_row->quantity*$invoice_booking_row->unit_rate_from_po, 2, '.', '');?></td>
			<?php if($invoice_booking_row->gst_discount_per==0){ ?>
			<td align="right"></td>
			<td align="right"></td>
			<?php }else{ ?>
			<td align="right"><?=number_format($invoice_booking_row->gst_discount_per, 2, '.', '');?></td>
			<td align="right"><?=number_format($invoice_booking_row->discount, 2, '.', '');?></td>
			<?php } ?>
			<?php if($invoice_booking_row->gst_pnf_per==0){ ?>
			<td align="right"></td>
			<td align="right"></td>
			<?php }else{ ?>
			<td align="right"><?= number_format($invoice_booking_row->gst_pnf_per, 2, '.', ''); ?></td>
			<td align="right"><?= number_format($invoice_booking_row->pnf, 2, '.', ''); ?></td>
			<?php } ?>
			
			<td align="right"><?= $invoice_booking_row->taxable_value; $total_taxable=$total_taxable+$invoice_booking_row->taxable_value; ?></td>
			<?php  $invoice_booking_row->amount; $total_amount=$total_amount+$invoice_booking_row->amount; ?>
			<?php if($purchase_acc->name=='Purchase GST'){ ?>
			<td align="right"><?php if(!empty($cgst_per[$invoice_booking_row->id]['tax_figure'])){echo $cgst_per[$invoice_booking_row->id]['tax_figure'].'%';} ?></td>
			<td align="right"><?= $invoice_booking_row->cgst; 
								$total_cgst= $total_cgst+$invoice_booking_row->cgst;  ?></td>
			<td align="right"><?php if(!empty($sgst_per[$invoice_booking_row->id]['tax_figure'])){ echo $sgst_per[$invoice_booking_row->id]['tax_figure'].'%';} ?></td>
			<td align="right"><?= $invoice_booking_row->sgst; $total_sgst= $total_sgst+$invoice_booking_row->sgst;   ?></td>
			<?php }else{ ?>
			<td align="right"><?php if(!empty($igst_per[$invoice_booking_row->id]['tax_figure'])){ echo $igst_per[$invoice_booking_row->id]['tax_figure'].'%'; } ?></td>
			<td align="right"><?= $invoice_booking_row->igst; $total_igst= $total_igst+$invoice_booking_row->igst;   ?></td>
			<?php } ?>
			<?php if($invoice_booking_row->other_charges==0){ ?>
			<td align="right"></td>
			<?php }else{ ?>
			<td align="right"><?= $invoice_booking_row->other_charges; $other_charges= $other_charges+$invoice_booking_row->other_charges; ?></td>
			<?php } ?>
			<td align="right"><?= $invoice_booking_row->total; ?></td>
		</tr>
		
		<?php 
		$amount_after_misc=($invoice_booking_row->quantity*$invoice_booking_row->unit_rate_from_po)+$invoice_booking_row->misc;
		if($invoice_booking_row->discount_per){
			$amount_after_discount=$amount_after_misc*(100-$invoice_booking_row->discount)/100;
		}else{
			$amount_after_discount=$amount_after_misc-$invoice_booking_row->discount;
		}
		
		if($invoice_booking_row->pnf_per){
			$amount_after_pnf=$amount_after_discount*(100+$invoice_booking_row->pnf)/100;
		}else{
			$amount_after_pnf=$amount_after_discount+$invoice_booking_row->pnf;
		}
		
		
		$amount_after_excise=$amount_after_pnf*(100+$invoice_booking_row->excise_duty)/100;
		
		if($invoiceBooking->purchase_ledger_account==538 || $invoiceBooking->purchase_ledger_account==308 || $invoiceBooking->purchase_ledger_account==160){
			$vat=$amount_after_excise*$invoice_booking_row->sale_tax/100;
		}
		
		$total_sale_tax=$total_sale_tax+@$vat; 
		$Total= $Total+$invoice_booking_row->total;
		endforeach; ?>
		
	</tbody>
	
	<tfoot>
		<tr>
			<?php $col_span=13; if($purchase_acc->name=='Purchase GST'){ $col_span=15;} ?>
			<td style="font-size:14px; font-weight:bold;"  align="right" colspan="4"> Total</td>
			<td style="font-size:14px; font-weight:bold; "  align="right"><?= 
			number_format($total_amount, 2, '.', '');
			 ?></td>
			 <?php $col_span=13; if($purchase_acc->name=='Purchase GST'){ $col_span=15;} ?>
			<td style="font-size:14px; font-weight:bold;"  align="right" colspan="4"> </td>
			<td style="font-size:14px; font-weight:bold; "  align="right"><?= 
			number_format($total_taxable, 2, '.', '');
			 ?></td>
			 <?php if($purchase_acc->name=='Purchase GST'){ ?>
			<?php $col_span=13; if($purchase_acc->name=='Purchase GST'){ $col_span=15;} ?>
			<td style="font-size:14px; font-weight:bold;"  align="right" colspan="1"> </td>
			<td style="font-size:14px; font-weight:bold; "  align="right"><?= 
			number_format($total_cgst, 2, '.', '');
			 ?></td>
			<?php $col_span=13; if($purchase_acc->name=='Purchase GST'){ $col_span=15;} ?>
			<td style="font-size:14px; font-weight:bold;"  align="right" colspan="1"> </td>
			<td style="font-size:14px; font-weight:bold; "  align="right"><?= 
			number_format($total_sgst, 2, '.', '');
			 ?></td>
		<?php }else { ?>
			<?php $col_span=13; if($purchase_acc->name=='Purchase GST'){ $col_span=15;} ?>
			<td style="font-size:14px; font-weight:bold;"  align="right" colspan="1"> </td>
			<td style="font-size:14px; font-weight:bold; "  align="right"><?= 
			number_format($total_igst, 2, '.', '');
			 ?></td>
		<?php } ?>
		<?php $col_span=13; if($purchase_acc->name=='Purchase GST'){ $col_span=15;} ?>
			<td style="font-size:14px; font-weight:bold;"  align="right" colspan="1"> <?= 
			number_format($other_charges, 2, '.', '');
			 ?></td>
			<td style="font-size:14px; font-weight:bold; "  align="right"><?= 
			number_format($invoiceBooking->total, 2, '.', '');
			 ?></td>
		</tr>
		
		
	</tfoot>
</table>
<div style="border:solid 1px ;margin-top: 12px;"></div>
<table width="100%" class="divFooter">
	<tr>
		<td style="vertical-align: top !important;">
			<table width="100%">
			    <tr>
					<td><b>Narration :</b>&nbsp;&nbsp;<?php echo $invoiceBooking->narration;?></td>
				</tr>
			</table>
			<table width="100%">
			    <tr>
					<td colspan="2"><b>Reference Numbers:</b></td>
				</tr>
				<?php foreach($ReferenceDetails as $ReferenceDetail){ ?>
				<tr>
				    <td width="22%"></td>
				    <td width="18%">Ref No - <?php echo $ReferenceDetail->reference_no; ?></td>
				    <td width="5%"align="left">:</td>
					<td align="left" style="padding-left:10px;"><?php echo $ReferenceDetail->credit; ?> Cr</td>
				</tr>
				<?php } ?>
			</table>
		</td>
		<td align="right">
		<table>
			<tr>
				<td align="center">
				<span style="font-size:14px;">For</span> <span style="font-size: 14px;font-weight: bold;"><?= h($invoiceBooking->company->name)?><br/></span>
				<?php 
				 echo $this->Html->Image('/signatures/'.$invoiceBooking->creator->signature,['height'=>'50px','style'=>'height:50px;']); 
				 ?></br>
				<span style="font-size: 14px;font-weight: bold;">Authorised Signatory</span>
				</br>
				<span style="font-size:14px;"><?= h($invoiceBooking->creator->name) ?></span><br/>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>	
<style>
.table thead tr th {
    color: #FFF;
	//background-color: #254b73;
}
.padding-right-decrease{
	padding-right: 0;
}
.padding-left-decrease{
	padding-left: 0;
}
</style>
</div>

