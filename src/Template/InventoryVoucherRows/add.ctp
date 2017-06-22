<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Inventory Voucher Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Inventory Vouchers'), ['controller' => 'InventoryVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Inventory Voucher'), ['controller' => 'InventoryVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="inventoryVoucherRows form large-9 medium-8 columns content">
    <?= $this->Form->create($inventoryVoucherRow) ?>
    <fieldset>
        <legend><?= __('Add Inventory Voucher Row') ?></legend>
        <?php
            echo $this->Form->input('inventory_voucher_id', ['options' => $inventoryVouchers]);
            echo $this->Form->input('item_id', ['options' => $items]);
            echo $this->Form->input('quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
