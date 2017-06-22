<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IvLeftSerialNumber Entity
 *
 * @property int $id
 * @property int $iv_left_row_id
 * @property string $sr_number
 *
 * @property \App\Model\Entity\IvLeftRow $iv_left_row
 */
class IvLeftSerialNumber extends Entity
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
