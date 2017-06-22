<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Item Ledgers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sources'), ['controller' => 'Sources', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Source'), ['controller' => 'Sources', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemLedgers form large-9 medium-8 columns content">
    <?= $this->Form->create($itemLedger) ?>
    <fieldset>
        <legend><?= __('Add Item Ledger') ?></legend>
        <?php
            echo $this->Form->input('item_id', ['options' => $items]);
            echo $this->Form->input('quantity');
            echo $this->Form->input('rate');
            echo $this->Form->input('source_model');
            echo $this->Form->input('source_id', ['options' => $sources]);
            echo $this->Form->input('in_out');
            echo $this->Form->input('processed_on');
            echo $this->Form->input('company_id', ['options' => $companies]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
