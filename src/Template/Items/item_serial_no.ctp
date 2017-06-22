<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Add SERial number </span>
		</div>
	</div>
	<div class="portlet-body" >
		<?= $this->Form->create($item,['id'=>'form_sample_3']) ?>
			<div class="row">
			 <div class="col-md-8">
			 <table class="table table-hover">
				 <thead>
					<tr>
						<th width="15%">S.N.</th>
						<th width="20%">Serial No</th>
						
					</tr>
				</thead>
				<tbody>
				<?php $sr=0; for($i=0; $i<=$ledger_data['total_rows'] ;$i++){  $sr++; ?>
					<tr>
							<td><?= h($sr) ?></td>
							<td><?php echo $this->Form->input(
							'item_serial_numbers.'.$i.'.serial_no', ['label' => false,'class' => 'form-control input-sm firstupercase','placeholder'=>'Name']); ?></td>
							
					</tr>
				<?php  } ?>
				</tbody>
			</table>
		</div>
		
		</div>
		<div class="form-actions">
				 <button type="submit" class="btn blue-hoki">Add Item</button>
			</div>
		<?= $this->Form->end() ?>
	</div>
</div>

