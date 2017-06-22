<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Purchase Order'), ['action' => 'edit', $purchaseOrder->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Purchase Order'), ['action' => 'delete', $purchaseOrder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrder->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Orders'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Grns'), ['controller' => 'Grns', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grn'), ['controller' => 'Grns', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Order Rows'), ['controller' => 'PurchaseOrderRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order Row'), ['controller' => 'PurchaseOrderRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="purchaseOrders view large-9 medium-8 columns content">
    <h3><?= h($purchaseOrder->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Company') ?></th>
            <td><?= $purchaseOrder->has('company') ? $this->Html->link($purchaseOrder->company->name, ['controller' => 'Companies', 'action' => 'view', $purchaseOrder->company->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Vendor') ?></th>
            <td><?= $purchaseOrder->has('vendor') ? $this->Html->link($purchaseOrder->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $purchaseOrder->vendor->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Shipping Method') ?></th>
            <td><?= h($purchaseOrder->shipping_method) ?></td>
        </tr>
        <tr>
            <th><?= __('Po1') ?></th>
            <td><?= h($purchaseOrder->po1) ?></td>
        </tr>
        <tr>
            <th><?= __('Po3') ?></th>
            <td><?= h($purchaseOrder->po3) ?></td>
        </tr>
        <tr>
            <th><?= __('Po4') ?></th>
            <td><?= h($purchaseOrder->po4) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($purchaseOrder->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Shipping Terms') ?></th>
            <td><?= $this->Number->format($purchaseOrder->shipping_terms) ?></td>
        </tr>
        <tr>
            <th><?= __('Total') ?></th>
            <td><?= $this->Number->format($purchaseOrder->total) ?></td>
        </tr>
        <tr>
            <th><?= __('Delivery Date') ?></th>
            <td><?= h($purchaseOrder->delivery_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Terms Conditions') ?></h4>
        <?= $this->Text->autoParagraph(h($purchaseOrder->terms_conditions)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Grns') ?></h4>
        <?php if (!empty($purchaseOrder->grns)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Date') ?></th>
                <th><?= __('Purchase Order Id') ?></th>
                <th><?= __('Company Id') ?></th>
                <th><?= __('Grn1') ?></th>
                <th><?= __('Grn3') ?></th>
                <th><?= __('Grn4') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($purchaseOrder->grns as $grns): ?>
            <tr>
                <td><?= h($grns->id) ?></td>
                <td><?= h($grns->date) ?></td>
                <td><?= h($grns->purchase_order_id) ?></td>
                <td><?= h($grns->company_id) ?></td>
                <td><?= h($grns->grn1) ?></td>
                <td><?= h($grns->grn3) ?></td>
                <td><?= h($grns->grn4) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Grns', 'action' => 'view', $grns->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Grns', 'action' => 'edit', $grns->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Grns', 'action' => 'delete', $grns->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grns->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Purchase Order Rows') ?></h4>
        <?php if (!empty($purchaseOrder->purchase_order_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Purchase Order Id') ?></th>
                <th><?= __('Item Id') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Rate') ?></th>
                <th><?= __('Amount') ?></th>
                <th><?= __('Processed Quantity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($purchaseOrder->purchase_order_rows as $purchaseOrderRows): ?>
            <tr>
                <td><?= h($purchaseOrderRows->id) ?></td>
                <td><?= h($purchaseOrderRows->purchase_order_id) ?></td>
                <td><?= h($purchaseOrderRows->item_id) ?></td>
                <td><?= h($purchaseOrderRows->description) ?></td>
                <td><?= h($purchaseOrderRows->quantity) ?></td>
                <td><?= h($purchaseOrderRows->rate) ?></td>
                <td><?= h($purchaseOrderRows->amount) ?></td>
                <td><?= h($purchaseOrderRows->processed_quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PurchaseOrderRows', 'action' => 'view', $purchaseOrderRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PurchaseOrderRows', 'action' => 'edit', $purchaseOrderRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchaseOrderRows', 'action' => 'delete', $purchaseOrderRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrderRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
