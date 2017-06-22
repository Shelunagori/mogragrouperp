<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Iv'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Iv Left Rows'), ['controller' => 'IvLeftRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Iv Left Row'), ['controller' => 'IvLeftRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ivs index large-9 medium-8 columns content">
    <h3><?= __('Ivs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('invoice_id') ?></th>
                <th><?= $this->Paginator->sort('voucher_no') ?></th>
                <th><?= $this->Paginator->sort('transaction_date') ?></th>
                <th><?= $this->Paginator->sort('company_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ivs as $iv): ?>
            <tr>
                <td><?= $this->Number->format($iv->id) ?></td>
                <td><?= $iv->has('invoice') ? $this->Html->link($iv->invoice->id, ['controller' => 'Invoices', 'action' => 'view', $iv->invoice->id]) : '' ?></td>
                <td><?= $this->Number->format($iv->voucher_no) ?></td>
                <td><?= h($iv->transaction_date) ?></td>
                <td><?= $iv->has('company') ? $this->Html->link($iv->company->name, ['controller' => 'Companies', 'action' => 'view', $iv->company->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $iv->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $iv->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $iv->id], ['confirm' => __('Are you sure you want to delete # {0}?', $iv->id)]) ?>
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
