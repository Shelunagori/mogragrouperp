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
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 70%;font-size: 12px;" class="maindiv">
<table width="100%" class="divHeader">
		<tr>
			<td width="30%"><?php echo $this->Html->image('/logos/'.$inventoryTransferVoucher->company->logo, ['width' => '40%']); ?></td>
			<td align="center" width="40%" style="font-size: 12px;"><div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">INVENTORY TRANSFER VOUCHER OUT</div></td>
			<td align="right" width="30%" style="font-size: 12px;">
			<span style="font-size: 14px;"><?= h($inventoryTransferVoucher->company->name) ?></span>
			<span><?= $this->Text->autoParagraph(h($inventoryTransferVoucher->company->address)) ?>
			<?= h($inventoryTransferVoucher->company->mobile_no) ?></span>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<div style="border:solid 2px #0685a8;margin-bottom:5px;margin-top: 5px;"></div>
			</td>
		</tr>
	</table>
</br>
<table width="100%">
	<tr>
		<td  valign="top" align="left">
			<table border="0">
				<tr>
					<td align="left" width=" "<label style="font-size: 14px;font-weight: bold;">Inventory Transfer Voucher No</label></td>
					<td>:</td>
					<td><?= h('#'.str_pad($inventoryTransferVoucher->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
					<td align="left"></td>
					<td></td>
				</tr>
			</table>
	   </td>
	</tr>
</table>	
</br>
<?php if(!empty($inventoryTransferVoucher)){ ?>
<div class="portlet-body form">
<table class="table table-bordered table-condensed">
	<thead> 
		<th width="10%">Sr.No.</th>
		<th width="60%">Item</th>
		<th>Quantity</th>
	</thead>
	<tbody>
		<?php  $i=1; foreach($inventoryTransferVoucher->inventory_transfer_voucher_rows as $out_item){ ?>
			<tr>
				<td valign="top"><?php echo $i; ?></td>
				<td valign="top"><?php echo $out_item->item->name ?></td>
				<td valign="top"><?php echo $out_item->quantity ?></td>
			</tr>
		<?php $i++; } ?>
		
	</tbody>
</table>
</br>
<table width="96%">
	<tr>
		<td align="right">
		<table >
			<tr>
			    <td align="center">
				<span style="font-size:14px;">For</span> <span style="font-size: 14px;font-weight: bold;"><?= h($inventoryTransferVoucher->company->name)?><br/></span>
				<?php 
				 echo $this->Html->Image('/signatures/'.$inventoryTransferVoucher->creator->signature,['height'=>'50px','style'=>'height:50px;']); 
				 ?></br>
				<span style="font-size: 14px;font-weight: bold;">Authorised Signatory</span>
				</br>
				<span style="font-size:14px;"><?= h($inventoryTransferVoucher->creator->name) ?></span><br/>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</div>
<?php } ?>
	
<table width="100%" class="divFooter">
	<tr>
		<td align="right">
	
		</td>
	</tr>
</table>	
</div>

 
 