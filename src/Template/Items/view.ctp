<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Item'), ['action' => 'edit', $item->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Categories'), ['controller' => 'ItemCategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Category'), ['controller' => 'ItemCategories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Groups'), ['controller' => 'ItemGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Group'), ['controller' => 'ItemGroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Sub Groups'), ['controller' => 'ItemSubGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Sub Group'), ['controller' => 'ItemSubGroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Units'), ['controller' => 'Units', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit'), ['controller' => 'Units', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Used By Companies'), ['controller' => 'ItemUsedByCompanies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Used By Company'), ['controller' => 'ItemUsedByCompanies', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="items view large-9 medium-8 columns content">
    <h3><?= h($item->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($item->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Item Category') ?></th>
            <td><?= $item->has('item_category') ? $this->Html->link($item->item_category->name, ['controller' => 'ItemCategories', 'action' => 'view', $item->item_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Item Group') ?></th>
            <td><?= $item->has('item_group') ? $this->Html->link($item->item_group->name, ['controller' => 'ItemGroups', 'action' => 'view', $item->item_group->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Item Sub Group') ?></th>
            <td><?= $item->has('item_sub_group') ? $this->Html->link($item->item_sub_group->name, ['controller' => 'ItemSubGroups', 'action' => 'view', $item->item_sub_group->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Unit') ?></th>
            <td><?= $item->has('unit') ? $this->Html->link($item->unit->name, ['controller' => 'Units', 'action' => 'view', $item->unit->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Source') ?></th>
            <td><?= h($item->source) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($item->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($item->quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Rate') ?></th>
            <td><?= $this->Number->format($item->rate) ?></td>
        </tr>
        <tr>
            <th><?= __('Item Unit') ?></th>
            <td><?= $this->Number->format($item->item_unit) ?></td>
        </tr>
        <tr>
            <th><?= __('Value') ?></th>
            <td><?= $this->Number->format($item->value) ?></td>
        </tr>
        <tr>
            <th><?= __('Freeze') ?></th>
            <td><?= $this->Number->format($item->freeze) ?></td>
        </tr>
        <tr>
            <th><?= __('Serial Number Enable') ?></th>
            <td><?= $this->Number->format($item->serial_number_enable) ?></td>
        </tr>
        <tr>
            <th><?= __('Minimum Quantity') ?></th>
            <td><?= $this->Number->format($item->minimum_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Maximum Quantity') ?></th>
            <td><?= $this->Number->format($item->maximum_quantity) ?></td>
        </tr>
        <tr>
            <th><?= __('Flag') ?></th>
            <td><?= $this->Number->format($item->flag) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Item Used By Companies') ?></h4>
        <?php if (!empty($item->item_used_by_companies)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Item Id') ?></th>
                <th><?= __('Company Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($item->item_used_by_companies as $itemUsedByCompanies): ?>
            <tr>
                <td><?= h($itemUsedByCompanies->id) ?></td>
                <td><?= h($itemUsedByCompanies->item_id) ?></td>
                <td><?= h($itemUsedByCompanies->company_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ItemUsedByCompanies', 'action' => 'view', $itemUsedByCompanies->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ItemUsedByCompanies', 'action' => 'edit', $itemUsedByCompanies->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ItemUsedByCompanies', 'action' => 'delete', $itemUsedByCompanies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemUsedByCompanies->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
