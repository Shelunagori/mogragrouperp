<?php //pr($quotation->customer->customer_contacts[0]->email); exit;
$pdf_url=$this->Url->build(['controller'=>'Quotations','action'=>'pdf']);
$list_url=$this->Url->build(['controller'=>'Quotations','action'=>'index']);
$edit_url=$this->Url->build(['controller'=>'Quotations','action'=>'Add']);
?>
<table width="100%">
	<tr>
		<td valign="top" style="background: #FFF;">
		<div class="list-group">
			<a href="<?php echo $list_url; ?>" class="list-group-item"><i class="fa fa-chevron-left"></i> Back to Quotations </a>
			<!--
			<?php if($quotation->revision==$revision){ ?>
			<a  data-toggle="modal" class="list-group-item" href="#myModal2"><i class="fa fa-envelope"></i> Email to Customer </a>
			
			<?php } ?>  
			-->
			<?php	echo $this->Html->link('<i class="fa fa-download"></i>Download ',['action' => 'pdf', $quotation->id],array('escape'=>false,'class'=>'list-group-item')); ?>
		
			
			<?php if($quotation->status=='Pending' AND $quotation->revision==$revision AND in_array(2,$allowed_pages) ){ ?>
			<?php
						if(!in_array(date("m-Y",strtotime($quotation->created_on)),$closed_month))
						{ ?>
				<div class="btn-group dropup" style=" width: 100%; ">
					<button type="button" class="list-group-item dropdown-toggle" data-toggle="dropdown" style=" width: 100%; text-align: left; "><i class="fa fa-pencil-square-o" width="100%"></i>Edit</button>
					<ul class="dropdown-menu" role="menu" style=" margin-left: 50px; margin-bottom:-100px; ">
						<li>
							<?php	echo $this->Html->link('<i class="fa fa-file-o"></i>Save as Revision ','/Quotations/Add?revision='.$id,array('escape'=>false,'class'=>''));
							 ?>
						</li>
						<li>
							<?php echo $this->Html->link('<i class="fa fa-repeat"></i>Save as old version ',['action' => 'edit', $quotation->id],array('escape'=>false,'class'=>'')); ?>
						</li>
						
					</ul>
				</div>
				<?php
						} ?>
			<?php } ?>
			<a href="#" class="list-group-item" onclick="window.close()"><i class="fa fa-times"></i> Close </a>
		</div>
		<div style="padding:5px;overflow: auto;">
		<h4>Adjust Font Size</h4>
		<?= $this->Form->create($quotation) ?>
			
							<?php 
							$options=[];
							$options=[['text'=>'8px','value'=>'8px'],['text'=>'9px','value'=>'9px'],['text'=>'10px','value'=>'10px'],['text'=>'11px','value'=>'11px'],['text'=>'12px','value'=>'12px'],['text'=>'13px','value'=>'13px'],['text'=>'14px','value'=>'14px'],['text'=>'15px','value'=>'15px'],['text'=>'16px','value'=>'16px']];

							?>
							<?php echo $this->Form->input('pdf_font_size', ['options'=>$options,'empty' => "--Select Font Size--",'label' => false,'class' => 'form-control input-sm select2me','required']); ?>

			
			<?= $this->Form->button(__('Update'),['class'=>'btn btn-sm default']) ?>
		
		<?= $this->Form->end() ?>
		</div>

		<?php if($quotation->revision==$revision){ ?>
		<div style="padding:5px;height: 400px;overflow: auto;">
		<h4>Adjust height of rows</h4>
		<?= $this->Form->create($quotation) ?>
			<?php $sr=0; foreach ($quotation->quotation_rows as $quotationRows): $sr++;
				echo $this->Form->input('quotation_rows.'.$quotationRows->id.'.id');
				echo $this->Form->input('quotation_rows.'.$quotationRows->id.'.height',['label' => 'Row-'.$sr,'class' => 'input-sm quantity','value'=>$quotationRows->height]);				
			endforeach; ?>
			<?= $this->Form->button(__('Update'),['class'=>'btn btn-sm default']) ?>
		
		<?= $this->Form->end() ?>
		</div>
		<?php } ?>
		</td>
		<td width="80%">
			<object data="<?php echo $pdf_url.'/'.$id; ?>" type="application/pdf" width="100%" height="613px">
			  <p>Wait a while, PDf is loading...</p>
			</object>
		</td>
	</tr>
