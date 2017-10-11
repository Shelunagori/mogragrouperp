
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Material Indent 
				
			</span>
			
		</div>
		
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
				
				<?php $page_no=$this->Paginator->current('SalesOrders'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th width="5%" >S. No.</th>
							<?php if($status == 'salesorder'){ ?>
								<th width="15%" >Sales Order No</th>
							<?php }else if($status == 'jobcard'){ ?>
								<th width="15%" >Job Card No</th>
							<?php }else if($status == 'purchaseorder'){ ?>
								<th width="15%" >Purchase Order No</th>
							<?php }else if($status == 'quotation'){ ?>
								<th width="15%" >Quotation No</th>
							<?php }else if($status == 'mi'){ ?>
								<th width="15%" >Material Indent No</th>
							<?php } ?>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						$i=0;
						foreach ($salesOrders as $salesOrder): ?>
						<tr>
							<td><?= h(++$i) ?></td>
							<td>
							<?php if($status == 'salesorder'){ ?>
								<?php if($salesOrder->gst=="no")
									{ ?>
								
								<?php echo $this->Html->link($salesOrder->so1.'/SO-'.str_pad($salesOrder->so2, 3, '0', STR_PAD_LEFT).'/'.$salesOrder->so3.'/'.$salesOrder->so4,['controller'=>'SalesOrders','action' => 'confirm', $salesOrder->id],array('escape'=>false,'target'=>'_blank','data-original-title'=>'View as PDF')); 
								?>
									<?php  }else{
										 echo $this->Html->link($salesOrder->so1.'/SO-'.str_pad($salesOrder->so2, 3, '0', STR_PAD_LEFT).'/'.$salesOrder->so3.'/'.$salesOrder->so4,['controller'=>'SalesOrders','action' => 'gstConfirm', $salesOrder->id],array('escape'=>false,'target'=>'_blank','data-original-title'=>'View as PDF')); 
								
									} 
							}else if($status == 'jobcard'){
								 echo $this->Html->link($salesOrder->jc1.'/JC-'.str_pad($salesOrder->jc2, 3, '0', STR_PAD_LEFT).'/'.$salesOrder->jc3.'/'.$salesOrder->jc4,['controller'=>'JobCards','action' => 'view', $salesOrder->id],array('escape'=>false,'target'=>'blank','data-original-title'=>'View')); 
							}else if($status == 'purchaseorder'){
								 echo $this->Html->link($salesOrder->po1.'/PO-'.str_pad($salesOrder->po2, 3, '0', STR_PAD_LEFT).'/'.$salesOrder->po3.'/'.$salesOrder->po4,['controller'=>'PurchaseOrders','action' => 'confirm', $salesOrder->id],array('escape'=>false,'target'=>'blank','data-original-title'=>'View')); 
							}else if($status == 'quotation'){
								 echo $this->Html->link($salesOrder->qt1.'/QT-'.str_pad($salesOrder->qt2, 3, '0', STR_PAD_LEFT).'/'.$salesOrder->qt3.'/'.$salesOrder->qt4,['controller'=>'Quotations','action' => 'confirm', $salesOrder->id],array('escape'=>false,'target'=>'blank','data-original-title'=>'View'));
							}else if($status == 'mi'){ 
								echo $this->Html->link('#'.str_pad($salesOrder->mi_number, 4, '0', STR_PAD_LEFT),['controller'=>'MaterialIndents','action' => 'edit', $salesOrder->id],array('escape'=>false,'target'=>'blank','data-original-title'=>'View'));
							}	?>
							</td>	
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				</div>
	</div>
	</div>
				
			</div>
		</div>

