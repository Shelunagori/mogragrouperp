<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invoice Entity
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
 * @property int $sales_order_id
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\SalesOrder $sales_order
 * @property \App\Model\Entity\InvoiceRow[] $invoice_rows
 */
class Invoice extends Entity
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
