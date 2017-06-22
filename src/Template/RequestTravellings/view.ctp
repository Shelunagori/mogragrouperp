<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Request Travelling'), ['action' => 'edit', $requestTravelling->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Request Travelling'), ['action' => 'delete', $requestTravelling->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requestTravelling->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Request Travellings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Request Travelling'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="requestTravellings view large-9 medium-8 columns content">
    <h3><?= h($requestTravelling->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Employee') ?></th>
            <td><?= $requestTravelling->has('employee') ? $this->Html->link($requestTravelling->employee->name, ['controller' => 'Employees', 'action' => 'view', $requestTravelling->employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Destination') ?></th>
            <td><?= h($requestTravelling->destination) ?></td>
        </tr>
        <tr>
            <th><?= __('Reason') ?></th>
            <td><?= h($requestTravelling->reason) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($requestTravelling->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Company') ?></th>
            <td><?= $requestTravelling->has('company') ? $this->Html->link($requestTravelling->company->name, ['controller' => 'Companies', 'action' => 'view', $requestTravelling->company->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($requestTravelling->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Total Ammount') ?></th>
            <td><?= $this->Number->format($requestTravelling->total_ammount) ?></td>
        </tr>
        <tr>
            <th><?= __('Approved Ammount') ?></th>
            <td><?= $this->Number->format($requestTravelling->approved_ammount) ?></td>
        </tr>
        <tr>
            <th><?= __('Request From') ?></th>
            <td><?= h($requestTravelling->request_from) ?></td>
        </tr>
        <tr>
            <th><?= __('Request To') ?></th>
            <td><?= h($requestTravelling->request_to) ?></td>
        </tr>
        <tr>
            <th><?= __('Request Date') ?></th>
            <td><?= h($requestTravelling->request_date) ?></td>
        </tr>
    </table>
</div>
