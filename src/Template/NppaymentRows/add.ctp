<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Nppayment Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Nppayments'), ['controller' => 'Nppayments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Nppayment'), ['controller' => 'Nppayments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="nppaymentRows form large-9 medium-8 columns content">
    <?= $this->Form->create($nppaymentRow) ?>
    <fieldset>
        <legend><?= __('Add Nppayment Row') ?></legend>
        <?php
            echo $this->Form->input('nppayment_id', ['options' => $nppayments]);
            echo $this->Form->input('received_from_id', ['options' => $receivedFroms]);
            echo $this->Form->input('amount');
            echo $this->Form->input('cr_dr');
            echo $this->Form->input('narration');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
