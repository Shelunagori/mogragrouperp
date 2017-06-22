<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $creditNotesRow->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $creditNotesRow->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Credit Notes Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Credit Notes'), ['controller' => 'CreditNotes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Credit Note'), ['controller' => 'CreditNotes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="creditNotesRows form large-9 medium-8 columns content">
    <?= $this->Form->create($creditNotesRow) ?>
    <fieldset>
        <legend><?= __('Edit Credit Notes Row') ?></legend>
        <?php
            echo $this->Form->input('credit_note_id', ['options' => $creditNotes]);
            echo $this->Form->input('head_id');
            echo $this->Form->input('amount');
            echo $this->Form->input('narration');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
