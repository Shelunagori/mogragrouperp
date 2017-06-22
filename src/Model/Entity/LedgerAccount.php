<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LedgerAccount Entity
 *
 * @property int $id
 * @property int $account_second_subgroup_id
 * @property string $name
 * @property string $source_model
 * @property int $source_id
 *
 * @property \App\Model\Entity\AccountSecondSubgroup $account_second_subgroup
 * @property \App\Model\Entity\Source $source
 * @property \App\Model\Entity\Ledger[] $ledgers
 */
class LedgerAccount extends Entity
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
