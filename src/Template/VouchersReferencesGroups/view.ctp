<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Vouchers References Group'), ['action' => 'edit', $vouchersReferencesGroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Vouchers References Group'), ['action' => 'delete', $vouchersReferencesGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vouchersReferencesGroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Vouchers References Groups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vouchers References Group'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Vouchers References'), ['controller' => 'VouchersReferences', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vouchers Reference'), ['controller' => 'VouchersReferences', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Account Groups'), ['controller' => 'AccountGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account Group'), ['controller' => 'AccountGroups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="vouchersReferencesGroups view large-9 medium-8 columns content">
    <h3><?= h($vouchersReferencesGroup->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Vouchers Reference') ?></th>
            <td><?= $vouchersReferencesGroup->has('vouchers_reference') ? $this->Html->link($vouchersReferencesGroup->vouchers_reference->id, ['controller' => 'VouchersReferences', 'action' => 'view', $vouchersReferencesGroup->vouchers_reference->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Account Group') ?></th>
            <td><?= $vouchersReferencesGroup->has('account_group') ? $this->Html->link($vouchersReferencesGroup->account_group->name, ['controller' => 'AccountGroups', 'action' => 'view', $vouchersReferencesGroup->account_group->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($vouchersReferencesGroup->id) ?></td>
        </tr>
    </table>
</div>
