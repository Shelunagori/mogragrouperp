<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Financial Month'), ['action' => 'edit', $financialMonth->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Financial Month'), ['action' => 'delete', $financialMonth->id], ['confirm' => __('Are you sure you want to delete # {0}?', $financialMonth->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Financial Months'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Financial Month'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Financial Years'), ['controller' => 'FinancialYears', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Financial Year'), ['controller' => 'FinancialYears', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="financialMonths view large-9 medium-8 columns content">
    <h3><?= h($financialMonth->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Financial Year') ?></th>
            <td><?= $financialMonth->has('financial_year') ? $this->Html->link($financialMonth->financial_year->id, ['controller' => 'FinancialYears', 'action' => 'view', $financialMonth->financial_year->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Month') ?></th>
            <td><?= h($financialMonth->month) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($financialMonth->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($financialMonth->id) ?></td>
        </tr>
    </table>
</div>
