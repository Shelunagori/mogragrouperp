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
.intrnl_tbl tr td, .intrnl_tbl tr th{
	border:solid; white !important;
        border-width:0 0 0 0 !important;
        border-bottom-style: none;

}
</style>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0 5px 0 20px;  /* this affects the margin in the printer settings */
}
</style>
<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>

<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 80%;font-size:12px;" class="maindiv">
<table width="100%">
	<tr>
		<td width="40%"><?php echo $this->Html->image('/logos/'.$jobCard->company->logo, ['width' => '35%']); ?></td>
		<td valign="middle" width="20%" align="center" style="font-size:22px;font-weight: bold;color: #0685a8;">JOB CARD</td>
		<td align="right" width="50%" style="font-size: 14px;">
		<span style="font-size: 16px;"><?= h($jobCard->company->name) ?></span><br/>
		<span style="font-size: 13px;"><?= $this->Text->autoParagraph(h($jobCard->company->address)) ?></span>
		<span style="font-size: 13px;"> <i class="fa fa-phone" aria-hidden="true"></i> <?= h($jobCard->company->landline_no) ?></span> |
		<span style="font-size: 13px;"><?= h($jobCard->company->mobile_no) ?></span>
		</td>
	</tr>
</table>
<div style="border:solid 3px #0685a8;margin-bottom:5px;margin-top: 5px;"></div>
<div class="portlet-body form">
	<div class="form-body">
		 <table border="0" align="center" width="100%">
		        <tr>
					<td  width="20%"><label><b>Job Card No</b></label></td>
					<td  width="5%">:</td>
					<td  width="25%"><?= h(($jobCard->jc1.'/JC-'.str_pad($jobCard->jc2, 3, '0', STR_PAD_LEFT).'/'.$jobCard->jc3.'/'.$jobCard->jc4))?></td>
					<td  width="20%"><label  style="font-size:105%"><b>Customer Name</b></label></td>
					<td  width="5%">:</td>
					<td  width="25%"><?= h($jobCard->customer->customer_name) ?></td>
				</tr>
				<tr>
					<td><label><b>Sales Order No</b></label></td>
					<td>:</td>
					<td><?= h(($jobCard->sales_order->so1.'/SO-'.str_pad($jobCard->sales_order->so2, 3, '0', STR_PAD_LEFT).'/'.$jobCard->sales_order->so3.'/'.$jobCard	->sales_order->so4))?></td>
					<td><label style="font-size:105%"><b>Customer PO No</b></label></td>
					<td>:</td>
					<td><?= h($jobCard->customer_po_no)?></td>
				</tr>
				<tr>
					<td><label style="font-size:105%"><b>Required Date</b></label></td>
					<td>:</td>
					<td><?= h($jobCard->required_date=date("d-m-Y",strtotime($jobCard->required_date))) ?></td>
					
				</tr>
				<tr>
					<td valign="top"><label style="font-size:105%"><b>Dispatch Destination</b></label></td>
					<td valign="top">:</td>
					<td colspan="4"><?= $this->Text->autoParagraph(h($jobCard->dispatch_destination))?></td>
				</tr>
				<tr>
					<td valign="top"><label style="font-size:105%"><b>Packing</b></label></td>
					<td valign="top">:</td>
					<td colspan="4"><?= $this->Text->autoParagraph(h($jobCard->packing)) ?></td>
					
				</tr>
			</table>	
	</div>
</div>	
	
<?php if(!empty($jobCard)){ ?>
<div class="portlet-body form">
<table class="table table-bordered table-condensed">
	<thead> 
		<th width="30%">Production</th>
		<th>Consumption</th>
	</thead>
	<tbody>
		<?php foreach ($jobCard->sales_order->sales_order_rows as $sales_order_row): ?>
		<tr>
			<td valign="top">
			<b><?= $sales_order_row->item->name ?> ( <?= h($sales_order_row->quantity) ?> )</b><br/>Remark:-(<?= h($sales_order_row->job_card_rows[0]['remark']) ?>)
			</td>
			<td>
				<table class="intrnl_tbl">
					<?php foreach($sales_order_row->job_card_rows as $job_card_row): ?> 
					<tr>
						<td><?= $job_card_row->item->name?></td>
						<td width="5%" align="right"><?= $job_card_row->quantity?></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<table width="96%">
	<tr>
		<td align="right">
		<table >
			<tr>
			    <td align="center">
				<span style="font-size:14px;">For</span> <span style="font-size: 14px;font-weight: bold;"><?= h($jobCard->company->name)?><br/></span>
				<?php 
				 echo $this->Html->Image('/signatures/'.$jobCard->creator->signature,['height'=>'50px','style'=>'height:50px;']); 
				 ?></br>
				<span style="font-size: 14px;font-weight: bold;">Authorised Signatory</span>
				</br>
				<span style="font-size:14px;"><?= h($jobCard->creator->name) ?></span><br/>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</div>
<?php } ?>
</div>