<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Condition Entity
 *
 * @property int $id
 * @property int|null $originid
 * @property string|null $description
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $seq
 *
 * @property \App\Model\Entity\People[] $peoples
 */
class Condition extends Entity
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
        'originid' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'seq' => true,
        'peoples' => true,
    ];
}
