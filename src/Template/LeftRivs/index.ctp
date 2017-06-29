<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Left Riv'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rivs'), ['controller' => 'Rivs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Riv'), ['controller' => 'Rivs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Right Rivs'), ['controller' => 'RightRivs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Right Riv'), ['controller' => 'RightRivs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="leftRivs index large-9 medium-8 columns content">
    <h3><?= __('Left Rivs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('riv_id') ?></th>
                <th><?= $this->Paginator->sort('item_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($leftRivs as $leftRiv): ?>
            <tr>
                <td><?= $this->Number->format($leftRiv->id) ?></td>
                <td><?= $leftRiv->has('riv') ? $this->Html->link($leftRiv->riv->id, ['controller' => 'Rivs', 'action' => 'view', $leftRiv->riv->id]) : '' ?></td>
                <td><?= $leftRiv->has('item') ? $this->Html->link($leftRiv->item->name, ['controller' => 'Items', 'action' => 'view', $leftRiv->item->id]) : '' ?></td>
                <td><?= $this->Number->format($leftRiv->quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $leftRiv->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $leftRiv->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $leftRiv->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leftRiv->id)]) ?>
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
