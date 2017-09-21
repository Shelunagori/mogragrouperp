<?php $url_excel="/?".$url;?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Account Statement For Reference Balance</span>
		</div>
		<div class="actions">
			<?php echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Excel', '/Ledgers/Excel-Export-Account-Ref/'.$url_excel.'',['class' =>'btn btn-sm green tooltips','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>
		</div>
<div class="portlet-body form">
	<form method="GET" >
		<table class="table table-condensed" >
			<tbody>
				<tr>
					<td width="15%">
						<?php echo $this->Form->input('ledgerid', ['empty'=>'--Select--','options' => $ledger,'empty' => "--Select Ledger Account--",'label' => false,'class' => 'form-control input-sm input-medium  select2me','required','value'=>@$ledger_account_id]); ?>
						<?php echo $this->Form->input('status', ['type'=>'hidden','value'=>'Pending']); ?>
					</td>
					<td width="75%">
						<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
					</td>
					
				</tr>
			</tbody>
		</table>
	</form>
		<!-- BEGIN FORM-->
<?php if(!empty($Ledger_Account_data)){  ?>
		<div class="row ">
			<div class="col-md-12">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div class="col-md-12" style="text-align:center; font-size: 20px;">Statement of Account As on  <?php echo date('d-m-Y');?> of<div class="uppercase"><?php 
					if(!empty($Ledger_Account_data->alias)){
					echo $Ledger_Account_data->name.' ('.$Ledger_Account_data->alias.')'; }else{
						echo $Ledger_Account_data->name;
					}
					?></div></div>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div><br/>


		<div class="row ">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Reference</th>
						<th>Transaction Date</th>
						<th>Due Date</th>
						<th style="text-align:right;">Dr</th>
						<th style="text-align:right;">Cr</th>
					</tr>
				</thead>
				<tbody>
				<?php $total_debit=0; $total_credit=0; foreach($ReferenceBalances as $ReferenceBalance){  
					if($ReferenceBalance->credit != $ReferenceBalance->debit){
				?>
				
				<tr>
						<td><?php echo $ReferenceBalance->reference_no; ?></td>
						<td><?php echo (date('d-m-Y',strtotime($ReferenceBalance->transaction_date))); ?></td>
						<td><?php echo (date('d-m-Y',strtotime($ReferenceBalance->due_date))); ?></td>
						<td align="right"><?= $this->Number->format($ReferenceBalance->debit,[ 'places' => 2]); ?></td>
						<td align="right"><?= $this->Number->format($ReferenceBalance->credit,[ 'places' => 2]);  ?></td>
						<?php $total_debit+=$ReferenceBalance->debit;
							  $total_credit+=$ReferenceBalance->credit  ?>

				</tr>
				<?php } } ?>
				<tr>
					<td align="right" colspan="3">Total</td>
					<td align="right"><?= $this->Number->format($total_debit,[ 'places' => 2]); ?>Dr.</td>
					<td align="right"><?= $this->Number->format($total_credit,[ 'places' => 2]); ?>Cr.</td>
				</tr>
				<tr>
					<td  align="right" colspan="3">On Account</td>	
					<?php 
						$on_acc=0;
						$closing_balance=0;
						$on_dr=@$ledger_amt['Debit']-@$ref_amt['debit'];
						$on_cr=@$ledger_amt['Credit']-@$ref_amt['credit'];
						
						$on_acc=$on_dr-$on_cr;
						
						
						?>
					<?php if($on_acc >= 0){ 
					$closing_balance=($on_acc+$total_debit)-$total_credit;
					
					
					?>
								<td align="right"><?php echo $this->Number->format(abs($on_acc),['places'=>2]); ?>Dr.</td>	
								<td align="right">0 Cr.</td>
							<?php } else{ 
							$closing_balance=(abs($on_acc)+$total_credit)-abs($total_debit);
							?>
								<td align="right">0 Dr.</td>
								<td align="right"><?php echo $this->Number->format(abs($on_acc),['places'=>2]); ?>Cr.</td>
					
					<?php } ?>
				</tr>
				</tbody>
			</table>
			</div>
			
			<div class="col-md-12">
				<div class="col-md-8"></div>	
				<div class="col-md-4 caption-subject " align="left" style="background-color:#E3F2EE; font-size: 16px;"><b>Closing Balance:- </b>
				<?php if(($on_acc+$total_debit)>$total_credit){
					echo $this->Number->format(abs($closing_balance),['places'=>2]).'Dr.'; 
				}else{
					echo $this->Number->format(abs($closing_balance),['places'=>2]).'Cr.'; 
				}	
				?>
				</div>
			</div>
			
		</div>
<?php } ?>
</div></div>
</div>