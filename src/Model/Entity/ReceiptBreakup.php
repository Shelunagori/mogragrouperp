<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReceiptBreakup Entity
 *
 * @property int $id
 * @property string $type
 * @property string $new_ref_no
 * @property int $receipt_voucher_id
 * @property int $invoice_id
 * @property float $amount
 *
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\ReceiptVoucher $receipt_voucher
 */
class ReceiptBreakup extends Entity
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
