<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Employee Hierarchies'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employeeHierarchies form large-9 medium-8 columns content">
    <?= $this->Form->create($employeeHierarchy) ?>
    <fieldset>
        <legend><?= __('Add Employee Hierarchy') ?></legend>
        <?php
            echo $this->Form->input('lft');
            echo $this->Form->input('rgft');
            echo $this->Form->input('employee_id', ['options' => $employees]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
