<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit District'), ['action' => 'edit', $district->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete District'), ['action' => 'delete', $district->id], ['confirm' => __('Are you sure you want to delete # {0}?', $district->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Districts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New District'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="districts view large-9 medium-8 columns content">
    <h3><?= h($district->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('State') ?></th>
            <td><?= h($district->state) ?></td>
        </tr>
        <tr>
            <th><?= __('District') ?></th>
            <td><?= h($district->district) ?></td>
        </tr>
        <tr>
            <th><?= __('District Description') ?></th>
            <td><?= h($district->district_description) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($district->id) ?></td>
        </tr>
    </table>
</div>
