<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Account Category'), ['action' => 'edit', $accountCategory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Account Category'), ['action' => 'delete', $accountCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountCategory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Account Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Account Groups'), ['controller' => 'AccountGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account Group'), ['controller' => 'AccountGroups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accountCategories view large-9 medium-8 columns content">
    <h3><?= h($accountCategory->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($accountCategory->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($accountCategory->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Account Groups') ?></h4>
        <?php if (!empty($accountCategory->account_groups)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Account Category Id') ?></th>
                <th><?= __('Name') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($accountCategory->account_groups as $accountGroups): ?>
            <tr>
                <td><?= h($accountGroups->id) ?></td>
                <td><?= h($accountGroups->account_category_id) ?></td>
                <td><?= h($accountGroups->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AccountGroups', 'action' => 'view', $accountGroups->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AccountGroups', 'action' => 'edit', $accountGroups->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccountGroups', 'action' => 'delete', $accountGroups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accountGroups->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
