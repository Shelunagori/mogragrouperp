<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Purchase Return Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="purchaseReturnRows index large-9 medium-8 columns content">
    <h3><?= __('Purchase Return Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('purchase_return_id') ?></th>
                <th><?= $this->Paginator->sort('item_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchaseReturnRows as $purchaseReturnRow): ?>
            <tr>
                <td><?= $this->Number->format($purchaseReturnRow->id) ?></td>
                <td><?= $this->Number->format($purchaseReturnRow->purchase_return_id) ?></td>
                <td><?= $purchaseReturnRow->has('item') ? $this->Html->link($purchaseReturnRow->item->name, ['controller' => 'Items', 'action' => 'view', $purchaseReturnRow->item->id]) : '' ?></td>
                <td><?= $this->Number->format($purchaseReturnRow->quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $purchaseReturnRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $purchaseReturnRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $purchaseReturnRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseReturnRow->id)]) ?>
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
