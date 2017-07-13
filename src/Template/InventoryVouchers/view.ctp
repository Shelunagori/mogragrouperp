<?php //pr($inventoryVoucher->inventory_voucher_rows); exit;?>
<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 70%;font-size: 12px;" class="maindiv">
<table width="100%" class="divHeader" border="0">
<tr>
    <td><?php echo $this->Html->image('/logos/'.$inventoryVoucher->company->logo, ['width' => '48%']); ?></td>
    <td valign="bottom" width="35%" align="center" style="font-size:23px;font-weight: bold;color: #0685a8;">INVENTORY VOUCHER</td>
	<td align="right" style="font-size: 14px;" width="36%"> 
 
	<span style="font-size: 20px;"><?= h($inventoryVoucher->company->name) ?></span><br/>
	<span style="font-size: 15px;"><?= $this->Text->autoParagraph(h($inventoryVoucher->company->address)) ?></span>
	<span><?= h($inventoryVoucher->company->landline_no) ?></span><br/>
	<span><?= h($inventoryVoucher->company->mobile_no) ?></span>
	</td>
</tr>
</table>
<div style="border:solid 3px #0685a8;margin-bottom:5px;margin-top: 5px;"></div>
</br>
<table width="100%">
	<tr>
		<td  valign="top" align="left">
			<table border="0" width='100%'>
				<tr>
					<td align="left" width=" "<label style="font-size: 14px;font-weight: bold;">Inventory Voucher No</label></td>
					<td>:</td>
					<td align="center">
					<?= h('IV/'.str_pad($inventoryVoucher->iv_number, 4, '0', STR_PAD_LEFT)) ?>
					</td>
					<td align="left"></td>
					<td width="10%"></td>
					
					<td align="center" width=" "<label style="font-size: 14px;font-weight: bold;">Invoice No</label></td>
					<td>:</td>
					<td align="center">
					<?= h($inventoryVoucher->invoice->in1.'/IN'.str_pad($inventoryVoucher->invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$inventoryVoucher->invoice->in3.'/'.$inventoryVoucher->invoice->in4) ?>
					</td>
					<td align="center"></td>
					<td width="10%"></td>
					<td align="left"></td>
					<td></td>
				</tr>
			</table>
	   </td>
	</tr>
</table>	
</br>
<?php if(!empty($inventoryVoucher)){ ?>
<div class="portlet-body form">
<table class="table table-bordered table-condensed">
	<thead> 
		<th width="30%"></th>
		<th>
			<table width="97%" align="center">
				<tr>
					<td>Item</td>
					<td width="5%">Quantity</td>
				</tr>
			</table>
		</th>
	</thead>
	
	<tbody>
		<?php foreach ($inventoryVoucher->invoice->invoice_rows as $invoice_row): ?>
		<tr>
			<td valign="top">
			<b><?= $invoice_row->item->name ?> ( <?= h($invoice_row->quantity) ?> )</b>
			</td>
			<td>
				<table width="100%">
					<?php foreach($inventoryVoucher->inventory_voucher_rows as $inventory_voucher_row): ?> 
					<?php if($inventory_voucher_row->left_item_id == $invoice_row->item->id){ ?>
					<tr>
						<td><?= $inventory_voucher_row->item->name?></td>
						<td width="5%"><?= $inventory_voucher_row->quantity?></td>
					</tr>
					<?php } endforeach; ?>
				</table>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>
</br>

</div>
<?php } ?>
	
<table width="100%" class="divFooter">
	<tr>
		<td align="left" width="10%"><label style="font-size: 14px;font-weight: bold;">Narration</label></td>
		<td  width="2%">:</td>
		<td>
		<?= h($inventoryVoucher->narration) ?>
		</td>
	</tr>
</table>	

<table width="96%">
	<tr>
		<td align="right">
		<table >
			<tr>
			    <td align="center">
				<span style="font-size:14px;">For</span> <span style="font-size: 14px;font-weight: bold;"><?= h($inventoryVoucher->company->name)?><br/></span>
				<?php 
				 echo $this->Html->Image('/signatures/'.$inventoryVoucher->creator->signature,['height'=>'50px','style'=>'height:50px;']); 
				 ?></br>
				<span style="font-size: 14px;font-weight: bold;">Authorised Signatory</span>
				</br>
				<span style="font-size:14px;"><?= h($inventoryVoucher->creator->name) ?></span><br/>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</div>

 
 