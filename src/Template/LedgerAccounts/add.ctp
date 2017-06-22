<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Ledger Accounts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Account Second Subgroups'), ['controller' => 'AccountSecondSubgroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Account Second Subgroup'), ['controller' => 'AccountSecondSubgroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sources'), ['controller' => 'Sources', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Source'), ['controller' => 'Sources', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ledgers'), ['controller' => 'Ledgers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ledger'), ['controller' => 'Ledgers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ledgerAccounts form large-9 medium-8 columns content">
    <?= $this->Form->create($ledgerAccount) ?>
    <fieldset>
        <legend><?= __('Add Ledger Account') ?></legend>
        <?php
            echo $this->Form->input('account_second_subgroup_id', ['options' => $accountSecondSubgroups]);
            echo $this->Form->input('name');
            echo $this->Form->input('source_model');
            echo $this->Form->input('source_id', ['options' => $sources]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
