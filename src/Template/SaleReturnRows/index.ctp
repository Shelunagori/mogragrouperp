<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Sale Return Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="saleReturnRows index large-9 medium-8 columns content">
    <h3><?= __('Sale Return Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('sale_return_id') ?></th>
                <th><?= $this->Paginator->sort('item_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th><?= $this->Paginator->sort('rate') ?></th>
                <th><?= $this->Paginator->sort('amount') ?></th>
                <th><?= $this->Paginator->sort('height') ?></th>
                <th><?= $this->Paginator->sort('inventory_voucher_status') ?></th>
                <th><?= $this->Paginator->sort('item_serial_number') ?></th>
                <th><?= $this->Paginator->sort('inventory_voucher_applicable') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saleReturnRows as $saleReturnRow): ?>
            <tr>
                <td><?= $this->Number->format($saleReturnRow->id) ?></td>
                <td><?= $saleReturnRow->has('sale_return') ? $this->Html->link($saleReturnRow->sale_return->id, ['controller' => 'SaleReturns', 'action' => 'view', $saleReturnRow->sale_return->id]) : '' ?></td>
                <td><?= $saleReturnRow->has('item') ? $this->Html->link($saleReturnRow->item->name, ['controller' => 'Items', 'action' => 'view', $saleReturnRow->item->id]) : '' ?></td>
                <td><?= $this->Number->format($saleReturnRow->quantity) ?></td>
                <td><?= $this->Number->format($saleReturnRow->rate) ?></td>
                <td><?= $this->Number->format($saleReturnRow->amount) ?></td>
                <td><?= $this->Number->format($saleReturnRow->height) ?></td>
                <td><?= h($saleReturnRow->inventory_voucher_status) ?></td>
                <td><?= h($saleReturnRow->item_serial_number) ?></td>
                <td><?= h($saleReturnRow->inventory_voucher_applicable) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $saleReturnRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $saleReturnRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $saleReturnRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturnRow->id)]) ?>
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
