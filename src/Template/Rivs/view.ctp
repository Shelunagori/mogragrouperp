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
			<td width="30%"><?php echo $this->Html->image('/logos/'.$riv->company->logo, ['width' => '40%']); ?></td>
			<td align="center" width="30%" style="font-size: 12px;"><div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">REVERSE INVENTORY VOUCHER</div></td>
			<td align="right" width="40%" style="font-size: 12px;">
			<span style="font-size: 14px;"><?= h($riv->company->name) ?></span>
			<span><?= $this->Text->autoParagraph(h($riv->company->address)) ?>
			<?= h($riv->company->mobile_no) ?></span>
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
					<td align="left" width=" "<label style="font-size: 14px;font-weight: bold;">Reverse Inventory Voucher No</label></td>
					<td>:</td>
					<td><?= h('#'.str_pad($riv->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
					<td align="left"></td>
					<td>
					</td>
				</tr>
			</table>
	   </td>
	</tr>
</table>	
</br>
<?php if(!empty($riv)){ ?>
<div class="portlet-body form">
<table class="table table-bordered table-condensed">
	<thead> 
		<th width="50%">Out Item</th>
		<th>In Item</th>
	</thead>
	<tbody>
<?php $p=0; foreach($riv->left_rivs as $key=>$left_riv){ ?>
		<tr >
			<td valign="top">
				<?= h($left_riv->item->name) ?> ( <?= h($left_riv->quantity) ?> )</b>
			</td>
			
			<td valign="top">
				<table class="table table-bordered table-condensed">
					<thead> 
						<th width="20%">Sr. No.</th>
						<th>Item</th>
						<th>Quantity</th>
					</thead>
					<tbody>
						<?php $j=1;  foreach($left_riv->right_rivs as $right_riv)  { ?>
						<tr>
							<td valign="top"><?php echo $j; ?></td>
							<td valign="top"><?php echo $right_riv->item->name ?></td>
							<td valign="top"><?php echo $right_riv->quantity ?></td>

						</tr>
						<?php $j++; } ?>
					</tbody>
				</table>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
</br>
<table width="96%">
	<tr>
		<td align="right">
		<table >
			<tr>
			    <td align="center">
				<span style="font-size:14px;">For</span> <span style="font-size: 14px;font-weight: bold;"><?= h($riv->company->name)?><br/></span>
				<?php 
				 echo $this->Html->Image('/signatures/'.$riv->creator->signature,['height'=>'50px','style'=>'height:50px;']); 
				 ?></br>
				<span style="font-size: 14px;font-weight: bold;">Authorised Signatory</span>
				</br>
				<span style="font-size:14px;"><?= h($riv->creator->name) ?></span><br/>
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

 
 