<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Inventory Voucher Row'), ['action' => 'edit', $inventoryVoucherRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Inventory Voucher Row'), ['action' => 'delete', $inventoryVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryVoucherRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Inventory Voucher Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Inventory Voucher Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Inventory Vouchers'), ['controller' => 'InventoryVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Inventory Voucher'), ['controller' => 'InventoryVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="inventoryVoucherRows view large-9 medium-8 columns content">
    <h3><?= h($inventoryVoucherRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Inventory Voucher') ?></th>
            <td><?= $inventoryVoucherRow->has('inventory_voucher') ? $this->Html->link($inventoryVoucherRow->inventory_voucher->id, ['controller' => 'InventoryVouchers', 'action' => 'view', $inventoryVoucherRow->inventory_voucher->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Item') ?></th>
            <td><?= $inventoryVoucherRow->has('item') ? $this->Html->link($inventoryVoucherRow->item->name, ['controller' => 'Items', 'action' => 'view', $inventoryVoucherRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($inventoryVoucherRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($inventoryVoucherRow->quantity) ?></td>
        </tr>
    </table>
</div>
