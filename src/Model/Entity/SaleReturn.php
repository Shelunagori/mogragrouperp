<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SaleReturn Entity
 *
 * @property int $id
 * @property float $temp_limit
 * @property int $customer_id
 * @property string $customer_address
 * @property string $lr_no
 * @property string $terms_conditions
 * @property bool $discount_type
 * @property float $total
 * @property float $pnf
 * @property bool $pnf_type
 * @property float $pnf_per
 * @property float $total_after_pnf
 * @property float $sale_tax_per
 * @property int $sale_tax_id
 * @property float $sale_tax_amount
 * @property float $exceise_duty
 * @property string $ed_description
 * @property float $fright_amount
 * @property string $fright_text
 * @property float $grand_total
 * @property float $due_payment
 * @property \Cake\I18n\Time $date_created
 * @property int $company_id
 * @property string $process_status
 * @property int $sales_order_id
 * @property string $in1
 * @property int $in2
 * @property string $in4
 * @property string $in3
 * @property string $customer_po_no
 * @property \Cake\I18n\Time $po_date
 * @property string $additional_note
 * @property int $employee_id
 * @property int $created_by
 * @property int $transporter_id
 * @property float $discount_per
 * @property float $discount
 * @property string $form47
 * @property string $form49
 * @property string $status
 * @property string $inventory_voucher_status
 * @property string $payment_mode
 * @property int $fright_ledger_account
 * @property int $sales_ledger_account
 * @property int $st_ledger_account_id
 * @property string $pdf_font_size
 * @property string $delivery_description
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\SaleTax $sale_tax
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\SalesOrder $sales_order
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\Transporter $transporter
 * @property \App\Model\Entity\StLedgerAccount $st_ledger_account
 * @property \App\Model\Entity\SaleReturnRow[] $sale_return_rows
 */
class SaleReturn extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
