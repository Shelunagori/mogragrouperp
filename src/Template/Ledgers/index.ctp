<?php 

		$url_excel="/?".$url; 
?>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Ledger Account</span>
		</div>
		<div class="pull-right"><p><?= $this->Paginator->counter() ?></p></div>

	<div class="portlet-body form">
	<div class="row ">
		<div class="col-md-12">
		<form method="GET" >
			<table class="table table-condensed">
				<tbody>
					<tr>
						<td width="20%">
							<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" value="<?php echo @$From; ?>"  data-date-format="dd-mm-yyyy" >
						</td>
						<td width="20%">
									<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" value="<?php echo @$To; ?>"  data-date-format="dd-mm-yyyy" >
						</td>
						<td>
							<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
						</td>
						<td width="5%"></td>
						<td width="5%"></td>
						<td width="5%"></td>
						<td width="12%"></td>
						<td><label>Page Number</label></td>
						<td> 
								<select class="form-control input-sm select2me" name='page'>
										<?= $this->Paginator->numbers(array('modulus'=>PHP_INT_MAX,'separator'=>'&nbsp;&nbsp;&nbsp;</b>|<b>&nbsp;&nbsp;&nbsp;')); ?>
									</select>
						</td>
						<td ><button type="submit" class="btn btn-primary btn-sm">Go</button></td>
						<td align="right">
						<?php echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Excel', '/Ledgers/Export-Excel/'.$url_excel.'',['class' =>'btn btn-sm green tooltips','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		
		
		<!-- BEGIN FORM-->
		<?php $page_no=$this->Paginator->current('Ledgers'); $page_no=($page_no-1)*20; ?>
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="10%">Transaction Date</th>
						<th width="10%">Ledger Account</th>
						<th width="10%">Source</th>
						<th width="10%">Reference</th>
						<th style="text-align:right;" width="5%">Debit</th>
						<th  style="text-align:right;" width="5%">Credit</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($ledgers as $ledger): 
				$url_path="";
				if($ledger->voucher_source=="Journal Voucher"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/JournalVouchers/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Payment Voucher"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/Payments/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Petty Cash Payment Voucher"){
					
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/PettyCashVouchers/view/".$ledger->voucher_id;
					
				}else if($ledger->voucher_source=="Contra Voucher"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/contra-vouchers/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Receipt Voucher"){ 
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/receipts/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Invoice"){ 
					$invoice=$url_link[$ledger->id];
					$voucher_no=h(($invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4));
					if($invoice->invoice_type=='GST'){
						$url_path="/invoices/gst-confirm/".$ledger->voucher_id;
					}else{
						$url_path="/invoices/confirm/".$ledger->voucher_id;
					}
					
				}else if($ledger->voucher_source=="Invoice Booking"){
					$invoice=$url_link[$ledger->id];
					$voucher_no=h(($invoice->ib1.'/IB-'.str_pad($invoice->ib2, 3, '0', STR_PAD_LEFT).'/'.$invoice->ib3.'/'.$invoice->ib4));
					$url_path="/invoice-bookings/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Non Print Payment Voucher"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/nppayments/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Debit Note"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/debit-notes/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Credit Note"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/credit-notes/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Purchase Return"){
					$url_path="/purchase-returns/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Sale Return"){
					$invoice=$url_link[$ledger->id];
					$voucher_no=h(($invoice->sr1.'/SR-'.str_pad($invoice->sr2, 3, '0', STR_PAD_LEFT).'/'.$invoice->sr3.'/'.$invoice->sr4));
					$url_path="/purchase-returns/view/".$ledger->voucher_id;
					$url_path="Sale Return";
					//pr($voucher_no); exit;
				}else if($ledger->voucher_source=="Inventory Return"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/rivs/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Inventory Voucher"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad(@$Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/Inventory/view/".$ledger->voucher_id;
				}
				
				?>
					<tr>
						<td><?php echo date("d-m-Y",strtotime($ledger->transaction_date)); ?></td>
						<td>
							<?php $name=""; if(empty($ledger->ledger_account->alias)){
							 echo $ledger->ledger_account->name;
							} else{
								 echo $ledger->ledger_account->name.'('; echo $ledger->ledger_account->alias.')'; 
							}?>
						</td>
						<td><?= h($ledger->voucher_source); ?></td>
						<td>
						
						<?php if($url_path=='Sale Return'){
								echo $voucher_no;
							}else if(!empty($url_path)){
								echo $this->Html->link(@$voucher_no ,$url_path,['target' => '_blank']);
							}else{
								echo str_pad($ledger->voucher_id,4,'0',STR_PAD_LEFT);
							}
						
						?>
						</td>
						<td align="right"><?= $this->Number->format($ledger->debit,['places'=>2]) ?></td>
						<td align="right"><?= $this->Number->format($ledger->credit,['places'=>2]) ?></td>
				</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			
		</div>
	</div>
  </div>
</div>
</div>