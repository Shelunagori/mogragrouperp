<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Details of Travelling / Daily Expenses</span>
			
		</div>

	</div>
	<div class="portlet-body form">
		<?=   $this->Form->create($requestTravellings,['id'=>'form_sample_3']) ?>
		<div class="form-body">
			<div class="row">
				
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-3 control-label">Employee Name</label>
						<div class="col-md-9">
							<?php echo $Employee->name; ?>
						</div>
					</div>
				</div>
			</div><br/>
			<div class="row">
				
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-3 control-label">Destination</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('destination', ['type' => 'text','label' => false,'class' => 'form-control input-sm']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			<div class="row">
				
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-3 control-label">Reason</label>
						<div class="col-md-9">
							<?php echo $this->Form->input('reason', ['type' => 'text','label' => false,'class' => 'form-control input-sm']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			<div class="row">
			
			</div><br/>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-4 control-label">1] Part –I (Attach bus and railway receipt)</label>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12" style="border:1px">
					<div class="form-group">
						<table id="main_table" width="50%"  class="table table-condensed">
							<thead>
								<tr>
									<th>Sr./No</th>
									<th>Date /Time/Of Departure</th>
									<th >From</th>
									<th >To</th>
									<th >Mode Of Transport/Class</th>
									<th>Amount Paid(Rs.)</th>
									<th>Bill(Yes/No)</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="maintbody">
							
							</tbody>
						</table>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12" >
					<div class="form-group">
						<label class="col-md-4 control-label">2]  Part-II (Hotel Expenses)</label>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12" style="border:1px solid">
					<div class="form-group">
						<label class="col-md-1 control-label">Sr./No.</label>
						<label class="col-md-3 control-label">Date & Time of Departure</label>
						<label class="col-md-1 control-label">From</label>
						<label class="col-md-1 control-label">To</label>
						<label class="col-md-1 control-label">No Of Days</label>
						<label class="col-md-2 control-label">Rate/Day</label>
						<label class="col-md-2 control-label">Amount Paid(Rs.)</label>
						<label class="col-md-1 control-label">Bill (Yes/No)</label>
					</div>
					
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-4 control-label">3]  Part-III (Details of Conveyance Expenses)</label>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12" style="border:1px solid">
					<div class="form-group">
						<label class="col-md-1 control-label">Sr./No.</label>
						<label class="col-md-2 control-label">Date & Time of Departure</label>
						<label class="col-md-1 control-label">From</label>
						<label class="col-md-1 control-label">To</label>
						<label class="col-md-1 control-label">Date & Time of Arrival</label>
						<label class="col-md-3 control-label">Mode of Transport/Class</label>
						<label class="col-md-2 control-label">Amount Paid(Rs.)</label>
						<label class="col-md-1 control-label">Bill (Yes/No)</label>
					</div>
					
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-4 control-label">4]  Part-IV (Details of Food Expenses)</label>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12" style="border:1px solid">
					<div class="form-group">
						<label class="col-md-1 control-label">Sr./No.</label>
						<label class="col-md-2 control-label">Date</label>
						<label class="col-md-4 control-label">Particulars</label>
						<label class="col-md-2 control-label">Amount Paid(Rs.)</label>
						<label class="col-md-2 control-label">Bill (Yes/No)</label>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-4 control-label">5]  Visit report in short</label>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12" style="border:1px solid">
					<div class="form-group">
						<label class="col-md-1 control-label">Sr./No.</label>
						<label class="col-md-2 control-label">Date & Time</label>
						<label class="col-md-3 control-label">Company Visited</label>
						<label class="col-md-3 control-label">Name of Person</label>
						<label class="col-md-3 control-label">Discussion</label>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-4 control-label">6] Total Amount Paid {Part (I+ II+III+IV+V)}</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('total_amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm']); ?>
						</div>
					</div>
					
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-4 control-label">7] Total amount approved for payment (In Rs.)</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('approved_amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm']); ?>
						</div>
					</div>
				</div>
			</div><br/>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-12 control-label"><b>Note: </b>This form should be submitted by the employee within 7 days of the return from the journey to the Accounts Department with proper billing proofs.</label>
					</div>
				</div>
			</div><br/><br/><br/>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-4 control-label">Employee Signature</label>
						<label class="col-md-4 control-label">Signature of Checker</label>
						<label class="col-md-4 control-label">Signature of Sanctioning Authority</label>
					</div>
				</div>
			</div><br/><br/><br/>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-8 control-label">C.C 1) M.D. /STL
							<br>   2)  Accounts Dept.
							<br>   3)  HR Dept.</label>
						<label class="col-md-4 control-label">Anshul Mogra <br>(Director (Mktg.)</label>
					</div>
					<div class="form-group">
						
					</div>
				</div>
			</div><br/>
		</div>
		<br/>
	</div>
		
		<?= $this->Form->end() ?>
	</div>
</div>
<style>

.padding-right-decrease{
	padding-right: 0;
}
.padding-left-decrease{
	padding-left: 0;
}
</style>
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
	//--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
				transaction_date:{
					required: true,
				},
				item_id :{
							required: true,
						  },
				quantity :{
							required: true,
						  }
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
			validate_serial();
			success3.show();
			error3.hide();
			form[0].submit(); // submit the form
		}

	});
	
	
	add_row();
	$('.add_row').die().live("click",function() { 
		add_row();  
	});
	function add_row(){  
		var tr2=$("#sampletable tbody tr").clone();
		$("#main_table tbody#maintbody").append(tr2);
		rename_rows();
		
	}

	$('.deleterow').live("click",function() {
			var l=$(this).closest("table tbody").find("tr").length;
			if (confirm("Are you sure to remove row ?") == true) {
				if(l>1){
					var del=$(this).closest("tr");
					$(del).remove();
					rename_rows();
				}
			} 
		});
	

	function rename_rows(){
		var j=0;
		$("#main_table tbody#maintbody tr.main").each(function(){
			
			$(this).find("td:nth-child(1)").html(++j); --j;
			$(this).find('td:nth-child(2) input').attr({name:"inventory_transfer_voucher_rows["+j+"][quantity]", id:"inventory_transfer_voucher_rows-"+j+"-quantity"}).rules("add", "required");
		
			$(this).find('td:nth-child(3) input').attr({name:"inventory_transfer_voucher_rows["+j+"][amount]", id:"inventory_transfer_voucher_rows-"+j+"-amount"}).rules("add", "required");
			
			$(this).find('td:nth-child(4) input').attr({name:"inventory_transfer_voucher_rows["+j+"][amount]", id:"inventory_transfer_voucher_rows-"+j+"-amount"}).rules("add", "required");
			
			$(this).find('td:nth-child(5) input').attr({name:"inventory_transfer_voucher_rows["+j+"][amount]", id:"inventory_transfer_voucher_rows-"+j+"-amount"}).rules("add", "required");
			
			$(this).find('td:nth-child(6) input').attr({name:"inventory_transfer_voucher_rows["+j+"][amount]", id:"inventory_transfer_voucher_rows-"+j+"-amount"}).rules("add", "required");
			j++; 
		});
	}	


});

