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
            <td width="30%"><?php echo $this->Html->image('/logos/'.$pettycashvoucher->company->logo, ['width' => '40%']); ?></td>
            <td align="center" width="30%" style="font-size: 12px;"><div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">PETTY CASH VOUCHER</div></td>
            <td align="right" width="40%" style="font-size: 12px;">
            <span style="font-size: 14px;"><?= h($pettycashvoucher->company->name) ?></span>
            <span><?= $this->Text->autoParagraph(h($pettycashvoucher->company->address)) ?>
            <?= h($pettycashvoucher->company->mobile_no) ?></span>
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
                        <td><?= h($pettycashvoucher->BankCash->name) ?></td>
                    </tr>
                    <tr>
                        <td>Voucher No</td>
                        <td width="20" align="center">:</td>
                        <td><?= h('#'.str_pad($pettycashvoucher->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
                    </tr>
                </table>
            </td>
            <td width="50%" valign="top" align="right">
                <table>
                    <tr>
                        <td>Transaction Date</td>
                        <td width="20" align="center">:</td>
                        <td><?= h(date("d-m-Y",strtotime($pettycashvoucher->transaction_date))) ?></td>
                    </tr>
					<tr>
						<td>Created On </td>
						<td width="20" align="center">:</td>
						<td><?= h(date("d-m-Y",strtotime($pettycashvoucher->created_on))) ?></td>
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
        <?php $total_cr=0; $total_dr=0; 
         foreach($pettycashvoucher->petty_cash_voucher_rows as $petty_cash_voucher_row): ?>
        <tr>
            <td style="white-space: nowrap;"><?= h($petty_cash_voucher_row->ReceivedFrom->name) ?></td>
            <td style="white-space: nowrap;"><?= h($this->Number->format($petty_cash_voucher_row->amount,[ 'places' => 2])) ?> <?= h($petty_cash_voucher_row->cr_dr) ?></td>
            <td><?= h($petty_cash_voucher_row->narration) ?></td>
        </tr>
		<?php if(!empty($ref_bal[$petty_cash_voucher_row->received_from_id])):?>
		<tr >
		
		<td colspan="3" style="border-top:none !important;">
			<table width="100%">
			
			<?php foreach($ref_bal[$petty_cash_voucher_row->received_from_id] as $refbal): ?>
			<tr>
					<td style="width :180px !important;"> <?= h($refbal->reference_type). '-' .h($refbal->reference_no) ?></td>
					
					<td > <?php if($refbal->credit != '0' ){ ?> 
					<?= h($refbal->credit) ?> Cr 
					<?php } elseif( $refbal->debit != '0'){?>
					<?= h($refbal->debit) ?> Dr
					<?php } ?></td>
					</tr>
			<?php endforeach; ?>
			</table>
		</td>
		
		</tr><?php endif; ?>
        <?php if($petty_cash_voucher_row->cr_dr=="Cr"){
            $total_cr=$total_cr+$petty_cash_voucher_row->amount;
        }else{
            $total_dr=$total_dr+$petty_cash_voucher_row->amount;
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
                        via <?= h($pettycashvoucher->payment_mode) ?> 
                        <?php if($pettycashvoucher->payment_mode=="Cheque"){
                            echo ' ('.$pettycashvoucher->cheque_no.')';
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
                         echo $this->Html->Image('/signatures/'.$pettycashvoucher->creator->signature,['height'=>'40px','style'=>'height:40px;']); 
                         ?></br>
                         </hr>
                         <span><b>Prepared By</b></span><br/>
                         <span><?= h($pettycashvoucher->company->name) ?></span><br/>
                        </td>
                    </tr>
                </table>
             </td>
        </tr>
    </table>
</div>

