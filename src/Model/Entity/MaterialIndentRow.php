<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MaterialIndentRow Entity
 *
 * @property int $id
 * @property int $material_indent_id
 * @property int $item_id
 * @property int $quantity
 * @property int $approved_purchased_quantity
 *
 * @property \App\Model\Entity\MaterialIndent $material_indent
 * @property \App\Model\Entity\Item $item
 */
class MaterialIndentRow extends Entity
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
