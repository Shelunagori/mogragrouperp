<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challan Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int $company_id
 * @property int $invoice_id
 * @property \Cake\I18n\Time $date
 * @property int $transporter_id
 * @property int $lr_no
 * @property string $reference_detail
 * @property float $total
 * @property string $documents
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\Transporter $transporter
 */
class Challan extends Entity
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
