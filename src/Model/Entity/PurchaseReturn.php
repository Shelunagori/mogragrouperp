<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseReturn Entity
 *
 * @property int $id
 * @property int $invoice_booking_id
 * @property \Cake\I18n\Time $created_on
 * @property int $company_id
 * @property int $created_by
 * @property int $voucher_no
 *
 * @property \App\Model\Entity\InvoiceBooking $invoice_booking
 * @property \App\Model\Entity\Company $company
 */
class PurchaseReturn extends Entity
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
