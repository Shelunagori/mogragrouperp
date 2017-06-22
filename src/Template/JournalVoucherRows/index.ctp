<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Journal Voucher Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Journal Vouchers'), ['controller' => 'JournalVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Journal Voucher'), ['controller' => 'JournalVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ledger Accounts'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ledger Account'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="journalVoucherRows index large-9 medium-8 columns content">
    <h3><?= __('Journal Voucher Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('journal_voucher_id') ?></th>
                <th><?= $this->Paginator->sort('ledger_account_id') ?></th>
                <th><?= $this->Paginator->sort('cr_dr') ?></th>
                <th><?= $this->Paginator->sort('amount') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($journalVoucherRows as $journalVoucherRow): ?>
            <tr>
                <td><?= $this->Number->format($journalVoucherRow->id) ?></td>
                <td><?= $journalVoucherRow->has('journal_voucher') ? $this->Html->link($journalVoucherRow->journal_voucher->id, ['controller' => 'JournalVouchers', 'action' => 'view', $journalVoucherRow->journal_voucher->id]) : '' ?></td>
                <td><?= $journalVoucherRow->has('ledger_account') ? $this->Html->link($journalVoucherRow->ledger_account->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $journalVoucherRow->ledger_account->id]) : '' ?></td>
                <td><?= $this->Number->format($journalVoucherRow->cr_dr) ?></td>
                <td><?= $this->Number->format($journalVoucherRow->amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $journalVoucherRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $journalVoucherRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $journalVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $journalVoucherRow->id)]) ?>
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
