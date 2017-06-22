<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Financial Years'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="financialYears form large-9 medium-8 columns content">
    <?= $this->Form->create($financialYear) ?>
    <fieldset>
        <legend><?= __('Add Financial Year') ?></legend>
        <?php
            echo $this->Form->input('date_from');
            echo $this->Form->input('date_to');
            echo $this->Form->input('status');
            echo $this->Form->input('company_id', ['options' => $companies]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
