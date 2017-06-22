<style>
.checkbox{
	margin:0;
}
</style>
<div class="row">
	<div class="col-md-12">					
		<div class="portlet box purple">
			<div class="portlet-title">
				<div class="caption">
					Pending Material Indents
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-scrollable">
					<?= $this->Form->create($mi,['id'=>'form_sample_3']) ?>
					<table class="table table-condensed">
						<thead>
							<tr>
								<th>Material Indent</th>
								<th>Item Name</th>
								<th>Quantity</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($materialIndents as $materialIndent){ 
							foreach($materialIndent->material_indent_rows as  $key=>$material_indent_row){ ?>
							<tr>
								<?php if($key==0){ ?>
								<td rowspan="<?php echo sizeof($materialIndent->material_indent_rows); ?>"><?= h($materialIndent->mi_number) ?></td>
								<?php } ?>
								<td><?= h($material_indent_row->item->name) ?></td>
								<td><?= h($material_indent_row->required_quantity-$material_indent_row->processed_quantity) ?></td>
								<td>
								<?php echo $this->Form->input('selected_data.'.$materialIndent->id.'.'.$material_indent_row->item->id, ['type' => 'checkbox','label' => false,'class' => 'form-control','value' => $material_indent_row->required_quantity-$material_indent_row->processed_quantity]); ?>
								</td>
							</tr>
						<?php } } ?>
						</tbody>
					</table>
					<button type="submit" class="btn btn-primary" >GENERATE PURCHASE ORDER</button>
					<?= $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
</div>
