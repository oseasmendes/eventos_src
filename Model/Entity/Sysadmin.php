<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sysadmin Entity
 *
 * @property int $id
 * @property string|null $app
 * @property string|null $control
 * @property string|null $act
 * @property int|null $role_id
 * @property int|null $profile_id
 * @property int|null $value
 * @property bool|null $active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $reference
 * @property int|null $register
 * @property int|null $sysaction_id
 * @property int|null $syscontrol_id
 * @property int|null $sysapp_id
 * @property string|null $description
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Profile $profile
 * @property \App\Model\Entity\Sysaction $sysaction
 * @property \App\Model\Entity\Syscontrol $syscontrol
 * @property \App\Model\Entity\Sysapp $sysapp
 */
class Sysadmin extends Entity
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
        'app' => true,
        'control' => true,
        'act' => true,
        'role_id' => true,
        'profile_id' => true,
        'value' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'reference' => true,
        'register' => true,
        'sysaction_id' => true,
        'syscontrol_id' => true,
        'sysapp_id' => true,
        'description' => true,
        'role' => true,
        'profile' => true,
        'sysaction' => true,
        'syscontrol' => true,
        'sysapp' => true,
    ];
}
