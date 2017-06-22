<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SaleReturnRow Entity
 *
 * @property int $id
 * @property int $sale_return_id
 * @property int $item_id
 * @property string $description
 * @property int $quantity
 * @property float $rate
 * @property float $amount
 * @property int $height
 * @property string $inventory_voucher_status
 * @property string $item_serial_number
 * @property string $inventory_voucher_applicable
 *
 * @property \App\Model\Entity\SaleReturn $sale_return
 * @property \App\Model\Entity\Item $item
 */
class SaleReturnRow extends Entity
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
