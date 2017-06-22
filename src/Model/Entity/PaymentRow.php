<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PaymentRow Entity
 *
 * @property int $id
 * @property int $receipt_id
 * @property int $received_from_id
 * @property float $amount
 * @property string $narration
 *
 * @property \App\Model\Entity\Receipt $receipt
 * @property \App\Model\Entity\ReceivedFrom $received_from
 */
class PaymentRow extends Entity
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