</table>

<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
	$('.quantity').die().live("keyup",function() {
			var asc=$(this).val();
			var numbers =  /^[0-9]*\.?[0-9]*$/;
			if(asc==0)
			{
				$(this).val('');
				return false; 
			}
			else if(asc.match(numbers))  
			{  
			} 
			else  
			{  
				$(this).val('');
				return false;  
			}
	});
	
	
});
</script>


<div id="myModal2" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style=" padding-right: 12px;"><div class="modal-backdrop fade in" ></div>
	<div class="modal-dialog">
	<?= $this->Form->create($email, ['id'=>'form_sample_3','url' => ['action' => 'email']]) ?>
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
						<br>
						<table width="100%" id="form_sample_3">
							<tr>
								<td>
								<label class="col-md-2 control-label">Email Id</label>
								 <div class="col-md-8" id='TextBoxesGroup'>
								 <?php echo $this->Form->input('quotation_id',['label' => false,'class' => 'form-control input-sm','type'=>'hidden','value' =>$quotation->id]); ?>
									<?php echo $this->Form->input('send_to[]',['label' => false,'class' => 'form-control input-sm','type'=>'email','Placeholder'=>"Email ID",'style'=>'margin-bottom:5px','required','value' =>$quotation->customer->customer_contacts[0]->email]); ?>
								</div>
								<a class="btn btn-xs btn-default" href="#" role='button'><i class="fa fa-plus" id='addButton'></i></a><a class="btn btn-xs btn-default deleterow" href="#" role='button'><i class="fa fa-times" id='removeButton'></i></a>
								
								</td>
							</tr>
							
						</table>
					 </div>
				</div>
				</div>

				
				<br/>
				<div class="row">
						<div class="col-md-12">
							<div class="form-group">
							<table width="100%" >
								<tr>
									<td>
									<label class="col-md-2 control-label">Subject</label>
									<div class="col-md-9">
										<?php echo $this->Form->input('subject', ['label' => false,'class' => 'form-control input-sm','value'=>$quotation->subject]); ?>
									</div>
									</td>
								</tr>
								
								<tr>
									<td><br>
									<label class="col-md-2 control-label">Message</label>
									<div class="col-md-9">
										<?php echo $this->Form->textarea('message', ['label' => false,'class' => 'form-control input-sm']); ?>
									</div>
									</td>
								</tr>
							
								<tr>
							        <td align="center"><br>
									 <div>
									 <button type="submit" class="btn btn-primary">Send</button>
									 <button type="button" class="btn default" data-dismiss="modal">Close</button>
									<div> 
									</td>
								</tr>
							</table>
						 
							</div>
						</div>
				</div> 
			</div>
		
		</div>
	<?= $this->Form->end() ?>
</div>

<script type="text/javascript">

$(document).ready(function(){

var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
				send_to:{
					required: true,	
				},
				
				message:{
					required: true,	
				}
			},
		messages: {
			
		}

		
	});
    var counter = 2;
	$("#addButton").click(function () {

	if(counter>10){
            alert("Only 10 textboxes allow");
            return false;
	}

	var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'TextBoxDiv' + counter); 

	newTextBoxDiv.after().html(
	  '<input type="email" class="form-control input-sm" name="send_to[]" id="textbox' + counter + '" value="" style="margin-bottom:5px;" Placeholder="Email ID" required>');
	
	newTextBoxDiv.appendTo("#TextBoxesGroup");
	
	counter++;
     });

     $("#removeButton").click(function () {
	if(counter==1){
          alert("No more textbox to remove");
          return false;
       }

	counter--;

        $("#TextBoxDiv" + counter).remove();

     });

    
  });
</script>
 



 




 
 