<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Agenda Entity
 *
 * @property int $id
 * @property int|null $originagendaid
 * @property int|null $dailyid
 * @property \Cake\I18n\FrozenDate|null $dateevent
 * @property string|null $timestart
 * @property string|null $timeend
 * @property string|null $dayname
 * @property int|null $daynumber
 * @property string|null $monthnumber
 * @property string|null $monthname
 * @property int|null $weeknumber
 * @property int|null $year
 * @property string|null $agendatype
 * @property string|null $sectorname
 * @property string|null $unityorganization
 * @property string|null $eventdescription
 * @property string|null $placeofevent
 * @property string|null $departmentname
 * @property string|null $dayreference
 * @property int|null $rolevent_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $obs
 *
 * @property \App\Model\Entity\Rolevent $rolevent
 */
class Agenda extends Entity
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
        'originagendaid' => true,
        'dailyid' => true,
        'dateevent' => true,
        'timestart' => true,
        'timeend' => true,
        'dayname' => true,
        'daynumber' => true,
        'monthnumber' => true,
        'monthname' => true,
        'weeknumber' => true,
        'year' => true,
        'agendatype' => true,
        'sectorname' => true,
        'unityorganization' => true,
        'eventdescription' => true,
        'placeofevent' => true,
        'departmentname' => true,
        'dayreference' => true,
        'rolevent_id' => true,
        'created' => true,
        'modified' => true,
        'obs' => true,
        'rolevent' => true,
    ];
}
