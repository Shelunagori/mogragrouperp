<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Sales Report</span>
		</div>
		<div class="actions">
			
			<?php $today =date('d-m-Y'); echo $this->Html->link('<i class="fa fa-puzzle-piece"></i> Sales Report',array('controller'=>'Invoices','action'=>'salesReport','From'=>$today,'To'=>$today),array('escape'=>false,'class'=>'btn btn-primary')); ?>
			<?php echo $this->Html->link('Sales Return Report','/SaleReturns/salesReturnReport',array('escape'=>false,'class'=>'btn btn-default')); ?>
			<?php echo $this->Html->link('Purchase Report','/InvoiceBookings/purchaseReport',array('escape'=>false,'class'=>'btn btn-default')); ?>
			<?php echo $this->Html->link('Purchase Return Report','/PurchaseReturns/purchaseReturnReport',array('escape'=>false,'class'=>'btn btn-default')); ?>
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
						<td width="3%">
								<?php echo $this->Form->input('salesman_name', ['empty'=>'--SalesMans--','options' => $SalesMans,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'SalesMan Name','value'=> h(@$salesman_id) ]); ?>
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
		
		 <?php $page_no=$this->Paginator->current('Ledgers'); $page_no=($page_no-1)*20; ?>
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
				<tbody><?php $i=1; ?>
				<?php foreach ($invoices as $invoice): ?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?= h(($invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4)) ?></td>
							<td><?php echo date("d-m-Y",strtotime($invoice->date_created)); ?></td>
							<td><?php echo $invoice->customer->customer_name.'('.$invoice->customer->alias.')'?></td>
						<td>
							<?php  if($invoice->fright_cgst_percent==8 && $invoice->fright_sgst_percent==11){
										echo $invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount;
								}else{
									echo "-";
								} ?>
						</td>
						<td>
							<?php  if($invoice->fright_cgst_percent==9 && $invoice->fright_sgst_percent==12){
										echo $invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount;
								}else{
									echo "-";
								} ?>
						</td>
						<td>
							<?php  if($invoice->fright_cgst_percent==10 && $invoice->fright_sgst_percent==13){
										echo $invoice->total_cgst_amount+$invoice->total_sgst_amount+ $invoice->fright_cgst_amount+ $invoice->fright_sgst_amount;
								}else{
									echo "-";
								} ?>
						</td>
						<td>
							<?php  if($invoice->fright_igst_percent==14){
										echo $invoice->total_igst_amount+$invoice->fright_igst_amount;
								}else{
									echo "-";
								} ?>
						</td>
						<td>
							<?php  if($invoice->fright_igst_percent==15){
										echo $invoice->total_igst_amount+$invoice->fright_igst_amount;
								}else{
									echo "-";
								} ?>
						</td>
						<td>
							<?php  if($invoice->fright_igst_percent==16){
										echo $invoice->total_igst_amount+$invoice->fright_igst_amount;
								}else{
									echo "-";
								} ?>
						</td>
						
					</tr>
				<?php $i++; endforeach; ?>
				
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>