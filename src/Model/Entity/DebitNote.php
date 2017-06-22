<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DebitNote Entity
 *
 * @property int $id
 * @property string $voucher_no
 * @property \Cake\I18n\Time $created_on
 * @property \Cake\I18n\Time $transaction_date
 * @property int $customer_suppiler_id
 * @property int $company_id
 * @property int $created_by
 * @property int $edited_by
 * @property \Cake\I18n\Time $edited_on
 * @property string $subject
 *
 * @property \App\Model\Entity\CustomerSuppiler $customer_suppiler
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\DebitNotesRow[] $debit_notes_rows
 */
class DebitNote extends Entity
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
