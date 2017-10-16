<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Sales_Report_".$date.'_'.$time;

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
				<b>Sales Report
				<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));} ?></b>
			</td>
		</tr>
		<?php if(!empty($Employees)){ ?>
		<tr>
			<td colspan="3" align="left">
				<b>Sales Man - 
				<b><?php echo $Employees['name'] ?></b>
			</td>
			
		</tr>
		<?php } ?>
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
				<?php $i=1; foreach ($invoices as $invoice): ?>
					<tr>
						<td><?= h($i++) ?></td>
							<td><?= h(($invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4)) ?></td>
							<td><?php echo date("d-m-Y",strtotime($invoice->date_created)); ?></td>
							<td><?php echo $invoice->customer->customer_name.'('.$invoice->customer->alias.')'?></td>
							<td align="right"><?php if($invoice->sale_tax_per==5.50){
								echo number_format($invoice->total_after_pnf,2,'.',',');
								$sales5=$sales5+$invoice->total_after_pnf;
							}else{
								echo "-";
							} ?>
							</td>
							<td align="right"><?php if($invoice->sale_tax_per==5.50){
								echo number_format($invoice->sale_tax_amount,2,'.',',');
								$vat5=$vat5+$invoice->sale_tax_amount;
							}else{
								echo "-";
							} ?></td>
							<td align="right"><?php if($invoice->sale_tax_per==14.50){
								echo number_format($invoice->total_after_pnf,2,'.',',');
								$sales14=$sales14+$invoice->total_after_pnf;
							}else{
								echo "-";
							} ?>
							</td>
							<td align="right"><?php if($invoice->sale_tax_per==14.50){
								echo number_format($invoice->sale_tax_amount,2,'.',',');
								$vat14=$vat14+$invoice->sale_tax_amount;
							}else{
								echo "-";
							} ?></td>
							<td align="right"><?php if($invoice->sale_tax_per==2.00){
								echo number_format($invoice->total_after_pnf,2,'.',',');
								$sales2=$sales2+$invoice->total_after_pnf;
							}else{
								echo "-";
							} ?>
							</td>
							<td align="right"><?php if($invoice->sale_tax_per==2.00){
								echo number_format($invoice->sale_tax_amount,2,'.',',');
								$vat2=$vat2+$invoice->sale_tax_amount;
							}else{
								echo "-";
							} ?></td>
							<td align="right"><?php if($invoice->sale_tax_per==0.00){
								echo number_format($invoice->total_after_pnf,2,'.',',');
								$sales0=$sales0+$invoice->total_after_pnf;
							}else{
								echo "-";
							} ?></td>
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