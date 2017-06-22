<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RequestLeave Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property int $leave_type_id
 * @property \Cake\I18n\Time $leave_from
 * @property \Cake\I18n\Time $leave_to
 * @property int $no_of_days
 * @property string $reason
 * @property int $request_date
 * @property string $leave_status
 * @property string $remarks
 * @property string $half_day
 * @property int $company_id
 *
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\LeaveType $leave_type
 * @property \App\Model\Entity\Company $company
 */
class RequestLeave extends Entity
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
