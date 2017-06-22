<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Job Card Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Job Cards'), ['controller' => 'JobCards', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job Card'), ['controller' => 'JobCards', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales Order Rows'), ['controller' => 'SalesOrderRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sales Order Row'), ['controller' => 'SalesOrderRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="jobCardRows index large-9 medium-8 columns content">
    <h3><?= __('Job Card Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('job_card_id') ?></th>
                <th><?= $this->Paginator->sort('sales_order_row_id') ?></th>
                <th><?= $this->Paginator->sort('item_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobCardRows as $jobCardRow): ?>
            <tr>
                <td><?= $this->Number->format($jobCardRow->id) ?></td>
                <td><?= $jobCardRow->has('job_card') ? $this->Html->link($jobCardRow->job_card->id, ['controller' => 'JobCards', 'action' => 'view', $jobCardRow->job_card->id]) : '' ?></td>
                <td><?= $jobCardRow->has('sales_order_row') ? $this->Html->link($jobCardRow->sales_order_row->id, ['controller' => 'SalesOrderRows', 'action' => 'view', $jobCardRow->sales_order_row->id]) : '' ?></td>
                <td><?= $jobCardRow->has('item') ? $this->Html->link($jobCardRow->item->name, ['controller' => 'Items', 'action' => 'view', $jobCardRow->item->id]) : '' ?></td>
                <td><?= $this->Number->format($jobCardRow->quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $jobCardRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $jobCardRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $jobCardRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $jobCardRow->id)]) ?>
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
