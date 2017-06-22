<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ivLeftSerialNumber->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ivLeftSerialNumber->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Iv Left Serial Numbers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Iv Left Rows'), ['controller' => 'IvLeftRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv Left Row'), ['controller' => 'IvLeftRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ivLeftSerialNumbers form large-9 medium-8 columns content">
    <?= $this->Form->create($ivLeftSerialNumber) ?>
    <fieldset>
        <legend><?= __('Edit Iv Left Serial Number') ?></legend>
        <?php
            echo $this->Form->input('iv_left_row_id', ['options' => $ivLeftRows]);
            echo $this->Form->input('sr_number');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
