<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SalesOrder Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property string $customer_address
 * @property string $subject
 * @property string $text
 * @property string $terms_conditions
 * @property float $total
 * @property \Cake\I18n\Time $date
 * @property int $company_id
 * @property string $process_status
 * @property int $quotation_id
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Quotation $quotation
 * @property \App\Model\Entity\SalesOrderRow[] $sales_order_rows
 */
class SalesOrder extends Entity
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
