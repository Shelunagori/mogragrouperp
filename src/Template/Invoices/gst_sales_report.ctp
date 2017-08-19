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
						<th style="text-align:right;">Sales @ 18 % GST</th>
						<th style="text-align:right;">Sales @ 28 % GST</th>
						<th style="text-align:right;">Sales @ 12 % IGST</th>
						<th style="text-align:right;">Sales @ 18 % IGST</th>
						<th style="text-align:right;">Sales @ 28 % IGST</th>
					</tr>
				</thead>
				<?php $i=1; $salesGst12=0; $salesGst18=0; $salesGst28=0; $salesIgst12=0; $salesIgst18=0; $salesIgst28=0; 
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
										echo $invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount;
										$salesGst12=$salesGst12+($invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount);
								}else{
									echo "-";
								} ?>
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
										echo $invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount;
										$salesGst28=$salesGst28+($invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount);
								}else{
									echo "-";
								} ?>
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
										echo $invoice->total_igst_amount+$invoice->fright_igst_amount;
										$salesIgst18=$salesIgst18+($invoice->total_igst_amount+$invoice->fright_igst_amount);
								}else{
									echo "-";
								} ?>
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
					<td align="right"><?php echo $this->Number->format($salesGst12,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesGst18,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesGst28,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesIgst12,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesIgst18,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesIgst28,['places'=>2]); ?></td>
				</tr>
				</tbody>
				</table>
				
		<div style="text-align:center" class="col-md-12">
			<span  class="caption-subject font-blue-steel uppercase">Sales Invoice</span>
		</div>
		
		<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Sr.No.</th>
						<th>Sales Order  No</th>
						<th>Date</th>
						<th>Customer</th>
						<th style="text-align:right;">Sales @ 12 % GST</th>
						<th style="text-align:right;">Sales @ 18 % GST</th>
						<th style="text-align:right;">Sales @ 28 % GST</th>
						<th style="text-align:right;">Sales @ 12 % IGST</th>
						<th style="text-align:right;">Sales @ 18 % IGST</th>
						<th style="text-align:right;">Sales @ 28 % IGST</th>
						<th style="text-align:right;">Expected Delivery Date</th>
					</tr>
				</thead>
				<?php $i=1; $salesGst12=0; $salesGst18=0; $salesGst28=0; $salesIgst12=0; $salesIgst18=0; $salesIgst28=0; 
				foreach ($SalesOrders as $SalesOrder):   ?>
				<tbody>
					<tr>
						<td><?php echo $i; ?></td>
						<td>
							<?php echo $this->Html->link( $SalesOrder->so1.'/SO-'.str_pad($SalesOrder->so2, 3, '0', STR_PAD_LEFT).'/'.$SalesOrder->so3.'/'.$SalesOrder->so4,[
							'controller'=>'SalesOrders','action' => 'gstConfirm',$SalesOrder->id],array('target'=>'_blank')); ?>
						</td>
						<td><?php echo date("d-m-Y",strtotime($SalesOrder->created_on)); ?></td>
						<td><?php echo $SalesOrder->customer->customer_name.'('.$SalesOrder->customer->alias.')'?></td>
						<td>
							<?php  if($SalesOrder->sales_order_rows[0]['cgst_per']==8 && $SalesOrder->sales_order_rows[0]['sgst_per']==11){
										echo $SalesOrder->total_cgst_value+$SalesOrder->total_sgst_value;
										$salesGst12=$salesGst12+($SalesOrder->total_cgst_value+$SalesOrder->total_sgst_value);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
							<?php  if($SalesOrder->sales_order_rows[0]['cgst_per']==9 && $SalesOrder->sales_order_rows[0]['sgst_per']==12){ 
										echo $SalesOrder->total_cgst_value+$SalesOrder->total_sgst_value;
										$salesGst18=$salesGst18+($SalesOrder->total_cgst_value+$SalesOrder->total_sgst_value);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
							<?php  if($SalesOrder->sales_order_rows[0]['cgst_per']==10 && $SalesOrder->sales_order_rows[0]['sgst_per']==13){
										echo $SalesOrder->total_cgst_value+$SalesOrder->total_sgst_value;
										$salesGst28=$salesGst28+($SalesOrder->total_cgst_value+$SalesOrder->total_sgst_value);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
							<?php  if($SalesOrder->sales_order_rows[0]['igst_per']==14){
										echo $SalesOrder->total_igst_value;
										$salesIgst12=$salesIgst12+($SalesOrder->total_igst_value);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
							<?php  if($SalesOrder->sales_order_rows[0]['igst_per']==15){
										echo $SalesOrder->total_igst_value;
										$salesIgst18=$salesIgst18+($SalesOrder->total_igst_value);
								}else{
									echo "-";
								} ?>
						</td>
						<td>
							<?php  if($SalesOrder->sales_order_rows[0]['igst_per']==16){
										echo $SalesOrder->total_igst_value;
										$salesIgst28=$salesIgst28+($SalesOrder->total_igst_value);
								}else{
									echo "-";
								} ?>
						</td>
						<td><?php echo date("d-m-Y",strtotime($SalesOrder->expected_delivery_date)); ?></td>
						
					</tr>
				<?php $i++; endforeach; ?>
				<tr>
					<td colspan="4"></td>
					<td align="right"><?php echo $this->Number->format($salesGst12,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesGst18,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesGst28,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesIgst12,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesIgst18,['places'=>2]); ?></td>
					<td align="right"><?php echo $this->Number->format($salesIgst28,['places'=>2]); ?></td>
					<td align="right"></td>
				</tr>
				</tbody>
				</table>
			
				
				
				
			</div>
		</div>
	</div>
</div>