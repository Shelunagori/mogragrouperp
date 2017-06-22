<style>
@media print{
.maindiv{
width:100% !important;
}	
	
}
</style>
<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>

<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 55%;font-size: 14px;" class="maindiv">	
<table width="100%" class="divHeader">
		<tr>
			<td width="30%"><?php echo $this->Html->image('/logos/'.$receiptVoucher->company->logo, ['width' => '40%']); ?></td>
			<td align="center" width="40%" style="font-size: 12px;"><div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">RECEIPT VOUCHER</div></td>
			<td align="right" width="30%" style="font-size: 12px;">
			<span style="font-size: 14px;"><?= h($receiptVoucher->company->name) ?></span>
			<span><?= $this->Text->autoParagraph(h($receiptVoucher->company->address)) ?>
			<?= h($receiptVoucher->company->mobile_no) ?></span>
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
						<td>Voucher No</td>
						<td width="20" align="center">:</td>
						<td><?= h('#'.str_pad($receiptVoucher->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Date.</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($receiptVoucher->transaction_date))) ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<div style="height:3px;" class="hdrmargin"></div>
	<table class="table-advance itmtbl ">
		<tfoot>
			
			<tr>
				<td>Recieved with thanks from
				<b><?= h($receiptVoucher->ReceivedFrom->name) ?></b></td>
			</tr>
			
		</tfoot>
	</table>
	
	
	<table width="100%">
		<?php  foreach($ReferenceDetails as $ReferenceDetail){   ?>
		<tr>
			<td width="30%"><?=h($ReferenceDetail->reference_type) ?></td>
			<td><?=h($ReferenceDetail->reference_no) ?></td>
			<td>Rs.<?=h($ReferenceDetail->debit) ?></td>
		</tr>
		<?php  } ?>
	</table>
	<div style="border:solid 1px ;"></div>
	<table width="100%" class="divFooter">
		<tr>
			<td align="left" valign="top">
				<table>
					<tr>
						<td style="font-size: 16px;font-weight: bold;">
						Rs: <?=h($receiptVoucher->amount) ?></td>
					</tr>
					<tr><td>Rupees<?php echo ucwords($this->NumberWords->convert_number_to_words($receiptVoucher->amount)) ?> Only </td>
					</tr>
					<tr>
						<td>via <?= h($receiptVoucher->payment_mode) ?> </td>
					</tr>
					<tr>
						<td><?= $this->Text->autoParagraph(h($receiptVoucher->narration)) ?> </td>
					</tr>
				</table>
			</td>
		    <td align="left" valign="top">
				<table>
					<tr>
	
					   <td align="right" width="15%"> 
						<?php 
						 echo $this->Html->Image('/signatures/'.$receiptVoucher->creator->signature,['height'=>'50px','style'=>'height:50px;']); 
						 ?></br>
						 </hr>
						 <span><b>Prepared By</b></span><br/>
						 <span><?= h($receiptVoucher->company->name) ?></span><br/>
						</td>
					</tr>
				</table>
			 </td>
		</tr>
	</table>
	<br/>

	
</div>
</br>
