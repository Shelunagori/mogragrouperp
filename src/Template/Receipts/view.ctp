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
			<td width="30%"><?php echo $this->Html->image('/logos/'.$receipt->company->logo, ['width' => '40%']); ?></td>
			<td align="center" width="40%" style="font-size: 12px;"><div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">RECEIPT VOUCHER</div></td>
			<td align="right" width="40%" style="font-size: 12px;">
			<span style="font-size: 14px;"><?= h($receipt->company->name) ?></span>
			<span><?= $this->Text->autoParagraph(h($receipt->company->address)) ?>
			<?= h($receipt->company->mobile_no) ?></span>
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
                        <td><?= h($receipt->BankCash->name) ?></td>
                    </tr>
					<tr>
						<td>Voucher No</td>
						<td width="20" align="center">:</td>
						<td><?= h('#'.str_pad($receipt->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Transaction Date</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($receipt->transaction_date))) ?></td>
					</tr>
					<tr>
						<td>Created On</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($receipt->created_on))) ?></td>
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
		<?php $total_cr=0; $total_dr=0; foreach ($receipt->receipt_rows as $receiptRows): ?>
		<tr>
			<td><?= h($receiptRows->ReceivedFrom->name) ?></td>
			<td align="right"><?= h($this->Number->format($receiptRows->amount,[ 'places' => 2])) ?> <?= h($receiptRows->cr_dr) ?></td>
		</tr>
		<?php if(!empty($ref_bal[$receiptRows->received_from_id])):?>
		<tr >
		
		<td colspan="3" style="border-top:none !important;">
			<table width="100%">
			
			<?php foreach($ref_bal[$receiptRows->received_from_id] as $refbal): ?>
			<tr>
					<td style="width :180px !important;"> <?= h($refbal->reference_type). '-' .h($refbal->reference_no) ?></td>
					
					<td > <?php if($refbal->credit != '0' ){ ?> 
					<?= h($this->Number->format($refbal->credit,[ 'places' => 2])) ?> Cr 
					<?php } elseif( $refbal->debit != '0'){?>
					<?= h($this->Number->format($refbal->debit,[ 'places' => 2])) ?> Dr
					<?php } ?></td>
					</tr>
			<?php endforeach; ?>
			</table>
		</td>
		
		</tr><?php endif; ?>
		<?php if($receiptRows->cr_dr=="Cr"){
			$total_cr=$total_cr+$receiptRows->amount;
		}else{
			$total_dr=$total_dr+$receiptRows->amount;
		}
		$total=$total_cr-$total_dr;
		endforeach; ?>
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
					<tr><td>Rupees<?php echo ucwords($this->NumberWords->convert_number_to_words($total)) ?> Only </td>
					</tr>
					<tr>
						<td>via <?= h($receipt->payment_mode) ?> </td>
					</tr>
				</table>
			</td>
		    <td align="left" valign="top">
				<table style="margin-top:3px;">
					<tr>
					   <td width="15%" align="center"> 
						<?php 
						 echo $this->Html->Image('/signatures/'.$receipt->creator->signature,['height'=>'40px','style'=>'height:40px;']); 
						 ?></br>
						 </hr>
						 <span><b>Prepared By</b></span><br/>
						 <span><?= h($receipt->company->name) ?></span><br/>
						</td>
					</tr>
				</table>
			 </td>
		</tr>
	</table>
</div>
