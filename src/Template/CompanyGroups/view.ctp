<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Company Group'), ['action' => 'edit', $companyGroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Company Group'), ['action' => 'delete', $companyGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $companyGroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Company Groups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company Group'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="companyGroups view large-9 medium-8 columns content">
    <h3><?= h($companyGroup->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($companyGroup->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($companyGroup->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($companyGroup->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Flag') ?></th>
            <td><?= $this->Number->format($companyGroup->flag) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Customers') ?></h4>
        <?php if (!empty($companyGroup->customers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Customer Name') ?></th>
                <th><?= __('District Id') ?></th>
                <th><?= __('Company Group Id') ?></th>
                <th><?= __('Customer Seg Id') ?></th>
                <th><?= __('Customer Contact Id') ?></th>
                <th><?= __('Tin No') ?></th>
                <th><?= __('Gst No') ?></th>
                <th><?= __('Pan No') ?></th>
                <th><?= __('Ecc No') ?></th>
                <th><?= __('Flag') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($companyGroup->customers as $customers): ?>
            <tr>
                <td><?= h($customers->id) ?></td>
                <td><?= h($customers->customer_name) ?></td>
                <td><?= h($customers->district_id) ?></td>
                <td><?= h($customers->company_group_id) ?></td>
                <td><?= h($customers->customer_seg_id) ?></td>
                <td><?= h($customers->customer_contact_id) ?></td>
                <td><?= h($customers->tin_no) ?></td>
                <td><?= h($customers->gst_no) ?></td>
                <td><?= h($customers->pan_no) ?></td>
                <td><?= h($customers->ecc_no) ?></td>
                <td><?= h($customers->flag) ?></td>
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
