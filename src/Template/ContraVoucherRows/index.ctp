<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Contra Voucher Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contra Vouchers'), ['controller' => 'ContraVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contra Voucher'), ['controller' => 'ContraVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contraVoucherRows index large-9 medium-8 columns content">
    <h3><?= __('Contra Voucher Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('contra_voucher_id') ?></th>
                <th><?= $this->Paginator->sort('received_from_id') ?></th>
                <th><?= $this->Paginator->sort('amount') ?></th>
                <th><?= $this->Paginator->sort('cr_dr') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contraVoucherRows as $contraVoucherRow): ?>
            <tr>
                <td><?= $this->Number->format($contraVoucherRow->id) ?></td>
                <td><?= $contraVoucherRow->has('contra_voucher') ? $this->Html->link($contraVoucherRow->contra_voucher->id, ['controller' => 'ContraVouchers', 'action' => 'view', $contraVoucherRow->contra_voucher->id]) : '' ?></td>
                <td><?= $contraVoucherRow->has('received_from') ? $this->Html->link($contraVoucherRow->received_from->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $contraVoucherRow->received_from->id]) : '' ?></td>
                <td><?= $this->Number->format($contraVoucherRow->amount) ?></td>
                <td><?= h($contraVoucherRow->cr_dr) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $contraVoucherRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contraVoucherRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contraVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contraVoucherRow->id)]) ?>
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
