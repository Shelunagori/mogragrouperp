<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Transporter'), ['action' => 'edit', $transporter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Transporter'), ['action' => 'delete', $transporter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transporter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Transporters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Transporter'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="transporters view large-9 medium-8 columns content">
    <h3><?= h($transporter->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Transporter Name') ?></th>
            <td><?= h($transporter->transporter_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Alias') ?></th>
            <td><?= h($transporter->alias) ?></td>
        </tr>
        <tr>
            <th><?= __('Transporter Company') ?></th>
            <td><?= h($transporter->transporter_company) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($transporter->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Address') ?></h4>
        <?= $this->Text->autoParagraph(h($transporter->address)); ?>
    </div>
</div>
