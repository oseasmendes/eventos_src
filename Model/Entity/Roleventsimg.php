<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Roleventsimg Entity
 *
 * @property int $id
 * @property string|null $description
 * @property int|null $rolevents_id
 * @property string|null $filepath
 * @property string|null $filename
 * @property string|null $filenameoriginal
 * @property bool|null $activeflag
 * @property bool|null $fileselection
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $docsystemtype
 *
 * @property \App\Model\Entity\Rolevent $rolevent
 */
class Roleventsimg extends Entity
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
        'description' => true,
        'rolevent_id' => true,
        'filepath' => true,
        'filename' => true,
        'filenameoriginal' => true,
        'activeflag' => true,
        'fileselection' => true,
        'created' => true,
        'modified' => true,
        'docsystemtype' => true,
        'rolevent' => true,
    ];
}