</script>

<table id="sampletable" style="display:none;">
	<tbody>
		<tr class="main">
			<td width="2%"></td>
			<td width="10%">
				<?php echo $this->Form->input('q', ['type' => 'text','label' => false,'class' => 'form-control input-sm qty_bx_in','placeholder' => 'Quantity']); ?>
			</td>
			<td width="10%"> 
				<?php echo $this->Form->input('q', ['type' => 'text','label' => false,'class' => 'form-control input-sm qty_bx_in','placeholder' => 'Quantity']); ?>
			</td>
			<td width="10%">
				<?php echo $this->Form->input('amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm ','placeholder' => 'Rate']); ?>
			</td>
			<td width="10%">
				<?php echo $this->Form->input('amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm ','placeholder' => 'Rate']); ?>
			</td>
			<td width="10%">
				<?php echo $this->Form->input('narration', ['type' => 'text','label' => false,'class' => 'form-control input-sm ','placeholder' => 'Narration']); ?>
			</td>
			<td width="10%">
				<?php echo $this->Form->input('amount', ['type' => 'text','label' => false,'class' => 'form-control input-sm ','placeholder' => 'Rate']); ?>
			</td>
			<td width="10%"><a class="btn btn-xs btn-default add_row" href="#" role='button'><i class="fa fa-plus"></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times"></i></a></td>
		</tr>
	</tbody>
</table>