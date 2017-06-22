<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Transporters'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="transporters form large-9 medium-8 columns content">
    <?= $this->Form->create($transporter) ?>
    <fieldset>
        <legend><?= __('Add Transporter') ?></legend>
        <?php
            echo $this->Form->input('transporter_name');
            echo $this->Form->input('alias');
            echo $this->Form->input('transporter_company');
            echo $this->Form->input('address');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
