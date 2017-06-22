<div class="modal-body">
	<div class="list-group">
		<span style=" font-size: 16px; "><?= h($customer->customer_name) ?></span><br/>
		<?php foreach ($customer->customer_address as $address): ?>
		<a href="#" class="list-group-item insert_address" role="button"><span><?= h($address->address) ?></span></a>
		<?php endforeach; ?>
	</div>
</div>

