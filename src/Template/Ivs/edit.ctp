<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $iv->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $iv->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ivs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Iv Left Rows'), ['controller' => 'IvLeftRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv Left Row'), ['controller' => 'IvLeftRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ivs form large-9 medium-8 columns content">
    <?= $this->Form->create($iv) ?>
    <fieldset>
        <legend><?= __('Edit Iv') ?></legend>
        <?php
            echo $this->Form->input('invoice_id', ['options' => $invoices]);
            echo $this->Form->input('voucher_no');
            echo $this->Form->input('transaction_date');
            echo $this->Form->input('company_id', ['options' => $companies]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
