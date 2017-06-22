<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Iv Left Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ivs'), ['controller' => 'Ivs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv'), ['controller' => 'Ivs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Invoice Rows'), ['controller' => 'InvoiceRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Invoice Row'), ['controller' => 'InvoiceRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Iv Left Serial Numbers'), ['controller' => 'IvLeftSerialNumbers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv Left Serial Number'), ['controller' => 'IvLeftSerialNumbers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Iv Right Rows'), ['controller' => 'IvRightRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv Right Row'), ['controller' => 'IvRightRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ivLeftRows form large-9 medium-8 columns content">
    <?= $this->Form->create($ivLeftRow) ?>
    <fieldset>
        <legend><?= __('Add Iv Left Row') ?></legend>
        <?php
            echo $this->Form->input('iv_id', ['options' => $ivs]);
            echo $this->Form->input('invoice_row_id', ['options' => $invoiceRows]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
