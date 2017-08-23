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
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 100%;font-size: 12px;" class="maindiv">
<table width="100%" class="divHeader">
		<tr>
			<td width="30%"><?php echo $this->Html->image('/logos/'.$inventoryTransferVoucher->company->logo, ['width' => '40%']); ?></td>
			<td align="center" width="30%" style="font-size: 12px;"><div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">INVENTORY TRANSFER VOUCHER</div></td>
			<td align="right" width="40%" style="font-size: 12px;">
			<span style="font-size: 14px;"><?= h($inventoryTransferVoucher->company->name) ?></span>
			<span><?= $this->Text->autoParagraph(h($inventoryTransferVoucher->company->address)) ?></span>
			<span> <i class="fa fa-phone" aria-hidden="true"></i> <?= h($inventoryTransferVoucher->company->landline_no) ?></span> |
			<?= h($inventoryTransferVoucher->company->mobile_no) ?>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<div style="border:solid 2px #0685a8;margin-bottom:5px;margin-top: 5px;"></div>
			</td>
		</tr>
	</table>

</br>
<table width="100%" style="margin-top: -18px;">
	<tr>
		<td  valign="top" align="left">
			<table border="0">
				<tr>
					<td align="left"><b>Inventory Transfer Voucher No</b></td>
					<td width="20" align="center">:</td>
					<td><?= h('#'.str_pad($inventoryTransferVoucher->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
				</tr>
				
			</table>
	   </td>
	    <td width="50%" valign="top" align="right">
				<table>
					<tr>
						<td><b>Transaction Date</b></td>
						<td width="20" align="center">:</td>
						<td><?php  if(!empty($inventoryTransferVoucher->transaction_date)){ echo date("d-m-Y",strtotime($inventoryTransferVoucher->transaction_date));}else{echo '-';} ?></td>
					</tr>
					 <tr>
						<td><b>Created On</b></td>
						<td width="20" align="center">:</td>
						<td><?php  if(!empty($inventoryTransferVoucher->created_on)){ echo  date("d-m-Y",strtotime($inventoryTransferVoucher->created_on));}else{echo '-';} ?></td>
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
		<th width="50%">Out Item</th>
		<th>In Item</th>
	</thead>
	<tbody>
		<tr >
			<td valign="top">
				<table class="table table-bordered table-condensed">
					<thead> 
					<?php $status=0;
					foreach($inventoryTransferVoucher->inventory_transfer_voucher_rows as $inventory_transfer_voucher_row ){
						if($inventory_transfer_voucher_row->status == 'out' && $inventory_transfer_voucher_row->item->item_companies[0]->serial_number_enable == 1) {
						$status=1;
						}
					}
					?>
						<th width="20%">Sr. No.</th>
						<th>Item</th>
						<?php if($status==1) { ?>
							<th>Item Serial No</th>
						<?php } ?>
						<th>Quantity</th>
						<th>Rate</th>
					</thead>
					<tbody>
						<?php $i=1; foreach($out_item as $out_item){ ?>
						<tr>
							<td valign="top"><?php echo $i; ?></td>
							<td valign="top"><?php echo $out_item->item->name ?></td>
							<?php if($status==1) {  if(!empty($out_item->item->item_companies[0]->serial_number_enable)){
							if($out_item->item->item_companies[0]->serial_number_enable == 1) { ?>
							<td><table>
							<?php foreach ($out_item->item->item_serial_numbers as  $item_serial_number){ 
							if($item_serial_number->inventory_transfer_voucher_id == $out_item->inventory_transfer_voucher_id){ ?>
							<tr>
								<td><?php echo $item_serial_number->serial_no ?></td>
							</tr>
							<?php }} ?>
							</table>
							</td>
							<?php }}else{  ?>
							<td><table>
							<?php foreach ($out_item->item->item_serial_numbers as  $item_serial_number){ 
							if($item_serial_number->inventory_transfer_voucher_id == $out_item->inventory_transfer_voucher_id){ ?>
							<tr>
								<td><?php echo "-"; ?></td>
							</tr>
							<?php }} ?>
							</table>
							</td>
							<?php }} ?>
							<td valign="top"><?php echo $out_item->quantity ?></td>
							<td><?= h($this->Number->format($out_item->amount,['places'=>2])) ?></td>
						</tr>
						<?php $i++; } ?>
					</tbody>
				</table>
			</td>
			
			<td valign="top">
				<table class="table table-bordered table-condensed">
					<thead> 
					<?php $status_in=0;
						foreach($inventoryTransferVoucher->inventory_transfer_voucher_rows as $inventory_transfer_voucher_rows_in ){
							
							if($inventory_transfer_voucher_rows_in->status == 'in' &&$inventory_transfer_voucher_rows_in->item->item_companies[0]->serial_number_enable == 1 ) {
								$status_in=1;
								}
						} ?>
						<th width="20%">Sr. No.</th>
						<th>Item</th>
						<?php if($status_in == 1) { ?>
							<th>Item Serial No</th>
						<?php } ?>
						<th>Quantity</th>
						<th>rate</th>
					</thead>
					<tbody>
						<?php $j=1; foreach($in_item as $in_item){  ?>
						<tr >
							<td valign="top"><?php echo $j; ?></td>
							<td valign="top"><?php echo $in_item->item->name ?></td>
							<?php if($status_in == 1) {
							if(!empty($in_item->item->item_companies[0]->serial_number_enable)){
							if($in_item->item->item_companies[0]->serial_number_enable == 1) { ?>
							<td><table>
							<?php foreach ($in_item->item->item_serial_numbers as  $item_serial_number){ 
							if($item_serial_number->inventory_transfer_voucher_id == $in_item->inventory_transfer_voucher_id){ ?>
							<tr>
								<td><?php echo $item_serial_number->serial_no ?></td>
							</tr>
							<?php }} ?>
							</table>
							</td>
							<?php }}else{  ?>
							<td><table>
							<?php foreach ($in_item->item->item_serial_numbers as  $item_serial_number){ 
							if($item_serial_number->inventory_transfer_voucher_id == $in_item->inventory_transfer_voucher_id){ ?>
							<tr>
								<td><?php echo "-"; ?></td>
							</tr>
							<?php }} ?>
							</table>
							</td>
							<?php }} ?>
							
							<td valign="top"><?php echo $in_item->quantity ?></td>
							<td><?= h($this->Number->format($in_item->amount,['places'=>2])) ?></td>

						</tr>
						<?php $j++; } ?>
					</tbody>
				</table>
			</td>
		</tr>
		
	</tbody>
</table>
</div>
<?php } ?>
<div style="border:solid 1px ;"></div>
<table width="96%">
	<tr>
	    <td align="left" >
		   <table class="divFooter" >
			     <tr>
					<td valign="top" align="left" width="10%"><b>Narration</b></td>
					<td width="20" align="center">:</td>
					<td ><?= h($inventoryTransferVoucher->narration) ?></td>
				</tr>
			</table ></br></br></br>
		</td>
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


 
 