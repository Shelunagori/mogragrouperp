<?php if(!empty($id)){ ?>
<div class="userRights form large-9 medium-8 columns content">
    <?= $this->Form->create($userRight) ?>
    <fieldset>
        <legend><?= __('Edit User Right') ?></legend>
        <?php
            echo $this->Form->input('login_id', ['options' => $logins]);
            echo $this->Form->input('page_id', ['options' => $pages]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<?php } ?>
