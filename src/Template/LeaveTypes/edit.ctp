<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Leave Types</span>
		</div>
	</div>
<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">
		<div class="col-md-6">
		 <?= $this->Form->create($leaveType,array("class"=>"form-horizontal")) ?>
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-5">Leave Type<span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-7">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('leave_name', ['label' => false,'class' => 'form-control','placeholder' => 'Leave Type']); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-5">Maximum Leave in Month <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-7">
						<div class="input-icon right">
							<i class="fa"></i>
							 <?php echo $this->Form->input('maximum_leave_in_month', ['label' => false,'class' => 'form-control']); ?>
						</div>
					</div>
				</div>
			
				<div class="row">
<<<<<<< HEAD
					<div class="col-md-offset-4 col-md-8">
=======
					<div class="col-md-offset-6 col-md-6">
>>>>>>> fa0e55373da757a24d35562ed041ba39ff37f454
						<button type="submit" class="btn btn-primary">Add Leave Type</button>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		</div>
</div>
</div>