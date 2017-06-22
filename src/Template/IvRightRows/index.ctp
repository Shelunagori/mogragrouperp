<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Iv Right Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Iv Left Rows'), ['controller' => 'IvLeftRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv Left Row'), ['controller' => 'IvLeftRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Iv Right Serial Numbers'), ['controller' => 'IvRightSerialNumbers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv Right Serial Number'), ['controller' => 'IvRightSerialNumbers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ivRightRows index large-9 medium-8 columns content">
    <h3><?= __('Iv Right Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('iv_left_row_id') ?></th>
                <th><?= $this->Paginator->sort('item_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ivRightRows as $ivRightRow): ?>
            <tr>
                <td><?= $this->Number->format($ivRightRow->id) ?></td>
                <td><?= $ivRightRow->has('iv_left_row') ? $this->Html->link($ivRightRow->iv_left_row->id, ['controller' => 'IvLeftRows', 'action' => 'view', $ivRightRow->iv_left_row->id]) : '' ?></td>
                <td><?= $ivRightRow->has('item') ? $this->Html->link($ivRightRow->item->name, ['controller' => 'Items', 'action' => 'view', $ivRightRow->item->id]) : '' ?></td>
                <td><?= $this->Number->format($ivRightRow->quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ivRightRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ivRightRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ivRightRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ivRightRow->id)]) ?>
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
