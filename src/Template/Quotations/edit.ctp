<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
	vertical-align: top !important;
}
</style>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Edit Quotation</span>
		</div>
	</div>
	<div class="portlet-body form">
		<?= $this->Form->create($quotation,['id'=>'form_sample_3']) ?>
		<div class="form-body">
			<div class="row">
				<div class="col-md-6">
				</div>
				<div class="col-md-6" align="right">
					<div class="form-group">
						<label class="col-md-8 control-label">Date</label>
						<div class="col-md-4">
							<?php echo $this->Form->input('created_on', ['type' => 'text','label' => false,'class' => 'form-control input-sm','value' => date("d-m-Y",strtotime($quotation->created_on)),'readonly']); ?>
						</div>

					<span style="color: red;">
						<?php if($chkdate == 'Not Found'){  ?>
							You are not in Current Financial Year
						<?php } ?>
					</span>


					</div>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Customer</label>
						<div class="col-md-9">
							<?php
							$options=array();
							foreach($customers as $customer){
								if(empty($customer->alias)){
									$merge=$customer->customer_name;
								}else{
									$merge=$customer->customer_name.'	('.$customer->alias.')';
								}
								
								$options[]=['text' =>$merge, 'value' => $customer->id,'employee_id' => $customer->employee_id,'file' => sizeof($customer->filenames)];
							}
							echo $this->Form->input('customer_id', ['empty' => "--Select--",'label' => false,'options' => $options,'class' => 'form-control input-sm select2me','value' => @$quotation->customer_id]); ?>
						</div>
					</div>
					<br/>
					<div class="form-group">
						<label class="col-md-3 control-label">Address</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('customer_address', ['label' => false,'class' => 'form-control','placeholder' => 'Address']); ?>
							<a href="#" role="button" class="pull-right select_address" >
							Select Address </a>
						</div>
					</div>
					
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-4 control-label">Salesman</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('employee_id', ['options'=>$employees,'label' => false,'class' => 'form-control input-sm select2me']); ?>
						</div>
					</div>
					<br/>
					<div class="form-group">
						<label class="col-md-4 control-label">Product</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('item_group_id', ['empty'=>'--Select--','options' => $ItemGroups,'label' => false,'class' => 'form-control input-sm select2me','required']); ?>
						</div>
					</div>
					<br/>
					<div class="form-group">
						<label class="col-md-4 control-label">Finalisation Date</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('finalisation_date', ['type' => 'text','label' => false,'class' => 'form-control input-sm date-picker','data-date-format' => 'dd-mm-yyyy','data-date-start-date' => '+0d','data-date-end-date' => '+60d','placeholder' => 'Finalisation Date','value'=>date("d-m-Y",strtotime($quotation->finalisation_date))]); ?>
						</div>
					</div>
					<br/>
					<br/>
					<div class="form-group">
						<label class="col-md-4 control-label">Qutote Ref. No.</label>
						<div class="col-md-2 padding-right-decrease">
							<?php echo $this->Form->input('qt1', ['label' => false,'class' => 'form-control input-sm','readonly']); ?>
						</div>
						<div class="col-md-3" id="qt3_div">
						
							<?php 
							$options=array();
							foreach($Filenames as $Filenames){
								$merge=$Filenames->file1.'-'.$Filenames->file2.'' ;
								
								$options[]=['text' =>$merge, 'value' => $merge];
							}
							
							echo $this->Form->input('qt3', ['options'=>$options,'label' => false,'class' => 'form-control input-sm','value'=>$quotation->qt3,'required']); ?>
						</div>
						<div class="col-md-3">
							<?php echo $this->Form->input('qt4', ['label' => false,'class' => 'form-control input-sm','readonly']); ?>
						</div>
					</div>
				
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Kind attention</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('customer_for_attention', ['label' => false,'class' => 'form-control input-sm']); ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Contact No</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('customer_contact_no', ['label' => false,'class' => 'form-control input-sm quantity','required']); ?>
						</div>
					</div>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-3 control-label">Reference</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('enquiry_no', ['label' => false,'class' => 'form-control input-sm']); ?>
						</div>
					</div>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-1 control-label">Subject</label>
						<div class="col-md-11">
							<?php echo $this->Form->input('subject', ['label' => false,'class' => 'form-control input-sm']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-1 control-label">Dear Sir</label>
						<div class="col-md-11">
							<?php echo $this->Form->input('text', ['label' => false,'class' => 'form-control','value' => $quotation->text]); ?>
						</div>
					</div>
				</div>
			</div>
			<br/>
			<table class="table tableitm" id="main_tb">
				<thead>
					<tr>
						<th width="50">Sr.No. </th>
						<th>Items</th>
						<th width="130">Quantity</th>
						<th width="130">Rate</th>
						<th width="130">Amount</th>
						<th width="70"></th>
					</tr>
				</thead>
				<tbody id="main_tbody">
					<?php $q=0; foreach ($quotation->quotation_rows as $quotation_row): ?>
						<tr class="tr1 preimp" row_no='<?php echo @$quotation_row->id; ?>'>
							<td rowspan="2" width="10">
								<?php echo $q; ?>
								<?php echo $this->Form->input('quotation_rows.'.$q.'.id'); ?>
							</td>
							<td>
								<div class="row">
									<div class="col-md-11 padding-right-decrease">
										<?php echo $this->Form->input('quotation_rows['.$q.'][item_id]', ['options' => $items,'label' => false,'class' => 'form-control input-sm item_box item_id','value' => $quotation_row->item_id,'required','popup_id'=>$q]); ?>
									</div>
									<div class="col-md-1 padding-left-decrease">
										<a href="#" class="btn btn-default btn-sm popup_btn" role="button" popup_id="<?php echo $q; ?>"> <i class="fa fa-info-circle"></i> </a>
										<div class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false" style="display: none; padding-right: 12px;" popup_div_id="<?php echo $q; ?>"><div class="modal-backdrop fade in" ></div>
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-body" popup_ajax_id="<?php echo $q; ?>">
														
													</div>
													<div class="modal-footer">
														<button type="button" class="btn default closebtn">Close</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php echo $this->Form->input('quotation_rows['.$q.'][height]', ['type' => 'hidden','value' => @$quotation_row->height]); ?>
							</td>
							<td width="100">
								<?php echo $this->Form->input('quotation_rows['.$q.'][quantity]', ['label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Quantity','value' => $quotation_row->quantity,'required','min'=>1]); ?>
								
							</td>
							<td width="130">
								<?php echo $this->Form->input('quotation_rows['.$q.'][rate]', ['label' => false,'class' => 'form-control input-sm rate','placeholder' => 'Rate', 'min'=>'0.01','value' => $quotation_row->rate,'required','r_popup_id'=>$q]); ?>
							</td>
							<td width="130">
								<?php echo $this->Form->input('quotation_rows['.$q.'][amount]', ['label' => false,'class' => 'form-control input-sm','placeholder' => 'Amount','value' => $quotation_row->amount]); ?>
							</td>
							<td  width="70"><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
						</tr>
						<tr class="tr2 preimp" row_no='<?php echo @$quotation_row->id; ?>'>
							<td colspan="4" class="main">
							<div class="note-editable" id="summer<?php echo $q; ?>" ><?php echo $quotation_row->description; ?></div>
							</td>
							<td></td>
						</tr>
					<?php $q++; endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" align="right"><b>Total</b></td>
						<td><?php echo $this->Form->input('total', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Total','readonly']); ?></td>
						<td></td>
					</tr>
				</tfoot>
			</table>
			<label class="control-label">Additional Note (Optional): </label>
			<?php echo $this->Form->input('additional_note', ['label' => false,'class' => 'form-control']); ?>
			<br/>
			
			
			<div id="t_c_box">
				<label class="control-label">Commercial Terms & Conditions: </label> <a href="#" role="button" class="select_term_condition btn btn-xs btn-primary">Select </a> <a  role="button" class="btn btn-xs btn-primary updatetc" >Update </a>
				<div name="terms_conditions_box" id="terms_conditions_box" class="summernote_1"><?php echo $quotation->terms_conditions; ?></div>
				<?php echo $this->Form->input('terms_conditions', ['label'=>false,'class' => 'form-control','value' => @$quotation->terms_conditions,'required','style'=>'display:none']); ?>
			</div>
			<br/>
			<ol id="sortable">
			  
			</ol>
		</div>
		<div class="form-actions">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					<?php if($chkdate == 'Not Found'){  ?>
						<label class="btn btn-danger"> You are not in Current Financial Year </label>
					<?php } else { ?>
						<button type="submit" id='submitbtn' class="btn btn-primary" >UPDATE QUOTATION</button>
					<?php } ?>
				</div>
			</div>
		</div>
		
		<?= $this->Form->end() ?>
	</div>
</div>
<style>
.table thead tr th {
    color: #FFF;
	background-color: #254b73;
}
.padding-right-decrease{
	padding-right: 0;
}
.padding-left-decrease{
	padding-left: 0;
}
</style>


<table id="sample_tb" style="display:none;">
	<tbody >
		<tr class="tr1 preimp maintr">
			<td rowspan="2" width="10">0</td>
			<td>
				<div class="row">
					<div class="col-md-11 padding-right-decrease">
						<?php echo $this->Form->input('item_id', ['empty'=>'Select','options' => $items,'label' => false,'class' => 'form-control input-sm item_box item_id','placeholder' => 'Item']); ?>
					</div>
					<div class="col-md-1 padding-left-decrease">
						<a href="#" class="btn btn-default btn-sm popup_btn" role="button"> <i class="fa fa-info-circle"></i> </a>
						<div class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false" style="display: none; padding-right: 12px;"><div class="modal-backdrop fade in" ></div>
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-body" >
										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn default closebtn">Close</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</td>
			<td width="100"><?php echo $this->Form->input('quantity[]', ['label' => false,'class' => 'form-control input-sm quantity','placeholder' => 'Quantity']); ?></td>
			<td width="130"><?php echo $this->Form->input('rate[]', ['type' => 'text', 'min'=>'0.01','label' => false,'class' => 'form-control input-sm rate','placeholder' => 'Rate']); ?></td>
			<td width="130"><?php echo $this->Form->input('amount[]', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Amount']); ?></td>
			<td  width="70"><a class="btn btn-xs btn-default addrow" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
		<tr class="tr2 preimp maintr">
			<td colspan="4" class="main"><?php echo $this->Form->textarea('description', ['label' => false,'class' => 'form-control input-sm autoExpand','placeholder' => 'Description','style'=>['display:none'],'rows'=>'1']); ?>
			<div contenteditable="true" id="editor"></div>
			</td>
			<td></td>
		</tr>
	</tbody>
</table>

<div id="terms_conditions" style="display:none;"></div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<style>
#sortable li{
	cursor: -webkit-grab;
}
</style>
<?php echo $this->Html->css('/drag_drop/jquery-ui.css'); ?>
<?php echo $this->Html->script('/drag_drop/jquery-1.12.4.js'); ?>
<?php echo $this->Html->script('/drag_drop/jquery-ui.js'); ?>
<script>
$( function() {
$( "#sortable" ).sortable();
$( "#sortable" ).disableSelection();
} );
</script>
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
	//--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
				customer_id : {
					  required: true,
				},
				customer_address : {
					  required: true,
				},
				
				employee_id:{
					required: true
				},
				item_group_id:{
					required: true,
				},
				finalisation_date:{
					required: true,
				},
				customer_for_attention : {
					  required: true,
				},
				enquiry_no  : {
					  required: true,
				},
				customer_contact_no: {
					  required: true,
					  digits: true,
					  minlength: 10,
					  maxlength: 10,
				},
				subject:{
					required: true,	
				},
				qt1:{
					required: true,	
				},
				qt3:{
					required: true,	
				},
				qt4:{
					required: true,	
				}
			},

		messages: { // custom messages for radio buttons and checkboxes
			membership: {
				required: "Please select a Membership type"
			},
			service: {
				required: "Please select  at least 2 types of Service",
				minlength: jQuery.validator.format("Please select  at least {0} types of Service")
			}
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
			put_code_description()
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
			put_code_description()
			success3.show();
			error3.hide();
			form[0].submit(); // submit the form
		}

	});
	//--	 END OF VALIDATION

    $('.addrow').die().live("click",function() { 
		add_row();
    });
	
	
	
	$('.deleterow').die().live("click",function() {
		var l=$(this).closest("table tbody").find("tr").length;
		if (confirm("Are you sure to remove row ?") == true) {
			if(l>2){
				var row_no=$(this).closest("tr").attr("row_no");
				var del="tr[row_no="+row_no+"]";
				$(del).remove();
				
				rename_rows();
				calculate_total();
			}
		} 
    });
	
	function add_row(){
		var tr1=$("#sample_tb tbody tr.tr1").clone();
		$("#main_tb tbody#main_tbody").append(tr1);
		var tr2=$("#sample_tb tbody tr.tr2").clone();
		$("#main_tb tbody#main_tbody").append(tr2);
		
		var w=0; var r=0;
		$("#main_tb tbody#main_tbody tr.preimp").each(function(){
			
			$(this).attr("row_no",w);
			r++;
			if(r==2){ w++; r=0; }
		});
		rename_rows();
		calculate_total();
	}
	rename_rows();
	function rename_rows(){
		var i=0;
		$("#main_tb tbody tr.tr1").each(function(){
			$(this).find('span.help-block-error').remove();
			$(this).find("td:nth-child(1)").html(++i); i--;
			//$(this).find("td:nth-child(2) select.item_box").select2().attr({name:"quotation_rows["+i+"][item_id]", id:"quotation_rows-"+i+"-item_id",popup_id:i}).rules("add", "required");
			$(this).find("td:nth-child(2) select.item_box").select2().attr({name:"quotation_rows["+i+"][item_id]", id:"quotation_rows-"+i+"-item_id",popup_id:i}).rules('add', {
						required: true,
						notEqualToGroup: ['.item_id'],
						messages: {
							notEqualToGroup: "Do not select same Item again."
						}
					});
			
			$(this).find("td:nth-child(2) input[type=hidden]:eq(0)").attr({name:"quotation_rows["+i+"][height]", id:"quotation_rows-"+i+"-height"});
			$(this).find("td:nth-child(2) a.popup_btn").attr("popup_id",i);
			$(this).find("td:nth-child(2) div.modal").attr("popup_div_id",i);
			$(this).find("td:nth-child(2) div.modal-body").attr("popup_ajax_id",i);
			$(this).find("td:nth-child(3) input").attr({name:"quotation_rows["+i+"][quantity]", id:"quotation_rows-"+i+"-quantity"}).rules('add', {
						required: true,
						digits: true,
					});
			$(this).find("td:nth-child(4) input").attr({name:"quotation_rows["+i+"][rate]", id:"quotation_rows-"+i+"-rate",r_popup_id:i}).rules('add', {
						required: true,
						number: true,
						min: 0.01
					});
			
			$(this).find("td:nth-child(5) input").attr({name:"quotation_rows["+i+"][amount]", id:"quotation_rows-"+i+"-amount"});
		i++; });
		
		var i=0;
		$("#main_tb tbody tr.tr2").each(function(){
			var htm=$(this).find('td:nth-child(1)').find('div.note-editable').html();
			if(!htm){ htm=""; }
			$(this).find('td:nth-child(1)').html('');
			$(this).find('td:nth-child(1)').append('<div id=summer'+i+'>'+htm+'</div>');
			$(this).find('td:nth-child(1)').find('div#summer'+i).summernote();
			$(this).find('td.main:nth-child(1)').append('<textarea name="quotation_rows['+i+'][description]" style="display:none;"></textarea>');
		i++; });
		
		$("select.item_box").each(function(){
			var popup_id=$(this).attr('popup_id');
			var item_id=$(this).val();
			if(popup_id){
				last_three_rates_onload(popup_id,item_id);
			}
		});
	}
	
	function put_code_description(){
		var i=0;
		$("#main_tb tbody tr.tr2").each(function(){
			var code=$(this).find('div#summer'+i).code();
			$(this).find('td:nth-child(1) textarea').val(code);
		i++; });
		
		var code=$('#terms_conditions_box').code();
		$('textarea[name="terms_conditions"]').val(code);
	}
	
	$('#main_tb input').die().live("keyup","blur",function() { 
		calculate_total();
    });
	function calculate_total(){
		var total=0;
		$("#main_tb tbody tr.tr1").each(function(){
			var unit=$(this).find("td:nth-child(3) input").val();
			var Rate=$(this).find("td:nth-child(4) input").val();
			var Amount=unit*Rate;
			$(this).find("td:nth-child(5) input").val(Amount.toFixed(2));
			total=total+Amount;
		});
		$('input[name="total"]').val(total.toFixed(2));
	}
	
	$('.select_address').on("click",function() { 
		open_address();
    });
	
	$('.closebtn').on("click",function() { 
		$("#myModal1").hide();
    });
	
	
	
	
	function open_address(){
		var customer_id=$('select[name="customer_id"]').val();
		$("#result_ajax").html('<div align="center"><?php echo $this->Html->image('/img/wait.gif', ['alt' => 'wait']); ?> Loading</div>');
		var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'addressList']); ?>";
		url=url+'/'+customer_id,
		$("#myModal1").show();
		$.ajax({
			url: url,
		}).done(function(response) {
			$("#result_ajax").html(response);
		});
	}
	
	$('.insert_address').die().live("click",function() { 
		var addr=$(this).text();
		$('textarea[name="customer_address"]').val(addr);
		$("#myModal1").hide();
    });
	

	
	$('select[name="customer_id"]').on("change",function() {
		var file=$('select[name="customer_id"] option:selected').attr('file');
		if(file==0){
			$('select[name="customer_id"]').closest('.col-md-9').append('<span id="fileerror" style="color:#a94442;">This customer has not linked with any file. </span>');
		}else{
			$('select[name="customer_id"]').closest('.col-md-9').find('span#fileerror').remove();
		}
		var contact_person=$('select[name="customer_id"] option:selected').attr('contact_person');
		$('input[name="customer_for_attention"]').val(contact_person);
		
		var customer_id=$('select[name="customer_id"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'defaultAddress']); ?>";
		url=url+'/'+customer_id,
		$.ajax({
			url: url,
		}).done(function(response) {
			$('textarea[name="customer_address"]').val(response);
		});
		
		var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'defaultContact']); ?>";
		url=url+'/'+customer_id,
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json'
		}).done(function(response) {
			$('input[name="customer_for_attention"]').val(response.contact_person);
			$('input[name="customer_contact_no"]').val(response.mobile);
		});
		
		$("#qt3_div").html('Loading...');
		var url="<?php echo $this->Url->build(['controller'=>'Filenames','action'=>'listFilename']); ?>";
		url=url+'/'+customer_id,
		$.ajax({
			url: url,
		}).done(function(response) {
			$("#qt3_div").html(response);
		});
    });
	
	$('select[name="company_id"]').on("change",function() {
		var alias=$('select[name="company_id"] option:selected').attr("alias");
		$('input[name="qt1"]').val(alias);
		
		var employee_id=$('select[name="customer_id"] option:selected').attr("employee_id");
		$("select[name=employee_id]").val(employee_id);
    });
	
	$('.select_term_condition').die().live("click",function() { 
		var addr=$(this).text();
		$("#myModal2").show();
    });
	
	$('.closebtn2').on("click",function() { 
		$("#myModal2").hide();
    });
	
	$('.closebtn').live("click",function() { 
		$(".modal").hide();
    });
	
	$('.popup_btn').live("click",function() {
		var popup_id=$(this).attr('popup_id');
		$("div[popup_div_id="+popup_id+"]").show();
    });
	
	$('.insert_tc').die().live("click",function() {
		$('#sortable').html("");
		
		$(".tabl_tc tbody tr").each(function(){
			var v=$(this).find('td:nth-child(1)  input[type="checkbox"]:checked').val();
			if(v){
				var tc=$(this).find('td:nth-child(1) .check_value').val();
				 
				$('#sortable').append('<li class="ui-state-default">'+tc+'</li>');
			}
		});
		var terms_conditions=$("#terms_conditions").html();
		$('div[name="terms_conditions"]').html(terms_conditions);
		$("#myModal2").hide();
    });
	
	function copy_term_condition_to_textarea(){
		$('#terms_conditions').html("");
		var inc=0;
		var tc_li = '';
		$("#sortable li").each(function(){
			var tc=$(this).text();
			++inc;
			tc_li += '<li>'+tc+'</li>';
		});
		$('#terms_conditions').append('<ol>'+ tc_li  +'</ol>');
		var terms_conditions=$("#terms_conditions").html();
		$('#terms_conditions_box').closest('#t_c_box').find('div[class="note-editable"]').html(terms_conditions);
		$("#sortable li").remove();
		var code=$('#terms_conditions_box').code();
		$('textarea[name="terms_conditions"]').val(code);
	}
	
	$(".updatetc").die().on("click",function(){
		copy_term_condition_to_textarea();
	})
	
	$("select.item_box").each(function(){
		var popup_id=$(this).attr('popup_id');
		var item_id=$(this).val();
		if(popup_id){
			last_three_rates_onload(popup_id,item_id);
		}
	});
	
	$("select.item_box").die().live("change",function(){
		var popup_id=$(this).attr('popup_id');
		var item_id=$(this).val();
		last_three_rates(popup_id,item_id);
	})
	
	function last_three_rates_onload(popup_id,item_id){
			var customer_id=$('select[name="customer_id"]').val();
			$('div[popup_ajax_id='+popup_id+']').html('<div align="center"><?php echo $this->Html->image('/img/wait.gif', ['alt' => 'wait']); ?> Loading</div>');
			if(customer_id){
				var url="<?php echo $this->Url->build(['controller'=>'Invoices','action'=>'RecentRecords']); ?>";
				url=url+'/'+item_id+'/'+customer_id,
				$.ajax({
					url: url,
					dataType: 'json',
				}).done(function(response) {
					$('input[r_popup_id='+popup_id+']').attr({ min:response.minimum_selling_price}).rules('add', {
						min: response.minimum_selling_price,
						messages: {
							min: "Minimum selling price: "+response.minimum_selling_price
						}
					});
					$('div[popup_ajax_id='+popup_id+']').html(response.html);
					
				});
			}else{
				$('div[popup_ajax_id='+popup_id+']').html('Select customer first.');
				$(".item_box[popup_id="+popup_id+"]").val('').select2();
			}
	}
	
	function last_three_rates(popup_id,item_id){
			var customer_id=$('select[name="customer_id"]').val();
			$('.modal[popup_div_id='+popup_id+']').show();
			$('div[popup_ajax_id='+popup_id+']').html('<div align="center"><?php echo $this->Html->image('/img/wait.gif', ['alt' => 'wait']); ?> Loading</div>');
			if(customer_id){
				var url="<?php echo $this->Url->build(['controller'=>'Invoices','action'=>'RecentRecords']); ?>";
				url=url+'/'+item_id+'/'+customer_id,
				$.ajax({
					url: url,
					dataType: 'json',
				}).done(function(response) {
					if(response.minimum_selling_price>0){
						$('input[r_popup_id='+popup_id+']').attr({ min:response.minimum_selling_price}).rules('add', {
							min: response.minimum_selling_price,
							messages: {
								min: "Minimum selling price: "+response.minimum_selling_price
							}
						});
					}
					else{
						$('input[r_popup_id='+popup_id+']').attr({ min:response.minimum_selling_price}).rules('add', {
							min: 0.01
						});
						
					}
					$('div[popup_ajax_id='+popup_id+']').html(response.html);
				});
			}else{
				$('div[popup_ajax_id='+popup_id+']').html('Select customer first.');
				$(".item_box[popup_id="+popup_id+"]").val('').select2();
			}
	}
	$("#select_all").change(function(){ 
				$(".check_value").prop('checked', $(this).prop("checked"));
				$.uniform.update(); 
	});
	
	//rename_rows();
	//calculate_total();
	
});

</script>
	 
<div id="myModal1" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false" style="display: none; padding-right: 12px;"><div class="modal-backdrop fade in" ></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" id="result_ajax">
				
			</div>
			<div class="modal-footer">
				<button class="btn default closebtn">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="myModal2" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false" style="display: none; padding-right: 12px;"><div class="modal-backdrop fade in" ></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" id="result_ajax">
			<h4>Commercial Terms & Conditions</h4>
				<div style=" overflow: auto; height: 450px;">
				<table class="table table-hover tabl_tc">
				<tr>
					<th>
						<label>
						<input type="checkbox" id="select_all"/> Selecct All
						</label>
					</th>
				</tr>
				<?php foreach ($termsConditions as $termsCondition): ?>
					 <tr>
						 
						<td>
						 <div class="checkbox-list">
							<label>
								<input type="checkbox" name="dummy" value="<?= h($termsCondition->text_line) ?>" class="check_value"><?= h($termsCondition->text_line) ?>
							</label> 
						 </div>
						
						</td>
					</tr>
				<?php endforeach; ?>
				</table>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn default closebtn2">Close</button>
				<button class="btn btn-primary insert_tc">Insert</button>
			</div>
		</div>
	</div>
</div>
