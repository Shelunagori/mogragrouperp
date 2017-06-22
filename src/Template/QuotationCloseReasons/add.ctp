<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Quotation Close Reasons'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="quotationCloseReasons form large-9 medium-8 columns content">
    <?= $this->Form->create($quotationCloseReason) ?>
    <fieldset>
        <legend><?= __('Add Quotation Close Reason') ?></legend>
        <?php
            echo $this->Form->input('reasion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
