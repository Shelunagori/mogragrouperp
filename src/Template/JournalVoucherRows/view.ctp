<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Journal Voucher Row'), ['action' => 'edit', $journalVoucherRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Journal Voucher Row'), ['action' => 'delete', $journalVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $journalVoucherRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Journal Voucher Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Journal Voucher Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Journal Vouchers'), ['controller' => 'JournalVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Journal Voucher'), ['controller' => 'JournalVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ledger Accounts'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger Account'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="journalVoucherRows view large-9 medium-8 columns content">
    <h3><?= h($journalVoucherRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Journal Voucher') ?></th>
            <td><?= $journalVoucherRow->has('journal_voucher') ? $this->Html->link($journalVoucherRow->journal_voucher->id, ['controller' => 'JournalVouchers', 'action' => 'view', $journalVoucherRow->journal_voucher->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Ledger Account') ?></th>
            <td><?= $journalVoucherRow->has('ledger_account') ? $this->Html->link($journalVoucherRow->ledger_account->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $journalVoucherRow->ledger_account->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($journalVoucherRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Cr Dr') ?></th>
            <td><?= $this->Number->format($journalVoucherRow->cr_dr) ?></td>
        </tr>
        <tr>
            <th><?= __('Amount') ?></th>
            <td><?= $this->Number->format($journalVoucherRow->amount) ?></td>
        </tr>
    </table>
</div>
