<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Riv Entity
 *
 * @property int $id
 * @property int $sale_return_id
 * @property int $voucher_no
 * @property \Cake\I18n\Time $created_on
 *
 * @property \App\Model\Entity\SaleReturn $sale_return
 * @property \App\Model\Entity\LeftRiv[] $left_rivs
 */
class Riv extends Entity
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
