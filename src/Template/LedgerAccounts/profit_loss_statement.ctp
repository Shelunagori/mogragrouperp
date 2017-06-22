<?php //pr($Ledgers_Assets); exit; ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>Profit & Loss Statement
				</div>
			</div>
			<div class="portlet-body">
				<form method="get">
					
						<div class="row">
							<div class="col-md-3">
								<input type="text" name="date" class="form-control date-picker from_date" placeholder="From Date" data-date-format='dd-mm-yyyy' data-date-end-date='0d' value="<?php  echo $date; ?>">
							</div>
							<div class="col-md-3">
								<input type="text" name="to_date" class="form-control date-picker to_date" placeholder="To Date" data-date-format='dd-mm-yyyy' data-date-end-date='0d' value="<?php  echo $to_date; ?>">
							</div>
							<div class="col-md-3">
								<span class="input-group-btn">
								<button class="btn blue" type="submit">Go</button>
								</span>
							</div>	
						</div>
					
				</form>
				<?php if($date){ ?>
				<div class="row">
					<div class="col-md-6">
						<div align="center"><h4>Expense</h4></div>
						<table id="main_tble"  class="table table-condensed table-hover">
							<tbody class="main_tbody">
							<?php
							usort($Expense_groups, function ($a, $b) {
								return $a['sequence'] - $b['sequence'];
							});
							$Total_Liablities=0; $Total_exp_Dr=0; $Total_exp_Cr=0; 
							foreach($Expense_groups as $Expense_group){ 
			
							$Total_Liablities+=$Expense_group['debit']-$Expense_group['credit']; ?>
								<tr group_id=<?php  echo $Expense_group['group_id'] ?> class="main_tr">
									<td> 
									<a href='#' role='button' status='close' class="group_name" group_id='<?php echo $Expense_group['group_id']; ?>' style='color:black;'>
									<?= h($Expense_group['name']) ?>
									</a> 
									</td>
									<?php if($Expense_group['debit'] > $Expense_group['credit']){?>
										<td style=" text-align: right; "><?= h(
										$this->Number->format($Expense_group['debit']-$Expense_group['credit'],['places'=>2])); echo "Dr" ;
										$Total_exp_Dr+=$Expense_group['debit']-$Expense_group['credit']; 
										?></td>
									<?php } else { ?>
											
										<td style=" text-align: right; "><?= h($this->Number->format(abs($Expense_group['debit']-$Expense_group['credit']),['places'=>2])); echo "Cr" ;
										$Total_exp_Cr+=$Expense_group['debit']-$Expense_group['credit']; 
										?></td>
									<?php } ?>
								</tr>
							<?php } ?>
								<?php $Total_exp_Dr= abs($Total_exp_Dr);  $Total_exp_Cr= abs($Total_exp_Cr); ?>
								<tr>
									<th>Total Expense</th>
									<?php  if($Total_exp_Dr>$Total_exp_Cr){ 
										$Total_Liablities=abs($Total_exp_Dr)-abs($Total_exp_Cr);?>
										<th style=" text-align: right; "><?= h ($this->Number->format(abs($Total_Liablities),['places'=>2])); ?>Dr</th>
									<?php } else if($Total_exp_Dr<$Total_exp_Cr) { 
										$Total_Liablities=abs($Total_exp_Dr)-abs($Total_exp_Cr); ?>
										<th style=" text-align: right; "><?= h($this->Number->format(abs($Total_Liablities),['places'=>2])); ?>Cr</th>
									<?php } else { ?>
									<th style=" text-align: right; "><?php echo $this->Number->format("0",['places'=>2]); ?></th>
									<?php } ?>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-6">
						<div align="center"><h4>Income</h4></div>
						<table id="main_tble1"  class="table table-condensed">
							<tbody class="main_tbody1">
							<?php 
							usort($Income_groups, function ($a, $b) {
								return $a['sequence'] - $b['sequence'];
							});
							$Total_Assets=0; $Total_Dr=0; $Total_Cr=0;
							foreach($Income_groups as $Income_group){ 
							$Total_Assets+=$Income_group['debit']-$Income_group['credit']; ?>
								<tr group_id=<?php  echo $Income_group['group_id'] ?> class="main_tr1">
									<td>
									<a href="#" role='button' status='close' class="group_name" group_id='<?php  echo $Income_group['group_id']; ?>' style='color:black;'>
											<?= h($Income_group['name']) ?>
															 </a>  
									</td>
									<?php if($Income_group['debit'] > $Income_group['credit']){?>
										<td style=" text-align: right; "><?= h($this->Number->format($Income_group['debit']-$Income_group['credit'],['places'=>2])); echo "Dr" ;
										$Total_Dr+=$Income_group['debit']-$Income_group['credit']; 
										?></td>
									<?php } else { ?>
											
										<td style=" text-align: right; "><?= h($this->Number->format(abs($Income_group['debit']-$Income_group['credit']),['places'=>2])); echo "Cr" ;
										$Total_Cr+=$Income_group['debit']-$Income_group['credit']; 
										?></td>
									<?php } ?>
								</tr>
							<?php } ?>
								<?php $Total_Dr= abs($Total_Dr); ?>
								<?php $Total_Cr= abs($Total_Cr); ?>
								
								<tr>
									<th>Total Income</th>
									<?php  if($Total_Dr>$Total_Cr){ $Total_Assets=abs($Total_Dr)-abs($Total_Cr);  ?>
										<th style=" text-align: right; "><?= h($this->Number->format(abs($Total_Assets),['places'=>2])); ?>Dr</th>
									<?php } else if($Total_Dr<$Total_Cr) { $Total_Assets=abs($Total_Dr)-abs($Total_Cr); ?>
										<th style=" text-align: right; "><?= h($this->Number->format(abs($Total_Assets),['places'=>2])); ?>Cr</th>
									<?php } else { ?>
									<th style=" text-align: right; "><?php echo $this->Number->format('0',['places'=>2]) ?></th>
									<?php } ?>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
$('tbody.main_tbody').sortable();	
$(document).ready(function() { 
	var isDragging = false;
	$("tr.main_tr").mousedown(function() {
		isDragging = false;
	}).mousemove(function() {
		isDragging = true;
	}).mouseup(function() {
		var wasDragging = isDragging;
		var rowCount = $("#main_tble > tbody > tr.main_tr").length;
		var abc=[];
		var k=0;
	setTimeout(
		function(){
			$(".main_tr").each(function(){ 
			k++;
			var group_id=$(this).attr("group_id");
      
            abc.push({[group_id]:k});
		});
		
	}, 1000);
    
	setTimeout( function(){	 
		myJSON = JSON.stringify(abc);
		var url="<?php echo $this->Url->build(['controller'=>'LedgerAccounts','action'=>'updateSequence']); ?>";
		url=url+'?AccountGroup='+myJSON;
        $.ajax({
		url: url,
		type: 'GET',
		dataType: 'text'
		}).done(function(response) {});
		}, 2000);

		isDragging = false;
		if (!wasDragging) {
		$("#throbble").toggle();
		}
	});

	$("ul").sortable();
});
</script>


<script type="text/javascript">
$('tbody.main_tbody1').sortable();	
$(document).ready(function() {
	var isDragging = false;
	$("tr.main_tr1").mousedown(function() {
		isDragging = false;
	}).mousemove(function() {
		isDragging = true;
	}).mouseup(function() {
		var wasDragging = isDragging;
		var rowCount = $("#main_tble1 > tbody > tr.main_tr1").length;
		var abc=[];
		var k=0;
	setTimeout(
		function(){
			$(".main_tr1").each(function(){ 
			k++;
			var group_id=$(this).attr("group_id");
      
            abc.push({[group_id]:k});
		});
		
	}, 1000);
    
	setTimeout( function(){	 
		myJSON = JSON.stringify(abc);
		var url="<?php echo $this->Url->build(['controller'=>'LedgerAccounts','action'=>'updateSequence']); ?>";
		url=url+'?AccountGroup='+myJSON;
        $.ajax({
		url: url,
		type: 'GET',
		dataType: 'text'
		}).done(function(response) {});
		}, 2000);

		isDragging = false;
		if (!wasDragging) {
		$("#throbble").toggle();
		}
	});

	$("ul").sortable();
});
</script>


<script>
$(document).ready(function() {
	$(".group_name").die().live('click',function(e){
	   var current_obj=$(this);
	   var group_id=$(this).attr('group_id');
	  
	  if(current_obj.attr('status') == 'open')
	   {
			$('tr.row_for_'+group_id+'').remove();
			current_obj.attr('status','close');
		   $('table > tbody > tr > td> a').removeClass("group_a");
		   $('table > tbody > tr > td> span').removeClass("group_a");

		}
	   else
	   {  
		   var from_date = $('.from_date').val();
		   var to_date = $('.to_date').val();
		   
		   var url="<?php echo $this->Url->build(['controller'=>'LedgerAccounts','action'=>'firstSubGroupsPnl']); ?>";
		   url=url+'/'+group_id +'/'+from_date+'/'+to_date,
			$.ajax({
				url: url,
			}).done(function(response) {
				current_obj.attr('status','open');
				 current_obj.addClass("group_a");
				current_obj.closest('tr').find('span').addClass("group_a");
				$('<tr class="append_tr row_for_'+group_id+'"><td colspan="2">'+response+'</td></tr>').insertAfter(current_obj.closest('tr'));
			});			   
		}   
	});	 

	
	$(".first_grp_name").die().live('click',function(e){ 
	   var current_obj=$(this);
	   var first_grp_id=$(this).attr('first_grp_id');
	  
	  if(current_obj.attr('status') == 'open')
	   {
			$('tr.row_for_'+first_grp_id+'').remove();
			current_obj.attr('status','close');
		   $('table > tbody > tr > td> a').removeClass("group_a");
		   $('table > tbody > tr > td> span').removeClass("group_a");

		}
	   else
	   {  
		   var from_date = $('.from_date').val();
		   var to_date = $('.to_date').val();
		   var url="<?php echo $this->Url->build(['controller'=>'LedgerAccounts','action'=>'secondSubGroupsPnl']); ?>";
		   url=url+'/'+first_grp_id +'/'+from_date+'/'+to_date,
			$.ajax({
				url: url,
			}).done(function(response) {
				current_obj.attr('status','open');
				 current_obj.addClass("group_a");
				current_obj.closest('tr').find('span').addClass("group_a");
				$('<tr class="append_tr row_for_'+first_grp_id+'"><td colspan="2">'+response+'</td></tr>').insertAfter(current_obj.closest('tr'));
			});			   
		}   
	});	
	$(".second_grp_name").die().live('click',function(e){ 
	   var current_obj=$(this);
	   var second_grp_id=$(this).attr('second_grp_id');
	  
	  if(current_obj.attr('status') == 'open')
	   {
			$('tr.row_for_'+second_grp_id+'').remove();
			current_obj.attr('status','close');
		   $('table > tbody > tr > td> a').removeClass("group_a");
		   $('table > tbody > tr > td> span').removeClass("group_a");

		}
	   else
	   {  
		   var from_date = $('.from_date').val();
		   var to_date = $('.to_date').val();
		   var url="<?php echo $this->Url->build(['controller'=>'LedgerAccounts','action'=>'ledgerAccountDataPnl']); ?>";
		   url=url+'/'+second_grp_id +'/'+from_date+'/'+to_date,
			$.ajax({
				url: url,
			}).done(function(response) {
				current_obj.attr('status','open');
				 current_obj.addClass("group_a");
				current_obj.closest('tr').find('span').addClass("group_a");
				$('<tr class="append_tr row_for_'+second_grp_id+'"><td colspan="2">'+response+'</td></tr>').insertAfter(current_obj.closest('tr'));
			});			   
		}   
	});
});	
</script>
