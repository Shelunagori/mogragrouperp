<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-globe font-blue-steel"></i>
			<span class="caption-subject font-blue-steel uppercase">Opening Balance View</span>
		</div>
		
		<div class="actions">
			<?php echo $this->Html->link('Opening Balance','/ledgers/opening-balance/',array('escape'=>false,'class'=>'btn btn-default')); ?>
			<?php echo $this->Html->link('Opening Balance View','/ledgers/opening-balance-view/',array('escape'=>false,'class'=>'btn btn-primary')); ?>
			
		</div>
<?php $page_no=$this->Paginator->current('Ledgers'); $page_no=($page_no-1)*20; ?>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
			<form method="GET" >
			<table width="30%" >
				<tbody>
					<tr>
						<td><input type="text" name="ledger_name" class="form-control input-sm" placeholder="Ledger Account" value="<?php echo @$ledger_name; ?>"></td>
						<td><button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button></td>
					</tr>
				</tbody>
			</table>
			</form>
			</div>
		</div>
	
	<table class="table table-bordered ">
		<tbody>
				<tr>
				<td >Sr.No.</td>
				<td>Ledger Account</td>
				<td style="text-align:right;">Credit</td>
				<td style="text-align:right;">Debit</td>
				<td >Action</td>
				</tr>
		</tbody>
        <tbody>
            <?php  foreach($OpeningBalanceViews as $OpeningBalanceView): 
			if(!empty($OpeningBalanceView->ledger_account->alias)){
				
				$ledger_name=$OpeningBalanceView->ledger_account->name . ' (' . $OpeningBalanceView->ledger_account->alias . ')';
			}else{
				$ledger_name=$OpeningBalanceView->ledger_account['name']; 
			}
			?>
            <tr>  
			   <td><?= h(++$page_no) ?></td>
			   <td>
				<?php echo $ledger_name; ?>
			    </td>
				<td style="text-align:right;"><?= h($this->Number->format($OpeningBalanceView->credit,['places'=>2])) ?></td>
				<td style="text-align:right;"><?= h($this->Number->format($OpeningBalanceView->debit,['places'=>2])) ?></td>
				
				<td class="actions">
				<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>',['action' => 'edit', $OpeningBalanceView->id],array('escape'=>false,'class'=>'btn btn-xs blue tooltips','data-original-title'=>'Edit'));?>
				
				</td>
				
			</tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	</div>
    <div class="paginator">
        <form method="GET" >
       <table width="30%">
				<tbody>
					<tr>
						
						<td align="right"><label>Page Number</label></td>
						<td align="right" width="5%"> 
								<select class="form-control input-sm select2me" name='page'>
										<?= $this->Paginator->numbers(array('modulus'=>PHP_INT_MAX,'separator'=>'&nbsp;&nbsp;&nbsp;</b>|<b>&nbsp;&nbsp;&nbsp;')); ?>
									</select>
						</td>
						<td ><button type="submit" class="btn btn-primary btn-sm">Go</button>						
						
						</td>
						<td><p><?= $this->Paginator->counter() ?></p></td>
					</tr>
				</tbody>
			</table>
			</form>
    </div>
		
	</div>