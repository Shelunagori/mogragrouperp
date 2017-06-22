<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">
						Print <i class="fa fa-print"></i>
						</a>
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 85%;font-size: 14px;" class="maindiv">
	<table width="100%" class="divHeader">
		<tr>
			<td width="50%"><?php echo $this->Html->image('/logos/'.$salesOrder->company->logo, ['width' => '40%']); ?></td>
			<td align="right" width="50%" style="font-size: 12px;">
			<span style="font-size: 16px;"><?= h($salesOrder->company->name) ?></span><br/>
			<span><?= $this->Text->autoParagraph(h($salesOrder->company->address)) ?></span>
			<span><?= h($salesOrder->company->mobile_no) ?></span>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">SALES ORDER</div>
				<div style="border:solid 2px #0685a8;margin-bottom:15px;margin-top: 5px;"></div>
			</td>
		</tr>
	</table>
	<div style="height:110px;" class="hdrmargin"></div>
	<table width="100%">
		<tr>
			<td width="50%">
				<table width="100%">
					<tr>
						<td>To,</td>
					</tr>
					<tr>
						<td>
							<span><?= h(($salesOrder->customer->customer_name)) ?></span><br/>
							<?= $this->Text->autoParagraph(h($salesOrder->customer_address)); ?>
							<span>TIN No. :<?= h($salesOrder->customer->tin_no) ?></span><br/>
							<span>PAN No. :<?= h($salesOrder->customer->pan_no) ?></span>
						</td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Sales Order No.</td>
						<td width="20" align="center">:</td>
						<td><?= h(($salesOrder->so1.'/SO'.str_pad($salesOrder->id, 3, '0', STR_PAD_LEFT).'/'.$salesOrder->so3.'/'.$salesOrder->so4)) ?></td>
					</tr>
					<tr>
						<td>Date</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-M-Y",strtotime($salesOrder->date))) ?></td>
					</tr>
					<tr>
						<td>Carrier</td>
						<td width="20" align="center">:</td>
						<td><?= h($salesOrder->transporter->transporter_name) ?></td>
					</tr>
					<tr>
						<td>LR No.</td>
						<td width="20" align="center">:</td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br/>
	<p>Your P.O. No. <?= h($salesOrder->customer_po_no) ?> dated <?= h(date("d-M-Y",strtotime($salesOrder->po_date))) ?> </p>
	<table class="table table-bordered table-advance itmtbl itmtbl2">
		<thead>
		<tr>
			<th><?= __('S No') ?></th>
			<th><?= __('Item') ?></th>
			<th><?= __('Quantity') ?></th>
			<th><?= __('Rate') ?></th>
			<th><?= __('Amount') ?></th>
			<th><?= __('P&F') ?></th>
			<th><?= __('Sales Tax(%)') ?></th>
			<th><?= __('Excise Duty(%)') ?></th>
		</tr>
		</thead>
		<?php $sr=0; foreach ($salesOrder->sales_order_rows as $salesOrderRows): $sr++; ?>
		<tr>
			<td rowspan="2" valign="top" width="50"><?= h($sr) ?></td>
			<td><?= h($salesOrderRows->item->name) ?></td>
			<td><?= h($salesOrderRows->quantity) ?></td>
			<td><?= h($salesOrderRows->rate) ?></td>
			<td><?= h($salesOrderRows->amount) ?></td>
			<td><?= h($salesOrderRows->pnf) ?></td>
			<td><?= h($salesOrderRows->sales_tax) ?></td>
			<td><?= h($salesOrderRows->excise_tax) ?></td>
		</tr>
		<tr>
			<td colspan="7"><b>Description: </b><?= $this->Text->autoParagraph(h($salesOrderRows->description)) ?></td>
		</tr>
		
		<?php endforeach; ?>
		<tfoot>
			<tr>
				<td colspan="7" align="right">Total</td>
				<td><?= h($salesOrder->total) ?></td>
			</tr>
			<tr>
				<td colspan="7" align="right">Total P&F </td>
				<td><?= h($salesOrder->total_pnf) ?></td>
			</tr>
			<tr>
				<td colspan="7" align="right">Total Sales Order</td>
				<td><?= h($salesOrder->total_sale_tax) ?></td>
			</tr>
			<tr>
				<td colspan="7" align="right">Total Excise Duty</td>
				<td><?= h($salesOrder->total_exceise_duty) ?></td>
			</tr>
			<tr>
				<td colspan="7" align="right"><b>Grand Total</b></td>
				<td><?= h($salesOrder->grand_total) ?></td>
			</tr>
			<tr>
				<td colspan="8"><b>Amount in words: </b> <?php echo $this->NumberWords->convert_number_to_words($salesOrder->grand_total); ?> </td>
			</tr>
			<tr>
				<td colspan="8"><b>Documents: </b> <?= h($salesOrder->documents_courier) ?> </td>
			</tr>
		</tfoot>
	</table>
	<br/>
	
	<table>
		<tr>
			<td>
			<div>
				<b>Commercial Terms & Conditions:</b>
				<?= $this->Text->autoParagraph(h($salesOrder->terms_conditions)); ?>
			</div>
			</td>
		</tr>
	</table>
	<table width="100%" class="divFooter">
		<tr>
			<td></td>
			<td align="right">
				<table>
					<tr>
						<td align="center">
						For <?= h($salesOrder->company->name) ?><br/><br/><br/><span style="    border-top: solid 1px #585757;">Authorised Signatory</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
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

<style type="text/css">
    @media print {
        table.divFooter {
            position: fixed;
            bottom: 0;
        }
    }
	
    @media print {
        table.divHeader {
            position: fixed;
			
			width:100%;
            top: 10;
			left: 0;
			right: 0;
        }
    }
    @media screen {
        div.hdrmargin {
            display: none;
        }
    }
    @media print {
        div.hdrmargin {
            display: block;
        }
    }
	
</style>