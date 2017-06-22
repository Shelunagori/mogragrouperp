<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Grn Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $date_created
 * @property int $purchase_order_id
 * @property int $company_id
 * @property string $grn1
 * @property string $grn3
 * @property string $grn4
 * @property \Cake\I18n\Time $created_by
 *
 * @property \App\Model\Entity\PurchaseOrder $purchase_order
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\GrnRow[] $grn_rows
 * @property \App\Model\Entity\InvoiceBooking[] $invoice_bookings
 */
class Grn extends Entity
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
