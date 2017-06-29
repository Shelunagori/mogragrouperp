<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Riv'), ['action' => 'edit', $riv->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Riv'), ['action' => 'delete', $riv->id], ['confirm' => __('Are you sure you want to delete # {0}?', $riv->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Rivs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Riv'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['controller' => 'SaleReturns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return'), ['controller' => 'SaleReturns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Left Rivs'), ['controller' => 'LeftRivs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Left Riv'), ['controller' => 'LeftRivs', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rivs view large-9 medium-8 columns content">
    <h3><?= h($riv->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Sale Return') ?></th>
            <td><?= $riv->has('sale_return') ? $this->Html->link($riv->sale_return->id, ['controller' => 'SaleReturns', 'action' => 'view', $riv->sale_return->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($riv->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Voucher No') ?></th>
            <td><?= $this->Number->format($riv->voucher_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Created On') ?></th>
            <td><?= h($riv->created_on) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Left Rivs') ?></h4>
        <?php if (!empty($riv->left_rivs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Riv Id') ?></th>
                <th><?= __('Item Id') ?></th>
                <th><?= __('Quantity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($riv->left_rivs as $leftRivs): ?>
            <tr>
                <td><?= h($leftRivs->id) ?></td>
                <td><?= h($leftRivs->riv_id) ?></td>
                <td><?= h($leftRivs->item_id) ?></td>
                <td><?= h($leftRivs->quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'LeftRivs', 'action' => 'view', $leftRivs->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'LeftRivs', 'action' => 'edit', $leftRivs->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'LeftRivs', 'action' => 'delete', $leftRivs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leftRivs->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
