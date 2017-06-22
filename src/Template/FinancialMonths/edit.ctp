<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $financialMonth->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $financialMonth->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Financial Months'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Financial Years'), ['controller' => 'FinancialYears', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Financial Year'), ['controller' => 'FinancialYears', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="financialMonths form large-9 medium-8 columns content">
    <?= $this->Form->create($financialMonth) ?>
    <fieldset>
        <legend><?= __('Edit Financial Month') ?></legend>
        <?php
            echo $this->Form->input('financial_year_id', ['options' => $financialYears]);
            echo $this->Form->input('month');
            echo $this->Form->input('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
