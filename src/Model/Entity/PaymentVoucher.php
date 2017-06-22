<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PaymentVoucher Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $created_on
 * @property \Cake\I18n\Time $voucher_date
 * @property int $paid_to
 * @property string $payment_mode
 * @property int $cash_bank_account
 * @property string $narration
 */
class PaymentVoucher extends Entity
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
