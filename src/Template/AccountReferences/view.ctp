<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Account Reference'), ['action' => 'edit', $accountReference->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Account Reference'), ['action' => 'delete', $accountReference->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountReference->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Account References'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account Reference'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ledger Accounts'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger Account'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accountReferences view large-9 medium-8 columns content">
    <h3><?= h($accountReference->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Entity Description') ?></th>
            <td><?= h($accountReference->entity_description) ?></td>
        </tr>
        <tr>
            <th><?= __('Ledger Account') ?></th>
            <td><?= $accountReference->has('ledger_account') ? $this->Html->link($accountReference->ledger_account->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $accountReference->ledger_account->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($accountReference->id) ?></td>
        </tr>
    </table>
</div>
