<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Contra Voucher Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contra Vouchers'), ['controller' => 'ContraVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contra Voucher'), ['controller' => 'ContraVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contraVoucherRows form large-9 medium-8 columns content">
    <?= $this->Form->create($contraVoucherRow) ?>
    <fieldset>
        <legend><?= __('Add Contra Voucher Row') ?></legend>
        <?php
            echo $this->Form->input('contra_voucher_id', ['options' => $contraVouchers]);
            echo $this->Form->input('received_from_id', ['options' => $receivedFroms]);
            echo $this->Form->input('amount');
            echo $this->Form->input('cr_dr');
            echo $this->Form->input('narration');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
