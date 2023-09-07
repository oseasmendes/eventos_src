<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Breakingnews Entity
 *
 * @property int $id
 * @property string|null $description
 * @property string|null $details
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool|null $activeflag
 * @property \Cake\I18n\FrozenDate|null $expirationdate
 */
class Breakingnews extends Entity
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
        'details' => true,
        'created' => true,
        'modified' => true,
        'activeflag' => true,
        'rolevent' => true,
        'expirationdate' => true,
        'rolevent' => true,
    ];
}
