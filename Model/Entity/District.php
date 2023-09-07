<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * District Entity
 *
 * @property int $id
 * @property string|null $description
 * @property int|null $originid
 * @property int|null $citie_id
 * @property int|null $seq
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\People[] $peoples
 */
class District extends Entity
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
        'originid' => true,
        'citie_id' => true,
        'seq' => true,
        'created' => true,
        'modified' => true,
        'city' => true,
        'peoples' => true,
    ];
}
