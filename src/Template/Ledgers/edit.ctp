<?php if($allow='YES'){ ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Opening Balance Edit</span>
		</div>
	</div>
	<div class="portlet-body form">

    <?= $this->Form->create($ledger,['id'=>'opening_balance']) ?>
    <div class="form-body">
		<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-md-6 control-label">Ledger Accounts</label>
						<?= h($ledger->ledger_account->name) ?>
						</div>
				</div>
				<div class="col-md-2">
						<div class="form-group">
							<label class="col-md-6 control-label">Date</label>
							<?= h(date("d-m-Y",strtotime($ledger->transaction_date))) ?>
						</div>
					</div>
			<?= $this->Form->hidden('voucher_source',['value'=>'Opening Balance']) ?>
		</div>
	<table class="table table-bordered" id="main_table">
		<tr>
			<td>Ref. No.</td>
			<td>Credit</td>
			<td>Debit</td>
			<td></td>
		</tr>
		<tbody id="main_tbody">
			<?php foreach($ledger_details as $ledger_detail):?>
				<tr class="tr1" row_no='<?php echo @$ledger_detail->id; ?>'>
					<td><?= $this->Form->input('ref_no',['type'=>'text','label'=>false,'value'=>$ledger_detail->ref_no]) ?></td>
					<?php if($ledger_detail->credit==0){ ?>
					<td><?= $this->Form->input('id',['type'=>'hidden','class'=>'','label'=>false, 'value'=>$ledger_detail->id]) ?>
					<?= $this->Form->input('credit',['type'=>'text','disabled'=>true,'class'=>'','label'=>false, 'value'=>$ledger_detail->credit]) ?></td>
					
					<td><?= $this->Form->input('debit',['type'=>'text','class'=>'','label'=>false, 'value'=>$ledger_detail->debit]) ?></td>
					<?php }else{ ?>
						<td><?= $this->Form->input('id',['type'=>'hidden','class'=>'','label'=>false, 'value'=>$ledger_detail->id]) ?>
					<?= $this->Form->input('credit',['type'=>'text','class'=>'','label'=>false, 'value'=>$ledger_detail->credit]) ?></td>
					
					<td><?= $this->Form->input('debit',['type'=>'text','disabled'=>true,'class'=>'','label'=>false,'readonly', 'value'=>$ledger_detail->debit]) ?></td>
					<?php } ?>
					
					<td><?= $this->Form->button(__('<i class="fa fa-plus"></i>'),['type'=>'button','class'=>'addrow','label'=>false]) ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	</div>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
	
</div>
</div>
<table class="table table-bordered" id="temp_table" style="display:none;">
	<tbody>
	<tr class="tr1">
	<td><?= $this->Form->input('reference_no',['type'=>'text','class'=>'distinctreference','label'=>false,'id'=>'reference_no_2']) ?></td>
	<td>
	<?= $this->Form->input('ledger_id',['type'=>'hidden','class'=>'','label'=>false, 'value'=>0]) ?>
	<?= $this->Form->input('credit',['type'=>'text','class'=>'','label'=>false, 'value'=>0]) ?></td>
	<td><?= $this->Form->input('debit',['type'=>'text','class'=>'','label'=>false, 'value'=>0]) ?></td>
	<td><?= $this->Form->button(__('<i class="fa fa-plus"></i>'),['type'=>'button','class'=>'addrow','label'=>false]) ?><?= $this->Form->button(__('<i class="fa fa-minus"></i>'),['type'=>'button','class'=>'remove_row','label'=>false]) ?></td>
	</tr>
	</tbody>
	</table>

<?php }else{ ?>
<span> The ref. no. has been used anywhere, so you can not edit this.</span>
<?php } ?>
	
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {

	
	////////////////  Validation  ////////////////////////
	
	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	}, "No space please and don't leave it empty");
	
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
}, jQuery.format("Please enter a Unique Value."));

	//--------- FORM VALIDATION
	var form3 = $('#opening_balance');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
				ledger_account_id:{
					required: true,
				},
				transaction_date:{
					required: true,
				},
				'reference_no[]':{
					required: true,
					noSpace: true,
					notEqualToGroup: ['.distinctreference'],
					remote : {
                    url: '<?php echo $this->Url->build(['controller'=>'Ledgers','action'=>'check_reference_no']); ?>',
                    type: "get",
                    data:
                        {
                            ledger_account_id: function(){return $('select[name=ledger_account_id] option:selected').val();}
                        },
					},

				}
			},

		messages: { // custom messages for radio buttons and checkboxes
			'reference_no[]': {
				remote: "Reference no. is alredy taken."
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
			success3.show();
			error3.hide();
			form[0].submit(); // submit the form
		}

	});
	//--	 END OF VALIDATION
	
		$('.addrow').die().live("click",function() { 
		add_row();
    });
	function add_row(){
		var tr1=$("#temp_table tbody tr.tr1").clone();
		$("#main_table tbody#main_tbody").append(tr1);
		rename_rows();
	}
	rename_rows();	
function rename_rows(){  
		var i=0;
		$("#main_table tbody#main_tbody tr.tr1").each(function(){
			$(this).attr("row_no",i);
			$(this).find("td:nth-child(1) input").attr({name:"ledger_rows["+i+"][ref_no]", id:"ledger_rows-"+i+"-ref_no",class:"ref_number"}).rules('add', {
				required: true,
				noSpace: true,
				notEqualToGroup: ['.ref_number'],
				messages: {
					remote: "Not an unique."
				}
			});
			$(this).find("td:nth-child(2) input:eq(0)").attr({name:"ledger_rows["+i+"][ledger_id]", id:"ledger_rows-"+i+"-ledger_id"}).rules("add", "required");
			$(this).find("td:nth-child(2) input:eq(1)").attr({name:"ledger_rows["+i+"][credit]", id:"ledger_rows-"+i+"-credit"}).rules("add", "required");
			$(this).find("td:nth-child(3) input").attr({name:"ledger_rows["+i+"][debit]", id:"ledger_rows-"+i+"-debit"}).rules("add", "required");
			i++;
			});
}

$('.remove_row').live("click",function() {
        var sel=$(this);
        $(this).closest("tr").remove();
    });
	
});	
</script>