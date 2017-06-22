<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Quotation Close Reasons</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
	<div class="row ">
		<div class="col-md-6">
		 <?= $this->Form->create($quotationCloseReason,array("class"=>"form-horizontal")) ?>
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-3">Reason<span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('reason', ['type'=>'textarea','label' => false,'class' => 'form-control input-sm']); ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-offset-4 col-md-8">
						<button type="submit" class="btn btn-primary">ADD</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>