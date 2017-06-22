<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Edit Terms & Conditions</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		 <?= $this->Form->create($termsCondition,array("class"=>"form-horizontal")) ?>
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-3">Text Line <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-4">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('text_line', ['label' => false,'class' => 'form-control input-sm']); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-primary">UPDATE</button>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		<!-- END FORM-->
	</div>
</div>
