<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Request Travelling'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="requestTravellings index large-9 medium-8 columns content">
    <h3><?= __('Request Travellings') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('employee_id') ?></th>
                <th><?= $this->Paginator->sort('destination') ?></th>
                <th><?= $this->Paginator->sort('reason') ?></th>
                <th><?= $this->Paginator->sort('request_from') ?></th>
                <th><?= $this->Paginator->sort('request_to') ?></th>
                <th><?= $this->Paginator->sort('request_date') ?></th>
                <th><?= $this->Paginator->sort('status') ?></th>
                <th><?= $this->Paginator->sort('total_ammount') ?></th>
                <th><?= $this->Paginator->sort('approved_ammount') ?></th>
                <th><?= $this->Paginator->sort('company_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requestTravellings as $requestTravelling): ?>
            <tr>
                <td><?= $this->Number->format($requestTravelling->id) ?></td>
                <td><?= $requestTravelling->has('employee') ? $this->Html->link($requestTravelling->employee->name, ['controller' => 'Employees', 'action' => 'view', $requestTravelling->employee->id]) : '' ?></td>
                <td><?= h($requestTravelling->destination) ?></td>
                <td><?= h($requestTravelling->reason) ?></td>
                <td><?= h($requestTravelling->request_from) ?></td>
                <td><?= h($requestTravelling->request_to) ?></td>
                <td><?= h($requestTravelling->request_date) ?></td>
                <td><?= h($requestTravelling->status) ?></td>
                <td><?= $this->Number->format($requestTravelling->total_ammount) ?></td>
                <td><?= $this->Number->format($requestTravelling->approved_ammount) ?></td>
                <td><?= $requestTravelling->has('company') ? $this->Html->link($requestTravelling->company->name, ['controller' => 'Companies', 'action' => 'view', $requestTravelling->company->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $requestTravelling->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $requestTravelling->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $requestTravelling->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requestTravelling->id)]) ?>
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
