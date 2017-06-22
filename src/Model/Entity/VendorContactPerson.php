<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VendorContactPerson Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $mobile
 * @property bool $default_person
 * @property int $vendor_id
 *
 * @property \App\Model\Entity\Vendor $vendor
 */
class VendorContactPerson extends Entity
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
