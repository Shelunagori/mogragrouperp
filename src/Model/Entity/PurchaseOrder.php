<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseOrder Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $vendor_id
 * @property string $shipping_method
 * @property int $shipping_terms
 * @property \Cake\I18n\Time $delivery_date
 * @property float $total
 * @property string $terms_conditions
 * @property string $po1
 * @property string $po3
 * @property string $po4
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Vendor $vendor
 * @property \App\Model\Entity\Grn[] $grns
 * @property \App\Model\Entity\PurchaseOrderRow[] $purchase_order_rows
 */
class PurchaseOrder extends Entity
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
