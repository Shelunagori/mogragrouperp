<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Purchase_report_".$date.'_'.$time;

	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );

?>
<table border='1'>
				<thead>
				<tr>
						<td colspan="10" align="center">
						<b> Purchase Report
						<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));} ?> </b>
						</td>
					</tr>
					<tr>
						<th>Sr.No.</th>
						<th>Invoice Book No</th>
						<th>Date</th>
						<th>Supplier</th>
						<th style="text-align:right;">Purchase @ 5.50 %</th>
						<th style="text-align:right;">VAT @5.50 %</th>
						<th style="text-align:right;">Purchase @ 14.50 %</th>
						<th style="text-align:right;">VAT @14.50 %</th>
						<th style="text-align:right;">Purchase @ 5.00 %</th>
						<th style="text-align:right;">VAT @5.00 %</th>
					</tr>
				</thead>
				<tbody><?php $i=1; $totalvat5=0; $totalvat14=0; $totalvat2=0; $total_purchase5=0; $total_purchase14=0; $total_purchase2=0; ?>
				<?php foreach ($InvoiceBookings as $InvoiceBooking):  
				if($InvoiceBooking->purchase_ledger_account != 35){ 
				?>
					<tr>
						<td><?= h($i++) ?></td>
							<td><?= h(($InvoiceBooking->ib1.'/IB-'.str_pad($InvoiceBooking->ib2, 3, '0', STR_PAD_LEFT).'/'.$InvoiceBooking->ib3.'/'.$InvoiceBooking->ib4)) ?></td>
							<td><?php echo date("d-m-Y",strtotime($InvoiceBooking->created_on)); ?></td>
							<td><?= h($InvoiceBooking->vendor->company_name) ?></td>
							<?php  $vat5=0;  $vat14=0; $vat2=0;  $purchase5=0;   $purchase14=0; $purchase2=0;  ?>
							<?php foreach($InvoiceBooking->invoice_booking_rows as $invoice_booking_row ) {?>
								<?php if($invoice_booking_row->sale_tax==5.00){
									$amount=$invoice_booking_row->unit_rate_from_po*$invoice_booking_row->quantity;
									$amount=$amount+$invoice_booking_row->misc;
									if($invoice_booking_row->discount_per==1){
										$amount=$amount*((100-$invoice_booking_row->discount)/100);
									}else{
										$amount=$amount-$invoice_booking_row->discount;
									}

									if($invoice_booking_row->pnf_per==1){
										$amount=$amount*((100+$invoice_booking_row->pnf)/100);
									}else{
										$amount=$amount+$invoice_booking_row->pnf;
									}
									$amount=$amount*((100+	$invoice_booking_row->excise_duty)/100);
									$amountofVAT=($amount*$invoice_booking_row->sale_tax)/100;
									$vat5=$vat5+$amountofVAT;
									$amount=$amount*((100+$invoice_booking_row->sale_tax)/100);
									
									$vat_amounts=$amountofVAT/$invoice_booking_row->quantity;
									
									$amount=$amount+$invoice_booking_row->other_charges; 
									$purchase5=$purchase5+$amount;
									$total_amt=$amount/$invoice_booking_row->quantity;
									
								}else if($invoice_booking_row->sale_tax==14.5){ 
									$amount=$invoice_booking_row->unit_rate_from_po*$invoice_booking_row->quantity;
									$amount=$amount+$invoice_booking_row->misc;
									if($invoice_booking_row->discount_per==1){
										$amount=$amount*((100-$invoice_booking_row->discount)/100);
									}else{
										$amount=$amount-$invoice_booking_row->discount;
									}

									if($invoice_booking_row->pnf_per==1){
										$amount=$amount*((100+$invoice_booking_row->pnf)/100);
									}else{
										$amount=$amount+$invoice_booking_row->pnf;
									}
									$amount=$amount*((100+	$invoice_booking_row->excise_duty)/100);
									$amountofVAT=($amount*$invoice_booking_row->sale_tax)/100;
									$vat14=$vat14+$amountofVAT;
									$amount=$amount*((100+$invoice_booking_row->sale_tax)/100);
									$vat_amounts=$amountofVAT/$invoice_booking_row->quantity;
									$amount=$amount+$invoice_booking_row->other_charges;  
									$purchase14=$purchase14+$amount;
									$total_amt=$amount/$invoice_booking_row->quantity;
									
								} else if($invoice_booking_row->sale_tax==5.50){ 
									$amount=$invoice_booking_row->unit_rate_from_po*$invoice_booking_row->quantity;
									$amount=$amount+$invoice_booking_row->misc;
									if($invoice_booking_row->discount_per==1){
										$amount=$amount*((100-$invoice_booking_row->discount)/100);
									}else{
										$amount=$amount-$invoice_booking_row->discount;
									}

									if($invoice_booking_row->pnf_per==1){
										$amount=$amount*((100+$invoice_booking_row->pnf)/100);
									}else{
										$amount=$amount+$invoice_booking_row->pnf;
									}
									$amount=$amount*((100+	$invoice_booking_row->excise_duty)/100);
									$amountofVAT=($amount*$invoice_booking_row->sale_tax)/100;
									$vat2=$vat2+$amountofVAT;
									$amount=$amount*((100+$invoice_booking_row->sale_tax)/100);
									$vat_amounts=$amountofVAT/$invoice_booking_row->quantity;
									$amount=$amount+$invoice_booking_row->other_charges; 
									 $purchase2=$purchase2+$amount;
									$total_amt=$amount/$invoice_booking_row->quantity;
									
								}
								?>
							<?php }?>
							<?php  ?>
							<td align="right"><?php if($purchase2 > 0){
								echo number_format($purchase2-$vat2,2,'.',',');
							}else{
								echo "-";
							} ?></td>
							<td align="right"><?php if($vat2 > 0){
								echo number_format($vat2,2,'.',',');
							}else{
								echo "-";
							} ?></td>
							<td align="right"><?php if($purchase14 > 0){
								echo number_format($purchase14-$vat14,2,'.',',');
							}else{
								echo "-";
							} ?></td>
							<td align="right"><?php if($vat14 > 0){
								echo number_format($vat14,2,'.',',');
							}else{
								echo "-";
							} ?>
							</td>
							<td align="right"><?php if($purchase5 > 0){
								echo number_format($purchase5-$vat5,2,'.',',');
							}else{
								echo "-";
							} ?></td>
							<td align="right"><?php if($vat5 > 0){
								echo number_format($vat5,2,'.',',');
							}else{
								echo "-";
							} ?>
							</td>
							
							
				</tr>
				<?php 	$totalvat5=$totalvat5+ $vat5;
						$total_purchase5=$total_purchase5+$purchase5;
						$totalvat14=$totalvat14+ $vat14;
						$total_purchase14=$total_purchase14+$purchase14;
						$totalvat2=$totalvat2+ $vat2;
						$total_purchase2=$total_purchase2+$purchase2;
						} ?>
						
				<?php endforeach; ?>
				<tr>
					<td colspan="4" align="right"><b>Total</b></td>
					<td align="right"><b><?php echo number_format($total_purchase2-$totalvat2,2,'.',','); ?></b></td>
					<td align="right"><b><?php echo number_format($totalvat2,2,'.',','); ?></b></td>
					<td align="right"><b><?php echo number_format($total_purchase14-$totalvat14,2,'.',','); ?></b></td>
					<td align="right"><b><?php echo number_format($totalvat14,2,'.',','); ?></b></td>
					<td align="right"><b><?php echo number_format($total_purchase5-$totalvat5,2,'.',','); ?></b></td>
					<td align="right"><b><?php echo number_format($totalvat5,2,'.',','); ?></b></td>
				</tr>
				</tbody>
			</table>