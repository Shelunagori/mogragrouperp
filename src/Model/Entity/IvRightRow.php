<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IvRightRow Entity
 *
 * @property int $id
 * @property int $iv_left_row_id
 * @property int $item_id
 * @property float $quantity
 *
 * @property \App\Model\Entity\IvLeftRow $iv_left_row
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\IvRightSerialNumber[] $iv_right_serial_numbers
 */
class IvRightRow extends Entity
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
