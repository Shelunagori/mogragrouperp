<?php //pr($Ledgers_Assets); exit; ?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>Balance Sheet
				</div>
			</div>
			<div class="portlet-body">
				<form method="get">
					<div class="input-group input-medium">
						<input type="text" name="date" class="form-control date-picker" placeholder="Date" data-date-format='dd-mm-yyyy' data-date-end-date='0d' value="<?php  echo $date; ?>">
						<span class="input-group-btn">
						<button class="btn blue" type="submit">Go</button>
						</span>
					</div>
				</form>
				<?php if($date){ ?>
				<div class="row">
					<table width="100%" style="margin-top: 10px;"  >
						<tr   style="width:50%;">
						    <td><div align="center"><h4>Liablities</h4></div></td>
						    <td><div align="center"><h4>Assets</h4></div></td>
						</tr>
						<tr style="width:50%;">
						    <td valign="top">
								<div class="col-md-12">
									<table id="main_tble" class="table table-condensed">
										<tbody class="main_tbody">
										<?php $total_lib = 0;
										$lib_tr = 0; $ass_tr = 0; $liablitie_tr =0; $assets_tr = 0; $Total_Liablities=0; $Total_lib_Dr=0; $Total_lib_Cr=0;
										//pr($liablitie_groups);exit;
										$i=0;
										
										usort($liablitie_groups, function ($a, $b) {
										return $a['sequence'] - $b['sequence'];
										});
										foreach($liablitie_groups as $liablitie_group){ 
										$i++;
										
										$Total_Liablities=$liablitie_group['debit']-$liablitie_group['credit']; ?>
											<tr group_id=<?php  echo $liablitie_group['group_id'] ?> class="main_tr">
												<td> 
													<a href='#' role='button' status='close' class="group_name" group_id='<?php echo $liablitie_group['group_id']; ?>' style='color:black;'> 
														<?=  h($liablitie_group['name']) ?> 
													</a>  
												</td>
												<td style="text-align:right;">
													<span>
														<?= h($this->Number->format(abs($Total_Liablities),['places'=>2])) ?>
														<?php if($Total_Liablities>=0)
														     { $Total_lib_Dr += $Total_Liablities; echo 'Dr'; }
															 else{ $Total_lib_Cr += $Total_Liablities; echo 'Cr';} ?>
													</span>
												</td>
											</tr> 
										<?php } ?>
										
										
											
											<?php $Total_lib_Dr= abs($Total_lib_Dr);  $Total_lib_Cr= abs($Total_lib_Cr); ?>
										</tbody>
									</table>
								</div>
							</td>
						    <td valign="top">
								<div class="col-md-12">
										<table id="main_tble1" class="table table-condensed">
											<tbody class="main_tbody1">
											<?php
											usort($asset_groups, function ($a, $b) {
											return $a['sequence'] - $b['sequence'];
											});
											$Total_Assets=0; $Total_Dr=0; $Total_Cr=0;
											foreach($asset_groups as $asset_group){
											$Total_Assets= $asset_group['debit'] - $asset_group['credit'];?>
													<tr group_id=<?php  echo $asset_group['group_id'] ?> class="main_tr1"> <?php $assets_tr++; ?>
														<td> <a href="#" role='button' status='close' class="group_name" group_id='<?php      echo $asset_group['group_id']; ?>' style='color:black;'>
																<?= h($asset_group['name']) ?>
															 </a>  
														</td>
														<td style="text-align:right;">
															<?= h($this->Number->format(abs($Total_Assets),['places'=>2])) ?>
															<?php if($Total_Assets>=0)
															{ $Total_Dr += $Total_Assets;  echo 'Dr'; }
														    else{ $Total_Cr += $Total_Assets; echo 'Cr'; } ?>
														</td>
													</tr>
											<?php } ?>
												<?php $Total_Dr= abs($Total_Dr);  $Total_Cr= abs($Total_Cr); ?>
											</tbody>
									</table>
								</div>
							</td>
						</tr>
						<tr>
							<td> 
							    <table style='width:100%;'>	
									<tr> 
										<th style='padding-left: 20px;'>Total Liablities </th>
										<?php  if($Total_lib_Dr>$Total_lib_Cr){ 
											$Total_Liablities=abs($Total_lib_Dr)-abs($Total_lib_Cr);?>
											<th style=" text-align: right; "><?= h (
											$this->Number->format(abs($Total_Liablities),['places'=>2])); ?> Dr</th>
										<?php } else if ($Total_lib_Dr<$Total_lib_Cr) { 
											$Total_Liablities=abs($Total_lib_Dr)-abs($Total_lib_Cr); ?>
											<th style=" text-align: right;padding-right: 20px;"><?= h($this->Number->format(abs($Total_Liablities),['places'=>2])); ?>Cr</th>
										<?php } else { ?>
										<th style=" text-align: right;padding-right: 20px;"><?php echo $this->Number->format('0',['places'=>2]); ?></th>
										<?php } ?>
									</tr>	

								</table>
							</td>
							<td>
								<table style='width:100%;'>
								  <tr>
									<th style='padding-left: 20px;'>Total Assets</th>
									<?php  if($Total_Dr>$Total_Cr){ $Total_Assets=abs($Total_Dr)-abs($Total_Cr);  ?>
										<th style=" text-align: right;padding-right: 20px;" width="200px"><?= h( $this->Number->format($Total_Assets,['places'=>2]) ); ?> Dr</th>
									<?php } else if($Total_Dr<$Total_Cr){ $Total_Assets=abs($Total_Dr)-abs($Total_Cr); ?>
										<th style=" text-align: right;padding-right: 20px;" width="200px"><?= h($this->Number->format(abs($Total_Assets),['places'=>2])); ?>Cr</th>
									<?php } else { ?>
									<th style=" text-align: right;padding-right: 20px;"><?php echo $this->Number->format('0',['places'=>2])?></th>
									<?php } ?>
								   </tr>
								</table>
							</td>	

						</tr>
						
					</table>
				</div>
				<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<style>
	.group_a {
		font-weight: bold;
		
	}
</style>

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
		   var date = $('.date-picker').val();
		   var url="<?php echo $this->Url->build(['controller'=>'LedgerAccounts','action'=>'firstSubGroups']); ?>";
		   url=url+'/'+group_id +'/'+date,
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
		   var date = $('.date-picker').val();
		   var url="<?php echo $this->Url->build(['controller'=>'LedgerAccounts','action'=>'secondSubGroups']); ?>";
		   url=url+'/'+first_grp_id +'/'+date,
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
		   var date = $('.date-picker').val();
		   var url="<?php echo $this->Url->build(['controller'=>'LedgerAccounts','action'=>'ledgerAccountData']); ?>";
		   url=url+'/'+second_grp_id +'/'+date,
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
