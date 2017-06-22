<?php //pr($materialIndent); exit; ?>
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding: 10px;margin: auto;width: 97%;font-size: 12px;" class="maindiv">
<table width="100%" class="divHeader">
<tr>
	<td width="38%"><?php echo $this->Html->image('/logos/'.$materialIndent->company->logo, ['width' => '38%']); ?></td>
	<td width="25%" valign="bottom" align="center" style="font-size: 19px;font-weight: bold;color: #0685a8;">MATERIAL INDENT</td>
	<td align="right" width="50%" style="font-size: 14px;">
	<span style="font-size: 20px;"><?= h($materialIndent->company->name) ?></span><br/>
	<span style="font-size: 15px;"><?= $this->Text->autoParagraph(h($materialIndent->company->address)) ?></span>
	<span style="font-size: 15px;"><?= h($materialIndent->company->mobile_no) ?></span>
	</td>
</tr>
</table>
<br>
<div style="border:solid 3px #0685a8;margin-bottom:5px;margin-top: 5px;"></div></br>
<div class="portlet-body form">
<?= $this->Form->create($materialIndent); ?>
<div class="form-body">
 <div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-5" style="font-size:118%"><b>Material Indent No:</b></label>
			<div class="col-md-7">
			<?=  h($materialIndent->mi1.'/MI'.str_pad($materialIndent->mi2, 3, '0', STR_PAD_LEFT).'/'.$materialIndent->mi3.'/'.$materialIndent->mi4) ?>
			 </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-5" style="font-size:118%"><b>Customer Name:</b></label>
			<div class="col-md-7">
			<?php echo $this->Form->input('customer_id', ['type'=>'hidden','value' => @$jobCards->customer_id]); ?>
			<?php echo $materialIndent->job_card->customer->customer_name; ?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    <label class="col-md-5" style="font-size:118%"><b>Required Date:</b><span class="required" aria-required="true">*</span></label>
			<div class="col-md-7">
			<td align="Center"><?php echo date("d-m-Y",strtotime($materialIndent->required_date)); ?></td>
			</div>
		</div>
	</div>
</div>
<br/><br/>
<?php $page_no=0; ?>	
	<table class="table tableitm">
		<thead>
			<tr>
			    <th width="30%">Sr.No. </th>
				<th width="20%">Item Name</th>
				<th width="20%">Required Quantity</th>
				<th width="20%">Approved Purchased Quantity</th>
			</tr>
		</thead>
		<tbody>
			 <?php foreach ($materialIndent->material_indent_rows as $material_indent_rows): ?>
			<tr>
			    <td width="20%"><?= h(++$page_no)?></td>
				<td width="20%"><?php echo $material_indent_rows->item->name?></td>
				<td width="20%"><?php echo $material_indent_rows->quantity?></td>
				<td width="20%"><?php echo $material_indent_rows->approved_purchased_quantity?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<table width="100%" class="divFooter">
	<tr>
		<td></td>
		<td align="right">
			<table>
				<tr>
					<td align="center">
					<span style="font-size:17px;">For </span><span style="font-size:17px;"><?= h($materialIndent->company->name)?><br/></span>
					<?php 
					 echo $this->Html->Image('/signatures/'.$materialIndent->creator->signature,['height'=>'50px','style'=>'height:50px;']); 
					 ?></br>
					  <span style="font-size:15px;font-weight: bold;">Authorised Signatory</span>
					  </br>
					  	<span style="font-size:15px;"><?= h($materialIndent->creator->name) ?></span><br/>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>	
</div>
</div>
 
 
<style>
.table thead tr th {
    color: #FFF;
	background-color: #254b73;
}
.padding-right-decrease{
	padding-right: 0;
}
.padding-left-decrease{
	padding-left: 0;
}
</style>
</div>
 