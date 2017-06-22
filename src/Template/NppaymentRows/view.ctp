<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Nppayment Row'), ['action' => 'edit', $nppaymentRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Nppayment Row'), ['action' => 'delete', $nppaymentRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nppaymentRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Nppayment Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Nppayment Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Nppayments'), ['controller' => 'Nppayments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Nppayment'), ['controller' => 'Nppayments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Received Froms'), ['controller' => 'LedgerAccounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Received From'), ['controller' => 'LedgerAccounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="nppaymentRows view large-9 medium-8 columns content">
    <h3><?= h($nppaymentRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Nppayment') ?></th>
            <td><?= $nppaymentRow->has('nppayment') ? $this->Html->link($nppaymentRow->nppayment->id, ['controller' => 'Nppayments', 'action' => 'view', $nppaymentRow->nppayment->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Received From') ?></th>
            <td><?= $nppaymentRow->has('received_from') ? $this->Html->link($nppaymentRow->received_from->name, ['controller' => 'LedgerAccounts', 'action' => 'view', $nppaymentRow->received_from->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Cr Dr') ?></th>
            <td><?= h($nppaymentRow->cr_dr) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($nppaymentRow->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Amount') ?></th>
            <td><?= $this->Number->format($nppaymentRow->amount) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Narration') ?></h4>
        <?= $this->Text->autoParagraph(h($nppaymentRow->narration)); ?>
    </div>
</div>
