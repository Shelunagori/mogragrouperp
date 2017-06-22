<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $filename->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $filename->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Filenames'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="filenames form large-9 medium-8 columns content">
    <?= $this->Form->create($filename) ?>
    <fieldset>
        <legend><?= __('Edit Filename') ?></legend>
        <?php
            echo $this->Form->input('file');
            echo $this->Form->input('customer_id', ['options' => $customers]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
