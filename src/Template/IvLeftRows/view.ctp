<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Iv Left Row'), ['action' => 'edit', $ivLeftRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Iv Left Row'), ['action' => 'delete', $ivLeftRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ivLeftRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Iv Left Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Iv Left Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ivs'), ['controller' => 'Ivs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Iv'), ['controller' => 'Ivs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Invoice Rows'), ['controller' => 'InvoiceRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice Row'), ['controller' => 'InvoiceRows', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Iv Left Serial Numbers'), ['controller' => 'IvLeftSerialNumbers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Iv Left Serial Number'), ['controller' => 'IvLeftSerialNumbers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Iv Right Rows'), ['controller' => 'IvRightRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Iv Right Row'), ['controller' => 'IvRightRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ivLeftRows view large-9 medium-8 columns content">
    <h3><?= h($ivLeftRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Iv') ?></th>
            <td><?= $ivLeftRow->has('iv') ? $this->Html->link($ivLeftRow->iv->id, ['controller' => 'Ivs', 'action' => 'view', $ivLeftRow->iv->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Invoice Row') ?></th>
            <td><?= $ivLeftRow->has('invoice_row') ? $this->Html->link($ivLeftRow->invoice_row->id, ['controller' => 'InvoiceRows', 'action' => 'view', $ivLeftRow->invoice_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($ivLeftRow->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Iv Left Serial Numbers') ?></h4>
        <?php if (!empty($ivLeftRow->iv_left_serial_numbers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Iv Left Row Id') ?></th>
                <th><?= __('Sr Number') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ivLeftRow->iv_left_serial_numbers as $ivLeftSerialNumbers): ?>
            <tr>
                <td><?= h($ivLeftSerialNumbers->id) ?></td>
                <td><?= h($ivLeftSerialNumbers->iv_left_row_id) ?></td>
                <td><?= h($ivLeftSerialNumbers->sr_number) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'IvLeftSerialNumbers', 'action' => 'view', $ivLeftSerialNumbers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'IvLeftSerialNumbers', 'action' => 'edit', $ivLeftSerialNumbers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'IvLeftSerialNumbers', 'action' => 'delete', $ivLeftSerialNumbers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ivLeftSerialNumbers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Iv Right Rows') ?></h4>
        <?php if (!empty($ivLeftRow->iv_right_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Iv Left Row Id') ?></th>
                <th><?= __('Item Id') ?></th>
                <th><?= __('Quantity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ivLeftRow->iv_right_rows as $ivRightRows): ?>
            <tr>
                <td><?= h($ivRightRows->id) ?></td>
                <td><?= h($ivRightRows->iv_left_row_id) ?></td>
                <td><?= h($ivRightRows->item_id) ?></td>
                <td><?= h($ivRightRows->quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'IvRightRows', 'action' => 'view', $ivRightRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'IvRightRows', 'action' => 'edit', $ivRightRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'IvRightRows', 'action' => 'delete', $ivRightRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ivRightRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
