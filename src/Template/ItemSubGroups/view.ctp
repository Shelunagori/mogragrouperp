<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Item Sub Group'), ['action' => 'edit', $itemSubGroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item Sub Group'), ['action' => 'delete', $itemSubGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemSubGroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Item Sub Groups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Sub Group'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Groups'), ['controller' => 'ItemGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Group'), ['controller' => 'ItemGroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="itemSubGroups view large-9 medium-8 columns content">
    <h3><?= h($itemSubGroup->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Item Group') ?></th>
            <td><?= $itemSubGroup->has('item_group') ? $this->Html->link($itemSubGroup->item_group->name, ['controller' => 'ItemGroups', 'action' => 'view', $itemSubGroup->item_group->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($itemSubGroup->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($itemSubGroup->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($itemSubGroup->items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Alias') ?></th>
                <th><?= __('Category Id') ?></th>
                <th><?= __('Item Category Id') ?></th>
                <th><?= __('Item Group Id') ?></th>
                <th><?= __('Item Sub Group Id') ?></th>
                <th><?= __('Unit Id') ?></th>
                <th><?= __('Ob Quantity') ?></th>
                <th><?= __('Ob Rate') ?></th>
                <th><?= __('Ob Value') ?></th>
                <th><?= __('Freeze') ?></th>
                <th><?= __('Serial Number Enable') ?></th>
                <th><?= __('Source') ?></th>
                <th><?= __('Minimum Quantity') ?></th>
                <th><?= __('Maximum Quantity') ?></th>
                <th><?= __('Deleted') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($itemSubGroup->items as $items): ?>
            <tr>
                <td><?= h($items->id) ?></td>
                <td><?= h($items->name) ?></td>
                <td><?= h($items->alias) ?></td>
                <td><?= h($items->category_id) ?></td>
                <td><?= h($items->item_category_id) ?></td>
                <td><?= h($items->item_group_id) ?></td>
                <td><?= h($items->item_sub_group_id) ?></td>
                <td><?= h($items->unit_id) ?></td>
                <td><?= h($items->ob_quantity) ?></td>
                <td><?= h($items->ob_rate) ?></td>
                <td><?= h($items->ob_value) ?></td>
                <td><?= h($items->freeze) ?></td>
                <td><?= h($items->serial_number_enable) ?></td>
                <td><?= h($items->source) ?></td>
                <td><?= h($items->minimum_quantity) ?></td>
                <td><?= h($items->maximum_quantity) ?></td>
                <td><?= h($items->deleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
