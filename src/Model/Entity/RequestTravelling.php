<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RequestTravelling Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property string $destination
 * @property string $reason
 * @property \Cake\I18n\Time $request_from
 * @property \Cake\I18n\Time $request_to
 * @property \Cake\I18n\Time $request_date
 * @property string $status
 * @property float $total_ammount
 * @property float $approved_ammount
 * @property int $company_id
 *
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\Company $company
 */
class RequestTravelling extends Entity
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
