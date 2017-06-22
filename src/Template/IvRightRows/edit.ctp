<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ivRightRow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ivRightRow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Iv Right Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Iv Left Rows'), ['controller' => 'IvLeftRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv Left Row'), ['controller' => 'IvLeftRows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Iv Right Serial Numbers'), ['controller' => 'IvRightSerialNumbers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv Right Serial Number'), ['controller' => 'IvRightSerialNumbers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ivRightRows form large-9 medium-8 columns content">
    <?= $this->Form->create($ivRightRow) ?>
    <fieldset>
        <legend><?= __('Edit Iv Right Row') ?></legend>
        <?php
            echo $this->Form->input('iv_left_row_id', ['options' => $ivLeftRows]);
            echo $this->Form->input('item_id', ['options' => $items]);
            echo $this->Form->input('quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
