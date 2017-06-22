<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List User Logs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Logins'), ['controller' => 'Logins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Login'), ['controller' => 'Logins', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="userLogs form large-9 medium-8 columns content">
    <?= $this->Form->create($userLog) ?>
    <fieldset>
        <legend><?= __('Add User Log') ?></legend>
        <?php
            echo $this->Form->input('login_id', ['options' => $logins]);
            echo $this->Form->input('datetime');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
