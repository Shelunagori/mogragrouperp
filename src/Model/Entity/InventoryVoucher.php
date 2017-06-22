<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventoryVoucher Entity
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $invoice_row_id
 * @property string $iv1
 * @property string $iv2
 * @property string $iv3
 * @property string $iv4
 *
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\InvoiceRow $invoice_row
 * @property \App\Model\Entity\InventoryVoucherRow[] $inventory_voucher_rows
 */
class InventoryVoucher extends Entity
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
