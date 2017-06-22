<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PettyCashVoucher Entity
 *
 * @property int $id
 * @property int $voucher_no
 * @property int $bank_cash_id
 * @property int $created_by
 * @property \Cake\I18n\Time $created_on
 * @property string $payment_mode
 * @property int $company_id
 * @property \Cake\I18n\Time $transaction_date
 * @property int $edited_by
 * @property \Cake\I18n\Time $edited_on
 * @property string $cheque_no
 *
 * @property \App\Model\Entity\BankCash $bank_cash
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\PettyCashVoucherRow[] $petty_cash_voucher_rows
 */
class PettyCashVoucher extends Entity
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
