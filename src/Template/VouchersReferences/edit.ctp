<?php
?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Edit Voucher Reference</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= $this->Form->create($vouchersReference,['type' => 'file','id'=>'form_sample_3']) ?>
			<div class="form-body">
				<div class="row">

					<span style="color: red;">
						<?php if($chkdate == 'Not Found'){  ?>
							You are not in Current Financial Year
						<?php } ?>
					</span>

				<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Voucher Entity <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('voucher_entity', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Voucher Entity']); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Description <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('description', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Description']); ?>
						</div>
					</div>
				</div>
				<div class="row">
				<div class="panel-group accordion" id="accordion0">
				<input name="ledger_accounts[_ids]" value="" autocomplete="off" type="hidden">
				<?php foreach($AccountGroups as $accountGroup){ ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<table width="100%">
								<tr>
									<td><input type="checkbox" class="group" group_id="<?php echo $accountGroup->id;?>" /></td>
									<td width="100%"><a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion0" href="#collapse_<?php echo $accountGroup->id;?>" aria-expanded="false"><?php echo $accountGroup->name; ?></a></td>
								</tr>
							</table>
						</h4>
					</div>
					<div id="collapse_<?php echo $accountGroup->id;?>" class="panel-collapse collapse" aria-expanded="false">
						<div class="panel-body">
							<!--Account first Sub group Start-->
							<div class="panel-group accordion" id="accordion<?php echo $accountGroup->id;?>">
							<?php foreach($accountGroup->account_first_subgroups as $account_first_subgroup){ ?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<table width="100%">
											<tr>
												<td><input type="checkbox" class="first_subgroup" group_id="<?php echo $accountGroup->id;?>" first_group_id="<?php echo $account_first_subgroup->id;?>" /></td>
												<td width="100%"><a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion<?php echo $accountGroup->id;?>" href="#collapse_<?php echo $accountGroup->id;?>_<?php echo $account_first_subgroup->id;?>" aria-expanded="false"><?php echo $account_first_subgroup->name; ?></a></td>
											</tr>
										</table>
									</h4>
								</div>
								<div id="collapse_<?php echo $accountGroup->id;?>_<?php echo $account_first_subgroup->id;?>" class="panel-collapse collapse" aria-expanded="false">
								<div class="panel-body">
										
								<!--Account second Sub group Start-->
								<div class="panel-group accordion" id="accordion<?php echo $accountGroup->id;?>_<?php echo $account_first_subgroup->id;?>">
								<?php foreach($account_first_subgroup->account_second_subgroups as $account_second_subgroup){ ?>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<table width="100%">
												<tr>
													<td ><input type="checkbox" class="second_subgroup" group_id="<?php echo $accountGroup->id;?>" first_group_id="<?php echo $account_first_subgroup->id;?>" second_subgrop_id="<?php echo $account_second_subgroup->id;?>"/></td>
													<td width="100%"><a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion<?php echo $accountGroup->id;?>_<?php echo $account_first_subgroup->id;?>" href="#collapse_<?php echo $accountGroup->id;?>_<?php echo $account_first_subgroup->id;?>_<?php echo $account_second_subgroup->id;?>" aria-expanded="false"><?php echo $account_second_subgroup->name; ?></a></td>
												</tr>
											</table>
										</h4>
								</div>
								<div id="collapse_<?php echo $accountGroup->id;?>_<?php echo $account_first_subgroup->id;?>_<?php echo $account_second_subgroup->id;?>" class="panel-collapse collapse" aria-expanded="false">
									<div class="panel-body">
									<!--Account ledger account Start-->
								<div class="panel-group accordion" id="accordion<?php echo $accountGroup->id;?>_<?php echo $account_first_subgroup->id;?>_<?php echo $account_second_subgroup->id;?>">
								<?php foreach($account_second_subgroup->ledger_accounts as $ledger_account){ ?>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<table width="100%">
												<tr>
													<td ><input type="checkbox" name="ledger_accounts[_ids][]"  value="<?php echo $ledger_account->id;?>" <?php if (in_array($ledger_account->id, $ledger_arr)) {echo 'checked'; } else { } ?> class="ledger" group_id="<?php echo $accountGroup->id;?>" first_group_id="<?php echo $account_first_subgroup->id;?>" second_subgrop_id="<?php echo $account_second_subgroup->id;?>" ledger_account_id="<?php echo $ledger_account->id;?>"/></td>
													<td width="100%">
													<?php if(!empty($ledger_account->alias)){ ?>
														<?php echo $ledger_account->name; ?> (<?= h($ledger_account->alias) ?>)
													<?php }else{ ?>
														<?= h($ledger_account->name) ?>
													<?php } ?>
													</td>
												</tr>
											</table>
										</h4>
								</div>
								
							</div>
							<?php } ?>
							</div>
							<!--Account Ledger Sub group End-->	
								</div>
								</div>
							</div>
							<?php } ?>
							</div>
							<!--Account Second Sub group End-->
	
									</div>
								</div>
							</div>
							<?php } ?>
							</div>
							<!--Account First Sub group End-->	
								</div>
								</div>
							</div>
							<?php } ?>
							</div>
							<!--Account Group Sub group End-->
						</div>
					
				
			</div>
		
			<div class="form-actions">

			<?php if($chkdate == 'Not Found'){  ?>
					<label class="btn btn-danger"> You are not in Current Financial Year </label>
				<?php } else { ?>
					<button type="submit" class="btn btn-primary">EDIT VOUCHER REFERENCE</button>
				<?php } ?>	


			</div>
		</div>
		<?= $this->Form->end() ?>
		<!-- END FORM-->
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {

	//--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
			voucher_entity:{
				required: true,
			},
			description  : {
				  required: true,
			},
			account_group_id : {
				  required: true,
			},
					
		},

		

		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.parent(".input-group").size() > 0) {
				error.insertAfter(element.parent(".input-group"));
			} else if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else if (element.parents('.radio-list').size() > 0) { 
				error.appendTo(element.parents('.radio-list').attr("data-error-container"));
			} else if (element.parents('.radio-inline').size() > 0) { 
				error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
			} else if (element.parents('.checkbox-list').size() > 0) {
				error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
			} else if (element.parents('.checkbox-inline').size() > 0) { 
				error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
			success3.hide();
			error3.show();
			Metronic.scrollTo(error3, -200);
		},

		highlight: function (element) { // hightlight error inputs
		   $(element)
				.closest('.form-group').addClass('has-error'); // set error class to the control group
		},

		unhighlight: function (element) { // revert the change done by hightlight
			$(element)
				.closest('.form-group').removeClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label
				.closest('.form-group').removeClass('has-error'); // set success class to the control group
		},

		submitHandler: function (form) {
			success3.show();
			error3.hide();
			form[0].submit(); // submit the form
		}

	});
	
	$(".group").each(function(){
		var group_id=$(this).attr('group_id');
		$(".first_subgroup[group_id="+group_id+"]").each(function(){
			var first_group_id=$(this).attr('first_group_id');
				$(".second_subgroup[first_group_id="+first_group_id+"]").each(function(){
					var second_subgrop_id=$(this).attr('second_subgrop_id');
					var all_element=$('.ledger[second_subgrop_id='+second_subgrop_id+']').length;
					
					var checked_element=$('.ledger[second_subgrop_id='+second_subgrop_id+']:checked').length;
					
					if(all_element==checked_element && all_element!=0){
						$('input.second_subgroup[second_subgrop_id="'+second_subgrop_id+'"]').attr('checked','checked');
						$.uniform.update();
					}else{
						$('input.second_subgroup[second_subgrop_id="'+second_subgrop_id+'"]').removeAttr('checked');
						$.uniform.update();
					}
				})
		})
	})
	
	$(".group").each(function(){
		var group_id=$(this).attr('group_id');
		$(".first_subgroup[group_id="+group_id+"]").each(function(){
			var first_group_id=$(this).attr('first_group_id');
			var all_element=$('.second_subgroup[first_group_id='+first_group_id+']').length;
			
			var checked_element=$('.second_subgroup[first_group_id='+first_group_id+']:checked').length;
			
			if(all_element==checked_element  && all_element!=0){
				$('input.first_subgroup[first_group_id="'+first_group_id+'"]').attr('checked','checked');
				$.uniform.update();
			}else{
				$('input.first_subgroup[first_group_id="'+first_group_id+'"]').removeAttr('checked');
				$.uniform.update();
			}
		})
	})
			
			
	$(".group").each(function(){
		var group_id=$(this).attr('group_id');
			var group_id=$(this).attr('group_id');
			var all_element=$('.first_subgroup[group_id='+group_id+']').length;
			
			var checked_element=$('.first_subgroup[group_id='+group_id+']:checked').length;
			
			if(all_element==checked_element  && all_element!=0){
				$('input.group[group_id="'+group_id+'"]').attr('checked','checked');
				$.uniform.update();
			}else{
				$('input.group[group_id="'+group_id+'"]').removeAttr('checked');
				$.uniform.update();
			}
		
	})		
		
	
	var second_subgrop_id=$('.ledger').attr('second_subgrop_id');
	var first_group_id=$('.ledger').attr('first_group_id');
	var group_id=$('.ledger').attr('group_id');
	var all_element=$('.ledger[second_subgrop_id='+second_subgrop_id+']').length;
	
		var checked_element=$('.ledger[second_subgrop_id='+second_subgrop_id+']:checked').length;
		if(all_element==checked_element  && all_element!=0){
			$('input.second_subgroup[second_subgrop_id="'+second_subgrop_id+'"]').attr('checked','checked');
			$.uniform.update();
		}else{
			$('input.second_subgroup[second_subgrop_id="'+second_subgrop_id+'"]').removeAttr('checked');
			$.uniform.update();
		}
		var all_element2=$('.second_subgroup[first_group_id='+first_group_id+']').length;
		var checked_element2=$('.second_subgroup[first_group_id='+first_group_id+']:checked').length;
		if(all_element2==checked_element2){
			$('input.first_subgroup[first_group_id="'+first_group_id+'"]').attr('checked','checked');
			$.uniform.update();
		}else{
			$('input.first_subgroup[first_group_id="'+first_group_id+'"]').removeAttr('checked');
			$.uniform.update();
		}
		
		var all_element3=$('.first_subgroup[group_id='+group_id+']').length;
		var checked_element3=$('.first_subgroup[group_id='+group_id+']:checked').length;
		if(all_element3==checked_element3  && all_element!=0){
			$('input.group[group_id="'+group_id+'"]').attr('checked','checked');
			$.uniform.update();
		}else{
			$('input.group[group_id="'+group_id+'"]').removeAttr('checked');
			$.uniform.update();
		}
	
	// end ledger onload
	
	$('input.group').die().live('click',function(){
		var sel=$(this);
		check_all_for_group(sel);
	});
	
	$('input.first_subgroup').die().live('click',function(){
		var sel2=$(this);
		check_all_for_first_sub_group(sel2);
		var group_id=$(this).attr('group_id');
		
		var all_element=$('.first_subgroup[group_id='+group_id+']').length;
		var checked_element=$('.first_subgroup[group_id='+group_id+']:checked').length;
		if(all_element==checked_element){
			$('input.group[group_id="'+group_id+'"]').attr('checked','checked');
			$.uniform.update();
		}else{
			$('input.group[group_id="'+group_id+'"]').removeAttr('checked');
			$.uniform.update();
		}
	});
	
	$('input.second_subgroup').die().live('click',function(){
		var sel3=$(this);
		check_all_for_second_sub_group(sel3);
		var first_group_id=$(this).attr('first_group_id');
		
		var group_id=$(this).attr('group_id');
		
		var all_element=$('.second_subgroup[first_group_id='+first_group_id+']').length;
		var checked_element=$('.second_subgroup[first_group_id='+first_group_id+']:checked').length;
		if(all_element==checked_element){
			$('input.first_subgroup[first_group_id="'+first_group_id+'"]').attr('checked','checked');
			$.uniform.update();
		}else{
			$('input.first_subgroup[first_group_id="'+first_group_id+'"]').removeAttr('checked');
			$.uniform.update();
		}
		
		var all_element3=$('.first_subgroup[group_id='+group_id+']').length;
		var checked_element3=$('.first_subgroup[group_id='+group_id+']:checked').length;
		if(all_element3==checked_element3){
			$('input.group[group_id="'+group_id+'"]').attr('checked','checked');
			$.uniform.update();
		}else{
			$('input.group[group_id="'+group_id+'"]').removeAttr('checked');
			$.uniform.update();
		}
	});
	
	$('input.ledger').die().live('click',function(){
		var second_subgrop_id=$(this).attr('second_subgrop_id');
		var first_group_id=$(this).attr('first_group_id');
		var group_id=$(this).attr('group_id');
		
		var all_element=$('.ledger[second_subgrop_id='+second_subgrop_id+']').length;
		var checked_element=$('.ledger[second_subgrop_id='+second_subgrop_id+']:checked').length;
		if(all_element==checked_element){
			$('input.second_subgroup[second_subgrop_id="'+second_subgrop_id+'"]').attr('checked','checked');
			$.uniform.update();
		}else{
			$('input.second_subgroup[second_subgrop_id="'+second_subgrop_id+'"]').removeAttr('checked');
			$.uniform.update();
		}
		
		var all_element2=$('.second_subgroup[first_group_id='+first_group_id+']').length;
		var checked_element2=$('.second_subgroup[first_group_id='+first_group_id+']:checked').length;
		if(all_element2==checked_element2){
			$('input.first_subgroup[first_group_id="'+first_group_id+'"]').attr('checked','checked');
			$.uniform.update();
		}else{
			$('input.first_subgroup[first_group_id="'+first_group_id+'"]').removeAttr('checked');
			$.uniform.update();
		}
		
		var all_element3=$('.first_subgroup[group_id='+group_id+']').length;
		var checked_element3=$('.first_subgroup[group_id='+group_id+']:checked').length;
		if(all_element3==checked_element3){
			$('input.group[group_id="'+group_id+'"]').attr('checked','checked');
			$.uniform.update();
		}else{
			$('input.group[group_id="'+group_id+'"]').removeAttr('checked');
			$.uniform.update();
		}
	});

	
	function check_all_for_group(sel){
			var group_id=sel.attr('group_id'); 
			if(sel.is(':checked')){ 
				$('.first_subgroup[group_id='+group_id+']').attr('checked','checked');
				$('.second_subgroup[group_id='+group_id+']').attr('checked','checked');
				$('.ledger[group_id='+group_id+']').attr('checked','checked');
				$.uniform.update(); 
			}else{
				$('.first_subgroup[group_id='+group_id+']').removeAttr('checked');
				$('.second_subgroup[group_id='+group_id+']').removeAttr('checked');
				$('.ledger[group_id='+group_id+']').removeAttr('checked');
				$.uniform.update(); 
			}
		
	}
	
	function check_all_for_first_sub_group(sel2){
			var first_group_id=sel2.attr('first_group_id');
			if(sel2.is(':checked')){
				$('.second_subgroup[first_group_id='+first_group_id+']').attr('checked','checked');
				$('.ledger[first_group_id='+first_group_id+']').attr('checked','checked');
				$.uniform.update(); 
			}else{
				$('.second_subgroup[first_group_id='+first_group_id+']').removeAttr('checked');
				$('.ledger[first_group_id='+first_group_id+']').removeAttr('checked');
				$.uniform.update(); 
			}
	}
	
	function check_all_for_second_sub_group(sel3){
			var second_subgrop_id=sel3.attr('second_subgrop_id');
			if(sel3.is(':checked')){
				$('.ledger[second_subgrop_id='+second_subgrop_id+']').attr('checked','checked');
				$.uniform.update(); 
			}else{
				$('.ledger[second_subgrop_id='+second_subgrop_id+']').removeAttr('checked');
				$.uniform.update(); 
			}
	}
	
	
});
</script>


