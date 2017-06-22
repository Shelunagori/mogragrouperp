<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DebitNotesRow Entity
 *
 * @property int $id
 * @property int $debit_note_id
 * @property int $head_id
 * @property float $amount
 * @property string $narration
 *
 * @property \App\Model\Entity\DebitNote $debit_note
 * @property \App\Model\Entity\Head $head
 */
class DebitNotesRow extends Entity
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
