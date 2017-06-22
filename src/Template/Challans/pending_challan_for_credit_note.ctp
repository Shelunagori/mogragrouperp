<?php //pr($challans); exit; ?>
<div class="portlet light bordered">

	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
			<?php $page_no=$this->Paginator->current('Challans'); $page_no=($page_no-1)*20; ?>
				<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Challan.No</th>
								<th>Status</th>
							</tr>
					
					</thead>

					<tbody>
            <?php foreach ($challans as $challan): ?>
            <tr>
                <td><?= h(++$page_no) ?></td>
				<td><?= h(($challan->ch1.'/CH-'.str_pad($challan->ch2, 3, '0', STR_PAD_LEFT).'/'.$challan->ch3.'/'.$challan->ch4)) ?></td>
                          
				<td class="actions">
								<?php echo $this->Html->link('<i class="fa fa-repeat"></i>  Pass Credit Notes','/CreditNotes/Add?Challan='.$challan->id,array('escape'=>false,'class'=>'btn btn-xs default blue-stripe'));?>
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

