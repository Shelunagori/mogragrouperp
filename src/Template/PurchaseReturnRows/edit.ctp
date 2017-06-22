<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $purchaseReturnRow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseReturnRow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Purchase Return Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="purchaseReturnRows form large-9 medium-8 columns content">
    <?= $this->Form->create($purchaseReturnRow) ?>
    <fieldset>
        <legend><?= __('Edit Purchase Return Row') ?></legend>
        <?php
            echo $this->Form->input('purchase_return_id');
            echo $this->Form->input('item_id', ['options' => $items]);
            echo $this->Form->input('quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
