<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Leave Type'), ['action' => 'edit', $leaveType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Leave Type'), ['action' => 'delete', $leaveType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leaveType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Leave Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Leave Type'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="leaveTypes view large-9 medium-8 columns content">
    <h3><?= h($leaveType->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Leave Name') ?></th>
            <td><?= h($leaveType->leave_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($leaveType->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Maximum Leave In Month') ?></th>
            <td><?= $this->Number->format($leaveType->maximum_leave_in_month) ?></td>
        </tr>
    </table>
</div>
