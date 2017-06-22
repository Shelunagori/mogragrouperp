<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User Log'), ['action' => 'edit', $userLog->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User Log'), ['action' => 'delete', $userLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userLog->id)]) ?> </li>
        <li><?= $this->Html->link(__('List User Logs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Log'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Logins'), ['controller' => 'Logins', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Login'), ['controller' => 'Logins', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="userLogs view large-9 medium-8 columns content">
    <h3><?= h($userLog->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Login') ?></th>
            <td><?= $userLog->has('login') ? $this->Html->link($userLog->login->id, ['controller' => 'Logins', 'action' => 'view', $userLog->login->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($userLog->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Datetime') ?></th>
            <td><?= h($userLog->datetime) ?></td>
        </tr>
    </table>
</div>
