<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Request Leave'), ['action' => 'edit', $requestLeave->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Request Leave'), ['action' => 'delete', $requestLeave->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requestLeave->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Request Leaves'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Request Leave'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Leave Types'), ['controller' => 'LeaveTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Leave Type'), ['controller' => 'LeaveTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="requestLeaves view large-9 medium-8 columns content">
    <h3><?= h($requestLeave->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Employee') ?></th>
            <td><?= $requestLeave->has('employee') ? $this->Html->link($requestLeave->employee->name, ['controller' => 'Employees', 'action' => 'view', $requestLeave->employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Leave Type') ?></th>
            <td><?= $requestLeave->has('leave_type') ? $this->Html->link($requestLeave->leave_type->leave_name, ['controller' => 'LeaveTypes', 'action' => 'view', $requestLeave->leave_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Reason') ?></th>
            <td><?= h($requestLeave->reason) ?></td>
        </tr>
        <tr>
            <th><?= __('Leave Status') ?></th>
            <td><?= h($requestLeave->leave_status) ?></td>
        </tr>
        <tr>
            <th><?= __('Remarks') ?></th>
            <td><?= h($requestLeave->remarks) ?></td>
        </tr>
        <tr>
            <th><?= __('Half Day') ?></th>
            <td><?= h($requestLeave->half_day) ?></td>
        </tr>
        <tr>
            <th><?= __('Company') ?></th>
            <td><?= $requestLeave->has('company') ? $this->Html->link($requestLeave->company->name, ['controller' => 'Companies', 'action' => 'view', $requestLeave->company->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($requestLeave->id) ?></td>
        </tr>
        <tr>
            <th><?= __('No Of Days') ?></th>
            <td><?= $this->Number->format($requestLeave->no_of_days) ?></td>
        </tr>
        <tr>
            <th><?= __('Request Date') ?></th>
            <td><?= $this->Number->format($requestLeave->request_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Leave From') ?></th>
            <td><?= h($requestLeave->leave_from) ?></td>
        </tr>
        <tr>
            <th><?= __('Leave To') ?></th>
            <td><?= h($requestLeave->leave_to) ?></td>
        </tr>
    </table>
</div>
