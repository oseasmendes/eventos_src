<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Org Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $address
 * @property string|null $district
 * @property string|null $zipcode
 * @property string|null $city
 * @property string|null $contactfone
 * @property string|null $email
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modifed
 *
 * @property \App\Model\Entity\Bussinessunit[] $bussinessunits
 */
class Org extends Entity
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
        'name' => true,
        'address' => true,
        'district' => true,
        'zipcode' => true,
        'city' => true,
        'contactfone' => true,
        'email' => true,
        'created' => true,
        'modifed' => true,       
        'bussinessunits' => true,
    ];
}
