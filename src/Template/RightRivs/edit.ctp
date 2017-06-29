<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $rightRiv->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $rightRiv->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Right Rivs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Left Rivs'), ['controller' => 'LeftRivs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Left Riv'), ['controller' => 'LeftRivs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rightRivs form large-9 medium-8 columns content">
    <?= $this->Form->create($rightRiv) ?>
    <fieldset>
        <legend><?= __('Edit Right Riv') ?></legend>
        <?php
            echo $this->Form->input('left_riv_id', ['options' => $leftRivs]);
            echo $this->Form->input('item_id', ['options' => $items]);
            echo $this->Form->input('quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
