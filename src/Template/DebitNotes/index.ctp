<?php //pr($pettyCashReceiptVouchers); exit; ?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-globe font-blue-steel"></i>
            <span class="caption-subject font-blue-steel uppercase">Debit Note</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <?php $page_no=$this->Paginator->current('DebitNotes'); $page_no=($page_no-1)*20; ?>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Transaction Date</th>
                            <th>Vocher No</th>
                         
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach ($debitNotes as $debitNote): $i++;  ?>
                        <tr>
                            <td><?= h(++$page_no) ?></td>
                            <td><?= h(date("d-m-Y",strtotime($debitNote->transaction_date)))?></td>
                            <td><?= h('#'.str_pad($debitNote->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
						
                            <td class="actions">
                            <?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'view', $debitNote->id],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-xs yellow tooltips','data-original-title'=>'View ')); ?>
                             <?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $debitNote->id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); ?>
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
