<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User Right'), ['action' => 'edit', $userRight->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User Right'), ['action' => 'delete', $userRight->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userRight->id)]) ?> </li>
        <li><?= $this->Html->link(__('List User Rights'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Right'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Logins'), ['controller' => 'Logins', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Login'), ['controller' => 'Logins', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pages'), ['controller' => 'Pages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Page'), ['controller' => 'Pages', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="userRights view large-9 medium-8 columns content">
    <h3><?= h($userRight->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Login') ?></th>
            <td><?= $userRight->has('login') ? $this->Html->link($userRight->login->id, ['controller' => 'Logins', 'action' => 'view', $userRight->login->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Page') ?></th>
            <td><?= $userRight->has('page') ? $this->Html->link($userRight->page->id, ['controller' => 'Pages', 'action' => 'view', $userRight->page->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($userRight->id) ?></td>
        </tr>
    </table>
</div>
