<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Receipt Row'), ['action' => 'edit', $receiptRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Receipt Row'), ['action' => 'delete', $receiptRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receiptRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Receipt Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receipt Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Receipts'), ['controller' => 'Receipts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receipt'), ['controller' => 'Receipts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="receiptRows view large-9 medium-8 columns content">
    <h3><?= h($receiptRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Receipt') ?></th>
            <td><?= $receiptRow->has('receipt') ? $this->Html->link($receiptRow->receipt->id, ['controller' => 'Receipts', 'action' => 'view', $receiptRow->receipt->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Received From') ?></th>
            <td><?= $receiptRow->has('received_from') ? $this->Html->link($receiptRow->received_from->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $receiptRow->received_from->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($receiptRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Amount') ?></th>
            <td><?= $this->Number->format($receiptRow->amount) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Narration') ?></h4>
        <?= $this->Text->autoParagraph(h($receiptRow->narration)); ?>
    </div>
</div>
