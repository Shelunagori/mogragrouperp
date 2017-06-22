<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Sales Return Report</span>
		</div>
		<div class="actions">
			<?php $today =date('d-m-Y'); echo $this->Html->link('<i class="fa fa-puzzle-piece"></i> Sales Report',array('controller'=>'Invoices','action'=>'salesReport','From'=>$today,'To'=>$today),array('escape'=>false,'class'=>'btn btn-default')); ?>
			<?php echo $this->Html->link('Sales Return Report','/SaleReturns/salesReturnReport',array('escape'=>false,'class'=>'btn btn-primary')); ?>
			<?php echo $this->Html->link('Purchase Report','/InvoiceBookings/purchaseReport',array('escape'=>false,'class'=>'btn btn-default')); ?>
			<?php echo $this->Html->link('Purchase Return Report','/PurchaseReturns/purchaseReturnReport',array('escape'=>false,'class'=>'btn btn-default')); ?>
		</div>
	<div class="portlet-body form">
		<form method="GET" >
			<table class="table table-condensed" width="50%">
				<tbody>
					<tr>
						<td width="2%">
							<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" value="<?php echo @$From; ?>"  data-date-format="dd-mm-yyyy" >
						</td>	
						<td width="2%">
							<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" value="<?php echo @$To; ?>"  data-date-format="dd-mm-yyyy" >
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
						<th style="text-align:right;">Sales @ 5.50 %</th>
						<th style="text-align:right;">VAT @5.50 %</th>
						<th style="text-align:right;">Sales @ 14.50 %</th>
						<th style="text-align:right;">VAT @14.50 %</th>
						<th style="text-align:right;">2 % CST Sale</th>
						<th style="text-align:right;">CST @ 2 %</th>
						<th style="text-align:right;">Sale NIL Tax</th>
					</tr>
				</thead>
				<tbody><?php $sales5=0; $vat5=0; $sales14=0; $vat14=0; $sales2=0; $vat2=0; $sales0=0; ?>
				<?php foreach ($SaleReturns as $SaleReturn): ?>
					<tr>
						<td><?= h(++$page_no) ?></td>
						<td><?= h(($SaleReturn->sr1.'/IN-'.str_pad($SaleReturn->sr2, 3, '0', STR_PAD_LEFT).'/'.$SaleReturn->sr3.'/'.$SaleReturn->sr4)) ?></td>
						<td><?php echo date("d-m-Y",strtotime($SaleReturn->date_created)); ?></td>
						<td><?= h($SaleReturn->customer->customer_name) ?></td>
						<td align="right"><?php if($SaleReturn->sale_tax_per==5.50){
								echo number_format($SaleReturn->total,2,'.',',');
								$sales5=$sales5+$SaleReturn->total; 
							}else{
								echo "-";
							} ?>
						</td>
						<td align="right"><?php if($SaleReturn->sale_tax_per==5.50){
								echo  number_format($SaleReturn->sale_tax_amount,2,'.',',');
								$vat5=$vat5+$SaleReturn->sale_tax_amount;
							}else{
								echo "-";} ?>
						</td>
						<td align="right"><?php if($SaleReturn->sale_tax_per==14.50){
								echo number_format($SaleReturn->total,2,'.',','); 
								$sales14=$sales14+$SaleReturn->total;
							}else{
								echo "-";
							} ?>
						</td>
						<td align="right"><?php if($SaleReturn->sale_tax_per==14.50){
								echo number_format($SaleReturn->sale_tax_amount,2,'.',',');
								$vat14=$vat14+$SaleReturn->sale_tax_amount;
							}else{
								echo "-";} ?>
						</td>
						<td align="right"><?php if($SaleReturn->sale_tax_per==2.00){
								echo number_format($SaleReturn->total,2,'.',',');
								$sales2=$sales2+$SaleReturn->total;
							}else{
								echo "-";
							} ?>
						</td>
						<td align="right"><?php if($SaleReturn->sale_tax_per==2.00){
								echo number_format($SaleReturn->sale_tax_amount,2,'.',',');
								$vat2=$vat2+$SaleReturn->sale_tax_amount;
							}else{
								echo "-";} ?>
						</td>
						<td align="right"><?php if($SaleReturn->sale_tax_per==0.00){
								echo number_format($SaleReturn->total,2,'.',',');
								$sales0=$sales0+$SaleReturn->total;
							}else{
								echo "-";} ?>
						</td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="4" align="right">Total</td>
					<td align="right"><?php echo number_format($sales5,2,'.',','); ?></td>
					<td align="right"><?php echo number_format($vat5,2,'.',','); ?></td>
					<td align="right"><?php echo number_format($sales14,2,'.',','); ?></td>
					<td align="right"><?php echo number_format($vat14,2,'.',','); ?></td>
					<td align="right"><?php echo number_format($sales2,2,'.',','); ?></td>
					<td align="right"><?php echo number_format($vat2,2,'.',','); ?></td>
					<td align="right"><?php echo number_format($sales0,2,'.',','); ?></td>
				</tr>
				</tbody>
			</table>
		</div>
		
	</div>
	</div>
	</div>
		
	</div>
		<!-- END FORM-->
</div>

</div>