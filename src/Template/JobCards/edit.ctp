<?php if($financial_year_data['Response'] == "Close" ){
 			echo "Financial Year Closed"; 
  } else { ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption" >
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Edit Job Card</span>
		</div>
		
	</div>
	
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= $this->Form->create($jobCard,['id'=>'form_sample_3']) ?>
			<div class="form-body">

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="col-md-4 control-label">Job Card No. </label>
							<div class="col-md-8">
							<?php echo $this->Form->input('jc1', ['label' => false,'type'=>'hidden','value'=>$jobCard->jc1]); ?>
							<?php echo $this->Form->input('jc2', ['label' => false,'type'=>'hidden','value'=>$jobCard->jc2]); ?>
							<?php echo $this->Form->input('jc3', ['label' => false,'type'=>'hidden','value'=>$jobCard->jc3]); ?>
							<?php echo $this->Form->input('jc4', ['label' => false,'type'=>'hidden','value'=>$jobCard->jc]); ?>
							<?php echo $jobCard->jc1.'/JC-'.str_pad($jobCard->jc2, 3, '0', STR_PAD_LEFT).'/'.$jobCard->jc3.'/'.$jobCard->jc4; ?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-3 control-label">SO No</label>
						<div class="col-md-9">
							<?= h($jobCard->sales_order->so1.'/'.str_pad($jobCard->sales_order->so2, 3, '0', STR_PAD_LEFT).'/'.$jobCard->sales_order->so3.'/'.$jobCard->sales_order->so4) ?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-4 control-label">Customer</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('customer_id', ['type'=>'hidden','value' => @$salesOrder->customer_id]); ?>
							<?php echo $jobCard->customer->customer_name.'('; echo$jobCard->customer->alias.')'; ?>
						</div>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-6 control-label">Customer PO No</label>
						<div class="col-md-6">
							<?php echo $this->Form->input('customer_po_no', ['type'=>'hidden','value' => @$salesOrder->customer_po_no]); ?>
							<?php echo  $jobCard->sales_order->customer_po_no; ?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-5 control-label">Required Date <span class="required" aria-required="true">*</span></label>
						<div class="col-md-7">
							
							<?php echo $this->Form->input('required_date', ['type'=>'text','value' => date("d-m-Y",strtotime($jobCard->required_date)),'label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','data-date-start-date' => '+0d','data-date-end-date' => '+60d']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-2 control-label">Dispatch Destination: <span class="required" aria-required="true">*</span></label>
						<div class="col-md-10">
							<?php echo $this->Form->textarea('dispatch_destination', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Dispatch Destination']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-2 control-label">Packing: <span class="required" aria-required="true">*</span></label>
						<div class="col-md-10">
							<?php echo $this->Form->textarea('packing', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Packing']); ?>
						</div>
					</div>
				</div>
			</div>			
			<br/>	
				
				<table width="100%" id="main_tb" border="1">
					<thead>
						<th width="30%" class="text-center"><label class="control-label">Production</label></th>
						<th align="center" class="text-center"><label class="control-label">Consumption</label></th>
					</thead>
					<tbody id="maintbody"><?php $p=0; $q=0; $r=0; ?>
					<?php //pr($jobCard->sales_order->sales_order_rows);
					foreach ($jobCard->sales_order->sales_order_rows as $sales_order_row): ?>
						
						<tr class="main_tr">
							<td valign="top" align="center">
							<?php echo $this->Form->input('sales_order_id', ['type'=>'text','empty'=>'--Select--','class' => 'form-control input-sm','label'=>false,'value'=>$sales_order_row->id,'type'=>'hidden']); ?>
							<br/><b><?= h($sales_order_row->item->name) ?> ( <?= h($sales_order_row->quantity) ?> )</b>
							</td>
							
							<td>
							<?php if(sizeof($sales_order_row->job_card_rows)>0){ ?>
							<?php  $page_no=$this->Paginator->current('SalesOrders'); $page_no=($page_no-1)*20; ?>	
							<div>
								<div class="form-group" style="padding:10px;">
									<?php   foreach($sales_order_row->job_card_rows as $job_card_row){ ?>
										<?php if(!empty($job_card_row->remark)){ ?>
											<label class="control-label">Remarks <span class="required" aria-required="true">*</span></label>
											<?php echo $this->Form->textarea('job_card_rows['.$r.'][remark]', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Remarks','value'=>$job_card_row->remark,'rows'=>1]); ?>
										<?php } ?>
									<?php $r++; } ?>
								</div>
								<table class="table">
									<thead>
										<th>Sr</th>
										<th width="70%">Item</th>
										<th>Quantity Per Unit</th>
										<th width="10%"></th>
									</thead>
									<tbody>
										<?php  foreach($sales_order_row->job_card_rows as $job_card_row): ?> 
											<tr>
												<td align="center"><?= h(++$page_no) ?></td>
												
												<td>
												<?php echo $this->Form->input('job_card_rows['.$p.'][sales_order_row_id]',['class' => 'form-control input-sm','type'=>'hidden','label'=>false,'value'=>$job_card_row->sales_order_row_id]); ?>
												<?php echo $this->Form->input('job_card_rows['.$p.'][item_id]',['empty'=>'--Select--','options'=>$items,'class' => 'form-control input-sm item_id ','label'=>false,'value'=>$job_card_row->item_id]); ?>
												</td>
												<td><?php echo $this->Form->input('job_card_rows['.$p.'][quantity]',['class' => 'form-control input-sm','placeholder'=>'Quantity','label'=>false,'value'=>$job_card_row->quantity]); ?></td>
												<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
												
											</tr>
										<?php $p++;  endforeach; ?>
										
									</tbody>
								</table>
							</div>
							<?php } ?>
							</td>
							
						</tr>
						<?php  endforeach; ?>
					</tbody>
				</table>
			</div>
		
			<div class="form-actions">
				<button type="submit" class="btn btn-primary" id='submitbtn'>EDIT JOB CARD</button>
			</div>
		<?= $this->Form->end() ?>
	</div>
	
		<!-- END FORM-->
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
	
	jQuery.validator.addMethod("notEqualToGroup", function (value, element, options) {
		// get all the elements passed here with the same class
		var elems = $(element).parents('form').find(options[0]);
		// the value of the current element
		var valueToCompare = value;
		// count
		var matchesFound = 0;
		// loop each element and compare its value with the current value
		// and increase the count every time we find one
		jQuery.each(elems, function () {
			thisVal = $(this).val();
			if (thisVal == valueToCompare) {
				matchesFound++;
			}
		});
		// count should be either 0 or 1 max
		if (this.optional(element) || matchesFound <= 1) {
			//elems.removeClass('error');
			return true;
		} else {
			//elems.addClass('error');
		}
	}, jQuery.format(""))
	
var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		
		rules: {
			rules: {
				packing:{
					required: true,
				},
				dispatch_destination:{
					required: true,
				},
				required_date : {
					  required: true,
				},
				remark : {
					  required: true,
				},
			},
		},

		messages: { // custom messages for radio buttons and checkboxes
			
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
			//Metronic.scrollTo(error3, -200);
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
			$('#submitbtn').prop('disabled', true);
			$('#submitbtn').text('Submitting.....');
			success3.show();
			error3.hide();
			form[0].submit(); // submit the form
		}

	});
	//--	 END OF VALIDATION
		
	onload_add_row();
	function onload_add_row(){
		var tr1=$("#onload_sample_tb").html();
		$("#main_tb tbody#maintbody tr.main_tr").each(function(){
			var table_count=$(this).find("td:nth-child(2) table").length;
			if(table_count==0){
				$(this).find("td:nth-child(2)").html(tr1);
			}
		});
		rename_rows_name();
	}
	
	$('.addrow').die().live("click",function() {
		var tr1=$("#sample_tb tbody").html();
		$(this).closest('table tbody').append(tr1);
		rename_rows_name();
    });
	
	$('.deleterow').die().live("click",function() {
		var l=$(this).closest("table tbody").find("tr").length;
		if (confirm("Are you sure to remove row ?") == true) {
			if(l>1){  
			 $(this).closest('tr').remove();
				var i=0; 
				$("#main_tb tbody#maintbody tr.main_tr").each(function(){
					var sales_order_row_id=$(this).find("td:nth-child(1) input").val();
					i++;
					$(this).find("td:nth-child(2) textarea").attr({name:"job_card_rows["+i+"][remark]", id:"job_card_rows-"+i+"-remark"});
					i--;
					var sr=0;
					$(this).find("td:nth-child(2) table tbody tr").each(function(){
						i++; sr++;
						$(this).find('td:nth-child(1)').html(sr);
						$(this).find("td:nth-child(2) input").attr({name:"job_card_rows["+i+"][sales_order_row_id]", id:"job_card_rows-"+i+"-sales_order_row_id"}).val(sales_order_row_id);
						
						$(this).find("td:nth-child(2) select").attr({name:"job_card_rows["+i+"][item_id]", id:"job_card_rows-"+i+"-item_id"}).select2();
						$(this).find("td:nth-child(3) input").attr({name:"job_card_rows["+i+"][quantity]", id:"job_card_rows-"+i+"-quantity"});
					});
				});
			}
		} 
    });
	
	function rename_rows_name(){
		var i=0; 
		$("#main_tb tbody#maintbody tr.main_tr").each(function(){
			var sales_order_row_id=$(this).find("td:nth-child(1) input").val();
			
			
			$(this).find("td:nth-child(2) textarea").attr({name:"job_card_rows["+i+"][remark]", id:"job_card_rows-"+i+"-remark"});
			
			var sr=0;
			$(this).find("td:nth-child(2) table tbody tr").each(function(){
				
				 sr++;
				$(this).find('td:nth-child(1)').html(sr);
				$(this).find('td:nth-child(2) input[type="hidden"]').attr({name:"job_card_rows["+i+"][sales_order_row_id]", id:"job_card_rows-"+i+"-sales_order_row_id"}).val(sales_order_row_id);
				
				$(this).find("td:nth-child(2) select").select2().attr({name:"job_card_rows["+i+"][item_id]", id:"job_card_rows-"+i+"-item_id"}).addClass("item_name-"+sales_order_row_id).rules('add', {
						required: true,
						notEqualToGroup: ['.item_name-'+sales_order_row_id],
						messages: {
							notEqualToGroup: "Do not select same Item again."
						}
					});
				$(this).find("td:nth-child(3) input").attr({name:"job_card_rows["+i+"][quantity]", id:"job_card_rows-"+i+"-quantity"});

				i++;
			});
		
		});
	}
});
</script>
<div id="onload_sample_tb" style="display:none;">
	<div class="form-group" style="padding:10px;">
		<label class="control-label">Remarks <span class="required" aria-required="true">*</span></label>
		<?php echo $this->Form->textarea('remark', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Remarks','required','rows'=>1]); ?>
	</div>
<table class="table">
	<thead>
		<th>Sr</th>
		<th width="70%">Item</th>
		<th>Quantity</th>
		<th width="10%"></th>
	</thead>
	<tbody>
		<tr>
			<td>0</td>
			<td>
			<?php echo $this->Form->input('sales_order_row_id',['class' => 'form-control input-sm','type'=>'hidden','label'=>false]); ?>
			<?php echo $this->Form->input('item_id',['empty'=>'--Select--','options'=>$items,'class' => 'form-control input-sm item_id','label'=>false,'required']); ?>
			</td>
			<td><?php echo $this->Form->input('quantity',['class' => 'form-control input-sm','label'=>false,'placeholder'=>'Quantity','required']); ?></td>
			<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
		
	</tbody>
</table>
</div>

<table id="sample_tb" style="display:none;">
	<tbody>
		<tr>
			<td>0</td>
			<td>
			<?php echo $this->Form->input('sales_order_row_id',['class' => 'form-control input-sm','type'=>'hidden','label'=>false]); ?>
			<?php echo $this->Form->input('item_id',['empty'=>'--Select--','options'=>$items,'class' => 'form-control input-sm item_id','label'=>false,'required']); ?>
			</td>
			<td><?php echo $this->Form->input('quantity',['class' => 'form-control input-sm','placeholder'=>'Quantity','label'=>false,'required']); ?></td>
			<td><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
		
	</tbody>
</table>
<?php } ?>