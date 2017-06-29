<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Right Riv'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Left Rivs'), ['controller' => 'LeftRivs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Left Riv'), ['controller' => 'LeftRivs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rightRivs index large-9 medium-8 columns content">
    <h3><?= __('Right Rivs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('left_riv_id') ?></th>
                <th><?= $this->Paginator->sort('item_id') ?></th>
                <th><?= $this->Paginator->sort('quantity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rightRivs as $rightRiv): ?>
            <tr>
                <td><?= $this->Number->format($rightRiv->id) ?></td>
                <td><?= $rightRiv->has('left_riv') ? $this->Html->link($rightRiv->left_riv->id, ['controller' => 'LeftRivs', 'action' => 'view', $rightRiv->left_riv->id]) : '' ?></td>
                <td><?= $rightRiv->has('item') ? $this->Html->link($rightRiv->item->name, ['controller' => 'Items', 'action' => 'view', $rightRiv->item->id]) : '' ?></td>
                <td><?= $this->Number->format($rightRiv->quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $rightRiv->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rightRiv->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rightRiv->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rightRiv->id)]) ?>
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
