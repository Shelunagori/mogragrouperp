<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $jobCardRow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $jobCardRow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Job Card Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Job Cards'), ['controller' => 'JobCards', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job Card'), ['controller' => 'JobCards', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sales Order Rows'), ['controller' => 'SalesOrderRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sales Order Row'), ['controller' => 'SalesOrderRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="jobCardRows form large-9 medium-8 columns content">
    <?= $this->Form->create($jobCardRow) ?>
    <fieldset>
        <legend><?= __('Edit Job Card Row') ?></legend>
        <?php
            echo $this->Form->input('job_card_id', ['options' => $jobCards]);
            echo $this->Form->input('sales_order_row_id', ['options' => $salesOrderRows]);
            echo $this->Form->input('item_id', ['options' => $items]);
            echo $this->Form->input('quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
