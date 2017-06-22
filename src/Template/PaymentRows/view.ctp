<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Payment Row'), ['action' => 'edit', $paymentRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Payment Row'), ['action' => 'delete', $paymentRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paymentRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Payment Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Receipts'), ['controller' => 'Receipts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Receipt'), ['controller' => 'Receipts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="paymentRows view large-9 medium-8 columns content">
    <h3><?= h($paymentRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Receipt') ?></th>
            <td><?= $paymentRow->has('receipt') ? $this->Html->link($paymentRow->receipt->id, ['controller' => 'Receipts', 'action' => 'view', $paymentRow->receipt->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Received From') ?></th>
            <td><?= $paymentRow->has('received_from') ? $this->Html->link($paymentRow->received_from->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $paymentRow->received_from->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($paymentRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Amount') ?></th>
            <td><?= $this->Number->format($paymentRow->amount) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Narration') ?></h4>
        <?= $this->Text->autoParagraph(h($paymentRow->narration)); ?>
    </div>
</div>
