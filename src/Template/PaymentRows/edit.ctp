<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $paymentRow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $paymentRow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Payment Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Receipts'), ['controller' => 'Receipts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Receipt'), ['controller' => 'Receipts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="paymentRows form large-9 medium-8 columns content">
    <?= $this->Form->create($paymentRow) ?>
    <fieldset>
        <legend><?= __('Edit Payment Row') ?></legend>
        <?php
            echo $this->Form->input('receipt_id', ['options' => $receipts]);
            echo $this->Form->input('received_from_id', ['options' => $receivedFroms]);
            echo $this->Form->input('amount');
            echo $this->Form->input('narration');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
