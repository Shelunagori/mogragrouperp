<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Sale Taxes'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="saleTaxes form large-9 medium-8 columns content">
    <?= $this->Form->create($saleTax) ?>
    <fieldset>
        <legend><?= __('Add Sale Tax') ?></legend>
        <?php
            echo $this->Form->input('tax_figure');
            echo $this->Form->input('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
