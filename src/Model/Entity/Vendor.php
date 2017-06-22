<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vendor Entity
 *
 * @property int $id
 * @property string $company_name
 * @property string $address
 * @property string $tin_no
 * @property string $gst_no
 * @property string $ecc_no
 * @property string $pan_no
 * @property int $payment_terms
 * @property string $mode_of_payment
 * @property int $item_group_id
 *
 * @property \App\Model\Entity\PurchaseOrder[] $purchase_orders
 */
class Vendor extends Entity
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
