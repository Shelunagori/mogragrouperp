<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * JournalVoucherRow Entity
 *
 * @property int $id
 * @property int $journal_voucher_id
 * @property int $ledger_account_id
 * @property int $cr_dr
 * @property int $amount
 *
 * @property \App\Model\Entity\JournalVoucher $journal_voucher
 * @property \App\Model\Entity\LedgerAccount $ledger_account
 */
class JournalVoucherRow extends Entity
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
