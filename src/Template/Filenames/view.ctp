<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Filename'), ['action' => 'edit', $filename->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Filename'), ['action' => 'delete', $filename->id], ['confirm' => __('Are you sure you want to delete # {0}?', $filename->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Filenames'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Filename'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="filenames view large-9 medium-8 columns content">
    <h3><?= h($filename->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('File') ?></th>
            <td><?= h($filename->file) ?></td>
        </tr>
        <tr>
            <th><?= __('Customer') ?></th>
            <td><?= $filename->has('customer') ? $this->Html->link($filename->customer->customer_name, ['controller' => 'Customers', 'action' => 'view', $filename->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($filename->id) ?></td>
        </tr>
    </table>
</div>
