<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
	vertical-align: top !important;
}
.disabledbutton {
    pointer-events: none;
    opacity: 0.4;
}
</style>

<?php   
if(!empty($copy))
{
	//pr($salesOrder->po_date); exit;
		$salesOrder->po_date=date(("d-m-Y"),strtotime($salesOrder->po_date));
		$salesOrder->expected_delivery_date=date(("d-m-Y"),strtotime($salesOrder->expected_delivery_date	));
	
}
?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Add Sales Order</span>
			<?php if($process_status=='Pulled From Quotation'){ ?>
			<br/><span style=" font-size: 13px; ">Converting Quotation: <?= h(($quotation->qt1.'/QO-'.str_pad($quotation->qt2, 3, '0', STR_PAD_LEFT).'/'.$quotation->qt3.'/'.$quotation->qt4)) ?></span>
			<?php } ?>
		</div>

		<div class="actions">
			<div class="btn-group">
				<button id="btnGroupVerticalDrop5" type="button" class="btn yellow dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
				Pull Quotation <i class="fa fa-angle-down"></i>
				</button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="btnGroupVerticalDrop5">
					<li>
					   <?php echo $this->Html->link(' Keep Open Quotation','/Quotations/index?gst-pull-request=true',array('escape'=>false)); ?>
					</li>
					<li>
					   <?php echo $this->Html->link('Close Quotation','/Quotations/index?gst-pull-request=true&&status=close',array('escape'=>false)); ?>
					</li>
				</ul>
			</div>
        </div>

		
		<div class="actions">
			<?php echo $this->Html->link('<i class="fa fa-files-o"></i> Copy Sales Order','/SalesOrders/index?gst-copy-request=copy',array('escape'=>false,'class'=>'btn btn-xs green')); ?>
		</div>
	</div>
	<?php  
	if($sales_id){
		$salesOrder_data=$salesOrder_data;
		
	}else{
		
		$salesOrder_data=$salesOrder_data;
	}
	?>
	
	
	<div class="portlet-body form">
		<?=   $this->Form->create($salesOrder_data,['id'=>'form_sample_3']) ?>
		<div class="form-body">
			<div class="row">
				<div class="col-md-6">
				</div>
				<div class="col-md-3">
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="col-md-3 control-label">Date</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('created_on', ['type' => 'text','label' => false,'class' => 'form-control input-sm','value' => date("d-m-Y"),'readonly']); ?>
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
						
							<?php 
							$options=array();
							foreach($customers as $customer){
								if(empty($customer->alias)){
									$merge=$customer->customer_name;
								}else{
									$merge=$customer->customer_name.'	('.$customer->alias.')';
								}
								
								$options[]=['text' =>$merge, 'value' => $customer->id, 'contact_person' => $customer->contact_person, 'employee_id' => $customer->employee_id, 'transporter_id' => $customer->transporter_id, 'documents_courier_id' => @$customer->customer_address[0]->transporter_id, 'dispatch_address' => @$customer->customer_address[0]->address];
							}
							if($sales_id){
								echo $this->Form->input('customer_id', ['empty' => "--Select--",'label' => false,'options' => $options,'class' => 'form-control input-sm select2me','value' => @$salesOrder->customer_id]);
								
							}else{
								echo $this->Form->input('customer_id', ['empty' => "--Select--",'label' => false,'options' => $options,'class' => 'form-control input-sm select2me','value' => @$quotation->customer_id]);
								
							} ?>
							
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Sales Order No.</label>
						<div class="col-md-3 padding-right-decrease">
							<?php echo $this->Form->input('so1', ['label' => false,'class' => 'form-control input-sm','readonly','value'=>$Company->alias]); ?>
						</div>
						<div class="col-md-3 padding-right-decrease" id="so3_div">
						<?php
							$options=array();
							foreach($Filenames as $Filenames){
								$merge=$Filenames->file1.'-'.$Filenames->file2.'' ;
								
								$options[]=['text' =>$merge, 'value' => $merge];
							}
							echo $this->Form->input('so3', ['options'=>$options,'label' => false,'class' => 'form-control input-sm select2me']); ?>
						
						</div>
						<div class="col-md-3">
							<?php echo $this->Form->input('so4', ['label' => false,'value'=>substr($s_year_from, -2).'-'.substr($s_year_to, -2),'class' => 'form-control input-sm','readonly']); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Address</label>
						<div class="col-md-9">
							<?php 
							if($sales_id){
								echo $this->Form->input('customer_address', ['label' => false,'class' => 'form-control','placeholder' => 'Address','value' => @$salesOrder->customer_address]);
								
							}else{
							echo $this->Form->input('customer_address', ['label' => false,'class' => 'form-control','placeholder' => 'Address','value' => @$quotation->customer_address]);
							} ?>
							<a href="#" role="button" class="pull-right select_address" >
							Select Address </a>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Salesman</label>
						<div class="col-md-9">
							<?php
							if($sales_id){
								echo $this->Form->input('employee_id', ['empty' => "--Select--",'label' => false,'options' => $employees,'class' => 'form-control input-sm select2me','value' => @$salesOrder->employee_id]);
								
							}else{
							echo $this->Form->input('employee_id', ['empty' => "--Select--",'label' => false,'options' => $employees,'class' => 'form-control input-sm select2me','value' => @$quotation->employee_id]); }?>
						</div>
					</div>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Customer PO NO <span class="required" aria-required="true">*</span></label>
						<div class="col-md-9">
							<?php
							if($sales_id){
								echo $this->Form->input('customer_po_no', ['type' => 'text','label' => false,'class' => 'form-control input-sm','value' => @$salesOrder->customer_po_no]);
								
							}else{
							echo $this->Form->input('customer_po_no', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Customer PO NO']); 
							} ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">PO Date <span class="required" aria-required="true">*</span></label>
						<div class="col-md-9">
							<?php
								if($sales_id){
								echo $this->Form->input('po_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm','value' => @$salesOrder->customer_po_no]);
								
							}else{
								echo $this->Form->input('po_date', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'PO Date','data-date-format'=>'dd-mm-yyyy'
							 ]);
							} ?>
						</div>
					</div>
				</div>
			</div>
			<br/>
			<div style="overflow: auto;">
			<table class="table tableitm" id="main_tb" style="width:1700px;">
				<thead>
					<tr>
						<th rowspan="2">S No</th>
						<th  rowspan="2">Items</th>
						<th  rowspan="2">Quantity</th>
						<th  rowspan="2">Rate</th>
						<th  rowspan="2">Amount</th>
						<th  colspan="2"><div align="center">Discount</div></th>
						<th  colspan="2"><div align="center">P&f </div></th>
						<th  rowspan="2"><div align="center">Taxable Value </div></th>
						<th  colspan="2"><div align="center">CGST</div></th>
						<th  colspan="2"><div align="center">SGST</div></th>
						<th  colspan="2"><div align="center">IGST</div></th>
						<th  rowspan="2"><div align="center">Total</div></th>
						<th  rowspan="2"></th>
					</tr>
					<tr>
						<th><div align="center">%</div></th>
						<th><div align="center">Amt</div></th>
						<th><div align="center">%</div></th>
						<th><div align="center">Amt</div></th>
						<th><div align="center">%</div></th>
						<th><div align="center">Amt</div></th>
						<th><div align="center">%</div></th>
						<th><div align="center">Amt</div></th>
						<th><div align="center">%</div></th>
						<th><div align="center">Amt</div></th>
					</tr>
				</thead>
				<tbody id="main_tbody">
					<?php  
                            $cgst_options=array();
							$sgst_options=array();
							$igst_options=array();
							foreach($GstTaxes as $GstTaxe){
								if($GstTaxe->cgst=="Yes"){
									$merge_cgst=$GstTaxe->tax_figure.' ('.$GstTaxe->invoice_description.')';
									$cgst_options[]=['text' =>$merge_cgst, 'value' => $GstTaxe->id,'percentage'=>$GstTaxe->tax_figure];
								}else if($GstTaxe->sgst=="Yes"){
									$merge_sgst=$GstTaxe->tax_figure.' ('.$GstTaxe->invoice_description.')';
									$sgst_options[]=['text' =>$merge_sgst, 'value' => $GstTaxe->id,'percentage'=>$GstTaxe->tax_figure];
								}else if($GstTaxe->igst=="Yes"){
									$merge_igst=$GstTaxe->tax_figure.' ('.$GstTaxe->invoice_description.')';
									$igst_options[]=['text' =>$merge_igst, 'value' => $GstTaxe->id,'percentage'=>$GstTaxe->tax_figure];
								}
								
							}
					if(!empty($process_status=="Pulled From Quotation") || !empty($quotation)) 
					{ 
					if(!empty($quotation->quotation_rows)){
					$q=0; foreach ($quotation->quotation_rows as $quotation_rows): 
					if($quotation_rows->quantity==$quotation_rows->proceed_qty){$disable_class="disabledbutton";
					}else{ $disable_class=""; } 
					?>
						<tr class="tr1 <?php echo $disable_class; ?> maintr" row_no='<?php echo @$quotation_rows->id; ?>'>
							<td rowspan="2"><?php echo ++$q; --$q; ?></td>
							<td width="280Px">

								<div class="row">
									<div class="col-md-10 padding-right-decrease">
										<?php echo $this->Form->input('sales_order_rows.'.$q.'.item_id', ['empty'=>'Select','options' => $items,'label' => false,'class' => 'form-control input-sm  item_box item_id','placeholder'=>'Item','value' => @$quotation_rows->item->id ,'popup_id'=>$q]); ?>
									</div>
									<div class="col-md-1 padding-left-decrease">
										<a href="#" class="btn btn-default btn-sm popup_btn" role="button" popup_id="<?php echo $q; ?>"> <i class="fa fa-info-circle"></i> </a>
										<div class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false" style="display: none; padding-right: 12px;" popup_div_id="<?php echo $q; ?>"><div class="modal-backdrop fade in" ></div>
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-body" popup_ajax_id="<?php echo $q; ?>">
														
													</div>
													<div class="modal-footer">
														<button type="button" class="btn default closebtn">Close</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</td>
							<td><?php echo $this->Form->input('sales_order_rows.'.$q.'.quantity', ['type'=>'text','label' => false,'class' => 'form-control input-sm quantity','max'=>@$quotation_rows->quantity-$quotation_rows->proceed_qty,'placeholder'=>'Quantity','value' => @$quotation_rows->quantity-$quotation_rows->proceed_qty]); ?></td>
							<td width="200Px"><?php echo $this->Form->input('sales_order_rows.'.$q.'.rate', ['type'=>'text','label' => false,'class' => 'form-control input-sm quantity','placeholder'=>'Rate','min'=>'0.01','value' => @$quotation_rows->rate,'r_popup_id'=>$q]); ?></td>
							<td width="200Px"><?php echo $this->Form->input('sales_order_rows.'.$q.'.amount', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Amount','value' => @$quotation_rows->amount]); ?></td>
							<td width="110px;"><?php echo $this->Form->input('sales_order_rows.'.$q.'.discount_per', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Discount Per','value' => '']); ?></td>
							<td width="200Px"><?php echo $this->Form->input('sales_order_rows.'.$q.'.discount', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Discount','value' => '']); ?></td>
							<td width="110px;><?php echo $this->Form->input('sales_order_rows.'.$q.'.pnf_per', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Pnf Per','value' => '']); ?></td>
							<td width="200Px"><?php echo $this->Form->input('sales_order_rows.'.$q.'.pnf', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Pnf','value' => '']); ?></td>
							<td width="200Px"><?php echo $this->Form->input('sales_order_rows.'.$q.'.taxable_value', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Taxable Value','value' => '']); ?></td>
							<td width="150px;"><?php 
							echo $this->Form->input('sales_order_rows.'.$q.'.cgst_per', ['options'=>$cgst_options,'label' => false,'class' => 'form-control input-sm','empty'=>'Select',]); ?></td>
							<td width="150px;"><?php echo $this->Form->input('sales_order_rows.'.$q.'.cgst_amount', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'cgst Amount']); ?></td>
							<td width="150px;">
							<?php  echo $this->Form->input('sales_order_rows.'.$q.'.sgst_per', ['options'=>$sgst_options,'label' => false,'class' => 'form-control input-sm change_des','empty'=>'Select',]);
							?>
							</td>
							<td width="150px;"><?php echo $this->Form->input('sales_order_rows.'.$q.'.sgst_amount', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Sgst Amount']); ?></td>
							<td width="200px;">
							<?php echo $this->Form->input('sales_order_rows.'.$q.'.igst_per', ['options'=>$igst_options,'label' => false,'class' => 'form-control input-sm change_des','empty'=>'Select',]);
							?>
							</td>
							<td width="150px;"><?php echo $this->Form->input('sales_order_rows.'.$q.'.igst_amount', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Igst Amount']); ?></td>
							<td width="200px;"><?php echo $this->Form->input('sales_order_rows.'.$q.'.total', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Total']); ?></td>
							<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
						</tr>
						<tr class="tr2 <?php echo $disable_class; ?> maintr" row_no='<?php echo @$quotation_rows->id; ?>'>
							<td colspan="11" class="main">
							<div class="note-editable" id="summer<?php echo $q; ?>" ><?php echo $quotation_rows->description; ?></div>
							</td>
							<td></td>
						</tr>
					<?php $q++; endforeach; } } elseif(!empty($copy)) { 
					if(!empty($salesOrder->sales_order_rows)){
					$q=0; foreach ($salesOrder->sales_order_rows as $sales_order_rows): ?>
						<tr class="tr1 maintr" row_no='<?php echo @$sales_order_rows->id; ?>'>
							<td rowspan="2"><?php echo ++$q; --$q; ?></td>
							<td width="280Px">
							<div class="row">
									<div class="col-md-10 padding-right-decrease">
										<?php echo $this->Form->input('sales_order_rows.'.$q.'.item_id', ['empty'=>'Select','options' => $items,'label' => false,'class' => 'form-control input-sm select2me item_box item_id','value' => @$sales_order_rows->item->id,'popup_id'=>$q]); ?>
									</div>
									<div class="col-md-1 padding-left-decrease">
										<a href="#" class="btn btn-default btn-sm popup_btn" role="button" popup_id="<?php echo $q; ?>"> <i class="fa fa-info-circle"></i> </a>
										<div class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false" style="display: none; padding-right: 12px;" popup_div_id="<?php echo $q; ?>"><div class="modal-backdrop fade in" ></div>
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-body" popup_ajax_id="<?php echo $q; ?>">
														
													</div>
													<div class="modal-footer">
														<button type="button" class="btn default closebtn">Close</button>
													</div>
												</div>
											</div>
										</div>
									</div>
							</div>
							
							</td>
							<td><?php echo $this->Form->input('sales_order_rows.'.$q.'.quantity', ['type'=>'text','label' => false,'class' => 'form-control input-sm quantity','placeholder'=>'Quantity','value' => @$sales_order_rows->quantity]); ?></td>
							<td width="200Px"><?php echo $this->Form->input('sales_order_rows.'.$q.'.rate', ['type'=>'text','label' => false,'class' => 'form-control input-sm quantity','placeholder'=>'Rate','value' => @$sales_order_rows->rate,'r_popup_id'=>$q]); ?></td>
							<td width="200Px"><?php echo $this->Form->input('sales_order_rows.'.$q.'.amount', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Amount','value' => @$sales_order_rows->amount]); ?></td>
							<td width="110px;"><?php echo $this->Form->input('sales_order_rows.'.$q.'.discount_per', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Discount Per','value' => '']); ?></td>
							<td width="200Px"><?php echo $this->Form->input('sales_order_rows.'.$q.'.discount', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Discount','value' => '']); ?></td>
							<td width="110px;><?php echo $this->Form->input('sales_order_rows.'.$q.'.pnf_per', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Pnf Per','value' => '']); ?></td>
							<td width="200Px"><?php echo $this->Form->input('sales_order_rows.'.$q.'.pnf', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Pnf','value' => '']); ?></td>
							<td width="200Px"><?php echo $this->Form->input('sales_order_rows.'.$q.'.taxable_value', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Taxable Value','value' => '']); ?></td>
							<td width="150px;"><?php 
							echo $this->Form->input('sales_order_rows.'.$q.'.cgst_per', ['options'=>$cgst_options,'label' => false,'class' => 'form-control input-sm','empty'=>'Select',]); ?></td>
							<td width="150px;"><?php echo $this->Form->input('sales_order_rows.'.$q.'.cgst_amount', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'cgst Amount']); ?></td>
							<td width="150px;">
							<?php  echo $this->Form->input('sales_order_rows.'.$q.'.sgst_per', ['options'=>$sgst_options,'label' => false,'class' => 'form-control input-sm change_des','empty'=>'Select',]);
							?>
							</td>
							<td width="150px;"><?php echo $this->Form->input('sales_order_rows.'.$q.'.sgst_amount', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Sgst Amount']); ?></td>
							<td width="200px;">
							<?php echo $this->Form->input('sales_order_rows.'.$q.'.igst_per', ['options'=>$igst_options,'label' => false,'class' => 'form-control input-sm change_des','empty'=>'Select',]);
							?>
							</td>
							<td width="150px;"><?php echo $this->Form->input('sales_order_rows.'.$q.'.igst_amount', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Igst Amount']); ?></td>
							<td width="200px;"><?php echo $this->Form->input('sales_order_rows.'.$q.'.total', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Total']); ?></td>
							<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
						</tr>
						<tr class="tr2 maintr" row_no='<?php echo @$sales_order_rows->id; ?>'>
							<td colspan="11" class="main">
								<div class="note-editable" id="summer<?php echo $q; ?>" ><?php echo $sales_order_rows->description; ?></div>
							</td>
							<td></td>
						</tr>
					<?php $q++; endforeach; } } ?>
				</tbody>
			</table>
			</div>
			<table class="table tableitm" id="tbl2">
				<tr>
					<td align="right"><b>Total Discount</b></td>
					<td width="20%"><?php echo $this->Form->input('total_discount', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total Discount','value' => 0,'step'=>0.01,'readonly']); ?></td>
				</tr>
				<tr>
					<td  align="right"><b>Total after P&F </b></td>
					<td><?php echo $this->Form->input('total_after_pnf', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total after P&F','readonly','step'=>0.01]); ?></td>
				</tr>
				<tr>
					<td align="right"><b>Total Taxable Value</b></td>
					<td width="20%"><?php echo $this->Form->input('total_taxable_value', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total Taxable Value ','value' => 0,'step'=>0.01,'readonly']); ?></td>
				</tr>
				<tr>
					<td  align="right"><b>Total Cgst Amt </b></td>
					<td><?php echo $this->Form->input('total_cgst_value', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total Cgst Amt','readonly','step'=>0.01]); ?></td>
				</tr>
				<tr>
					<td align="right"><b>Total Sgst Amt</b></td>
					<td width="20%"><?php echo $this->Form->input('total_sgst_value', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total Sgst Amt','value' => 0,'step'=>0.01,'readonly']); ?></td>
				</tr>
				<tr>
					<td  align="right"><b>Total Igst Amt </b></td>
					<td><?php echo $this->Form->input('total_igst_value', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total Igst Amt','readonly','step'=>0.01]); ?></td>
				</tr>
				<tr>
					<td  align="right"><b>Total Amount </b></td>
					<td><?php echo $this->Form->input('total', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total Igst Amt','readonly','step'=>0.01]); ?></td>
				</tr>
			</table>

			
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label">Transporter <span class="required" aria-required="true">*</span></label>
						<?php
							echo $this->Form->input('transporter_id', ['empty' => "--Select--",'label' => false,'options' => $transporters,'class' => 'form-control input-sm select2me','value' => @$quotation->customer->transporter_id]);  ?>
					</div>
					<br/>
					<div class="form-group">
						<label class="control-label">Documents Courier <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->input('documents_courier_id', ['empty' => "--Select--",'label' => false,'options' => $transporters,'class' => 'form-control input-sm select2me','value' => @$quotation->customer->customer_address[0]->transporter_id]); ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label">Expected Delivery Date <span class="required" aria-required="true">*</span></label>
						<?php
							if($sales_id){
							 echo $this->Form->input('expected_delivery_date', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'PO Date','data-date-format'=>'dd-mm-yyyy','value'=>date("d-m-Y",strtotime($salesOrder->expected_delivery_date))
							 ]);
								
							}else{
								echo $this->Form->input('expected_delivery_date', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format'=>'dd-mm-yyyy'
							 ]);
							} ?>
						
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label">Delivery Description <span class="required" aria-required="true">*</span></label>
						<?php 
						if($sales_id){
							echo $this->Form->input('delivery_description', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Delivery Description','value'=>$salesOrder->delivery_description]); 
							
						}else{
							echo $this->Form->input('delivery_description', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Delivery Description']); 
						}
						
						?>
					</div>
				</div>
			</div>
			<h4>Dispatch Details</h4>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Name <span class="required" aria-required="true">*</span></label>
						<?php 
						if($sales_id){
							echo $this->Form->input('dispatch_name', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Name','value'=>$salesOrder->dispatch_name]); 
							
						}else{
							echo $this->Form->input('dispatch_name', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Name']); 
						}
						
						?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Mobile <span class="required" aria-required="true">*</span></label>
						<?php 
						echo $this->Form->input('gst', ['type' => 'hidden','value'=>'yes']);
						if($sales_id){
							echo $this->Form->input('dispatch_mobile', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Mobile','value'=>$salesOrder->dispatch_mobile]); 
							
						}else{
							echo $this->Form->input('dispatch_mobile', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Mobile']); 
						}
						?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Email <span class="required" aria-required="true">*</span></label>
						<?php 
						if($sales_id){
							echo $this->Form->input('dispatch_email', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Email','value'=>$salesOrder->dispatch_email]); 
							
						}else{
							echo $this->Form->input('dispatch_email', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder'=>'Email']); 
						}
						 ?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Address  <span class="required" aria-required="true">*</span></label>
						<?php 
						if($sales_id){
							echo $this->Form->input('customer_address', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Email','value'=>$salesOrder->customer_address]); 
							
						}else{
							echo $this->Form->input('customer_address', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Email']); 
						}
						
					?>
					</div>
				</div>
				
				
			</div>
			<div class="row">
				
				<div class="col-md-4">
					<div class="form-group">
						<div class="radio-list" data-error-container="#road_permit_required_error">
						<label class="control-label">Road Permit Required <span class="required" aria-required="true">*</span></label>
						<?php 
						
						echo $this->Form->radio('road_permit_required',[['value' => 'Yes', 'text' => 'Yes'],['value' => 'No', 'text' => 'No']]); ?>
						</div>
						<div id="road_permit_required_error"></div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="radio-list" data-error-container="#form49_error">
						<label class="control-label">Form-49 Required <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->radio('form49',[['value' => 'Yes', 'text' => 'Yes'],['value' => 'No', 'text' => 'No']]); ?>
						</div>
						<div id="form49_error"></div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label">Additional Note  <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->input('additional_note', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Additional Note','value' => @$quotation->customer_address]); ?>
					</div>
				</div>
			</div>
			<br/>
		</div>
		<?php echo $this->Form->input('process_status', ['type' => 'hidden','value' => @$process_status]); ?>
		<div class="form-actions">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					<?php if($chkdate == 'Not Found'){  ?>
					<label class="btn btn-danger"> You are not in Current Financial Year </label>
				<?php } else { ?>
					<button type="submit" class="btn btn-primary" id='submitbtn' >ADD SALES ORDER</button>
				<?php } ?>	
					</div>
			</div>
		</div>
		
		<?= $this->Form->end() ?>
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


<table id="sample_tb" style="display:none;">
	<tbody>
		<tr class="tr1 preimp maintr">
			<td rowspan="2" width="10">0</td>
			<td width="280px;">
				<div class="row">
					<div class="col-md-10 padding-right-decrease">
						<?php echo $this->Form->input('item_id', ['empty'=>'Select','options' => $items,'label' => false,'class' => 'form-control input-sm item_box item_id','placeholder' => 'Item']); ?>
					</div>
					
				</div>
			</td>
			<td width="100"><?php echo $this->Form->input('unit[]', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Quantity']); ?></td>
			<td width="150px"><?php echo $this->Form->input('rate[]', ['type' => 'text','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Rate','step'=>"0.01"]); ?>
			</td>
			<td width="100"><?php echo $this->Form->input('amount[]', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Amount']); ?></td>
			<td width="100"><?php 
			echo $this->Form->input('discount_per	', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Discount Percentage']); ?></td>
			<td width="200px;"><?php echo $this->Form->input('discount	[]', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Discount Amount']); ?></td>
			<td width="100"><?php 
			echo $this->Form->input('pnf_per	', ['type'=>'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'P&F Percentage']); ?></td>
			<td width="200px;"><?php echo $this->Form->input('pnf[]', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'P&f Amount']); ?></td>
			<td width="200px;"><?php echo $this->Form->input('taxable_value[]', ['type' => 'text','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Taxable Value']); ?></td>
			<td width="150px;"><?php 
			echo $this->Form->input('cgst_amount	', ['options'=>$cgst_options,'label' => false,'class' => 'form-control input-sm','empty'=>'Select',]); ?></td>
			<td width="150px;"><?php echo $this->Form->input('cgst_amount	[]', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'cgst Amount']); ?></td>
			<td width="150px;">
			<?php  echo $this->Form->input('sgst_per', ['options'=>$sgst_options,'label' => false,'class' => 'form-control input-sm change_des','empty'=>'Select',]);
			?>
			</td>
			<td width="150px;"><?php echo $this->Form->input('sgst_amount[]', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Sgst Amount']); ?></td>
			<td width="200px;">
			<?php echo $this->Form->input('igst_per', ['options'=>$igst_options,'label' => false,'class' => 'form-control input-sm change_des','empty'=>'Select',]);
			?>
			</td>
			<td width="150px;"><?php echo $this->Form->input('igst_amount[]', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Igst Amount']); ?></td>
			<td width="200px;"><?php echo $this->Form->input('total[]', ['type' => 'type','label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Total']); ?></td>
			<td width="70"><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
		<tr class="tr2 preimp maintr">
			<td colspan="11" class="main"></td>
		</tr>
	</tbody>
</table>

<div id="terms_conditions" style="display:none;">
</div>



<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
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
	}, jQuery.format(""))
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
			date : {
				  required: true,
			},
			customer_id : {
				  required: true,
			},
			so1 : {
				  required: true,
			},
			so3:{
				required: true
			},
			so4:{
				required: true,
			},
			customer_address:{
				required: true,
			},
			employee_id : {
				  required: true,
			},
			customer_po_no  : {
				  required: true,
			},
			po_date: {
				  required: true,
			},
			transporter_id:{
				required: true,	
			},
			documents_courier_id:{
				required: true,	
			},
			expected_delivery_date:{
				required: true,	
			},
			delivery_description:{
				required: true,	
			},
			dispatch_name:{
				required: true,	
			},
			dispatch_mobile:{
				required: true,
				digits: true,
				minlength: 10,
				maxlength: 10,
			},
			dispatch_email:{
				required: true,
				email: true,
			},
			road_permit_required:{
				required: true,
			},
			form49:{
				required: true,
			}
		},

		messages: { // custom messages for radio buttons and checkboxes
			membership: {
				required: "Please select a Membership type"
			},
			service: {
				required: "Please select  at least 2 types of Service",
				minlength: jQuery.validator.format("Please select  at least {0} types of Service")
			}
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
			$('#submitbtn').prop('disabled', true);
			$('#submitbtn').text('Submitting.....');
			put_code_description();
			success3.show();
			error3.hide();
			form[0].submit(); // submit the form
		}

	});
	//--	 END OF VALIDATION
	
	
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
			
			
		}else{
			$("#discount_text").hide();
			$('input[name="discount"]').removeAttr('readonly');
			$('input[name="discount_per"]').val(0);
			$('input[name="discount"]').val(0);
			
		}
		calculate_total();
	})

	<?php if($process_status=="New" ){ ?> add_row(); 
	$("#main_tb tbody tr.tr1").each(function(){
		var description=$(this).find("td:nth-child(7) select option:selected").attr("description");
		$(this).closest("td").find('input').val(description);
	});
	<?php } ?>
	
    $('.addrow').die().live("click",function() { 
		add_row();
    });
	
	$('.change_des').die().live("change",function() { 
		var description=$(this).find('option:selected').attr("description");
		$(this).closest("td").find('input:eq(0)').val(description);
		var ledger_account_id=$(this).find('option:selected').attr("ledger_account_id");
		$(this).closest("td").find('input:eq(1)').val(ledger_account_id);
    });
	
	
	$("#main_tb tbody tr.tr1").each(function(){
		var description=$(this).find("td:nth-child(7) select option:selected").attr("description");
		$(this).find("td:nth-child(7) input").val(description);
	});
	
	
	$('.deleterow').die().live("click",function() {
		var l=$(this).closest("table tbody").find("tr").length;
		if (confirm("Are you sure to remove row ?") == true) {
			if(l>2){
				var row_no=$(this).closest("tr").attr("row_no");
				var del="tr[row_no="+row_no+"]";
				$(del).remove();
				rename_rows();
				calculate_total();
			}
		} 
    });
	
	function add_row(){
		var tr1=$("#sample_tb tbody tr.tr1").clone();
		$("#main_tb tbody#main_tbody").append(tr1);
		var tr2=$("#sample_tb tbody tr.tr2").clone();
		$("#main_tb tbody#main_tbody").append(tr2);
		
		var w=0; var r=0;
		$("#main_tb tbody#main_tbody tr.maintr").each(function(){
			$(this).attr("row_no",w);
			r++;
			if(r==2){ w++; r=0; }
		});
		rename_rows();
	}
	rename_rows();
	calculate_total();
	function rename_rows(){
		var i=0;
		
		$("#main_tb tbody tr.tr1").each(function(){
		    $(this).find('span.help-block-error').remove();
			$(this).find("td:nth-child(1)").html(++i); --i;
			//$(this).find("td:nth-child(2) select").attr({name:"sales_order_rows["+i+"][item_id]", id:"sales_order_rows-"+i+"-item_id",popup_id:i}).select2().rules("add", "required");
			$(this).find("td:nth-child(2) select").attr({name:"sales_order_rows["+i+"][item_id]", id:"sales_order_rows-"+i+"-item_id",popup_id:i}).select2().rules('add', {
						required: true,
						notEqualToGroup: ['.item_id'],
						messages: {
							notEqualToGroup: "Do not select same Item again."
						}
					});
			$(this).find("td:nth-child(3) input:eq( 0 )").attr({name:"sales_order_rows["+i+"][quantity]", id:"sales_order_rows-"+i+"-quantity"}).rules('add', {
						required: true,
						digits: true,
						min: 1,
						messages: {
							min: "Quantity can't be zero."
						}
					});
				//$(this).find("td:nth-child(3)").append('<span for="sales_order_rows-'+i+'-quantity" class="help-block help-block-error" style="display:none;"></span>');
					
			$(this).find("td:nth-child(4) input").attr({name:"sales_order_rows["+i+"][rate]", id:"sales_order_rows-"+i+"-rate",r_popup_id:i}).rules('add', {
						required: true,
						number: true,
						min: 0.01
					});
			$(this).find("td:nth-child(5) input").attr({name:"sales_order_rows["+i+"][amount]", id:"sales_order_rows-"+i+"-amount"}).rules("add", "required");
			$(this).find("td:nth-child(6) input").attr({name:"sales_order_rows["+i+"][discount_per]", id:"sales_order_rows-"+i+"-discount_per"}).rules("required");
			$(this).find("td:nth-child(7) input").attr({name:"sales_order_rows["+i+"][discount]", id:"sales_order_rows-"+i+"-discount"}).rules("required");
			$(this).find("td:nth-child(8) input").attr({name:"sales_order_rows["+i+"][pnf_per]", id:"sales_order_rows-"+i+"-pnf_per"}).rules("required");
			$(this).find("td:nth-child(9) input").attr({name:"sales_order_rows["+i+"][pnf]", id:"sales_order_rows-"+i+"-pnf"}).rules("required");
			$(this).find("td:nth-child(10) input").attr("name","sales_order_rows["+i+"][taxable_value]").rules("required");
			$(this).find("td:nth-child(11) select").attr("name","sales_order_rows["+i+"][cgst_per]")
			$(this).find("td:nth-child(12) input").attr("name","sales_order_rows["+i+"][cgst_amount]");
			$(this).find("td:nth-child(13) select").attr("name","sales_order_rows["+i+"][sgst_per]")
			$(this).find("td:nth-child(14) input").attr("name","sales_order_rows["+i+"][sgst_amount]");
			$(this).find("td:nth-child(15) select").attr("name","sales_order_rows["+i+"][igst_per]");
			$(this).find("td:nth-child(16) input").attr("name","sales_order_rows["+i+"][igst_amount]");
			$(this).find("td:nth-child(17) input").attr("name","sales_order_rows["+i+"][total]").rules("required");
			
		i++; });
		
		var i=0;
		$("#main_tb tbody tr.tr2").each(function(){ 
			var htm=$(this).find('td:nth-child(1)').find('div.note-editable').html();
			
			if(!htm){ htm=""; }
			$(this).find('td:nth-child(1)').html('');
			$(this).find('td:nth-child(1)').append('<div id=summer'+i+'>'+htm+'</div>');
			$(this).find('td:nth-child(1)').find('div#summer'+i).summernote();
			$(this).find('td.main:nth-child(1)').append('<textarea name="sales_order_rows['+i+'][description]"style="display:none;"></textarea>');
		i++; });
		
		

		$("select.item_box").each(function(){
			var popup_id=$(this).attr('popup_id');
			var item_id=$(this).val();
			if(popup_id){
				last_three_rates_onload(popup_id,item_id);
			}
		});
	}
	put_code_description();
	function put_code_description(){
			var i=0;
			$("#main_tb tbody#main_tbody tr.tr2").each(function(){
				var row_no=$(this).attr('row_no');		
				var code=$(this).find('div#summer'+i).code();
				$('#main_tb tbody tr.tr2[row_no="'+row_no+'"]').find('td:nth-child(1) textarea').val(code);
			i++; });
		}
	
	$('#main_tb input,#tbl2 input').die().live("keyup","blur",function() { 
		calculate_total();
    });
	$('#main_tb select').die().live("change",function() {
		calculate_total();
    });
	
	function calculate_total(){ 
		var total=0; var grand_total=0;var total_cgst=0;var total_sgst=0; var total_igst=0;
		var total_discount_amt=0;var total_pnf_amt=0; var tatal_taxable_amt=0;
		$("#main_tb tbody tr.tr1").each(function(){ var row_total=0;
			var qty=$(this).find("td:nth-child(3) input").val();
			var Rate=$(this).find("td:nth-child(4) input").val();
			var Amount=qty*Rate;
			$(this).find("td:nth-child(5) input").val(Amount.toFixed(2));
			//total=total+Amount;
			row_total =row_total+Amount;
			var discount=$(this).find("td:nth-child(6) input").val();
			if(!discount){ discount=0; $(this).find("td:nth-child(7) input").val('');}
			var discount_value = (Amount*discount)/100;
			var value_after_discount = Amount-discount_value;
			if(discount)
			{   
		         row_total =row_total-parseFloat(discount_value);
				 total_discount_amt = total_discount_amt+parseFloat(discount_value);
				 $(this).find("td:nth-child(7) input").val(discount_value.toFixed(2));
			}
			var pnf=$(this).find("td:nth-child(8) input").val(); 
			if(!pnf){ pnf=0; $(this).find("td:nth-child(9) input").val('');}
			var pnf_value = (value_after_discount*pnf)/100;
			var value_after_pnf =value_after_discount+parseFloat(pnf_value);
			if(pnf)
			{
				total_pnf_amt =total_pnf_amt+parseFloat(pnf_value);
				row_total =value_after_pnf;
				$(this).find("td:nth-child(9) input").val(pnf_value.toFixed(2));
			}
			tatal_taxable_amt = tatal_taxable_amt+parseFloat(value_after_pnf);
			$(this).find("td:nth-child(10) input").val(value_after_pnf.toFixed(2));
			var cgst_percentage=parseFloat($(this).find("td:nth-child(11) option:selected").attr("percentage"));
			if(isNaN(cgst_percentage))
			{ 
					var cgst_amount = 0; 
					$(this).find("td:nth-child(12) input").val(cgst_amount.toFixed(2));
			}else
			{  
					var taxable_value=parseFloat($(this).find("td:nth-child(10) input").val());
					var cgst_amount = (taxable_value*cgst_percentage)/100;
					$(this).find("td:nth-child(12) input").val(cgst_amount.toFixed(2));
					row_total=row_total+((taxable_value*cgst_percentage)/100);
			}
			total_cgst=total_cgst+cgst_amount;
			
			var sgst_percentage=parseFloat($(this).find("td:nth-child(13) option:selected").attr("percentage"));
			if(isNaN(sgst_percentage)){ 
				 var sgst_amount = 0; 
				$(this).find("td:nth-child(14) input").val(sgst_amount.toFixed(2));
			}else{ 
			    var taxable_value=parseFloat($(this).find("td:nth-child(10) input").val());
				var sgst_amount = (taxable_value*sgst_percentage)/100;
				$(this).find("td:nth-child(14) input").val(sgst_amount.toFixed(2));
				row_total=row_total+((taxable_value*sgst_percentage)/100);
			}
			total_sgst=total_sgst+sgst_amount;
			var igst_percentage=parseFloat($(this).find("td:nth-child(15) option:selected").attr("percentage"));
			if(isNaN(igst_percentage)){ 
				 var igst_amount = 0; 
				$(this).find("td:nth-child(16) input").val(igst_amount.toFixed(2));
			}else{ 
				var taxable_value=parseFloat($(this).find("td:nth-child(10) input").val());
				var igst_amount = (taxable_value*igst_percentage)/100;
				$(this).find("td:nth-child(16) input").val(igst_amount.toFixed(2));
				row_total=row_total+((taxable_value*igst_percentage)/100);
			}
			total_igst=total_igst+igst_amount;
			$(this).find("td:nth-child(17) input").val(row_total.toFixed(2));
			total = total+parseFloat(row_total);
		});
		
		$('input[name="total_discount"]').val(total_discount_amt.toFixed(2));
		$('input[name="total_after_pnf"]').val(total_pnf_amt.toFixed(2));
		$('input[name="total_taxable_value"]').val(tatal_taxable_amt.toFixed(2));
		$('input[name="total_cgst_value"]').val(total_cgst.toFixed(2));
		$('input[name="total_sgst_value"]').val(total_sgst.toFixed(2));
		$('input[name="total_igst_value"]').val(total_igst.toFixed(2));
		$('input[name="total"]').val(total.toFixed(2));
		
		
		/*if($("#discount_per").is(':checked')){
			var discount_per=parseFloat($('input[name="discount_per"]').val());
			var discount_amount=(total*discount_per)/100;
			if(isNaN(discount_amount)) { var discount_amount = 0; }
			$('input[name="discount"]').val(discount_amount.toFixed(2));
		}else{
			var discount_amount=parseFloat($('input[name="discount"]').val());
			if(isNaN(discount_amount)) { var discount_amount = 0; }
		}
		total=total-discount_amount*/
		
		//$('input[name="total"]').val(total.toFixed(2));
		
		/*if($("#pnfper").is(':checked')){
			var pnf_per=parseFloat($('input[name="pnf_per"]').val());
			var pnf_amount=(total*pnf_per)/100;
			if(isNaN(pnf_amount)) { var pnf_amount = 0; }
			$('input[name="pnf"]').val(pnf_amount.toFixed(2));
		}else{
			var pnf_amount=parseFloat($('input[name="pnf"]').val());
			if(isNaN(pnf_amount)) { var pnf_amount = 0; }
		}*/
		//var total_after_pnf=total+pnf_amount;
		//if(isNaN(total_after_pnf)) { var total_after_pnf = 0; }
		//$('input[name="total_after_pnf"]').val(total_after_pnf.toFixed(2));
		
		//var sale_tax_per=parseFloat($('input[name="sale_tax_per"]').val());
		/*var sale_tax=(total_after_pnf*sale_tax_per)/100;
		if(isNaN(sale_tax)) { var sale_tax = 0; }
		$('input[name="sale_tax_amount"]').val(sale_tax.toFixed(2));*/
		

		
	}
	
	$('.select_address').on("click",function() { 
		open_address();
    });
	
		
	$('.closebtn').live("click",function() { 
		$(".modal").hide();
    });
	
	$('.closebtn').on("click",function() { 
		$("#myModal12").hide();
    });
	$('.popup_btn').live("click",function() {
		var popup_id=$(this).attr('popup_id');
		$("div[popup_div_id="+popup_id+"]").show();
    });
	
	
	
	function open_address(){
		var customer_id=$('select[name="customer_id"]').val();
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
	


	
	  
	$('select[name="customer_id"]').on("change",function() {
		var customer_id=$('select[name="customer_id"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'defaultAddress']); ?>";
		url=url+'/'+customer_id,
		$.ajax({
			url: url,
		}).done(function(response) {
			$('textarea[name="customer_address"]').val(response);
		});
		
		
		$("#so3_div").html('Loading...');
		var url="<?php echo $this->Url->build(['controller'=>'Filenames','action'=>'listFilename']); ?>";
		url=url+'/'+customer_id+'/so',
		$.ajax({
			url: url,
		}).done(function(response) {
			$("#so3_div").html(response);
			$('select[name="qt3"]').attr('name','so3').select2();
		});
		
		
		
		var employee_id=$('select[name="customer_id"] option:selected').attr("employee_id");
		$("select[name=employee_id]").val(employee_id).select2();
		
		var transporter_id=$('select[name="customer_id"] option:selected').attr("transporter_id");
		$("select[name=transporter_id]").val(transporter_id).select2();
		
		var documents_courier_id=$('select[name="customer_id"] option:selected').attr("documents_courier_id");
		$("select[name=documents_courier_id]").val(documents_courier_id).select2();
		
		var dispatch_address=$('select[name="customer_id"] option:selected').attr("dispatch_address");
		$("textarea[name=dispatch_address]").val(dispatch_address);
		
    });
	

	
	
	
	$('select[name="company_id"]').on("change",function() {
		var alias=$('select[name="company_id"] option:selected').attr("alias");
		$('input[name="so1"]').val(alias);
    });
	
	$('.select_term_condition').die().live("click",function() { 
		var addr=$(this).text();
		$("#myModal2").show();
    });
	
	$('.closebtn2').on("click",function() { 
		$("#myModal2").hide();
    });
	
	$('.insert_tc').die().live("click",function() {
		$('#terms_conditions').html("");
		var inc=0;
		$(".tabl_tc tbody tr").each(function(){
			var v=$(this).find('td:nth-child(1) input[type="checkbox"]:checked').val();
			if(v){
				++inc;
				var tc=$(this).find('td:nth-child(2)').text();
				//$('textarea[name="terms_conditions"]').val($('textarea[name="terms_conditions"]').val()+inc+". "+tc+"&#13;&#10;");
				$('#terms_conditions').append(inc+". "+tc+"&#13;&#10;");
			}
		});
		var terms_conditions=$("#terms_conditions").text();
		$('textarea[name="terms_conditions"]').val(terms_conditions);
		$("#myModal2").hide();
    });
	
		$("select.item_box").die().live("change",function(){
		var popup_id=$(this).attr('popup_id');
		var item_id=$(this).val();
		last_three_rates(popup_id,item_id);
	})
	$("select.item_box").each(function(){
		var popup_id=$(this).attr('popup_id');
		var item_id=$(this).val();
		if(popup_id){
			last_three_rates_onload(popup_id,item_id);
		}
	});
	
	$("select.item_box").die().live("change",function(){ 
		var popup_id=$(this).attr('popup_id');
		var item_id=$(this).val();
		last_three_rates(popup_id,item_id);
	})
	
	function last_three_rates_onload(popup_id,item_id){
		
			var customer_id=$('select[name="customer_id"]').val();
			//$('.modal[popup_div_id='+popup_id+']').show();
			$('div[popup_ajax_id='+popup_id+']').html('<div align="center"><?php echo $this->Html->image('/img/wait.gif', ['alt' => 'wait']); ?> Loading</div>');
			if(customer_id){
				var url="<?php echo $this->Url->build(['controller'=>'Invoices','action'=>'RecentRecords']); ?>";
				url=url+'/'+item_id+'/'+customer_id,
				$.ajax({
					url: url,
					dataType: 'json',
				}).done(function(response) {
					$('input[r_popup_id='+popup_id+']').attr({ min:response.minimum_selling_price}).rules('add', {
						min: response.minimum_selling_price,
						messages: {
							min: "Enter value greater than minimum selling price "+response.minimum_selling_price
						}
					});
					$('div[popup_ajax_id='+popup_id+']').html(response.html);
				});
			}else{
				$('div[popup_ajax_id='+popup_id+']').html('Select customer first.');
				$(".item_box[popup_id="+popup_id+"]").val('').select2();
			}
	}
	function last_three_rates(popup_id,item_id){
			var customer_id=$('select[name="customer_id"]').val();
			$('.modal[popup_div_id='+popup_id+']').show();
			$('div[popup_ajax_id='+popup_id+']').html('<div align="center"><?php echo $this->Html->image('/img/wait.gif', ['alt' => 'wait']); ?> Loading</div>');
			if(customer_id){
				var url="<?php echo $this->Url->build(['controller'=>'Invoices','action'=>'RecentRecords']); ?>";
				url=url+'/'+item_id+'/'+customer_id,
				$.ajax({
					url: url,
					dataType: 'json',
				}).done(function(response) {
					if(response.minimum_selling_price>0){
						$('input[r_popup_id='+popup_id+']').attr({ min:response.minimum_selling_price}).rules('add', {
							min: response.minimum_selling_price,
							messages: {
								min: "Minimum selling price: "+response.minimum_selling_price
							}
						});
					}
					else{
						$('input[r_popup_id='+popup_id+']').attr({ min:response.minimum_selling_price}).rules('add', {
							min: 0.01,
							messages: {
								min: "Rate Can't be 0 "
							}
						});
						
					}
					$('div[popup_ajax_id='+popup_id+']').html(response.html);
				});
			}else{
				$('div[popup_ajax_id='+popup_id+']').html('Select customer first.');
				$(".item_box[popup_id="+popup_id+"]").val('').select2();
			}
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
		<?php echo $this->Form->create('pull_from_quotation', ['url' => ['action' => 'pull_from_quotation']])?>
			<div class="modal-body">
				<p>
					<label>Select Quotation Ref. No.</label>
					<?php 
					$options=array();
					foreach($quotationlists as $quotationdata){
						$options[]=['text' => h(($quotationdata->qt1.'/QT-'.str_pad($quotationdata->id, 3, '0', STR_PAD_LEFT).'/'.$quotationdata->qt3.'/'.$quotationdata->qt4)), 'value' => $quotationdata->id];
					}
					echo $this->Form->input('quotation_id', ['empty' => "--Select--",'label' => false,'options' => $options,'class' => 'form-control input-sm select2me']); ?>
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

<div id="myModal2" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false" style="display: none; padding-right: 12px;"><div class="modal-backdrop fade in" ></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" id="result_ajax">
			<h4>Commercial Terms & Conditions</h4>
			<table class="table table-hover tabl_tc">
			<?php foreach ($termsConditions as $termsCondition): ?>
				 
				 <tr>
					<td width="10"><label><?php echo $this->Form->input('dummy', ['type' => 'checkbox','label' => false,'class' => '']); ?></label></td>
					<td><p><?= h($termsCondition->text_line) ?></p></td>
				</tr>
			<?php endforeach; ?>
			</table>
			</div>
			<div class="modal-footer">
				<button class="btn default closebtn2">Close</button>
				<button class="btn btn-primary insert_tc">Insert</button>
			</div>
		</div>
	</div>
</div>