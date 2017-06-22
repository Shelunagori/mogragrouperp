<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VouchersReferencesGroup Entity
 *
 * @property int $id
 * @property int $vouchers_reference_id
 * @property int $account_group_id
 *
 * @property \App\Model\Entity\VouchersReference $vouchers_reference
 * @property \App\Model\Entity\AccountGroup $account_group
 */
class VouchersReferencesGroup extends Entity
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
