<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Daily_report_".$date.'_'.$time;

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
							<td colspan="7" align="center">
								 Daily Report 
								<?php if(!empty($From) || !empty($To)){ echo date('d-m-Y',strtotime($From)); ?> TO <?php echo date('d-m-Y',strtotime($To));} ?>
							</td>
						</tr>
						<tr>
							<th>S. No.</th>
							<th>Transaction Date</th>
							<th>Ledger Account</th>
							<th>Source</th>
							<th>Reference</th>
							<th>Debit</th>
							<th>Credit</th>
							
						</tr>
					</thead>
					<tbody>
						<?php $i=0; foreach ($ledgers as $ledger): 
							if($ledger->voucher_source=="Journal Voucher"){
										$Receipt=$url_link[$ledger->id];
										$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
							}else if($ledger->voucher_source=="Payment Voucher"){
										$Receipt=$url_link[$ledger->id];
										$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
							}else if($ledger->voucher_source=="Petty Cash Payment Voucher"){
										$Receipt=$url_link[$ledger->id];
										$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
							}else if($ledger->voucher_source=="Contra Voucher"){
										$Receipt=$url_link[$ledger->id];
										$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
							}else if($ledger->voucher_source=="Receipt Voucher"){ 
										$Receipt=$url_link[$ledger->id];
										$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
							}else if($ledger->voucher_source=="Invoice"){ 
										$invoice=$url_link[$ledger->id];
										$voucher_no=h(($invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4));
							}else if($ledger->voucher_source=="Invoice Booking"){
										$invoice=$url_link[$ledger->id];
										$voucher_no=h(($invoice->ib1.'/IB-'.str_pad($invoice->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoice->ib3.'/'.$invoice->ib4));
							}else if($ledger->voucher_source=="Non Print Payment Voucher"){
										$Receipt=$url_link[$ledger->id];
										$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
							}else if($ledger->voucher_source=="Debit Note"){
										$Receipt=$url_link[$ledger->id];
										$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
							}else if($ledger->voucher_source=="Credit Note"){
										$Receipt=$url_link[$ledger->id];
										$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
							}else if($ledger->voucher_source=="Sale Return"){
										$invoice=$url_link[$ledger->id];
										$voucher_no=h(($invoice->sr1.'/SR-'.str_pad($invoice->sr2, 3, '0', STR_PAD_LEFT).'/'.$invoice->sr3.'/'.$invoice->sr4));
							}else if($ledger->voucher_source=="Inventory Return"){
										$Receipt=$url_link[$ledger->id];
										$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
							}else if($ledger->voucher_source=="Inventory Voucher"){
										$Receipt=$url_link[$ledger->id];
										$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
							}
					?>
						<tr>
						<td><?= h(++$i) ?></td>
						<td><?php echo date("d-m-Y",strtotime($ledger->transaction_date)); ?></td>
						<td><?php $name=""; if(empty($ledger->ledger_account->alias)){
							 echo $ledger->ledger_account->name;
							} else{
								 echo $ledger->ledger_account->name.'('; echo $ledger->ledger_account->alias.')'; 
							}?></td>
						<td><?= h($ledger->voucher_source); ?></td>
						<td>
						<?php echo @$voucher_no;?>
						</td>
						<td ><?= $this->Number->format($ledger->debit) ?></td>
						<td ><?= $this->Number->format($ledger->credit) ?></td>
				</tr>
				<?php endforeach; ?>
					</tbody>
				</table>
				
