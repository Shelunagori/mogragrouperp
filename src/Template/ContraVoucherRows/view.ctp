<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Contra Voucher Row'), ['action' => 'edit', $contraVoucherRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Contra Voucher Row'), ['action' => 'delete', $contraVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contraVoucherRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contra Voucher Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contra Voucher Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contra Vouchers'), ['controller' => 'ContraVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contra Voucher'), ['controller' => 'ContraVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contraVoucherRows view large-9 medium-8 columns content">
    <h3><?= h($contraVoucherRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Contra Voucher') ?></th>
            <td><?= $contraVoucherRow->has('contra_voucher') ? $this->Html->link($contraVoucherRow->contra_voucher->id, ['controller' => 'ContraVouchers', 'action' => 'view', $contraVoucherRow->contra_voucher->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Received From') ?></th>
            <td><?= $contraVoucherRow->has('received_from') ? $this->Html->link($contraVoucherRow->received_from->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $contraVoucherRow->received_from->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Cr Dr') ?></th>
            <td><?= h($contraVoucherRow->cr_dr) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($contraVoucherRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Amount') ?></th>
            <td><?= $this->Number->format($contraVoucherRow->amount) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Narration') ?></h4>
        <?= $this->Text->autoParagraph(h($contraVoucherRow->narration)); ?>
    </div>
</div>
