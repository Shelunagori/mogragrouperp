<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Customer Group'), ['action' => 'edit', $customerGroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Customer Group'), ['action' => 'delete', $customerGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerGroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Customer Groups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer Group'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="customerGroups view large-9 medium-8 columns content">
    <h3><?= h($customerGroup->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($customerGroup->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($customerGroup->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Customers') ?></h4>
        <?php if (!empty($customerGroup->customers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Customer Group Id') ?></th>
                <th><?= __('Customer Name') ?></th>
                <th><?= __('Contact Person') ?></th>
                <th><?= __('District Id') ?></th>
                <th><?= __('Company Group Id') ?></th>
                <th><?= __('Customer Seg Id') ?></th>
                <th><?= __('Tin No') ?></th>
                <th><?= __('Gst No') ?></th>
                <th><?= __('Pan No') ?></th>
                <th><?= __('Ecc No') ?></th>
                <th><?= __('Flag') ?></th>
                <th><?= __('Employee Id') ?></th>
                <th><?= __('Payment Terms') ?></th>
                <th><?= __('Mode Of Payment') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customerGroup->customers as $customers): ?>
            <tr>
                <td><?= h($customers->id) ?></td>
                <td><?= h($customers->customer_group_id) ?></td>
                <td><?= h($customers->customer_name) ?></td>
                <td><?= h($customers->contact_person) ?></td>
                <td><?= h($customers->district_id) ?></td>
                <td><?= h($customers->company_group_id) ?></td>
                <td><?= h($customers->customer_seg_id) ?></td>
                <td><?= h($customers->tin_no) ?></td>
                <td><?= h($customers->gst_no) ?></td>
                <td><?= h($customers->pan_no) ?></td>
                <td><?= h($customers->ecc_no) ?></td>
                <td><?= h($customers->flag) ?></td>
                <td><?= h($customers->employee_id) ?></td>
                <td><?= h($customers->payment_terms) ?></td>
                <td><?= h($customers->mode_of_payment) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Customers', 'action' => 'view', $customers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Customers', 'action' => 'edit', $customers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Customers', 'action' => 'delete', $customers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
