 <?php $url_excel="/?".$url; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Material Indents</span> 
			
	    </div>
		<div class="actions">
			
			<div class="btn-group">
			<?php
			if($status==null or $status=='Open'){ $class1='btn btn-primary'; }else{ $class1='btn btn-default'; }
			if($status=='Close'){ $class2='btn btn-primary'; }else{ $class2='btn btn-default'; }
			?>
			<?= $this->Html->link(
					'Open',
					'/MaterialIndents/index?status=Open',
					['class' => $class1]
				); ?>
			<?= $this->Html->link(
					'Close',
					'/MaterialIndents/index?status=Close',
					['class' => $class2 ]
				); ?>
				
			
			</div>
			<?php echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Excel', '/MaterialIndents/Excel-Export/'.$url_excel.'',['class' =>'btn  green tooltips','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>
		</div>
				 <form method="GET" >
				<input type="hidden" name="pull-request" value="<?php echo @$pull_request; ?>">
				<input type="hidden" name="gst" value="<?php echo @$gst; ?>">
				<input type="hidden" name="job-card" value="<?php echo @$job_card; ?>">
				<table class="table table-condensed">
					<tbody>
						<tr>
							<td width="17%">
								<div class="input-group" id="pnf_text">
									<span class="input-group-addon">MI-</span><input type="text" name="mi_no" class="form-control input-sm" placeholder="Material Indent No" value="<?php echo @$mi_no; ?>">
								</div>
							</td>
							
							<td width="9%">
								<input type="text" name="From" class="form-control input-sm date-picker" placeholder="From" value="<?php echo @$From; ?>" data-date-format="dd-mm-yyyy" >
							</td>
							<td width="9%">
								<input type="text" name="To" class="form-control input-sm date-picker" placeholder="To" value="<?php echo @$To; ?>" data-date-format="dd-mm-yyyy" >
							</td>
							<td>
								<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
							</td>
						</tr>
					</tbody>
				</table>
				</form>
<?php $page_no=$this->Paginator->current('MaterialIndentS'); $page_no=($page_no-1)*20; ?>
	<table class="table table-bordered table-striped table-hover">
		<thead>
				<tr>
				<td style="font-size:120%;">Sr.No.</td>
				<td style="font-size:120%;">Material Indent No</td>
				<td style="font-size:120%;">Created on</td>
				<td style="font-size:120%;">Action</td>
				</tr>
		</thead>
        <tbody>
            <?php  foreach($materialIndents as $materialIndent): 
			//pr($materialIndent->material_indent_rows);
			?>
            <tr>
			   <td><?= h(++$page_no) ?></td>
			   <td>
				<?= h('#'.str_pad($materialIndent->mi_number, 4, '0', STR_PAD_LEFT)) ?>
			    </td>
				<td><?php echo date("d-m-Y",strtotime($materialIndent->created_on)); ?></td>
				
				<td class="actions">
				<?php if($status==null or $status=='Open'){ ?>
				<!--<?php echo $this->Html->link('<i class="fa fa-search"></i>',['action' => 'view', $materialIndent->id],array('escape'=>false,'target'=>'_blank','class'=>'btn btn-xs yellow tooltips')); ?>-->
				<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $materialIndent->id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit'));?>
				<?php }; ?>
				</td>
				
			</tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
