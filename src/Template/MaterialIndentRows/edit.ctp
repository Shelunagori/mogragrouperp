<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $materialIndentRow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $materialIndentRow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Material Indent Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Material Indents'), ['controller' => 'MaterialIndents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Material Indent'), ['controller' => 'MaterialIndents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="materialIndentRows form large-9 medium-8 columns content">
    <?= $this->Form->create($materialIndentRow) ?>
    <fieldset>
        <legend><?= __('Edit Material Indent Row') ?></legend>
        <?php
            echo $this->Form->input('material_indent_id', ['options' => $materialIndents]);
            echo $this->Form->input('item_id', ['options' => $items]);
            echo $this->Form->input('quantity');
            echo $this->Form->input('approved_purchased_quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
