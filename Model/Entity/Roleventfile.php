<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Roleventfile Entity
 *
 * @property int $id
 * @property string|null $filename
 * @property int|null $rolevent_id
 * @property string|null $path
 * @property string|null $originalfilename
 * @property string|null $midiatype
 * @property bool|null $activeflag
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Rolevent $rolevent
 */
class Roleventfile extends Entity
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
        'filename' => true,
        'rolevent_id' => true,
        'path' => true,
        'originalfilename' => true,
        'midiatype' => true,
        'activeflag' => true,
        'created' => true,
        'modified' => true,
        'rolevent' => true,
    ];
}
