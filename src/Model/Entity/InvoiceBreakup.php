<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InvoiceBreakup Entity
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $receipt_id
 * @property int $amount
 *
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\Receipt $receipt
 */
class InvoiceBreakup extends Entity
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
