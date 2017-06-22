<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Quotation Close Reason'), ['action' => 'edit', $quotationCloseReason->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Quotation Close Reason'), ['action' => 'delete', $quotationCloseReason->id], ['confirm' => __('Are you sure you want to delete # {0}?', $quotationCloseReason->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Quotation Close Reasons'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Quotation Close Reason'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="quotationCloseReasons view large-9 medium-8 columns content">
    <h3><?= h($quotationCloseReason->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($quotationCloseReason->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Reasion') ?></h4>
        <?= $this->Text->autoParagraph(h($quotationCloseReason->reasion)); ?>
    </div>
</div>
