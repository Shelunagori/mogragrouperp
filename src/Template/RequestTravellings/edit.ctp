<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $requestTravelling->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $requestTravelling->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Request Travellings'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="requestTravellings form large-9 medium-8 columns content">
    <?= $this->Form->create($requestTravelling) ?>
    <fieldset>
        <legend><?= __('Edit Request Travelling') ?></legend>
        <?php
            echo $this->Form->input('employee_id', ['options' => $employees]);
            echo $this->Form->input('destination');
            echo $this->Form->input('reason');
            echo $this->Form->input('request_from');
            echo $this->Form->input('request_to');
            echo $this->Form->input('request_date');
            echo $this->Form->input('status');
            echo $this->Form->input('total_ammount');
            echo $this->Form->input('approved_ammount');
            echo $this->Form->input('company_id', ['options' => $companies]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
