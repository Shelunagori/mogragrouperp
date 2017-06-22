<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * JobCard Entity
 *
 * @property int $id
 * @property int $sales_order_id
 * @property int $company_id
 * @property int $created_by
 * @property \Cake\I18n\Time $created_on
 *
 * @property \App\Model\Entity\SalesOrder $sales_order
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\JobCardRow[] $job_card_rows
 */
class JobCard extends Entity
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
