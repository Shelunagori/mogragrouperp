<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Challan'), ['action' => 'edit', $challan->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Challan'), ['action' => 'delete', $challan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $challan->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Challans'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Challan'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Transporters'), ['controller' => 'Transporters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Transporter'), ['controller' => 'Transporters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="challans view large-9 medium-8 columns content">
    <h3><?= h($challan->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Customer') ?></th>
            <td><?= $challan->has('customer') ? $this->Html->link($challan->customer->customer_name, ['controller' => 'Customers', 'action' => 'view', $challan->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Company') ?></th>
            <td><?= $challan->has('company') ? $this->Html->link($challan->company->name, ['controller' => 'Companies', 'action' => 'view', $challan->company->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Invoice') ?></th>
            <td><?= $challan->has('invoice') ? $this->Html->link($challan->invoice->id, ['controller' => 'Invoices', 'action' => 'view', $challan->invoice->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Transporter') ?></th>
            <td><?= $challan->has('transporter') ? $this->Html->link($challan->transporter->transporter_name, ['controller' => 'Transporters', 'action' => 'view', $challan->transporter->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Reference Detail') ?></th>
            <td><?= h($challan->reference_detail) ?></td>
        </tr>
        <tr>
            <th><?= __('Documents') ?></th>
            <td><?= h($challan->documents) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($challan->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Lr No') ?></th>
            <td><?= $this->Number->format($challan->lr_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Total') ?></th>
            <td><?= $this->Number->format($challan->total) ?></td>
        </tr>
        <tr>
            <th><?= __('Date') ?></th>
            <td><?= h($challan->date) ?></td>
        </tr>
    </table>
</div>
