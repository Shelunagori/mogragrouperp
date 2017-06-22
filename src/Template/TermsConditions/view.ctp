<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Terms Condition'), ['action' => 'edit', $termsCondition->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Terms Condition'), ['action' => 'delete', $termsCondition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $termsCondition->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Terms Conditions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Terms Condition'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="termsConditions view large-9 medium-8 columns content">
    <h3><?= h($termsCondition->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($termsCondition->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Text Line') ?></h4>
        <?= $this->Text->autoParagraph(h($termsCondition->text_line)); ?>
    </div>
</div>
