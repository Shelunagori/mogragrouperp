<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Item Sub Groups'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Item Groups'), ['controller' => 'ItemGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Group'), ['controller' => 'ItemGroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemSubGroups form large-9 medium-8 columns content">
    <?= $this->Form->create($itemSubGroup) ?>
    <fieldset>
        <legend><?= __('Add Item Sub Group') ?></legend>
        <?php
            echo $this->Form->input('item_group_id', ['options' => $itemGroups]);
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
