<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerContact Entity
 *
 * @property int $id
 * @property string $contact_person
 * @property int $customer_id
 * @property string $designation
 * @property string $telephone
 * @property string $email
 * @property int $mobile
 * @property bool $default_contact
 *
 * @property \App\Model\Entity\Customer $customer
 */
class CustomerContact extends Entity
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
