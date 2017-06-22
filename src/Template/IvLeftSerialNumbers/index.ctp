<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Iv Left Serial Number'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Iv Left Rows'), ['controller' => 'IvLeftRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv Left Row'), ['controller' => 'IvLeftRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ivLeftSerialNumbers index large-9 medium-8 columns content">
    <h3><?= __('Iv Left Serial Numbers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('iv_left_row_id') ?></th>
                <th><?= $this->Paginator->sort('sr_number') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ivLeftSerialNumbers as $ivLeftSerialNumber): ?>
            <tr>
                <td><?= $this->Number->format($ivLeftSerialNumber->id) ?></td>
                <td><?= $ivLeftSerialNumber->has('iv_left_row') ? $this->Html->link($ivLeftSerialNumber->iv_left_row->id, ['controller' => 'IvLeftRows', 'action' => 'view', $ivLeftSerialNumber->iv_left_row->id]) : '' ?></td>
                <td><?= h($ivLeftSerialNumber->sr_number) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ivLeftSerialNumber->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ivLeftSerialNumber->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ivLeftSerialNumber->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ivLeftSerialNumber->id)]) ?>
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
