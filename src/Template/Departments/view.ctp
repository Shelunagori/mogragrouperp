<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Dipartment'), ['action' => 'edit', $dipartment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Dipartment'), ['action' => 'delete', $dipartment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dipartment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Dipartments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Dipartment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="dipartments view large-9 medium-8 columns content">
    <h3><?= h($dipartment->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($dipartment->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($dipartment->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Employees') ?></h4>
        <?php if (!empty($dipartment->employees)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Sex') ?></th>
                <th><?= __('Dipartment Id') ?></th>
                <th><?= __('Designation Id') ?></th>
                <th><?= __('Mobile') ?></th>
                <th><?= __('Email') ?></th>
                <th><?= __('Address') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($dipartment->employees as $employees): ?>
            <tr>
                <td><?= h($employees->id) ?></td>
                <td><?= h($employees->name) ?></td>
                <td><?= h($employees->sex) ?></td>
                <td><?= h($employees->dipartment_id) ?></td>
                <td><?= h($employees->designation_id) ?></td>
                <td><?= h($employees->mobile) ?></td>
                <td><?= h($employees->email) ?></td>
                <td><?= h($employees->address) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Employees', 'action' => 'view', $employees->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Employees', 'action' => 'edit', $employees->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Employees', 'action' => 'delete', $employees->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employees->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
