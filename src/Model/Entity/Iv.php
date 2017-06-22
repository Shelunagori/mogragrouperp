<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Iv Entity
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $voucher_no
 * @property \Cake\I18n\Time $transaction_date
 * @property int $company_id
 *
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\IvLeftRow[] $iv_left_rows
 */
class Iv extends Entity
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
