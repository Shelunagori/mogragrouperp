<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">GST Sales Report</span>
		</div>
		<div class="actions">
			
		</div>
		
	
	<div class="portlet-body form">
		<form method="GET" >
			<table width="50%" class="table table-condensed">
				<tbody>
					<tr>
						<td width="12%">
							<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" value="<?php echo @date('d-m-Y', strtotime($From));  ?>"  data-date-format="dd-mm-yyyy">
						</td>	
						<td width="12%">
							<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" value="<?php echo @date('d-m-Y', strtotime($To));  ?>"  data-date-format="dd-mm-yyyy" >
						</td>
						
						<td width="15%">
								<?php echo $this->Form->input('item_name', ['empty'=>'---Items---','options' => $Items,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category','value'=> h(@$item_name) ]); ?>
						</td>
						<td width="15%">
								<?php echo $this->Form->input('item_category', ['empty'=>'---Category---','options' => $ItemCategories,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category','value'=> h(@$item_category) ]); ?>
						</td>
						<td width="15%">
							<div id="item_group_div">
							<?php echo $this->Form->input('item_group_id', ['empty'=>'---Group---','options' =>$ItemGroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Group','value'=> h(@$item_group)]); ?></div>
						</td>
						<td width="15%">
							<div id="item_sub_group_div">
							<?php echo $this->Form->input('item_sub_group_id', ['empty'=>'---Sub-Group---','options' =>$ItemSubGroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Sub-Group','value'=> h(@$item_sub_group)]); ?></div>
						</td>
					
						<td width="10%">
							<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
						</td>
					</tr>
				</tbody>
			</table>
			</form>
		<!-- BEGIN FORM-->
		<div class="row ">
		
		
		<div class="col-md-12">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<td colspan="11" align="center"  valign="top">
							<h4 class="caption-subject font-black-steel uppercase">Sales Invoice</h4>
						</td>
					</tr>
					<tr>
						<th>Sr.No.</th>
						<th>Invoice No</th>
						<th>Date</th>
						<th>Customer</th>
						<th style="text-align:right;">Sales @ 12 % GST</th>
						<th style="text-align:right;">GST @ 12 % </th>
						<th style="text-align:right;">Sales @ 18 % GST</th>
						<th style="text-align:right;">GST @ 18 % </th>
						<th style="text-align:right;">Sales @ 28 % GST</th>
						<th style="text-align:right;">GST @ 28 % </th>
					</tr>
				</thead>
				<?php $i=1; $salesGst12=0; $salesGst18=0; $salesGst28=0; $salesTotal12=0; $salesTotal18=0; $salesTotal28=0; 
				foreach ($invoices as $invoice):  ?>
				<tbody>
					<tr>
						<td><?php echo $i; ?></td>
						<td>
							<?php echo $this->Html->link( $invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4,[
							'controller'=>'Invoices','action' => 'gstConfirm',$invoice->id],array('target'=>'_blank')); ?>
						</td>
						<td><?php echo date("d-m-Y",strtotime($invoice->date_created)); ?></td>
						<td><?php echo $invoice->customer->customer_name.'('.$invoice->customer->alias.')'?></td>
						<td>
						<?php  if($invoice->invoice_rows[0]['cgst_percentage']==8 && $invoice->invoice_rows[0]['sgst_percentage']==11){
							 echo $invoice->grand_total;
							 $salesTotal12=$salesTotal12+$invoice->grand_total;
						}else{
							echo "-";
						}?>
						</td>
						<td>
							<?php  if($invoice->invoice_rows[0]['cgst_percentage']==8 && $invoice->invoice_rows[0]['sgst_percentage']==11){
										echo $invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount;
										$salesGst12=$salesGst12+($invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
						<?php  if($invoice->invoice_rows[0]['cgst_percentage']==9 && $invoice->invoice_rows[0]['sgst_percentage']==12){
							 echo $invoice->grand_total;
							 $salesTotal18=$salesTotal18+$invoice->grand_total;
						}else{
							echo "-";
						}?>
						</td>
						<td>
							<?php  if($invoice->invoice_rows[0]['cgst_percentage']==9 && $invoice->invoice_rows[0]['sgst_percentage']==12){
										echo $invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount;
										$salesGst18=$salesGst18+($invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
						<?php  if($invoice->invoice_rows[0]['cgst_percentage']==10 && $invoice->invoice_rows[0]['sgst_percentage']==13){
							 echo $invoice->grand_total;
							 $salesTotal28=$salesTotal28+$invoice->grand_total;
						}else{
							echo "-";
						}?>
						</td>
						<td>
							<?php  if($invoice->invoice_rows[0]['cgst_percentage']==10 && $invoice->invoice_rows[0]['sgst_percentage']==13){
										echo $invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount;
										$salesGst28=$salesGst28+($invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount);
								}else{
									echo "-";
								} ?>
						</td>

						
					</tr>
				<?php $i++; endforeach; ?>
				<tr>
					<td colspan="4"></td>
					<td align="right"><?php echo $this->Number->format($salesTotal12,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesGst12,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesTotal18,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesGst18,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesTotal28,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesGst28,['places'=>2]); ?></td>
					
				</tr>
				</tbody>
				</table>
				
		
			
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<td colspan="11" align="center"  valign="top">
							<h4 class="caption-subject font-black-steel uppercase">Sales Inter State</h4>
						</td>
					</tr>
					<tr>
						<th>Sr.No.</th>
						<th>Invoice No</th>
						<th>Date</th>
						<th>Customer</th>
						<th style="text-align:right;">Sales @ 12 % IGST</th>
						<th style="text-align:right;">IGST @ 12 % </th>
						<th style="text-align:right;">Sales @ 18 % IGST</th>
						<th style="text-align:right;">IGST @ 18 % </th>
						<th style="text-align:right;">Sales @ 28 % IGST</th>
						<th style="text-align:right;">IGST @ 28 % </th>
					</tr>
				</thead>
				<?php $i=1; $salesIgst12=0; $salesIgst18=0; $salesIgst28=0; $salesTotal12=0; $salesTotal18=0; $salesTotal28=0; 
				foreach ($interStateInvoice as $invoice):  ?>
				<tbody>
					<tr>
						<td><?php echo $i; ?></td>
						<td>
							<?php echo $this->Html->link( $invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4,[
							'controller'=>'Invoices','action' => 'gstConfirm',$invoice->id],array('target'=>'_blank')); ?>
						</td>
						<td><?php echo date("d-m-Y",strtotime($invoice->date_created)); ?></td>
						<td><?php echo $invoice->customer->customer_name.'('.$invoice->customer->alias.')'?></td>
						<td>
						<?php  if($invoice->invoice_rows[0]['igst_percentage']==14){
							 echo $invoice->grand_total;
							 $salesTotal12=$salesTotal12+$invoice->grand_total;
						}else{
							echo "-";
						}?>
						</td>
						<td>
							<?php  if($invoice->invoice_rows[0]['igst_percentage']==14){
										echo $invoice->total_igst_amount+$invoice->fright_igst_amount;
										$salesIgst12=$salesIgst12+($invoice->total_igst_amount+$invoice->fright_igst_amount);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
						<?php  if($invoice->invoice_rows[0]['igst_percentage']==15){
							 echo $invoice->grand_total;
							 $salesTotal18=$salesTotal18+$invoice->grand_total;
						}else{
							echo "-";
						}?>
						</td>
						<td>
							<?php  if($invoice->invoice_rows[0]['igst_percentage']==15){
										echo $invoice->total_igst_amount+$invoice->fright_igst_amount;
										$salesIgst18=$salesIgst18+($invoice->total_igst_amount+$invoice->fright_igst_amount);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
						<?php  if($invoice->invoice_rows[0]['igst_percentage']==16){
							 echo $invoice->grand_total;
							 $salesTotal28=$salesTotal28+$invoice->grand_total;
						}else{
							echo "-";
						}?>
						</td>
						<td>
							<?php  if($invoice->invoice_rows[0]['igst_percentage']==16){
										echo $invoice->total_igst_amount+$invoice->fright_igst_amount;
										$salesIgst28=$salesIgst28+($invoice->total_igst_amount+$invoice->fright_igst_amount);
								}else{
									echo "-";
								} ?>
						</td>

						
					</tr>
				<?php $i++; endforeach; ?>
				<tr>
					<td colspan="4"></td>
					<td align="right"><?php echo $this->Number->format($salesTotal12,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesIgst12,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesTotal18,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesIgst18,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesTotal28,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesIgst28,['places'=>2]); ?></td>
					
				</tr>
				</tbody>
				</table>
		
		
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<td colspan="11" align="center"  valign="top">
							<h4 class="caption-subject font-black-steel uppercase">Purchase</h4>
						</td>
					</tr>
					<tr>
						<th>Sr.No.</th>
						<th>Invoice Booking No</th>
						<th>Date</th>
						<th>Supplier</th>
						<th style="text-align:right;">Purchase @ 12 % GST</th>
						<th style="text-align:right;">GST @ 12 % </th>
						<th style="text-align:right;">Purchase @ 18 % GST</th>
						<th style="text-align:right;">GST @ 18 % </th>
						<th style="text-align:right;">Purchase @ 28 % GST</th>
						<th style="text-align:right;">GST @ 28 % </th>
					</tr>
				</thead>
				<?php  $salesGst12=0; $salesGst18=0; $salesGst28=0; $salesTotal12=0; $salesTotal18=0; $salesTotal28=0; $i=0;
				foreach ($invoiceBookings as $invoiceBooking):   ?>
				<tbody>
				<?php $cgstAmt=0; $sgstAmt=0; $igstAmt=0;  
					if(!empty($invoiceBooking->invoice_booking_rows)){  $i++;
						foreach($invoiceBooking->invoice_booking_rows as $invoice_booking_row)
						{ 
							$cgstAmt=$cgstAmt+$invoice_booking_row->cgst;
							$sgstAmt=$sgstAmt+$invoice_booking_row->sgst;
							$igstAmt=$igstAmt+$invoice_booking_row->igst;
						}
						
				?>
					<tr>
						<td><?php echo $i; ?></td>
						<td>
						<?php echo $this->Html->link( $invoiceBooking->ib1.'/IB-'.str_pad($invoiceBooking->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoiceBooking->ib3.'/'.$invoiceBooking->ib4,[
							'controller'=>'InvoiceBookings','action' => 'gst-invoice-booking-view',$invoiceBooking->id],array('target'=>'_blank')); ?>
						</td>
						<td><?php echo date("d-m-Y",strtotime($invoiceBooking->created_on)); ?></td>
						<td><?php echo $invoiceBooking->vendor->company_name; ?></td>
						<td>
						<?php  if($invoiceBooking->invoice_booking_rows[0]['cgst_per']==17 && $invoiceBooking->invoice_booking_rows[0]['sgst_per']==18){
							 echo $invoiceBooking->total;
							 $salesTotal12=$salesTotal12+$invoiceBooking->total;
						}else{
							echo "-";
						}?>
						</td>
						<td>
							<?php  if($invoiceBooking->invoice_booking_rows[0]['cgst_per']==17 && $invoiceBooking->invoice_booking_rows[0]['sgst_per']==18){
										echo $cgstAmt+$sgstAmt;
										$salesGst12=$salesGst12+($cgstAmt+$sgstAmt);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
						<?php  if($invoiceBooking->invoice_booking_rows[0]['cgst_per']==19 && $invoiceBooking->invoice_booking_rows[0]['sgst_per']==20){
							 echo $invoiceBooking->total;
							  $salesTotal18=$salesTotal18+$invoiceBooking->total;
						}else{
							echo "-";
						}?>
						</td>
						<td>
							<?php  if($invoiceBooking->invoice_booking_rows[0]['cgst_per']==19 && $invoiceBooking->invoice_booking_rows[0]['sgst_per']==20){
										echo $cgstAmt+$sgstAmt;
										$salesGst18=$salesGst18+($cgstAmt+$sgstAmt);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
						<?php  if($invoiceBooking->invoice_booking_rows[0]['cgst_per']==21 && $invoiceBooking->invoice_booking_rows[0]['sgst_per']==22){
							 echo $invoiceBooking->total;
							
							 $salesTotal28=$salesTotal28+$invoiceBooking->total;
						}else{
							echo "-";
						}?>
						</td>
						<td>
							<?php  if($invoiceBooking->invoice_booking_rows[0]['cgst_per']==21 && $invoiceBooking->invoice_booking_rows[0]['sgst_per']==22){
										echo $cgstAmt;
										$salesGst28=$salesGst28+($cgstAmt+$sgstAmt);
								}else{
									echo "-";
								} ?>
						</td>

						
					</tr>
				<?php }   endforeach; ?>
					<tr>
						<td colspan="4"></td>
						<td align="right"><?php echo $this->Number->format($salesTotal12,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesGst12,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotal18,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesGst18,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesTotal28,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($salesGst28,['places'=>2]); ?></td>
						
					</tr>
				</tbody>
				
				</table>
				
		
			
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<td colspan="11" align="center"  valign="top">
							<h4 class="caption-subject font-black-steel uppercase">Purchase Inter State</h4>
						</td>
					</tr>
					<tr>
						<th>Sr.No.</th>
						<th>Invoice Booking No</th>
						<th>Date</th>
						<th>Supplier</th>
						<th style="text-align:right;">Purchase @ 12 % IGST</th>
						<th style="text-align:right;">IGST @ 12 % </th>
						<th style="text-align:right;">Purchase @ 18 % IGST</th>
						<th style="text-align:right;">IGST @ 18 % </th>
						<th style="text-align:right;">Purchase @ 28 % IGST</th>
						<th style="text-align:right;">IGST @ 28 % </th>
					</tr>
				</thead>
				<?php $purchaseIgst12=0; $purchaseIgst18=0; $purchaseIgst28=0; $purchaseTotal12=0; $purchaseTotal18=0; $purchaseTotal28=0; $i=0; 
				foreach ($invoiceBookingsInterState as $invoiceBooking):   ?>
				<tbody>
				<?php $cgstAmt=0; $sgstAmt=0; $igstAmt=0; 
					if(!empty($invoiceBooking->invoice_booking_rows)){ $i++;
						foreach($invoiceBooking->invoice_booking_rows as $invoice_booking_row)
						{ 
							$cgstAmt=$cgstAmt+$invoice_booking_row->cgst;
							$sgstAmt=$sgstAmt+$invoice_booking_row->sgst;
							$igstAmt=$igstAmt+$invoice_booking_row->igst;
						}
				?>
					<tr>
						<td><?php echo $i; ?></td>
						<td>
						<?php echo $this->Html->link( $invoiceBooking->ib1.'/IB-'.str_pad($invoiceBooking->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoiceBooking->ib3.'/'.$invoiceBooking->ib4,[
							'controller'=>'InvoiceBookings','action' => 'gst-invoice-booking-view',$invoiceBooking->id],array('target'=>'_blank')); ?>
						</td>
						<td><?php echo date("d-m-Y",strtotime($invoiceBooking->created_on)); ?></td>
						<td><?php echo $invoiceBooking->vendor->company_name; ?></td>
						<td>
						<?php  if($invoiceBooking->invoice_booking_rows[0]['igst_per']==23){
							 echo $invoiceBooking->total;
							 $purchaseTotal12=$purchaseTotal12+$invoiceBooking->total;
						}else{
							echo "-";
						}?>
						</td>
						<td>
							<?php  if($invoiceBooking->invoice_booking_rows[0]['igst_per']==23){
										echo $igstAmt;
										$purchaseIgst12=$purchaseIgst12+($igstAmt);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
						<?php  if($invoiceBooking->invoice_booking_rows[0]['igst_per']==24){
							 echo $invoiceBooking->total;
							  $purchaseTotal18=$purchaseTotal18+$invoiceBooking->total;
						}else{
							echo "-";
						}?>
						</td>
						<td>
							<?php  if($invoiceBooking->invoice_booking_rows[0]['igst_per']==24){
										echo $igstAmt;
										$purchaseIgst18=$purchaseIgst18+($igstAmt);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
						<?php  if($invoiceBooking->invoice_booking_rows[0]['igst_per']==25){
							 echo $invoiceBooking->total;
							
							 $purchaseTotal28=$purchaseTotal28+$invoiceBooking->total;
						}else{
							echo "-";
						}?>
						</td>
						<td>
							<?php  if($invoiceBooking->invoice_booking_rows[0]['igst_per']==25){
										echo $igstAmt;
										$purchaseIgst28=$purchaseIgst28+($igstAmt);
								}else{
									echo "-";
								} ?>
						</td>

						
					</tr>
				<?php }  endforeach; ?>
					<tr>
						<td colspan="4"></td>
						<td align="right"><?php echo $this->Number->format($purchaseTotal12,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($purchaseIgst12,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($purchaseTotal18,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($purchaseIgst18,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($purchaseTotal28,['places'=>2]); ?></td>
						<td align="right"><?php echo $this->Number->format($purchaseIgst28,['places'=>2]); ?></td>
						
					</tr>
				</tbody>
				
				</table>
		
				
			</div>
		</div>
	</div>
</div>


<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>



<script>
$(document).ready(function() {

	$('select[name="item_category"]').on("change",function() { 
		$('#item_group_div').html('Loading...');
		var itemCategoryId=$('select[name="item_category"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'ItemGroups','action'=>'ItemGroupDropdown']); ?>";
		url=url+'/'+itemCategoryId,
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			$('#item_group_div').html(response);
			$('select[name="item_group_id"]').select2();
		});
	});	
	//////
	$('select[name="item_group_id"]').die().live("change",function() {
		$('#item_sub_group_div').html('Loading...');
		var itemGroupId=$('select[name="item_group_id"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'ItemSubGroups','action'=>'ItemSubGroupDropdown']); ?>";
		url=url+'/'+itemGroupId,
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			$('#item_sub_group_div').html(response);
			$('select[name="item_sub_group_id"]').select2();
		});
	});
});
</script>