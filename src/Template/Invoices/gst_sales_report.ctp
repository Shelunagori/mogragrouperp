<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Sales Report</span>
		</div>
		<div class="actions">
			
		</div>
		
	
	<div class="portlet-body form">
		<form method="GET" >
			<table width="50%" class="table table-condensed">
				<tbody>
					<tr>
						<td width="2%">
							<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" value="<?php echo @date('d-m-Y', strtotime($From));  ?>"  data-date-format="dd-mm-yyyy">
						</td>	
						<td width="2%">
							<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" value="<?php echo @date('d-m-Y', strtotime($To));  ?>"  data-date-format="dd-mm-yyyy" >
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
		
		<div style="text-align:center" class="col-md-12">
			<span  class="caption-subject font-blue-steel uppercase">Sales Invoice</span>
		</div>
		
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-hover">
				<thead>
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
				
		<div style="text-align:center" class="col-md-12">
			<span  class="caption-subject font-blue-steel uppercase">Sales Inter State</span>
		</div>
			
			<table class="table table-bordered table-striped table-hover">
				<thead>
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
					<td align="right"><?php echo $this->Number->format($salesGst12,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesTotal18,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesGst18,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesTotal28,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesGst28,['places'=>2]); ?></td>
					
				</tr>
				</tbody>
				</table>
		
		<div style="text-align:center" class="col-md-12">
			<span  class="caption-subject font-blue-steel uppercase">Purchase</span>
		</div>
			
			<table class="table table-bordered table-striped table-hover">
				<thead>
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
				<?php  $salesGst12=0; $salesGst18=0; $salesGst28=0; $salesTotal12=0; $salesTotal18=0; $salesTotal28=0; 
				foreach ($invoiceBookings as $invoiceBooking):   ?>
				<tbody>
				<?php $cgstAmt=0; $sgstAmt=0; $igstAmt=0;  $i=1;
					if(!empty($invoiceBooking->invoice_booking_rows)){
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
				<?php }  $i++;  endforeach; ?>
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
				
		<div style="text-align:center" class="col-md-12">
			<span  class="caption-subject font-blue-steel uppercase">Purchase</span>
		</div>
			
			<table class="table table-bordered table-striped table-hover">
				<thead>
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
				<?php $i=1; $salesGst12=0; $salesGst18=0; $salesGst28=0; $salesTotal12=0; $salesTotal18=0; $salesTotal28=0; 
				foreach ($invoiceBookings as $invoiceBooking):   ?>
				<tbody>
				<?php $cgstAmt=0; $sgstAmt=0; $igstAmt=0; 
					if(!empty($invoiceBooking->invoice_booking_rows)){
						foreach($invoiceBooking->invoice_booking_rows as $invoice_booking_row)
						{ 
							$cgstAmt=$cgstAmt+$invoice_booking_row->cgst;
							$sgstAmt=$sgstAmt+$invoice_booking_row->sgst;
							$igstAmt=$igstAmt+$invoice_booking_row->igst;
						}
				?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $invoiceBooking->ib1.'/IB-'.str_pad($invoiceBooking->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoiceBooking->ib3.'/'.$invoiceBooking->ib4; ?></td>
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
				<?php } $i++; endforeach; ?>
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
		
				
			</div>
		</div>
	</div>
</div>