<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="saleReturnRows form large-9 medium-8 columns content">
    <?= $this->Form->create($saleReturnRow) ?>
    <fieldset>
        <legend><?= __('Add Sale Return Row') ?></legend>
        <?php
            echo $this->Form->input('sale_return_id', ['options' => $saleReturns]);
            echo $this->Form->input('item_id', ['options' => $items]);
            echo $this->Form->input('description');
            echo $this->Form->input('quantity');
            echo $this->Form->input('rate');
            echo $this->Form->input('amount');
            echo $this->Form->input('height');
            echo $this->Form->input('inventory_voucher_status');
            echo $this->Form->input('item_serial_number');
            echo $this->Form->input('inventory_voucher_applicable');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
