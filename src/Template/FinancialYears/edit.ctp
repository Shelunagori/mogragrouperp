
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Financial Years</span>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<div class="row ">

		 <?= $this->Form->create($financialYear,['id'=>'form_sample_3'], array("class"=>"form-horizontal")) ?>
			<div class="form-body">
				<div class="col-md-6">
				<div class="form-group col-md-12">
					<label class="control-label col-md-3">Date From <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
							<?php echo $this->Form->input('date_from', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'','value'=>date("d-m-Y",strtotime($financialYear->date_from)), 'data-date-format'=>'dd-mm-yyyy']); ?>
						</div>
					</div>
				</div>
				</br>
				<div class="form-group col-md-12">
					<label class="control-label col-md-3">Date To <span class="required" aria-required="true">
					* </span>
					</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<i class="fa"></i>
								<?php echo $this->Form->input('date_to', ['type'=>'text','label' => false,'class' => 'form-control input-sm date-picker','placeholder'=>'','data-date-format'=>'dd-mm-yyyy','value'=>date("d-m-Y",strtotime($financialYear->date_to))]); ?>
						</div>
					</div>
				</div>
				</br>
				
			</div>
				<div class="row">
					<div class="col-md-offset-4 col-md-8">
						<button type="submit" class="btn btn-primary">Add Financial Year</button>
					</div>
				</div>
			</div>
		<?= $this->Form->end() ?>
		</div>
	</div>
</div>
