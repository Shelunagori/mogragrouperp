<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Iv Right Row'), ['action' => 'edit', $ivRightRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Iv Right Row'), ['action' => 'delete', $ivRightRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ivRightRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Iv Right Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Iv Right Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Iv Left Rows'), ['controller' => 'IvLeftRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Iv Left Row'), ['controller' => 'IvLeftRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Iv Right Serial Numbers'), ['controller' => 'IvRightSerialNumbers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Iv Right Serial Number'), ['controller' => 'IvRightSerialNumbers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ivRightRows view large-9 medium-8 columns content">
    <h3><?= h($ivRightRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Iv Left Row') ?></th>
            <td><?= $ivRightRow->has('iv_left_row') ? $this->Html->link($ivRightRow->iv_left_row->id, ['controller' => 'IvLeftRows', 'action' => 'view', $ivRightRow->iv_left_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Item') ?></th>
            <td><?= $ivRightRow->has('item') ? $this->Html->link($ivRightRow->item->name, ['controller' => 'Items', 'action' => 'view', $ivRightRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($ivRightRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($ivRightRow->quantity) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Iv Right Serial Numbers') ?></h4>
        <?php if (!empty($ivRightRow->iv_right_serial_numbers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Iv Right Row Id') ?></th>
                <th><?= __('Item Serial Number Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ivRightRow->iv_right_serial_numbers as $ivRightSerialNumbers): ?>
            <tr>
                <td><?= h($ivRightSerialNumbers->id) ?></td>
                <td><?= h($ivRightSerialNumbers->iv_right_row_id) ?></td>
                <td><?= h($ivRightSerialNumbers->item_serial_number_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'IvRightSerialNumbers', 'action' => 'view', $ivRightSerialNumbers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'IvRightSerialNumbers', 'action' => 'edit', $ivRightSerialNumbers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'IvRightSerialNumbers', 'action' => 'delete', $ivRightSerialNumbers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ivRightSerialNumbers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
