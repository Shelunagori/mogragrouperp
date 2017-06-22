<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Material Indent Row'), ['action' => 'edit', $materialIndentRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Material Indent Row'), ['action' => 'delete', $materialIndentRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $materialIndentRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Material Indent Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Material Indent Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Material Indents'), ['controller' => 'MaterialIndents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Material Indent'), ['controller' => 'MaterialIndents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="materialIndentRows view large-9 medium-8 columns content">
    <h3><?= h($materialIndentRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Material Indent') ?></th>
            <td><?= $materialIndentRow->has('material_indent') ? $this->Html->link($materialIndentRow->material_indent->id, ['controller' => 'MaterialIndents', 'action' => 'view', $materialIndentRow->material_indent->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Item') ?></th>
            <td><?= $materialIndentRow->has('item') ? $this->Html->link($materialIndentRow->item->name, ['controller' => 'Items', 'action' => 'view', $materialIndentRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($materialIndentRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($materialIndentRow->quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Approved Purchased Quantity') ?></th>
            <td><?= $this->Number->format($materialIndentRow->approved_purchased_quantity) ?></td>
        </tr>
    </table>
</div>
