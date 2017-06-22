<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sale Return'), ['action' => 'edit', $saleReturn->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sale Return'), ['action' => 'delete', $saleReturn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturn->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sale Returns'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Taxes'), ['controller' => 'SaleTaxes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Tax'), ['controller' => 'SaleTaxes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sales Orders'), ['controller' => 'SalesOrders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sales Order'), ['controller' => 'SalesOrders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Transporters'), ['controller' => 'Transporters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Transporter'), ['controller' => 'Transporters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sale Return Rows'), ['controller' => 'SaleReturnRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale Return Row'), ['controller' => 'SaleReturnRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="saleReturns view large-9 medium-8 columns content">
    <h3><?= h($saleReturn->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Customer') ?></th>
            <td><?= $saleReturn->has('customer') ? $this->Html->link($saleReturn->customer->customer_name, ['controller' => 'Customers', 'action' => 'view', $saleReturn->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Lr No') ?></th>
            <td><?= h($saleReturn->lr_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Sale Tax') ?></th>
            <td><?= $saleReturn->has('sale_tax') ? $this->Html->link($saleReturn->sale_tax->tax_figure, ['controller' => 'SaleTaxes', 'action' => 'view', $saleReturn->sale_tax->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Ed Description') ?></th>
            <td><?= h($saleReturn->ed_description) ?></td>
        </tr>
        <tr>
            <th><?= __('Fright Text') ?></th>
            <td><?= h($saleReturn->fright_text) ?></td>
        </tr>
        <tr>
            <th><?= __('Company') ?></th>
            <td><?= $saleReturn->has('company') ? $this->Html->link($saleReturn->company->name, ['controller' => 'Companies', 'action' => 'view', $saleReturn->company->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Process Status') ?></th>
            <td><?= h($saleReturn->process_status) ?></td>
        </tr>
        <tr>
            <th><?= __('Sales Order') ?></th>
            <td><?= $saleReturn->has('sales_order') ? $this->Html->link($saleReturn->sales_order->id, ['controller' => 'SalesOrders', 'action' => 'view', $saleReturn->sales_order->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('In1') ?></th>
            <td><?= h($saleReturn->in1) ?></td>
        </tr>
        <tr>
            <th><?= __('In4') ?></th>
            <td><?= h($saleReturn->in4) ?></td>
        </tr>
        <tr>
            <th><?= __('In3') ?></th>
            <td><?= h($saleReturn->in3) ?></td>
        </tr>
        <tr>
            <th><?= __('Customer Po No') ?></th>
            <td><?= h($saleReturn->customer_po_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Additional Note') ?></th>
            <td><?= h($saleReturn->additional_note) ?></td>
        </tr>
        <tr>
            <th><?= __('Employee') ?></th>
            <td><?= $saleReturn->has('employee') ? $this->Html->link($saleReturn->employee->name, ['controller' => 'Employees', 'action' => 'view', $saleReturn->employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Transporter') ?></th>
            <td><?= $saleReturn->has('transporter') ? $this->Html->link($saleReturn->transporter->transporter_name, ['controller' => 'Transporters', 'action' => 'view', $saleReturn->transporter->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Form47') ?></th>
            <td><?= h($saleReturn->form47) ?></td>
        </tr>
        <tr>
            <th><?= __('Form49') ?></th>
            <td><?= h($saleReturn->form49) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($saleReturn->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Inventory Voucher Status') ?></th>
            <td><?= h($saleReturn->inventory_voucher_status) ?></td>
        </tr>
        <tr>
            <th><?= __('Payment Mode') ?></th>
            <td><?= h($saleReturn->payment_mode) ?></td>
        </tr>
        <tr>
            <th><?= __('Pdf Font Size') ?></th>
            <td><?= h($saleReturn->pdf_font_size) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($saleReturn->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Temp Limit') ?></th>
            <td><?= $this->Number->format($saleReturn->temp_limit) ?></td>
        </tr>
        <tr>
            <th><?= __('Total') ?></th>
            <td><?= $this->Number->format($saleReturn->total) ?></td>
        </tr>
        <tr>
            <th><?= __('Pnf') ?></th>
            <td><?= $this->Number->format($saleReturn->pnf) ?></td>
        </tr>
        <tr>
            <th><?= __('Pnf Per') ?></th>
            <td><?= $this->Number->format($saleReturn->pnf_per) ?></td>
        </tr>
        <tr>
            <th><?= __('Total After Pnf') ?></th>
            <td><?= $this->Number->format($saleReturn->total_after_pnf) ?></td>
        </tr>
        <tr>
            <th><?= __('Sale Tax Per') ?></th>
            <td><?= $this->Number->format($saleReturn->sale_tax_per) ?></td>
        </tr>
        <tr>
            <th><?= __('Sale Tax Amount') ?></th>
            <td><?= $this->Number->format($saleReturn->sale_tax_amount) ?></td>
        </tr>
        <tr>
            <th><?= __('Exceise Duty') ?></th>
            <td><?= $this->Number->format($saleReturn->exceise_duty) ?></td>
        </tr>
        <tr>
            <th><?= __('Fright Amount') ?></th>
            <td><?= $this->Number->format($saleReturn->fright_amount) ?></td>
        </tr>
        <tr>
            <th><?= __('Grand Total') ?></th>
            <td><?= $this->Number->format($saleReturn->grand_total) ?></td>
        </tr>
        <tr>
            <th><?= __('Due Payment') ?></th>
            <td><?= $this->Number->format($saleReturn->due_payment) ?></td>
        </tr>
        <tr>
            <th><?= __('In2') ?></th>
            <td><?= $this->Number->format($saleReturn->in2) ?></td>
        </tr>
        <tr>
            <th><?= __('Created By') ?></th>
            <td><?= $this->Number->format($saleReturn->created_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Discount Per') ?></th>
            <td><?= $this->Number->format($saleReturn->discount_per) ?></td>
        </tr>
        <tr>
            <th><?= __('Discount') ?></th>
            <td><?= $this->Number->format($saleReturn->discount) ?></td>
        </tr>
        <tr>
            <th><?= __('Fright Ledger Account') ?></th>
            <td><?= $this->Number->format($saleReturn->fright_ledger_account) ?></td>
        </tr>
        <tr>
            <th><?= __('Sales Ledger Account') ?></th>
            <td><?= $this->Number->format($saleReturn->sales_ledger_account) ?></td>
        </tr>
        <tr>
            <th><?= __('St Ledger Account Id') ?></th>
            <td><?= $this->Number->format($saleReturn->st_ledger_account_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Created') ?></th>
            <td><?= h($saleReturn->date_created) ?></td>
        </tr>
        <tr>
            <th><?= __('Po Date') ?></th>
            <td><?= h($saleReturn->po_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Discount Type') ?></th>
            <td><?= $saleReturn->discount_type ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Pnf Type') ?></th>
            <td><?= $saleReturn->pnf_type ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Customer Address') ?></h4>
        <?= $this->Text->autoParagraph(h($saleReturn->customer_address)); ?>
    </div>
    <div class="row">
        <h4><?= __('Terms Conditions') ?></h4>
        <?= $this->Text->autoParagraph(h($saleReturn->terms_conditions)); ?>
    </div>
    <div class="row">
        <h4><?= __('Delivery Description') ?></h4>
        <?= $this->Text->autoParagraph(h($saleReturn->delivery_description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sale Return Rows') ?></h4>
        <?php if (!empty($saleReturn->sale_return_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Sale Return Id') ?></th>
                <th><?= __('Item Id') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Rate') ?></th>
                <th><?= __('Amount') ?></th>
                <th><?= __('Height') ?></th>
                <th><?= __('Inventory Voucher Status') ?></th>
                <th><?= __('Item Serial Number') ?></th>
                <th><?= __('Inventory Voucher Applicable') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($saleReturn->sale_return_rows as $saleReturnRows): ?>
            <tr>
                <td><?= h($saleReturnRows->id) ?></td>
                <td><?= h($saleReturnRows->sale_return_id) ?></td>
                <td><?= h($saleReturnRows->item_id) ?></td>
                <td><?= h($saleReturnRows->description) ?></td>
                <td><?= h($saleReturnRows->quantity) ?></td>
                <td><?= h($saleReturnRows->rate) ?></td>
                <td><?= h($saleReturnRows->amount) ?></td>
                <td><?= h($saleReturnRows->height) ?></td>
                <td><?= h($saleReturnRows->inventory_voucher_status) ?></td>
                <td><?= h($saleReturnRows->item_serial_number) ?></td>
                <td><?= h($saleReturnRows->inventory_voucher_applicable) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SaleReturnRows', 'action' => 'view', $saleReturnRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SaleReturnRows', 'action' => 'edit', $saleReturnRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SaleReturnRows', 'action' => 'delete', $saleReturnRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleReturnRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
