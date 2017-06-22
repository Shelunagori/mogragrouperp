<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $pettyCashVoucherRow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $pettyCashVoucherRow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Petty Cash Voucher Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Petty Cash Vouchers'), ['controller' => 'PettyCashVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Petty Cash Voucher'), ['controller' => 'PettyCashVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pettyCashVoucherRows form large-9 medium-8 columns content">
    <?= $this->Form->create($pettyCashVoucherRow) ?>
    <fieldset>
        <legend><?= __('Edit Petty Cash Voucher Row') ?></legend>
        <?php
            echo $this->Form->input('petty_cash_voucher_id', ['options' => $pettyCashVouchers]);
            echo $this->Form->input('received_from_id', ['options' => $receivedFroms]);
            echo $this->Form->input('amount');
            echo $this->Form->input('cr_dr');
            echo $this->Form->input('narration');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
