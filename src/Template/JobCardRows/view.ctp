<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Job Card Row'), ['action' => 'edit', $jobCardRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Job Card Row'), ['action' => 'delete', $jobCardRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $jobCardRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Job Card Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Job Card Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Job Cards'), ['controller' => 'JobCards', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Job Card'), ['controller' => 'JobCards', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Order Rows'), ['controller' => 'SalesOrderRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Order Row'), ['controller' => 'SalesOrderRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="jobCardRows view large-9 medium-8 columns content">
    <h3><?= h($jobCardRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Job Card') ?></th>
            <td><?= $jobCardRow->has('job_card') ? $this->Html->link($jobCardRow->job_card->id, ['controller' => 'JobCards', 'action' => 'view', $jobCardRow->job_card->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Sales Order Row') ?></th>
            <td><?= $jobCardRow->has('sales_order_row') ? $this->Html->link($jobCardRow->sales_order_row->id, ['controller' => 'SalesOrderRows', 'action' => 'view', $jobCardRow->sales_order_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Item') ?></th>
            <td><?= $jobCardRow->has('item') ? $this->Html->link($jobCardRow->item->name, ['controller' => 'Items', 'action' => 'view', $jobCardRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($jobCardRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($jobCardRow->quantity) ?></td>
        </tr>
    </table>
</div>
