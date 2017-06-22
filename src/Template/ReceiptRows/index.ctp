<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Receipt Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Receipts'), ['controller' => 'Receipts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Receipt'), ['controller' => 'Receipts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="receiptRows index large-9 medium-8 columns content">
    <h3><?= __('Receipt Rows') ?></h3>
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
            <?php foreach ($receiptRows as $receiptRow): ?>
            <tr>
                <td><?= $this->Number->format($receiptRow->id) ?></td>
                <td><?= $receiptRow->has('receipt') ? $this->Html->link($receiptRow->receipt->id, ['controller' => 'Receipts', 'action' => 'view', $receiptRow->receipt->id]) : '' ?></td>
                <td><?= $receiptRow->has('received_from') ? $this->Html->link($receiptRow->received_from->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $receiptRow->received_from->id]) : '' ?></td>
                <td><?= $this->Number->format($receiptRow->amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $receiptRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $receiptRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $receiptRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receiptRow->id)]) ?>
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
