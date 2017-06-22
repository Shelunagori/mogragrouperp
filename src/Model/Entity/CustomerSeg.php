<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerSeg Entity
 *
 * @property int $id
 * @property string $name
 * @property string $segment_description1
 * @property string $segment_description2
 * @property int $flag
 *
 * @property \App\Model\Entity\Customer[] $customers
 */
class CustomerSeg extends Entity
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
