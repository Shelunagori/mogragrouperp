<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sale Return Row'), ['action' => 'edit', $saleReturnRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sale Return Row'), ['action' => 'delete', $saleReturnRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturnRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="saleReturnRows view large-9 medium-8 columns content">
    <h3><?= h($saleReturnRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Sale Return') ?></th>
            <td><?= $saleReturnRow->has('sale_return') ? $this->Html->link($saleReturnRow->sale_return->id, ['controller' => 'SaleReturns', 'action' => 'view', $saleReturnRow->sale_return->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Item') ?></th>
            <td><?= $saleReturnRow->has('item') ? $this->Html->link($saleReturnRow->item->name, ['controller' => 'Items', 'action' => 'view', $saleReturnRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Inventory Voucher Status') ?></th>
            <td><?= h($saleReturnRow->inventory_voucher_status) ?></td>
        </tr>
        <tr>
            <th><?= __('Item Serial Number') ?></th>
            <td><?= h($saleReturnRow->item_serial_number) ?></td>
        </tr>
        <tr>
            <th><?= __('Inventory Voucher Applicable') ?></th>
            <td><?= h($saleReturnRow->inventory_voucher_applicable) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($saleReturnRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($saleReturnRow->quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Rate') ?></th>
            <td><?= $this->Number->format($saleReturnRow->rate) ?></td>
        </tr>
        <tr>
            <th><?= __('Amount') ?></th>
            <td><?= $this->Number->format($saleReturnRow->amount) ?></td>
        </tr>
        <tr>
            <th><?= __('Height') ?></th>
            <td><?= $this->Number->format($saleReturnRow->height) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($saleReturnRow->description)); ?>
    </div>
</div>
