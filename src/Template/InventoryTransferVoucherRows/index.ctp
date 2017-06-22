<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Inventory Transfer Voucher Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Inventory Transfer Vouchers'), ['controller' => 'InventoryTransferVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Inventory Transfer Voucher'), ['controller' => 'InventoryTransferVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="inventoryTransferVoucherRows index large-9 medium-8 columns content">
    <h3><?= __('Inventory Transfer Voucher Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('inventory_transfer_voucher_id') ?></th>
                <th><?= $this->Paginator->sort('item_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th><?= $this->Paginator->sort('amount') ?></th>
                <th><?= $this->Paginator->sort('status') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventoryTransferVoucherRows as $inventoryTransferVoucherRow): ?>
            <tr>
                <td><?= $this->Number->format($inventoryTransferVoucherRow->id) ?></td>
                <td><?= $inventoryTransferVoucherRow->has('inventory_transfer_voucher') ? $this->Html->link($inventoryTransferVoucherRow->inventory_transfer_voucher->id, ['controller' => 'InventoryTransferVouchers', 'action' => 'view', $inventoryTransferVoucherRow->inventory_transfer_voucher->id]) : '' ?></td>
                <td><?= $inventoryTransferVoucherRow->has('item') ? $this->Html->link($inventoryTransferVoucherRow->item->name, ['controller' => 'Items', 'action' => 'view', $inventoryTransferVoucherRow->item->id]) : '' ?></td>
                <td><?= $this->Number->format($inventoryTransferVoucherRow->quantity) ?></td>
                <td><?= $this->Number->format($inventoryTransferVoucherRow->amount) ?></td>
                <td><?= h($inventoryTransferVoucherRow->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $inventoryTransferVoucherRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $inventoryTransferVoucherRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $inventoryTransferVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryTransferVoucherRow->id)]) ?>
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
