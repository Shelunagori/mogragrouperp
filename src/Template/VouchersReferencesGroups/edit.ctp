<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $vouchersReferencesGroup->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $vouchersReferencesGroup->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Vouchers References Groups'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Vouchers References'), ['controller' => 'VouchersReferences', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vouchers Reference'), ['controller' => 'VouchersReferences', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Account Groups'), ['controller' => 'AccountGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Account Group'), ['controller' => 'AccountGroups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="vouchersReferencesGroups form large-9 medium-8 columns content">
    <?= $this->Form->create($vouchersReferencesGroup) ?>
    <fieldset>
        <legend><?= __('Edit Vouchers References Group') ?></legend>
        <?php
            echo $this->Form->input('vouchers_reference_id', ['options' => $vouchersReferences]);
            echo $this->Form->input('account_group_id', ['options' => $accountGroups]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
