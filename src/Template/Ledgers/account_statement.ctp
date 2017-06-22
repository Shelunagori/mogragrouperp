<?php //pr($Ledgers->toArray());exit;
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

	$opening_balance_ar=[];
	$closing_balance_ar=[];
	if(!empty(@$Ledgers))
	{
		foreach($Ledgers as $Ledger)
		{
			if($Ledger->voucher_source == 'Opening Balance')
			{
				@$opening_balance_ar['debit']+=$Ledger->debit;
				@$opening_balance_ar['credit']+=$Ledger->credit;
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
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Account Statement</span>
		</div>
		
	
	
	<div class="portlet-body form">
	<form method="GET" >
				<table class="table table-condensed" >
				<tbody>
					<tr>
					<td>
						<div class="row">
							<div class="col-md-4">
									<?php echo $this->Form->input('ledger_account_id', ['empty'=>'--Select--','options' => $ledger,'empty' => "--Select Ledger Account--",'label' => false,'class' => 'form-control input-sm select2me','required','value'=>@$ledger_account_id]); ?>
							</div>
							<div class="col-md-4">
								<?php echo $this->Form->input('From', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','value' => @date('d-m-Y', strtotime($transaction_from_date)),'data-date-start-date' => date("d-m-Y",strtotime($financial_year->date_from)),'data-date-end-date' => date("d-m-Y",strtotime($financial_year->date_to))]); ?>
								
							</div>
							<div class="col-md-4">
								<?php echo $this->Form->input('To', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','value' => @date('d-m-Y', strtotime($transaction_from_date)),'data-date-start-date' => date("d-m-Y",strtotime($financial_year->date_from)),'data-date-end-date' => date("d-m-Y",strtotime($financial_year->date_to))]); ?>
							</div>
						</div>
					</td>
					<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
					</tr>
				</tbody>
			</table>
	</form>
		<!-- BEGIN FORM-->
<?php if(!empty($Ledger_Account_data)){  ?>
		<div class="row ">
			<div class="col-md-12">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<div class="col-md-12 " style="text-align:center; font-size: 20px;"><?php echo $Ledger_Account_data->name; ?></div>
					<div class="col-md-12" style="text-align:left; font-size: 16px;"> <?php echo $Ledger_Account_data->account_second_subgroup->account_first_subgroup->account_group->account_category->name; ?>->
					<?php echo $Ledger_Account_data->account_second_subgroup->account_first_subgroup->account_group->name; ?>->
					<?php echo $Ledger_Account_data->account_second_subgroup->account_first_subgroup->name; ?>->
					<?php echo $Ledger_Account_data->account_second_subgroup->name; ?></div>
				</div>
				<div class="col-md-3"></div>
			</div>
		</div><br/>


		<div class="row ">
		<div class="col-md-12">
			<div class="col-md-8"></div>	
			<div class="col-md-4 caption-subject " align="left" style="background-color:#E7E2CB; font-size: 16px;"><b>Opening Balance : 
				<?php 
						$opening_balance_ar=[];
						
						
						foreach($Ledgers as $Ledger)
						{
							if($Ledger->voucher_source == 'Opening Balance')
							{
								@$opening_balance_ar['debit']+=$Ledger->debit;
								@$opening_balance_ar['credit']+=$Ledger->credit;
							}
						}
						
						if(!empty(@$opening_balance_ar)){
						
							if(@$opening_balance_ar['debit'] > @$opening_balance_ar['credit']){
								echo $this->Number->format(@$opening_balance_ar['debit'].'Dr',[ 'places' => 2]);		
							}
							else{
								echo $this->Number->format(@$opening_balance_ar['credit'].'Cr',[ 'places' => 2]);
							}						
						
						}
						else { echo $this->Number->format('0',[ 'places' => 2]); }

						
				?>  
			</b>
			
			</div>
		</div>
		<div class="col-md-12">
				
		 
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Transaction Date</th>
						<th>Source</th>
						<th>Reference</th>
						<th style="text-align:right;">Dr</th>
						<th style="text-align:right;">Cr</th>
					</tr>
				</thead>
				<tbody>
				<?php  $total_balance_acc=0; $total_debit=0; $total_credit=0;
				foreach($Ledgers as $ledger): 
				$url_path="";
				if($ledger->voucher_source=="Journal Voucher"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad($Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/JournalVouchers/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Payment Voucher"){
					$Receipt=$url_link[$ledger->id];
					$voucher_no=h(str_pad($Receipt->voucher_no,4,'0',STR_PAD_LEFT));
					$url_path="/Payments/view/".$ledger->voucher_id;
				}else if($ledger->voucher_source=="Petty Cash Payment Voucher"){
					$Receipt=$url_link[$ledger->id];
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
				
				if($ledger->voucher_source != 'Opening Balance')	
				{
				?>
				<tr>
						<td><?php echo date("d-m-Y",strtotime($ledger->transaction_date)); ?></td>
						<td><?= h($ledger->voucher_source); ?></td>
						<td>
						
						<?php if(!empty($url_path)){
								echo $this->Html->link($voucher_no ,$url_path,['target' => '_blank']);
							}else{
								echo str_pad($ledger->voucher_id,4,'0',STR_PAD_LEFT);
							}
						
						?>
						</td>
						<td align="right"><?= $this->Number->format($ledger->debit,[ 'places' => 2]); 
							$total_debit+=$ledger->debit; ?></td>
						<td align="right"><?= $this->Number->format($ledger->credit,[ 'places' => 2]); 
							$total_credit+=$ledger->credit; ?></td>

				</tr>
				<?php } endforeach; ?>
				<tr>
					<td colspan="3" align="right">Total</td>
					<td align="right" ><?= number_format(@$opening_balance_total['debit'],2,'.',',') ;?> Dr</td>
					<td align="right" ><?= number_format(@$opening_balance_total['credit'],2,'.',',')?> Cr</td>
					
				<tr>
				</tbody>
			</table>
			</div>
			
			<div class="col-md-12">
				<div class="col-md-8"></div>	
				<div class="col-md-4 caption-subject " align="left" style="background-color:#E3F2EE; font-size: 16px;"><b>Closing Balance:- </b>
				<?php $closing_balance=@$closing_balance_ar['debit']-@$closing_balance_ar['credit'];
						echo $this->Number->format(abs($closing_balance),['places'=>2]);
						if($closing_balance>0){
							echo 'Dr';
						}else if($closing_balance <0){
							echo 'Cr';
						}
						
				?>
				</div>
			</div>
			
		</div>
<?php } ?>
</div></div>