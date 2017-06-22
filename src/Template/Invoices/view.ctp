<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">
						Print <i class="fa fa-print"></i>
						</a>
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;font-size: 14px;" class="maindiv">
	<table width="100%" class="divHeader">
		<tr>
			<td width="50%"><?php echo $this->Html->image('/logos/'.$invoice->company->logo, ['width' => '40%']); ?></td>
			<td align="right" width="50%" style="font-size: 12px;">
			<span style="font-size: 16px;"><?= h($invoice->company->name) ?></span><br/>
			<span><?= $this->Text->autoParagraph(h($invoice->company->address)) ?></span>
			<span><?= h($invoice->company->mobile_no) ?></span>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">INVOICE</div>
				<div style="border:solid 2px #0685a8;margin-bottom:15px;margin-top: 5px;"></div>
			</td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td width="50%">
				<table width="100%">
					<tr>
						<td>To,</td>
					</tr>
					<tr>
						<td>
							<span><?= h(($invoice->customer->customer_name)) ?></span><br/>
							<?= $this->Text->autoParagraph(h($invoice->customer_address)); ?>
							<span>TIN No. :<?= h($invoice->customer->tin_no) ?></span><br/>
							<span>PAN No. :<?= h($invoice->customer->pan_no) ?></span>
						</td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Invoice No.</td>
						<td width="20" align="center">:</td>
						<td><?= h(($invoice->in1.'/IN'.str_pad($invoice->id, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4)) ?></td>
					</tr>
					<tr>
						<td>Date</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-M-Y",strtotime($invoice->date))) ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table class="">
		<thead>
		<tr>
			<th><?= __('S No') ?></th>
			<th><?= __('Item') ?></th>
			<th><?= __('Quantity') ?></th>
			<th><?= __('Rate') ?></th>
			<th><?= __('Amount') ?></th>
			<th>P&F</th>
			<th>Sales Tax(%)</th>
			<th>Excise Duty(%)</th>
		</tr>
		</thead>
		<?php $sr=0; foreach ($invoice->invoice_rows as $invoiceRows): $sr++; ?>
		<tr>
			<td valign="top" width="50"><?= h($sr) ?></td>
			<td><?= $this->Text->autoParagraph(h($invoiceRows->description)) ?></td>
			<td><?= h($invoiceRows->quantity) ?></td>
			<td><?= h($invoiceRows->rate) ?></td>
			<td><?= h($invoiceRows->amount) ?></td>
			<td><?= h($invoiceRows->pnf) ?></td>
			<td><?= h($invoiceRows->sales_tax) ?></td>
			<td><?= h($invoiceRows->excise_tax) ?></td>
		</tr>
		<?php endforeach; ?>
		<tfoot>
			<tr>
				<td colspan="7" align="right"><b>Total</b></td>
				<td><?= h($invoice->total) ?></td>
			</tr>
			<tr>
				<td colspan="7" align="right">Total P&F </td>
				<td><?= h($invoice->total_pnf) ?></td>
			</tr>
			<tr>
				<td colspan="7" align="right">Total Sales Order</td>
				<td><?= h($invoice->total_sale_tax) ?></td>
			</tr>
			<tr>
				<td colspan="7" align="right">Total Excise Duty</td>
				<td><?= h($invoice->total_exceise_duty) ?></td>
			</tr>
			<tr>
				<td colspan="7" align="right"><b>Grand Total</b></td>
				<td><?= h($invoice->grand_total) ?></td>
			</tr>
			<tr>
				<td colspan="8"><b>Amount in words: </b> <?php echo $this->NumberWords->convert_number_to_words($invoice->grand_total); ?> </td>
			</tr>
		</tfoot>
	</table>
	<table width="100%" class="divFooter">
		<tr>
			<td></td>
			<td align="right">
				<table>
					<tr>
						<td align="center">
						For <?= h($invoice->company->name) ?><br/><br/><br/><span style="    border-top: solid 1px #585757;">Authorised Signatory</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
		<!--<div style="border:solid 2px #0685a8;margin-bottom:10px;"></div>
		<table width="100%">
			<tr>
				<td width="10%"><?php echo $this->Html->image('/img/qr.png', ['height' => '50px']); ?></td>
				<td>
					<a href="#" class="btn default btn-xs black"><i class="fa fa-phone-square"></i> +91-9638527410 </a><br/>
					<a href="#" class="btn default btn-xs black"><i class="fa fa-phone-square"></i> +91-8527419630 </a>
				</td>
				<td>Key Feature 1 | Key Feature 2 | Key Feature 3 | Key Feature 4 | Key Feature 5</td>
			</tr>
		</table>-->
	</div>
<style>
.padding_tbl td{
	    padding: 0 10px 0 0;
}
.itmtbl th{
	    background-color: #0685a8 !important;
		color: #FFF !important;
}
</style>
<style media="print">
.maindiv{
	width: 100% !important;
}
.itmtbl2 th{
	background-color: #cfcbcb !important;
    color: #000 !important;
}
</style>

