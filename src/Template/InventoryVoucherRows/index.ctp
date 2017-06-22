<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Inventory Voucher Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Inventory Vouchers'), ['controller' => 'InventoryVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Inventory Voucher'), ['controller' => 'InventoryVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="inventoryVoucherRows index large-9 medium-8 columns content">
    <h3><?= __('Inventory Voucher Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('inventory_voucher_id') ?></th>
                <th><?= $this->Paginator->sort('item_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventoryVoucherRows as $inventoryVoucherRow): ?>
            <tr>
                <td><?= $this->Number->format($inventoryVoucherRow->id) ?></td>
                <td><?= $inventoryVoucherRow->has('inventory_voucher') ? $this->Html->link($inventoryVoucherRow->inventory_voucher->id, ['controller' => 'InventoryVouchers', 'action' => 'view', $inventoryVoucherRow->inventory_voucher->id]) : '' ?></td>
                <td><?= $inventoryVoucherRow->has('item') ? $this->Html->link($inventoryVoucherRow->item->name, ['controller' => 'Items', 'action' => 'view', $inventoryVoucherRow->item->id]) : '' ?></td>
                <td><?= $this->Number->format($inventoryVoucherRow->quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $inventoryVoucherRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $inventoryVoucherRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $inventoryVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryVoucherRow->id)]) ?>
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
