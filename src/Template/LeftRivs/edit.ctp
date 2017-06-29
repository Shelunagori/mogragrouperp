<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $leftRiv->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $leftRiv->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Left Rivs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Rivs'), ['controller' => 'Rivs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Riv'), ['controller' => 'Rivs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Right Rivs'), ['controller' => 'RightRivs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Right Riv'), ['controller' => 'RightRivs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="leftRivs form large-9 medium-8 columns content">
    <?= $this->Form->create($leftRiv) ?>
    <fieldset>
        <legend><?= __('Edit Left Riv') ?></legend>
        <?php
            echo $this->Form->input('riv_id', ['options' => $rivs]);
            echo $this->Form->input('item_id', ['options' => $items]);
            echo $this->Form->input('quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
