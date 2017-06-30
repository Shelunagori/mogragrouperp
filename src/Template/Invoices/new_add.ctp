<style>
table > thead > tr > th, table > tbody > tr > th, table > tfoot > tr > th, table > thead > tr > td, table > tbody > tr > td, table > tfoot > tr > td{
	vertical-align: top !important;
	border-bottom:solid 1px #CCC;
}
.help-block-error{
	font-size: 10px;
}
</style>
<?php 
if($sales_order->customer->tin_no==''){?>
	<div class="modal fade in"  ></div>
	<div id="myModaltin" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" >
				Please Enter Tin Number For <b><?php echo $sales_order->customer->customer_name; ?></b>
			</div>
			<div class="modal-footer">
				<button class="btn default closetin">Close</button>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
$('.closetin').on("click",function() { 
		$("#myModaltin").hide();
    });
});
</script>
	
<?php } else { ?>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Add Invoice</span>
			<?php if($process_status!="New"){ ?>
			<br/><span style=" font-size: 13px; ">Converting Sales Orders: <?= h(($sales_order->so1.'/QO-'.str_pad($sales_order->so2, 3, '0', STR_PAD_LEFT).'/'.$sales_order->so3.'/'.$sales_order->so4)) ?></span>
			<?php } ?>
		</div>
		<div class="actions">
			<?php echo $this->Html->link('<i class="icon-home"></i> Pull Sales-Order','/SalesOrders/index?pull-request=true',array('escape'=>false,'class'=>'btn btn-xs blue')); ?>
		</div>
	</div>
	<?php if($process_status!="New"){ ?>
	<div class="portlet-body form">
		<?= $this->Form->create($invoice,['id'=>'form_sample_3']) ?>
		<div class="form-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-4 control-label">Sales Account<span class="required" aria-required="true">*</span></label>
						<div class="col-md-8">
							<?php echo $this->Form->input('sales_ledger_account', ['empty' => "--Select--",'label' => false,'options' => $ledger_account_details,'class' => 'form-control input-sm select2me','required']); ?>
						</div>
					</div>
				</div>
				<div class="col-md-3">
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="col-md-3 control-label">Date</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('date_created', ['type' => 'text','label' => false,'class' => 'form-control input-sm','value' => date("d-m-Y"),'readonly']); ?>
						</div>
						<span style="color: red;"><?php if($chkdate == 'Not Found'){  ?>
					You are not in Current Financial Year
				<?php } ?></span>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Customer</label>
						<div class="col-md-9">
						<?php echo $this->Form->input('customer_id', ['type'=>'hidden','value' => @$sales_order->customer_id]); ?>
						<?php echo $sales_order->customer->customer_name.'('; echo $sales_order->customer->alias.')'; ?>	
							
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Invoice No.</label>
						<div class="col-md-9 padding-right-decrease">
							<?php echo $this->Form->input('in1', ['type'=>'hidden','value' => @$sales_order->so1]); ?>
							<?php echo $this->Form->input('in3', ['type'=>'hidden','value' => @$sales_order->so3]); ?>
							<?php echo $this->Form->input('in4', ['type'=>'hidden','value' => substr($s_year_from, -2).'-'.substr($s_year_to, -2)]); ?>
							<?php echo @$sales_order->so1; ?>/<?php echo @$sales_order->so3; ?>/<?php echo substr($s_year_from, -2).'-'.substr($s_year_to, -2); ?>
						</div>
						
					</div>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Address</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('customer_address', ['label' => false,'class' => 'form-control','placeholder' => 'Address','value' => @$sales_order->customer_address]); ?>
							<a href="#" role="button" class="pull-right select_address" >
							Select Address </a>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">LR No. <span class="required" aria-required="true">*</span></label>
						<div class="col-md-9">
							<?php echo $this->Form->input('lr_no', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'LR No']); ?>
						</div>
					</div>
					<br/><br/>
					<div class="form-group">
						<label class="col-md-3 control-label">Salesman  </label>
						<div class="col-md-9">
							<?php echo @$sales_order->employee->name; ?>
						</div>
					</div><br/>
					
					<div class="form-group">
						<label class="col-md-3 control-label">Carrier <span class="required" aria-required="true">*</span></label>
						<div class="col-md-9">
							<?php echo $this->Form->input('transporter_id', ['empty' => "--Select--",'label' => false,'options' => $transporters,'class' => 'form-control input-sm select2me','value' => @$sales_order->transporter_id]); ?>
						</div>
					</div>
				</div>
			</div><br/>

			<div class="row">
				<div class="col-md-6">
				
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3  control-label">Delivery Description <span class="required" aria-required="true">*</span></label>
						<div class="col-md-9">
						<?php echo $this->Form->input('delivery_description', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Delivery Description','value'=>$sales_order->delivery_description]); ?>
						</div>
					</div>
				</div>
				
			</div><br/>
			
			<div class="row">
			<div class="col-md-6">
				<div class="form-group">
						<label class="col-md-3 control-label">Customer PO NO  </label>
						<div class="col-md-9">
								<?php echo $sales_order->customer_po_no; ?>
						</div>
					</div>
			</div>
			<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">PO DATE  <span class="required" aria-required="true">*</span></label>
						<div class="col-md-9">
						
							<?php echo @date("d-m-Y",strtotime($sales_order->po_date)); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
			<?php if($sales_order->road_permit_required=='Yes') {?>
				<div class="col-md-6">
				<div class="form-group">
						<label class="col-md-3 control-label">Road Permit No  <span class="required" aria-required="true">*</span></label>
						<div class="col-md-9">
							<?php echo $this->Form->input('form47', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Form 47','required']); ?>
						</div>
					</div>
				</div>
			<?php } ?>
				<?php if($sales_order->form49=='Yes'){ ?>
				<div class="col-md-6">
				<div class="form-group">
						<label class="col-md-3 control-label">Form 49 <span class="required" aria-required="true">*</span></label>
						<div class="col-md-9">
							<?php echo $this->Form->input('form49', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Form 49','required']); ?>
						</div>
					</div>
				</div>
				<?php } ?>
			</div><br/>
			<input type="text"  name="checked_row_length" id="checked_row_length" style="height: 0px;padding: 0;border: none;" />
			
			<table class="table tableitm" id="main_tb">
				<thead>
					<tr>
						<th width="50">Sr.No. </th>
						<th>Items</th>
						<th width="130">Quantity</th>
						<th width="130">Rate</th>
						<th width="130">Amount</th>
						<th width="130">Sale Tax</th>
						<th width="70"></th>
					</tr>
				</thead>
				<tbody>
					<?php $ed_des=[];
					if(!empty($sales_order->sales_order_rows)){
					$q=0; foreach ($sales_order->sales_order_rows as $sales_order_rows): 
						$ed_des[]=$sales_order_rows->excise_duty;
					?>
						<tr class="tr1  firsttr " row_no='<?php echo @$sales_order_rows->id; ?>'>
						
							<td rowspan="2"><?php echo ++$q; --$q; ?></td>
							<td>
							<?php echo $this->Form->input('q', ['label' => false,'type' => 'hidden','value' => @$sales_order_rows->item->id,'readonly']); ?>
							<?php echo $sales_order_rows->item->name; ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'type' => 'text','class' => 'form-control input-sm quantity','placeholder'=>'Quantity','value' => @$sales_order_rows->quantity-$sales_order_rows->processed_quantity,'readonly','min'=>'1','max'=>@$sales_order_rows->quantity-$sales_order_rows->processed_quantity]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Rate','value' => @$sales_order_rows->rate,'readonly','step'=>0.01]); ?></td>
							<td><?php echo $this->Form->input('q', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Amount','value' => @$sales_order_rows->amount,'readonly','step'=>0.01]); ?></td>
							<td><?php echo @$sales_order_rows->sale_tax->tax_figure; ?></td>
							<td>
								<label><?php echo $this->Form->input('check.'.$q, ['label' => false,'type'=>'checkbox','class'=>'rename_check','value' => @$sales_order_rows->id]); ?></label>
								<?php echo $this->Form->input('q', ['label' => false,'type' => 'hidden','value' => @$sales_order_rows->sale_tax->tax_figure]); ?>
								<?php echo $this->Form->input('st_description', ['type' => 'hidden','label' => false,'value' => @$sales_order_rows->sale_tax->invoice_description]); ?>
								<?php echo $this->Form->input('st_id', ['type' => 'hidden','label' => false,'value' => @$sales_order_rows->sale_tax->id]); ?>
								<?php echo $this->Form->input('st_ledger_account_id', ['type' => 'hidden','label' => false,'value' => @$sale_tax_ledger_accounts[$sales_order_rows->sale_tax->id]]); ?>
							</td>
						</tr>
						<tr class="tr2  secondtr" row_no='<?php echo @$sales_order_rows->id; ?>'>
							<td colspan="5">

							<div contenteditable="true" class="note-editable" id="summer<?php echo $q; ?>"><?php echo @$sales_order_rows->description; ?></div>
							<?php echo $this->Form->input('q', ['label' => false,'type' => 'textarea','class' => 'form-control input-sm ','placeholder'=>'Description','style'=>['display:none'],'value' => @$sales_order_rows->description,'readonly','required']); ?>
							</td>
							<td></td>
						</tr>
				
						<?php 
						
						$options1=[]; 
							foreach($sales_order_rows->item->item_serial_numbers as $item_serial_number){
								$options1[]=['text' =>$item_serial_number->serial_no, 'value' => $item_serial_number->id];
							} 
							if($sales_order_rows->item->item_companies[0]->serial_number_enable==1) { ?>
							<tr class="tr3" row_no='<?php echo @$sales_order_rows->id; ?>'>
							<td></td>
							<td colspan="5">
							<?php echo $this->Form->input('q', ['label'=>false,'options' => $options1,'multiple' => 'multiple','class'=>'form-control select2me','style'=>'width:100%']);  ?></td>
							</tr><?php } ?>
					<?php $q++; endforeach; }?>
				</tbody>
			</table>
			<table class="table tableitm" id="tbl2">
				<tr>
					<td  align="right">
					<?php 
						if($sales_order->discount_type==1){ $checked2="Checked";
							echo 'In Sales Order '; echo @$sales_order->discount_per; echo ' %  ' ;
							 } 
						else{	$checked2="";
							echo 'In Sales Order '; echo  @$sales_order->discount; echo ' Rs ' ;
							 } 
					?> 
					<b>Discount <label><?php echo $this->Form->input('discount_type', ['type' => 'checkbox','label' => false,'class' => 'form-control input-sm','id'=>'discount_per','Checked'=>$checked2]); ?></label>(in %)</b>
						
						<div class="input-group col-md-2" style="display:none;" id="discount_text">
						<input type="text" name="discount_per" class="form-control input-sm" placeholder="5.5"  'step'=0.01 value="<?php echo $sales_order->discount_per; ?> "><span class="input-group-addon">%</span>
					</div>
					</td>
				
					<td><?php echo $this->Form->input('discount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Discount','step'=>0.01,'value'=>$sales_order->discount]); ?></td>
				</tr>
				<?php if(in_array('Yes',@$ed_des)) { ?>
				<tr style="background-color:#e6faf9;">
					<td align="right"><b><?php echo $this->Form->input('ed_description', ['type'=>'textarea','label' => false,'class' => 'form-control input-sm','placeholder' => 'Excise-Duty Description']); ?> </b></td>
					<td><?php echo $this->Form->input('exceise_duty', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Excise-Duty','value' => 0]); ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td align="right"><b>Total</b></td>
					<td width="20%"><?php echo $this->Form->input('total', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total','value' => 0,'step'=>0.01,'readonly']); ?></td>
				</tr>
				<tr>
					<td  align="right">
					<?php
						if($sales_order->pnf_type==1){
							echo 'In Sales Order '; echo @$sales_order->pnf_per; echo ' % ';
							 } 
						else{
							echo 'In Sales Order '; echo  @$sales_order->pnf; echo ' Rs ' ;
							 }
							echo ' ';
						?> 
					<b>P&F <label><?php echo $this->Form->input('pnf_type', ['type' => 'checkbox','label' => false,'class' => 'form-control input-sm','id'=>'pnfper']); ?></label>(in %)</b>
					<div class="input-group col-md-2" style="display:none;" id="pnf_text">
						<input type="text" name="pnf_per" class="form-control input-sm" placeholder="5.5"  'step'=0.01><span class="input-group-addon">%</span>
					</div>
					</td>
					<td><?php echo $this->Form->input('pnf', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'P&F','step'=>0.01]); ?></td>
				</tr>
				<tr>
					<td  align="right"><b>Total after P&F </b></td>
					<td><?php echo $this->Form->input('total_after_pnf', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total after P&F','readonly','step'=>0.01]); ?></td>
				</tr>
				<tr>
					<td  align="right">
						<?php if($process_status!="New"){ ?>
							
							<input type="hidden" name="sale_tax_id"  />
							<input type="hidden" name="st_ledger_account_id" />
							<input type="text" name="sale_tax_description" class="form-control input-sm" readonly placeholder="Sale Tax Description" style="text-align:right;" />
							<div class="input-group col-md-2">
							<div class="input-group">
							<input type="text" name="sale_tax_per" class="form-control input-sm" readonly><span class="input-group-addon">%</span>
							</div>
							</div>
						
						<?php }else{ ?>
						
						<input type="hidden" name="sale_tax_id" />
						<input type="hidden" name="st_ledger_account_id" />
						<input type="text" name="sale_tax_description" class="form-control input-sm" readonly placeholder="Sale Tax Description" style="text-align:right;" />
						<div class="input-group col-md-2">
							<div class="input-group">
						<?php					
							$options=[];
							foreach($SaleTaxes as $SaleTaxe){
								$options[]=['text' => (string)$SaleTaxe->tax_figure.'%', 'value' => $SaleTaxe->tax_figure, 'description' => $SaleTaxe->invoice_description];
							}
							echo $this->Form->input('sale_tax_per', ['options'=>$options,'label' => false,'class' => 'form-control input-sm']); 
						} ?>
							</div>
						</div>
					</td>
					<td><?php echo $this->Form->input('sale_tax_amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','readonly','step'=>0.01]); ?></td>
				</tr>
				<tr>
					<td  align="right">
					<?php echo $this->Form->input('fright_text', ['type'=>'textarea','label' => false,'class' => 'form-control input-sm','placeholder'=>'Additional text for Fright Amount','style'=>['text-align:right']]); ?>
					</td>
					<td>
					<?php echo $this->Form->input('fright_ledger_account', ['empty' => "--Fright Account--",'label' => false,'options' =>$ledger_account_details_for_fright,'class' => 'form-control input-sm select2me','required']); ?>
						
					<?php echo $this->Form->input('fright_amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Fright Amount','step'=>0.01,'value'=>@$sales_order->fright_amount]); ?></td>
				</tr>
				<tr>
					<td  align="right"><b>Grand Total </b></td>
					<td><?php echo $this->Form->input('grand_total', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Grand Total','readonly','step'=>0.01]); ?></td>
				</tr>
			</table>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-3 control-label">Additional Note</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('additional_note', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Additional Note']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-6 control-label">Credit Limits</label>
						<div class="col-md-6" id="due">
							<?php echo $this->Form->input('credit_limit', ['label' => false,'class' => 'form-control input-md','placeholder'=>'','readonly','value' => @$sales_order->customer->credit_limit]); ?><br/>
							<a href="#" role="button" id="update_credit_limit">Update Credit Limit</a>
							<span id="update_credit_limit_wait"></span>
						</div>
					</div>
				</div>
		
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-6 control-label">Due Payment</label>
						<div class="col-md-6" id="due">
							<?php echo $this->Form->input('old_due_payment', ['label' => false,'class' => 'form-control input-md','placeholder'=>'','readonly','value'=>$old_due_payment]); ?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-6 control-label">New Due Payment</label>
						<div class="col-md-6" id="due">
							<?php echo $this->Form->input('new_due_payment', ['label' => false,'class' => 'form-control input-md','placeholder'=>'','readonly','max'=>@$sales_order->customer->credit_limit]); ?>
						</div>
					</div>
				</div>
			
				
				
			</div><br/>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-6 control-label">Temporary Limit</label>
						<div class="col-md-6" id="due">
							<?php echo $this->Form->input('temp_limit', ['label' => false,'class' => 'form-control input-md','placeholder'=>'']); ?>
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-6 control-label">Customer TIN</label>
						<div class="col-md-6" id="due">
							<?php echo $this->Form->input('customer_tin', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'','readonly','value' => @$sales_order->customer->tin_no,'required']); ?><br/>
							
						</div>
					</div>
				</div>
			</div>
			
			<?php $ref_types=['New Reference'=>'New Ref','Against Reference'=>'Agst Ref','Advance Reference'=>'Advance']; ?>
				
				<div class="row">
					<div class="col-md-8">
					<table width="100%" class="main_ref_table">
						<thead>
							<tr>
								<th width="25%">Ref Type</th>
								<th width="40%">Ref No.</th>
								<th width="30%">Amount</th>
								<th width="5%"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $this->Form->input('ref_types', ['empty'=>'--Select-','options'=>$ref_types,'label' => false,'class' => 'form-control input-sm ref_type']); ?></td>
								<td class="ref_no"></td>
								<td><?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount']); ?></td>
								<td><a class="btn btn-xs btn-default deleterefrow" href="#" role="button"><i class="fa fa-times"></i></a></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td align="center" style="vertical-align: middle !important;">On Account</td>
								<td></td>
								<td><?php echo $this->Form->input('on_account', ['label' => false,'class' => 'form-control input-sm on_account','placeholder'=>'Amount','readonly']); ?></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2"><a class="btn btn-xs btn-default addrefrow" href="#" role="button"><i class="fa fa-plus"></i> Add row</a></td>
								<td><input type="text" class="form-control input-sm" placeholder="total" readonly></td>
								<td></td>
							</tr>
						</tfoot>
					</table>
					</div>
				</div>
		<?php echo $this->Form->input('process_status', ['type' => 'hidden','value' => @$process_status]); ?>
		<?php echo $this->Form->input('sales_order_id', ['type' => 'hidden','value' => @$sales_order_id]); ?>
		
		<div class="form-actions">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
			   <?php if($chkdate == 'Not Found'){  ?>
					<label class="btn btn-danger"> You are not in Current Financial Year </label>
				<?php } else { ?>
					<?= $this->Form->button(__('ADD INVOICE'),['class'=>'btn btn-primary','id'=>'add_submit','type'=>'Submit']) ?>
				<?php } ?>	

				</div>
			</div>
		</div>
		
		<?= $this->Form->end() ?>
		
	</div>
	<?php } ?>
	
		
</div>
</div>
<style>
.table thead tr th {
    color: #FFF;
	background-color: #254b73;
}
</style>


<table id="sample_tb" style="display:none;">
	<tbody>
		<tr class="tr1">
			<td rowspan="2">0</td>
			<td><?php echo $this->Form->input('item_id', ['empty'=>'Select','options' => $items,'label' => false,'class' => 'form-control input-sm','placeholder' => 'Item']); ?></td>
			<td><?php echo $this->Form->input('unit[]', ['type' => 'text','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Quantity']); ?></td>
			<td><?php echo $this->Form->input('rate[]', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Rate','step'=>0.01]); ?></td>
			<td><?php echo $this->Form->input('amount[]', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Amount','step'=>0.01]); ?></td>
			<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
		<tr class="tr2">
			<td colspan="4"><?php echo $this->Form->textarea('description', ['label' => false,'class' => 'form-control input-sm autoExpand','placeholder' => 'Description','rows'=>'1']); ?></td>
			<td></td>
		</tr>
	</tbody>
</table>


<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<script>
$(document).ready(function() {
	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	}, "No space please and don't leave it empty");
	
	jQuery.validator.addMethod("notEqualToGroup", function (value, element, options) {
		// get all the elements passed here with the same class
		var elems = $(element).parents('form').find(options[0]);
		// the value of the current element
		var valueToCompare = value;
		// count
		var matchesFound = 0;
		// loop each element and compare its value with the current value
		// and increase the count every time we find one
		jQuery.each(elems, function () {
			thisVal = $(this).val();
			if (thisVal == valueToCompare) {
				matchesFound++;
			}
		});
		// count should be either 0 or 1 max
		if (this.optional(element) || matchesFound <= 1) {
			//elems.removeClass('error');
			return true;
		} else {
			//elems.addClass('error');
		}
	}, jQuery.format("Please enter a Unique Value."));
	
	//--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
			company_id:{
				required: true,
			},
			date_created : {
				  required: true,
			},
			customer_id : {
				  required: true,
			},
			in1 : {
				  required: true,
			},			
			in3:{
				required: true
			},
			in4:{
				required: true,
			},
			customer_address:{
				required: true,
			},
			lr_no : {
				  required: true,
			},
			customer_po_no  : {
				  required: true,
			},
			employee_id: {
				  required: true,
			},
			customer_tin: {
				  required: true,
			},
			checked_row_length: {
				required: true,
				max : 1,
			},
		},

		messages: { // custom messages for radio buttons and checkboxes
			checked_row_length: {
				required : "Please select atleast one row.",
				max: "You can not select multiple rows of different sale tax rate."
			},
			customer_tin: {
				required: "Can't generate Invoice,Customer has not TIN"
			},
			service: {
				required: "Please select  at least 2 types of Service",
				minlength: jQuery.validator.format("Please select  at least {0} types of Service")
			},
		},

		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.parent(".input-group").size() > 0) {
				error.insertAfter(element.parent(".input-group"));
			} else if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else if (element.parents('.radio-list').size() > 0) { 
				error.appendTo(element.parents('.radio-list').attr("data-error-container"));
			} else if (element.parents('.radio-inline').size() > 0) { 
				error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
			} else if (element.parents('.checkbox-list').size() > 0) {
				error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
			} else if (element.parents('.checkbox-inline').size() > 0) { 
				error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
			put_code_description();
			success3.hide();
			error3.show();
			$("#add_submit").removeAttr("disabled");
			//Metronic.scrollTo(error3, -200);
		},

		highlight: function (element) { // hightlight error inputs
		   $(element)
				.closest('.form-group').addClass('has-error'); // set error class to the control group
		},

		unhighlight: function (element) { // revert the change done by hightlight
			$(element)
				.closest('.form-group').removeClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label
				.closest('.form-group').removeClass('has-error'); // set success class to the control group
		},
	
		submitHandler: function (form) {
			$('#add_submit').prop('disabled', true);
			$('#add_submit').text('Submitting.....');
		
			put_code_description();
			success3.show();
			error3.hide();
			form[0].submit();
		}

	});
	
	//--	 END OF VALIDATION
	
	if($("#discount_per").is(':checked')){
			$("#discount_text").show();
			$('input[name="discount"]').attr('readonly','readonly');
			
		}else{
			$("#discount_text").hide();
			$('input[name="discount"]').removeAttr('readonly');
			$('input[name="discount_per"]').val(0);
			$('input[name="discount"]').val(0);
		}
	
	$('#update_credit_limit').on("click",function() {
		var customer_id=$('input[name="customer_id"]').val();
		$("#update_credit_limit_wait").html('Loading...');
		var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'CreditLimit']); ?>";
		url=url+'/'+customer_id,
		$.ajax({
			url: url,
		}).done(function(response) {
			$('input[name="credit_limit"]').val(response);
			$("#update_credit_limit_wait").html('');
			$('input[name="new_due_payment"]').attr('max',response).rules('add', {
						required: true,
						max: response,
						messages: {
							max: "Credit Limit Exieded ."
						}
					});
		});
    });
	
	$('input[name="temp_limit"]').die().live("keyup",function(){
	var credit_limit=$('input[name="credit_limit"]').val();
	var temp_limit=$('input[name="temp_limit"]').val();
    var sum= parseFloat(temp_limit) + parseFloat(credit_limit);
	$('input[name="new_due_payment"]').attr('max',sum).rules('add', {
						required: true,
						max: sum,
						messages: {
							max: "Credit Limit Exieded ."
						}
					});
	});
	
	$('input[name="discount"],input[name="discount_per"],input[name="pnf"],input[name="fright_amount"],input[name="pnf_per"]').die().live("keyup",function() {
			var asc=$(this).val();
			var numbers =  /^[0-9]*\.?[0-9]*$/;
			if(asc.match(numbers))  
			{  
			} 
			else  
			{  
				$(this).val('');
				return false;  
			}
	});
	
	
	
	$('select[name="company_id"]').on("change",function() {
		var alias=$('select[name="company_id"] option:selected').attr("alias");
		$('input[name="in1"]').val(alias);
    });
	
		$("#pnfper").on('click',function(){
		if($(this).is(':checked')){
			$("#pnf_text").show();
			$('input[name="pnf"]').attr('readonly','readonly');
			$('input[name="pnf_per"]').val(0);

		}else{
			$("#pnf_text").hide();
			$('input[name="pnf"]').removeAttr('readonly');
			$('input[name="pnf"]').val(0);
			$('input[name="pnfper"]').val(0);
			
		}
		calculate_total();
	})
	
	$("#discount_per").on('click',function(){  
		if($(this).is(':checked')){
			$("#discount_text").show();
			$('input[name="discount"]').attr('readonly','readonly');
			calculate_total();
		}else{ 
			$("#discount_text").hide();
			$('input[name="discount"]').removeAttr('readonly');
			$('input[name="discount_per"]').val(0);
			$('input[name="discount"]').val(0);
			
		}
		calculate_total();
	})
	
	$('#main_tb input,#tbl1 input').die().live("keyup","blur",function() { 
		calculate_total();
    });
	$('input[name="discount_per"]').die().live("keyup",function() {
		calculate_total();
    });
	$('input[name="discount"]').die().live("keyup",function() {
		calculate_total();
    });
	$('input[name="pnf_per"]').die().live("keyup",function() {
		calculate_total();
    });
	$('input[name="pnf"]').die().live("keyup",function() {
		calculate_total();
    });
	$('input[name="exceise_duty"]').die().live("keyup",function() {
		calculate_total();
    });
	$('input[name="fright_amount"]').die().live("keyup",function() {
		calculate_total();
    });
	
	$('#main_tb input,#tbl2 select').die().live("change",function() { 
		calculate_total();
    });
	
	$('.rename_check').die().live("click",function() {
	
		rename_rows(); calculate_total();
    });
	
	$('.quantity').die().live("keyup",function() {
		var qty =$(this).val();
			rename_rows(); 
    });
	
	<?php if($process_status!="New"){ ?>
	function rename_rows(){
		var list = new Array();
		
		$("#main_tb tbody tr.tr1").each(function(){  
			var row_no=$(this).attr('row_no');
			
			var val=$(this).find('td:nth-child(7) input[type="checkbox"]:checked').val();
			if(val){
				
				$(this).find('td:nth-child(2) input').attr("name","invoice_rows["+val+"][item_id]").attr("id","invoice_rows-"+val+"-item_id").rules("add", "required");
				$(this).find('td:nth-child(3) input').removeAttr("readonly").attr("name","invoice_rows["+val+"][quantity]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-quantity").rules("add", "required");
				$(this).find('td:nth-child(4) input').attr("name","invoice_rows["+val+"][rate]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-rate").rules("add", "required");
				$(this).find('td:nth-child(5) input').attr("name","invoice_rows["+val+"][amount]").attr("id","q"+val).attr("id","invoice_rows-"+val+"-amount").rules("add", "required");
				
				
				var htm=$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] >td').find('div.note-editable').html();
				
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] td:nth-child(1)').closest('td').html('');
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] td:nth-child(1)').append('<div id=summer'+row_no+'>'+htm+'</div>');
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] td:nth-child(1)').find('div#summer'+row_no).summernote();
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"] td:nth-child(1)').append('<textarea name="invoice_rows['+val+'][description]"style="display:none;"></textarea>');
				$(this).css('background-color','#fffcda');
				
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]');
				var qty=$(this).find('td:nth-child(3) input[type="text"]').val();
				var serial_l=$('#main_tb tbody tr.tr3[row_no="'+row_no+'"] td:nth-child(2) select').length;
				
				if(serial_l>0){
					$('#main_tb tbody tr.tr3[row_no="'+row_no+'"] td:nth-child(2) select').removeAttr("readonly").attr("name","invoice_rows["+val+"][item_serial_numbers][]").attr("id","invoice_rows-"+val+"-item_serial_no").attr('maxlength',qty).select2().rules('add', {
						    required: true,
							minlength: qty,
							maxlength: qty,
							messages: {
								maxlength: "select serial number equal to quantity.",
								minlength: "select serial number equal to quantity."
							}
					});
				}
				$('#main_tb tbody tr.tr3[row_no="'+row_no+'"]').css('background-color','#fffcda');
				var s_tax=$(this).find('td:nth-child(6)').text();
				
				list.push(s_tax);
			
			}
			else{
				$(this).find('td:nth-child(2) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(3) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(4) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).find('td:nth-child(5) input').attr({ name:"q", readonly:"readonly"}).rules( "remove", "required" );
				$(this).css('background-color','#FFF');
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').css('background-color','#FFF');
				var serial_l=$('#main_tb tbody tr.tr3[row_no="'+row_no+'"] td:nth-child(2) select').length;
				if(serial_l>0){
				$('#main_tb tbody tr.tr3[row_no="'+row_no+'"] select').attr({ name:"q", readonly:"readonly"}).select2().rules( "remove", "required" );
				$('#main_tb tbody tr.tr3[row_no="'+row_no+'"]').css('background-color','#FFF');
				}
				
			}
			
			var unique=list.filter(function(itm,i,a){
				return i==a.indexOf(itm);
			});

			$("#checked_row_length").val(unique.length);
			
		});
	}
	
	
	
	function put_code_description(){
		var i=0;
			$("#main_tb tbody tr.tr1").each(function(){ 
				var row_no=$(this).attr('row_no');			
				var val=$(this).find('td:nth-child(7) input[type="checkbox"]:checked').val();
				
				if(val){
				var code=$('#main_tb tbody tr.tr2').find('div#summer'+val).code();
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').find('td:nth-child(1) textarea').val(code);
				}
			i++; 
		});
		
	}
	
	
	function calculate_total(){
		var total=0; var grand_total=0;
		$("#main_tb tbody tr.tr1").each(function(){
			var val=$(this).find('td:nth-child(7) input[type="checkbox"]:checked').val();
			if(val){
				var qty=parseInt($(this).find("td:nth-child(3) input").val());
				var Rate=parseFloat($(this).find("td:nth-child(4) input").val());
				var Amount=qty*Rate;
				$(this).find("td:nth-child(5) input").val(Amount.toFixed(2));
				total=total+Amount;
				var sale_tax=parseFloat($(this).find("td:nth-child(7) input[type=hidden]").eq(1).val());
				if(isNaN(sale_tax)) { var sale_tax = 0; }
				$('input[name="sale_tax_per"]').val(sale_tax);
				var sale_tax_description=$(this).find("td:nth-child(7) input[type=hidden]").eq(2).val();
				$('input[name="sale_tax_description"]').val(sale_tax_description);
				var sale_tax_id=$(this).find("td:nth-child(7) input[type=hidden]").eq(3).val();
				$('input[name="sale_tax_id"]').val(sale_tax_id);
				var st_ledger_account_id=$(this).find("td:nth-child(7) input[type=hidden]").eq(4).val();
				$('input[name="st_ledger_account_id"]').val(st_ledger_account_id);
				
			}
		});
		
		if($("#discount_per").is(':checked')){
			var discount_per=parseFloat($('input[name="discount_per"]').val());
			var discount_amount=(total*discount_per)/100;
			if(isNaN(discount_amount)) { var discount_amount = 0; }
			$('input[name="discount"]').val(discount_amount.toFixed(2));
		}else{
			var discount_amount=parseFloat($('input[name="discount"]').val());
			if(isNaN(discount_amount)) { var discount_amount = 0; }
		}
		total=total-discount_amount
		
		var exceise_duty=parseFloat($('input[name="exceise_duty"]').val());
		if(isNaN(exceise_duty)) { var exceise_duty = 0; }
		total=total+exceise_duty
		$('input[name="total"]').val(total.toFixed(2));
		
		if($("#pnfper").is(':checked')){
			var pnf_per=parseFloat($('input[name="pnf_per"]').val());
			var pnf_amount=(total*pnf_per)/100;
			if(isNaN(pnf_amount)) { var pnf_amount = 0; }
			$('input[name="pnf"]').val(pnf_amount.toFixed(2));
		}else{
			var pnf_amount=parseFloat($('input[name="pnf"]').val());
			if(isNaN(pnf_amount)) { var pnf_amount = 0; }
		}
		var total_after_pnf=total+pnf_amount;
		if(isNaN(total_after_pnf)) { var total_after_pnf = 0; }
		$('input[name="total_after_pnf"]').val(total_after_pnf.toFixed(2));
		
		var sale_tax_per=parseFloat($('input[name="sale_tax_per"]').val());
		
		var sale_tax=(total_after_pnf*sale_tax_per)/100;
		if(isNaN(sale_tax)) { var sale_tax = 0; }
		$('input[name="sale_tax_amount"]').val(sale_tax.toFixed(2));
		
		var fright_amount=parseFloat($('input[name="fright_amount"]').val());
		//alert(fright_amount);
		if(isNaN(fright_amount)) { var fright_amount = 0; }
		
		grand_total=total_after_pnf+sale_tax+fright_amount;
		$('input[name="grand_total"]').val(grand_total.toFixed(2));
		
		var old_due_payment1=parseFloat($('input[name="old_due_payment"]').val());
		
		var	new_due_payment=grand_total+old_due_payment1;
		$('input[name="new_due_payment"]').val(new_due_payment.toFixed(2));
		do_ref_total();
	}
	<?php } ?>
	
	$('.select_address').on("click",function() {
		open_address();
    });
	
	$('.closebtn').on("click",function() { 
		$("#myModal12").hide();
    });
	
	
	
	$('select[name="customer_id"]').on("change",function() {
		var customer_id=$('select[name="customer_id"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'defaultAddress']); ?>";
		url=url+'/'+customer_id,
		$.ajax({
			url: url,
		}).done(function(response) {
			$('textarea[name="customer_address"]').val(response);
		});
		
		$("#in3_div").html('Loading...');
		var url="<?php echo $this->Url->build(['controller'=>'Filenames','action'=>'listFilename']); ?>";
		url=url+'/'+customer_id,
		$.ajax({
			url: url,
		}).done(function(response) {
			$("#in3_div").html(response);
			$('select[name="qt3"]').attr('name','in3');
		});
		
		var employee_id=$('select[name="customer_id"] option:selected').attr("employee_id");
			$("select[name=employee_id]").val(employee_id).select2();
		
    });
	
	<?php if($process_status!="New"){ ?> 
		var customer_id=$('select[name="customer_id"] option:selected').val();
		
		$("#in3_div").html('Loading...');
		var url="<?php echo $this->Url->build(['controller'=>'Filenames','action'=>'listFilename']); ?>";
		url=url+'/'+customer_id+'/in',
		$.ajax({
			url: url,
		}).done(function(response) {
			$("#in3_div").html(response);
			$('select[name="qt3"]').attr('name','in3');
		});
	<?php } ?>
	
	function open_address(){
		var customer_id=$('input[name="customer_id"]').val();
		
		$("#result_ajax").html('<div align="center"><?php echo $this->Html->image('/img/wait.gif', ['alt' => 'wait']); ?> Loading</div>');
		var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'addressList']); ?>";
		url=url+'/'+customer_id,
		
		$("#myModal12").show();
		$.ajax({
			url: url,
		}).done(function(response) {
			$("#result_ajax").html(response);
		});
	}
	
	$('.insert_address').die().live("click",function() { 
		var addr=$(this).text();
		$('textarea[name="customer_address"]').val(addr);
		$("#myModal12").hide();
    });
	
	$(".check_row").die().live("click",function() {  
	if($(this).is(':checked')){  
			$(this).closest('tr').find('.amount_box').removeAttr('readonly');
			var amount=$(this).closest('tr').find('.amount_box').attr('amount');
			
			$(this).closest('tr').find('.amount_box').val(amount);
			calculation_for_total();
   
		}else{
			$(this).closest('tr').find('.amount_box').attr('readonly','readonly');
			$(this).closest('tr').find('.amount_box').val('');
			calculation_for_total();
		}
	
	});
	
	 
	calculation_for_total();
	$('input').live("keyup",function() {
		calculation_for_total();
	});
	function calculation_for_total(){
		var total_left=0; var total_right=0; var sum=0;
		$("#due_receipt tbody tr.tr1").each(function(){ 
			var val=$(this).find('td:nth-child(1) input[type="checkbox"]:checked').val();
			if(val){
				var qty=parseFloat($(this).find('.amount_box').val());
				total_left=total_left+qty;
			} 
			$('input[name="total_amount_agst"]').val(total_left.toFixed(2));	
			
		});
	}
	
	
	
	$('.addrefrow').live("click",function() {
		add_ref_row();
	});
	
	function add_ref_row(){
		var tr=$("#sample_ref table.ref_table tbody tr").clone();
		$("table.main_ref_table tbody").append(tr);
		rename_ref_rows();
	}
	rename_ref_rows();
	function rename_ref_rows(){
		var i=0;
		$("table.main_ref_table tbody tr").each(function(){
			$(this).find("td:nth-child(1) select").attr({name:"ref_rows["+i+"][ref_type]", id:"ref_rows-"+i+"-ref_type"}).rules("add", "required");
			var is_select=$(this).find("td:nth-child(2) select").length;
			var is_input=$(this).find("td:nth-child(2) input").length;
			
			if(is_select){
				$(this).find("td:nth-child(2) select").attr({name:"ref_rows["+i+"][ref_no]", id:"ref_rows-"+i+"-ref_no"}).rules("add", "required");
			}else if(is_input){
				var url='<?php echo $this->Url->build(['controller'=>'Invoices','action'=>'checkRefNumberUnique']); ?>';
				url=url+'/<?php echo $c_LedgerAccount->id; ?>/'+i;
				$(this).find("td:nth-child(2) input").attr({name:"ref_rows["+i+"][ref_no]", id:"ref_rows-"+i+"-ref_no", class:"form-control input-sm ref_number"}).rules('add', {
							required: true,
							noSpace: true,
							notEqualToGroup: ['.ref_number'],
							remote: {
								url: url,
							},
							messages: {
								remote: "Not an unique."
							}
						});
			}
			
			$(this).find("td:nth-child(3) input").attr({name:"ref_rows["+i+"][ref_amount]", id:"ref_rows-"+i+"-ref_amount"}).rules("add", "required");
			i++;
		});
		
		var is_tot_input=$("table.main_ref_table tfoot tr:eq(1) td:eq(1) input").length;
		if(is_tot_input){
			$("table.main_ref_table tfoot tr:eq(1) td:eq(1) input").attr({name:"ref_rows_total", id:"ref_rows_total"}).rules('add', { equalTo: "#grand-total" });
		}
	}
	
	$('.deleterefrow').live("click",function() {
		$(this).closest("tr").remove();
		do_ref_total();
	});
	
	$('.ref_type').live("change",function() {
		var current_obj=$(this);
		
		var ref_type=$(this).find('option:selected').val();
		if(ref_type=="Against Reference"){
			var url="<?php echo $this->Url->build(['controller'=>'Invoices','action'=>'fetchRefNumbers']); ?>";
			url=url,
			$.ajax({
				url: url+'/<?php echo $c_LedgerAccount->id; ?>',
				type: 'GET',
			}).done(function(response) {
				current_obj.closest('tr').find('td:eq(1)').html(response);
				rename_ref_rows();
			});
		}else if(ref_type=="New Reference" || ref_type=="Advance Reference"){
			current_obj.closest('tr').find('td:eq(1)').html('<input type="text" class="form-control input-sm" placeholder="Ref No." >');
			rename_ref_rows();
		}else{
			current_obj.closest('tr').find('td:eq(1)').html('');
		}
	});
	
	$('.ref_list').live("change",function() {
		var current_obj=$(this);
		var due_amount=$(this).find('option:selected').attr('due_amount');
		$(this).closest('tr').find('td:eq(2) input').val(due_amount);
		do_ref_total();
	});
	
	$('.ref_amount_textbox').live("keyup",function() {
		do_ref_total();
	});
	
	function do_ref_total(){
		var main_amount=parseFloat($('input[name="grand_total"]').val());
		if(!main_amount){ main_amount=0; }
		
		var total_ref=0;
		$("table.main_ref_table tbody tr").each(function(){
			var am=parseFloat($(this).find('td:nth-child(3) input').val());
			if(!am){ am=0; }
			total_ref=total_ref+am;
		});
		
		var on_acc=main_amount-total_ref; 
		if(on_acc>=0){
			$("table.main_ref_table tfoot tr:nth-child(1) td:nth-child(3) input").val(on_acc.toFixed(2));
			total_ref=total_ref+on_acc;
		}else{
			$("table.main_ref_table tfoot tr:nth-child(1) td:nth-child(3) input").val(0);
		}
		$("table.main_ref_table tfoot tr:nth-child(2) td:nth-child(2) input").val(total_ref.toFixed(2));
	}
	
});
</script>
	 
