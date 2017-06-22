<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Payment Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Receipts'), ['controller' => 'Receipts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Receipt'), ['controller' => 'Receipts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="paymentRows index large-9 medium-8 columns content">
    <h3><?= __('Payment Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('receipt_id') ?></th>
                <th><?= $this->Paginator->sort('received_from_id') ?></th>
                <th><?= $this->Paginator->sort('amount') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentRows as $paymentRow): ?>
            <tr>
                <td><?= $this->Number->format($paymentRow->id) ?></td>
                <td><?= $paymentRow->has('receipt') ? $this->Html->link($paymentRow->receipt->id, ['controller' => 'Receipts', 'action' => 'view', $paymentRow->receipt->id]) : '' ?></td>
                <td><?= $paymentRow->has('received_from') ? $this->Html->link($paymentRow->received_from->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $paymentRow->received_from->id]) : '' ?></td>
                <td><?= $this->Number->format($paymentRow->amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $paymentRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $paymentRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $paymentRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paymentRow->id)]) ?>
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
