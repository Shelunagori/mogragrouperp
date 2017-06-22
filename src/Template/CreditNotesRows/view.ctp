<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Credit Notes Row'), ['action' => 'edit', $creditNotesRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Credit Notes Row'), ['action' => 'delete', $creditNotesRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $creditNotesRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Credit Notes Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Credit Notes Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Credit Notes'), ['controller' => 'CreditNotes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Credit Note'), ['controller' => 'CreditNotes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="creditNotesRows view large-9 medium-8 columns content">
    <h3><?= h($creditNotesRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Credit Note') ?></th>
            <td><?= $creditNotesRow->has('credit_note') ? $this->Html->link($creditNotesRow->credit_note->id, ['controller' => 'CreditNotes', 'action' => 'view', $creditNotesRow->credit_note->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($creditNotesRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Head Id') ?></th>
            <td><?= $this->Number->format($creditNotesRow->head_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Amount') ?></th>
            <td><?= $this->Number->format($creditNotesRow->amount) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Narration') ?></h4>
        <?= $this->Text->autoParagraph(h($creditNotesRow->narration)); ?>
    </div>
</div>
