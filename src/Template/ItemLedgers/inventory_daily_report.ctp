<?php //echo $voucher_no->toArray(); exit;?>
<?php $url_excel="/?".$url; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Inventory Daily Report</span>
		</div>
		<div class="actions">
			<?php echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Excel', '/ItemLedgers/Excel-Inventory/'.$url_excel.'',['class' =>'btn  green tooltips','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>
		</div>

	<div class="portlet-body form">
	<div class="row ">
		<div class="col-md-12">
		<form method="GET" >
			<table class="table table-condensed">
				<tbody>
					<tr>
						<td width="20%">
							<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" value="<?php echo date('d-m-Y',strtotime(@$From)); ?>"  data-date-format="dd-mm-yyyy" >
						</td>
						<td width="20%">
							<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" value="<?php echo date('d-m-Y',strtotime(@$To)); ?>"  data-date-format="dd-mm-yyyy" >
						</td>
						<td>
							<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
						</td>
						
					</tr>
				</tbody>
			</table>
		</form>
		
		
		<!-- BEGIN FORM-->
		
			<table class="table table-bordered  ">
				<thead>
					<tr>
						<th width="2%">SR</th>
						<th width="10%">Transaction Date</th>
						<th width="10%">Voucher</th>
						<th width="10%">Item</th>
						<th width="10%">In</th>
						<th width="5%">Out</th>
						<th width="5%">Serial No.</th>
					</tr>
				</thead>
				<tbody>
					<?php $srn=0; foreach ($itemDatas as $key=>$itemData){ 
					
					$row_count=count($itemData);
					?>
					
						<?php $flag=0; foreach($itemData as $itemData) {  ?>
						<tr>
						<?php if($flag==0){?>
						<td style="vertical-align: top !important;" rowspan="<?php echo $row_count; ?>"><?php echo ++$srn; ?> </td>
						<td style="vertical-align: top !important;" rowspan="<?php echo $row_count; ?>"><?php echo date("d-m-Y",strtotime($itemData['processed_on'])); ?></td>
						
						<td style="vertical-align: top !important;" rowspan="<?php echo $row_count; ?>">
							<?php 
							$location='/'.$link[$key]['controller'].'/'.$link[$key]['action'].'/'.$itemData->source_id;
							//$location=$link[$key].'/'.$itemData->source_id;
							//pr($location);
							echo $this->Html->link($voucher_no[$key][0],$location,array('target'=>'_blank'));?>
						</td>
						
						
						
						<?php $flag=1; }?>
						<td style="vertical-align: top !important;"><?php echo $itemData['item']['name']; ?></td>
						<?php if($itemData['in_out']=="In"){ ?>
						<td style="vertical-align: top !important;"><?php echo $itemData['quantity']; ?></td>
						<?php }else{ ?>
						<td style="vertical-align: top !important;"><?php echo "-"; ?></td>
						<?php } ?>
						<?php if($itemData['in_out']=="Out"){ ?>
						<td><?php echo $itemData['quantity']; ?></td>
						<?php }else{ ?>
						<td><?php echo "-"; ?></td>
						<?php } ?>
						
						<td width="30px">
						<?php foreach($serial_nos[$key][$itemData['item_id']] as $sr){ 
							echo $no=$sr['serial_no']; echo "</br>";
							//$srn=implode(',', $no);
						} //echo $srn; ?>
						</td>
						</tr>
						<?php } ?>
						
					
					<?php } ?>
				</tbody>
				</table>
			
		</div>
	</div>
  </div>
</div>
</div>