<div id="myModal12" class="modal fade in" tabindex="-1"  style="display: none; padding-right: 12px;"><div class="modal-backdrop fade in" ></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" id="result_ajax">
				
			</div>
			<div class="modal-footer">
				<button class="btn default closebtn">Close</button>
				<button class="btn yellow">Save</button>
			</div>
		</div>
	</div>
</div>


<div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<?php echo $this->Form->create('pull_From_Sales_Order', ['url' => ['action' => 'pull_From_Sales_Order']])?>
			<div class="modal-body">
				<p>
					<label>Select Sales Order No.</label>
					<?php 
					$options=array();
					foreach($salesOrders as $salesOrderdata){
						$options[]=['text' => h(($salesOrderdata->so1.'/SO-'.str_pad($salesOrderdata->id, 3, '0', STR_PAD_LEFT).'/'.$salesOrderdata->so3.'/'.$salesOrderdata->so4)), 'value' => $salesOrderdata->id];
					}
					echo $this->Form->input('sales_order_id', ['empty' => "--Select--",'label' => false,'options' => $options,'class' => 'form-control input-sm select2me']); ?>
				</p>
			</div>
			<div class="modal-footer">
				<button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
				<button class="btn blue" type="submit" name="pull_submit">GO</button>
			</div>
		<?= $this->Form->end() ?>
		</div>
	</div>
</div>
<?php } ?>

<?php $ref_types=['New Reference'=>'New Ref','Against Reference'=>'Agst Ref','Advance Reference'=>'Advance']; ?>
<div id="sample_ref" style="display:none;">
	<table width="100%" class="ref_table">
		<tbody>
			<tr>
				<td><?php echo $this->Form->input('ref_types', ['empty'=>'--Select-','options'=>$ref_types,'label' => false,'class' => 'form-control input-sm ref_type']); ?></td>
				<td class="ref_no"></td>
				<td><?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm ref_amount_textbox','placeholder'=>'Amount']); ?></td>
				<td><a class="btn btn-xs btn-default deleterefrow" href="#" role="button"><i class="fa fa-times"></i></a></td>
			</tr>
		</tbody>
	</table>
</div>