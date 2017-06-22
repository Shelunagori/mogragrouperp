<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $journalVoucherRow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $journalVoucherRow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Journal Voucher Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Journal Vouchers'), ['controller' => 'JournalVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Journal Voucher'), ['controller' => 'JournalVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ledger Accounts'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ledger Account'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="journalVoucherRows form large-9 medium-8 columns content">
    <?= $this->Form->create($journalVoucherRow) ?>
    <fieldset>
        <legend><?= __('Edit Journal Voucher Row') ?></legend>
        <?php
            echo $this->Form->input('journal_voucher_id', ['options' => $journalVouchers]);
            echo $this->Form->input('ledger_account_id', ['options' => $ledgerAccounts]);
            echo $this->Form->input('cr_dr');
            echo $this->Form->input('amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
