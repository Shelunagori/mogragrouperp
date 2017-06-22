<?php  //foreach($JobCardRows as $items){ pr($items); } exit; ?>
<style>
.page-content-wrapper .page-content{
	padding:5px 5px 5px 5px;
}
#main_tb td,th{
	padding:3px;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
	vertical-align: top !important;
}
</style>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Add Inventory Voucher</span>
		</div>
		<div class="actions">
		<?php echo $this->Html->link('<i class="fa fa-files-o"></i> Pull Invoice','/Invoices?inventory_voucher=true',array('escape'=>false,'class'=>'btn btn-xs blue')); ?>
		</div>
	</div>
<div class="portlet-body form">
	
		<?= $this->Form->create($inventoryVoucher,['id'=>'form_sample_3']) ?>
		<div class="form-body">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-3 control-label">Customer</label>
						<div class="col-md-9">
						<?php echo $Invoice->customer->customer_name.'('; echo $Invoice->customer->alias.')'; ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
				<div class="form-group">
						<label class="col-md-3 control-label">Invoice No.</label>
						<div class="col-md-9 padding-right-decrease">
							<?= h(($Invoice->in1.'/IN-'.str_pad($Invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$Invoice->in3.'/'.$Invoice->in4)) ?>
						</div>
						
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label class="col-md-3 control-label">Date</label>
						<div class="col-md-9">
							<?php echo date("d-m-Y"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div width="80px">
		<?php foreach($display_items as $item_id=>$item_name){ ?>
			<?php echo $this->Html->link($item_name,'/Inventory-Vouchers/add?invoice='.$invoice_id.'&item_id='.$item_id); ?><br/>
		<?php } ?>
		</div>
		<div class="row">
		<div class="col-md-8"> 
		<table id="main_table" class="table table-bordered">
			<tbody id="maintbody">
			<?php $i=0; foreach($JobCardRows as $job_card_row){ ?>
				<tr class="tr1 preimp" row_no='<?php echo $i; ?>'>
					<td width="60%">
					<?php echo $this->Form->input('invoice_id', ['type'=>'hidden','value' => @$invoice_row->invoice_id]); ?>
					<?php echo $this->Form->input('inventory_voucher_rows.'.$i.'.item_id', ['options' => $items,'empty'=>'--select--','label' => false,'class' => 'form-control input-sm select_item','value' => $job_card_row->item_id]); ?>
					</td>
					<td>
					<?php echo $this->Form->input('inventory_voucher_rows.'.$i.'.quantity', ['type' => 'text','label' => false,'class' => 'form-control input-sm qty_bx','value' => $job_card_row->quantity]); ?>
					
					<?php 
					$options1=[];
					foreach($job_card_row->item->item_serial_numbers as $item_serial_number){
						$options1[]=['text' =>$item_serial_number->serial_no, 'value' => $item_serial_number->id];
					} ?>
					<div class="serial_containor">
					<?php if($options1) { ?>
						<?php echo $this->Form->input('q', ['label'=>'Select Serial Number','options' => $options1,'multiple' => 'multiple','class'=>'form-control ','required','style'=>'width:100%']);  ?></td>
					<?php } ?>
					</div>
					</td>
					<td>
					<a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a>
					</td>
				</tr>
				
				
			<?php $i++; } ?>
			</tbody>
		</table>
		</div>
		</div>

		<button type="submit" class="btn btn-primary" >NEXT</button>
		<?= $this->Form->end() ?>
	
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
			item_serial_numbers:{
				required: true,
			}
		},
	});
	rename_rows_name();
	$('.addrow').die().live("click",function() { //alert();
		var tr1=$("#sample_tb tbody").html();
		$(this).closest('table tbody').append(tr1);
		
		var w=0; var r=0;
		$("#main_table tbody#maintbody tr.preimp").each(function(){
			$(this).attr("row_no",w);
			r++;
			if(r==2){ w++; r=0; }
		});
		rename_rows_name();
    });
	$('.deleterow').die().live("click",function() {
		var l=$(this).closest("table tbody").find("tr").length;
		if (confirm("Are you sure to remove row ?") == true) {
			if(l>2){
				var row_no=$(this).closest("tr").attr("row_no");
				var del="tr[row_no="+row_no+"]";
				$(del).remove();
				rename_rows_name();
			}
		} 
    });
	
	$('.qty_bx').die().live("keyup",function() {
		validate_serial();
    });
	
	$('.select_item').die().live("change",function() {
		var t=$(this);
  		var select_item_id=$(this).find('option:selected').val();
		var url1="<?php echo $this->Url->build(['controller'=>'InventoryVouchers','action'=>'ItemSerialNumber']); ?>";
		url1=url1+'/'+select_item_id,
		$.ajax({
			url: url1,
		}).done(function(response) {
			alert(response);
  			$(t).closest('tr').find('div.serial_containor').html(response);
			$(t).closest('tr').find('div.serial_containor select').select2();
			rename_rows_name();
		});
	});
	
	
	validate_serial();
	function validate_serial(){
		$("#main_table tbody#maintbody tr.tr1").each(function(){
			var qty=$(this).find('td:nth-child(2) input:nth-child(1)').val();
			if($(this).find('td:nth-child(2) select').length >0 ){
				$(this).find('td:nth-child(2) select').rules('add', {
						required: true,
						minlength: qty,
						maxlength: qty,
						messages: {
							maxlength: "select serial number equal to quantity.",
							minlength: "select serial number equal to quantity.",
						}
				});
			}
			
			
		});	
	}
	
	
	function rename_rows_name(){ 
		var i=0;
		$("#main_table tbody#maintbody tr.tr1").each(function(){
			$(this).find("td:nth-child(1) select").attr({name:"inventory_voucher_rows["+i+"][item_id]", id:"inventory_voucher_rows-"+i+"-item_id"}).select2().rules('add', {required: true});
					
			$(this).find("td:nth-child(2) input").attr({name:"inventory_voucher_rows["+i+"][quantity]", id:"inventory_voucher_rows-"+i+"-quantity"}).rules('add', {
							required: true,
							digits: true
					});
			$(this).find("td:nth-child(2) select").attr({name:"inventory_voucher_rows["+i+"][serial_no][]", id:"inventory_voucher_rows-"+i+"-serial_no"}).select2();
			
			i++;
		});
	}
	
	
});
</script>

<table id="sample_tb" style="display:none;">
	<tbody>
	<tr class="tr1 preimp">
		<td>
		<?php echo $this->Form->input('invoice_row_id', ['class' => 'form-control input-sm ','type'=>'hidden','label'=>false]); ?>
		<?php echo $this->Form->input('invoice_row_item_id',['class' => 'form-control input-sm item_id','type'=>'hidden','label'=>false]); ?>
		<?php echo $this->Form->input('item_id', ['options' => $items,'empty'=>'--select--','label' => false,'class' => 'form-control input-sm select_item']); ?>
		</td>
		<td>
		<?php echo $this->Form->input('quantity', ['type' => 'text','label' => false,'class' => 'form-control input-sm qty_bx']); ?>
		<div class="serial_containor"></div>
		</td>
		<td>
		<a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a>
		</td>
	</tr>
				
				
			
	</tbody>
</table>