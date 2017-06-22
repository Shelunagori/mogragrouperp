<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Item Ledger'), ['action' => 'edit', $itemLedger->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item Ledger'), ['action' => 'delete', $itemLedger->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemLedger->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Item Ledgers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Ledger'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sources'), ['controller' => 'Sources', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Source'), ['controller' => 'Sources', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="itemLedgers view large-9 medium-8 columns content">
    <h3><?= h($itemLedger->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Item') ?></th>
            <td><?= $itemLedger->has('item') ? $this->Html->link($itemLedger->item->name, ['controller' => 'Items', 'action' => 'view', $itemLedger->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Source Model') ?></th>
            <td><?= h($itemLedger->source_model) ?></td>
        </tr>
        <tr>
            <th><?= __('Source') ?></th>
            <td><?= $itemLedger->has('source') ? $this->Html->link($itemLedger->source->name, ['controller' => 'Sources', 'action' => 'view', $itemLedger->source->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('In Out') ?></th>
            <td><?= h($itemLedger->in_out) ?></td>
        </tr>
        <tr>
            <th><?= __('Company') ?></th>
            <td><?= $itemLedger->has('company') ? $this->Html->link($itemLedger->company->name, ['controller' => 'Companies', 'action' => 'view', $itemLedger->company->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($itemLedger->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($itemLedger->quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Rate') ?></th>
            <td><?= $this->Number->format($itemLedger->rate) ?></td>
        </tr>
        <tr>
            <th><?= __('Processed On') ?></th>
            <td><?= h($itemLedger->processed_on) ?></td>
        </tr>
    </table>
</div>
