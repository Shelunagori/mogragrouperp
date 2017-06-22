<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Terms Conditions'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="termsConditions form large-9 medium-8 columns content">
    <?= $this->Form->create($termsCondition) ?>
    <fieldset>
        <legend><?= __('Add Terms Condition') ?></legend>
        <?php
            echo $this->Form->input('text_line');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
