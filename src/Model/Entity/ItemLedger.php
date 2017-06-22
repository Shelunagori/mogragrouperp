<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemLedger Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $quantity
 * @property float $rate
 * @property string $source_model
 * @property int $source_id
 * @property string $in_out
 * @property \Cake\I18n\Time $processed_on
 * @property int $company_id
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Source $source
 * @property \App\Model\Entity\Company $company
 */
class ItemLedger extends Entity
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
