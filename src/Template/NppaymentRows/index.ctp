<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Nppayment Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Nppayments'), ['controller' => 'Nppayments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Nppayment'), ['controller' => 'Nppayments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="nppaymentRows index large-9 medium-8 columns content">
    <h3><?= __('Nppayment Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('nppayment_id') ?></th>
                <th><?= $this->Paginator->sort('received_from_id') ?></th>
                <th><?= $this->Paginator->sort('amount') ?></th>
                <th><?= $this->Paginator->sort('cr_dr') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nppaymentRows as $nppaymentRow): ?>
            <tr>
                <td><?= $this->Number->format($nppaymentRow->id) ?></td>
                <td><?= $nppaymentRow->has('nppayment') ? $this->Html->link($nppaymentRow->nppayment->id, ['controller' => 'Nppayments', 'action' => 'view', $nppaymentRow->nppayment->id]) : '' ?></td>
                <td><?= $nppaymentRow->has('received_from') ? $this->Html->link($nppaymentRow->received_from->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $nppaymentRow->received_from->id]) : '' ?></td>
                <td><?= $this->Number->format($nppaymentRow->amount) ?></td>
                <td><?= h($nppaymentRow->cr_dr) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $nppaymentRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $nppaymentRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $nppaymentRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nppaymentRow->id)]) ?>
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
