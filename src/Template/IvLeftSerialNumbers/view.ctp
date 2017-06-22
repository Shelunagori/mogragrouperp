<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Iv Left Serial Number'), ['action' => 'edit', $ivLeftSerialNumber->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Iv Left Serial Number'), ['action' => 'delete', $ivLeftSerialNumber->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ivLeftSerialNumber->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Iv Left Serial Numbers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Iv Left Serial Number'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Iv Left Rows'), ['controller' => 'IvLeftRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Iv Left Row'), ['controller' => 'IvLeftRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ivLeftSerialNumbers view large-9 medium-8 columns content">
    <h3><?= h($ivLeftSerialNumber->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Iv Left Row') ?></th>
            <td><?= $ivLeftSerialNumber->has('iv_left_row') ? $this->Html->link($ivLeftSerialNumber->iv_left_row->id, ['controller' => 'IvLeftRows', 'action' => 'view', $ivLeftSerialNumber->iv_left_row->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Sr Number') ?></th>
            <td><?= h($ivLeftSerialNumber->sr_number) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($ivLeftSerialNumber->id) ?></td>
        </tr>
    </table>
</div>
