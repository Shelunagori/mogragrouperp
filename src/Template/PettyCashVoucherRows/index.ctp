<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Petty Cash Voucher Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Petty Cash Vouchers'), ['controller' => 'PettyCashVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Petty Cash Voucher'), ['controller' => 'PettyCashVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pettyCashVoucherRows index large-9 medium-8 columns content">
    <h3><?= __('Petty Cash Voucher Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('petty_cash_voucher_id') ?></th>
                <th><?= $this->Paginator->sort('received_from_id') ?></th>
                <th><?= $this->Paginator->sort('amount') ?></th>
                <th><?= $this->Paginator->sort('cr_dr') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pettyCashVoucherRows as $pettyCashVoucherRow): ?>
            <tr>
                <td><?= $this->Number->format($pettyCashVoucherRow->id) ?></td>
                <td><?= $pettyCashVoucherRow->has('petty_cash_voucher') ? $this->Html->link($pettyCashVoucherRow->petty_cash_voucher->id, ['controller' => 'PettyCashVouchers', 'action' => 'view', $pettyCashVoucherRow->petty_cash_voucher->id]) : '' ?></td>
                <td><?= $pettyCashVoucherRow->has('received_from') ? $this->Html->link($pettyCashVoucherRow->received_from->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $pettyCashVoucherRow->received_from->id]) : '' ?></td>
                <td><?= $this->Number->format($pettyCashVoucherRow->amount) ?></td>
                <td><?= h($pettyCashVoucherRow->cr_dr) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $pettyCashVoucherRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pettyCashVoucherRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pettyCashVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pettyCashVoucherRow->id)]) ?>
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
