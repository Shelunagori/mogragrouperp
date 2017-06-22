<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Employee Hierarchy'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employeeHierarchies index large-9 medium-8 columns content">
    <h3><?= __('Employee Hierarchies') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('lft') ?></th>
                <th><?= $this->Paginator->sort('rgft') ?></th>
                <th><?= $this->Paginator->sort('employee_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employeeHierarchies as $employeeHierarchy): ?>
            <tr>
                <td><?= $this->Number->format($employeeHierarchy->id) ?></td>
                <td><?= $this->Number->format($employeeHierarchy->lft) ?></td>
                <td><?= $this->Number->format($employeeHierarchy->rgft) ?></td>
                <td><?= $employeeHierarchy->has('employee') ? $this->Html->link($employeeHierarchy->employee->name, ['controller' => 'Employees', 'action' => 'view', $employeeHierarchy->employee->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $employeeHierarchy->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employeeHierarchy->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employeeHierarchy->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeHierarchy->id)]) ?>
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
