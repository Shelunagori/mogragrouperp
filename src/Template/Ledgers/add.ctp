<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Ledgers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ledger Accounts'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ledger Account'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ledgers form large-9 medium-8 columns content">
    <?= $this->Form->create($ledger) ?>
    <fieldset>
        <legend><?= __('Add Ledger') ?></legend>
        <?php
            echo $this->Form->input('ledger_account_id', ['options' => $ledgerAccounts]);
            echo $this->Form->input('debit');
            echo $this->Form->input('credit');
            echo $this->Form->input('voucher_id');
            echo $this->Form->input('voucher_source');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
