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

<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 65%;font-size: 12px;" class="maindiv">	

<table width="100%" class="divHeader">
	<tr>
			<td width="30%"><?php echo $this->Html->image('/logos/'.$journalVoucher->company->logo, ['width' => '40%']); ?></td>
			<td align="center" width="40%" style="font-size: 12px;"><div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">JOURNAL VOUCHER</div></td>
			<td align="right" width="40%" style="font-size: 12px;">
			<span style="font-size: 14px;"><?= h($journalVoucher->company->name) ?></span>
			<span><?= $this->Text->autoParagraph(h($journalVoucher->company->address)) ?>
			<?= h($journalVoucher->company->mobile_no) ?></span>
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
						<td><?= h('#'.str_pad($journalVoucher->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Transaction Date</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($journalVoucher->transaction_date))) ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td width="50%" valign="top" align="right"></td>
			<td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td>Created On</td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($journalVoucher->created_on))) ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br/>
	
	<div style="height:3px;" class="hdrmargin"></div>
	<table width="100%" class="table" style="font-size:12px">
		
			<tr>
				<th><?= __('Ledger A/C') ?></th>
				<th><?= __('Narration') ?></th>
				<th><?= __('Dr') ?></th>
				<th><?= __('Cr') ?></th>
			</tr>
		
		
			<?php $sr=0; $dr=0; $cr=0; foreach ($journalVoucher->journal_voucher_rows as $journal_voucher_row): $sr++; ?>
			<tr>
				<td><?= h($journal_voucher_row->ReceivedFrom->name) ?></td>
				<td><?=$this->Text->autoParagraph(h($journal_voucher_row->narration)) ?></td>
				<td>
				<?php if($journal_voucher_row->cr_dr=="Dr")
					{ 
					
					$dr=$dr+$journal_voucher_row->amount;
					echo $this->Number->format($journal_voucher_row->amount,[ 'places' => 2]) ;
					}else{ echo "-";} ?>
				</td>
				<td>
				<?php if($journal_voucher_row->cr_dr=="Cr")
					{
					
					$cr=$cr+$journal_voucher_row->amount;
					echo $this->Number->format($journal_voucher_row->amount,[ 'places' => 2]);
					}else{ echo "-";} ?>
				</td>
			</tr>
			
			<?php if(!empty($ref_bal[$journal_voucher_row->received_from_id])):?>
			<tr>
			<td colspan="3" style="border-top:none !important;">
			<table width="100%">
			
			<?php foreach($ref_bal[$journal_voucher_row->received_from_id] as $refbal): ?>
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
<?php endforeach ?>
			
			
			
			<tr>
			<td></td>
			<td align="right"><b>Total</b></td>
			
			<td > <?php echo number_format($dr,2,'.',',');?></td>
			<td > <?php echo number_format($cr,2,'.',',');?></td>
			</tr>
		
	</table>
	
	<div style="border:solid 1px ;"></div>
	<table width="100%" class="divFooter">
		<tr>
			<td></td>
			<td align="right" valign="top" width="35%">
				<table style="margin-top:3px;">
					<tr>
						<td width="15%" align="center">
						For <?= h($journalVoucher->company->name) ?>
							<br/>
					 <?php 
		             echo $this->Html->Image('/signatures/'.$journalVoucher->creator->signature,['height'=>'50px','style'=>'height:50px;']); 
		             ?></br>		
							
						Authorised Signatory</span>
						
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>	
</div>
</div>
