<?php  ?>
<h4>Due Invoices of <?= h($Vendor->company_name) ?></h4>
<table class="table table-hover" id="due_payment">
	<thead>
		<tr>
			<th></th>
			<th>#</th>
			<th>Invoice Booking</th>
			<th style="text-align: right;">Due Amount</th>
			<th style="text-align: right;">Amount</th>
		</tr>
	</thead>
	<tbody>
	<?php $i=0; foreach($InvoiceBookings as $InvoiceBooking){ ?>
		<tr class="tr1">
			<td><input type="checkbox" value="<?= h($InvoiceBooking->id) ?>" class="check_row" name="invoice_booking_record[<?php echo $i; ?>][checkbox]" /></td>
			<td><?php echo ++$i; $i--;  ?></td>
			<td><?= h(($InvoiceBooking->ib1.'/IN-'.str_pad($InvoiceBooking->ib2, 3, '0', STR_PAD_LEFT).'/'.$InvoiceBooking->ib3.'/	'.$InvoiceBooking->ib4)) ?></td>
			<td align="right" >
				<?php echo $this->Number->format($InvoiceBooking->due_payment,[ 'places' => 2]); ?>
				<input type="hidden" name="invoice_booking_record[<?php echo $i; ?>][invoice_booking_id]" value='<?php echo $InvoiceBooking->id; ?>' />
			</td>
			<td align="right" width="120">
				<input type="text" name="invoice_booking_record[<?php echo $i; ?>][invoice_booking_amount]" class="form-control input-sm amount_box" placeholder="Amount" max="<?php echo $InvoiceBooking->due_payment; ?>" readonly="readonly" invoice_booking_amount="<?php echo $InvoiceBooking->due_payment; ?>" />
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