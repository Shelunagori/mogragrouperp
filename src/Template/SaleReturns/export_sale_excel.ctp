<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Sales_Return_report_".$date.'_'.$time;

	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );

?>			
				<table border="1">
					<thead>
					<tr>
						<td colspan="11" align="center">
						<b> Sales Return Report
						<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));} ?> </b>
						</td>
					</tr>
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
				<tbody><?php $i=1; $sales5=0; $vat5=0; $sales14=0; $vat14=0; $sales2=0; $vat2=0; $sales0=0; ?>
				<?php foreach ($SaleReturns as $SaleReturn): ?>
					<tr>
						<td><?= h($i++) ?></td>
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
					<td colspan="4" align="right"><b>Total</b></td>
					<td align="right"><b><?php echo number_format($sales5,2,'.',','); ?></b></td>
					<td align="right"><b><?php echo number_format($vat5,2,'.',','); ?></b></td>
					<td align="right"><b><?php echo number_format($sales14,2,'.',','); ?></b></td>
					<td align="right"><b><?php echo number_format($vat14,2,'.',','); ?></b></td>
					<td align="right"><b><?php echo number_format($sales2,2,'.',','); ?></b></td>
					<td align="right"><b><?php echo number_format($vat2,2,'.',','); ?></b></td>
					<td align="right"><b><?php echo number_format($sales0,2,'.',','); ?></b></td>
				</tr>
				</tbody>
			</table>