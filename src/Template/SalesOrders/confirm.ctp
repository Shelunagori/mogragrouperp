<?php //pr($salesorder); exit;
$pdf_url=$this->Url->build(['controller'=>'SalesOrders','action'=>'pdf']);
$list_url=$this->Url->build(['controller'=>'SalesOrders','action'=>'index']);
$edit_url=$this->Url->build(['controller'=>'SalesOrders','action'=>'Edit']);
?>
<table width="100%">
	<tr>
		<td valign="top" style="background: #FFF;">
		<div class="list-group">
			<a href="<?php echo $list_url; ?>" class="list-group-item"><i class="fa fa-chevron-left"></i> Back to Sales Orders </a>
			<?php  foreach($salesorder->sales_order_rows as $sales_order_row){
			if($sales_order_row->processed_quantity != $sales_order_row->quantity AND in_array(4,$allowed_pages)){ 
			if(!in_array(date("m-Y",strtotime($salesorder->created_on)),$closed_month))
			{ 
			?>
			<a href="<?php echo $edit_url.'/'.$id; ?>" class="list-group-item"><i class="fa fa-edit"></i> Edit </a>
			<?php break; } } } ?>
			
			<a href="#" class="list-group-item" onclick="window.close()"><i class="fa fa-times"></i> Close </a>
		</div>
		<div style="padding:5px;height: 400px;overflow: auto;">
		<h4>Adjust height of rows</h4>
		<?= $this->Form->create($salesorder) ?>
			<?php $sr=0; foreach ($salesorder->sales_order_rows as $SalesOrderRows): $sr++;
				echo $this->Form->input('sales_order_rows.'.$SalesOrderRows->id.'.id');
				echo $this->Form->input('sales_order_rows.'.$SalesOrderRows->id.'.height',['label' => 'Row-'.$sr,'class' => 'input-sm quantity','value'=>$SalesOrderRows->height]);				
			endforeach; ?>
			<?= $this->Form->button(__('Update'),['class'=>'btn btn-sm default']) ?>
		<?= $this->Form->end() ?>
		</div>
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