<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Quotation Entity
 *
 * @property int $id
 * @property string $ref_no
 * @property int $customer_id
 * @property string $customer_address
 * @property string $salesman
 * @property string $product
 * @property \Cake\I18n\Time $finalisation_date
 * @property string $customer_for_attention
 * @property string $customer_contact
 * @property int $enquiry_no
 * @property string $subject
 * @property string $text
 * @property string $terms_conditions
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\QuotationRow[] $quotation_rows
 */
class Quotation extends Entity
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
