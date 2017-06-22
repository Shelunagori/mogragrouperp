<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Inventory Transfer Voucher'), ['action' => 'edit', $inventoryTransferVoucher->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Inventory Transfer Voucher'), ['action' => 'delete', $inventoryTransferVoucher->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryTransferVoucher->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Inventory Transfer Vouchers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Inventory Transfer Voucher'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Inventory Transfer Voucher Rows'), ['controller' => 'InventoryTransferVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Inventory Transfer Voucher Row'), ['controller' => 'InventoryTransferVoucherRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="inventoryTransferVouchers view large-9 medium-8 columns content">
    <h3><?= h($inventoryTransferVoucher->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Company') ?></th>
            <td><?= $inventoryTransferVoucher->has('company') ? $this->Html->link($inventoryTransferVoucher->company->name, ['controller' => 'Companies', 'action' => 'view', $inventoryTransferVoucher->company->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($inventoryTransferVoucher->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Voucher No') ?></th>
            <td><?= $this->Number->format($inventoryTransferVoucher->voucher_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Created By') ?></th>
            <td><?= $this->Number->format($inventoryTransferVoucher->created_by) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Inventory Transfer Voucher Rows') ?></h4>
        <?php if (!empty($inventoryTransferVoucher->inventory_transfer_voucher_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Inventory Transfer Voucher Id') ?></th>
                <th><?= __('Item Id') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Amount') ?></th>
                <th><?= __('Status') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($inventoryTransferVoucher->inventory_transfer_voucher_rows as $inventoryTransferVoucherRows): ?>
            <tr>
                <td><?= h($inventoryTransferVoucherRows->id) ?></td>
                <td><?= h($inventoryTransferVoucherRows->inventory_transfer_voucher_id) ?></td>
                <td><?= h($inventoryTransferVoucherRows->item_id) ?></td>
                <td><?= h($inventoryTransferVoucherRows->quantity) ?></td>
                <td><?= h($inventoryTransferVoucherRows->amount) ?></td>
                <td><?= h($inventoryTransferVoucherRows->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'InventoryTransferVoucherRows', 'action' => 'view', $inventoryTransferVoucherRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'InventoryTransferVoucherRows', 'action' => 'edit', $inventoryTransferVoucherRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'InventoryTransferVoucherRows', 'action' => 'delete', $inventoryTransferVoucherRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryTransferVoucherRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
