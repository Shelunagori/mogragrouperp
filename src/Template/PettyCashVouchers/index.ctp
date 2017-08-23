<?php 	
	$first="01";
	$last="31";
	$start_date=$first.'-'.$financial_month_first->month;
	$end_date=$last.'-'.$financial_month_last->month;
	///pr($end_date); exit;
?>
<?php $url_excel="/?".$url; ?>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-globe font-blue-steel"></i>
            <span class="caption-subject font-blue-steel uppercase">PettyCash Vouchers</span>
        </div>
		<div class="actions">
			<?php echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Excel', '/PettyCashVouchers/Export-Excel/'.$url_excel.'',['class' =>'btn  green tooltips','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>
		</div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <?php $page_no=$this->Paginator->current('Payments'); $page_no=($page_no-1)*20; ?>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Transaction Date</th>
                            <th>Vocher No</th>
                            <th style="text-align:right;">Amount</th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach ($pettycashvouchers as $pettycashvoucher): $i++;  ?>
                        <tr>
                            <td><?= h(++$page_no) ?></td>
                            <td><?= h(date("d-m-Y",strtotime($pettycashvoucher->transaction_date)))?></td>
                            <td><?= h('#'.str_pad($pettycashvoucher->voucher_no, 4, '0', STR_PAD_LEFT)) ?></td>
							<?php $total_dr=0; $total_cr=0; $total=0;  foreach($pettycashvoucher->petty_cash_voucher_rows as $petty_cash_voucher_row){ 
								if($petty_cash_voucher_row->cr_dr=='Dr'){
									$total_dr=$total_dr+$petty_cash_voucher_row->amount;
								}else{
									$total_cr=$total_cr+$petty_cash_voucher_row->amount;
								}
							}  $total= $total_dr-$total_cr?>
                            <td align="right"><?= h($this->Number->format($total,[ 'places' => 2])) ?></td>
                            <td class="actions">
                            <?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'view', $pettycashvoucher->id],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-xs yellow tooltips','data-original-title'=>'View ')); ?>
							<?php if(date("d-m-Y",strtotime($pettycashvoucher->transaction_date)) >= $start_date && date("d-m-Y",strtotime($pettycashvoucher->transaction_date)) <= $end_date) {
							  echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $pettycashvoucher->id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit')); 
							}else{
								echo "Financial Month has been Closed";
							}							 ?>
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
