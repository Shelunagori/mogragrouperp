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
		<table border="1">
			<thead>
				
			</thead>
			<tbody>
			<tr>
					<td colspan="6" align="center">Account Statment For
					<?php $name=""; if(empty($ledger_acc_alias)){
					 echo $ledger_acc_name;
					} else{
						 echo $ledger_acc_name.'('; echo $ledger_acc_alias.')'; 
					}?>
			</tr>
				<tr>
					<td colspan="5" align="right">Opening Balance</td>
					<?php $open_bal=0; 
					if(@$opening_balance_ar['debit'] > @$opening_balance_ar['credit']){ 
					$open_bal=@$opening_balance_ar['debit']-@$opening_balance_ar['credit']; 
					}else{
					$open_bal=@$opening_balance_ar['credit']-@$opening_balance_ar['debit']; 	
					}?>
					<?php if(@$opening_balance_ar['debit'] > @$opening_balance_ar['credit']){ ?>
					<td><?php echo abs($open_bal); ?>Dr.</td>
					<?php } else{ ?>
					<td><?php echo abs($open_bal); ?>Cr.</td>
				<?php 	} ?>
				</tr>
				<?php $total_dr=0; $total_cr=0; $i=0; foreach ($ledgers as $ledger): 
								$url_path="";
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
					$url_path="/invoices/confirm/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Invoice Booking"){
					$invoice=$url_link[$ledger->id];
					$voucher_no=h(($invoice->ib1.'/IB-'.str_pad($invoice->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoice->ib3.'/'.$invoice->ib4));
					$url_path="/invoice-bookings/view/".$ledger->voucher_id;
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
					$url_path="/purchase-returns/view/".$ledger->voucher_id;
				}
				?>
					
					<tr>
						<td><?= h(++$i) ?></td>
						<td><?php echo date("d-m-Y",strtotime($ledger->transaction_date)); ?></td>
						<td><?= h($ledger->voucher_source); ?></td>
						<td>
						<?php echo ($voucher_no); ?>
						</td>
						<td ><?= $this->Number->format($ledger->debit) ?></td>
						<td ><?= $this->Number->format($ledger->credit) ?></td>
						<?php 
						if($ledger->credit == 0){
							$total_dr=$total_dr+$ledger->debit;
						}else{
							$total_cr=$total_cr+$ledger->credit;
						}
						?>
					</tr>
			
			<?php endforeach; ?>
					<tr>
						<td colspan="4" align="right">Total</td>
						<td><?php echo $total_dr; ?>Dr</td>
						<td><?php echo $total_cr; ?>Cr</td>
					</tr>
					<tr>
						<td colspan="5" align="right">Closing Balance</td>
							<?php $close_bal=0;
							if(@$opening_balance_ar['debit'] > @$opening_balance_ar['credit']){ 
							$close_bal=@$open_bal+$total_dr-@$total_cr;  ?>
						<td><?php echo abs($close_bal); ?>Dr.</td>
						<?php } else{ 
							$close_bal=@$open_bal+$total_cr-@$total_dr; ?>
						<td><?php echo abs($close_bal); ?>Cr.</td>
						<?php 	}
					?>
					
					</tr>
			</tbody>
		</table>
				
