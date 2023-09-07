<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bussinessunit Entity
 *
 * @property int $id
 * @property int|null $oringid
 * @property string|null $description
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $seq
 * @property int|null $org_id
 * @property string|null $address
 * @property string|null $postalcode
 * @property string|null $district
 * @property string|null $city
 * @property string|null $phone
 * @property string|null $responsible
 * @property string|null $sector
 * @property string|null $email
 * @property bool|null $active
 * @property bool|null $general
 *
 * @property \App\Model\Entity\Org $org
 * @property \App\Model\Entity\People[] $peoples
 */
class Bussinessunit extends Entity
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
        'oringid' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'seq' => true,
        'org_id' => true,
        'address' => true,
        'postalcode' => true,
        'district' => true,
        'city' => true,
        'phone' => true,
        'responsible' => true,
        'sector' => true,
        'email' => true,
        'active' => true,
        'general' => true,
        'org' => true,
        'peoples' => true,
        'rolevent' => true,
    ];
}
