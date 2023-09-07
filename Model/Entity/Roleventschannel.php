<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Roleventschannel Entity
 *
 * @property int $id
 * @property int|null $rolevent_id
 * @property string|null $description
 * @property string|null $details
 * @property bool|null $activestatus
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Rolevent $rolevent
 */
class Roleventschannel extends Entity
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
        'rolevent_id' => true,
        'description' => true,
        'details' => true,
        'activestatus' => true,
        'created' => true,
        'modified' => true,
        'rolevent' => true,
    ];
}
