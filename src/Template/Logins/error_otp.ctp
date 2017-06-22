<style>
label.control-label{
	color: #a94442;
}
</style>

<?php
$this->Form->templates([
    'inputContainer' => '{{content}}'
]);
?>
<!-- BEGIN LOGIN FORM -->
	<?= $this->Form->create($Employee) ?>
		<h3 class="form-title" style="text-align:center;color: #a94442;">Login ERROR</h3>
       
       <div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label">Please Contact Your Admin for your Mobile Number is not correct</label>
			
		</div>
		
	<?= $this->Form->end() ?>
	<!-- END LOGIN FORM -->