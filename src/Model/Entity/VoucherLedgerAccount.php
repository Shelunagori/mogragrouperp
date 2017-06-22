<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VoucherLedgerAccount Entity
 *
 * @property int $vouchers_reference_id
 * @property int $ledger_account_id
 *
 * @property \App\Model\Entity\VouchersReference $vouchers_reference
 * @property \App\Model\Entity\LedgerAccount $ledger_account
 */
class VoucherLedgerAccount extends Entity
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
        'vouchers_reference_id' => false,
        'ledger_account_id' => false
    ];
}
