<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * JournalVoucher Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $created_on
 * @property \Cake\I18n\Time $transaction_date
 * @property int $ledger1
 * @property string $payment_mode
 * @property int $ledger2
 * @property string $narration
 * @property float $amount
 * @property int $company_id
 * @property int $created_by
 *
 * @property \App\Model\Entity\Company $company
 */
class JournalVoucher extends Entity
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
