<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Credit Notes Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Credit Notes'), ['controller' => 'CreditNotes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Credit Note'), ['controller' => 'CreditNotes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="creditNotesRows index large-9 medium-8 columns content">
    <h3><?= __('Credit Notes Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('credit_note_id') ?></th>
                <th><?= $this->Paginator->sort('head_id') ?></th>
                <th><?= $this->Paginator->sort('amount') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($creditNotesRows as $creditNotesRow): ?>
            <tr>
                <td><?= $this->Number->format($creditNotesRow->id) ?></td>
                <td><?= $creditNotesRow->has('credit_note') ? $this->Html->link($creditNotesRow->credit_note->id, ['controller' => 'CreditNotes', 'action' => 'view', $creditNotesRow->credit_note->id]) : '' ?></td>
                <td><?= $this->Number->format($creditNotesRow->head_id) ?></td>
                <td><?= $this->Number->format($creditNotesRow->amount) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $creditNotesRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $creditNotesRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $creditNotesRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $creditNotesRow->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
