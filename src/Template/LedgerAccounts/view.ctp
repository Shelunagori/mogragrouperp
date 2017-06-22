<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ledger Account'), ['action' => 'edit', $ledgerAccount->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ledger Account'), ['action' => 'delete', $ledgerAccount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ledgerAccount->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ledger Accounts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger Account'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Account Second Subgroups'), ['controller' => 'AccountSecondSubgroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account Second Subgroup'), ['controller' => 'AccountSecondSubgroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sources'), ['controller' => 'Sources', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Source'), ['controller' => 'Sources', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ledgerAccounts view large-9 medium-8 columns content">
    <h3><?= h($ledgerAccount->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Account Second Subgroup') ?></th>
            <td><?= $ledgerAccount->has('account_second_subgroup') ? $this->Html->link($ledgerAccount->account_second_subgroup->name, ['controller' => 'AccountSecondSubgroups', 'action' => 'view', $ledgerAccount->account_second_subgroup->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($ledgerAccount->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Source Model') ?></th>
            <td><?= h($ledgerAccount->source_model) ?></td>
        </tr>
        <tr>
            <th><?= __('Source') ?></th>
            <td><?= $ledgerAccount->has('source') ? $this->Html->link($ledgerAccount->source->name, ['controller' => 'Sources', 'action' => 'view', $ledgerAccount->source->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($ledgerAccount->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Ledgers') ?></h4>
        <?php if (!empty($ledgerAccount->ledgers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Ledger Account Id') ?></th>
                <th><?= __('Debit') ?></th>
                <th><?= __('Credit') ?></th>
                <th><?= __('Voucher Id') ?></th>
                <th><?= __('Voucher Source') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ledgerAccount->ledgers as $ledgers): ?>
            <tr>
                <td><?= h($ledgers->id) ?></td>
                <td><?= h($ledgers->ledger_account_id) ?></td>
                <td><?= h($ledgers->debit) ?></td>
                <td><?= h($ledgers->credit) ?></td>
                <td><?= h($ledgers->voucher_id) ?></td>
                <td><?= h($ledgers->voucher_source) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Ledgers', 'action' => 'view', $ledgers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Ledgers', 'action' => 'edit', $ledgers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Ledgers', 'action' => 'delete', $ledgers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ledgers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
