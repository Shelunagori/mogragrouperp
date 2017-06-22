<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property string $name
 * @property int $item_category_id
 * @property int $item_group_id
 * @property int $item_sub_group_id
 * @property int $unit_id
 * @property int $quantity
 * @property int $rate
 * @property int $item_unit
 * @property int $value
 * @property int $freeze
 * @property int $serial_number_enable
 * @property string $source
 * @property int $minimum_quantity
 * @property int $maximum_quantity
 * @property int $flag
 *
 * @property \App\Model\Entity\ItemCategory $item_category
 * @property \App\Model\Entity\ItemGroup $item_group
 * @property \App\Model\Entity\ItemSubGroup $item_sub_group
 * @property \App\Model\Entity\Unit $unit
 * @property \App\Model\Entity\ItemUsedByCompany[] $item_used_by_companies
 */
class Item extends Entity
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
