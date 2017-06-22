<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IvLeftRow Entity
 *
 * @property int $id
 * @property int $iv_id
 * @property int $invoice_row_id
 *
 * @property \App\Model\Entity\Iv $iv
 * @property \App\Model\Entity\InvoiceRow $invoice_row
 * @property \App\Model\Entity\IvLeftSerialNumber[] $iv_left_serial_numbers
 * @property \App\Model\Entity\IvRightRow[] $iv_right_rows
 */
class IvLeftRow extends Entity
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
