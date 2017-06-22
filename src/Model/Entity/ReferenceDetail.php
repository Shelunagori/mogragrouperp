<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReferenceDetail Entity
 *
 * @property int $id
 * @property int $ledger_account_id
 * @property int $receipt_voucher_id
 * @property int $payment_voucher_id
 * @property int $invoice_id
 * @property string $reference_no
 * @property float $credit
 * @property float $debit
 * @property string $reference_type
 * @property int $invoice_booking_id
 * @property int $credit_note_id
 *
 * @property \App\Model\Entity\LedgerAccount $ledger_account
 * @property \App\Model\Entity\ReceiptVoucher $receipt_voucher
 * @property \App\Model\Entity\PaymentVoucher $payment_voucher
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\InvoiceBooking $invoice_booking
 * @property \App\Model\Entity\CreditNote $credit_note
 */
class ReferenceDetail extends Entity
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
