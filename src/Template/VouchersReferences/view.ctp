<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Vouchers Reference'), ['action' => 'edit', $vouchersReference->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Vouchers Reference'), ['action' => 'delete', $vouchersReference->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vouchersReference->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Vouchers References'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vouchers Reference'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Vouchers References Groups'), ['controller' => 'VouchersReferencesGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vouchers References Group'), ['controller' => 'VouchersReferencesGroups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="vouchersReferences view large-9 medium-8 columns content">
    <h3><?= h($vouchersReference->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Voucher Entity') ?></th>
            <td><?= h($vouchersReference->voucher_entity) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($vouchersReference->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($vouchersReference->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Vouchers References Groups') ?></h4>
        <?php if (!empty($vouchersReference->vouchers_references_groups)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Vouchers Reference Id') ?></th>
                <th><?= __('Account Group Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($vouchersReference->vouchers_references_groups as $vouchersReferencesGroups): ?>
            <tr>
                <td><?= h($vouchersReferencesGroups->id) ?></td>
                <td><?= h($vouchersReferencesGroups->vouchers_reference_id) ?></td>
                <td><?= h($vouchersReferencesGroups->account_group_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'VouchersReferencesGroups', 'action' => 'view', $vouchersReferencesGroups->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'VouchersReferencesGroups', 'action' => 'edit', $vouchersReferencesGroups->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'VouchersReferencesGroups', 'action' => 'delete', $vouchersReferencesGroups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vouchersReferencesGroups->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
