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
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 5px !important;
}
</style>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0 5px 0 20px;  /* this affects the margin in the printer settings */
}
</style>
<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 70%;font-size:14px;" class="maindiv">	
	<table width="100%" class="divHeader">
		<tr>
			<td width="30%"><?php echo $this->Html->image('/logos/'.$purchaseReturn->company->logo, ['width' => '40%']); ?></td>
			<td align="center" width="40%" style="font-size: 12px;"><div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">Purchase Return</div></td>
			<td align="right" width="30%" style="font-size: 12px;">
			<span style="font-size: 14px;"><?= h($purchaseReturn->company->name) ?></span>
			<span><?= $this->Text->autoParagraph(h($purchaseReturn->company->address)) ?>
			<?= h($purchaseReturn->company->mobile_no) ?></span>
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
						<td><?= h($purchaseReturn->invoice_booking->ib1.'/IB-'.str_pad($purchaseReturn->invoice_booking->ib2, 3, '0', STR_PAD_LEFT).'/'.$purchaseReturn->invoice_booking->ib3.'/'.$purchaseReturn->invoice_booking->ib4) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td><b>Created On</b></td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($purchaseReturn->created_on))) ?></td>
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
						<td><?= h($purchaseReturn->invoice_booking->invoice_no) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td><b>Supplier Invoice Date</b></td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($purchaseReturn->invoice_booking->supplier_date))) ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
</br>
<?php $page_no=$this->Paginator->current('InvoiceBookings'); $page_no=($page_no-1)*20; ?>
<table width="100%" class="table tableitm"  border="0">	
	<thead>
		<tr>
			<th >S.No</th>
			<th >Item Name</th>
			<th style="text-align: center;">Quantity</th>
			<th style="text-align: right;">Rate</th>
			<th style="text-align: right;">Amount</th>
		</tr>
	</thead>
	<tbody>
	<?php $total_sale_tax=0; $total=0; foreach ($purchaseReturn->purchase_return_rows as $purchase_return_row): 
		foreach($purchase_return_row->item->item_ledgers as $item_ledger):
	?>
		<tr>
			<td><?= h(++$page_no) ?></td>
			<td><?= $purchase_return_row->item->name; ?></td>
			<td align="center"><?= $purchase_return_row->quantity; ?></td>
			
			<td align="right"><?=  number_format($item_ledger->rate, 2, '.', ',');?></td>
			<td align="right"><?= number_format($purchase_return_row->quantity*$item_ledger->rate, 2, '.', ',');?></td>
		</tr>
		<?php $total=$total+($purchase_return_row->quantity*$item_ledger->rate); endforeach; endforeach; ?>
	</tbody>
	<tfoot>
		
		<?php if($purchaseReturn->invoice_booking->purchase_ledger_account==538 || 
				 $purchaseReturn->invoice_booking->purchase_ledger_account==308 ||
				 $purchaseReturn->invoice_booking->purchase_ledger_account==160){ ?>
		<tr>
			<td colspan="3"></td>
			<td style="font-size:14px;"  align="right"> VAT Amount
				<?php if(empty($LedgerAccount->alias)){ ?>
						: <?php echo $LedgerAccount->name; ?>
					<?php }else{ ?>
						: <?php echo $LedgerAccount->name; ?> (<?php echo $LedgerAccount->alias; ?>)
					<?php } ?>
			</td>
			
		</tr>
		<?php } ?>
		<tr>
			<td colspan="3"></td>
			<td style="font-size:14px; font-weight:bold;"  align="right"> Total</td>
			<td style="font-size:14px; font-weight:bold; "  align="right"><?= 
			number_format($total, 2, '.', ',');
			 ?></td>
		</tr>
	</tfoot>
</table>
<div style="border:solid 1px ;"></div>
<table width="100%" class="divFooter">
	<tr>
		<td style="vertical-align: top !important;">
			<table>
				<tr>
					<td colspan="2"><b>Reference Number:</b></td>
				</tr>
				<?php foreach($ReferenceDetails as $ReferenceDetail){ ?>
				<tr>
					<td><?php echo $ReferenceDetail->reference_no; ?></td>
					<td>:<?php echo $ReferenceDetail->credit; ?></td>
				</tr>
				<?php } ?>
			</table>
		</td>
		<td align="right">
		<table>
			<tr>
				<td align="center">
				<span style="font-size:14px;">For</span> <span style="font-size: 14px;font-weight: bold;"><?= h($purchaseReturn->company->name)?><br/></span>
				<?php 
				 echo $this->Html->Image('/signatures/'.$purchaseReturn->creator->signature,['height'=>'50px','style'=>'height:50px;']); 
				 ?></br>
				<span style="font-size: 14px;font-weight: bold;">Authorised Signatory</span>
				</br>
				<span style="font-size:14px;"><?= h($purchaseReturn->creator->name) ?></span><br/>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>	
<style>
.table thead tr th {
    color: #FFF;
	background-color: #254b73;
}
.padding-right-decrease{
	padding-right: 0;
}
.padding-left-decrease{
	padding-left: 0;
}
</style>
</div>

