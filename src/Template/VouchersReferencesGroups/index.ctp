<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Vouchers References Group'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Vouchers References'), ['controller' => 'VouchersReferences', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vouchers Reference'), ['controller' => 'VouchersReferences', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Account Groups'), ['controller' => 'AccountGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Account Group'), ['controller' => 'AccountGroups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="vouchersReferencesGroups index large-9 medium-8 columns content">
    <h3><?= __('Vouchers References Groups') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('vouchers_reference_id') ?></th>
                <th><?= $this->Paginator->sort('account_group_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vouchersReferencesGroups as $vouchersReferencesGroup): ?>
            <tr>
                <td><?= $this->Number->format($vouchersReferencesGroup->id) ?></td>
                <td><?= $vouchersReferencesGroup->has('vouchers_reference') ? $this->Html->link($vouchersReferencesGroup->vouchers_reference->id, ['controller' => 'VouchersReferences', 'action' => 'view', $vouchersReferencesGroup->vouchers_reference->id]) : '' ?></td>
                <td><?= $vouchersReferencesGroup->has('account_group') ? $this->Html->link($vouchersReferencesGroup->account_group->name, ['controller' => 'AccountGroups', 'action' => 'view', $vouchersReferencesGroup->account_group->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $vouchersReferencesGroup->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $vouchersReferencesGroup->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $vouchersReferencesGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vouchersReferencesGroup->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
