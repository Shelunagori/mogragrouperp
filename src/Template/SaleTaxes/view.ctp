<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sale Tax'), ['action' => 'edit', $saleTax->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sale Tax'), ['action' => 'delete', $saleTax->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleTax->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sale Taxes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Tax'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="saleTaxes view large-9 medium-8 columns content">
    <h3><?= h($saleTax->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($saleTax->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($saleTax->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Tax Figure') ?></th>
            <td><?= $this->Number->format($saleTax->tax_figure) ?></td>
        </tr>
    </table>
</div>
