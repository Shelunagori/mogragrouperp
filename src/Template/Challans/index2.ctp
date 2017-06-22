<?php //pr($challans); exit; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Challans</span>
		
		</div>
		<div class="actions">
			<div class="btn-group">
			<?= $this->Html->link(
				'Returnable',
				'/Challans/Index',
				['class' => 'btn btn-default']
			); ?>
			<?= $this->Html->link(
				'Non Returnable',
				'/Challans/Index2',
				['class' => 'btn btn-primary']
			); ?>
			</div>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
			<form method="GET" >
				<table class="table table-condensed">
					<tbody>
						<tr>
							<td>
								<div class="row">
									<div class="col-md-6">
										<div class="input-group" style="" id="pnf_text">
											<span class="input-group-addon">CH-</span><input type="text" name="ch2" class="form-control input-sm" placeholder="Challan No" value="<?php echo @$ch2; ?>">
										</div>
									</div>
									<div class="col-md-4">
										<input type="text" name="file" class="form-control input-sm" placeholder="File" value="<?php echo @$file; ?>">
									</div>
								</div>
							</td>
							<td><input type="text" name="customer" class="form-control input-sm" placeholder="Customer" value="<?php echo @$customer; ?>"></td>
							<td>
								<div class="row">
									<div class="col-md-6">
										<input type="text" name="From" class="form-control input-sm date-picker" placeholder="From" value="<?php echo @$From; ?>"  data-date-format="dd-mm-yyyy" >
									</div>
									<div class="col-md-6">
										<input type="text" name="To" class="form-control input-sm date-picker" placeholder="To" value="<?php echo @$To; ?>"  data-date-format="dd-mm-yyyy" >
									</div>
								</div>
							</td>
							
							<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
						</tr>
					</tbody>
				</table>
				</form>		
				<?php $page_no=$this->Paginator->current('Challans'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Ref. No</th>
								<th>Challan For</th>
								<th>Customer/Vendor Name</th>
								<th>Company name</th>
								<th>Transporter Name</th>
								<th>LR No</th>
								<th>Reference Detail</th>
								<th>Total.</th>
								
								
								<th class="actions"><?= __('Actions') ?></th>
							</tr>
					
					</thead>

					<tbody>
            <?php foreach ($challans as $challan): ?>
            <tr>
				<?php $type=$challan->challan_for; ?>
                <td><?= h(++$page_no) ?></td>
				<td><?= h(($challan->ch1.'/CH-'.str_pad($challan->ch2, 3, '0', STR_PAD_LEFT).'/'.$challan->ch3.'/'.$challan->ch4)) ?></td>
                <td><?= h($challan->challan_for) ?></td>
				<td><?php if($challan->customer_id){ echo $challan->customer->customer_name;  }elseif($challan->vendor_id){ echo $challan->vendor->company_name; } ?></td>
                <td><?= h($challan->company->name) ?></td>
				<td><?= h($challan->transporter->transporter_name) ?></td>
                <td><?= $this->Number->format($challan->lr_no) ?></td>
                <td><?= h($challan->reference_detail) ?></td>
                <td><?= $this->Number->format($challan->total) ?></td>
               
				<td class="actions">
								<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'confirm', $challan->id],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-xs yellow tooltips','data-original-title'=>'View as PDF')); ?>
								<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $challan->id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
				</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
				</table>
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
	</div>
</div>

