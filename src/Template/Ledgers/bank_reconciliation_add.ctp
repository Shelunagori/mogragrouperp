<?php if(empty(@$transaction_from_date)){
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
			
				@$opening_balance_total['debit']+=$Ledger->debit;
				@$opening_balance_total['credit']+=$Ledger->credit;			
			
			
			@$closing_balance_ar['debit']+=$Ledger->debit;
			@$closing_balance_ar['credit']+=$Ledger->credit;
			//pr($closing_balance_ar);
		}	
		
	}

?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Bank Reconciliation Add</span>
		</div>
		<div align="right">
			<?php $today =date('d-m-Y');
						echo $this->Html->link('<i class="fa fa-puzzle-piece"></i> Bank Reconcilation View',array('controller'=>'Ledgers','action'=>'bankReconciliationView','From'=>$today,'To'=>$today),array('escape'=>false)); ?>
		</div>
	
	
	<div class="portlet-body form">
	<form method="GET" >
				<table class="table table-condensed" >
				<tbody>
					<tr>
					<td>
						<div class="row">
							<div class="col-md-4">
									<?php echo $this->Form->input('ledger_account_id', ['empty'=>'--Select--','options' => @$banks,'empty' => "--Select Bank--",'label' => false,'class' => 'bank_data form-control input-sm select2me','required','value'=>@$ledger_account_id]); ?>
							</div>
							<div class="col-md-4">
								<?php echo $this->Form->input('From', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','value' => @date('01-04-Y', strtotime($from)),'data-date-start-date' => date("d-m-Y",strtotime($financial_year->date_from)),'data-date-end-date' => date("d-m-Y",strtotime($financial_year->date_to))]); ?>
								
							</div>
							<?php if(empty($To)){ ?>
							<div class="col-md-4">
								<?php echo $this->Form->input('	To', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','value' => @date('d-m-Y', strtotime($To)),'data-date-start-date' => date("d-m-Y",strtotime($financial_year->date_from)),'data-date-end-date' => date("d-m-Y",strtotime($financial_year->date_to))]); ?>
								
							</div>
							<?php }else{ ?>
							<div class="col-md-4">
							<?php echo $this->Form->input('To', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','value' => @$To,'data-date-start-date' => date("d-m-Y",strtotime($financial_year->date_from)),'data-date-end-date' => date("d-m-Y",strtotime($financial_year->date_to))]); ?>
								
							</div>	
							<?php } ?>
						</div>
					</td>
					<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
					</tr>
				</tbody>
			</table>
	</form>
	
		<!-- BEGIN FORM-->
<?php if(!empty($Bank_Ledgers)){  ?>
	<div class="row " id="hide_div">
		<div class="col-md-12">
			<div class="col-md-8"></div>	
			<div class="col-md-4 caption-subject " align="left" style="background-color:#E7E2CB; font-size: 16px;"><b>Opening Balance : 
				<?php 
						$opening_balance_data=0;
	
						if(!empty(@$opening_balance_ar)){  
							if(@$opening_balance_ar['debit'] > @$opening_balance_ar['credit']){ 
								$opening_balance_data=@$opening_balance_ar['debit'] - @$opening_balance_ar['credit'];
								echo $this->Number->format(@$opening_balance_data.'Dr',[ 'places' => 2]);	echo " Dr";
							}
							else { 
								$opening_balance_data=@$opening_balance_ar['credit'] - @$opening_balance_ar['debit'];
								echo $this->Number->format(@$opening_balance_data.'Cr',[ 'places' => 2]); echo " Cr";
							}					
						}
						else {   echo $this->Number->format('0',[ 'places' => 2]); }
						
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
						<th style="text-align:right;">Dr</th>
						<th style="text-align:right;">Cr</th>
						<th>Reconcilation Date</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
				
				$total_balance_acc=0; $total_debit=0; $total_credit=0;
				//pr($Bank_Ledgers->toArray()); exit;
				foreach($Bank_Ledgers as $ledger): 
				?>
				<tr class="main_tr">
						<td><?php echo date("d-m-Y",strtotime($ledger->transaction_date)); ?></td>
						<td><?= h($ledger->voucher_source); ?></td>
						
						<td align="right"><?= $this->Number->format($ledger->debit,[ 'places' => 2]); 
							$total_debit+=$ledger->debit; ?></td>
						<td align="right"><?= $this->Number->format($ledger->credit,[ 'places' => 2]); 
							$total_credit+=$ledger->credit; ?></td>
						<td>
						<?php if(empty($ledger->reconciliation_date)){  ?>
						
							<?php echo $this->Form->input('reconciliation_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker reconciliation_date','data-date-format' => 'dd-mm-yyyy','data-date-start-date' => date("d-m-Y",strtotime($financial_year->date_from)),'data-date-end-date' => date("d-m-Y",strtotime($financial_year->date_to)),'placeholder' => 'Reconcilation Date','ledger_id'=>$ledger->id,'required']); 
						}else{  ?>
							<?php echo $this->Form->input('reconciliation_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker reconciliation_date','data-date-format' => 'dd-mm-yyyy','data-date-start-date' => date("d-m-Y",strtotime($financial_year->date_from)),'data-date-end-date' => date("d-m-Y",strtotime($financial_year->date_to)),'placeholder' => 'Reconcilation Date','ledger_id'=>$ledger->id,'required','value'=>date('d-m-Y',strtotime($ledger->reconciliation_date))]); ?>
						<?php } ?></td>
						<td>
							<button type="button" ledger_id=<?php echo $ledger->id ?> class="btn btn-primary btn-sm subdate"><i class="fa fa-arrow-right" ></i></button>	
						</td>
				</tr>
				<?php  endforeach; ?>
				<tr>
					<td colspan="2" align="right">Total</td>
					<td align="right" ><?php echo $this->Number->format($total_debit,['places'=>2]) ;?> Dr</td>
					<td align="right" ><?php echo $this->Number->format($total_credit,['places'=>2]); ?> Cr</td>
					<td align="right" ></td>
					<td align="right" ></td>
				<tr>
				</tbody>
			</table>
			</div>
			<div class="col-md-12">
				<div class="col-md-8"></div>	
				<div class="col-md-4 caption-subject " align="left" style="background-color:#E3F2EE; font-size: 16px;"><b>Closing Balance:  </b>
				<?php 
				/////
				$close_dr=0;$close_cr=0;
				
						if((@$opening_balance_ar['debit'] > 0) || (@$opening_balance_ar['credit'] > 0)){  
							if(@$opening_balance_ar['debit'] > @$opening_balance_ar['credit']){
								
									 $close_dr=@$opening_balance_data-@$total_debit;
									 $close_cr=@$total_credit;
								
							}
							else if(@$opening_balance_ar['credit'] > @$opening_balance_ar['debit']){ 
							
								$close_cr=@$opening_balance_data-@$total_credit;
								$close_dr=@$total_debit;
							 
							}else if($opening_balance_ar['debit']== $opening_balance_ar['credit']){ 
								if(@$closing_balance_ar['debit'] > @$closing_balance_ar['credit']){   
								$close_dr=@$closing_balance_ar['debit'];
								$close_cr=@$closing_balance_ar['credit'];
								}else{
									$close_dr=@$closing_balance_ar['debit'];
									$close_cr=@$closing_balance_ar['credit'];
								}
							}
							}else if((@$opening_balance_ar['debit']== 0) && (@$opening_balance_ar['credit']== 0)){ 
								$close_dr=@$total_debit;
								$close_cr=@$total_credit;
								
							}else if($opening_balance_ar['debit']== $opening_balance_ar['credit']){ 
								if(@$closing_balance_ar['debit'] > @$closing_balance_ar['credit']){ 
								$close_dr=@$closing_balance_ar['debit'];
								$close_cr=@$closing_balance_ar['credit'];
								}else{
									$close_dr=@$closing_balance_ar['debit'];
									$close_cr=@$closing_balance_ar['credit'];
								}
							}
			
				///////
				
				$closing_balance=@$close_dr+@$close_cr;
					
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
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
	$('.subdate').die().click(function() { 
	var t=$(this);
		var ledger_id=$(this).attr('ledger_id');
		var reconciliation_date=$(this).closest('tr.main_tr').find('.reconciliation_date').val();
		if(reconciliation_date == ""){
			alert("Please Select Reconcilation Date");
		}else{
			var url="<?php echo $this->Url->build(['controller'=>'Ledgers','action'=>'dateUpdate']); ?>";
			url=url+'/'+ledger_id+'/'+reconciliation_date,
			$.ajax({
				url: url,
			}).done(function(response) { 
				t.closest("tr").hide();
				 window.location.reload(true);
			});
		}
		
    });
	
	$('.bank_data').die().live("change",function() { 
		$("#hide_div").hide();
	});

});
</script>
