<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Stock_report_".$date.'_'.$time;

	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );  

?>			
<table border="1">
	<thead>
		<tr>
			<td colspan="6" align="center">
				 Stock Report
				<?php if(!empty($from_date) || !empty($to_date)){ echo date('d-m-Y',strtotime($from_date)); ?> TO <?php echo date('d-m-Y',strtotime($to_date));} ?>
			</td>
		</tr>
		<?php if(!empty($ItemCategories) || !empty($ItemsName) || !empty($itemGroups) || !empty($ItemSubGroups) || !empty($stock)){ ?>
		<tr>
			<td align="left" width="10%">
				Category :
				<?php if(!empty($ItemCategories)){ ?><b><?php echo $ItemCategories['name'];  } ?></b>
			</td>
			<td align="left">
				Item : 
				<?php if(!empty($ItemsName)){ ?><b><?php echo $ItemsName['name'];  } ?></b>
			</td>
			<td align="left" colspan="2" width="10%">
				Item Group :
				<?php if(!empty($itemGroups)){ ?><b><?php echo $itemGroups['name'];  } ?></b>
			</td>
			<td align="left" width="10%" >
				Item Sub Group : 
				<?php if(!empty($ItemSubGroups)){ ?><b><?php echo $ItemSubGroups['name'];  } ?></b>
			</td>
			<td align="left" width="10%" >
				Stock :
				<?php if(!empty($stock)){ ?><b><?php echo $stock;  } ?></b>
			</td>
		</tr>	
		<?php } ?>		
		<tr>
			<th>Sr. No.</th>
			<th>Item</th>
			<th>Current Stock</th>
			<th>Unit</th>
			<th style="text-align:right;">Unit Rate</th>
			<th style="text-align:right;">Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php $total_inv=0; $page_no=0; 
		foreach ($item_stocks as $key=> $item_stock){
		if($item_stock!=0){
			if(@$in_qty[$key]==0){ 
				$per_unit=@$item_rate[$key];
			}else{
				$per_unit=@$item_rate[$key]/@$in_qty[$key];
			}
		}else{ 
			if(@$in_qty[$key]==0){ 
				$per_unit=@$item_rate[$key];
			}else{
				$per_unit=@$item_rate[$key]/@$in_qty[$key];
			}
			
		}
		
		$amount=@$item_stock*abs($per_unit);
		$total_inv+=$amount;
		?>
							
			<tr class="main_tr" id="<?= h($key) ?>">
				<td><?= h(++$page_no) ?></td>
				<td width="20%">
					
					<?= h($items_names[$key]) ?></td>
				<td><?= h($item_stock) ?></td>
				<td><?= h($items_unit_names[$key]) ?></td>
				<td align="right">
					<?php if($item_stock!=0){ ?>
						<?= h($this->Number->format(@$per_unit,['places'=>2])) ?>
					<?php } ?>
				</td>
				<td align="right"><?php if(abs($amount)==0){ $amount=abs($amount);  } ?><?= h($this->Number->format($amount,['places'=>2])) ?></td>
			</tr>
			
			<?php } ?>
			<?php if($to_date == date('d-m-Y')){ ?>
			<?php $page_no1=$page_no; foreach($ItemDatas as $key=>$ItemData){ ?>
			
			<tr class="main_tr1" id="<?= h($key) ?>">
				<td><?= h(++$page_no1) ?></td>
				<td width="20%">
					
					<?= h($ItemData) ?></td>
				
				<td><?= h(0) ?></td>
				
				<td><?= h($ItemUnits[$key]) ?></td>
				<td align="right"><?= h($this->Number->format(0,['places'=>2])) ?></td>
				<td align="right"><?= h($this->Number->format(0,['places'=>2])) ?></td>
			</tr>
			<?php }} ?>
			<tr>
				<td colspan="5" align="right">Total</td>
				<td align="right"><?= h($this->Number->format($total_inv,['places'=>2])) ?></td>
			</tr>
		</tbody>
</table>	