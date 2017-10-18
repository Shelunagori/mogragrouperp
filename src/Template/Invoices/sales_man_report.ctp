
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">GST Sales Man Report</span>
		</div>
		<div class="actions">
			
		</div>
		
	
	<div class="portlet-body form">
		<form method="GET">
			<table width="50%" class="table table-condensed">
				<tbody>
					<tr>
						<td width="10%">
							<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" value="<?php echo @date('d-m-Y', strtotime($From));  ?>"  data-date-format="dd-mm-yyyy">
						</td>	
						<td width="10%">
							<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" value="<?php echo @date('d-m-Y', strtotime($To));  ?>"  data-date-format="dd-mm-yyyy" >
						</td>
						<td width="10%">
								<?php echo $this->Form->input('item_name', ['empty'=>'---Items---','options' => $Items,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category','value'=> h(@$item_name) ]); ?>
						</td>
						<td width="10%">
								<?php echo $this->Form->input('item_category', ['empty'=>'---Category---','options' => $ItemCategories,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category','value'=> h(@$item_category) ]); ?>
						</td>
						<td width="10%">
							<div id="item_group_div">
							<?php echo $this->Form->input('item_group_id', ['empty'=>'---Group---','options' =>$ItemGroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Group','value'=> h(@$item_group)]); ?></div>
						</td>
						<td width="10%">
							<div id="item_sub_group_div">
							<?php echo $this->Form->input('item_sub_group_id', ['empty'=>'---Sub-Group---','options' =>$ItemSubGroups,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Sub-Group','value'=> h(@$item_sub_group)]); ?></div>
						</td>
						<td width="10%">
							<?php echo $this->Form->input('salesman_name', ['empty'=>'---SalesMan---','options' => $SalesMans,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category','value'=> h(@$salesman_id) ]); ?>
						</td>
						<td width="5%">
							<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
						</td>
					</tr>
				</tbody>
			</table>
			</form>
		<!-- BEGIN FORM-->
		<div class="row ">
		
		
		<div class="col-md-12">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
					<?php $col=sizeof($invoicesGst->toArray()); $col=($col*1)+4;  ?>
						<td colspan="<?php echo $col; ?>" align="center"  valign="top">
							<h4 class="caption-subject font-black-steel uppercase">Sales Invoice</h4>
						</td>
					</tr>
					<tr>
						<th>Sr.No.</th>
						<th>Invoice No</th>
						<th>Date</th>
						<th>Customer</th>
						<?php foreach($invoicesGst as $Key1=> $SaleTaxeGst){ 
							if($SaleTaxeGst->cgst == 'Yes'){
								$saletax=($SaleTaxeGst->tax_figure*2); ?>
							<th style="text-align:right;">Sales GST @ <?php echo $saletax; ?> % </th>	
						<?php	}else{
								$saletax=$SaleTaxeGst->tax_figure; ?>
							<th style="text-align:right;">Sales IGST @ <?php echo $saletax; ?> % </th>	
						<?php }  } ?>
					</tr>
				</thead>
				
					<?php $SalesTotal=[];$SalesgstTotal=[];$gstRowTotal=[]; $gstTotal=[];$i=1; $SigstRowTotal=[];$SigstTotal=[];
					foreach ($invoices as $invoice):
						foreach($invoice->invoice_rows as $invoice_row)
						{ 
							 if($invoice_row['igst_percentage'] == 0){
							
							@$gstTotal[$invoice->id][$invoice_row['cgst_percentage']]+=@$gstTotal[$invoice->id][$invoice_row['cgst_percentage']]+(@$invoice_row->taxable_value);
							}
							else if($invoice_row['igst_percentage'] > 0){
								@$SigstTotal[$invoice->id][$invoice_row['igst_percentage']]+=@$SigstTotal[$invoice->id][$invoice_row['igst_percentage']]+$invoice_row->taxable_value;
							} 
						}
						
						
					?>
				
				
					
				<tbody>
					<tr>
						<td><?php echo $i; ?></td>
						<td>
							<?php echo $this->Html->link( $invoice->in1.'/IN-'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$invoice->in3.'/'.$invoice->in4,[
							'controller'=>'Invoices','action' => 'gstConfirm',$invoice->id],array('target'=>'_blank')); ?>
						</td>
						<td><?php echo date("d-m-Y",strtotime($invoice->date_created)); ?></td>
						<td><?php echo $invoice->customer->customer_name.'('.$invoice->customer->alias.')'?></td>
						<?php $k=0; $AllTaxs=[];
							foreach($invoicesGst as $Key1=>$SaleTaxeGst){ 
									$AllTaxs[$k]=$SaleTaxeGst->id;
									$k++;
							}
							//pr($AllTaxs); exit;
						?>
						<?php foreach($AllTaxs as  $key=>$AllTax){ 
							if(isset($gstTotal[$invoice->id][$AllTax]))
							{?>
								
									<td style="text-align:right;"><?php echo $this->Number->format($gstTotal[$invoice->id][$AllTax]+(@$invoice->fright_amount),['places'=>2]); 
									$SalesgstTotal[$AllTax]=@$SalesgstTotal[$AllTax]+$gstTotal[$invoice->id][$AllTax]+(@$invoice->fright_amount);
									?></td>
									<?php 
							}else if(isset($SigstTotal[$invoice->id][$AllTax])){  ?>
								<td style="text-align:right;"><?php echo $this->Number->format($SigstTotal[$invoice->id][$AllTax]+(@$invoice->fright_amount),['places'=>2]); 
									$gstRowTotal[$AllTax]=@$gstRowTotal[$AllTax]+$SigstTotal[$invoice->id][$AllTax]+(@$invoice->fright_amount);
									?></td>
							<?php }							
							else 
							{ 
							?>
								
								<td style="text-align:right;"><?php echo "-"; ?></td>
							<?php 
							} 
							
						}  ?>
						
					</tr>
				<?php $i++; endforeach; ?>
				<tr>
				<td style="text-align:right;" colspan=4><b>Total</b></td>
				<?php 
					foreach($invoicesGst as $Key1=>$SaleTaxeGst){  
						if(!empty($SalesgstTotal[$SaleTaxeGst->id])){
					?>
						<td style="text-align:right;"><b><?php echo 
						$this->Number->format(@$SalesgstTotal[$SaleTaxeGst->id],['places'=>2]); ?></b></td>
					<?php }else if(!empty($gstRowTotal[$SaleTaxeGst->id])){ ?>
						<td style="text-align:right;"><b><?php echo 
						$this->Number->format(@$gstRowTotal[$SaleTaxeGst->id],['places'=>2]); ?></b></td>
					<?php }
					else{ ?>
						<td style="text-align:right;"><b>-</b></td>
						
					<?php }} ?>
				
				</tr>
				</tbody>
				</table>
				
		
		<table class="table table-bordered table-condensed">
				<thead>
					<tr><?php $col=sizeof($invoicesGst->toArray()); $col=($col*1)+5;  ?>
						<td colspan="<?php echo $col; ?>" align="center"  valign="top">
							<h4 class="caption-subject font-black-steel uppercase">Sales Order Booked</h4>
						</td>
					</tr>
					<tr>
						<th>Sr.No.</th>
						<th>Sales Order  No</th>
						<th>Date</th>
						<th>Customer</th>
						<?php foreach($invoicesGst as $Key1=> $SaleTaxeGst){ 
							if($SaleTaxeGst->cgst == 'Yes'){
								$saletax=($SaleTaxeGst->tax_figure*2); ?>
							<th style="text-align:right;">Sales GST @ <?php echo $saletax; ?> % </th>	
						<?php	}else{
								$saletax=$SaleTaxeGst->tax_figure; ?>
							<th style="text-align:right;">Sales IGST @ <?php echo $saletax; ?> % </th>	
						<?php }  } ?>
						<th style="text-align:right;">Expected Delivery Date</th>
					</tr>
				</thead>
				
					<?php $SalesOrderTotal=[];$SalesOrdergstTotal=[];$SalesOrdergstRowTotal=[]; $SalesOrdergstTotal=[];$i=1; $SalesOrderigstRowTotal=[];$SalesOrderigstTotal=[];
					foreach ($SalesOrders as $SalesOrder):
						foreach($SalesOrder->sales_order_rows as $sales_order_rows)
						{ 
							 if($sales_order_rows['igst_per'] == 0){
							
							@$SalesOrderTotal[$SalesOrder->id][$sales_order_rows['cgst_per']]=@$SalesOrderTotal[$SalesOrder->id][$sales_order_rows['cgst_per']]+(@$sales_order_rows->taxable_value);
							}
							else if($sales_order_rows['igst_per'] > 0){
								@$SalesOrderigstTotal[$SalesOrder->id][$sales_order_rows['igst_per']]=@$SalesOrderigstTotal[$SalesOrder->id][$sales_order_rows['igst_per']]+$sales_order_rows->taxable_value;
							} 
						}
						
						
					?>
				
				<tbody>
					<tr>
						<td><?php echo $i; ?></td>
						<td>
							<?php echo $this->Html->link( $SalesOrder->so1.'/SO-'.str_pad($SalesOrder->so2, 3, '0', STR_PAD_LEFT).'/'.$SalesOrder->so3.'/'.$SalesOrder->so4,[
							'controller'=>'SalesOrders','action' => 'gstConfirm',$SalesOrder->id],array('target'=>'_blank')); ?>
						</td>
						<td><?php echo date("d-m-Y",strtotime($SalesOrder->created_on)); ?></td>
						<td><?php echo $SalesOrder->customer->customer_name.'('.$SalesOrder->customer->alias.')'?></td>
						<?php $k=0; $AllTaxs=[];
							foreach($invoicesGst as $Key1=>$SaleTaxeGst){ 
									$AllTaxs[$k]=$SaleTaxeGst->id;
									$k++;
							}
							//pr($AllTaxs); exit;
						?>
						<?php foreach($AllTaxs as  $key=>$AllTax){ 
							if(isset($SalesOrderTotal[$SalesOrder->id][$AllTax]))
							{?>
								
									<td style="text-align:right;"><?php echo $this->Number->format($SalesOrderTotal[$SalesOrder->id][$AllTax],['places'=>2]); 
									$SalesOrdergstRowTotal[$AllTax]=@$SalesOrdergstRowTotal[$AllTax]+$SalesOrderTotal[$SalesOrder->id][$AllTax];
									?></td>
									<?php 
							}else if(isset($SalesOrderigstTotal[$SalesOrder->id][$AllTax])){  ?>
								<td style="text-align:right;"><?php echo $this->Number->format($SalesOrderigstTotal[$SalesOrder->id][$AllTax],['places'=>2]); 
									$SalesOrderigstRowTotal[$AllTax]=@$SalesOrderigstRowTotal[$AllTax]+$SalesOrderigstTotal[$SalesOrder->id][$AllTax];
									?></td>
							<?php }							
							else 
							{ 
							?>
								
								<td style="text-align:right;"><?php echo "-"; ?></td>
							<?php 
							} 
							
						}  ?>
						<td><?php echo date('d-m-Y',strtotime($SalesOrder->expected_delivery_date)); ?></td>
					</tr>
				<?php $i++; endforeach; ?>
				<tr>
				<td style="text-align:right;" colspan=4><b>Total</b></td>
				<?php 
					foreach($invoicesGst as $Key1=>$SaleTaxeGst){  
						if(!empty($SalesOrdergstRowTotal[$SaleTaxeGst->id])){
					?>
						<td style="text-align:right;"><b><?php echo 
						$this->Number->format(@$SalesOrdergstRowTotal[$SaleTaxeGst->id],['places'=>2]); ?></b></td>
					<?php }else if(!empty($SalesOrderigstRowTotal[$SaleTaxeGst->id])){ ?>
						<td style="text-align:right;"><b><?php echo 
						$this->Number->format(@$SalesOrderigstRowTotal[$SaleTaxeGst->id],['places'=>2]); ?></b></td>
					<?php }
					else{ ?>
						<td style="text-align:right;"><b>-</b></td>
						
					<?php }} ?>
				<td></td>
				</tr>
				</tbody>
				</table>
			<!--Opened Quaotation Report Start-->
				
				<table class="table table-bordered table-condensed">
					<thead>
						<tr>
							<td colspan="8" align="center"  valign="top">
								<h4 class="caption-subject font-black-steel uppercase">Open Quotations</h4>
							</td>
						</tr>
						<tr>
							<th>Sr.No.</th>
							<th>Quotation  No</th>
							<th>Date</th>
							<th>Customer</th>
							<th>Brand</th>
							<th>Item</th>
							<th style="text-align:right;">Value</th>
							<th>Expected Finalisation Date</th>
						</tr>
					</thead>
					<?php $i=1; $total=0;
					foreach ($OpenQuotations as $openquotation):    ?>
					<tbody>
						<tr>
							<td>
								<?php echo $i; ?>
							</td>
							<td>
								<?php echo $this->Html->link( $openquotation->qt1.'/QT-'.str_pad($openquotation->qt2, 3, '0', STR_PAD_LEFT).'/'.$openquotation->qt3.'/'.$openquotation->qt4,[
								'controller'=>'Quotations','action' => 'Confirm',$openquotation->id],array('target'=>'_blank')); ?>
							</td>
							<td>
								<?php echo date("d-m-Y",strtotime($openquotation->created_on)); ?>
							</td>
							<td>
								<?php echo @$openquotation->customer->customer_name.'('.@$openquotation->customer->alias.')'?>
							</td>
							<td>
								<?php  echo @$openquotation->quotation_rows[0]->item->item_category->name; ?>
							</td>
							<td>
								<?php  echo @$openquotation->quotation_rows[0]->item->name; ?>
							</td>
							<td align="right">
								<?php  echo $this->Number->format(@$openquotation->total,['places'=>2]);
											$total=$total+($openquotation->total);	?>
							</td>
							<td><?php echo date("d-m-Y",strtotime(@$openquotation->finalisation_date)); ?></td>
							
						</tr>
					<?php $i++; endforeach; ?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td align="right"><b>Total</b></td>
						<td align="right"><b><?php echo $this->Number->format($total,['places'=>2]); ?></b></td>
						<td align="right"></td>
					</tr>
					</tbody>
				</table>
			
			<!--Opened Quaotation Report End-->	
				
				
			<!--Closed Quaotation Report Start-->
						
				<table class="table table-bordered table-condensed">
					<thead>
						<tr>
							<td colspan="8" align="center"  valign="top">
								<h4 class="caption-subject font-black-steel uppercase">Closed Quotations</h4>
							</td>
						</tr>	
						<tr>
							<th>Sr.No.</th>
							<th>Quotation  No</th>
							<th>Date</th>
							<th>Customer</th>
							<th>Brand</th>
							<th>Item</th>
							<th style="text-align:right;">Value</th>
							<th>Closure reason</th>
						</tr>
					</thead>
					<?php $i=1; $total=0;
					foreach ($ClosedQuotations as $closedquotation):    ?>
					<tbody>
						<tr>
							<td>
								<?php echo $i; ?>
							</td>
							<td>
								<?php echo $this->Html->link( $closedquotation->qt1.'/QT-'.str_pad($closedquotation->qt2, 3, '0', STR_PAD_LEFT).'/'.$closedquotation->qt3.'/'.$closedquotation->qt4,[
								'controller'=>'Quotations','action' => 'Confirm',$closedquotation->id],array('target'=>'_blank')); ?>
							</td>
							<td>
								<?php echo date("d-m-Y",strtotime($closedquotation->created_on)); ?>
							</td>
							<td>
								<?php echo @$closedquotation->customer->customer_name.'('.@$closedquotation->customer->alias.')'?>
							</td>
							<td>
								<?php  echo @$closedquotation->quotation_rows[0]->item->item_category->name; ?>
							</td>
							<td>
								<?php  echo @$closedquotation->quotation_rows[0]->item->name; ?>
							</td>
							<td align="right">
								<?php  echo $this->Number->format(@$closedquotation->total,['places'=>2]);
											$total=$total+($closedquotation->total);	?>
							</td>
							<td><?php if(!empty($closedquotation->reason)){ echo @$closedquotation->reason; }else{ echo "-"; } ?></td>
							
						</tr>
					<?php $i++; endforeach; ?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td align="right"><b>Total</b></td>
						<td align="right"><b><?php echo $this->Number->format($total,['places'=>2]); ?></b></td>
						<td align="right"></td>
					</tr>
					</tbody>
				</table>
					
			<!--Closed Quaotation Report End-->
				
				
				
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<script>
$(document).ready(function() {
	$('select[name="item_category"]').on("change",function() {
		$('#item_group_div').html('Loading...');
		var itemCategoryId=$('select[name="item_category"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'ItemGroups','action'=>'ItemGroupDropdown']); ?>";
		url=url+'/'+itemCategoryId,
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			$('#item_group_div').html(response);
			$('select[name="item_group_id"]').select2();
		});
	});	
	//////
	$('select[name="item_group_id"]').die().live("change",function() {
		$('#item_sub_group_div').html('Loading...');
		var itemGroupId=$('select[name="item_group_id"] option:selected').val();
		var url="<?php echo $this->Url->build(['controller'=>'ItemSubGroups','action'=>'ItemSubGroupDropdown']); ?>";
		url=url+'/'+itemGroupId,
		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(response) {
			$('#item_sub_group_div').html(response);
			$('select[name="item_sub_group_id"]').select2();
		});
	});
});
</script>