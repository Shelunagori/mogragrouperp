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
			<td width="30%"><?php echo $this->Html->image('/logos/'.$payment->company->logo, ['width' => '40%']); ?></td>
			<td align="center" width="30%" style="font-size: 12px;"><div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">PAYMENT VOUCHER</div></td>
			<td align="right" width="40%" style="font-size: 12px;">
			<span style="font-size: 14px;"><?= h($payment->company->name) ?></span>
			<span><?= $this->Text->autoParagraph(h($payment->company->address)) ?>
			<?= h($payment->company->mobile_no) ?></span>
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
						<td>Bank/Cash Account</td>
						<td width="20" align="center">:</td>
						<td><?= h($payment->BankCash->name) ?></td>
					</tr>
					<tr>
						<td>Voucher No</td>
						<td width="20" align="center">:</td>
						<td><?= h('#'.str_pad($payment->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Transaction Date</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($payment->transaction_date))) ?></td>
					</tr>
					<tr>
						<td>Created On</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($payment->created_on))) ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br/>
	<table width="100%" class="table" style="font-size:12px">
		<tr>
			<th><?= __('Paid to') ?></th>
			<th><?= __('Amount') ?></th>
			<th><?= __('Narration') ?></th>
		</tr>
		<?php $total_cr=0; $total_dr=0; foreach ($payment->payment_rows as $paymentRows):  ?>
		<tr>
			<td style="white-space: nowrap;"><?= h($paymentRows->ReceivedFrom->name) ?></td>
			<td style="white-space: nowrap;"><?= h($this->Number->format($paymentRows->amount,[ 'places' => 2])) ?> <?= h($paymentRows->cr_dr) ?></td>
			<td><?= h($paymentRows->narration) ?></td>
			
		</tr>
		<?php if(!empty($ref_details[$paymentRows->received_from_id])):?>
		<tr >

		<td colspan="3" style="border-top:none !important;">
			<table width="100%">
			
			<?php foreach($ref_details[$paymentRows->received_from_id] as $refdetail): ?>
			<tr>
					<td style="width :180px !important;"> <?= h($refdetail->reference_type). '-' .h($refdetail->reference_no) ?></td>
					<td>:</td>
					<td > <?php if($refdetail->credit != '0' ){ ?> 
					<?php echo number_format($refdetail->credit,2,',','') ?> Cr 
					<?php } elseif( $refdetail->debit != '0'){?>
					<?php echo number_format($refdetail->debit,2,',','') ?> Dr
					<?php } ?></td>
					</tr>
			<?php endforeach; ?>
			</table>
		</td>
		
		</tr><?php endif; ?>
		<?php if($paymentRows->cr_dr=="Cr"){
			$total_cr=$total_cr+$paymentRows->amount;
		}else{
			$total_dr=$total_dr+$paymentRows->amount;
		}
		$total=$total_dr-$total_cr; endforeach; ?>
	</table>
	
	
	
	<div style="border:solid 1px ;"></div>
	<table width="100%" class="divFooter">
		<tr>
			<td align="left" valign="top">
				<table>
					<tr>
						<td style="font-size: 16px;font-weight: bold;">
						Rs: <?= h($this->Number->format($total,[ 'places' => 2])) ?></td>
					</tr>
					<tr>
						<td style="font-size: 12px;">Rupees<?php echo ucwords($this->NumberWords->convert_number_to_words($total)) ?> Only </td>
					</tr>
					<tr>
						<td style="font-size: 12px;">
						via <?= h($payment->payment_mode) ?> 
						<?php if($payment->payment_mode=="Cheque"){
							echo ' ('.$payment->cheque_no.')';
						} ?>
						</td>
					</tr>
				</table>
			</td>
		    <td align="right" valign="top" width="35%">
				<table style="margin-top:3px;">
					<tr>
					   <td width="15%" align="center"> 
						<?php 
						 echo $this->Html->Image('/signatures/'.$payment->creator->signature,['height'=>'40px','style'=>'height:40px;']); 
						 ?></br>
						 </hr>
						 <span><b>Prepared By</b></span><br/>
						 <span><?= h($payment->company->name) ?></span><br/>
						</td>
					</tr>
				</table>
			 </td>
		</tr>
	</table>
</div>

