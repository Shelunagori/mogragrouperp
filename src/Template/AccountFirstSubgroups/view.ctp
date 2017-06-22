<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Account First Subgroup'), ['action' => 'edit', $accountFirstSubgroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Account First Subgroup'), ['action' => 'delete', $accountFirstSubgroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountFirstSubgroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Account First Subgroups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account First Subgroup'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Account Groups'), ['controller' => 'AccountGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account Group'), ['controller' => 'AccountGroups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accountFirstSubgroups view large-9 medium-8 columns content">
    <h3><?= h($accountFirstSubgroup->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Account Group') ?></th>
            <td><?= $accountFirstSubgroup->has('account_group') ? $this->Html->link($accountFirstSubgroup->account_group->name, ['controller' => 'AccountGroups', 'action' => 'view', $accountFirstSubgroup->account_group->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($accountFirstSubgroup->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($accountFirstSubgroup->id) ?></td>
        </tr>
    </table>
</div>
