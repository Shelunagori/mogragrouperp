<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Leave Types'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="leaveTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($leaveType) ?>
    <fieldset>
        <legend><?= __('Add Leave Type') ?></legend>
        <?php
            echo $this->Form->input('leave_name');
            echo $this->Form->input('maximum_leave_in_month');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
