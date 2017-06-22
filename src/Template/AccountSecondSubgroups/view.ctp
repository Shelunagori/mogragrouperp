<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Account Second Subgroup'), ['action' => 'edit', $accountSecondSubgroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Account Second Subgroup'), ['action' => 'delete', $accountSecondSubgroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountSecondSubgroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Account Second Subgroups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account Second Subgroup'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Account First Subgroups'), ['controller' => 'AccountFirstSubgroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account First Subgroup'), ['controller' => 'AccountFirstSubgroups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accountSecondSubgroups view large-9 medium-8 columns content">
    <h3><?= h($accountSecondSubgroup->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Account First Subgroup') ?></th>
            <td><?= $accountSecondSubgroup->has('account_first_subgroup') ? $this->Html->link($accountSecondSubgroup->account_first_subgroup->name, ['controller' => 'AccountFirstSubgroups', 'action' => 'view', $accountSecondSubgroup->account_first_subgroup->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($accountSecondSubgroup->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($accountSecondSubgroup->id) ?></td>
        </tr>
    </table>
</div>
