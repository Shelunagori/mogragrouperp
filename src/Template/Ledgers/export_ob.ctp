<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Accountant_statement_".$date.'_'.$time;

	  header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );  

?>		

<?php
	if(empty(@$transaction_from_date)){
			$transaction_from_date=" ";
		}else{
			$transaction_from_date=$transaction_from_date;
		} 

		if(empty($transaction_to_date)){
			$transaction_to_date=" ";
		}else{
			$transaction_to_date=$transaction_to_date;
		}
	$opening_balance_ar1=[];
	$closing_balance_ar=[];
	if(!empty(@$Ledgers))
	{
		foreach($Ledgers as $Ledger)
		{
			if($Ledger->voucher_source == 'Opening Balance')
			{
				@$opening_balance_ar1['debit']+=$Ledger->debit;
				@$opening_balance_ar1['credit']+=$Ledger->credit;
			}
			else
			{
				@$opening_balance_total['debit']+=$Ledger->debit;
				@$opening_balance_total['credit']+=$Ledger->credit;			
			}
			
			@$closing_balance_ar['debit']+=$Ledger->debit;
			@$closing_balance_ar['credit']+=$Ledger->credit;
		}	
		
	}

?>	
		<table border="1">
			<thead>
			<tr>
					<td colspan="12" align="center">Account Statment For
					<?php if(!empty(@$Ledger_Account_data->alias)){ echo @$Ledger_Account_data->name.'('.@$Ledger_Account_data->alias.')';
					}else{ echo @$Ledger_Account_data->name; }?>
					<?php if(!empty($from) || !empty($To)){ echo date('d-m-Y',strtotime($from)); ?> TO <?php echo date('d-m-Y',strtotime($To));} ?>
			</tr>
			<tr>
					<td colspan="11" align="right">Opening Balance</td>
					<td><?php 
						$opening_balance_data=0;;
						if(!empty(@$opening_balance_ar)){
							if(@$opening_balance_ar['debit'] > @$opening_balance_ar['credit']){
								$opening_balance_data=@$opening_balance_ar['debit'] - @$opening_balance_ar['credit'];
								echo $this->Number->format(@$opening_balance_data.'Dr',[ 'places' => 2]);	echo " Dr";
							}
							else{
								$opening_balance_data=@$opening_balance_ar['credit'] - @$opening_balance_ar['debit'];
								echo $this->Number->format(@$opening_balance_data.'Cr',[ 'places' => 2]); echo " Cr";
							}						
						}
						else {   echo $this->Number->format('0',[ 'places' => 2]); }
						$close_dr=0;
						$close_cr=0;
						if((@$opening_balance_ar['debit'] > 0) || (@$opening_balance_ar['credit'] > 0)){   
							if(@$opening_balance_ar['debit'] > @$opening_balance_ar['credit']){
								$close_dr=@$opening_balance_data+@$opening_balance_total['debit'];
								$close_cr=@$opening_balance_total['credit'];
							}
							else if(@$opening_balance_ar['credit'] > @$opening_balance_ar['debit']){
								$close_cr=@$opening_balance_data+@$opening_balance_total['credit'];
								$close_dr=@$opening_balance_total['debit'];
							}
						}else if((@$opening_balance_ar['debit']== 0) && (@$opening_balance_ar['credit']== 0)){ 
								$close_dr=@$opening_balance_total['debit'];
								$close_cr=@$opening_balance_total['credit'];
								
							}	
						
				?>  
			</td>
				</tr>
				<tr>
						<th>Transaction Date</th>
						<th>Source</th>
						<th>Reference</th>
						<th>Party</th>
						<th>TIN</th>
						<th>VAT</th>
						<th>CGST</th>
						<th>SGST</th>
						<th>IGST</th>
						<th>Total</th>
						<th style="text-align:right;">Dr</th>
						<th style="text-align:right;">Cr</th>
					</tr>
			</thead>
			<tbody>
			
				
				
					
					<?php  $total_balance_acc=0; $total_debit=0; $total_credit=0;
				foreach($Ledgers as $ledger): 
				$url_path="";
				$cgst_amt=0;
				$sgst_amt=0;
				$igst_amt=0;
				if($ledger->voucher_source=="Journal Voucher"){
					$Receipt=$url_link[$ledger->id];
					//pr($Receipt->voucher_no); 
					$voucher_no=h(str_pad($Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/JournalVouchers/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Payment Voucher"){
					$Receipt=$url_link[$ledger->id];
					//pr($Receipt->voucher_no);exit;
					$voucher_no=h(str_pad($Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/Payments/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Petty Cash Payment Voucher"){
					$Receipt=$url_link[$ledger->id];
					//pr($url_link[$ledger->id]);exit;
					$voucher_no=h(str_pad($Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/petty-cash-vouchers/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Contra Voucher"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad($Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/contra-vouchers/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Receipt Voucher"){ 
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad($Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/receipts/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Invoice"){ 
					$invoice=$url_link[$ledger->id];
					$voucher_no=h(($invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4));
					if($invoice->invoice_type=="GST"){
					$url_path="/invoices/gst-confirm/".$ledger->voucher_id;	
					}else{
					$url_path="/invoices/confirm/".$ledger->voucher_id;
					}
					if($invoice->invoice_type=="GST"){
						$cgst_amt=$invoice->total_cgst_amount;
						$sgst_amt=$invoice->total_sgst_amount;
						$igst_amt=$invoice->total_igst_amount;
						
					}else{
						$cgst_amt="-";
						$sgst_amt="-";
						$igst_amt="-";
					}
					
					
				}else if($ledger->voucher_source=="Invoice Booking"){
					$ibs=$url_link[$ledger->id];
					//pr($ibs); exit;
					$voucher_no=h(($ibs->ib1.'/IB-'.str_pad($ibs->ib2, 3, '0', STR_PAD_LEFT).'/'.$ibs->ib3.'/'.$ibs->ib4));
					if($ibs->gst=="yes"){
					$url_path="/invoice-bookings/gst-invoice-booking-view/".$ledger->voucher_id;	
					}else{
					$url_path="/invoice-bookings/view/".$ledger->voucher_id;
					}
					
					//$url_path="/invoice-bookings/view/".$ledger->voucher_id;
					if($ibs->gst=="yes"){ 
						foreach($ibs->invoice_booking_rows as $ibr)
						{ 
							$cgst_amt=$cgst_amt+$ibr->cgst;
							$sgst_amt=$sgst_amt+$ibr->sgst;
							$igst_amt=$igst_amt+$ibr->igst;
						}
					}else{
							$cgst_amt="-";
							$sgst_amt="-";
							$igst_amt="-";
					}
				}else if($ledger->voucher_source=="Non Print Payment Voucher"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad($Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/nppayments/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Debit Note"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad($Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/debit-notes/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Credit Note"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad($Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/credit-notes/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Purchase Return"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad($Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/purchase-returns/view/".$ledger->voucher_id;
				}
				
				if($ledger->voucher_source != 'Opening Balance')	
				{
				?>
				<tr>
						<td><?php echo date("d-m-Y",strtotime($ledger->transaction_date)); ?></td>
						<td><?= h($ledger->voucher_source); ?></td>
						<td>
						
						<?php if(!empty($url_path)){
								echo $voucher_no ;
							}else{
								echo str_pad($ledger->voucher_id,4,'0',STR_PAD_LEFT);
							}
						?>
						</td>
						<td>
							<?php if($ledger->voucher_source=="Invoice"){ ?>
								<?php echo $url_link[$ledger->id]->customer->customer_name.' '.$url_link[$ledger->id]->customer->alias; ?>
							<?php }elseif($ledger->voucher_source=="Invoice Booking"){ ?>
								<?php echo $url_link[$ledger->id]->vendor->company_name; ?>
							<?php } ?>
						</td>
						<td>
							<?php if($ledger->voucher_source=="Invoice"){ ?>
								<?php echo $url_link[$ledger->id]->customer->tin_no; ?>
							<?php }elseif($ledger->voucher_source=="Invoice Booking"){ ?>
								<?php echo $url_link[$ledger->id]->vendor->tin_no; ?>
							<?php } ?>
						</td>
						<td align="right">
							<?php if($ledger->voucher_source=="Invoice"){ ?>cst_vat
								<?php echo @$url_link[$ledger->id]->sale_tax->invoice_description; ?>
							<?php }elseif($ledger->voucher_source=="Invoice Booking"){ ?>
								<?php //echo $url_link[$ledger->id]->cst_vat;
								if($url_link[$ledger->id]->cst_vat=="VAT"){
										echo $this->Number->format($url_link[$ledger->id]->total_saletax,[ 'places' => 2]); 
									}else{
										echo "-";
									}
							 } ?>
						</td>
						<td align="right"><?= $this->Number->format($cgst_amt,[ 'places' => 2]); ?></td>
						<td align="right"><?= $this->Number->format($sgst_amt,[ 'places' => 2]); ?></td>
						<td align="right"><?= $this->Number->format($igst_amt,[ 'places' => 2]); ?></td>
						<?php if($ledger->voucher_source=="Invoice Booking"){ ?>
						<td align="right"><?= $this->Number->format($url_link[$ledger->id]->total,[ 'places' => 2]); ?></td>
						 <?php }else{ ?>
						 <td><?php echo "-"; ?></td>
						 <?php } ?>
						<td align="right"><?= $this->Number->format($ledger->debit,[ 'places' => 2]); 
							$total_debit+=$ledger->debit; ?></td>
						<td align="right"><?= $this->Number->format($ledger->credit,[ 'places' => 2]); 
							$total_credit+=$ledger->credit; ?></td>

				</tr>
				<?php } endforeach; ?>
				<tr>
					<td colspan="10" align="right">Total</td>
					<td align="right" ><?= number_format(@$opening_balance_total['debit'],2,'.',',') ;?> Dr</td>
					<td align="right" ><?= number_format(@$opening_balance_total['credit'],2,'.',',')?> Cr</td>
					
				<tr>
				<tr>
					<td colspan="11" align="right">Closing Balance</td>
					<td><?php 
				 
				$closing_balance=@$close_dr-@$close_cr;
					
						echo $this->Number->format(abs($closing_balance),['places'=>2]);
						if($closing_balance>0){
							echo 'Dr';
						}else if($closing_balance <0){
							echo 'Cr';
						}
						
				?></td>
				</tr>
				</tbody>
		</table>
				
