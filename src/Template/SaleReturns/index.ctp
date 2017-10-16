<?php $url_excel="/?".$url; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Sales Return</span> 
			
		</div>
		<div class='actions'>
			<?php echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Excel', '/SaleReturns/Export-Excel/'.$url_excel.'',['class' =>'btn  green tooltips','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>
		</div>
	<div class="portlet-body">
		<div class="row">
		  <div class="col-md-12">
			<form method="GET" >
				<table class="table table-condensed">
					<tbody>
						<tr>
							
							<td width="20%">  
								<div class="input-group" style="" id="pnf_text">
									<span class="input-group-addon">SR-</span>
									<input type="text" name="vouch_no" class="form-control input-sm" placeholder="Sales Return No" value="<?php echo @$vouch_no; ?>">
								</div>	
							</td>
							
							<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
						</tr>
					</tbody>
				</table>
			</form>
			<?php $page_no=$this->Paginator->current('Invoices'); $page_no=($page_no-1)*20; ?>
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Sr. No.</th>
						<th>Sales Return No.</th>
						<th>Invoice No.</th>
						<th>Date Created</th>
						<th style="text-align:right;">Total</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
						<?php foreach ($saleReturns as $saleReturn): 
						
						?>
					<tr>
						<td><?= h(++$page_no) ?></td>
						<td><?= h(($saleReturn->sr1.'/SR-'.str_pad($saleReturn->sr2, 3, '0', STR_PAD_LEFT).'/'.$saleReturn->sr3.'/'.$saleReturn->sr4)) ?></td>
						
						<td><?= h(($saleReturn->invoice->in1.'/IN-'.str_pad($saleReturn->invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$saleReturn->invoice->in3.'/'.$saleReturn->invoice->in4)) ?></td>
						
						<td><?php echo date("d-m-Y",strtotime($saleReturn->date_created)); ?></td>
						<td align="right"><?= h($this->Number->format($saleReturn->total_after_pnf,[ 'places' => 2])) ?></td>
						<td class="actions">
							<?php if($saleReturn->sale_return_type=="GST"){
								echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'gstSalesEdit/'.$saleReturn->id,],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit'));
							}else{
								echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'Edit/'.$saleReturn->id,],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit'));
								
							}
							 ?>
							
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div>
		</div>
	</div>
				<div class="paginator">
					<ul class="pagination">
						<?= $this->Paginator->prev('< ' . __('previous')) ?>
						<?= $this->Paginator->numbers() ?>
						<?= $this->Paginator->next(__('next') . ' >') ?>
					</ul>
					<p><?= $this->Paginator->counter() ?></p>
				</div>
	</div>
</div>

