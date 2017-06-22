<?php  ?>
<h4>Due Invoices of <?= h($Customer->customer_name) ?></h4>
<table class="table table-hover" id="due_receipt">
	<thead>
		<tr>
			<th></th>
			<th>#</th>
			<th>Invoice</th>
			<th style="text-align: right;">Due Amount</th>
			<th style="text-align: right;">Amount</th>
		</tr>
	</thead>
	<tbody>
	<?php $i=0; foreach($Invoices as $Invoice){ ?>
		<tr class="tr1">
			<td><input type="checkbox" value="<?= h($Invoice->id) ?>" class="check_row" name="invoice_record[<?php echo $i; ?>][checkbox]" /></td>
			<td><?php echo ++$i; $i--;  ?></td>
			<td><?= h(($Invoice->in1.'/IN-'.str_pad($Invoice->in2, 3, '0', STR_PAD_LEFT).'/'.$Invoice->in3.'/	'.$Invoice->in4)) ?></td>
			<td align="right" >
				<?php echo $this->Number->format($Invoice->due_payment,[ 'places' => 2]); ?>
				<input type="hidden" name="invoice_record[<?php echo $i; ?>][invoice_id]" value='<?php echo $Invoice->id; ?>' />
			</td>
			<td align="right" width="120">
				<input type="text" name="invoice_record[<?php echo $i; ?>][invoice_amount]" class="form-control input-sm amount_box" placeholder="Amount" max="<?php echo $Invoice->due_payment; ?>" readonly="readonly" invoice_amount="<?php echo $Invoice->due_payment; ?>" />
			</td>
		</tr>
	<?php $i++; } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">Advance</td>
			<td><?php echo $this->Form->input('advance', ['type' => 'text','label' => false,'class' => 'form-control input-sm','placeholder' => 'Advance','readonly' => 'readonly' ]); ?></td>
			<td align="right" ></td>
			<td><input type="text" name="total_amount_agst" class="form-control input-sm" readonly="readonly" placeholder="Total" value="0.00"/></td>
		</tr>
	</tfoot>
</table>