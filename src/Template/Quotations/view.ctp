
<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 85%;font-size: 14px;" class="maindiv">
	<table width="100%">
		<tr>
			<td width="50%"><?php echo $this->Html->image('/logos/'.$quotation->company->logo, ['width' => '40%']); ?></td>
			<td align="right" width="50%" style="font-size: 12px;">
			<span style="font-size: 16px;"><?= h($quotation->company->name) ?></span><br/>
			<span><?= $this->Text->autoParagraph(h($quotation->company->address)) ?></span>
			<span><?= h($quotation->company->mobile_no) ?></span>
			</td>
		</tr>
	</table>
	<div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;margin-top: 5px;">QUOTATION</div>
	<div style="border:solid 2px #0685a8;margin-bottom:15px;"></div>
	<table width="100%">
		<tr>
			<td style="">
				<table width="100%">
					<tr>
						<td>To,</td>
					</tr>
					<tr>
						<td>
							<span><?= h(($quotation->customer->customer_name)) ?></span><br/>
							<?= $this->Text->autoParagraph(h($quotation->customer_address)); ?>
							<span>TIN No. :<?= h($quotation->customer->tin_no) ?></span><br/>
							<span>PAN No. :<?= h($quotation->customer->pan_no) ?></span>
						</td>
					</tr>
					<tr>
						<td>
							<table class="padding_tbl">
								<tr>
									<td>Kind attention:</td>
									<td><?= h(($quotation->customer_for_attention)) ?> (<?= h($quotation->customer_contact) ?>)</td>
								</tr>
								<tr>
									<td>Reference:</td>
									<td><?= h($quotation->enquiry_no) ?></td>
								</tr>
								<tr>
									<td>Subject:</td>
									<td><?= h(($quotation->subject)) ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td align="right" valign="top">
				<table class="padding_tbl">
					<tr>
						<td>Date</td>
						<td><?= h(date("d-M-Y",strtotime($quotation->date))) ?></td>
					</tr>
					<tr>
						<td>Ref no:</td>
						<td><?= h(($quotation->ref_no)) ?></td>
					</tr>
					<tr class="hide_at_print">
						<td>Salesman:</td>
						<td><?= h(($quotation->employee->name)) ?></td>
					</tr>
					<tr class="hide_at_print">
						<td>Product:</td>
						<td><?= h(strtoupper($quotation->item_category->name)) ?></td>
					</tr>
					<tr class="hide_at_print">
						<td>Finalisation Date:</td>
						<td><?= h(date("d-M-Y",strtotime($quotation->finalisation_date))) ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br/>
	<table width="100%">
		<tr>
			<td width="7%">Dear Sir,</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><?= $this->Text->autoParagraph(h($quotation->text)); ?></td>
		</tr>
	</table>
	<table class="table table-bordered table-advance itmtbl itmtbl2">
		<thead>
		<tr>
			<th><?= __('Sr. No.') ?></th>
			<th><?= __('Item') ?></th>
			<th><?= __('Quantity') ?></th>
			<th><?= __('Rate') ?></th>
			<th><?= __('Amount') ?></th>
		</tr>
		</thead>
		<?php $sr=0; foreach ($quotation->quotation_rows as $quotationRows): $sr++; ?>
		<tr>
			<td rowspan="2"><?= h($sr) ?></td>
			<td><?= h($quotationRows->item->name) ?></td>
			<td><?= h($quotationRows->quantity) ?></td>
			<td><?= h($quotationRows->rate) ?></td>
			<td><?= h($quotationRows->amount) ?></td>
		</tr>
		<tr>
			<td colspan="3"><b>Description:</b> <?= $this->Text->autoParagraph(h($quotationRows->description)) ?></td>
			<td></td>
		</tr>
		<?php endforeach; ?>
		<tfoot>
			<tr>
				<td colspan="4" align="right"><b>Total</b></td>
				<td><?= h($quotation->total) ?></td>
			</tr>
		</tfoot>
	</table>
	<br/>
	<div>
		<b>Commercial Terms & Conditions:</b>
		<?= $this->Text->autoParagraph(h($quotation->terms_conditions)); ?>
	</div>
	<br/>
	<div><b>I hope above is to your requirement and in case of any clarification kindly revert back.</b></div>
	<br/>
	<div><b>Thanks and Regards</b><br/>
	<span><?= h(($quotation->employee->name)) ?></span><br/>
	<span><?= h(($quotation->employee->mobile)) ?></span><br/>
	<span><?= h(($quotation->employee->email)) ?></span>
	</div>
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