<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string $customer_name
 * @property int $district_id
 * @property int $company_group_id
 * @property int $customer_seg_id
 * @property string $tin_no
 * @property string $gst_no
 * @property string $pan_no
 * @property string $ecc_no
 * @property int $flag
 *
 * @property \App\Model\Entity\District $district
 * @property \App\Model\Entity\CompanyGroup $company_group
 * @property \App\Model\Entity\CustomerSeg $customer_seg
 * @property \App\Model\Entity\CustomerContact[] $customer_contacts
 * @property \App\Model\Entity\Quotation[] $quotations
 */
class Customer extends Entity
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
        'id' => true
    ];
}
