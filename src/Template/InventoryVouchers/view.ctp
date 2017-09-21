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
<?php //pr($inventoryVoucher->inventory_voucher_rows); exit;?>
<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 70%;font-size: 12px;" class="maindiv">
<table width="100%" class="divHeader" border="0">
<tr>
    <td><?php echo $this->Html->image('/logos/'.$inventoryVoucher->company->logo, ['width' => '48%']); ?></td>
    <td align="center" width="30%" style="font-size: 12px;"><div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">INVENTORY VOUCHER</div></td>
	<td align="right" width="40%" style="font-size: 12px;">
			<span style="font-size: 14px;"><?= h($inventoryVoucher->company->name) ?></span>
			<span><?= $this->Text->autoParagraph(h($inventoryVoucher->company->address)) ?></span>
			<span> <i class="fa fa-phone" aria-hidden="true"></i> <?= h($inventoryVoucher->company->landline_no) ?></span> |
			<?= h($inventoryVoucher->company->mobile_no) ?>
			</td>
	
</tr>
</table>
<div style="border:solid 3px #0685a8;margin-bottom:5px;margin-top: 5px;"></div>
</br>
<table width="100%" style="margin-top: -17px;">
	<tr>
		<td width="50%" valign="top" align="left">
			<table>
				<tr>
					<td><b>Inventory Voucher No</b></td>
					<td width="20%" align="center">:</td>
					<td>
					<?= h('IV/'.str_pad($inventoryVoucher->iv_number, 4, '0', STR_PAD_LEFT)) ?>
					</td>
				</tr>
				<tr>
					<td><b>Invoice No</b></td>
						<td width="20%" align="center">:</td>
						<td><?= h($inventoryVoucher->invoice->in1.'/IN'.str_pad($inventoryVoucher->invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$inventoryVoucher->invoice->in3.'/'.$inventoryVoucher->invoice->in4) ?>
					</td>
				</tr>
			</table>
	   </td>
	   
	   <td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td><b>Transaction Date</b></td>
						<td width="20%" align="center">:</td>
						<td><?php  if(!empty($inventoryVoucher->transaction_date)){ echo date("d-m-Y",strtotime($inventoryVoucher->transaction_date));}else{echo '-';} ?></td>
					</tr>
					<tr>
						<td><b>Created On</b></td>
						<td width="20%" align="center">:</td>
						<td><?php  if(!empty($inventoryVoucher->created_on)){ echo date("d-m-Y",strtotime($inventoryVoucher->created_on));}else{echo '-';} ?></td>
					</tr>
				</table>
			</td>
	</tr>
	
</table>
<table>
<tr>
		<td width="50%" valign="top" align="left" >
			<table width="100%">
				<tr>
					<td width="20%"><b>Customer Name</b></td>
					<td width="5%">:</td>
					<td width="72%"><?php echo $inventoryVoucher->invoice->customer->customer_name ."(". $inventoryVoucher->invoice->customer->alias.")"; ?></td>
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
		<?php $status=0;
					foreach($inventoryVoucher->inventory_voucher_rows as $inventory_voucher_row ){
						if( $inventory_voucher_row->item->item_companies[0]->serial_number_enable == 1) {
						$status=1;
						}
					}
					?>
			<table width="97%" align="center">
				<tr>
					<td width="7%">Item</td>
					<?php if($status==1) { ?>
					<th width="10%">Item Serial No</th>
					<?php } ?>
					<td width="1%">Quantity</td>
				</tr>
			</table>
		</th>
	</thead>
	
	<tbody>
		<?php foreach ($inventoryVoucher->invoice->invoice_rows as $invoice_row): 
       if($invoice_row->inventory_voucher_applicable=="Yes"){
       ?>
		<tr>
			<td valign="top">
			<b><?= $invoice_row->item->name ?> ( <?= h($invoice_row->quantity) ?> )</b>
			</td>
			<td>
				<table width="100%">
					<?php foreach($inventoryVoucher->inventory_voucher_rows as $inventory_voucher_row): ?> 
					<?php if($inventory_voucher_row->left_item_id == $invoice_row->item->id){ ?>
					<tr>
						<td width="30%"><?= $inventory_voucher_row->item->name?></td>
						<?php if($status==1) {  if(!empty($inventory_voucher_row->item->item_companies[0]->serial_number_enable)){
							if($inventory_voucher_row->item->item_companies[0]->serial_number_enable == 1) { ?>
							<td width="50%"><table>
							<?php foreach ($inventory_voucher_row->item->item_serial_numbers as  $item_serial_number){ 
							if($item_serial_number->iv_invoice_id == $inventory_voucher_row->invoice_id){ ?>
							<tr>
								<td ><?php echo $item_serial_number->serial_no ?></td>
							</tr>
							<?php }} ?>
							</table>
							</td>
							<?php }}else{  ?>
							<td><table>
							<?php foreach ($inventory_voucher_row->item->item_serial_numbers as  $item_serial_number){ 
							if($item_serial_number->in_inventory_voucher_id == $inventory_voucher_row->inventory_voucher_id){ ?>
							<tr>
								<td>-</td>
							</tr>
							<?php }} ?>
							</table>
							</td>
							<?php }} ?>

						<td width="8%" ><?= $inventory_voucher_row->quantity?></td>
					</tr>
					<?php } endforeach; ?>
				</table>
			</td>
		</tr>
		<?php } endforeach; ?>
	</tbody>
	
</table>
</br>

</div>
<?php } ?>
<div style="border:solid 1px ;"></div>
	

<table width="96%">
	<tr>
	    <td align="left">
			<table  class="divFooter" >
				<tr>
					<td valign="top" align="left" width="10%"><b>Narration</b></td>
					<td  width="2%" align="center">:</td>
					<td>
					<?= h($inventoryVoucher->narration) ?>
					</td>
				</tr>
			</table></br></br></br>
		</td>
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

 
 