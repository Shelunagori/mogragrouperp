<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New User Right'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Logins'), ['controller' => 'Logins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Login'), ['controller' => 'Logins', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pages'), ['controller' => 'Pages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Page'), ['controller' => 'Pages', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="userRights index large-9 medium-8 columns content">
    <h3><?= __('User Rights') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('login_id') ?></th>
                <th><?= $this->Paginator->sort('page_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userRights as $userRight): ?>
            <tr>
                <td><?= $this->Number->format($userRight->id) ?></td>
                <td><?= $userRight->has('login') ? $this->Html->link($userRight->login->id, ['controller' => 'Logins', 'action' => 'view', $userRight->login->id]) : '' ?></td>
                <td><?= $userRight->has('page') ? $this->Html->link($userRight->page->id, ['controller' => 'Pages', 'action' => 'view', $userRight->page->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $userRight->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userRight->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userRight->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userRight->id)]) ?>
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
