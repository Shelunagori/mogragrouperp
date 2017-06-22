<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MaterialIndent Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $job_card_id
 * @property \Cake\I18n\Time $required_date
 * @property \Cake\I18n\Time $created_on
 * @property int $created_by
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\JobCard $job_card
 * @property \App\Model\Entity\MaterialIndentRow[] $material_indent_rows
 */
class MaterialIndent extends Entity
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
