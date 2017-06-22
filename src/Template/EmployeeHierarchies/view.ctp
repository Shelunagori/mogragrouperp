<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Employee Hierarchy'), ['action' => 'edit', $employeeHierarchy->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Employee Hierarchy'), ['action' => 'delete', $employeeHierarchy->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeHierarchy->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Employee Hierarchies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee Hierarchy'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="employeeHierarchies view large-9 medium-8 columns content">
    <h3><?= h($employeeHierarchy->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Employee') ?></th>
            <td><?= $employeeHierarchy->has('employee') ? $this->Html->link($employeeHierarchy->employee->name, ['controller' => 'Employees', 'action' => 'view', $employeeHierarchy->employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($employeeHierarchy->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Lft') ?></th>
            <td><?= $this->Number->format($employeeHierarchy->lft) ?></td>
        </tr>
        <tr>
            <th><?= __('Rgft') ?></th>
            <td><?= $this->Number->format($employeeHierarchy->rgft) ?></td>
        </tr>
    </table>
</div>
