<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Right Riv'), ['action' => 'edit', $rightRiv->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Right Riv'), ['action' => 'delete', $rightRiv->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rightRiv->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Right Rivs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Right Riv'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Left Rivs'), ['controller' => 'LeftRivs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Left Riv'), ['controller' => 'LeftRivs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rightRivs view large-9 medium-8 columns content">
    <h3><?= h($rightRiv->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Left Riv') ?></th>
            <td><?= $rightRiv->has('left_riv') ? $this->Html->link($rightRiv->left_riv->id, ['controller' => 'LeftRivs', 'action' => 'view', $rightRiv->left_riv->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Item') ?></th>
            <td><?= $rightRiv->has('item') ? $this->Html->link($rightRiv->item->name, ['controller' => 'Items', 'action' => 'view', $rightRiv->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($rightRiv->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($rightRiv->quantity) ?></td>
        </tr>
    </table>
</div>
