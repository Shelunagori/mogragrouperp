<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Left Riv'), ['action' => 'edit', $leftRiv->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Left Riv'), ['action' => 'delete', $leftRiv->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leftRiv->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Left Rivs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Left Riv'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rivs'), ['controller' => 'Rivs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Riv'), ['controller' => 'Rivs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Right Rivs'), ['controller' => 'RightRivs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Right Riv'), ['controller' => 'RightRivs', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="leftRivs view large-9 medium-8 columns content">
    <h3><?= h($leftRiv->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Riv') ?></th>
            <td><?= $leftRiv->has('riv') ? $this->Html->link($leftRiv->riv->id, ['controller' => 'Rivs', 'action' => 'view', $leftRiv->riv->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Item') ?></th>
            <td><?= $leftRiv->has('item') ? $this->Html->link($leftRiv->item->name, ['controller' => 'Items', 'action' => 'view', $leftRiv->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($leftRiv->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($leftRiv->quantity) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Right Rivs') ?></h4>
        <?php if (!empty($leftRiv->right_rivs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Left Riv Id') ?></th>
                <th><?= __('Item Id') ?></th>
                <th><?= __('Quantity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($leftRiv->right_rivs as $rightRivs): ?>
            <tr>
                <td><?= h($rightRivs->id) ?></td>
                <td><?= h($rightRivs->left_riv_id) ?></td>
                <td><?= h($rightRivs->item_id) ?></td>
                <td><?= h($rightRivs->quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RightRivs', 'action' => 'view', $rightRivs->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'RightRivs', 'action' => 'edit', $rightRivs->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RightRivs', 'action' => 'delete', $rightRivs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rightRivs->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
