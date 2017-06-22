<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Inventory Transfer Voucher Row'), ['action' => 'edit', $inventoryTransferVoucherRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Inventory Transfer Voucher Row'), ['action' => 'delete', $inventoryTransferVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryTransferVoucherRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Inventory Transfer Voucher Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Inventory Transfer Voucher Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Inventory Transfer Vouchers'), ['controller' => 'InventoryTransferVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Inventory Transfer Voucher'), ['controller' => 'InventoryTransferVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="inventoryTransferVoucherRows view large-9 medium-8 columns content">
    <h3><?= h($inventoryTransferVoucherRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Inventory Transfer Voucher') ?></th>
            <td><?= $inventoryTransferVoucherRow->has('inventory_transfer_voucher') ? $this->Html->link($inventoryTransferVoucherRow->inventory_transfer_voucher->id, ['controller' => 'InventoryTransferVouchers', 'action' => 'view', $inventoryTransferVoucherRow->inventory_transfer_voucher->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Item') ?></th>
            <td><?= $inventoryTransferVoucherRow->has('item') ? $this->Html->link($inventoryTransferVoucherRow->item->name, ['controller' => 'Items', 'action' => 'view', $inventoryTransferVoucherRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($inventoryTransferVoucherRow->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($inventoryTransferVoucherRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($inventoryTransferVoucherRow->quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Amount') ?></th>
            <td><?= $this->Number->format($inventoryTransferVoucherRow->amount) ?></td>
        </tr>
    </table>
</div>
