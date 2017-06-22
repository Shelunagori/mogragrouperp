<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Item Groups'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Item Categories'), ['controller' => 'ItemCategories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Category'), ['controller' => 'ItemCategories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Sub Groups'), ['controller' => 'ItemSubGroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Sub Group'), ['controller' => 'ItemSubGroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemGroups form large-9 medium-8 columns content">
    <?= $this->Form->create($itemGroup) ?>
    <fieldset>
        <legend><?= __('Add Item Group') ?></legend>
        <?php
            echo $this->Form->input('item_category_id', ['options' => $itemCategories]);
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
