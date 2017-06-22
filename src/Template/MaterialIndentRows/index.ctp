<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Material Indent Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Material Indents'), ['controller' => 'MaterialIndents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Material Indent'), ['controller' => 'MaterialIndents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="materialIndentRows index large-9 medium-8 columns content">
    <h3><?= __('Material Indent Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('material_indent_id') ?></th>
                <th><?= $this->Paginator->sort('item_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th><?= $this->Paginator->sort('approved_purchased_quantity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materialIndentRows as $materialIndentRow): ?>
            <tr>
                <td><?= $this->Number->format($materialIndentRow->id) ?></td>
                <td><?= $materialIndentRow->has('material_indent') ? $this->Html->link($materialIndentRow->material_indent->id, ['controller' => 'MaterialIndents', 'action' => 'view', $materialIndentRow->material_indent->id]) : '' ?></td>
                <td><?= $materialIndentRow->has('item') ? $this->Html->link($materialIndentRow->item->name, ['controller' => 'Items', 'action' => 'view', $materialIndentRow->item->id]) : '' ?></td>
                <td><?= $this->Number->format($materialIndentRow->quantity) ?></td>
                <td><?= $this->Number->format($materialIndentRow->approved_purchased_quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $materialIndentRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $materialIndentRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $materialIndentRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $materialIndentRow->id)]) ?>
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
