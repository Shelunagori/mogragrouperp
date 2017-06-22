<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Petty Cash Voucher Row'), ['action' => 'edit', $pettyCashVoucherRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Petty Cash Voucher Row'), ['action' => 'delete', $pettyCashVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pettyCashVoucherRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Petty Cash Voucher Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Petty Cash Voucher Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Petty Cash Vouchers'), ['controller' => 'PettyCashVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Petty Cash Voucher'), ['controller' => 'PettyCashVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pettyCashVoucherRows view large-9 medium-8 columns content">
    <h3><?= h($pettyCashVoucherRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Petty Cash Voucher') ?></th>
            <td><?= $pettyCashVoucherRow->has('petty_cash_voucher') ? $this->Html->link($pettyCashVoucherRow->petty_cash_voucher->id, ['controller' => 'PettyCashVouchers', 'action' => 'view', $pettyCashVoucherRow->petty_cash_voucher->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Received From') ?></th>
            <td><?= $pettyCashVoucherRow->has('received_from') ? $this->Html->link($pettyCashVoucherRow->received_from->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $pettyCashVoucherRow->received_from->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Cr Dr') ?></th>
            <td><?= h($pettyCashVoucherRow->cr_dr) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($pettyCashVoucherRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Amount') ?></th>
            <td><?= $this->Number->format($pettyCashVoucherRow->amount) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Narration') ?></h4>
        <?= $this->Text->autoParagraph(h($pettyCashVoucherRow->narration)); ?>
    </div>
</div>
