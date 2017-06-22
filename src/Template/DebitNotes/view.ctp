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

<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 55%;font-size: 12px;" class="maindiv">	
	<table width="100%" class="divHeader">
		<tr>
			<td width="30%"><?php echo $this->Html->image('/logos/'.$debitNote->company->logo, ['width' => '40%']); ?></td>
			<td align="center" width="40%" style="font-size: 12px;"><div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">DEBIT NOTE</div></td>
			<td align="right" width="40%" style="font-size: 12px;">
			<span style="font-size: 14px;"><?= h($debitNote->company->name) ?></span>
			<span><?= $this->Text->autoParagraph(h($debitNote->company->address)) ?>
			<?= h($debitNote->company->mobile_no) ?></span>
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
			<td width="70%" valign="top" align="left">
				<table>
					<tr>
						<td>Customer/Supplier</td>
						<td width="20" align="center">:</td>
						<td><?= h($debitNote->customer_suppiler->name.'('.$debitNote->customer_suppiler->alias.')') ?></td>
					</tr>
					<tr>
						<td>Voucher No</td>
						<td width="20" align="center">:</td>
						<td><?= h('#'.str_pad($debitNote->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Transaction Date</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($debitNote->transaction_date))) ?></td>
					</tr>
					<tr>
						<td>Created On</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($debitNote->created_on))) ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<br/>
	<table width="100%" class="table" style="font-size:12px">
		<tr>
			<th><?= __('Received From') ?></th>
			<th style="text-align: right;">Amount</th>
		</tr>
		<?php $total_cr=0; $total_dr=0; foreach ($debitNote->debit_notes_rows as $debit_notes_row): ?>
		<tr>
			<td><?= h($debit_notes_row->heads->name) ?></td>
			<td align="right"><?= h($this->Number->format($debit_notes_row->amount,[ 'places' => 2])) ?> </td>
		</tr>
		<?php endforeach; ?>
	</table>
	
	<table width="100%">
		<tr>
			<th>Ref Type</th>
			<th>Ref No</th>
			<th>Debit</th>
		</tr>
		<?php  foreach($ReferenceDetails as $ReferenceDetail){   ?>
		<tr>
			<td width="30%"><?=h($ReferenceDetail->reference_type) ?></td>
			<td><?=h($ReferenceDetail->reference_no) ?></td>
			<td>Rs.<?=h($this->Number->format($ReferenceDetail->debit,[ 'places' => 2])) ?></td>
		</tr>
		<?php  } ?>
	</table>
	</br>
	<div style="border:solid 1px ;"></div>
	<table width="100%" class="divFooter">
		<tr>
		    <td align="right" valign="top">
				<table style="margin-top:3px;">
					<tr>
					   <td width="100%" align="center" style="float: right;"> 
						<?php 
						 echo $this->Html->Image('/signatures/'.$debitNote->creator->signature,['height'=>'40px','style'=>'height:40px;']); 
						 ?></br>
						 </hr>
						 <span><b>Prepared By</b></span><br/>
						 <span><?= h($debitNote->company->name) ?></span><br/>
						</td>
					</tr>
				</table>
			 </td>
		</tr>
	</table>
</div>
