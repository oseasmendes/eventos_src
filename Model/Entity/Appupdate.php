<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Appupdate Entity
 *
 * @property int $id
 * @property string|null $doc
 * @property string|null $module
 * @property string|null $description
 * @property string|null $technicaldescription
 * @property bool|null $prd
 * @property \Cake\I18n\FrozenDate|null $prddate
 * @property bool|null $tst
 * @property \Cake\I18n\FrozenDate|null $tstdate
 * @property bool|null $dev
 * @property \Cake\I18n\FrozenDate|null $devdate
 * @property int|null $linereference
 * @property int|null $linereferenceuntil
 * @property string|null $status
 * @property string|null $valor
 * @property string|null $changetype
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class Appupdate extends Entity
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
        'doc' => true,
        'module' => true,
        'description' => true,
        'technicaldescription' => true,
        'prd' => true,
        'prddate' => true,
        'tst' => true,
        'tstdate' => true,
        'dev' => true,
        'devdate' => true,
        'linereference' => true,
        'linereferenceuntil' => true,
        'status' => true,
        'valor' => true,
        'ordem' => true,
        'changetype' => true,
        'created' => true,
        'modified' => true,
    ];
}
