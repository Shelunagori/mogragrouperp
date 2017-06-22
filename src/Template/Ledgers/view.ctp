<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ledger'), ['action' => 'edit', $ledger->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ledger'), ['action' => 'delete', $ledger->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ledger->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ledgers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ledger Accounts'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger Account'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ledgers view large-9 medium-8 columns content">
    <h3><?= h($ledger->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Ledger Account') ?></th>
            <td><?= $ledger->has('ledger_account') ? $this->Html->link($ledger->ledger_account->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $ledger->ledger_account->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Voucher Source') ?></th>
            <td><?= h($ledger->voucher_source) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($ledger->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Debit') ?></th>
            <td><?= $this->Number->format($ledger->debit) ?></td>
        </tr>
        <tr>
            <th><?= __('Credit') ?></th>
            <td><?= $this->Number->format($ledger->credit) ?></td>
        </tr>
        <tr>
            <th><?= __('Voucher Id') ?></th>
            <td><?= $this->Number->format($ledger->voucher_id) ?></td>
        </tr>
    </table>
</div>
