<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Vendor'), ['action' => 'edit', $vendor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Vendor'), ['action' => 'delete', $vendor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendor->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Vendors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendor'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Orders'), ['controller' => 'PurchaseOrders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order'), ['controller' => 'PurchaseOrders', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="vendors view large-9 medium-8 columns content">
    <h3><?= h($vendor->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Company Name') ?></th>
            <td><?= h($vendor->company_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Tin No') ?></th>
            <td><?= h($vendor->tin_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Gst No') ?></th>
            <td><?= h($vendor->gst_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Ecc No') ?></th>
            <td><?= h($vendor->ecc_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Pan No') ?></th>
            <td><?= h($vendor->pan_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Mode Of Payment') ?></th>
            <td><?= h($vendor->mode_of_payment) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($vendor->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Payment Terms') ?></th>
            <td><?= $this->Number->format($vendor->payment_terms) ?></td>
        </tr>
        <tr>
            <th><?= __('Item Group Id') ?></th>
            <td><?= $this->Number->format($vendor->item_group_id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Address') ?></h4>
        <?= $this->Text->autoParagraph(h($vendor->address)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Purchase Orders') ?></h4>
        <?php if (!empty($vendor->purchase_orders)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Company Id') ?></th>
                <th><?= __('Vendor Id') ?></th>
                <th><?= __('Shipping Method') ?></th>
                <th><?= __('Shipping Terms') ?></th>
                <th><?= __('Delivery Date') ?></th>
                <th><?= __('Total') ?></th>
                <th><?= __('Terms Conditions') ?></th>
                <th><?= __('Po1') ?></th>
                <th><?= __('Po3') ?></th>
                <th><?= __('Po4') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($vendor->purchase_orders as $purchaseOrders): ?>
            <tr>
                <td><?= h($purchaseOrders->id) ?></td>
                <td><?= h($purchaseOrders->company_id) ?></td>
                <td><?= h($purchaseOrders->vendor_id) ?></td>
                <td><?= h($purchaseOrders->shipping_method) ?></td>
                <td><?= h($purchaseOrders->shipping_terms) ?></td>
                <td><?= h($purchaseOrders->delivery_date) ?></td>
                <td><?= h($purchaseOrders->total) ?></td>
                <td><?= h($purchaseOrders->terms_conditions) ?></td>
                <td><?= h($purchaseOrders->po1) ?></td>
                <td><?= h($purchaseOrders->po3) ?></td>
                <td><?= h($purchaseOrders->po4) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PurchaseOrders', 'action' => 'view', $purchaseOrders->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PurchaseOrders', 'action' => 'edit', $purchaseOrders->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PurchaseOrders', 'action' => 'delete', $purchaseOrders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrders->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
