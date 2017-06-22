<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Account Group'), ['action' => 'edit', $accountGroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Account Group'), ['action' => 'delete', $accountGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountGroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Account Groups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account Group'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Account Categories'), ['controller' => 'AccountCategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account Category'), ['controller' => 'AccountCategories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Account First Subgroups'), ['controller' => 'AccountFirstSubgroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account First Subgroup'), ['controller' => 'AccountFirstSubgroups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accountGroups view large-9 medium-8 columns content">
    <h3><?= h($accountGroup->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Account Category') ?></th>
            <td><?= $accountGroup->has('account_category') ? $this->Html->link($accountGroup->account_category->id, ['controller' => 'AccountCategories', 'action' => 'view', $accountGroup->account_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($accountGroup->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($accountGroup->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Account First Subgroups') ?></h4>
        <?php if (!empty($accountGroup->account_first_subgroups)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Account Group Id') ?></th>
                <th><?= __('Name') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($accountGroup->account_first_subgroups as $accountFirstSubgroups): ?>
            <tr>
                <td><?= h($accountFirstSubgroups->id) ?></td>
                <td><?= h($accountFirstSubgroups->account_group_id) ?></td>
                <td><?= h($accountFirstSubgroups->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AccountFirstSubgroups', 'action' => 'view', $accountFirstSubgroups->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AccountFirstSubgroups', 'action' => 'edit', $accountFirstSubgroups->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccountFirstSubgroups', 'action' => 'delete', $accountFirstSubgroups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountFirstSubgroups->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
