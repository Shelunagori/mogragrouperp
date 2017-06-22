<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventoryTransferVoucher Entity
 *
 * @property int $id
 * @property int $voucher_no
 * @property int $company_id
 * @property int $created_by
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\InventoryTransferVoucherRow[] $inventory_transfer_voucher_rows
 */
class InventoryTransferVoucher extends Entity
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
