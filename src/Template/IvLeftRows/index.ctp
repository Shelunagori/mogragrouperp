<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Iv Left Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ivs'), ['controller' => 'Ivs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv'), ['controller' => 'Ivs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Invoice Rows'), ['controller' => 'InvoiceRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Invoice Row'), ['controller' => 'InvoiceRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Iv Left Serial Numbers'), ['controller' => 'IvLeftSerialNumbers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv Left Serial Number'), ['controller' => 'IvLeftSerialNumbers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Iv Right Rows'), ['controller' => 'IvRightRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv Right Row'), ['controller' => 'IvRightRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ivLeftRows index large-9 medium-8 columns content">
    <h3><?= __('Iv Left Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('iv_id') ?></th>
                <th><?= $this->Paginator->sort('invoice_row_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ivLeftRows as $ivLeftRow): ?>
            <tr>
                <td><?= $this->Number->format($ivLeftRow->id) ?></td>
                <td><?= $ivLeftRow->has('iv') ? $this->Html->link($ivLeftRow->iv->id, ['controller' => 'Ivs', 'action' => 'view', $ivLeftRow->iv->id]) : '' ?></td>
                <td><?= $ivLeftRow->has('invoice_row') ? $this->Html->link($ivLeftRow->invoice_row->id, ['controller' => 'InvoiceRows', 'action' => 'view', $ivLeftRow->invoice_row->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ivLeftRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ivLeftRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ivLeftRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ivLeftRow->id)]) ?>
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
