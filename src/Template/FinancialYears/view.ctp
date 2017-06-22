<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Financial Year'), ['action' => 'edit', $financialYear->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Financial Year'), ['action' => 'delete', $financialYear->id], ['confirm' => __('Are you sure you want to delete # {0}?', $financialYear->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Financial Years'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Financial Year'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="financialYears view large-9 medium-8 columns content">
    <h3><?= h($financialYear->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($financialYear->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Company') ?></th>
            <td><?= $financialYear->has('company') ? $this->Html->link($financialYear->company->name, ['controller' => 'Companies', 'action' => 'view', $financialYear->company->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($financialYear->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Date From') ?></th>
            <td><?= h($financialYear->date_from) ?></td>
        </tr>
        <tr>
            <th><?= __('Date To') ?></th>
            <td><?= h($financialYear->date_to) ?></td>
        </tr>
    </table>
</div>
