<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerAddres Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property string $address
 * @property int $district_id
 * @property string $telephone
 * @property string $mobile
 * @property int $transporter_id
 * @property bool $default_address
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\District $district
 * @property \App\Model\Entity\Transporter $transporter
 */
class CustomerAddres extends Entity
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
