<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Inventory Transfer Voucher Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Inventory Transfer Vouchers'), ['controller' => 'InventoryTransferVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Inventory Transfer Voucher'), ['controller' => 'InventoryTransferVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="inventoryTransferVoucherRows form large-9 medium-8 columns content">
    <?= $this->Form->create($inventoryTransferVoucherRow) ?>
    <fieldset>
        <legend><?= __('Add Inventory Transfer Voucher Row') ?></legend>
        <?php
            echo $this->Form->input('inventory_transfer_voucher_id', ['options' => $inventoryTransferVouchers]);
            echo $this->Form->input('item_id', ['options' => $items]);
            echo $this->Form->input('quantity');
            echo $this->Form->input('amount');
            echo $this->Form->input('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
